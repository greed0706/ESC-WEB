<?php
/**
 * Section News (TIN TỨC). Lấy post động từ category "Tin tức" (ID 13).
 * Ngày = ACF field 'time' nếu có, ngược lại fallback ngày đăng (ecsges_post_time).
 * Bài đầu = featured (lớn); các bài sau = list nhỏ phân trang bằng JS thuần.
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
		'posts_per_page'      => 21,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
$ecsges_posts = $ecsges_news_q->posts;

if ( ! empty( $ecsges_posts ) ) :
	$ecsges_featured = $ecsges_posts[0];
	$ecsges_rest     = array_slice( $ecsges_posts, 1 );
	$per_page        = 4;
	$pages           = $ecsges_rest ? array_chunk( $ecsges_rest, $per_page ) : array();
	$page_count      = count( $pages );
	$arrow           = ecsges_img( 'arrow.svg' );
	$archive_url     = get_category_link( $ecsges_news_cat );
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

		<div class="ecs-news__grid">
			<!-- Featured card -->
			<article class="ecs-news__featured" data-aos="fade-up">
				<div class="ecs-news__featured-media">
					<img src="<?php echo esc_url( ecsges_post_thumb( $ecsges_featured->ID, 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $ecsges_featured ) ); ?>" class="ecs-news__featured-img">
				</div>
				<div class="ecs-news__featured-body">
					<h3 class="ecs-news__featured-title"><a href="<?php echo esc_url( get_permalink( $ecsges_featured ) ); ?>" class="ecs-news__link"><?php echo esc_html( get_the_title( $ecsges_featured ) ); ?></a></h3>
					<p class="ecs-news__featured-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $ecsges_featured ), 30 ) ); ?></p>
					<div class="ecs-news__featured-footer">
						<span class="ecs-news__date"><?php echo esc_html( ecsges_post_time( $ecsges_featured->ID ) ); ?></span>
						<?php ecsges_see_more( get_permalink( $ecsges_featured ) ); ?>
					</div>
				</div>
			</article>

			<!-- List (paginated) -->
			<div class="ecs-news__list" data-aos="fade-up" data-aos-delay="120" data-news>
				<?php foreach ( $pages as $pi => $page ) : ?>
					<div data-news-page="<?php echo esc_attr( $pi ); ?>" class="ecs-news__page<?php echo 0 === $pi ? ' is-active' : ''; ?>">
						<?php foreach ( $page as $item ) : ?>
							<article class="ecs-news__item">
								<div class="ecs-news__item-media">
									<img src="<?php echo esc_url( ecsges_post_thumb( $item->ID, 'medium' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $item ) ); ?>" class="ecs-news__item-img">
								</div>
								<div class="ecs-news__item-body">
									<h3 class="ecs-news__item-title"><a href="<?php echo esc_url( get_permalink( $item ) ); ?>" class="ecs-news__link"><?php echo esc_html( get_the_title( $item ) ); ?></a></h3>
									<div class="ecs-news__item-footer">
										<span class="ecs-news__date"><?php echo esc_html( ecsges_post_time( $item->ID ) ); ?></span>
										<?php ecsges_see_more( get_permalink( $item ) ); ?>
									</div>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php if ( $page_count > 1 ) : ?>
			<!-- Pagination -->
			<div class="ecs-news__pagination" data-news-pagination data-page-count="<?php echo esc_attr( $page_count ); ?>">
				<button type="button" data-news-prev aria-label="Trang trước" class="ecs-news__arrow">
					<img src="<?php echo esc_url( $arrow ); ?>" alt="" class="ecs-news__arrow-img">
				</button>

				<div class="ecs-news__dots" role="tablist" aria-label="Trang tin tức">
					<?php for ( $i = 0; $i < $page_count; $i++ ) : ?>
						<button type="button" data-news-dot="<?php echo esc_attr( $i ); ?>" aria-label="Trang <?php echo esc_attr( $i + 1 ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" class="ecs-news__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"></button>
					<?php endfor; ?>
				</div>

				<button type="button" data-news-next aria-label="Trang sau" class="ecs-news__arrow">
					<img src="<?php echo esc_url( $arrow ); ?>" alt="" class="ecs-news__arrow-img ecs-news__arrow-img--next">
				</button>
			</div>
		<?php endif; ?>

		<div class="ecs-news__more" data-aos="fade-up">
			<a href="<?php echo esc_url( $archive_url ); ?>" class="ecs-news__more-link">Xem tất cả tin tức</a>
		</div>
	</div>
</section>
	<?php
	wp_reset_postdata();
endif;
