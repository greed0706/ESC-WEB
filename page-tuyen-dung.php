<?php
/**
 * Template Name: Tuyển dụng
 * Trang "Tuyển dụng". Gán tự động cho Page slug 'tuyen-dung' (nhờ tên file
 * page-tuyen-dung.php) hoặc chọn template.
 *
 * Bố cục (theo Figma node 402:280 / 405:228):
 *   1. section-tuyen-dung-hero  — banner ảnh + tiêu đề "Tuyển dụng".
 *   2. section-tuyen-dung-jobs  — bộ lọc, danh sách việc làm, phân trang,
 *      kèm modal "Nộp đơn ứng tuyển".
 *
 * GHI CHÚ: bộ lọc và form ứng tuyển hiện là tĩnh (chưa nối backend). Xem
 * initJobModal() trong assets/js/main.js để biết chỗ cắm xử lý hồ sơ.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main>
		<?php
		get_template_part( 'template-parts/section', 'tuyen-dung-hero' );
		get_template_part( 'template-parts/section', 'tuyen-dung-jobs' );
		?>
	</main>
<?php
get_footer();
