<?php
/**
 * Lĩnh vực hoạt động — thanh 5 tab + panel (ảnh trái, đoạn text phải).
 * Tab tương tác bằng initEcosystemTabs() (assets/js/main.js) qua
 * data-ecosystem / data-tab / data-panel (tái dùng, không cần JS mới).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lv_tabs = ecsges_linh_vuc_tabs();
?>
<section aria-labelledby="linh-vuc-heading" class="ecs-lv">
	<div class="ecs-lv__inner">
		<h2 id="linh-vuc-heading" class="ecs-lv__visually-hidden">Lĩnh vực hoạt động</h2>

		<div data-aos="fade-up" data-ecosystem>
			<!-- Tab bar -->
			<div role="tablist" aria-label="Lĩnh vực hoạt động" class="ecs-lv__tablist">
				<?php foreach ( $lv_tabs as $i => $tab ) : ?>
					<?php $active = ( 0 === $i ); ?>
					<button
						type="button"
						role="tab"
						id="lv-tab-<?php echo esc_attr( $tab['id'] ); ?>"
						data-tab="<?php echo esc_attr( $tab['id'] ); ?>"
						aria-selected="<?php echo $active ? 'true' : 'false'; ?>"
						aria-controls="lv-panel-<?php echo esc_attr( $tab['id'] ); ?>"
						class="ecs-lv__tab<?php echo $active ? ' is-active' : ''; ?>"
					><?php echo esc_html( $tab['label'] ); ?></button>
				<?php endforeach; ?>
			</div>

			<!-- Panels -->
			<?php foreach ( $lv_tabs as $i => $tab ) : ?>
				<?php $active = ( 0 === $i ); ?>
				<div
					role="tabpanel"
					id="lv-panel-<?php echo esc_attr( $tab['id'] ); ?>"
					data-panel="<?php echo esc_attr( $tab['id'] ); ?>"
					aria-labelledby="lv-tab-<?php echo esc_attr( $tab['id'] ); ?>"
					class="ecs-lv__panel<?php echo $active ? ' is-active' : ''; ?>"
				>
					<div class="ecs-lv__panel-inner">
						<img src="<?php echo esc_url( ecsges_img( $tab['image'] ) ); ?>" alt="<?php echo esc_attr( $tab['label'] ); ?>" class="ecs-lv__image">
						<div class="ecs-lv__box">
							<div class="ecs-lv__text">
								<?php if ( ! empty( $tab['title'] ) ) : ?>
									<p class="ecs-lv__title"><?php echo esc_html( $tab['title'] ); ?></p>
								<?php endif; ?>
								<?php
								// Đoạn paragraph là chuỗi nhiều dòng (title, mô tả, nhãn "Các dịch vụ:", rồi các dòng "- ...").
								// Tách từng dòng, bỏ khoảng trắng thừa; gom các dòng "- ..." liền nhau thành <ul>, còn lại là <p>.
								$lv_lines = preg_split( '/\r\n|\r|\n/', (string) $tab['paragraph'] );
								$lv_bullets = array();
								$flush_bullets = static function () use ( &$lv_bullets ) {
									if ( empty( $lv_bullets ) ) {
										return;
									}
									echo '<ul class="ecs-lv__list">';
									foreach ( $lv_bullets as $bullet ) {
										echo '<li>' . esc_html( $bullet ) . '</li>';
									}
									echo '</ul>';
									$lv_bullets = array();
								};
								foreach ( $lv_lines as $line ) {
									$line = trim( $line );
									if ( '' === $line ) {
										continue;
									}
									if ( 0 === strpos( $line, '-' ) ) {
										$lv_bullets[] = trim( ltrim( $line, '-' ) );
										continue;
									}
									$flush_bullets();
									echo '<p>' . esc_html( $line ) . '</p>';
								}
								$flush_bullets();
								?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
