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
		// Breadcrumb nằm NGOÀI container: Figma vẽ nền xám full-bleed 1920×66,
		// chỉ phần chữ mới thụt vào theo container.
		?>
		<div class="ecs-single__crumbbar">
			<div class="ecs-single__crumbbar-inner">
				<nav class="ecs-single__breadcrumb" aria-label="Breadcrumb">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( ecsges_t( 'Trang chủ' ) ); ?></a>
					<?php
					$ecsges_news_home = ecsges_translate_path( '/tin-tuc/' );
					?>
					<span class="ecs-single__crumb-sep" aria-hidden="true"></span>
					<a href="<?php echo esc_url( $ecsges_news_home ); ?>"><?php echo esc_html( ecsges_t( 'Tin tức' ) ); ?></a>
					<?php
					// Chuyên mục của bài (Figma: "Trang chủ > Tin tức > Về ECS > tiêu đề").
					// Bỏ qua nếu tên chuyên mục trùng nhãn "Tin tức" ở trên — nếu không
					// breadcrumb sẽ lặp "Tin tức > Tin tức".
					$ecsges_cats = get_the_category();
					if ( ! empty( $ecsges_cats ) && $ecsges_cats[0]->name !== ecsges_t( 'Tin tức' ) ) :
						?>
						<span class="ecs-single__crumb-sep" aria-hidden="true"></span>
						<a href="<?php echo esc_url( get_category_link( $ecsges_cats[0]->term_id ) ); ?>"><?php echo esc_html( $ecsges_cats[0]->name ); ?></a>
					<?php endif; ?>
					<span class="ecs-single__crumb-sep" aria-hidden="true"></span>
					<span class="ecs-single__breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
				</nav>
			</div>
		</div>

		<div class="ecs-single__inner">
			<div class="ecs-single__layout">
				<div class="ecs-single__main">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article <?php post_class( 'ecs-single__article' ); ?>>
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

				<?php get_template_part( 'template-parts/news', 'sidebar', array( 'exclude' => get_the_ID() ) ); ?>
			</div>
		</div>
	</main>
<?php
get_footer();
