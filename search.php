<?php
/**
 * Trang kết quả tìm kiếm (/?s=tu-khoa) — mở từ ô tìm kiếm ở header. Dùng lại
 * đúng bố cục lưới 3 cột của template-parts/tin-tuc-grid.php (trang Tin tức):
 * không có sidebar, chỉ khác không có banner/tab list.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_term  = get_search_query();
$ecsges_found = (int) $GLOBALS['wp_query']->found_posts;

get_header();
?>
	<main class="ecs-archive ecs-archive--search">
		<?php ecsges_breadcrumb(); ?>
		<div class="ecs-archive__inner">
			<header class="ecs-archive__head">
				<h1 class="ecs-archive__title">
					<?php echo esc_html( ecsges_t( 'Kết quả tìm kiếm' ) ); ?>
					<?php if ( '' !== $ecsges_term ) : ?>
						<span class="ecs-archive__term">&ldquo;<?php echo esc_html( $ecsges_term ); ?>&rdquo;</span>
					<?php endif; ?>
				</h1>

				<p class="ecs-archive__count">
					<?php
					printf(
						/* translators: %d = số kết quả tìm được. */
						esc_html( ecsges_t( 'Tìm thấy %d kết quả.' ) ),
						absint( $ecsges_found )
					);
					?>
				</p>

				<?php get_search_form(); ?>
			</header>

			<?php if ( have_posts() ) : ?>
				<ul class="ecs-news-grid__list">
					<?php
					while ( have_posts() ) :
						the_post();
						// Nhãn chuyên mục — cùng kiểu card với tin-tuc-grid.php.
						$ecsges_cats  = get_the_category();
						$ecsges_label = ! empty( $ecsges_cats ) ? $ecsges_cats[0]->name : '';
						?>
						<li class="ecs-news-grid__item">
							<article class="ecs-news-card">
								<a href="<?php the_permalink(); ?>" class="ecs-news-card__media" tabindex="-1" aria-hidden="true">
									<img
										src="<?php echo esc_url( ecsges_post_thumb( get_the_ID(), 'large' ) ); ?>"
										alt=""
										loading="lazy"
										decoding="async"
										class="ecs-news-card__img">
								</a>
								<div class="ecs-news-card__body">
									<?php if ( '' !== $ecsges_label ) : ?>
										<p class="ecs-news-card__cat"><?php echo esc_html( $ecsges_label ); ?></p>
									<?php endif; ?>
									<h2 class="ecs-news-card__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>
									<p class="ecs-news-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
									<div class="ecs-news-card__foot">
										<span class="ecs-news-card__date"><?php echo esc_html( ecsges_post_time( null, 'd/m/Y' ) ); ?></span>
										<a href="<?php the_permalink(); ?>" class="ecs-news-card__more"><?php echo esc_html( ecsges_t( 'Xem thêm' ) ); ?></a>
									</div>
								</div>
							</article>
						</li>
					<?php endwhile; ?>
				</ul>

				<?php
				// Dãy nút số trang tròn — ĐÚNG markup với tin-tuc-grid.php (paginate_links
				// dạng array thay vì the_posts_pagination(), để cùng CSS .ecs-news-grid__pagination).
				$ecsges_total_pages = (int) $GLOBALS['wp_query']->max_num_pages;
				if ( $ecsges_total_pages > 1 ) :
					$ecsges_page_links = paginate_links(
						array(
							'current'   => max( 1, (int) get_query_var( 'paged' ) ),
							'total'     => $ecsges_total_pages,
							'mid_size'  => 2,
							'end_size'  => 1,
							'prev_next' => false,
							'type'      => 'array',
						)
					);
					if ( ! empty( $ecsges_page_links ) ) :
						?>
						<nav class="ecs-news-grid__pagination" aria-label="<?php echo esc_attr( ecsges_t( 'Phân trang' ) ); ?>">
							<ul class="ecs-news-grid__pages">
								<?php foreach ( $ecsges_page_links as $ecsges_page_link ) : ?>
									<li class="ecs-news-grid__page"><?php echo wp_kses_post( $ecsges_page_link ); ?></li>
								<?php endforeach; ?>
							</ul>
						</nav>
						<?php
					endif;
				endif;
				?>
			<?php else : ?>
				<p class="ecs-archive__empty"><?php echo esc_html( ecsges_t( 'Không tìm thấy nội dung nào phù hợp. Hãy thử từ khoá khác.' ) ); ?></p>
			<?php endif; ?>
		</div>
	</main>
<?php
get_footer();
