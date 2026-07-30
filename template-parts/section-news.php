<?php
/**
 * Section News (TIN TỨC) — trang chủ.
 *
 * Bố cục theo ảnh mẫu: tiêu đề → 4 tab "loại tin" (gạch chân cam khi active) →
 * thanh lọc xám (Thời gian từ / Đến / Chủ đề / Định dạng + 2 nút đổi kiểu xem)
 * → dải xám full-bleed chứa lưới card → link "XEM THÊM" giữa 2 đường kẻ.
 *
 * LỌC BẰNG JS, DỮ LIỆU CÓ SẴN: template đổ bài mới nhất TOÀN SITE (tối đa
 * $ecsges_news_max) vào DOM kèm data-tab / data-year / data-topic / data-format;
 * initNewsFilter() (assets/js/main.js) chỉ ẩn/hiện card, luôn giới hạn hiện tối
 * đa $ecsges_news_per card khớp bộ lọc — không AJAX, không reload.
 *
 * "XEM THÊM" là LINK THẬT (không lộ thêm card tại chỗ nữa): trỏ tới
 * category.php của Chủ đề đang chọn, hoặc của tab loại tin đang active nếu
 * Chủ đề = "Tất cả" — JS cập nhật href mỗi khi đổi tab/chủ đề.
 *
 * 2 TRỤC LỌC CHUYÊN MỤC ĐỘC LẬP NHAU:
 *   - "loại tin" (4 tab, ecsges_news_types()) — cố định, chỉ xếp bài vào 1
 *     trong 4 bucket (bài không thuộc cả 4 thì rơi vào tab đầu, xem vòng lặp
 *     bên dưới); dùng để lấy link "XEM THÊM" mặc định của mỗi tab.
 *   - "Chủ đề" (select, $ecsges_news_topics) — TẤT CẢ chuyên mục thật đang có
 *     bài trên site (get_categories()), không còn giới hạn ở danh sách tĩnh.
 * Bài không match chuyên mục "loại tin"/"Chủ đề" nào → tab đó rỗng; không bài
 * nào cả → rơi về nội dung mẫu ecsges_news_knowledge() để khối không bị trắng.
 *
 * NÚT "Xem thêm" TRONG CARD: cố ý dùng LẠI NGUYÊN class .ecs-about__cta-wrap +
 * .ecs-about__cta (src/scss/components/_landing.scss) qua ecsges_see_more(),
 * để luôn giống hệt nút của section-about về mọi mặt. Đừng thay bằng class
 * riêng của khối này.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_news_per = 3;  // số card tối đa hiện ra khớp bộ lọc hiện tại ("XEM THÊM" là link ra category.php, không lộ thêm tại chỗ nữa).
$ecsges_news_max = 12; // số bài tối đa đổ vào DOM.

$ecsges_news_types   = ecsges_news_types();
$ecsges_news_formats = ecsges_news_formats();

// Chủ đề = TẤT CẢ chuyên mục thật có bài trong WordPress (get_categories() mặc
// định hide_empty), không còn giới hạn ở 5 tab tĩnh của trang Tin tức nữa —
// $ecsges_news_topics là nhãn hiển thị, $ecsges_news_topic_links là link
// category.php tương ứng để nút "XEM THÊM" trỏ tới (xem bên dưới).
$ecsges_news_topics      = array();
$ecsges_news_topic_links = array();
foreach ( get_categories( array( 'hide_empty' => true ) ) as $ecsges_news_term ) {
	$ecsges_news_topics[ $ecsges_news_term->slug ]      = $ecsges_news_term->name;
	$ecsges_news_topic_links[ $ecsges_news_term->slug ] = get_term_link( $ecsges_news_term );
}

// --- 4 chuyên mục "loại tin" — chỉ dùng để XẾP TAB + lấy link "XEM THÊM"
// mặc định của từng tab, KHÔNG còn dùng để giới hạn câu truy vấn (xem dưới).
$ecsges_news_cats      = array();
$ecsges_news_tab_links = array();
foreach ( array_keys( $ecsges_news_types ) as $ecsges_news_slug ) {
	$ecsges_news_cid = ecsges_category_id( $ecsges_news_slug );
	if ( $ecsges_news_cid ) {
		$ecsges_news_cats[ $ecsges_news_cid ]      = $ecsges_news_slug;
		$ecsges_news_tab_links[ $ecsges_news_slug ] = ecsges_category_link( $ecsges_news_slug );
	}
}

// "Chủ đề: Tất cả" = tin mới nhất TOÀN SITE (không giới hạn 4 chuyên mục loại
// tin nữa) — bài không thuộc chuyên mục nào trong 4 loại tin vẫn cần hiện ra
// để lọc theo Chủ đề hoạt động đúng, nên bỏ hẳn category__in.
$ecsges_news_q     = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => $ecsges_news_max,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
$ecsges_news_posts = $ecsges_news_q->posts;
wp_reset_postdata();

$ecsges_news_items = array();

if ( $ecsges_news_posts ) {
	foreach ( $ecsges_news_posts as $ecsges_news_post ) {
		$ecsges_news_slugs = wp_list_pluck( get_the_category( $ecsges_news_post->ID ), 'slug' );

		// Tab = chuyên mục "loại tin" đầu tiên mà bài thuộc về; không khớp cái
		// nào (không xảy ra với query trên, nhưng phòng bài đa chuyên mục lạ)
		// thì xếp vào tab đầu để card không biến mất khỏi mọi tab.
		$ecsges_news_tab_key = '';
		foreach ( $ecsges_news_cats as $ecsges_news_cat_slug ) {
			if ( in_array( $ecsges_news_cat_slug, $ecsges_news_slugs, true ) ) {
				$ecsges_news_tab_key = $ecsges_news_cat_slug;
				break;
			}
		}
		if ( '' === $ecsges_news_tab_key ) {
			$ecsges_news_tab_key = key( $ecsges_news_types );
		}

		// Chủ đề = chuyên mục chủ đề đầu tiên bài thuộc về ('' = chưa gắn).
		$ecsges_news_topic = '';
		foreach ( array_keys( $ecsges_news_topics ) as $ecsges_news_topic_slug ) {
			if ( in_array( $ecsges_news_topic_slug, $ecsges_news_slugs, true ) ) {
				$ecsges_news_topic = $ecsges_news_topic_slug;
				break;
			}
		}

		// Nhãn trên card: ưu tiên tên chủ đề, chưa gắn chủ đề thì lấy tên loại tin.
		$ecsges_news_label = '' !== $ecsges_news_topic
			? $ecsges_news_topics[ $ecsges_news_topic ]
			: $ecsges_news_types[ $ecsges_news_tab_key ];

		$ecsges_news_items[] = array(
			'title'   => get_the_title( $ecsges_news_post ),
			'excerpt' => wp_trim_words( get_the_excerpt( $ecsges_news_post ), 24 ),
			'img'     => ecsges_post_thumb( $ecsges_news_post->ID, 'medium_large' ),
			'href'    => get_permalink( $ecsges_news_post ),
			'label'   => $ecsges_news_label,
			'date'    => get_the_date( 'd/m/Y', $ecsges_news_post ),
			'year'    => get_the_date( 'Y', $ecsges_news_post ),
			'tab'     => $ecsges_news_tab_key,
			'topic'   => $ecsges_news_topic,
			'format'  => ecsges_news_format_key( $ecsges_news_post->ID ),
		);
	}
} else {
	// Nội dung mẫu: 'img' là tên file trong assets/img nên phải qua ecsges_img(),
	// còn ảnh bài thật ở nhánh trên đã là URL đầy đủ.
	$ecsges_news_year = current_time( 'Y' );
	foreach ( array_slice( ecsges_tr_deep( ecsges_news_knowledge() ), 0, 6 ) as $ecsges_news_fb ) {
		$ecsges_news_items[] = array(
			'title'   => $ecsges_news_fb['title'],
			'excerpt' => $ecsges_news_fb['excerpt'],
			'img'     => ecsges_img( $ecsges_news_fb['img'] ),
			'href'    => $ecsges_news_fb['href'],
			'label'   => reset( $ecsges_news_types ),
			'date'    => current_time( 'd/m/Y' ),
			'year'    => $ecsges_news_year,
			'tab'     => key( $ecsges_news_types ),
			'topic'   => '',
			'format'  => 'hinh-anh',
		);
	}
}

if ( empty( $ecsges_news_items ) ) {
	return;
}

// Danh sách năm cho 2 select "Thời gian từ / Đến" — chỉ những năm THẬT SỰ có
// bài, mới nhất trước (giống thứ tự trong ảnh mẫu).
$ecsges_news_years = array_values( array_unique( wp_list_pluck( $ecsges_news_items, 'year' ) ) );
rsort( $ecsges_news_years );

// Mặc định: "từ" = năm cũ nhất, "đến" = năm mới nhất → không lọc mất bài nào.
$ecsges_news_y_min = $ecsges_news_years[ count( $ecsges_news_years ) - 1 ];
$ecsges_news_y_max = $ecsges_news_years[0];

$ecsges_news_first = key( $ecsges_news_types );

// Link mặc định của nút "XEM THÊM" khi chưa chọn Chủ đề nào: category.php của
// tab loại tin đang active (tab luôn ứng với 1 chuyên mục thật, xem
// $ecsges_news_tab_links ở trên) — JS (initNewsFilter) sẽ cập nhật lại href
// này mỗi khi đổi tab/chủ đề, ưu tiên Chủ đề nếu có chọn.
$ecsges_news_more_href = isset( $ecsges_news_tab_links[ $ecsges_news_first ] )
	? $ecsges_news_tab_links[ $ecsges_news_first ]
	: ecsges_translate_path( '/tin-tuc/' );
?>
<section id="tin-tuc" aria-labelledby="news-heading" class="ecs-news" data-news-filter>
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

		<div class="ecs-news__tabs" role="tablist" aria-label="<?php echo esc_attr( ecsges_t( 'Loại tin' ) ); ?>" data-aos="fade-up">
			<?php foreach ( $ecsges_news_types as $ecsges_news_key => $ecsges_news_name ) : ?>
				<?php $ecsges_news_on = ( $ecsges_news_key === $ecsges_news_first ); ?>
				<button
					type="button"
					role="tab"
					class="ecs-news__tab<?php echo $ecsges_news_on ? ' is-active' : ''; ?>"
					data-news-tab="<?php echo esc_attr( $ecsges_news_key ); ?>"
					data-news-href="<?php echo esc_url( isset( $ecsges_news_tab_links[ $ecsges_news_key ] ) ? $ecsges_news_tab_links[ $ecsges_news_key ] : ecsges_translate_path( '/tin-tuc/' ) ); ?>"
					aria-selected="<?php echo $ecsges_news_on ? 'true' : 'false'; ?>"><?php echo esc_html( ecsges_t( $ecsges_news_name ) ); ?></button>
			<?php endforeach; ?>
			<span class="ecs-news__tab-indicator" aria-hidden="true" data-news-tab-indicator></span>
		</div>

		<div class="ecs-news__toolbar" data-aos="fade-up" data-aos-delay="60">
			<?php // Thẻ bọc này KHÔNG thừa: nó gom 3 cụm lọc thành một khối căn GIỮA thanh, tách khỏi cụm icon ghim mép phải (xem &__filters trong components/_news.scss). ?>
			<div class="ecs-news__filters">
			<div class="ecs-news__group">
				<label class="ecs-news__label" for="news-year-from"><?php echo esc_html( ecsges_t( 'Thời gian từ' ) ); ?></label>
				<div class="ecs-news__select-wrap">
					<select id="news-year-from" class="ecs-news__select" data-news-year-from>
						<?php foreach ( $ecsges_news_years as $ecsges_news_y ) : ?>
							<option value="<?php echo esc_attr( $ecsges_news_y ); ?>"<?php echo $ecsges_news_y === $ecsges_news_y_min ? ' selected' : ''; ?>><?php echo esc_html( $ecsges_news_y ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<label class="ecs-news__label" for="news-year-to"><?php echo esc_html( ecsges_t( 'Đến' ) ); ?></label>
				<div class="ecs-news__select-wrap">
					<select id="news-year-to" class="ecs-news__select" data-news-year-to>
						<?php foreach ( $ecsges_news_years as $ecsges_news_y ) : ?>
							<option value="<?php echo esc_attr( $ecsges_news_y ); ?>"<?php echo $ecsges_news_y === $ecsges_news_y_max ? ' selected' : ''; ?>><?php echo esc_html( $ecsges_news_y ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="ecs-news__group">
				<label class="ecs-news__label" for="news-topic"><?php echo esc_html( ecsges_t( 'Chủ đề' ) ); ?></label>
				<div class="ecs-news__select-wrap">
					<?php // data-news-href: category.php của chuyên mục — nút "XEM THÊM" ưu tiên
					// link này khi có chọn Chủ đề; option "Tất cả" để rỗng để JS rơi về link
					// của tab loại tin đang active (xem initNewsFilter trong assets/js/main.js). ?>
					<select id="news-topic" class="ecs-news__select" data-news-key="topic">
						<option value="" data-news-href=""><?php echo esc_html( ecsges_t( 'Tất cả' ) ); ?></option>
						<?php foreach ( $ecsges_news_topics as $ecsges_news_key => $ecsges_news_name ) : ?>
							<option value="<?php echo esc_attr( $ecsges_news_key ); ?>" data-news-href="<?php echo esc_url( $ecsges_news_topic_links[ $ecsges_news_key ] ); ?>"><?php echo esc_html( ecsges_t( $ecsges_news_name ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="ecs-news__group">
				<label class="ecs-news__label" for="news-format"><?php echo esc_html( ecsges_t( 'Định dạng' ) ); ?></label>
				<div class="ecs-news__select-wrap">
					<select id="news-format" class="ecs-news__select" data-news-key="format">
						<option value=""><?php echo esc_html( ecsges_t( 'Tất cả' ) ); ?></option>
						<?php foreach ( $ecsges_news_formats as $ecsges_news_key => $ecsges_news_name ) : ?>
							<option value="<?php echo esc_attr( $ecsges_news_key ); ?>"><?php echo esc_html( ecsges_t( $ecsges_news_name ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			</div><?php // .ecs-news__filters ?>

			<div class="ecs-news__views" role="group" aria-label="<?php echo esc_attr( ecsges_t( 'Kiểu hiển thị' ) ); ?>">
				<button type="button" class="ecs-news__view is-active" data-news-view="grid" aria-pressed="true" aria-label="<?php echo esc_attr( ecsges_t( 'Xem dạng lưới' ) ); ?>">
					<?php echo ecsges_inline_svg( 'tin-tuc/type-post-1.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
				<button type="button" class="ecs-news__view" data-news-view="list" aria-pressed="false" aria-label="<?php echo esc_attr( ecsges_t( 'Xem dạng danh sách' ) ); ?>">
					<?php echo ecsges_inline_svg( 'tin-tuc/type-post-2.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			</div>
		</div>
	</div>

	<div class="ecs-news__band">
		<div class="ecs-news__inner">
			<div class="ecs-news__grid" data-news-list data-news-per="<?php echo esc_attr( $ecsges_news_per ); ?>" data-aos="fade-up" data-aos-delay="80">
				<?php foreach ( $ecsges_news_items as $item ) : ?>
					<article
						class="ecs-news__card"
						data-news-item
						data-tab="<?php echo esc_attr( $item['tab'] ); ?>"
						data-year="<?php echo esc_attr( $item['year'] ); ?>"
						data-topic="<?php echo esc_attr( $item['topic'] ); ?>"
						data-format="<?php echo esc_attr( $item['format'] ); ?>">
						<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-news__card-media">
							<img src="<?php echo esc_url( $item['img'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" class="ecs-news__card-img">
						</a>
						<div class="ecs-news__card-body">
							<p class="ecs-news__card-eyebrow"><?php echo esc_html( ecsges_t( $item['label'] ) ); ?></p>
							<h3 class="ecs-news__card-title">
								<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-news__card-link"><?php echo esc_html( $item['title'] ); ?></a>
							</h3>
							<p class="ecs-news__card-excerpt"><?php echo esc_html( $item['excerpt'] ); ?></p>
							<div class="ecs-news__card-foot">
								<time class="ecs-news__card-date"><?php echo esc_html( $item['date'] ); ?></time>
								<div class="ecs-about__cta-wrap">
									<?php ecsges_see_more( $item['href'], 'Xem thêm', 'ecs-about__cta' ); ?>
								</div>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<p class="ecs-news__empty" data-news-empty hidden><?php echo esc_html( ecsges_t( 'Không có bài viết phù hợp.' ) ); ?></p>

			<?php // Link thật tới category.php của Chủ đề đang chọn (hoặc tab loại tin
			// đang active nếu Chủ đề = "Tất cả") — không còn lộ thêm card tại chỗ.
			// initNewsFilter() (assets/js/main.js) tự cập nhật href mỗi khi đổi
			// tab/chủ đề, giá trị dưới đây chỉ là mặc định lúc tải trang. ?>
			<div class="ecs-news__more" data-news-more-wrap>
				<a href="<?php echo esc_url( $ecsges_news_more_href ); ?>" class="ecs-news__more-btn" data-news-more><?php echo esc_html( ecsges_t( 'XEM THÊM' ) ); ?></a>
			</div>
		</div>
	</div>
</section>
