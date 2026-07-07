<?php
/**
 * Section News (port NewsSection.tsx + NewsCard + NewsListItem).
 * Phân trang bằng JS thuần thay cho React useState. Nội dung tĩnh (GĐ1).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_featured = ecsges_featured_news();
$ecsges_excerpt  = ecsges_news_excerpt();
$ecsges_items    = ecsges_news_items();
$ecsges_news_img = ecsges_img( 'news.png' );

$per_page   = 4;
$pages      = array_chunk( $ecsges_items, $per_page );
$page_count = count( $pages );
$arrow      = ecsges_img( 'arrow.svg' );
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
					<img src="<?php echo esc_url( $ecsges_news_img ); ?>" alt="<?php echo esc_attr( $ecsges_featured['title'] ); ?>" class="ecs-news__featured-img">
				</div>
				<div class="ecs-news__featured-body">
					<h3 class="ecs-news__featured-title"><a href="<?php echo esc_url( $ecsges_featured['href'] ); ?>" class="ecs-news__link"><?php echo esc_html( $ecsges_featured['title'] ); ?></a></h3>
					<p class="ecs-news__featured-excerpt"><?php echo esc_html( $ecsges_excerpt ); ?></p>
					<div class="ecs-news__featured-footer">
						<span class="ecs-news__date"><?php echo esc_html( $ecsges_featured['date'] ); ?></span>
						<?php ecsges_see_more( $ecsges_featured['href'] ); ?>
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
									<img src="<?php echo esc_url( $ecsges_news_img ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" class="ecs-news__item-img">
								</div>
								<div class="ecs-news__item-body">
									<h3 class="ecs-news__item-title"><a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-news__link"><?php echo esc_html( $item['title'] ); ?></a></h3>
									<div class="ecs-news__item-footer">
										<?php ecsges_see_more( $item['href'] ); ?>
									</div>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

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
	</div>
</section>
