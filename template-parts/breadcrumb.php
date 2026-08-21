<?php
/**
 * Dải breadcrumb full-bleed nền xám — dùng chung MỌI trang trừ trang chủ.
 *
 * Dữ liệu lấy từ ecsges_breadcrumb_items() (inc/breadcrumb.php), đúng mảng mà
 * inc/schema.php dùng để dựng BreadcrumbList — sửa đường dẫn ở đó là cả hai
 * cùng đổi.
 *
 * Class giữ nguyên tiền tố .ecs-single__* vì CSS của dải này đã nằm sẵn ở
 * components/_posts.scss và đang được nhiều template dùng; đổi tên sẽ phải sửa
 * đồng loạt mà không được lợi gì.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_crumbs = ecsges_breadcrumb_items();

if ( empty( $ecsges_crumbs ) ) {
	return; // trang chủ
}
?>
<div class="ecs-single__crumbbar">
	<div class="ecs-single__crumbbar-inner">
		<nav class="ecs-single__breadcrumb" aria-label="Breadcrumb">
			<?php foreach ( $ecsges_crumbs as $ecsges_i => $ecsges_crumb ) : ?>
				<?php if ( $ecsges_i > 0 ) : ?>
					<span class="ecs-single__crumb-sep" aria-hidden="true"></span>
				<?php endif; ?>

				<?php if ( '' !== $ecsges_crumb['url'] ) : ?>
					<a href="<?php echo esc_url( $ecsges_crumb['url'] ); ?>"><?php echo esc_html( $ecsges_crumb['label'] ); ?></a>
				<?php else : ?>
					<span class="ecs-single__breadcrumb-current" aria-current="page"><?php echo esc_html( $ecsges_crumb['label'] ); ?></span>
				<?php endif; ?>
			<?php endforeach; ?>
		</nav>
	</div>
</div>
