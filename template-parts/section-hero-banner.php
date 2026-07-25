<?php
/**
 * Section Hero — biến thể BANNER (Figma node 2:13 / rect 2:34, 1920x792).
 *
 * Toàn bộ chữ ("Kiến tạo hệ sinh thái / GIÁO DỤC TOÀN CẦU / VÌ TƯƠNG LAI VIỆT NAM")
 * đã bake sẵn trong ảnh nên KHÔNG render text overlay — chỉ một <h1> ẩn cho
 * screen reader / SEO, giống cách template-parts/page-hero.php xử lý
 * variant 'banner'.
 *
 * Bản hero cũ (emblem + chữ hiện từng ký tự) vẫn giữ nguyên ở
 * template-parts/section-hero.php để tái sử dụng — đổi lại một dòng
 * get_template_part() trong front-page.php là quay về được.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_banner = ecsges_field_img( 'hero_banner', 'hero-banner.jpg' );
$hero_alt    = ecsges_t( 'Kiến tạo hệ sinh thái giáo dục toàn cầu — Vì tương lai Việt Nam' );
?>
<section id="top" aria-labelledby="hero-heading" class="ecs-hero-banner">
	<h1 id="hero-heading" class="ecs-hero-banner__visually-hidden"><?php echo esc_html( $hero_alt ); ?></h1>
	<img src="<?php echo esc_url( $hero_banner ); ?>" alt="" aria-hidden="true" width="1920" height="792" class="ecs-hero-banner__img">
</section>
