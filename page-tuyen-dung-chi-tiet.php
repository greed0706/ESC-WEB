<?php
/**
 * Template Name: Chi tiết tuyển dụng
 *
 * Gán template này cho 1 WP Page = 1 tin tuyển dụng thật (Page Attributes →
 * Template, trong wp-admin). Không giới hạn số Page dùng chung template —
 * mỗi Page có nội dung riêng qua ACF field group "group_ecsges_job_detail"
 * (inc/acf-fields.php), đọc bằng ecsges_field_page( get_the_ID(), ... ).
 *
 * Bố cục theo ảnh mẫu: 1 cột duy nhất, breadcrumb ở trên cùng rồi một chồng
 * thẻ trắng viền mảnh — thẻ tóm tắt (tiêu đề/lương/meta/nút) rồi lần lượt các
 * thẻ nội dung. Không có sidebar.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-job-detail">
		<div class="ecs-job-detail__inner">
			<?php
			get_template_part( 'template-parts/job-chi-tiet', 'header' );
			get_template_part( 'template-parts/job-chi-tiet', 'content' );
			?>
		</div>
	</main>
<?php
get_template_part( 'template-parts/job', 'modal' );

get_footer();
