<?php
/**
 * Archive category (vd /category/tin-tuc/). Bố cục: cột trái danh sách bài,
 * cột phải sidebar sticky "TIN TỨC - THÔNG BÁO" (bài mới nhất toàn site).
 * Ngày = ACF 'time' nếu có, ngược lại ngày đăng (ecsges_post_time).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-archive">
		<div class="ecs-archive__inner">
			<?php
			// Breadcrumb: Trang chủ / (chuyên mục cha) / chuyên mục hiện tại.
			$ecsges_cat       = get_queried_object();
			$ecsges_ancestors = ( $ecsges_cat instanceof WP_Term ) ? array_reverse( get_ancestors( $ecsges_cat->term_id, 'category', 'taxonomy' ) ) : array();
			?>
			<nav class="ecs-archive__breadcrumb" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( ecsges_t( 'Trang chủ' ) ); ?></a>
				<?php foreach ( $ecsges_ancestors as $ecsges_ancestor_id ) : ?>
					<span aria-hidden="true">/</span>
					<a href="<?php echo esc_url( get_category_link( $ecsges_ancestor_id ) ); ?>"><?php echo esc_html( get_cat_name( $ecsges_ancestor_id ) ); ?></a>
				<?php endforeach; ?>
				<span aria-hidden="true">/</span>
				<span class="ecs-archive__breadcrumb-current" aria-current="page"><?php echo esc_html( single_cat_title( '', false ) ); ?></span>
			</nav>

			<header class="ecs-archive__head">
				<h1 class="ecs-archive__title"><?php single_cat_title(); ?></h1>
			</header>

			<div class="ecs-archive__layout">
				<!-- Cột trái: danh sách bài -->
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
						<p class="ecs-archive__empty"><?php esc_html_e( 'Chưa có bài viết.', 'ecsges' ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Cột phải: sidebar sticky (dùng chung với single.php) -->
				<?php get_template_part( 'template-parts/news', 'sidebar' ); ?>
			</div>
		</div>
	</main>
<?php
get_footer();
