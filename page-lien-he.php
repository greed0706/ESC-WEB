<?php
/**
 * Template Name: Liên hệ
 * Trang "Liên hệ". Gán tự động cho Page slug 'lien-he' (nhờ tên file
 * page-lien-he.php) hoặc chọn template "Liên hệ".
 *
 * Bố cục (theo Figma node 288:147):
 *   1. Banner ảnh (assets/img/lien-he/image.png) — "LIÊN HỆ" + icon đã bake sẵn.
 *   2. section-contact — form liên hệ + thông tin trụ sở.
 *   3. section-branch — hệ thống chi nhánh (dùng lại từ trang chủ).
 *
 * GHI CHÚ: form ở section-contact hiện là tĩnh (chưa gửi mail). Để nối backend,
 * cắm plugin Contact Form 7 (hoặc admin-post handler) và trỏ action tương ứng.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main>
		<!-- ============================ Banner ============================ -->
		<?php
		get_template_part(
			'template-parts/page',
			'hero',
			array(
				'title'   => 'Liên hệ',
				'id'      => 'lien-he-hero',
				'bg'      => 'lien-he/banner.png',
				'variant' => 'banner',
			)
		);
		?>

		<?php
		get_template_part( 'template-parts/section', 'contact' );
		get_template_part( 'template-parts/section', 'branch' );
		?>
	</main>
<?php
get_footer();
