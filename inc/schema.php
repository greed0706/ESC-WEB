<?php
/**
 * Schema JSON-LD toàn site (việc #11–#20 trong bảng kế hoạch).
 *
 * In MỘT khối @graph vào <head> mọi trang, gồm:
 *   - Organization  — danh tính doanh nghiệp (tên, mã số thuế, logo, địa chỉ, liên hệ, mạng xã hội)
 *   - WebSite       — khai báo website + ô tìm kiếm nội bộ
 *   - node theo ngữ cảnh — BlogPosting / AboutPage / ContactPage / WebPage
 *   - BreadcrumbList — mọi trang TRỪ trang chủ
 *
 * Vì sao dựng bằng mảng PHP rồi wp_json_encode() thay vì dán chuỗi JSON thô:
 * escape đúng chuẩn, và URL lấy từ chính cấu hình site nên không lệch giữa
 * local (ecs.test) và production.
 *
 * Vì sao một @graph thay vì nhiều khối rời: các node tham chiếu nhau bằng @id
 * (bài viết → publisher → logo), Google gộp đúng hơn và không lặp dữ liệu.
 *
 * ⚠️ SCHEMA CỦA YOAST BỊ TẮT ở cuối file. Bật lại (bỏ filter đó) mà vẫn giữ
 * file này thì site có HAI bộ Organization/WebSite/Breadcrumb — Google Search
 * Console sẽ báo trùng lặp. Chỉ được chạy một nguồn.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URL gốc của site theo NGÔN NGỮ đang xem (Polylang), có dấu / cuối.
 *
 * @return string
 */
function ecsges_schema_home() {
	return function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
}

/** @id của node Organization. */
function ecsges_schema_org_id() {
	return home_url( '/' ) . '#organization';
}

/** @id của node WebSite. */
function ecsges_schema_site_id() {
	return home_url( '/' ) . '#website';
}

/**
 * URL logo dùng cho Organization. Lấy đúng file logo theme đang enqueue.
 *
 * @return string
 */
function ecsges_schema_logo_url() {
	$logo = ecsges_field_img( 'header_logo', 'logo-ecsges.svg' );
	return $logo ? $logo : ecsges_img( 'logo-ecsges.svg' );
}

/**
 * Các link mạng xã hội (sameAs). Đọc CÙNG field mà footer.php dùng nên sửa một
 * chỗ là cả hai đổi theo.
 *
 * @return string[]
 */
function ecsges_schema_social_links() {
	$links = array(
		ecsges_field( 'footer_facebook', 'https://www.facebook.com/ecsglobal.edu.vn' ),
		ecsges_field( 'footer_youtube', 'https://www.youtube.com/@ecs.global' ),
		ecsges_field( 'footer_tiktok', 'https://www.tiktok.com/@ecsglobal' ),
	);
	return array_values( array_filter( array_map( 'trim', $links ), 'strlen' ) );
}

/**
 * Node Organization — danh tính doanh nghiệp.
 *
 * @return array
 */
function ecsges_schema_organization() {
	$contact = ecsges_footer_contact();
	$entity  = ecsges_footer_legal_entity();
	$home    = home_url( '/' );

	return array(
		'@type'       => 'Organization',
		'@id'         => ecsges_schema_org_id(),
		'name'        => 'ECS Global Education System',
		'alternateName' => 'ECSGES',
		'legalName'   => $entity['company'],
		'taxID'       => $entity['tax_id'],
		'url'         => $home,
		'logo'        => array(
			'@type'      => 'ImageObject',
			'@id'        => $home . '#logo',
			'url'        => ecsges_schema_logo_url(),
			'contentUrl' => ecsges_schema_logo_url(),
			'caption'    => 'ECS Global Education System',
		),
		'image'       => array( '@id' => $home . '#logo' ),
		'email'       => $contact['email'],
		'telephone'   => $contact['phone'],
		'address'     => array(
			'@type'          => 'PostalAddress',
			'streetAddress'  => $contact['address'],
			'addressCountry' => 'VN',
		),
		'sameAs'      => ecsges_schema_social_links(),
	);
}

/**
 * Node WebSite — khai báo site + sitelinks searchbox.
 *
 * @return array
 */
function ecsges_schema_website() {
	$home = home_url( '/' );

	return array(
		'@type'           => 'WebSite',
		'@id'             => ecsges_schema_site_id(),
		'url'             => $home,
		'name'            => 'ECS Global Education System',
		'alternateName'   => 'ECSGES',
		'description'     => get_bloginfo( 'description' ),
		'publisher'       => array( '@id' => ecsges_schema_org_id() ),
		'inLanguage'      => ecsges_schema_lang(),
		'potentialAction' => array(
			array(
				'@type'       => 'SearchAction',
				'target'      => array(
					'@type'       => 'EntryPoint',
					'urlTemplate' => $home . '?s={search_term_string}',
				),
				'query-input' => 'required name=search_term_string',
			),
		),
	);
}

/**
 * Mã ngôn ngữ cho inLanguage: 'vi-VN' / 'en-US'.
 *
 * @return string
 */
function ecsges_schema_lang() {
	return ecsges_is_en() ? 'en-US' : 'vi-VN';
}

/**
 * Node BreadcrumbList dựng từ CHÍNH mảng mà dải breadcrumb hiển thị dùng
 * (ecsges_breadcrumb_items) — hai bên không thể lệch nhau.
 *
 * @param string $page_id @id của node trang hiện tại.
 * @return array|null null nếu là trang chủ (không có breadcrumb).
 */
function ecsges_schema_breadcrumb( $page_id ) {
	$items = ecsges_breadcrumb_items();
	if ( empty( $items ) ) {
		return null;
	}

	$list = array();
	foreach ( $items as $i => $item ) {
		$node = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $item['label'],
		);
		// Mục cuối (trang hiện tại) KHÔNG có 'item' — đúng khuyến nghị của
		// Google, tự trỏ về mình là thừa.
		if ( '' !== $item['url'] ) {
			$node['item'] = $item['url'];
		}
		$list[] = $node;
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => $page_id . '#breadcrumb',
		'itemListElement' => $list,
	);
}

/**
 * Mô tả cho node trang: ưu tiên mô tả Yoast đã nhập, sau đó tóm tắt, cuối cùng
 * cắt từ nội dung.
 *
 * @param int $post_id
 * @return string
 */
function ecsges_schema_description( $post_id ) {
	$yoast = get_post_meta( $post_id, '_yoast_wpseo_metadesc', true );
	if ( is_string( $yoast ) && '' !== trim( $yoast ) ) {
		return trim( $yoast );
	}
	$excerpt = get_the_excerpt( $post_id );
	if ( is_string( $excerpt ) && '' !== trim( $excerpt ) ) {
		return trim( wp_strip_all_tags( $excerpt ) );
	}
	$post = get_post( $post_id );
	return $post ? wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 40 ) : '';
}

/**
 * Node ImageObject cho ảnh đại diện của một bài/trang.
 *
 * @param int    $post_id
 * @param string $id_suffix
 * @return array|null
 */
function ecsges_schema_primary_image( $post_id, $id_suffix = '#primaryimage' ) {
	$thumb_id = get_post_thumbnail_id( $post_id );
	if ( ! $thumb_id ) {
		return null;
	}
	$src = wp_get_attachment_image_src( $thumb_id, 'full' );
	if ( ! $src ) {
		return null;
	}
	$node = array(
		'@type'      => 'ImageObject',
		'@id'        => get_permalink( $post_id ) . $id_suffix,
		'url'        => $src[0],
		'contentUrl' => $src[0],
		'width'      => (int) $src[1],
		'height'     => (int) $src[2],
	);
	$alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
	if ( $alt ) {
		$node['caption'] = $alt;
	}
	return $node;
}

/**
 * Node author cho BlogPosting.
 *
 * Ưu tiên hồ sơ trong post type 'tac_gia' (nguồn tác giả thật của site — xem
 * inc/tac-gia.php); bài chưa gán tác giả thì lùi về "Ban biên tập ECSGES" chứ
 * KHÔNG dùng tài khoản đăng nhập WordPress — tài khoản 'admin' lọt ra schema
 * là tín hiệu xấu với Google và lộ tên đăng nhập.
 *
 * @param int $post_id
 * @return array
 */
function ecsges_schema_author( $post_id ) {
	$tg = ecsges_tg_for_post( $post_id );
	if ( $tg ) {
		$node = array(
			'@type' => 'Person',
			'@id'   => get_permalink( $tg->ID ) . '#person',
			'name'  => get_the_title( $tg->ID ),
			'url'   => get_permalink( $tg->ID ),
		);
		$role = get_post_meta( $tg->ID, 'ecsges_tg_role', true );
		if ( $role ) {
			$node['jobTitle'] = $role;
		}
		$photo = ecsges_tg_photo( $tg->ID, 'full' );
		if ( $photo ) {
			$node['image'] = array(
				'@type' => 'ImageObject',
				'url'   => $photo,
			);
		}
		return $node;
	}

	return array(
		'@type' => 'Organization',
		'@id'   => ecsges_schema_org_id(),
		'name'  => ecsges_t( 'Ban biên tập ECSGES' ),
	);
}

/**
 * Node theo ngữ cảnh trang đang xem.
 *
 * Ánh xạ theo bảng kế hoạch:
 *   - bài viết          → BlogPosting (#12)
 *   - Page 've-ecs*'    → AboutPage   (#13)
 *   - Page 'lien-he'    → ContactPage (#14)
 *   - chuyên mục Hướng nghiệp/Tuyển sinh/Đào tạo/Việc làm/Truyền thông → WebPage (#15–19)
 *   - còn lại           → WebPage
 *
 * @return array
 */
function ecsges_schema_context_node() {
	$lang = ecsges_schema_lang();

	/* ---------- Bài viết → BlogPosting (#12) ---------- */
	if ( is_singular( 'post' ) ) {
		$id   = get_the_ID();
		$url  = get_permalink( $id );
		$node = array(
			'@type'            => 'BlogPosting',
			'@id'              => $url . '#blogposting',
			'mainEntityOfPage' => array(
				'@type' => 'WebPage',
				'@id'   => $url,
			),
			'headline'         => wp_strip_all_tags( get_the_title( $id ) ),
			'description'      => ecsges_schema_description( $id ),
			'datePublished'    => get_post_time( 'c', true, $id ),
			'dateModified'     => get_post_modified_time( 'c', true, $id ),
			'inLanguage'       => $lang,
			'author'           => ecsges_schema_author( $id ),
			'publisher'        => array( '@id' => ecsges_schema_org_id() ),
			'isPartOf'         => array(
				'@type' => 'Blog',
				'@id'   => home_url( '/' ) . '#blog',
				'name'  => ecsges_t( 'Blog ECS Global Education System' ),
				'url'   => ecsges_translate_path( '/tin-tuc/' ),
			),
			'url'              => $url,
			'wordCount'        => str_word_count( wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $id ) ) ) ),
		);

		$image = ecsges_schema_primary_image( $id );
		if ( $image ) {
			$node['image'] = $image;
		}

		$cats = get_the_category( $id );
		if ( ! empty( $cats ) ) {
			$node['articleSection'] = $cats[0]->name;
		}

		$tags = get_the_tags( $id );
		if ( $tags && ! is_wp_error( $tags ) ) {
			$node['keywords'] = wp_list_pluck( $tags, 'name' );
		}

		return $node;
	}

	/* ---------- Hồ sơ tác giả → ProfilePage ---------- */
	if ( is_singular( ECSGES_TG_TYPE ) ) {
		$id  = get_the_ID();
		$url = get_permalink( $id );
		return array(
			'@type'      => array( 'WebPage', 'ProfilePage' ),
			'@id'        => $url . '#webpage',
			'url'        => $url,
			'name'       => wp_strip_all_tags( get_the_title( $id ) ),
			'inLanguage' => $lang,
			'isPartOf'   => array( '@id' => ecsges_schema_site_id() ),
			'mainEntity' => ecsges_schema_author_self( $id ),
		);
	}

	/* ---------- Chuyên mục → WebPage (#15–19) ---------- */
	if ( is_category() ) {
		$term = get_queried_object();
		$url  = $term instanceof WP_Term ? get_category_link( $term->term_id ) : ecsges_schema_home();
		return array(
			// Vừa WebPage (theo đúng bảng kế hoạch) vừa CollectionPage (chính
			// xác hơn cho một trang lưu trữ) — schema.org cho phép nhiều @type.
			'@type'       => array( 'WebPage', 'CollectionPage' ),
			'@id'         => $url . '#webpage',
			'url'         => $url,
			'name'        => $term instanceof WP_Term ? $term->name : '',
			'headline'    => $term instanceof WP_Term ? $term->name : '',
			'description' => $term instanceof WP_Term ? wp_strip_all_tags( term_description( $term->term_id ) ) : '',
			'inLanguage'  => $lang,
			'isPartOf'    => array( '@id' => ecsges_schema_site_id() ),
			'about'       => array( '@id' => ecsges_schema_org_id() ),
		);
	}

	/* ---------- Trang tĩnh ---------- */
	if ( is_page() ) {
		$id   = get_the_ID();
		$url  = get_permalink( $id );
		$slug = get_post_field( 'post_name', $id );

		// Slug bản dịch khác bản gốc, nên dò theo slug GỐC trong nhóm dịch.
		$base_slug = $slug;
		if ( function_exists( 'pll_get_post_translations' ) ) {
			foreach ( pll_get_post_translations( $id ) as $lang_code => $tr_id ) {
				if ( 'vi' === $lang_code ) {
					$base_slug = get_post_field( 'post_name', $tr_id );
				}
			}
		}

		$type = 'WebPage';
		if ( 0 === strpos( $base_slug, 've-ecs' ) ) {
			$type = 'AboutPage';   // #13
		} elseif ( 'lien-he' === $base_slug ) {
			$type = 'ContactPage'; // #14
		}

		$node = array(
			'@type'       => is_front_page() ? 'WebPage' : $type,
			'@id'         => $url . '#webpage',
			'url'         => $url,
			'name'        => wp_strip_all_tags( get_the_title( $id ) ),
			'headline'    => wp_strip_all_tags( get_the_title( $id ) ),
			'description' => ecsges_schema_description( $id ),
			'inLanguage'  => $lang,
			'isPartOf'    => array( '@id' => ecsges_schema_site_id() ),
			'about'       => array( '@id' => ecsges_schema_org_id() ),
		);

		$image = ecsges_schema_primary_image( $id );
		if ( $image ) {
			$node['primaryImageOfPage'] = $image;
		}

		return $node;
	}

	/* ---------- Còn lại (tìm kiếm, 404, lưu trữ khác) ---------- */
	$url = home_url( add_query_arg( array() ) );
	return array(
		'@type'      => 'WebPage',
		'@id'        => $url . '#webpage',
		'url'        => $url,
		'name'       => wp_strip_all_tags( wp_get_document_title() ),
		'inLanguage' => $lang,
		'isPartOf'   => array( '@id' => ecsges_schema_site_id() ),
	);
}

/**
 * Node Person của chính hồ sơ tác giả đang mở (mainEntity của ProfilePage).
 *
 * @param int $tg_id
 * @return array
 */
function ecsges_schema_author_self( $tg_id ) {
	$node = array(
		'@type' => 'Person',
		'@id'   => get_permalink( $tg_id ) . '#person',
		'name'  => wp_strip_all_tags( get_the_title( $tg_id ) ),
		'url'   => get_permalink( $tg_id ),
	);
	$role = get_post_meta( $tg_id, 'ecsges_tg_role', true );
	if ( $role ) {
		$node['jobTitle'] = $role;
	}
	$bio = get_post_meta( $tg_id, 'ecsges_tg_bio', true );
	if ( $bio ) {
		$node['description'] = wp_trim_words( $bio, 60 );
	}
	$photo = ecsges_tg_photo( $tg_id, 'full' );
	if ( $photo ) {
		$node['image'] = array(
			'@type' => 'ImageObject',
			'url'   => $photo,
		);
	}
	$node['worksFor'] = array( '@id' => ecsges_schema_org_id() );
	return $node;
}

/**
 * In khối @graph vào <head>.
 *
 * @return void
 */
function ecsges_schema_output() {
	// Trang quản trị / feed / trang tác giả WP (đã 301) không cần schema.
	if ( is_admin() || is_feed() || is_robots() ) {
		return;
	}

	$context = ecsges_schema_context_node();
	$graph   = array(
		ecsges_schema_organization(),
		ecsges_schema_website(),
		$context,
	);

	$crumbs = ecsges_schema_breadcrumb( isset( $context['@id'] ) ? $context['@id'] : ecsges_schema_home() );
	if ( $crumbs ) {
		$graph[]            = $crumbs;
		$context['breadcrumb'] = array( '@id' => $crumbs['@id'] );
		$graph[2]           = $context; // cập nhật lại node ngữ cảnh đã thêm liên kết
	}

	$payload = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	// UNESCAPED_UNICODE giữ tiếng Việt có dấu; UNESCAPED_SLASHES để URL không
	// thành http:\/\/ — cả hai đều hợp lệ nhưng bản sạch dễ soi lỗi hơn nhiều.
	echo "\n<!-- ECSGES schema -->\n<script type=\"application/ld+json\">"
		. wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. "</script>\n";
}
add_action( 'wp_head', 'ecsges_schema_output', 20 );

/**
 * TẮT schema của Yoast SEO.
 *
 * Bắt buộc: Yoast cũng in Organization/WebSite/WebPage/BreadcrumbList. Để cả
 * hai chạy thì mỗi trang có hai bộ, Google Search Console báo "Duplicate field"
 * và có thể bỏ qua cả hai.
 *
 * BẬT LẠI YOAST: xoá filter này VÀ bỏ add_action('wp_head', 'ecsges_schema_output')
 * ở trên — chỉ được chạy MỘT nguồn schema.
 *
 * @return bool
 */
add_filter( 'wpseo_json_ld_output', '__return_false' );
