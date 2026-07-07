<?php
/**
 * Fallback template. Trang chủ dùng front-page.php; template này giữ cho các
 * route khác (và để WP nhận diện theme hợp lệ). GĐ1 chỉ có landing page.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-index">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'ecs-index__article' ); ?>>
					<h1 class="ecs-index__title"><?php the_title(); ?></h1>
					<div class="ecs-index__content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endwhile;
		else :
			?>
			<p class="ecs-index__empty"><?php esc_html_e( 'Không có nội dung.', 'ecsges' ); ?></p>
			<?php
		endif;
		?>
	</main>
<?php
get_footer();
