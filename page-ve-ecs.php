<?php
/**
 * Template Name: Về ECS
 * Trang "Về ECS" (port VeEcsPage.tsx). Gán cho Page có slug 've-ecs'
 * (tự áp dụng nhờ tên file page-ve-ecs.php) hoặc chọn template "Về ECS".
 *
 * GỘP: toàn bộ 5 section ve-ecs (hero / journey / vision-mission / values /
 * stats) được inline trực tiếp vào file này thay cho get_template_part.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main>

		<!-- ============================ Hero ============================ -->
		<section id="top" aria-labelledby="ve-ecs-hero-heading" class="ecs-ve-hero">
			<img src="<?php echo esc_url( ecsges_img( 've-ecs/ve-ecs-hero-bg.jpg' ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-hero__bg">
			<div aria-hidden="true" class="ecs-ve-hero__overlay"></div>

			<div class="ecs-ve-hero__content">
				<h1 id="ve-ecs-hero-heading" data-aos="fade-up" class="ecs-ve-hero__title"><?php echo esc_html( ecsges_t( 'Về ECS' ) ); ?></h1>
			</div>
		</section>

		<!-- ==================== Hành trình phát triển ==================== -->
		<?php
		$milestones = ecsges_tr_deep( ecsges_milestones() );
		$intro      = ecsges_ve_ecs_intro();
		$stairs     = ecsges_img( 've-ecs/ve-ecs-journey-stairs.png' );

		// Vị trí từng mốc (% theo khung 1920×1416). side: neo trái/phải; align: canh chữ body.
		$positions = array(
			array( 'side' => 'left',  'align' => 'text-justify', 'box' => 'left:16.8%;top:71%;width:18%' ),
			array( 'side' => 'right', 'align' => 'text-right',   'box' => 'right:15.8%;top:59.8%;width:21%' ),
			array( 'side' => 'left',  'align' => 'text-justify', 'box' => 'left:16.8%;top:36.1%;width:19%' ),
			array( 'side' => 'right', 'align' => 'text-justify', 'box' => 'right:14.8%;top:25.3%;width:22%' ),
			array( 'side' => 'left',  'align' => 'text-justify', 'box' => 'left:26.1%;top:2.7%;width:22%' ),
		);
		?>
		<section id="hanh-trinh-phat-trien" aria-labelledby="ve-ecs-journey-heading" class="ecs-ve-journey">
			<div class="ecs-ve-journey__inner">
				<div data-aos="fade-up">
					<?php
					ecsges_section_heading(
						array(
							'id'     => 've-ecs-journey-heading',
							'lines'  => array( 'HÀNH TRÌNH PHÁT TRIỂN' ),
							'accent' => array(),
							'align'  => 'center',
						)
					);
					?>
				</div>
				<div class="ecs-ve-journey__intro" data-aos="fade-up" data-aos-delay="100">
					<img src="<?php echo esc_url( ecsges_img( 've-ecs/icon-journey.svg' ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-journey__intro-icon">
					<p class="ecs-ve-journey__intro-text"><?php echo esc_html( $intro ); ?></p>
				</div>
			</div>

			<!-- Desktop: mốc đặt quanh ảnh cầu thang -->
			<div class="ecs-ve-journey__stage">
				<img src="<?php echo esc_url( $stairs ); ?>" alt="Biểu đồ tăng trưởng của ECSGES qua các giai đoạn, trên nền bản đồ thế giới" class="ecs-ve-journey__stairs-img">
				<?php foreach ( $milestones as $i => $m ) : ?>
					<?php $pos = $positions[ $i ]; ?>
					<div class="ecs-ve-journey__milestone ecs-ve-journey__milestone--<?php echo 'right' === $pos['side'] ? 'right' : 'left'; ?>" style="<?php echo esc_attr( $pos['box'] ); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $i * 120 ); ?>">
						<p class="ecs-ve-journey__year"><?php echo esc_html( $m['years'] ); ?></p>
						<h3 class="ecs-ve-journey__milestone-title"><?php echo esc_html( $m['title'] ); ?></h3>
						<p class="ecs-ve-journey__milestone-body ecs-ve-journey__milestone-body--<?php echo 'text-right' === $pos['align'] ? 'right' : 'justify'; ?>"><?php echo esc_html( $m['body'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Mobile/tablet: ảnh trên, mốc xếp dọc -->
			<div class="ecs-ve-journey__mobile">
				<img src="<?php echo esc_url( $stairs ); ?>" alt="Biểu đồ tăng trưởng của ECSGES qua các giai đoạn" class="ecs-ve-journey__mobile-img">
				<div class="ecs-ve-journey__mobile-list">
					<?php foreach ( $milestones as $mi => $m ) : ?>
						<div data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $mi * 80 ); ?>">
							<p class="ecs-ve-journey__mobile-year"><?php echo esc_html( $m['years'] ); ?></p>
							<h3 class="ecs-ve-journey__mobile-title"><?php echo esc_html( $m['title'] ); ?></h3>
							<p class="ecs-ve-journey__mobile-body"><?php echo esc_html( $m['body'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- ==================== Tầm nhìn + Sứ mệnh ==================== -->
		<?php
		$vision  = ecsges_ve_ecs_vision();
		$mission = ecsges_tr_deep( ecsges_ve_ecs_mission() );
		?>
		<section aria-label="Tầm nhìn và sứ mệnh" class="ecs-ve-vm">
			<div class="ecs-ve-vm__inner">
				<!-- Tầm nhìn — chữ trái, ảnh phải -->
				<div class="ecs-ve-vm__row">
					<div data-aos="fade-up">
						<?php
						ecsges_section_heading(
							array(
								'lines'  => array( 'TẦM NHÌN' ),
								'accent' => array(),
							)
						);
						?>
						<p class="ecs-ve-vm__text"><?php echo esc_html( $vision ); ?></p>
					</div>
					<img src="<?php echo esc_url( ecsges_img( 've-ecs/ve-ecs-vision.png' ) ); ?>" alt="Tầm nhìn ECSGES" loading="lazy" data-aos="fade-up" data-aos-delay="100" class="ecs-ve-vm__img">
				</div>

				<!-- Sứ mệnh — ảnh trái, chữ phải -->
				<div class="ecs-ve-vm__row">
					<div class="ecs-ve-vm__row-text ecs-ve-vm__row-text--mission" data-aos="fade-up">
						<?php
						ecsges_section_heading(
							array(
								'lines'  => array( 'SỨ MỆNH' ),
								'accent' => array(),
							)
						);
						?>
						<?php foreach ( $mission as $para ) : ?>
							<p class="ecs-ve-vm__text"><?php echo esc_html( $para ); ?></p>
						<?php endforeach; ?>
					</div>
					<img src="<?php echo esc_url( ecsges_img( 've-ecs/ve-ecs-mission.png' ) ); ?>" alt="Sứ mệnh ECSGES" loading="lazy" data-aos="fade-up" data-aos-delay="100" class="ecs-ve-vm__img ecs-ve-vm__img--mission">
				</div>
			</div>
		</section>

		<!-- ======================= Giá trị cốt lõi ======================= -->
		<?php
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

		<!-- ==================== Những con số ấn tượng ==================== -->
		<?php
		$stats = ecsges_tr_deep( ecsges_ve_ecs_stats() );
		?>
		<section aria-labelledby="ve-ecs-stats-heading" class="ecs-ve-stats">
			<div class="ecs-ve-stats__inner">
				<div data-aos="fade-up">
					<?php
					ecsges_section_heading(
						array(
							'id'     => 've-ecs-stats-heading',
							'lines'  => array( 'NHỮNG CON SỐ ẤN TƯỢNG' ),
							'accent' => array(),
							'align'  => 'center',
						)
					);
					?>
				</div>

				<dl class="ecs-ve-stats__grid">
					<?php foreach ( $stats as $si => $stat ) : ?>
						<div class="ecs-ve-stats__item" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $si * 80 ); ?>">
							<img src="<?php echo esc_url( ecsges_img( 've-ecs/last-section/' . $stat['icon'] ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-stats__icon">
							<dd class="ecs-ve-stats__value"><?php echo esc_html( $stat['value'] ); ?></dd>
							<dt class="ecs-ve-stats__label"><?php echo esc_html( $stat['label'] ); ?></dt>
						</div>
					<?php endforeach; ?>
				</dl>
			</div>
		</section>

	</main>
<?php
get_footer();
