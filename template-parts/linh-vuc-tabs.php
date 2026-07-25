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

$lv_tabs = ecsges_tr_deep( ecsges_linh_vuc_tabs() );
?>
<section aria-labelledby="linh-vuc-heading" class="ecs-lv">
	<div class="ecs-lv__inner">
		<h2 id="linh-vuc-heading" class="ecs-lv__visually-hidden"><?php echo esc_html( ecsges_t( 'Lĩnh vực hoạt động' ) ); ?></h2>

		<div data-aos="fade-up" data-ecosystem>
			<!-- Tab bar -->
			<?php
			// Dùng LẠI tablist của trang chủ (section-ecosystem.php): các class
			// .ecs-ecosystem__tablist/__tab-wrap/__tab/__icon/__label/__caret là BEM
			// phẳng nên áp được ngoài .ecs-ecosystem, không cần SCSS mới.
			// Hành vi giữ nguyên: vẫn là <button data-tab> đổi panel tại chỗ qua
			// initEcosystemTabs(), KHÔNG điều hướng (cả trang này là các panel đó).
			?>
			<?php
			// KHÔNG dùng lại class .ecs-lv__tablist ở đây: nó có `display: flex` và
			// _pages.scss nạp SAU _landing.scss nên sẽ ghi đè `display: grid` của
			// .ecs-ecosystem__tablist (cùng độ đặc hiệu 1 class → thứ tự quyết định).
			// Hệ quả kèm theo: mất luôn đường kẻ xám dưới hàng tab của thiết kế cũ —
			// đúng ý, vì tablist trang chủ là các thẻ rời có gap, không có đường kẻ.
			?>
			<div role="tablist" aria-label="<?php echo esc_attr( ecsges_t( 'Lĩnh vực hoạt động' ) ); ?>" class="ecs-ecosystem__tablist">
				<?php foreach ( $lv_tabs as $i => $tab ) : ?>
					<?php $active = ( 0 === $i ); ?>
					<div class="ecs-ecosystem__tab-wrap">
						<button
							type="button"
							role="tab"
							id="lv-tab-<?php echo esc_attr( $tab['id'] ); ?>"
							data-tab="<?php echo esc_attr( $tab['id'] ); ?>"
							aria-selected="<?php echo $active ? 'true' : 'false'; ?>"
							aria-controls="lv-panel-<?php echo esc_attr( $tab['id'] ); ?>"
							class="ecs-ecosystem__tab<?php echo $active ? ' is-active' : ''; ?>"
						>
							<?php if ( ! empty( $tab['icon'] ) ) : ?>
								<span data-tab-icon aria-hidden="true" class="ecs-ecosystem__icon">
									<?php echo ecsges_inline_svg( $tab['icon'] . '.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
							<?php endif; ?>
							<span class="ecs-ecosystem__label"><?php echo esc_html( $tab['label'] ); ?></span>
						</button>
						<span data-tab-caret aria-hidden="true" class="ecs-ecosystem__caret"></span>
					</div>
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
