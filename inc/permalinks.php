<?php
/**
 * Bỏ tiền tố /category/ khỏi URL chuyên mục (việc #28 trong bảng kế hoạch).
 *
 * /category/huong-nghiep/  →  /huong-nghiep/
 *
 * VÌ SAO KHÔNG chỉ đổi option 'category_base': để rỗng thì WordPress tự nhét
 * lại 'category'; đặt '.' hay '/' làm hỏng rewrite của trang con. Cách chắc
 * chắn là tự thêm rewrite rule cho từng slug + sửa link + 301 URL cũ.
 *
 * ⚠️ VA CHẠM SLUG: nếu một Page và một chuyên mục trùng slug (site này có CẢ
 * Page 'tin-tuc' LẪN chuyên mục 'tin-tuc') thì /tin-tuc/ chỉ trỏ được về MỘT
 * trong hai. WordPress cho Page thắng, nên chuyên mục sẽ không bao giờ mở
 * được. Vì vậy ecsges_cat_flat_slugs() CỐ Ý BỎ QUA mọi chuyên mục trùng slug
 * với Page — những chuyên mục đó giữ nguyên /category/... Muốn chúng cũng
 * phẳng thì phải đổi slug của Page hoặc của chuyên mục trong admin.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slug các chuyên mục ĐƯỢC bỏ tiền tố (đã loại slug trùng với Page).
 *
 * Cache trong option để không phải truy vấn terms + pages ở MỌI request chỉ để
 * dựng rewrite rule. Xoá cache khi thêm/sửa/xoá chuyên mục hoặc Page (xem các
 * hook ở cuối file).
 *
 * @return string[]
 */
function ecsges_cat_flat_slugs() {
	$cached = get_transient( 'ecsges_cat_flat_slugs' );
	if ( is_array( $cached ) ) {
		return $cached;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
			'fields'     => 'slugs',
		)
	);
	if ( is_wp_error( $terms ) ) {
		return array();
	}

	$out = array();
	foreach ( $terms as $slug ) {
		// get_page_by_path() tra theo ĐƯỜNG DẪN nên chỉ khớp Page cấp 1 — đúng
		// thứ ta cần, vì /{slug}/ cũng là đường dẫn cấp 1.
		$page = get_page_by_path( $slug );
		if ( $page && 'publish' === get_post_status( $page ) ) {
			continue; // trùng Page → giữ /category/
		}
		// Cũng phải né bài viết / hồ sơ tác giả trùng slug: rule của ta nằm ở
		// 'top' nên sẽ che mất chúng (xem ghi chú trong ecsges_cat_add_rewrites).
		$clash = get_posts(
			array(
				'name'        => $slug,
				'post_type'   => array( 'post', ECSGES_TG_TYPE ),
				'post_status' => 'publish',
				'numberposts' => 1,
				'fields'      => 'ids',
			)
		);
		if ( ! empty( $clash ) ) {
			continue;
		}
		$out[] = $slug;
	}

	set_transient( 'ecsges_cat_flat_slugs', $out, DAY_IN_SECONDS );
	return $out;
}

/**
 * Thêm rewrite rule /{slug}/ (và /{slug}/page/2/) cho từng chuyên mục phẳng.
 *
 * PHẢI là 'top', KHÔNG ĐƯỢC 'bottom': WordPress có sẵn một rule vét
 * `(.?.+?)/?$ → index.php?pagename=$matches[1]` nằm gần cuối bảng. Rule thêm ở
 * 'bottom' đứng SAU nó, nên /huong-nghiep/ bị hiểu thành tên Page, không tìm
 * thấy Page nào và trả 404 (đã đo đúng như vậy).
 *
 * Đặt 'top' an toàn vì ecsges_cat_flat_slugs() đã loại mọi slug trùng với Page,
 * bài viết hay hồ sơ tác giả — không có gì để che.
 *
 * @return void
 */
function ecsges_cat_add_rewrites() {
	foreach ( ecsges_cat_flat_slugs() as $slug ) {
		$q = 'index.php?category_name=' . $slug;
		add_rewrite_rule( '^' . $slug . '/?$', $q, 'top' );
		add_rewrite_rule( '^' . $slug . '/page/([0-9]{1,})/?$', $q . '&paged=$matches[1]', 'top' );
		add_rewrite_rule( '^' . $slug . '/feed/?$', $q . '&feed=feed', 'top' );
	}
}
add_action( 'init', 'ecsges_cat_add_rewrites', 15 );

/**
 * Bỏ /category/ khỏi link chuyên mục do WordPress sinh ra.
 *
 * @param string $link
 * @param int    $term_id
 * @return string
 */
function ecsges_cat_clean_link( $link, $term_id ) {
	$term = get_term( $term_id, 'category' );
	if ( ! $term || is_wp_error( $term ) ) {
		return $link;
	}
	if ( ! in_array( $term->slug, ecsges_cat_flat_slugs(), true ) ) {
		return $link;
	}
	// Chỉ cắt ĐÚNG đoạn '/category/' trong đường dẫn, không dựng lại URL bằng
	// home_url(): site chạy Polylang nên URL có thể mang tiền tố ngôn ngữ
	// (/en/category/...), dựng lại sẽ đánh mất tiền tố đó.
	return preg_replace( '#/category/#', '/', $link, 1 );
}
add_filter( 'category_link', 'ecsges_cat_clean_link', 10, 2 );

/**
 * 301 URL cũ /category/{slug}/ về /{slug}/.
 *
 * Bắt buộc có: link cũ đã nằm trong index của Google và trong bài viết cũ. Bỏ
 * qua khi slug không thuộc danh sách phẳng (những chuyên mục đó vẫn dùng URL có
 * tiền tố, chuyển hướng sẽ thành vòng lặp).
 *
 * @return void
 */
function ecsges_cat_redirect_old() {
	if ( is_admin() || ! is_category() ) {
		return;
	}
	$term = get_queried_object();
	if ( ! ( $term instanceof WP_Term ) || ! in_array( $term->slug, ecsges_cat_flat_slugs(), true ) ) {
		return;
	}
	$path = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( '' === $path || false === strpos( $path, '/category/' ) ) {
		return;
	}
	// Thay đoạn base ngay trong đường dẫn ĐANG VÀO, không dựng lại từ
	// get_category_link(): giữ nguyên tiền tố ngôn ngữ, thư mục con và query.
	wp_safe_redirect( preg_replace( '#/category/#', '/', $path, 1 ), 301 );
	exit;
}
add_action( 'template_redirect', 'ecsges_cat_redirect_old', 5 );

/**
 * Nạp lại rewrite rules khi danh sách chuyên mục phẳng thay đổi.
 *
 * @return void
 */
function ecsges_cat_flush_cache() {
	delete_transient( 'ecsges_cat_flat_slugs' );
	// Cờ để lần request sau nạp lại rules (flush ngay trong hook lưu term sẽ
	// chạy TRƯỚC khi term mới được ghi xong).
	update_option( 'ecsges_cat_rewrite_dirty', 1 );
}
add_action( 'created_category', 'ecsges_cat_flush_cache' );
add_action( 'edited_category', 'ecsges_cat_flush_cache' );
add_action( 'delete_category', 'ecsges_cat_flush_cache' );
add_action( 'save_post_page', 'ecsges_cat_flush_cache' );
add_action( 'deleted_post', 'ecsges_cat_flush_cache' );

/**
 * Thực hiện nạp lại rewrite rules nếu có cờ, hoặc lần đầu cài đặt.
 *
 * @return void
 */
function ecsges_cat_maybe_flush() {
	if ( get_option( 'ecsges_cat_rewrite_dirty' ) || 'v2' !== get_option( 'ecsges_cat_rewrite_version' ) ) {
		flush_rewrite_rules();
		update_option( 'ecsges_cat_rewrite_version', 'v2' );
		delete_option( 'ecsges_cat_rewrite_dirty' );
	}
}
add_action( 'init', 'ecsges_cat_maybe_flush', 25 );
