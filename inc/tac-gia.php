<?php
/**
 * Post Type "Tác giả" (tac_gia) — hồ sơ tác giả soạn như một trang.
 *
 * VÌ SAO KHÔNG DÙNG USER CỦA WORDPRESS: hồ sơ ở đây là NỘI DUNG BIÊN TẬP (ảnh
 * chân dung, tiểu sử dài, kinh nghiệm, thành tích) chứ không phải tài khoản
 * đăng nhập. Người viết bài thực tế có thể không có tài khoản trên site.
 *
 * ĐÁNH ĐỔI PHẢI BIẾT: post type này KHÔNG tự gắn với bài viết như `post_author`
 * của WordPress. Mỗi bài phải CHỌN TAY tác giả ở ô "Tác giả bài viết" trong màn
 * hình sửa bài (meta box bên dưới ghi vào meta ECSGES_TG_META_LINK). Bài chưa
 * chọn thì trang hồ sơ không liệt kê được nó.
 *
 * URL: /tac-gia/ (danh sách) và /tac-gia/{slug}/ (một hồ sơ).
 * Template: archive-tac_gia.php và single-tac_gia.php.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Tên post type. Rewrite slug là 'tac-gia' — KHÁC tên post type, đừng lẫn. */
const ECSGES_TG_TYPE = 'tac_gia';

/** Meta trên BÀI VIẾT, trỏ tới ID hồ sơ tác giả. */
const ECSGES_TG_META_LINK = 'ecsges_tac_gia_id';

/**
 * Các field của hồ sơ: khoá meta → nhãn + kiểu ô + gợi ý.
 *
 * Post type này CỐ Ý không bật 'editor' — hồ sơ tác giả là dữ liệu có cấu trúc
 * (chức danh, tiểu sử, kinh nghiệm, thành tích), không phải bài viết tự do. Bỏ
 * ô soạn thảo lớn để màn hình nhập gọn và không ai dán được HTML lung tung vào
 * giữa bố cục hồ sơ.
 *
 * Ảnh chân dung KHÔNG nằm ở đây: dùng Ảnh đại diện (featured image) của post type.
 *
 * @return array[]
 */
function ecsges_tg_fields() {
	return array(
		'ecsges_tg_role' => array(
			'label' => 'Chức danh',
			'type'  => 'text',
			'desc'  => 'Ví dụ: Trưởng ban Biên tập ECSGES. Hiện ngay dưới tên.',
		),
		'ecsges_tg_bio' => array(
			'label' => 'Tiểu sử',
			'type'  => 'textarea',
			'desc'  => 'Vài dòng giới thiệu. Cách nhau một dòng trống để tách đoạn. Cũng là đoạn tóm tắt hiện ở trang danh sách /tac-gia/.',
		),
		'ecsges_tg_experience' => array(
			'label' => 'Kinh nghiệm làm việc',
			'type'  => 'textarea',
			'desc'  => 'MỖI DÒNG MỘT MỤC. Ví dụ: 2020 – nay: Trưởng ban Đào tạo, ECS Global',
		),
		'ecsges_tg_achievements' => array(
			'label' => 'Thành tích',
			'type'  => 'textarea',
			'desc'  => 'MỖI DÒNG MỘT MỤC. Ví dụ: Giải Nhì Giáo viên dạy giỏi cấp Thành phố 2024',
		),
	);
}

/* ------------------------------------------------------------------ *\
 * Đăng ký post type
\* ------------------------------------------------------------------ */

/**
 * Đăng ký post type "Tác giả".
 *
 * @return void
 */
function ecsges_tg_register() {
	register_post_type(
		ECSGES_TG_TYPE,
		array(
			'labels' => array(
				'name'               => 'Tác giả',
				'singular_name'      => 'Tác giả',
				'menu_name'          => 'Tác giả',
				'add_new'            => 'Thêm tác giả',
				'add_new_item'       => 'Thêm tác giả mới',
				'edit_item'          => 'Sửa hồ sơ tác giả',
				'new_item'           => 'Tác giả mới',
				'view_item'          => 'Xem hồ sơ',
				'search_items'       => 'Tìm tác giả',
				'not_found'          => 'Chưa có tác giả nào.',
				'not_found_in_trash' => 'Thùng rác trống.',
				'featured_image'     => 'Ảnh chân dung',
				'set_featured_image' => 'Chọn ảnh chân dung',
			),
			'public'       => true,
			'has_archive'  => 'tac-gia',
			'rewrite'      => array(
				'slug'       => 'tac-gia',
				'with_front' => false, // /tac-gia/... chứ không đội thêm tiền tố permalink.
			),
			'menu_icon'    => 'dashicons-id-alt',
			'menu_position' => 21, // ngay dưới Trang
			// KHÔNG có 'editor' và 'excerpt': mọi nội dung hồ sơ đi qua meta box
			// "Thông tin hồ sơ" (xem ecsges_tg_fields). Bật lại 'editor' sẽ hiện ô
			// soạn thảo lớn nhưng single-tac_gia.php KHÔNG in the_content() nữa,
			// nên nội dung gõ vào đó sẽ không hiện ra đâu cả.
			'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true,
			'taxonomies'   => array(),
		)
	);
}
add_action( 'init', 'ecsges_tg_register' );

/**
 * Nạp lại rewrite rules MỘT LẦN sau khi thêm post type.
 *
 * Không gọi flush_rewrite_rules() trên mọi request (rất nặng) — chốt bằng một
 * option version. Đổi post type/slug về sau thì tăng chuỗi version này lên.
 *
 * @return void
 */
function ecsges_tg_maybe_flush() {
	if ( 'v1' !== get_option( 'ecsges_tg_rewrite_version' ) ) {
		flush_rewrite_rules();
		update_option( 'ecsges_tg_rewrite_version', 'v1' );
	}
}
add_action( 'init', 'ecsges_tg_maybe_flush', 20 );

/* ------------------------------------------------------------------ *\
 * Meta box trên màn hình sửa hồ sơ tác giả
\* ------------------------------------------------------------------ */

/**
 * Thêm hộp "Thông tin hồ sơ" vào màn hình sửa tác giả.
 *
 * @return void
 */
function ecsges_tg_add_meta_box() {
	add_meta_box(
		'ecsges-tg-info',
		'Thông tin hồ sơ',
		'ecsges_tg_render_meta_box',
		ECSGES_TG_TYPE,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ecsges_tg_add_meta_box' );

/**
 * Nội dung hộp meta.
 *
 * @param WP_Post $post
 * @return void
 */
function ecsges_tg_render_meta_box( $post ) {
	wp_nonce_field( 'ecsges_tg_save', 'ecsges_tg_nonce' );
	?>
	<style>
		.ecsges-tg-field { margin-bottom: 18px; }
		.ecsges-tg-field label { display: block; font-weight: 600; margin-bottom: 4px; }
		.ecsges-tg-field input[type="text"],
		.ecsges-tg-field textarea { width: 100%; }
	</style>
	<?php foreach ( ecsges_tg_fields() as $key => $field ) : ?>
		<?php $value = get_post_meta( $post->ID, $key, true ); ?>
		<div class="ecsges-tg-field">
			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
			<?php if ( 'textarea' === $field['type'] ) : ?>
				<textarea id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" rows="6"><?php echo esc_textarea( $value ); ?></textarea>
			<?php else : ?>
				<input type="text" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>">
			<?php endif; ?>
			<p class="description"><?php echo esc_html( $field['desc'] ); ?></p>
		</div>
	<?php endforeach; ?>
	<p class="description">
		<strong>Ảnh chân dung</strong> đặt ở hộp "Ảnh chân dung" bên phải.
	</p>
	<?php
}

/**
 * Lưu meta hồ sơ tác giả.
 *
 * @param int $post_id
 * @return void
 */
function ecsges_tg_save_meta( $post_id ) {
	if ( ! isset( $_POST['ecsges_tg_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['ecsges_tg_nonce'] ) ), 'ecsges_tg_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( ecsges_tg_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $key ] );
		$val = 'textarea' === $field['type'] ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		update_post_meta( $post_id, $key, $val );
	}
}
add_action( 'save_post_' . ECSGES_TG_TYPE, 'ecsges_tg_save_meta' );

/* ------------------------------------------------------------------ *\
 * Ô chọn tác giả trên màn hình sửa BÀI VIẾT
\* ------------------------------------------------------------------ */

/**
 * Hộp "Tác giả bài viết" ở cột bên của màn hình sửa bài.
 *
 * @return void
 */
function ecsges_tg_add_post_box() {
	add_meta_box(
		'ecsges-tg-picker',
		'Tác giả bài viết',
		'ecsges_tg_render_post_box',
		'post',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'ecsges_tg_add_post_box' );

/**
 * Nội dung hộp chọn tác giả.
 *
 * @param WP_Post $post
 * @return void
 */
function ecsges_tg_render_post_box( $post ) {
	wp_nonce_field( 'ecsges_tg_link_save', 'ecsges_tg_link_nonce' );
	$current = (int) get_post_meta( $post->ID, ECSGES_TG_META_LINK, true );
	$people  = ecsges_tg_all();
	?>
	<?php if ( ! $people ) : ?>
		<p>Chưa có hồ sơ tác giả nào. Vào <strong>Tác giả → Thêm tác giả</strong> để tạo trước.</p>
	<?php else : ?>
		<select name="<?php echo esc_attr( ECSGES_TG_META_LINK ); ?>" style="width:100%">
			<option value="0">— Không gán —</option>
			<?php foreach ( $people as $person ) : ?>
				<option value="<?php echo esc_attr( $person->ID ); ?>" <?php selected( $current, $person->ID ); ?>>
					<?php echo esc_html( $person->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p class="description">Hồ sơ hiện ở trang bài viết và bài này sẽ được liệt kê trong trang hồ sơ đó.</p>
	<?php endif; ?>
	<?php
}

/**
 * Lưu liên kết bài viết → tác giả.
 *
 * @param int $post_id
 * @return void
 */
function ecsges_tg_save_link( $post_id ) {
	if ( ! isset( $_POST['ecsges_tg_link_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['ecsges_tg_link_nonce'] ) ), 'ecsges_tg_link_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$id = isset( $_POST[ ECSGES_TG_META_LINK ] ) ? absint( wp_unslash( $_POST[ ECSGES_TG_META_LINK ] ) ) : 0;
	if ( $id > 0 && ECSGES_TG_TYPE === get_post_type( $id ) ) {
		update_post_meta( $post_id, ECSGES_TG_META_LINK, $id );
	} else {
		delete_post_meta( $post_id, ECSGES_TG_META_LINK );
	}
}
add_action( 'save_post_post', 'ecsges_tg_save_link' );

/* ------------------------------------------------------------------ *\
 * Helper cho template
\* ------------------------------------------------------------------ */

/**
 * Toàn bộ hồ sơ tác giả đã publish, theo thứ tự menu_order rồi tên.
 *
 * @return WP_Post[]
 */
function ecsges_tg_all() {
	return get_posts(
		array(
			'post_type'      => ECSGES_TG_TYPE,
			'post_status'    => 'publish',
			'numberposts'    => -1,
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'suppress_filters' => false,
		)
	);
}

/**
 * Một field textarea của hồ sơ → mảng dòng (bỏ dòng trống).
 *
 * @param int    $post_id ID hồ sơ tác giả.
 * @param string $key     Khoá meta.
 * @return string[]
 */
function ecsges_tg_lines( $post_id, $key ) {
	$raw = (string) get_post_meta( $post_id, $key, true );
	if ( '' === trim( $raw ) ) {
		return array();
	}
	$lines = preg_split( '/\r\n|\r|\n/', $raw );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

/**
 * Hồ sơ tác giả gắn với một bài viết.
 *
 * @param int|null $post_id Mặc định bài hiện tại.
 * @return WP_Post|null null nếu bài chưa gán tác giả (hoặc hồ sơ đã bị xoá).
 */
function ecsges_tg_for_post( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$tg_id   = (int) get_post_meta( $post_id, ECSGES_TG_META_LINK, true );
	if ( $tg_id <= 0 ) {
		return null;
	}
	$tg = get_post( $tg_id );
	return ( $tg && ECSGES_TG_TYPE === $tg->post_type && 'publish' === $tg->post_status ) ? $tg : null;
}

/**
 * Tiểu sử của một hồ sơ, đã tách đoạn thành HTML an toàn để in thẳng.
 *
 * Giá trị lưu là văn bản THUẦN (sanitize_textarea_field), nên phải esc_html()
 * TRƯỚC rồi mới wpautop() — làm ngược lại sẽ thoát luôn cả thẻ <p> vừa sinh ra
 * và người đọc thấy "&lt;p&gt;" trên màn hình.
 *
 * @param int $tg_id
 * @return string HTML ('' nếu chưa nhập).
 */
function ecsges_tg_bio_html( $tg_id ) {
	$raw = trim( (string) get_post_meta( $tg_id, 'ecsges_tg_bio', true ) );
	return '' === $raw ? '' : wpautop( esc_html( $raw ) );
}

/**
 * Tiểu sử rút gọn cho thẻ ở trang danh sách.
 *
 * @param int $tg_id
 * @param int $words
 * @return string Văn bản thuần.
 */
function ecsges_tg_bio_excerpt( $tg_id, $words = 22 ) {
	$raw = trim( (string) get_post_meta( $tg_id, 'ecsges_tg_bio', true ) );
	return '' === $raw ? '' : wp_trim_words( $raw, $words );
}

/**
 * Ảnh chân dung của một hồ sơ (featured image), rỗng nếu chưa đặt.
 *
 * @param int    $tg_id
 * @param string $size
 * @return string URL hoặc ''.
 */
function ecsges_tg_photo( $tg_id, $size = 'medium' ) {
	$url = get_the_post_thumbnail_url( $tg_id, $size );
	return $url ? $url : '';
}

/* ------------------------------------------------------------------ *\
 * Gộp về MỘT khái niệm tác giả
\* ------------------------------------------------------------------ */

/**
 * Chuyển hướng 301 kho lưu trữ tác giả của WordPress (/author/{tài-khoản}/)
 * sang hồ sơ trong post type này.
 *
 * Lý do: site giờ có ĐÚNG MỘT khái niệm tác giả. Để /author/ sống song song sẽ
 * tạo trang trùng nội dung (Google phạt) và một URL không ai biên tập được —
 * theme lại không có author.php nên nó rơi xuống index.php, hiện ra trơ trụi.
 *
 * BỎ CHUYỂN HƯỚNG NÀY: xoá add_action ở dưới.
 *
 * @return void
 */
function ecsges_tg_redirect_user_archives() {
	if ( ! is_author() ) {
		return;
	}
	wp_safe_redirect( get_post_type_archive_link( ECSGES_TG_TYPE ), 301 );
	exit;
}
add_action( 'template_redirect', 'ecsges_tg_redirect_user_archives' );
