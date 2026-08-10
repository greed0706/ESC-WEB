<?php
/**
 * Section News (TIN TỨC) — trang chủ.
 *
 * ĐÚNG THEO FIGMA (node 614:211 "TRANG CHỦ SỬA", con trực tiếp 614:274 +
 * 697:398.../697:443/697:453): CHỈ có tiêu đề "TIN TỨC" (đen, không accent,
 * căn giữa) rồi tới lưới 3 card trên nền TRẮNG — không tab "loại tin", không
 * thanh lọc, không dải xám full-bleed, không nút "Xem thêm" trong từng card,
 * không link "XEM THÊM" ở cuối. Bộ tab/thanh lọc đầy đủ đó là của TRANG
 * /tin-tuc/ riêng (page-tin-tuc.php + template-parts/tin-tuc-tabs.php), đừng
 * nhầm lẫn đưa lại vào đây.
 *
 * Lấy 3 bài mới nhất TOÀN SITE, không lọc theo chuyên mục. Nhãn trên card lấy
 * tên chuyên mục đầu tiên của bài (không có thì rơi về nhãn loại tin đầu
 * tiên trong ecsges_news_types()) — không có bài nào thì dùng nội dung mẫu
 * ecsges_news_knowledge() để khối không bị trắng.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_news_count = 3; // đúng số card trong Figma — không phân trang, không "xem thêm" tại chỗ.
$ecsges_news_types = ecsges_news_types();

$ecsges_news_q     = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $ecsges_news_count,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
$ecsges_news_posts = $ecsges_news_q->posts;
wp_reset_postdata();

$ecsges_news_items = array();

if ( $ecsges_news_posts ) {
	foreach ( $ecsges_news_posts as $ecsges_news_post ) {
		$ecsges_news_cats  = get_the_category( $ecsges_news_post->ID );
		$ecsges_news_label = $ecsges_news_cats ? $ecsges_news_cats[0]->name : reset( $ecsges_news_types );

		$ecsges_news_items[] = array(
			'title'   => get_the_title( $ecsges_news_post ),
			'excerpt' => wp_trim_words( get_the_excerpt( $ecsges_news_post ), 24 ),
			'img'     => ecsges_post_thumb( $ecsges_news_post->ID, 'medium_large' ),
			'href'    => get_permalink( $ecsges_news_post ),
			'label'   => $ecsges_news_label,
			'date'    => get_the_date( 'd/m/Y', $ecsges_news_post ),
		);
	}
} else {
	// Nội dung mẫu: 'img' là tên file trong assets/img nên phải qua ecsges_img(),
	// còn ảnh bài thật ở nhánh trên đã là URL đầy đủ.
	foreach ( array_slice( ecsges_tr_deep( ecsges_news_knowledge() ), 0, $ecsges_news_count ) as $ecsges_news_fb ) {
		$ecsges_news_items[] = array(
			'title'   => $ecsges_news_fb['title'],
			'excerpt' => $ecsges_news_fb['excerpt'],
			'img'     => ecsges_img( $ecsges_news_fb['img'] ),
			'href'    => $ecsges_news_fb['href'],
			'label'   => reset( $ecsges_news_types ),
			'date'    => current_time( 'd/m/Y' ),
		);
	}
}

if ( empty( $ecsges_news_items ) ) {
	return;
}
?>
<section id="tin-tuc" aria-labelledby="news-heading" class="ecs-news">
	<div class="ecs-news__inner">
		<div data-aos="fade-up">
			<?php
			ecsges_section_heading(
				array(
					'id'     => 'news-heading',
					'align'  => 'center',
					'lines'  => array( 'TIN TỨC' ),
					'accent' => array(),
					'class'  => 'ecs-news__heading',
				)
			);
			?>
		</div>

		<div class="ecs-news__grid" data-aos="fade-up" data-aos-delay="80">
			<?php foreach ( $ecsges_news_items as $item ) : ?>
				<article class="ecs-news__card">
					<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-news__card-media">
						<img src="<?php echo esc_url( $item['img'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" class="ecs-news__card-img">
					</a>
					<div class="ecs-news__card-body">
						<p class="ecs-news__card-eyebrow"><?php echo esc_html( ecsges_t( $item['label'] ) ); ?></p>
						<h3 class="ecs-news__card-title">
							<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-news__card-link"><?php echo esc_html( $item['title'] ); ?></a>
						</h3>
						<p class="ecs-news__card-excerpt"><?php echo esc_html( $item['excerpt'] ); ?></p>
						<time class="ecs-news__card-date"><?php echo esc_html( $item['date'] ); ?></time>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
