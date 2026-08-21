<?php
/**
 * Breadcrumb — MỘT nguồn dữ liệu cho cả phần hiển thị lẫn schema (việc #20).
 *
 * ecsges_breadcrumb_items() trả về đường dẫn phân cấp của trang hiện tại.
 * template-parts/breadcrumb.php vẽ nó ra, inc/schema.php dựng BreadcrumbList
 * từ CHÍNH mảng đó. Nhờ vậy dải breadcrumb người đọc thấy và cái Google đọc
 * không bao giờ lệch nhau — trước đây mỗi template tự viết breadcrumb riêng
 * nên rất dễ trôi.
 *
 * Mục cuối cùng là trang hiện tại: 'url' để RỖNG (không tự trỏ về chính mình).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Đường dẫn breadcrumb của trang đang xem.
 *
 * Trang chủ trả về mảng RỖNG — theo đúng bảng kế hoạch ("loại trừ trang chủ").
 *
 * @return array[] Mỗi mục: label (string), url (string, '' nếu là trang hiện tại).
 */
function ecsges_breadcrumb_items() {
	if ( is_front_page() ) {
		return array();
	}

	$home  = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
	$items = array(
		array(
			'label' => ecsges_t( 'Trang chủ' ),
			'url'   => $home,
		),
	);

	if ( is_singular( 'post' ) ) {
		// Bài viết: Trang chủ > Tin tức > [Chuyên mục] > Tiêu đề.
		$news = ecsges_translate_path( '/tin-tuc/' );
		$items[] = array(
			'label' => ecsges_t( 'Tin tức' ),
			'url'   => $news,
		);
		$cats = get_the_category();
		// Bỏ qua nếu tên chuyên mục trùng nhãn "Tin tức" ở trên, nếu không
		// breadcrumb đọc thành "Tin tức > Tin tức".
		//
		// PHẢI so bằng ecsges_normalize_for_compare(), KHÔNG so !== trực tiếp:
		// tên chuyên mục trong DB lưu dạng nửa phân rã ("ư" U+01B0 + dấu sắc
		// rời) còn chuỗi trong code là NFC ("ứ" U+1EE9). Hai chuỗi hiện ra y
		// hệt nhau nhưng khác byte nên so trực tiếp LUÔN ra "khác" — đó chính
		// là lý do breadcrumb từng in "Tin tức › Tin tức".
		$dup = ! empty( $cats )
			&& ecsges_normalize_for_compare( $cats[0]->name ) === ecsges_normalize_for_compare( ecsges_t( 'Tin tức' ) );
		if ( ! empty( $cats ) && ! $dup ) {
			$items[] = array(
				'label' => $cats[0]->name,
				'url'   => get_category_link( $cats[0]->term_id ),
			);
		}
		$items[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
		return $items;
	}

	if ( is_singular( ECSGES_TG_TYPE ) ) {
		$items[] = array(
			'label' => ecsges_t( 'Tác giả' ),
			'url'   => get_post_type_archive_link( ECSGES_TG_TYPE ),
		);
		$items[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
		return $items;
	}

	if ( is_post_type_archive( ECSGES_TG_TYPE ) ) {
		$items[] = array(
			'label' => ecsges_t( 'Tác giả' ),
			'url'   => '',
		);
		return $items;
	}

	if ( is_page() ) {
		// Trang: chèn toàn bộ trang cha theo thứ tự gốc → con.
		foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) {
			if ( 'publish' !== get_post_status( $ancestor ) ) {
				continue;
			}
			$items[] = array(
				'label' => get_the_title( $ancestor ),
				'url'   => get_permalink( $ancestor ),
			);
		}
		$items[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
		return $items;
	}

	if ( is_category() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			foreach ( array_reverse( get_ancestors( $term->term_id, 'category', 'taxonomy' ) ) as $ancestor ) {
				$items[] = array(
					'label' => get_cat_name( $ancestor ),
					'url'   => get_category_link( $ancestor ),
				);
			}
			$items[] = array(
				'label' => $term->name,
				'url'   => '',
			);
		}
		return $items;
	}

	if ( is_search() ) {
		$items[] = array(
			'label' => ecsges_t( 'Kết quả tìm kiếm' ),
			'url'   => '',
		);
		return $items;
	}

	if ( is_404() ) {
		$items[] = array(
			'label' => ecsges_t( 'Không tìm thấy trang' ),
			'url'   => '',
		);
		return $items;
	}

	// Kho lưu trữ còn lại (ngày tháng, thẻ…): dùng tiêu đề WP tự sinh.
	$title = wp_strip_all_tags( get_the_archive_title() );
	if ( '' !== $title ) {
		$items[] = array(
			'label' => $title,
			'url'   => '',
		);
	}
	return $items;
}

/**
 * In dải breadcrumb. Bọc get_template_part để template gọi cho gọn.
 *
 * @return void
 */
function ecsges_breadcrumb() {
	get_template_part( 'template-parts/breadcrumb' );
}
