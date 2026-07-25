<?php
/**
 * Section Ecosystem (port EcosystemSection.tsx + EcosystemTabs.tsx).
 * Tab tương tác bằng JS thuần (assets/js/main.js) thay cho React useState.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_defaults = ecsges_ecosystem_tabs();
$ecsges_tabs     = array();
foreach ( $ecsges_defaults as $i => $t ) {
	$n             = $i + 1;
	$ecsges_tabs[] = array(
		'id'    => $t['id'],
		'icon'  => $t['icon'],
		'label' => ecsges_field( "ecosystem_tab{$n}_label", $t['label'] ),
		'title' => ecsges_field( "ecosystem_tab{$n}_title", $t['title'] ),
		'body'  => ecsges_field( "ecosystem_tab{$n}_body", $t['body'] ),
		'image' => ecsges_field_img( "ecosystem_tab{$n}_image", $t['image'] ),
	);
}
$eco_lines      = ecsges_field_lines( 'ecosystem_heading', array( 'HỆ SINH THÁI', 'KẾT NỐI ĐA LĨNH VỰC' ) );
$eco_intro      = ecsges_field( 'ecosystem_intro', 'Mỗi lĩnh vực hoạt động của ECSGES là một mắt xích quan trọng, cùng đồng hành với người học trên hành trình học tập, rèn luyện và lập nghiệp.' );
?>
<section id="linh-vuc" aria-labelledby="ecosystem-heading" class="ecs-ecosystem">
	<div class="ecs-ecosystem__inner">
		<div data-aos="fade-up">
			<?php
			ecsges_section_heading(
				array(
					'id'    => 'ecosystem-heading',
					'align' => 'center',
					'lines' => $eco_lines,
					'class' => 'ecs-ecosystem__heading',
				)
			);
			?>
		</div>
		<p class="ecs-ecosystem__intro" data-aos="fade-up" data-aos-delay="100"><?php echo esc_html( $eco_intro ); ?></p>

		<div class="ecs-ecosystem__tabs" data-aos="fade-up" data-aos-delay="150" data-ecosystem>
			<!-- Tab bar -->
			<div role="tablist" aria-label="Lĩnh vực hoạt động" class="ecs-ecosystem__tablist">
				<?php foreach ( $ecsges_tabs as $i => $tab ) : ?>
					<?php $active = ( 0 === $i ); ?>
					<div class="ecs-ecosystem__tab-wrap">
						<button
							type="button"
							role="tab"
							id="tab-<?php echo esc_attr( $tab['id'] ); ?>"
							data-tab="<?php echo esc_attr( $tab['id'] ); ?>"
							aria-selected="<?php echo $active ? 'true' : 'false'; ?>"
							aria-controls="panel-<?php echo esc_attr( $tab['id'] ); ?>"
							class="ecs-ecosystem__tab<?php echo $active ? ' is-active' : ''; ?>"
						>
							<span data-tab-icon aria-hidden="true" class="ecs-ecosystem__icon">
								<?php echo ecsges_inline_svg( $tab['icon'] . '.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
							<span class="ecs-ecosystem__label"><?php echo esc_html( $tab['label'] ); ?></span>
						</button>
						<span data-tab-caret aria-hidden="true" class="ecs-ecosystem__caret"></span>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Panels -->
			<?php foreach ( $ecsges_tabs as $i => $tab ) : ?>
				<?php $active = ( 0 === $i ); ?>
				<div
					role="tabpanel"
					id="panel-<?php echo esc_attr( $tab['id'] ); ?>"
					data-panel="<?php echo esc_attr( $tab['id'] ); ?>"
					aria-labelledby="tab-<?php echo esc_attr( $tab['id'] ); ?>"
					class="ecs-ecosystem__panel<?php echo $active ? ' is-active' : ''; ?>"
				>
					<img src="<?php echo esc_url( $tab['image'] ); ?>" alt="<?php echo esc_attr( ecsges_t( 'Hình ảnh minh hoạ lĩnh vực' ) . ' ' . mb_strtolower( $tab['label'] ) ); ?>" class="ecs-ecosystem__panel-img">
					<div class="ecs-ecosystem__panel-body">
						<h3 class="ecs-ecosystem__panel-title"><?php echo esc_html( $tab['title'] ); ?></h3>
						<p class="ecs-ecosystem__panel-text"><?php echo esc_html( $tab['body'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
