<?php
/**
 * Mục lục bài viết — lớp mỏng bọc plugin "Easy Table of Contents" (ez-toc).
 *
 * Phần nhìn nằm ở src/scss/components/_toc.scss. File này chỉ lo phần chữ.
 *
 * Nhãn mục lục lưu trong option `ez-toc-settings` của plugin (mặc định
 * "Table of Contents"). Thay vì ghi đè giá trị đó trong DB, theme lọc lúc
 * đọc: site là site tiếng Việt nên nhãn phải là "Mục lục", còn trang bản
 * tiếng Anh của Polylang giữ nguyên "Table of Contents" — cùng cách làm với
 * lớp dịch trong inc/i18n.php, không nhân đôi chuỗi ở hai nơi.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nhãn tiêu đề khối mục lục.
 *
 * CỐ Ý bỏ qua khi is_admin(): màn hình cài đặt của plugin cũng đọc qua
 * ezTOC_Option::get(), lọc cả ở đó thì ô nhập sẽ hiện "Mục lục" thay vì giá
 * trị thật đang lưu, và lần bấm Lưu kế tiếp sẽ âm thầm ghi đè option.
 *
 * @param string $value Giá trị đang lưu trong option.
 * @return string
 */
function ecsges_toc_heading_text( $value ) {
	if ( is_admin() ) {
		return $value;
	}

	return ecsges_is_en() ? 'Table of Contents' : 'Mục lục';
}
add_filter( 'eztoc_get_option_heading_text', 'ecsges_toc_heading_text' );
