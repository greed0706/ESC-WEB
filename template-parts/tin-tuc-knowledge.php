<?php
/**
 * Trang Tin tức — khối "KIẾN THỨC" (Figma node 548:9518, y 1748–2502).
 *
 * Dải nền #f0f0f0 full-bleed, lưới 3 card/trang (card 408x426, ảnh 408x244),
 * phân trang bằng JS thuần: dùng lại initNewsPagination() trong assets/js/main.js
 * qua các attribute data-news / data-news-page / data-news-pagination / data-news-dot.
 *
 * LƯU Ý: initNewsPagination() dùng document.querySelector('[data-news]') nên chỉ
 * hỗ trợ MỘT khối phân trang trên mỗi trang. Trang chủ có section-news riêng, còn
 * trang này là template khác nên không xung đột — đừng đặt 2 khối trên cùng 1 trang.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tt_items = ecsges_tr_deep( ecsges_news_knowledge() );
if ( empty( $tt_items ) ) {
	return;
}

$tt_per_page = 3;
$tt_pages    = array_chunk( $tt_items, $tt_per_page );
$tt_count    = count( $tt_pages );
$tt_arrow    = ecsges_img( 'arrow.svg' );
?>
<section aria-labelledby="kien-thuc-heading" class="ecs-newsroom__knowledge">
	<div class="ecs-newsroom__inner">
		<h2 id="kien-thuc-heading" class="ecs-newsroom__heading" data-aos="fade-up"><?php echo esc_html( ecsges_t( 'KIẾN THỨC' ) ); ?></h2>

		<div data-news data-aos="fade-up" data-aos-delay="80">
			<?php foreach ( $tt_pages as $tt_pi => $tt_page ) : ?>
				<div data-news-page="<?php echo esc_attr( $tt_pi ); ?>" class="ecs-newsroom__grid<?php echo 0 === $tt_pi ? ' is-active' : ''; ?>">
					<?php foreach ( $tt_page as $item ) : ?>
						<article class="ecs-newsroom__card">
							<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-newsroom__card-media">
								<img src="<?php echo esc_url( ecsges_img( $item['img'] ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" class="ecs-newsroom__img">
							</a>
							<div class="ecs-newsroom__card-body">
								<h3 class="ecs-newsroom__card-title">
									<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-newsroom__link"><?php echo esc_html( $item['title'] ); ?></a>
								</h3>
								<p class="ecs-newsroom__card-excerpt"><?php echo esc_html( $item['excerpt'] ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if ( $tt_count > 1 ) : ?>
			<div class="ecs-news__pagination ecs-newsroom__pagination" data-news-pagination data-page-count="<?php echo esc_attr( $tt_count ); ?>">
				<button type="button" data-news-prev aria-label="<?php echo esc_attr( ecsges_t( 'Trang trước' ) ); ?>" class="ecs-news__arrow">
					<img src="<?php echo esc_url( $tt_arrow ); ?>" alt="" class="ecs-news__arrow-img">
				</button>

				<div class="ecs-news__dots" role="tablist" aria-label="<?php echo esc_attr( ecsges_t( 'Trang kiến thức' ) ); ?>">
					<?php for ( $tt_i = 0; $tt_i < $tt_count; $tt_i++ ) : ?>
						<button type="button" data-news-dot="<?php echo esc_attr( $tt_i ); ?>" aria-label="<?php echo esc_attr( sprintf( '%s %d', ecsges_t( 'Trang' ), $tt_i + 1 ) ); ?>" aria-selected="<?php echo 0 === $tt_i ? 'true' : 'false'; ?>" class="ecs-news__dot<?php echo 0 === $tt_i ? ' is-active' : ''; ?>"></button>
					<?php endfor; ?>
				</div>

				<button type="button" data-news-next aria-label="<?php echo esc_attr( ecsges_t( 'Trang sau' ) ); ?>" class="ecs-news__arrow">
					<img src="<?php echo esc_url( $tt_arrow ); ?>" alt="" class="ecs-news__arrow-img ecs-news__arrow-img--next">
				</button>
			</div>
		<?php endif; ?>
	</div>
</section>
