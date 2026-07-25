<?php
/**
 * Trang kết quả tìm kiếm (/?s=tu-khoa) — mở từ ô tìm kiếm ở header.
 * Dùng lại đúng bố cục của category.php: cột trái danh sách kết quả, cột phải
 * sidebar sticky "TIN TỨC - THÔNG BÁO".
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

			<div class="ecs-archive__layout">
				<!-- Cột trái: danh sách kết quả -->
				<div class="ecs-archive__main">
					<?php if ( have_posts() ) : ?>
						<?php
						while ( have_posts() ) :
							the_post();
							?>
							<article <?php post_class( 'ecs-archive__card' ); ?>>
								<a href="<?php the_permalink(); ?>" class="ecs-archive__card-media">
									<img src="<?php echo esc_url( ecsges_post_thumb( get_the_ID(), 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="ecs-archive__card-img">
								</a>
								<div class="ecs-archive__card-body">
									<h2 class="ecs-archive__card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<div class="ecs-archive__card-meta">
										<span class="ecs-archive__card-date"><?php echo esc_html( ecsges_post_time() ); ?></span>
									</div>
									<p class="ecs-archive__card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
									<?php ecsges_see_more( get_permalink(), 'Xem thêm' ); ?>
								</div>
							</article>
						<?php endwhile; ?>

						<div class="ecs-archive__pagination">
							<?php
							the_posts_pagination(
								array(
									'mid_size'  => 1,
									'prev_text' => '‹',
									'next_text' => '›',
								)
							);
							?>
						</div>
					<?php else : ?>
						<p class="ecs-archive__empty"><?php echo esc_html( ecsges_t( 'Không tìm thấy nội dung nào phù hợp. Hãy thử từ khoá khác.' ) ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Cột phải: sidebar sticky (giống category.php) -->
				<aside class="ecs-archive__sidebar">
					<div class="ecs-archive__widget">
						<h2 class="ecs-archive__widget-title"><?php echo esc_html( ecsges_t( 'TIN TỨC - THÔNG BÁO' ) ); ?></h2>
						<ul class="ecs-archive__widget-list">
							<?php
							$ecsges_recent = new WP_Query(
								array(
									'post_type'           => 'post',
									'posts_per_page'      => 3,
									'ignore_sticky_posts' => true,
									'no_found_rows'       => true,
								)
							);
							while ( $ecsges_recent->have_posts() ) :
								$ecsges_recent->the_post();
								?>
								<li class="ecs-archive__widget-item">
									<a href="<?php the_permalink(); ?>" class="ecs-archive__widget-thumb">
										<img src="<?php echo esc_url( ecsges_post_thumb( get_the_ID(), 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
									</a>
									<div class="ecs-archive__widget-text">
										<a href="<?php the_permalink(); ?>" class="ecs-archive__widget-link"><?php the_title(); ?></a>
										<span class="ecs-archive__widget-date"><?php echo esc_html( ecsges_post_time() ); ?></span>
									</div>
								</li>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</ul>
					</div>
				</aside>
			</div>
		</div>
	</main>
<?php
get_footer();
