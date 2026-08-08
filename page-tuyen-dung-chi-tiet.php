<?php
/**
 * Template Name: Chi tiết tuyển dụng
 *
 * Gán template này cho 1 WP Page = 1 tin tuyển dụng thật (Page Attributes →
 * Template, trong wp-admin). Không giới hạn số Page dùng chung template —
 * mỗi Page có nội dung riêng qua ACF field group "group_ecsges_job_detail"
 * (inc/acf-fields.php), đọc bằng ecsges_field_page( get_the_ID(), ... ).
 *
 * Bố cục theo Figma node 715:1458: nền trang xám #f0f0f0, breadcrumb trên cùng,
 * rồi 2 cột — cột trái 905px (thẻ tóm tắt + một thẻ trắng liền mạch chứa
 * "Tổng quan" và các khối nội dung), cột phải 360px (thẻ công ty + thẻ
 * "Thông tin chung").
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
			<?php get_template_part( 'template-parts/job-chi-tiet', 'breadcrumb' ); ?>

			<div class="ecs-job-detail__layout">
				<div class="ecs-job-detail__main">
					<?php get_template_part( 'template-parts/job-chi-tiet', 'header' ); ?>

					<div class="ecs-job-detail__card ecs-job-detail__body">
						<?php
						get_template_part( 'template-parts/job-chi-tiet', 'overview' );
						get_template_part( 'template-parts/job-chi-tiet', 'content' );
						?>
					</div>
				</div>

				<?php get_template_part( 'template-parts/job-chi-tiet', 'sidebar' ); ?>
			</div>
		</div>
	</main>
<?php
get_template_part( 'template-parts/job', 'modal' );

get_footer();
