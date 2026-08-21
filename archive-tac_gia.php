<?php
/**
 * Danh sách tác giả — /tac-gia/.
 *
 * Lưới thẻ: ảnh chân dung tròn, tên, chức danh, tóm tắt. Tóm tắt cắt từ field
 * "Tiểu sử" trong meta box — post type này không bật 'editor'/'excerpt'.
 *
 * Trang này cũng là đích chuyển hướng 301 của /author/{tài-khoản}/ — xem
 * ecsges_tg_redirect_user_archives() trong inc/tac-gia.php.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-author-list">
		<?php ecsges_breadcrumb(); ?>

		<div class="ecs-author-list__inner">
			<h1 class="ecs-author-list__title"><?php echo esc_html( ecsges_t( 'Đội ngũ tác giả' ) ); ?></h1>

			<?php if ( have_posts() ) : ?>
				<ul class="ecs-author-list__grid">
					<?php
					while ( have_posts() ) :
						the_post();
						$ecsges_photo = ecsges_tg_photo( get_the_ID(), 'medium' );
						$ecsges_role  = (string) get_post_meta( get_the_ID(), 'ecsges_tg_role', true );
						?>
						<li class="ecs-author-list__item">
							<article class="ecs-author-card">
								<a href="<?php the_permalink(); ?>" class="ecs-author-card__photo" tabindex="-1" aria-hidden="true">
									<?php if ( '' !== $ecsges_photo ) : ?>
										<img src="<?php echo esc_url( $ecsges_photo ); ?>" alt="" loading="lazy" decoding="async">
									<?php else : ?>
										<span class="ecs-author-card__fallback"><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span>
									<?php endif; ?>
								</a>

								<h2 class="ecs-author-card__name">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>

								<?php if ( '' !== $ecsges_role ) : ?>
									<p class="ecs-author-card__role"><?php echo esc_html( $ecsges_role ); ?></p>
								<?php endif; ?>

								<?php $ecsges_blurb = ecsges_tg_bio_excerpt( get_the_ID() ); ?>
								<?php if ( '' !== $ecsges_blurb ) : ?>
									<p class="ecs-author-card__excerpt"><?php echo esc_html( $ecsges_blurb ); ?></p>
								<?php endif; ?>
							</article>
						</li>
					<?php endwhile; ?>
				</ul>

				<?php
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
				<p class="ecs-author-list__empty"><?php echo esc_html( ecsges_t( 'Chưa có tác giả nào.' ) ); ?></p>
			<?php endif; ?>
		</div>
	</main>
<?php
get_footer();
