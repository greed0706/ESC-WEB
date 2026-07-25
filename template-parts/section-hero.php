<?php
/**
 * Section Hero (port HeroSection.tsx).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_mark    = ecsges_field_img( 'hero_mark', 'hero-mark.svg' );
$hero_eyebrow = ecsges_field( 'hero_eyebrow', 'ECS GLOBAL EDUCATION SYSTEM' );
$hero_script  = ecsges_field( 'hero_script', 'Kiến tạo' );
$hero_lines   = ecsges_field_lines( 'hero_heading', array( 'HỆ SINH THÁI', 'GIÁO DỤC TOÀN CẦU' ) );
$hero_badge   = ecsges_field( 'hero_badge', 'Vì tương lai Việt Nam' );
$hero_label   = ecsges_field( 'hero_cta_label', 'TÌM HIỂU THÊM' );
// Để trống field trong admin → nút trỏ về chuyên mục riêng (/category/ve-ecs/);
// chuyên mục chưa tạo thì lùi về neo #ve-ecs như cũ.
$hero_link    = ecsges_field( 'hero_cta_link', ecsges_category_link( 've-ecs', '#ve-ecs' ) );
?>
<section id="top" aria-labelledby="hero-heading" class="ecs-hero">
	<div class="ecs-hero__inner">
		<div class="ecsges-hero-emblem ecs-hero__emblem">
			<div class="ecsges-hero-mark ecs-hero__mark">
				<img src="<?php echo esc_url( $hero_mark ); ?>" alt="<?php echo esc_attr( ecsges_t( 'Biểu tượng ECS Global' ) ); ?>" class="ecs-hero__mark-img">
			</div>
		</div>

		<div class="ecs-hero__content">
			<p class="hero-reveal ecs-hero__eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>

			<p class="hero-reveal ecs-hero__script"><?php echo esc_html( $hero_script ); ?></p>

			<h1 id="hero-heading" data-hero-chars class="ecs-hero__heading">
				<?php
				foreach ( $hero_lines as $li => $line ) {
					if ( $li > 0 ) {
						echo '<br>';
					}
					$words = preg_split( '/\s+/u', trim( $line ) );
					foreach ( $words as $wi => $word ) {
						if ( '' === $word ) {
							continue;
						}
						if ( $wi > 0 ) {
							echo ' ';
						}
						$chars = function_exists( 'mb_str_split' ) ? mb_str_split( $word ) : preg_split( '//u', $word, -1, PREG_SPLIT_NO_EMPTY );
						echo '<span class="hero-word">';
						foreach ( $chars as $ch ) {
							echo '<span class="hero-char">' . esc_html( $ch ) . '</span>';
						}
						echo '</span>';
					}
				}
				?>
			</h1>

			<p class="hero-reveal ecs-hero__badge"><?php echo esc_html( $hero_badge ); ?></p>
		</div>
	</div>
</section>
