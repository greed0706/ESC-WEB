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

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main>

	<!-- ============================ Hero ============================ -->
	<?php
	get_template_part(
		'template-parts/page',
		'hero',
		array(
			'title' => 'GIỚI THIỆU VỀ ECS',
			'id' => 'top',
			'bg' => 'banner-page.png',
			'variant' => 'banner',
			'banner_title' => true,
		)
	);
	?>

	<!-- ==================== Hành trình phát triển ==================== -->
	<?php
	$milestones = ecsges_tr_deep(ecsges_milestones());
	$intro = ecsges_ve_ecs_intro();
	$stairs = ecsges_img('ve-ecs/ve-ecs-journey-stairs.png');

	// Vị trí từng mốc (% theo khung 1920×1416). side: neo trái/phải; align: canh chữ body.
	//
	// Thẻ được đẩy RA XA tâm và nới rộng để chứa cỡ chữ 28/18px. Cách tính: giảm
	// left (thẻ trái) / right (thẻ phải) để dịch ra mép, đồng thời tăng width
	// đúng bằng lượng đã giảm — nhờ vậy MÉP TRONG (phía ảnh bậc thang) gần như
	// đứng yên, chữ không lấn vào ảnh:
	//   trái:  left 16.8% + w 19%  ->  left 11% + w 24%   (mép phải 35.8% -> 35%)
	//   phải:  right 15.8% + w 21% ->  right 10% + w 25%  (mép trái 63.2% -> 65%)
	$positions = array(
		array('side' => 'left', 'align' => 'text-justify', 'box' => 'left:8%;top:71%;width:23%'),
		array('side' => 'right', 'align' => 'text-justify', 'box' => 'right:10%;top:59.8%;width:25%'),
		array('side' => 'left', 'align' => 'text-justify', 'box' => 'left:10%;top:34.5%;width:24%'),
		array('side' => 'right', 'align' => 'text-justify', 'box' => 'right:10%;top:20.3%;width:26%'),
		array('side' => 'left', 'align' => 'text-justify', 'box' => 'left:20%;top:2.7%;width:26%'),
	);
	?>
	<section id="hanh-trinh-phat-trien" aria-labelledby="ve-ecs-journey-heading" class="ecs-ve-journey">
		<div class="ecs-ve-journey__inner">
			<div data-aos="fade-up">
				<?php
				ecsges_section_heading(
					array(
						'id' => 've-ecs-journey-heading',
						'lines' => array('HÀNH TRÌNH PHÁT TRIỂN'),
						'accent' => array(),
						'align' => 'center',
					)
				);
				?>
			</div>
			<div class="ecs-ve-journey__intro" data-aos="fade-up" data-aos-delay="100">
				<img src="<?php echo esc_url(ecsges_img('ve-ecs/icon-journey.svg')); ?>" alt="" aria-hidden="true"
					class="ecs-ve-journey__intro-icon">
				<p class="ecs-ve-journey__intro-text"><?php echo esc_html($intro); ?></p>
			</div>
		</div>

		<!-- Desktop: mốc đặt quanh ảnh cầu thang -->
		<div class="ecs-ve-journey__stage">
			<img src="<?php echo esc_url($stairs); ?>"
				alt="<?php echo esc_attr(ecsges_t('Biểu đồ tăng trưởng của ECSGES qua các giai đoạn, trên nền bản đồ thế giới')); ?>"
				class="ecs-ve-journey__stairs-img">
			<?php foreach ($milestones as $i => $m): ?>
				<?php $pos = $positions[$i]; ?>
				<div class="ecs-ve-journey__milestone ecs-ve-journey__milestone--<?php echo 'right' === $pos['side'] ? 'right' : 'left'; ?>"
					style="<?php echo esc_attr($pos['box']); ?>" data-aos="fade-up"
					data-aos-delay="<?php echo esc_attr($i * 120); ?>">
					<p class="ecs-ve-journey__year"><?php echo esc_html($m['years']); ?></p>
					<h3 class="ecs-ve-journey__milestone-title"><?php echo esc_html($m['title']); ?></h3>
					<p
						class="ecs-ve-journey__milestone-body ecs-ve-journey__milestone-body--<?php echo 'text-right' === $pos['align'] ? 'right' : 'justify'; ?>">
						<?php echo esc_html($m['body']); ?>
					</p>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Mobile/tablet: ảnh trên, mốc xếp dọc -->
		<div class="ecs-ve-journey__mobile">
			<img src="<?php echo esc_url($stairs); ?>"
				alt="<?php echo esc_attr(ecsges_t('Biểu đồ tăng trưởng của ECSGES qua các giai đoạn')); ?>"
				class="ecs-ve-journey__mobile-img">
			<div class="ecs-ve-journey__mobile-list">
				<?php foreach ($milestones as $mi => $m): ?>
					<div data-aos="fade-up" data-aos-delay="<?php echo esc_attr($mi * 80); ?>">
						<p class="ecs-ve-journey__mobile-year"><?php echo esc_html($m['years']); ?></p>
						<h3 class="ecs-ve-journey__mobile-title"><?php echo esc_html($m['title']); ?></h3>
						<p class="ecs-ve-journey__mobile-body"><?php echo esc_html($m['body']); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ==================== Tầm nhìn + Sứ mệnh ==================== -->
	<?php
	$vision = ecsges_ve_ecs_vision();
	$mission = ecsges_tr_deep(ecsges_ve_ecs_mission());
	?>
	<section aria-label="Tầm nhìn và sứ mệnh" class="ecs-ve-vm">
		<div class="ecs-ve-vm__inner">
			<!-- Tầm nhìn — chữ trái, ảnh phải -->
			<div id="tam-nhin" class="ecs-ve-vm__row">
				<div data-aos="fade-up">
					<?php
					ecsges_section_heading(
						array(
							'lines' => array('TẦM NHÌN'),
							'accent' => array(),
						)
					);
					?>
					<p class="ecs-ve-vm__text"><?php echo esc_html($vision); ?></p>
				</div>
				<img src="<?php echo esc_url(ecsges_img('ve-ecs/tam-nhin.png')); ?>"
					alt="<?php echo esc_attr(ecsges_t('Tầm nhìn ECSGES')); ?>" loading="lazy" data-aos="fade-up"
					data-aos-delay="100" class="ecs-ve-vm__img">
			</div>

			<!-- Sứ mệnh — ảnh trái, chữ phải -->
			<div id="su-menh" class="ecs-ve-vm__row">
				<div class="ecs-ve-vm__row-text ecs-ve-vm__row-text--mission" data-aos="fade-up">
					<?php
					ecsges_section_heading(
						array(
							'lines' => array('SỨ MỆNH'),
							'accent' => array(),
						)
					);
					?>
					<?php foreach ($mission as $para): ?>
						<p class="ecs-ve-vm__text"><?php echo esc_html($para); ?></p>
					<?php endforeach; ?>
				</div>
				<img src="<?php echo esc_url(ecsges_img('ve-ecs/su-menh.png')); ?>"
					alt="<?php echo esc_attr(ecsges_t('Sứ mệnh ECSGES')); ?>" loading="lazy" data-aos="fade-up"
					data-aos-delay="100" class="ecs-ve-vm__img ecs-ve-vm__img--mission">
			</div>
		</div>
	</section>

	<!-- ======================= Giá trị cốt lõi ======================= -->
	<?php
	$values = array();
	foreach (ecsges_core_values() as $v) {
		$values[$v['key']] = $v;
	}

	$wedge_fills = array(
		array('src' => 'bg/bg-tam.svg', 'left' => '38.2%', 'top' => '76.3%', 'width' => '10%'),
		array('src' => 'bg/bg-ben.svg', 'left' => '41.9%', 'top' => '63.4%', 'width' => '10.6%'),
		array('src' => 'bg/bg-hop.svg', 'left' => '50.2%', 'top' => '59.3%', 'width' => '9.7%'),
		array('src' => 'bg/bg-tri.svg', 'left' => '58.4%', 'top' => '63.5%', 'width' => '10.6%'),
		array('src' => 'bg/bg-sang.svg', 'left' => '62.2%', 'top' => '76.2%', 'width' => '10%'),
	);
	$fan_box = 'left:32.97%;top:48.6%;width:34.375%;height:38.4%';
	$icons = array(
		array('key' => 'TÂM', 'src' => 'tam.svg', 'left' => '37.6%', 'top' => '79%', 'width' => '4.06%'),
		array('key' => 'BỀN', 'src' => 'ben.svg', 'left' => '42.8%', 'top' => '64.5%', 'width' => '3.54%'),
		array('key' => 'HỢP', 'src' => 'hop.svg', 'left' => '50.2%', 'top' => '59%', 'width' => '3.59%'),
		array('key' => 'TRÍ', 'src' => 'tri.svg', 'left' => '57.2%', 'top' => '64.5%', 'width' => '3.28%'),
		array('key' => 'SÁNG', 'src' => 'sang.svg', 'left' => '62.0%', 'top' => '78.75%', 'width' => '3.59%'),
	);
	$arrows = array(
		array('src' => 'arrow/arrow-hop.svg', 'left' => '50%', 'top' => '45.6%', 'width' => '2.92%'),
		array('src' => 'arrow/arrow-ben.svg', 'left' => '39.0%', 'top' => '54.3%', 'width' => '4.06%'),
		array('src' => 'arrow/arrow-tri.svg', 'left' => '61.5%', 'top' => '53.8%', 'width' => '4.06%'),
		array('src' => 'arrow/arrow-tam.svg', 'left' => '32.3%', 'top' => '76.6%', 'width' => '3.59%'),
		array('src' => 'arrow/arrow-sang.svg', 'left' => '68.0%', 'top' => '75.5%', 'width' => '3.59%'),
	);
	$labels = array(
		// left = TÂM của ô (ô có translate:-50% 0), tính theo % khung quạt.
		//
		// Số đo Figma (node 7:1756, khung 1920x852) KHÔNG bê nguyên được: khung
		// quạt co theo màn hình còn chữ đã cố định 28/18px + dãn dòng 32px, nên ở
		// 1521px các khối chữ cao gấp ~1,4 lần Figma và tràn vào hình quạt.
		// Bù lại bằng cách NỚI RỘNG ô (bớt 1-2 dòng mỗi khối) và ĐẨY RA MÉP:
		//   - trái  : mép phải <= 32%   (hình quạt bắt đầu ở 32,97%)
		//   - phải  : mép trái  >= 67%  (hình quạt kết thúc ở 67,34%)
		//   - HỢP   : đáy <= 48%        (đỉnh hình quạt ở 48,6%)
		array('key' => 'TÂM', 'left' => '22%', 'top' => '70%', 'width' => '10%'),
		array('key' => 'BỀN', 'left' => '30%', 'top' => '40%', 'width' => '10%'),
		array('key' => 'HỢP', 'left' => '50%', 'top' => '28%', 'width' => '22.5%'),
		array('key' => 'TRÍ', 'left' => '70%', 'top' => '40%', 'width' => '10%'),
		array('key' => 'SÁNG', 'left' => '78%', 'top' => '67%', 'width' => '10%'),
	);
	// Cỡ chữ của nhãn hình quạt KHÔNG còn đặt inline (trước đây là clamp cqw
	// co giãn theo container) — đã chuyển hẳn sang thang cỡ chữ cố định trong
	// src/scss/components/_ve-ecs.scss (.ecs-ve-values__label-*). Inline style
	// ở đây chỉ còn lo phần vị trí/kích thước tính bằng %.
	$centered = 'transform:translate(-50%, -50%)';
	?>
	<section id="gia-tri-cot-loi" aria-labelledby="ve-ecs-values-heading" class="ecs-ve-values">
		<!-- Desktop: hình quạt -->
		<div class="ecs-ve-values__fan" style="container-type:inline-size;aspect-ratio:1920 / 852" data-aos="fade-up">
			<h2 id="ve-ecs-values-heading" class="ecs-ve-values__heading">
				<?php echo esc_html(ecsges_t('GIÁ TRỊ CỐT LÕI')); ?>
			</h2>

			<?php // Cụm hình quạt (nền cánh + viền + icon + mũi tên) bọc chung 1 lớp để
			// phóng to như MỘT KHỐI bằng transform trong SCSS (.ecs-ve-values__art),
			// khỏi phải tính lại toạ độ % của từng phần tử. Lớp bọc phủ đúng khung
			// cha (inset:0) nên mọi % bên trong giữ nguyên ý nghĩa. ?>
			<div class="ecs-ve-values__art" aria-hidden="true">
				<?php foreach ($wedge_fills as $f): ?>
					<img src="<?php echo esc_url(ecsges_img('ve-ecs/' . $f['src'])); ?>" alt="" aria-hidden="true"
						class="ecs-ve-values__wedge"
						style="left:<?php echo esc_attr($f['left']); ?>;top:<?php echo esc_attr($f['top']); ?>;width:<?php echo esc_attr($f['width']); ?>;<?php echo esc_attr($centered); ?>">
				<?php endforeach; ?>

				<img src="<?php echo esc_url(ecsges_img('ve-ecs/list.svg')); ?>" alt="" aria-hidden="true"
					class="ecs-ve-values__fan-img" style="<?php echo esc_attr($fan_box); ?>">

				<?php foreach ($icons as $ic): ?>
					<img src="<?php echo esc_url(ecsges_img('ve-ecs/' . $ic['src'])); ?>" alt="" aria-hidden="true"
						class="ecs-ve-values__icon"
						style="left:<?php echo esc_attr($ic['left']); ?>;top:<?php echo esc_attr($ic['top']); ?>;width:<?php echo esc_attr($ic['width']); ?>;<?php echo esc_attr($centered); ?>">
				<?php endforeach; ?>

				<?php foreach ($arrows as $a): ?>
					<img src="<?php echo esc_url(ecsges_img('ve-ecs/' . $a['src'])); ?>" alt="" aria-hidden="true"
						class="ecs-ve-values__arrow"
						style="left:<?php echo esc_attr($a['left']); ?>;top:<?php echo esc_attr($a['top']); ?>;width:<?php echo esc_attr($a['width']); ?>;<?php echo esc_attr($centered); ?>">
				<?php endforeach; ?>
			</div>

			<?php
			foreach ($labels as $lb):
				$v = $values[$lb['key']];
				?>
				<div class="ecs-ve-values__label"
					style="left:<?php echo esc_attr($lb['left']); ?>;top:<?php echo esc_attr($lb['top']); ?>;width:<?php echo esc_attr($lb['width']); ?>">
					<p class="ecs-ve-values__label-key"><?php echo esc_html(ecsges_t($v['key'])); ?></p>
					<p class="ecs-ve-values__label-phrase"><?php echo esc_html(ecsges_t($v['phrase'])); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Mobile/tablet: icon + chữ xếp dọc -->
		<div class="ecs-ve-values__mobile">
			<div data-aos="fade-up">
				<?php
				ecsges_section_heading(
					array(
						'lines' => array('GIÁ TRỊ CỐT LÕI'),
						'accent' => array(),
						'align' => 'center',
						'tone' => 'light',
					)
				);
				?>
			</div>
			<div class="ecs-ve-values__grid">
				<?php
				foreach ($icons as $mi => $ic):
					$v = $values[$ic['key']];
					?>
					<div class="ecs-ve-values__item" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($mi * 80); ?>">
						<img src="<?php echo esc_url(ecsges_img('ve-ecs/' . $ic['src'])); ?>" alt="" aria-hidden="true"
							class="ecs-ve-values__item-icon">
						<p class="ecs-ve-values__item-key"><?php echo esc_html(ecsges_t($v['key'])); ?></p>
						<p class="ecs-ve-values__item-phrase"><?php echo esc_html(ecsges_t($v['phrase'])); ?></p>
						<p class="ecs-ve-values__item-body"><?php echo esc_html(ecsges_t($v['body'])); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ==================== Những con số ấn tượng ==================== -->
	<?php
	$stats = ecsges_tr_deep(ecsges_ve_ecs_stats());
	?>
	<section id="nhung-con-so-an-tuong" aria-labelledby="ve-ecs-stats-heading" class="ecs-ve-stats">
		<div class="ecs-ve-stats__inner">
			<div data-aos="fade-up">
				<?php
				ecsges_section_heading(
					array(
						'id' => 've-ecs-stats-heading',
						'lines' => array('NHỮNG CON SỐ ẤN TƯỢNG'),
						'accent' => array(),
						'align' => 'center',
					)
				);
				?>
			</div>

			<?php
			// data-stats-odometer: mốc để initStatsOdometer() (assets/js/main.js) gắn
			// IntersectionObserver. Giá trị vẫn in ra dạng text thật — JS mới là thứ
			// dựng các cột chữ số, nên tắt JS thì con số vẫn hiện đúng, không vỡ.
			?>
			<dl class="ecs-ve-stats__grid" data-stats-odometer>
				<?php foreach ($stats as $si => $stat): ?>
					<div class="ecs-ve-stats__item" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($si * 80); ?>">
						<img src="<?php echo esc_url(ecsges_img('ve-ecs/last-section/' . $stat['icon'])); ?>" alt=""
							aria-hidden="true" class="ecs-ve-stats__icon">
						<dd class="ecs-ve-stats__value" data-odometer><?php echo esc_html($stat['value']); ?></dd>
						<dt class="ecs-ve-stats__label"><?php echo esc_html($stat['label']); ?></dt>
					</div>
				<?php endforeach; ?>
			</dl>
		</div>
	</section>

</main>
<?php
get_footer();
