<?php
/**
 * Single post — Figma node 825:2396.
 *
 * Bố cục: dải breadcrumb xám #f0f0f0 chạy hết chiều ngang (cao 66), rồi 2 cột
 * trong container 1271: bài viết 818px bên trái, sidebar "TIN TỨC - THÔNG BÁO"
 * 370px bên phải, cách nhau 83px.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-single">
		<?php
		// Breadcrumb nằm NGOÀI container (nền xám full-bleed). Dùng part chung —
		// đường dẫn do ecsges_breadcrumb_items() dựng, ĐÚNG mảng mà inc/schema.php
		// dùng cho BreadcrumbList, nên phần hiển thị và schema không thể lệch nhau.
		ecsges_breadcrumb();
		?>

		<div class="ecs-single__inner">
			<div class="ecs-single__layout">
				<div class="ecs-single__main">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article <?php post_class( 'ecs-single__article' ); ?>>
							<h1 class="ecs-single__title"><?php the_title(); ?></h1>
							<?php get_template_part( 'template-parts/post', 'byline' ); ?>

							<div class="ecs-single__content">
								<?php the_content(); ?>
							</div>
						</article>
						<?php
					endwhile;
					?>
				</div>

				<?php get_template_part( 'template-parts/news', 'sidebar', array( 'exclude' => get_the_ID() ) ); ?>
			</div>
		</div>
	</main>
<?php
get_footer();
