<?php
/**
 * Chi tiết tuyển dụng — header tóm tắt (tiêu đề, lương, địa điểm, hạn nộp,
 * nút Ứng tuyển ngay mở lại đúng .ecs-job-modal đã có ở section-tuyen-dung-jobs.php).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id       = get_the_ID();
$jd_title    = get_the_title();
$jd_salary   = ecsges_field_page( $jd_id, 'job_salary', 'Thoả thuận' );
$jd_location = ecsges_field_page( $jd_id, 'job_location', 'Hà Nội' );
$jd_deadline = ecsges_field_page( $jd_id, 'job_deadline', 'Thời hạn: 20/7/2026' );
?>
<header class="ecs-job-detail__header">
	<div class="ecs-job-detail__header-inner">
		<h1 class="ecs-job-detail__title"><?php echo esc_html( $jd_title ); ?></h1>
		<ul class="ecs-job-detail__meta">
			<li class="ecs-job-detail__meta-item ecs-job-detail__meta-item--salary"><?php echo esc_html( $jd_salary ); ?></li>
			<li class="ecs-job-detail__meta-item">
				<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/pin.svg' ) ); ?>" alt="" class="ecs-job-detail__meta-icon">
				<?php echo esc_html( $jd_location ); ?>
			</li>
			<li class="ecs-job-detail__meta-item">
				<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/file.svg' ) ); ?>" alt="" class="ecs-job-detail__meta-icon">
				<?php echo esc_html( $jd_deadline ); ?>
			</li>
		</ul>
		<button type="button" class="ecs-job-detail__apply ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $jd_title ); ?>" aria-haspopup="dialog"><?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?></button>
	</div>
</header>
