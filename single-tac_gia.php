<?php
/**
 * Hồ sơ một tác giả — /tac-gia/{slug}/.
 *
 * Ảnh chân dung = Ảnh đại diện của bài; tiểu sử = ô soạn thảo; chức danh /
 * kinh nghiệm / thành tích = meta khai trong inc/tac-gia.php.
 *
 * Lưới bài viết bên dưới KHÔNG dùng post_author của WordPress mà truy ngược
 * meta ECSGES_TG_META_LINK — xem ghi chú "ĐÁNH ĐỔI PHẢI BIẾT" trong
 * inc/tac-gia.php. Bài nào chưa chọn tác giả trong màn hình sửa bài thì không
 * xuất hiện ở đây.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$ecsges_tg_id  = get_the_ID();
	$ecsges_photo  = ecsges_tg_photo( $ecsges_tg_id, 'medium_large' );
	$ecsges_role   = (string) get_post_meta( $ecsges_tg_id, 'ecsges_tg_role', true );
	$ecsges_exp    = ecsges_tg_lines( $ecsges_tg_id, 'ecsges_tg_experience' );
	$ecsges_awards = ecsges_tg_lines( $ecsges_tg_id, 'ecsges_tg_achievements' );

	// Bài viết đã gán cho hồ sơ này. paged để phân trang chạy đúng khi hồ sơ
	// có nhiều bài.
	$ecsges_paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
	$ecsges_posts = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 9,
			'paged'          => $ecsges_paged,
			'meta_key'       => ECSGES_TG_META_LINK, // phpcs:ignore WordPress.DB.SlowMetaQuery.SlowMetaQuery
			'meta_value'     => (string) $ecsges_tg_id, // phpcs:ignore WordPress.DB.SlowMetaQuery.SlowMetaQuery
		)
	);
	?>
	<main class="ecs-author">
		<?php ecsges_breadcrumb(); ?>

		<div class="ecs-author__inner">
			<header class="ecs-author__profile">
				<div class="ecs-author__avatar">
					<?php if ( '' !== $ecsges_photo ) : ?>
						<img src="<?php echo esc_url( $ecsges_photo ); ?>" alt="<?php the_title_attribute(); ?>">
					<?php else : ?>
						<?php // Chưa đặt ảnh: ô xám + chữ cái đầu, tránh khoảng trống vô nghĩa. ?>
						<span class="ecs-author__avatar-fallback" aria-hidden="true"><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span>
					<?php endif; ?>
				</div>

				<div class="ecs-author__ident">
					<h1 class="ecs-author__name"><?php the_title(); ?></h1>

					<?php if ( '' !== $ecsges_role ) : ?>
						<p class="ecs-author__role"><?php echo esc_html( $ecsges_role ); ?></p>
					<?php endif; ?>

					<?php
					// Tiểu sử là meta chứ không phải the_content(): post type này
					// không bật 'editor' (xem inc/tac-gia.php).
					$ecsges_bio = ecsges_tg_bio_html( $ecsges_tg_id );
					if ( '' !== $ecsges_bio ) :
						?>
						<div class="ecs-author__bio"><?php echo wp_kses_post( $ecsges_bio ); ?></div>
					<?php endif; ?>
				</div>
			</header>

			<?php if ( $ecsges_exp || $ecsges_awards ) : ?>
				<div class="ecs-author__facts">
					<?php if ( $ecsges_exp ) : ?>
						<section class="ecs-author__fact">
							<h2 class="ecs-author__fact-title"><?php echo esc_html( ecsges_t( 'Kinh nghiệm làm việc' ) ); ?></h2>
							<ul class="ecs-author__fact-list">
								<?php foreach ( $ecsges_exp as $ecsges_line ) : ?>
									<li class="ecs-author__fact-item"><?php echo esc_html( $ecsges_line ); ?></li>
								<?php endforeach; ?>
							</ul>
						</section>
					<?php endif; ?>

					<?php if ( $ecsges_awards ) : ?>
						<section class="ecs-author__fact">
							<h2 class="ecs-author__fact-title"><?php echo esc_html( ecsges_t( 'Thành tích' ) ); ?></h2>
							<ul class="ecs-author__fact-list">
								<?php foreach ( $ecsges_awards as $ecsges_line ) : ?>
									<li class="ecs-author__fact-item"><?php echo esc_html( $ecsges_line ); ?></li>
								<?php endforeach; ?>
							</ul>
						</section>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $ecsges_posts->have_posts() ) : ?>
				<section class="ecs-author__posts">
					<h2 class="ecs-author__posts-title"><?php echo esc_html( ecsges_t( 'Bài viết của tác giả' ) ); ?></h2>

					<ul class="ecs-news-grid__list">
						<?php
						while ( $ecsges_posts->have_posts() ) :
							$ecsges_posts->the_post();
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
										<h3 class="ecs-news-card__title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
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
					// Phân trang: cùng markup/CSS với category.php và tin-tuc-grid.php.
					if ( (int) $ecsges_posts->max_num_pages > 1 ) :
						$ecsges_page_links = paginate_links(
							array(
								'base'      => trailingslashit( get_permalink( $ecsges_tg_id ) ) . 'page/%#%/',
								'format'    => '',
								'current'   => $ecsges_paged,
								'total'     => (int) $ecsges_posts->max_num_pages,
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
				</section>
			<?php endif; ?>
		</div>
	</main>
	<?php
	wp_reset_postdata();
endwhile;

get_footer();
