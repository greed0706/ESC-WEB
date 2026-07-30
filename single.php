<?php
/**
 * Single post. Ảnh đại diện + tiêu đề + ngày (ACF 'time' hoặc ngày đăng) + nội dung.
 * Bên phải: sidebar sticky bài mới nhất (dùng chung phong cách archive).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-single">
		<div class="ecs-single__inner">
			<div class="ecs-single__layout">
				<div class="ecs-single__main">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article <?php post_class( 'ecs-single__article' ); ?>>
							<nav class="ecs-single__breadcrumb" aria-label="Breadcrumb">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( ecsges_t( 'Trang chủ' ) ); ?></a>
								<?php
								$ecsges_cats = get_the_category();
								if ( ! empty( $ecsges_cats ) ) :
									?>
									<span aria-hidden="true">/</span>
									<a href="<?php echo esc_url( get_category_link( $ecsges_cats[0]->term_id ) ); ?>"><?php echo esc_html( $ecsges_cats[0]->name ); ?></a>
								<?php endif; ?>
								<span aria-hidden="true">/</span>
								<span class="ecs-single__breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
							</nav>

							<h1 class="ecs-single__title"><?php the_title(); ?></h1>
							<div class="ecs-single__meta">
								<span class="ecs-single__date"><?php echo esc_html( ecsges_post_time() ); ?></span>
							</div>

							<div class="ecs-single__content">
								<?php the_content(); ?>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>

				<!-- Sidebar sticky -->
				<aside class="ecs-single__sidebar ecs-archive__sidebar">
					<div class="ecs-archive__widget">
						<h2 class="ecs-archive__widget-title"><?php echo esc_html( ecsges_t( 'TIN TỨC - THÔNG BÁO' ) ); ?></h2>
						<ul class="ecs-archive__widget-list">
							<?php
							$ecsges_recent = new WP_Query(
								array(
									'post_type'           => 'post',
									'posts_per_page'      => 3,
									'post__not_in'        => array( get_the_ID() ),
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
