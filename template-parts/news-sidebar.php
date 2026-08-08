<?php
/**
 * Sidebar "TIN TỨC - THÔNG BÁO" — dùng chung cho single.php và category.php.
 *
 * Đo từ Figma node 825:2396 (cột phải x=1226, rộng 370):
 *   - Đầu khối: dải #f0f0f0 cao 58, gạch cam 4px sát mép trái, nhãn 18px
 *     Regular #000 lh 30, lề trong 18px.
 *   - Thân khối nền trắng, lề trong 18px.
 *   - Mỗi mục: ảnh 334×200 (tỉ lệ 334/200), rồi nhãn chuyên mục 16px Light
 *     #747272, tiêu đề 18px Regular #000 lh 28, ngày 16px Light #747272;
 *     giữa các mục có đường kẻ mảnh.
 *
 * @param int $args['exclude'] ID bài đang xem (bỏ khỏi danh sách), tuỳ chọn.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ns_exclude = isset( $args['exclude'] ) ? (int) $args['exclude'] : 0;

$ns_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 2,
		'post__not_in'        => $ns_exclude ? array( $ns_exclude ) : array(),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
?>
<aside class="ecs-news-side">
	<h2 class="ecs-news-side__head"><?php echo esc_html( ecsges_t( 'TIN TỨC - THÔNG BÁO' ) ); ?></h2>

	<ul class="ecs-news-side__list">
		<?php
		while ( $ns_query->have_posts() ) :
			$ns_query->the_post();
			$ns_cats  = get_the_category();
			$ns_label = ! empty( $ns_cats ) ? $ns_cats[0]->name : '';
			?>
			<li class="ecs-news-side__item">
				<a href="<?php the_permalink(); ?>" class="ecs-news-side__thumb" tabindex="-1" aria-hidden="true">
					<img
						src="<?php echo esc_url( ecsges_post_thumb( get_the_ID(), 'medium' ) ); ?>"
						alt=""
						loading="lazy"
						decoding="async">
				</a>
				<?php if ( '' !== $ns_label ) : ?>
					<p class="ecs-news-side__cat"><?php echo esc_html( $ns_label ); ?></p>
				<?php endif; ?>
				<h3 class="ecs-news-side__title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<span class="ecs-news-side__date"><?php echo esc_html( ecsges_post_time( null, 'd/m/Y' ) ); ?></span>
			</li>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</ul>
</aside>
