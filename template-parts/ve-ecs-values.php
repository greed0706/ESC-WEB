<?php
/**
 * Về ECS — Giá trị cốt lõi (port VeEcsValues.tsx).
 * Desktop: hình quạt 5 múi (nền xám → viền cam → icon → mũi tên) + 5 khối chữ
 * đặt tuyệt đối. Mobile: icon + chữ xếp dọc. Toạ độ giữ nguyên theo Figma.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$values = array();
foreach ( ecsges_core_values() as $v ) {
	$values[ $v['key'] ] = $v;
}

$wedge_fills = array(
	array( 'src' => 'bg/bg-tam.svg',  'left' => '38.2%', 'top' => '76.3%', 'width' => '10%' ),
	array( 'src' => 'bg/bg-ben.svg',  'left' => '41.9%', 'top' => '63.4%', 'width' => '10.6%' ),
	array( 'src' => 'bg/bg-hop.svg',  'left' => '50.2%', 'top' => '59.3%', 'width' => '9.7%' ),
	array( 'src' => 'bg/bg-tri.svg',  'left' => '58.4%', 'top' => '63.5%', 'width' => '10.6%' ),
	array( 'src' => 'bg/bg-sang.svg', 'left' => '62.2%', 'top' => '76.2%', 'width' => '10%' ),
);
$fan_box = 'left:32.97%;top:48.6%;width:34.375%;height:38.4%';
$icons   = array(
	array( 'key' => 'TÂM',  'src' => 'tam.svg',  'left' => '37.6%', 'top' => '79%',    'width' => '4.06%' ),
	array( 'key' => 'BỀN',  'src' => 'ben.svg',  'left' => '42.8%', 'top' => '64.5%',  'width' => '3.54%' ),
	array( 'key' => 'HỢP',  'src' => 'hop.svg',  'left' => '50.2%', 'top' => '59%',    'width' => '3.59%' ),
	array( 'key' => 'TRÍ',  'src' => 'tri.svg',  'left' => '57.2%', 'top' => '64.5%',  'width' => '3.28%' ),
	array( 'key' => 'SÁNG', 'src' => 'sang.svg', 'left' => '62.0%', 'top' => '78.75%', 'width' => '3.59%' ),
);
$arrows = array(
	array( 'src' => 'arrow/arrow-hop.svg',  'left' => '50%',   'top' => '45.6%', 'width' => '2.92%' ),
	array( 'src' => 'arrow/arrow-ben.svg',  'left' => '39.0%', 'top' => '54.3%', 'width' => '4.06%' ),
	array( 'src' => 'arrow/arrow-tri.svg',  'left' => '61.5%', 'top' => '53.8%', 'width' => '4.06%' ),
	array( 'src' => 'arrow/arrow-tam.svg',  'left' => '32.3%', 'top' => '76.6%', 'width' => '3.59%' ),
	array( 'src' => 'arrow/arrow-sang.svg', 'left' => '68.0%', 'top' => '75.5%', 'width' => '3.59%' ),
);
$labels = array(
	array( 'key' => 'TÂM',  'left' => '22.8%', 'top' => '67.4%', 'width' => '15%' ),
	array( 'key' => 'BỀN',  'left' => '28%',   'top' => '40.7%', 'width' => '19%' ),
	array( 'key' => 'HỢP',  'left' => '50%',   'top' => '21.6%', 'width' => '23%' ),
	array( 'key' => 'TRÍ',  'left' => '73.2%', 'top' => '37.4%', 'width' => '19.5%' ),
	array( 'key' => 'SÁNG', 'left' => '76.9%', 'top' => '66%',   'width' => '15%' ),
);
$key_fs  = 'font-size:clamp(15px, 1.35cqw, 26px)';
$text_fs = 'font-size:clamp(11px, 0.94cqw, 18px)';

$centered = 'transform:translate(-50%, -50%)';
?>
<section id="gia-tri-cot-loi" aria-labelledby="ve-ecs-values-heading" class="ecs-ve-values">
	<!-- Desktop: hình quạt -->
	<div class="ecs-ve-values__fan" style="container-type:inline-size;aspect-ratio:1920 / 852" data-aos="fade-up">
		<h2 id="ve-ecs-values-heading" class="ecs-ve-values__heading" style="font-size:clamp(24px, 2.6cqw, 50px)">GIÁ TRỊ CỐT LÕI</h2>

		<?php foreach ( $wedge_fills as $f ) : ?>
			<img src="<?php echo esc_url( ecsges_img( 've-ecs/' . $f['src'] ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-values__wedge" style="left:<?php echo esc_attr( $f['left'] ); ?>;top:<?php echo esc_attr( $f['top'] ); ?>;width:<?php echo esc_attr( $f['width'] ); ?>;<?php echo esc_attr( $centered ); ?>">
		<?php endforeach; ?>

		<img src="<?php echo esc_url( ecsges_img( 've-ecs/list.svg' ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-values__fan-img" style="<?php echo esc_attr( $fan_box ); ?>">

		<?php foreach ( $icons as $ic ) : ?>
			<img src="<?php echo esc_url( ecsges_img( 've-ecs/' . $ic['src'] ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-values__icon" style="left:<?php echo esc_attr( $ic['left'] ); ?>;top:<?php echo esc_attr( $ic['top'] ); ?>;width:<?php echo esc_attr( $ic['width'] ); ?>;<?php echo esc_attr( $centered ); ?>">
		<?php endforeach; ?>

		<?php foreach ( $arrows as $a ) : ?>
			<img src="<?php echo esc_url( ecsges_img( 've-ecs/' . $a['src'] ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-values__arrow" style="left:<?php echo esc_attr( $a['left'] ); ?>;top:<?php echo esc_attr( $a['top'] ); ?>;width:<?php echo esc_attr( $a['width'] ); ?>;<?php echo esc_attr( $centered ); ?>">
		<?php endforeach; ?>

		<?php
		foreach ( $labels as $lb ) :
			$v = $values[ $lb['key'] ];
			?>
			<div class="ecs-ve-values__label" style="left:<?php echo esc_attr( $lb['left'] ); ?>;top:<?php echo esc_attr( $lb['top'] ); ?>;width:<?php echo esc_attr( $lb['width'] ); ?>">
				<p class="ecs-ve-values__label-key" style="<?php echo esc_attr( $key_fs ); ?>"><?php echo esc_html( ecsges_t( $v['key'] ) ); ?></p>
				<p class="ecs-ve-values__label-phrase" style="<?php echo esc_attr( $text_fs ); ?>"><?php echo esc_html( ecsges_t( $v['phrase'] ) ); ?></p>
				<p class="ecs-ve-values__label-body" style="<?php echo esc_attr( $text_fs ); ?>"><?php echo esc_html( ecsges_t( $v['body'] ) ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- Mobile/tablet: icon + chữ xếp dọc -->
	<div class="ecs-ve-values__mobile">
		<div data-aos="fade-up">
			<?php
			ecsges_section_heading(
				array(
					'lines'  => array( 'GIÁ TRỊ CỐT LÕI' ),
					'accent' => array(),
					'align'  => 'center',
				)
			);
			?>
		</div>
		<div class="ecs-ve-values__grid">
			<?php
			foreach ( $icons as $mi => $ic ) :
				$v = $values[ $ic['key'] ];
				?>
				<div class="ecs-ve-values__item" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $mi * 80 ); ?>">
					<img src="<?php echo esc_url( ecsges_img( 've-ecs/' . $ic['src'] ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-values__item-icon">
					<p class="ecs-ve-values__item-key"><?php echo esc_html( ecsges_t( $v['key'] ) ); ?></p>
					<p class="ecs-ve-values__item-phrase"><?php echo esc_html( ecsges_t( $v['phrase'] ) ); ?></p>
					<p class="ecs-ve-values__item-body"><?php echo esc_html( ecsges_t( $v['body'] ) ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
