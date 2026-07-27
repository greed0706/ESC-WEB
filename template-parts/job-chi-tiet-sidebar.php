<?php
/**
 * Chi tiết tuyển dụng — sidebar: thẻ thông tin ECSGES (địa chỉ/email/điện
 * thoại, tái dùng ecsges_footer_contact() đã có cho footer) + nút Ứng tuyển
 * ngay, sticky ở màn hình rộng.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_contact = ecsges_footer_contact();
$jd_title   = get_the_title();
?>
<aside class="ecs-job-detail__sidebar">
	<div class="ecs-job-detail__sidebar-card">
		<img src="<?php echo esc_url( ecsges_img( 'logo-ecsges.svg' ) ); ?>" alt="ECSGES" class="ecs-job-detail__sidebar-logo">
		<p class="ecs-job-detail__sidebar-name">ECSGES — ECS Global Education System</p>
		<p class="ecs-job-detail__sidebar-line"><?php echo esc_html( $jd_contact['address'] ); ?></p>
		<p class="ecs-job-detail__sidebar-line"><?php echo esc_html( $jd_contact['email'] ); ?></p>
		<p class="ecs-job-detail__sidebar-line"><?php echo esc_html( $jd_contact['phone'] ); ?></p>
		<button type="button" class="ecs-job-detail__sidebar-apply ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $jd_title ); ?>" aria-haspopup="dialog"><?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?></button>
	</div>
</aside>
