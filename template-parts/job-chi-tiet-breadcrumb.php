<?php
/**
 * Chi tiết tuyển dụng — breadcrumb (Figma node 715:1458, y=132).
 *
 * "Trang chủ > Tuyển dụng > <tiêu đề tin>", 18px Light #000, dấu phân cách là
 * mũi tên nhỏ. Khác trang bài viết: ở đây KHÔNG có dải nền riêng vì cả trang
 * đã là nền xám #f0f0f0.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_list_url = ecsges_translate_path( '/tuyen-dung/' );
?>
<nav class="ecs-job-detail__breadcrumb" aria-label="Breadcrumb">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( ecsges_t( 'Trang chủ' ) ); ?></a>
	<span class="ecs-job-detail__crumb-sep" aria-hidden="true"></span>
	<a href="<?php echo esc_url( $jd_list_url ); ?>"><?php echo esc_html( ecsges_t( 'Tuyển dụng' ) ); ?></a>
	<span class="ecs-job-detail__crumb-sep" aria-hidden="true"></span>
	<span class="ecs-job-detail__breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
</nav>
