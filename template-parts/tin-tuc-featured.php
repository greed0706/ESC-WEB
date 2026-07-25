<?php
/**
 * Trang Tin tức — khối "TIN NỔI BẬT" (Figma node 548:9518, y 881–1699).
 *
 * Cột trái: 1 bài lớn (ảnh 816x488 → title 40px → excerpt 28px).
 * Cột phải: 2 bài nhỏ (ảnh 413x247 → title 22px). Gap 2 cột = 44px.
 * Cả 3 ảnh cùng tỉ lệ 816/488 = 413/247 = 1.672.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tt_featured = ecsges_tr_deep( ecsges_news_featured() );
$tt_main     = $tt_featured['main'];
$tt_side     = $tt_featured['side'];
?>
<section aria-labelledby="tin-noi-bat-heading" class="ecs-newsroom__section">
	<div class="ecs-newsroom__inner">
		<h2 id="tin-noi-bat-heading" class="ecs-newsroom__heading" data-aos="fade-up"><?php echo esc_html( ecsges_t( 'TIN NỔI BẬT' ) ); ?></h2>

		<div class="ecs-newsroom__featured" data-aos="fade-up" data-aos-delay="80">
			<article class="ecs-newsroom__lead">
				<a href="<?php echo esc_url( $tt_main['href'] ); ?>" class="ecs-newsroom__lead-media">
					<img src="<?php echo esc_url( ecsges_img( $tt_main['img'] ) ); ?>" alt="<?php echo esc_attr( $tt_main['title'] ); ?>" class="ecs-newsroom__img">
				</a>
				<h3 class="ecs-newsroom__lead-title">
					<a href="<?php echo esc_url( $tt_main['href'] ); ?>" class="ecs-newsroom__link"><?php echo esc_html( $tt_main['title'] ); ?></a>
				</h3>
				<p class="ecs-newsroom__lead-excerpt"><?php echo esc_html( $tt_main['excerpt'] ); ?></p>
			</article>

			<div class="ecs-newsroom__side">
				<?php foreach ( $tt_side as $item ) : ?>
					<article class="ecs-newsroom__side-item">
						<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-newsroom__side-media">
							<img src="<?php echo esc_url( ecsges_img( $item['img'] ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" class="ecs-newsroom__img">
						</a>
						<h3 class="ecs-newsroom__side-title">
							<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-newsroom__link"><?php echo esc_html( $item['title'] ); ?></a>
						</h3>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
