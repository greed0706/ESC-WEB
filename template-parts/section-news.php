<?php
/**
 * Section News (TIN TỨC). Lấy post động từ category "Tin tức" (ID 13).
 * Bố cục giống hệt khối "TIN NỔI BẬT" của trang Tin tức
 * (template-parts/tin-tuc-featured.php): 1 bài lớn (cột trái) + 2 bài nhỏ
 * (cột phải), dùng chung các class .ecs-newsroom__* — không có list/phân
 * trang riêng của trang chủ nữa.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_news_cat = 13; // category "Tin tức" (slug tin-tuc).
$ecsges_news_q   = new WP_Query(
	array(
		'post_type'           => 'post',
		'cat'                 => $ecsges_news_cat,
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
$ecsges_posts = $ecsges_news_q->posts;

if ( ! empty( $ecsges_posts ) ) :
	$ecsges_featured = $ecsges_posts[0];
	$ecsges_side     = array_slice( $ecsges_posts, 1, 2 );
	?>
<section id="tin-tuc" aria-labelledby="news-heading" class="ecs-news">
	<div class="ecs-news__inner">
		<div data-aos="fade-up">
			<?php
			ecsges_section_heading(
				array(
					'id'     => 'news-heading',
					'align'  => 'center',
					'lines'  => array( 'TIN TỨC' ),
					'accent' => array(),
					'class'  => 'ecs-news__heading',
				)
			);
			?>
		</div>

		<div class="ecs-newsroom__featured" data-aos="fade-up" data-aos-delay="80">
			<article class="ecs-newsroom__lead">
				<a href="<?php echo esc_url( get_permalink( $ecsges_featured ) ); ?>" class="ecs-newsroom__lead-media">
					<img src="<?php echo esc_url( ecsges_post_thumb( $ecsges_featured->ID, 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $ecsges_featured ) ); ?>" class="ecs-newsroom__img">
				</a>
				<h3 class="ecs-newsroom__lead-title">
					<a href="<?php echo esc_url( get_permalink( $ecsges_featured ) ); ?>" class="ecs-newsroom__link"><?php echo esc_html( get_the_title( $ecsges_featured ) ); ?></a>
				</h3>
				<p class="ecs-newsroom__lead-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $ecsges_featured ), 30 ) ); ?></p>
			</article>

			<div class="ecs-newsroom__side">
				<?php foreach ( $ecsges_side as $item ) : ?>
					<article class="ecs-newsroom__side-item">
						<a href="<?php echo esc_url( get_permalink( $item ) ); ?>" class="ecs-newsroom__side-media">
							<img src="<?php echo esc_url( ecsges_post_thumb( $item->ID, 'medium' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $item ) ); ?>" loading="lazy" class="ecs-newsroom__img">
						</a>
						<h3 class="ecs-newsroom__side-title">
							<a href="<?php echo esc_url( get_permalink( $item ) ); ?>" class="ecs-newsroom__link"><?php echo esc_html( get_the_title( $item ) ); ?></a>
						</h3>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
	<?php
	wp_reset_postdata();
endif;
