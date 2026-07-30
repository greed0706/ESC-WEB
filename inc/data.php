<?php
/**
 * Nội dung tĩnh cho landing page ECSGES — port từ src/components/landing-page/data.ts.
 * GIAI ĐOẠN 1: hard-code tại đây. GIAI ĐOẠN 2: thay bằng ACF get_field().
 *
 * @package ECSGES
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Menu điều hướng header.
 * 'href' = anchor tới section trên trang chủ.
 */
function ecsges_nav_items()
{
	return array(
		array(
			'label' => 'Về ECS',
			'href' => '/ve-ecs',
			'children' => array(
				array('label' => 'Hành trình phát triển', 'href' => '/ve-ecs#hanh-trinh-phat-trien'),
				array('label' => 'Tầm nhìn', 'href' => '/ve-ecs#tam-nhin'),
				array('label' => 'Sứ mệnh', 'href' => '/ve-ecs#su-menh'),
				array('label' => 'Giá trị cốt lõi', 'href' => '/ve-ecs#gia-tri-cot-loi'),
			),
		),
		array(
			'label' => 'Lĩnh vực hoạt động',
			'href' => '/linh-vuc-hoat-dong/',
			'children' => array(
				array('label' => 'Hướng nghiệp', 'href' => '/linh-vuc-hoat-dong/'),
				array('label' => 'Tuyển sinh', 'href' => '/linh-vuc-hoat-dong/'),
				array('label' => 'Đào tạo', 'href' => '/linh-vuc-hoat-dong/'),
				array('label' => 'Việc làm', 'href' => '/linh-vuc-hoat-dong/'),
				array('label' => 'Truyền thông', 'href' => '/linh-vuc-hoat-dong/'),
			),
		),
		array(
			'label' => 'Phát triển bền vững',
			'href' => '/phat-trien-ben-vung/',
			'children' => array(
				array('label' => 'Văn hoá ECS', 'href' => '/phat-trien-ben-vung/'),
				array('label' => 'Con người ECS', 'href' => '/phat-trien-ben-vung/'),
				array('label' => 'Trách nhiệm xã hội', 'href' => '/phat-trien-ben-vung/'),
			),
		),
		array('label' => 'Tin tức', 'href' => '/category/tin-tuc/'),
		array('label' => 'Tuyển dụng', 'href' => '#tuyen-dung'),
		array('label' => 'Liên hệ', 'href' => '/lien-he/'),
	);
}

/**
 * Các tab "Hệ sinh thái kết nối đa lĩnh vực".
 * 'icon' = tên file svg (không đuôi) trong assets/img.
 */
function ecsges_ecosystem_tabs()
{
	return array(
		array(
			'id' => 'huong-nghiep',
			'icon' => 'icon-huongnghiep',
			'image' => 'he-sinh-thai/huong-nghiep.jpg',
			'label' => 'HƯỚNG NGHIỆP',
			'title' => 'HƯỚNG NGHIỆP',
			'body' => 'ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm của đội ngũ lãnh đạo trẻ, cùng với sự năng động, sáng tạo, đoàn kết của nhiều lớp nhân viên.
						Sau hơn 9 năm, ECS Global đã khẳng định được vị thế trên thị trường ở các lĩnh vực tuyển sinh, hướng nghiệp khởi nghiệp, việc làm, giáo dục, truyền thông và công nghệ số.',
		),
		array(
			'id' => 'tuyen-sinh',
			'icon' => 'icon-tuyensinh',
			'image' => 'he-sinh-thai/tuyen-sinh.jpg',
			'label' => 'TUYỂN SINH',
			'title' => 'TUYỂN SINH',
			'body' => 'Với mạng lưới đối tác giáo dục đa dạng và hệ thống tư vấn chuyên nghiệp, ECSGES triển khai các giải pháp tuyển sinh linh hoạt, đáp ứng nhu cầu học tập ở nhiều cấp độ và lĩnh vực khác nhau. Chúng tôi hướng tới việc mở rộng cơ hội tiếp cận giáo dục chất lượng cho mọi đối tượng người học.',
		),
		array(
			'id' => 'dao-tao',
			'icon' => 'icon-daotao',
			'image' => 'he-sinh-thai/dao-tao.jpg',
			'label' => 'ĐÀO TẠO',
			'title' => 'ĐÀO TẠO',
			'body' => 'ECSGES phát triển các chương trình đào tạo đa dạng theo định hướng ứng dụng, kết hợp giữa kiến thức chuyên môn, kỹ năng thực tiễn và yêu cầu của thị trường lao động. Chúng tôi chú trọng xây dựng môi trường học tập hiện đại, linh hoạt và phù hợp với xu hướng phát triển của thời đại số.',
		),
		array(
			'id' => 'viec-lam',
			'icon' => 'icon-vieclam',
			'image' => 'he-sinh-thai/viec-lam.jpg',
			'label' => 'VIỆC LÀM',
			'title' => 'VIỆC LÀM',
			'body' => 'Là cầu nối giữa người lao động và doanh nghiệp, ECSGES cung cấp các giải pháp việc làm trong nước và quốc tế, góp phần nâng cao chất lượng nguồn nhân lực và thúc đẩy phát triển nghề nghiệp bền vững. Chúng tôi đồng hành cùng người lao động từ quá trình định hướng, đào tạo đến tìm kiếm cơ hội việc làm phù hợp.',
		),
		array(
			'id' => 'truyen-thong',
			'icon' => 'icon-truyenthong',
			'image' => 'he-sinh-thai/truyen-thong.png',
			'label' => 'TRUYỀN THÔNG',
			'title' => 'TRUYỀN THÔNG',
			'body' => 'ECSGES cung cấp các giải pháp truyền thông toàn diện cho lĩnh vực giáo dục, góp phần nâng cao hình ảnh thương hiệu, tăng cường kết nối với người học và mở rộng sức ảnh hưởng tới cộng đồng. Chúng tôi kết hợp giữa truyền thông hiện đại và tổ chức sự kiện để tạo nên những chiến dịch hiệu quả và bền vững.',
		),
	);
}

/** Tiêu đề dùng chung cho các bài tin (dữ liệu mẫu). */
function ecsges_news_title()
{
	return ecsges_t('Lễ ký kết hợp tác ECS GLOBAL và Học viện Quản lý NanYang');
}

/** Trích dẫn ngắn dưới bài nổi bật. */
function ecsges_news_excerpt()
{
	return ecsges_t('ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm.');
}

/** Ngày của 12 bài tin (chia 4 bài / trang). */
function ecsges_news_dates()
{
	return array(
		'May 29, 2023',
		'Apr 18, 2023',
		'Mar 02, 2023',
		'Feb 11, 2023',
		'Jan 20, 2023',
		'Dec 05, 2022',
		'Nov 14, 2022',
		'Oct 03, 2022',
		'Sep 22, 2022',
		'Aug 09, 2022',
		'Jul 27, 2022',
		'Jun 15, 2022',
	);
}

/** Danh sách bài tin (side list). */
function ecsges_news_items()
{
	$items = array();
	foreach (ecsges_news_dates() as $i => $date) {
		$items[] = array(
			'id' => $i + 1,
			'title' => ecsges_news_title(),
			'date' => $date,
			'href' => '#tin-tuc',
		);
	}
	return $items;
}

/** Bài nổi bật (card lớn). */
function ecsges_featured_news()
{
	$dates = ecsges_news_dates();
	return array(
		'id' => 0,
		'title' => ecsges_news_title(),
		'date' => $dates[0],
		'href' => '#tin-tuc',
	);
}

/**
 * Các cột link trong footer — MẶC ĐỊNH TĨNH.
 *
 * Chỉ dùng khi Theme Options → Footer Settings còn trống (xem
 * ecsges_footer_links() trong inc/theme-options.php). Mỗi link là một cặp
 * nhãn + đích, đích khai bằng ĐÚNG MỘT trong hai khoá:
 *   - 'url' : đường dẫn tĩnh (anchor trùng id section trong page-ve-ecs.php /
 *             template-parts/ptbv-*.php, khớp menu header — xem ecsges_nav_items()).
 *             Đường dẫn 1 cấp được ánh xạ sang Page cùng ngôn ngữ khi render.
 *   - 'cat' : slug chuyên mục → lấy link archive thật lúc render; chuyên mục
 *             chưa tạo thì tự rơi về '#'.
 */
function ecsges_footer_columns()
{
	return array(
		array(
			'title' => 'VỀ ECSGES',
			'links' => array(
				array('label' => 'Hành trình phát triển', 'url' => '/ve-ecs#hanh-trinh-phat-trien'),
				array('label' => 'Tầm nhìn', 'url' => '/ve-ecs#tam-nhin'),
				array('label' => 'Sứ mệnh', 'url' => '/ve-ecs#su-menh'),
				array('label' => 'Giá trị cốt lõi', 'url' => '/ve-ecs#gia-tri-cot-loi'),
			),
		),
		array(
			'title' => 'LĨNH VỰC HOẠT ĐỘNG',
			'links' => array(
				array('label' => 'Hướng nghiệp', 'cat' => 'huong-nghiep'),
				array('label' => 'Tuyển sinh', 'cat' => 'tuyen-sinh'),
				array('label' => 'Đào tạo', 'cat' => 'dao-tao'),
				array('label' => 'Việc làm', 'cat' => 'viec-lam'),
				array('label' => 'Truyền thông', 'cat' => 'truyen-thong'),
			),
		),
		array(
			'title' => 'PHÁT TRIỂN BỀN VỮNG',
			'links' => array(
				array('label' => 'Con người ECS', 'url' => '/phat-trien-ben-vung/#con-nguoi-ecs'),
				array('label' => 'Văn hoá ECS', 'url' => '/phat-trien-ben-vung/#van-hoa-ecs'),
				array('label' => 'Trách nhiệm xã hội', 'url' => '/phat-trien-ben-vung/#trach-nhiem-xa-hoi'),
			),
		),
	);
}

/**
 * Hero slider trang chủ — CẤU HÌNH MẶC ĐỊNH.
 *
 * Chỉ dùng khi Theme Options → Hero Slider còn trống (xem
 * ecsges_hero_slider() trong inc/theme-options.php). 'slides' để rỗng =
 * frontend tự lùi về ảnh banner tĩnh assets/img/hero-banner.jpg, tức giao
 * diện y hệt trước khi có Theme Options.
 */
function ecsges_hero_slider_defaults()
{
	return array(
		'autoplay' => 1,
		'interval' => 5000, // ms mỗi slide đứng yên
		'speed' => 600,     // ms hiệu ứng trượt
		'dots' => 1,
		'nav' => 1,
		'slides' => array(),
	);
}

/** Thông tin liên hệ footer. */
function ecsges_footer_contact()
{
	return array(
		'address' => 'Toà ROX Tower Goldmark City 136 Hồ Tùng Mậu, Phú Diễn, Hà Nội',
		'email' => 'contact@ecs.edu.vn',
		'phone' => '024.668.39.668',
	);
}

/** Danh sách tỉnh/thành cho ô chọn nhanh ở section Chi nhánh. */
function ecsges_branch_provinces()
{
	return array('Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ');
}

/** Gợi ý địa chỉ chi nhánh. */
function ecsges_branch_addresses()
{
	return array(
		'146 Phố Tây Sơn, Đống Đa, Thành phố Hà Nội',
		'146 Phố Tây Sơn, Đống Đa, Thành phố Hà Nội',
	);
}

/* ------------------------------------------------------------------ *\
 * Trang "Về ECS" (port từ data.ts) — nội dung tĩnh
\* ------------------------------------------------------------------ */

/** Đoạn dẫn dưới tiêu đề Hành trình phát triển. */
function ecsges_ve_ecs_intro()
{
	return ecsges_t('Từ những bước đi đầu tiên đến hệ sinh thái giáo dục đa lĩnh vực hôm nay, mỗi giai đoạn phát triển của ECSGES đều gắn liền với khát vọng nâng cao chất lượng giáo dục, mở rộng cơ hội học tập và phát triển nguồn nhân lực cho cộng đồng.');
}

/** Các mốc trên timeline Hành trình phát triển. */
function ecsges_milestones()
{
	return array(
		array(
			'years' => '2004 - 2007',
			'title' => 'ĐẶT NỀN MÓNG',
			'body' => 'Tiền thân là công ty cổ phần HSC hoạt động trong lĩnh vực công nghệ thông tin và thiết bị máy tính.
						Triển khai các giải pháp quản lý đào tạo cho trung tâm tin học.
						Xây dựng nền tảng quản trị và định hướng phát triển trong lĩnh vực giáo dục.',
		),
		array(
			'years' => '2008 - 2018',
			'title' => 'MỞ RỘNG SỨ MỆNH GIÁO DỤC',
			'body' => 'Năm 2008, đổi tên thành công ty cổ phần truyền thông BTS Việt Nam. Chuyển đổi sang các lĩnh vực hướng nghiệp, tuyển sinh và đào tạo.',
		),
		array(
			'years' => '2018 - 2025',
			'title' => 'PHÁT TRIỂN NỘI LỰC VÀ KIỆN TOÀN TỔ CHỨC',
			'body' => 'Năm 2019, đổi tên thành Công ty cổ phần hỗ trợ và phát triển chọn nghề khởi nghiệp ECS Global.
						Mở rộng các pháp nhân.
						Ứng dụng công nghệ và kiện toàn tổ chức.',
		),
		array(
			'years' => '2026',
			'title' => 'PHÁT TRIỂN BỀN VỮNG',
			'body' => 'Năm 2026, đổi tên thành Công ty cổ phần hỗ trợ và phát triển ECSGES, phát triển hệ thống chuỗi văn phòng.',
		),
	);
}

/** Nội dung Tầm nhìn. */
function ecsges_ve_ecs_vision()
{
	return ecsges_t('Trở thành một tổ chức hàng đầu cung cấp sản phẩm, dịch vụ và giải pháp trong lĩnh vực hướng nghiệp, tuyển sinh, đào tạo, việc làm, truyền thông. ECSGES sẽ là doanh nghiệp đáng tin cậy và chuyên nghiệp trong cung cấp nguồn nhân lực chất lượng quốc tế.');
}

/** Các đoạn Sứ mệnh. */
function ecsges_ve_ecs_mission()
{
	return array(
		'Với sứ mệnh nâng tầm nguồn nhân lực Việt Nam, chúng tôi cam kết không ngừng nỗ lực xây dựng những sản phẩm, dịch vụ, giải pháp, có tính thực tiễn, sáng tạo, chuyên nghiệp và giá trị nhất đáp ứng nhu cầu phát triển nguồn nhân lực chất lượng cho xã hội.',
	);
}

/** 5 giá trị cốt lõi. */
function ecsges_core_values()
{
	return array(
		array(
			'key' => 'TÂM',
			'phrase' => 'Tận tâm, tâm lực, tâm hợp',
			'body' => 'ECSGES cam kết phục vụ & hành động với sự tận tâm, nhiệt huyết và đam mê.',
		),
		array(
			'key' => 'TRÍ',
			'phrase' => 'Trí thức, trí tuệ, trí lực',
			'body' => 'Thông qua việc khuyến khích cá nhân và tổ chức học tập, chúng tôi không ngừng phát triển và sáng tạo để đảm bảo chất lượng cao nhất cho từng sản phẩm và dịch vụ của mình.',
		),
		array(
			'key' => 'SÁNG',
			'phrase' => 'Sáng tạo, sáng suốt, sáng rạng',
			'body' => 'ECSGES coi sáng tạo là hạt giống của sự thay đổi và tiến bộ.',
		),
		array(
			'key' => 'BỀN',
			'phrase' => 'Bền vững, bền bỉ, bền chặt',
			'body' => 'ECSGES luôn bền bỉ và kiên định trong việc phát triển sản phẩm và dịch vụ hướng tới giá trị lâu dài cho khách hàng, đối tác và đồng nghiệp.',
		),
		array(
			'key' => 'HỢP',
			'phrase' => 'Hợp lực, hợp nhất, hợp tác',
			'body' => 'ECSGES luôn đề cao sự hợp tác & phát triển. Với tinh thần này, chúng tôi tin rằng đây sẽ là nền tảng để nâng cao sự chuyên nghiệp, bền vững và mở rộng những giải pháp sáng tạo và toàn diện hơn.',
		),
	);
}

/** Các con số ấn tượng (kèm tên file icon trong assets/img/ve-ecs/last-section). */
function ecsges_ve_ecs_stats()
{
	return array(
		array('value' => '20', 'label' => 'Năm thành lập và phát triển', 'icon' => '1.svg'),
		array('value' => '5', 'label' => 'Lĩnh vực hoạt động', 'icon' => '2.svg'),
		array('value' => '20+', 'label' => 'Văn phòng toàn quốc', 'icon' => '3.svg'),
		array('value' => '235.000+', 'label' => 'HSSV được tư vấn', 'icon' => '4.svg'),
		array('value' => '20.000+', 'label' => 'Sinh viên được đào tạo', 'icon' => '5.svg'),
		array('value' => '50+', 'label' => 'Trường học được tư vấn', 'icon' => '6.svg'),
		array('value' => '50+', 'label' => 'Đối tác', 'icon' => '7.svg'),
		array('value' => '200+', 'label' => 'Tiến sĩ, Thạc sĩ, CBNV', 'icon' => '8.svg'),
	);
}

/** Vị trí pin trên bản đồ About (% theo Figma). 'lg' = pin trung tâm. */
function ecsges_about_pins()
{
	return array(
		array('x' => 14.9, 'y' => 45.9),
		array('x' => 18.6, 'y' => 51.3),
		array('x' => 31.0, 'y' => 57.0),
		array('x' => 33.5, 'y' => 70.9),
		array('x' => 35.8, 'y' => 31.8),
		array('x' => 47.2, 'y' => 44.8),
		array('x' => 56.0, 'y' => 52.5, 'lg' => true),
		array('x' => 56.0, 'y' => 35.6),
		array('x' => 56.0, 'y' => 60.4),
		array('x' => 70.5, 'y' => 37.2),
		array('x' => 76.6, 'y' => 42.5),
		array('x' => 85.2, 'y' => 68.6),
		array('x' => 92.0, 'y' => 40.8),
	);
}

/**
 * Lĩnh vực hoạt động — 5 tab. Tab HƯỚNG NGHIỆP dùng text thật (Figma);
 * 4 tab còn lại placeholder (thay nội dung sau). 'image' = tên file trong assets/img.
 */
function ecsges_linh_vuc_tabs()
{
	// Ảnh panel dùng CHUNG với khối "Hệ sinh thái" trang chủ
	// (template-parts/section-ecosystem.php → ecsges_ecosystem_tabs()): lấy theo
	// 'id' để hai nơi không bao giờ lệch nhau khi đổi ảnh. Không hardcode lại
	// tên file, và bỏ placeholder 'ecosystem-content.png' cũ.
	$eco_img = array_column(ecsges_ecosystem_tabs(), 'image', 'id');
	return array(
		array(
			'id' => 'huong-nghiep',
			'label' => 'HƯỚNG NGHIỆP',
			'icon' => 'icon-huongnghiep',
			'image' => $eco_img['huong-nghiep'],
			'title' => 'Định hướng tương lai từ sự thấu hiểu năng lực',
			'paragraph' => 'ECSGES đồng hành cùng học sinh, sinh viên trên hành trình khám phá bản thân, định hình mục tiêu nghề nghiệp và lựa chọn lộ trình học tập phù hợp. Thông qua các chương trình tư vấn, trải nghiệm thực tế và cập nhật xu hướng thị trường lao động, chúng tôi giúp người học xây dựng nền tảng vững chắc để phát triển trong môi trường làm việc hiện đại và hội nhập.
							Các dịch vụ nổi bật:
							- Định hướng nghề nghiệp
							- Lựa chọn ngành học
							- Phát triển kỹ năng',
		),
		array(
			'id' => 'tuyen-sinh',
			'label' => 'TUYỂN SINH',
			'icon' => 'icon-tuyensinh',
			'image' => $eco_img['tuyen-sinh'],
			'title' => 'Kết nối người học với cơ hội phát triển toàn diện',
			'paragraph' => 'Với mạng lưới đối tác giáo dục đa dạng và hệ thống tư vấn chuyên nghiệp, ECSGES triển khai các giải pháp tuyển sinh linh hoạt, đáp ứng nhu cầu học tập ở nhiều cấp độ và lĩnh vực khác nhau. Chúng tôi hướng tới việc mở rộng cơ hội tiếp cận giáo dục chất lượng cho mọi đối tượng người học.
							Các chương trình tuyển sinh:
							- Chính quy Đại học, Cao đẳng
							- Du học
							- Liên thông
							- Chương trình 9+
							- E-Learning
							- Các khóa học ngắn hạn'
		),
		array(
			'id' => 'dao-tao',
			'label' => 'ĐÀO TẠO',
			'icon' => 'icon-daotao',
			'image' => $eco_img['dao-tao'],
			'title' => 'Nâng cao năng lực, gia tăng giá trị nghề nghiệp',
			'paragraph' => 'ECSGES phát triển các chương trình đào tạo đa dạng theo định hướng ứng dụng, kết hợp giữa kiến thức chuyên môn, kỹ năng thực tiễn và yêu cầu của thị trường lao động. Chúng tôi chú trọng xây dựng môi trường học tập hiện đại, linh hoạt và phù hợp với xu hướng phát triển của thời đại số.
							Các lĩnh vực đào tạo:
							- Chính quy Đại học, Cao đẳng
							- Du học
							- Liên thông
							- Kỹ năng
							- Chương trình 9+
							- E-Learning'
		),
		array(
			'id' => 'viec-lam',
			'label' => 'VIỆC LÀM',
			'icon' => 'icon-vieclam',
			'image' => $eco_img['viec-lam'],
			'title' => 'Kết nối nguồn nhân lực với cơ hội nghề nghiệp',
			'paragraph' => 'Là cầu nối giữa người lao động và doanh nghiệp, ECSGES cung cấp các giải pháp việc làm trong nước và quốc tế, góp phần nâng cao chất lượng nguồn nhân lực và thúc đẩy phát triển nghề nghiệp bền vững. Chúng tôi đồng hành cùng người lao động từ quá trình định hướng, đào tạo đến tìm kiếm cơ hội việc làm phù hợp.
							Việc làm trong nước:
							- Lao động phổ thông
							- Lao động thời vụ
							- Lao động tay nghề cao
							- Lao động có kinh nghiệm
							Việc làm quốc tế:
							- Xuất khẩu lao động phổ thông
							- Xuất khẩu lao động kỹ sư'
		),
		array(
			'id' => 'truyen-thong',
			'label' => 'TRUYỀN THÔNG',
			'icon' => 'icon-truyenthong',
			'image' => $eco_img['truyen-thong'],
			'title' => 'Lan tỏa giá trị bằng sức mạnh kết nối',
			'paragraph' => 'ECSGES cung cấp các giải pháp truyền thông toàn diện cho lĩnh vực giáo dục, góp phần nâng cao hình ảnh thương hiệu, tăng cường kết nối với người học và mở rộng sức ảnh hưởng tới cộng đồng. Chúng tôi kết hợp giữa truyền thông hiện đại và tổ chức sự kiện để tạo nên những chiến dịch hiệu quả và bền vững.
							Các dịch vụ chính:
							- Truyền thông online
							- Truyền thông offline
							- Tổ chức sự kiện'
		),
	);
}

/**
 * Bản đồ <id lĩnh vực> => permalink của Page chi tiết.
 *
 * Cùng cách làm với ecsges_jobs_list(): tìm mọi Page đã gán template
 * "Chi tiết lĩnh vực" (page-linh-vuc-chi-tiet.php) rồi ghép với tab qua SLUG
 * của Page. Slug phải trùng 'id' trong ecsges_linh_vuc_tabs()
 * (huong-nghiep / tuyen-sinh / dao-tao / viec-lam / truyen-thong).
 *
 * Khớp chính xác trước; nếu không có thì chấp nhận slug có hậu tố
 * ('huong-nghiep-en' của bản Polylang, hay 'huong-nghiep-2' do WP tự thêm khi
 * trùng slug). Chưa tạo Page nào thì trả mảng rỗng — template render nút bất
 * hoạt thay vì link chết.
 */
function ecsges_linh_vuc_detail_map()
{
	static $map = null;
	if (null !== $map) {
		return $map;
	}

	$q = new WP_Query(array(
		'post_type'      => 'page',
		'posts_per_page' => 50,
		'no_found_rows'  => true,
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'page-linh-vuc-chi-tiet.php',
	));

	$map = array();
	$ids = array_column(ecsges_linh_vuc_tabs(), 'id');

	// Vòng 1: slug trùng khít. Vòng 2 (chỉ cho id còn trống): slug có hậu tố.
	foreach ($q->posts as $p) {
		if (in_array($p->post_name, $ids, true)) {
			$map[$p->post_name] = get_permalink($p);
		}
	}
	foreach ($q->posts as $p) {
		foreach ($ids as $id) {
			if (!isset($map[$id]) && 0 === strpos($p->post_name, $id . '-')) {
				$map[$id] = get_permalink($p);
				break;
			}
		}
	}
	return $map;
}

/** URL Page chi tiết của 1 lĩnh vực; '' nếu chưa tạo Page tương ứng. */
function ecsges_linh_vuc_detail_url($id)
{
	$map = ecsges_linh_vuc_detail_map();
	return isset($map[$id]) ? $map[$id] : '';
}

/**
 * Phát triển bền vững — carousel nhân sự (placeholder). 'image' = tên file trong assets/img.
 */
function ecsges_ptbv_team()
{
	$img = 'phat-trien-ben-vung/image.png'; // ảnh chân dung (thay ảnh thật từng người sau)
	$people = array();
	for ($i = 0; $i < 6; $i++) {
		$people[] = array(
			'name' => 'Phan Trần Duy Đạt',
			'title' => 'Giám đốc kinh doanh',
			'image' => $img,
		);
	}
	return $people;
}

/**
 * Phát triển bền vững — 3 giá trị (TẬN TÂM / ĐỒNG HÀNH / ĐỔI MỚI). Theo Figma:
 * thẻ có viền + icon line + ảnh; mô tả ẩn, chỉ hiện khi hover (nền cam + "Xem thêm").
 * 'icon' = file svg icon line trong assets/img; 'image' = ảnh minh hoạ; 'href' = link "Xem thêm".
 */
function ecsges_ptbv_values()
{
	$base = 'phat-trien-ben-vung/';
	return array(
		array(
			'title' => 'TẬN TÂM',
			'icon' => $base . '1.svg',
			'image' => $base.'tan-tan.jpg',
			'href' => '#',
			'category' => 'tan-tam', // nút "Xem thêm" → /category/tan-tam/ (tạo trong admin)
			'text' => 'Chúng tôi tin rằng sự tận tâm là nền tảng của mọi giá trị bền vững. Mỗi cán bộ, giảng viên và chuyên gia của ECSGES luôn làm việc bằng trách nhiệm, sự chân thành và tinh thần phụng sự, hướng đến lợi ích của người học, đối tác và cộng đồng.',
		),
		array(
			'title' => 'ĐỒNG HÀNH',
			'icon' => $base . '2.svg',
			'image' => $base.'dong-hanh.jpg',
			'href' => '#',
			'category' => 'dong-hanh', // nút "Xem thêm" → /category/dong-hanh/ (tạo trong admin)
			'text' => 'ECSGES không chỉ cung cấp dịch vụ giáo dục mà còn đồng hành cùng người học trên từng chặng đường phát triển. Từ định hướng nghề nghiệp, lựa chọn ngành học đến quá trình học tập và phát triển sự nghiệp, chúng tôi luôn là người bạn đồng hành đáng tin cậy.',
		),
		array(
			'title' => 'ĐỔI MỚI',
			'icon' => $base . '3.svg',
			'image' => $base.'doi-moi.jpg',
			'href' => '#',
			'category' => 'doi-moi', // nút "Xem thêm" → /category/doi-moi/ (tạo trong admin)
			'text' => 'Đổi mới là động lực để ECSGES không ngừng phát triển. Với tư duy mở và tinh thần tiên phong, chúng tôi liên tục cập nhật xu hướng, nâng cao chất lượng và kiến tạo những giá trị mới nhằm đáp ứng yêu cầu của thời đại hội nhập.',
		),
	);
}

/**
 * Phát triển bền vững — VĂN HÓA ECS. Theo Figma (node 715-573): 3 thẻ hiện cùng lúc,
 * mỗi thẻ = icon + gạch + tiêu đề + ảnh (giống cấu trúc CON NGƯỜI ECS) — 'icon'/'image'
 * xuất trực tiếp từ Figma, 'category' → nút "Xem thêm" trỏ /category/{slug}/ (tạo trong admin).
 */
function ecsges_ptbv_culture()
{
	$base = 'phat-trien-ben-vung/';
	return array(
		array(
			'title'    => 'HỌC HỎI',
			'icon'     => $base . 'hoc-hoi.svg',
			'image'    => $base . 'hoc-hoi.jpg',
			'category' => 'hoc-hoi',
			'text'     => 'ECSGES xây dựng môi trường khuyến khích học tập và phát triển liên tục. Thông qua các chương trình đào tạo nội bộ, hoạt động chia sẻ chuyên môn và cơ hội tham gia các khóa học nâng cao, đội ngũ cán bộ, giảng viên và nhân viên luôn được tạo điều kiện để cập nhật kiến thức, rèn luyện kỹ năng và phát triển năng lực nghề nghiệp.',
		),
		array(
			'title'    => 'HỢP TÁC',
			'icon'     => $base . 'hop-tac.svg',
			'image'    => $base . 'hop-tac.jpg',
			'category' => 'hop-tac',
			'text'     => 'ECSGES coi hợp tác là nền tảng để mở rộng giá trị. Chúng tôi chủ động kết nối với doanh nghiệp, tổ chức giáo dục và đối tác trong, ngoài nước để cùng xây dựng chương trình đào tạo chất lượng, tạo cơ hội thực tập, việc làm và phát triển bền vững cho người học.',
		),
		array(
			'title'    => 'PHỤNG SỰ',
			'icon'     => $base . 'phung-su.svg',
			'image'    => $base . 'phung-su.jpg',
			'category' => 'phung-su',
			'text'     => 'Phụng sự là kim chỉ nam trong mọi hoạt động của ECSGES. Mỗi cán bộ, giảng viên luôn đặt lợi ích của người học và cộng đồng lên hàng đầu, tận tụy đồng hành và hỗ trợ để mang lại những giá trị giáo dục thiết thực, góp phần xây dựng một xã hội học tập bền vững.',
		),
	);
}

/**
 * Phát triển bền vững — TRÁCH NHIỆM XÃ HỘI. Theo Figma (node 715-573): cùng cấu trúc
 * thẻ icon+gạch+tiêu đề+ảnh như 2 khối trên (không còn thẻ text-only tô nền cam cố định).
 * Icon KHUYẾN HỌC xuất trực tiếp từ Figma; icon CỘNG ĐỒNG/PHÁT TRIỂN Figma chưa vẽ nên
 * tự vẽ tạm theo đúng phong cách (stroke #F05A28 width 2) — thay bằng bản Figma khi có.
 */
function ecsges_ptbv_responsibility()
{
	$base = 'phat-trien-ben-vung/';
	return array(
		array(
			'title'    => 'KHUYẾN HỌC',
			'icon'     => $base . 'khuyen-hoc.svg',
			'image'    => $base . 'khuyen-hoc.jpg',
			'category' => 'khuyen-hoc',
			'text'     => 'Lan tỏa cơ hội học tập và tiếp cận giáo dục cho nhiều đối tượng trong cộng đồng, đồng hành cùng học sinh, sinh viên có hoàn cảnh khó khăn thông qua học bổng và các chương trình hỗ trợ thiết thực.',
		),
		array(
			'title'    => 'CỘNG ĐỒNG',
			'icon'     => $base . 'cong-dong.svg',
			'image'    => $base . 'cong-dong.jpg',
			'category' => 'cong-dong',
			'text'     => 'Gắn kết và sẻ chia cùng cộng đồng qua các hoạt động thiện nguyện, kết nối các thế hệ và lan tỏa tinh thần tương thân tương ái trong xã hội.',
		),
		array(
			'title'    => 'PHÁT TRIỂN',
			'icon'     => $base . 'phat-trien.svg',
			'image'    => $base . 'phat-trien.jpg',
			'category' => 'phat-trien',
			'text'     => 'Đồng hành cùng thế hệ trẻ trên hành trình hội nhập, sáng tạo và kiến tạo giá trị cho xã hội, góp phần phát triển nguồn nhân lực chất lượng cao phục vụ đất nước.',
		),
	);
}

/**
 * Phát triển bền vững — 4 thẻ hướng dẫn (dưới banner "Click here").
 * 'image' = tên file trong assets/img.
 */
function ecsges_ptbv_guides()
{
	$base = 'phat-trien-ben-vung/';
	return array(
		array('image' => $base . '1.png', 'title' => 'Hướng dẫn nạp tiền', 'href' => '#'),
		array('image' => $base . '2.png', 'title' => 'Hướng dẫn kích hoạt gói', 'href' => '#'),
		array('image' => $base . '3.png', 'title' => 'Hướng dẫn KYC tài khoản', 'href' => '#'),
		array('image' => $base . '4.png', 'title' => 'Hướng dẫn kích hoạt gói trả góp', 'href' => '#'),
	);
}

/** Bộ lọc Tuyển dụng — danh sách khu vực. */
function ecsges_job_areas()
{
	return array(
		'Hà Nội',
		'Bắc Ninh',
		'Hải Phòng',
		'Hải Dương',
	);
}

/** Bộ lọc Tuyển dụng — danh sách phòng ban. */
function ecsges_job_departments()
{
	return array(
		'Phòng Tuyển sinh',
		'Phòng Đào tạo',
		'Phòng Hành chính',
		'Phòng Nhân sự',
		'Phòng Tài chính kế toán',
		'Phòng Dịch vụ công tác học sinh sinh viên',
		'Phòng Hỗ trợ doanh nghiệp và khởi nghiệp',
		'Phòng Hợp tác quốc tế',
		'Phòng Marketing',
		'Phòng Công nghệ thông tin và Truyền thông',
		'Phòng Khảo thí và đảm bảo chất lượng',
		'Phòng Pháp chế',
		'Khối giảng viên',
	);
}

/** Bộ lọc Tuyển dụng — danh sách loại công việc. */
function ecsges_job_types()
{
	return array(
		'Toàn thời gian',
		'Bán thời gian',
		'Thực tập',
	);
}

/** Danh sách việc làm đang tuyển (trang Tuyển dụng). */
function ecsges_jobs()
{
	return array(
		array(
			'title' => 'Nhân viên Digital Marketing',
			'location' => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type' => 'Toàn thời gian',
			'deadline' => 'Thời hạn: 20/7/2026',
			'tag' => 'hot',
		),
		array(
			'title' => 'Nhân viên Digital Marketing',
			'location' => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type' => 'Toàn thời gian',
			'deadline' => 'Thời hạn: 20/7/2026',
			'tag' => 'new',
		),
		array(
			'title' => 'Nhân viên Media',
			'location' => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type' => 'Toàn thời gian',
			'deadline' => 'Thời hạn: 20/7/2026',
			'tag' => 'new',
		),
		array(
			'title' => 'Nhân viên Designer',
			'location' => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type' => 'Toàn thời gian',
			'deadline' => 'Thời hạn: 20/7/2026',
			'tag' => 'new',
		),
	);
}

/**
 * Danh sách job hiển thị ở trang Tuyển dụng. Ưu tiên Page thật đã gán
 * template "Chi tiết tuyển dụng" (page-tuyen-dung-chi-tiet.php) — có Page
 * thật thì BỎ HẲN hardcode, không merge. Chưa có Page nào → fallback
 * ecsges_jobs() để trang không bao giờ trống.
 *
 * Nếu Polylang đang hoạt động, WP_Query này tự lọc theo ngôn ngữ hiện tại —
 * một job Page chỉ tồn tại ở 1 ngôn ngữ sẽ không hiện ở danh sách ngôn ngữ
 * kia (rơi về fallback hardcode ở ngôn ngữ đó). Đây là hành vi mong muốn/an
 * toàn, chỉ ghi chú lại vì không hiển nhiên.
 */
function ecsges_jobs_list()
{
	$q = new WP_Query(array(
		'post_type'      => 'page',
		'posts_per_page' => 100,
		'no_found_rows'  => true,
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-tuyen-dung-chi-tiet.php',
		'orderby' => 'date',
		'order' => 'DESC',
	));

	if (empty($q->posts)) {
		$fallback = ecsges_jobs();
		foreach ($fallback as &$job) {
			$job['href'] = '';
		}
		unset($job);
		return $fallback;
	}

	$jobs = array();
	foreach ($q->posts as $p) {
		$jobs[] = array(
			'title' => get_the_title($p),
			'location' => ecsges_field_page($p->ID, 'job_location', ''),
			'department' => ecsges_field_page($p->ID, 'job_department', ''),
			'type' => ecsges_field_page($p->ID, 'job_type', ''),
			'deadline' => ecsges_field_page($p->ID, 'job_deadline', ''),
			'tag' => (function_exists('get_field') && get_field('job_hot', $p->ID)) ? 'hot' : '',
			'href' => get_permalink($p),
		);
	}
	return $jobs;
}


/**
 * Trang Đối tác — 4 khối logo (Figma node 539:372).
 *
 * 'logos' theo đúng thứ tự đọc trong Figma (trái→phải, trên→dưới). Mỗi logo giữ
 * 'w'/'h' = kích thước px riêng của nó trong Figma; ô card luôn 233x153 nên logo
 * KHÔNG scale đồng loạt, chỉ căn giữa trong ô ở đúng cỡ thiết kế.
 *
 * File ảnh export trực tiếp từ Figma (@2x) vào assets/img/doi-tac/, đặt tên theo
 * <khối>-<số thứ tự> để thêm/bớt logo không phải đổi tên file đang có.
 *
 * GHI CHÚ: trong Figma khối 1 vẽ 7 ô nhưng 4 ô chưa có logo — đã bỏ, chỉ render
 * logo thật. Thêm logo mới = thêm phần tử vào mảng, không cần sửa template/SCSS.
 */
function ecsges_partner_groups()
{
	return array(
		array(
			'title' => 'ĐỐI TÁC GIÁO DỤC TRONG NƯỚC',
			'logos' => array(
				array('file' => 'gd-trong-nuoc-01.png', 'alt' => 'Đại học Đông Đô', 'w' => 146, 'h' => 147),
				array('file' => 'gd-trong-nuoc-02.png', 'alt' => 'Đại học Sao Đỏ', 'w' => 107, 'h' => 115),
				array('file' => 'gd-trong-nuoc-03.png', 'alt' => 'Đại học Công nghệ Giao thông Vận tải', 'w' => 179, 'h' => 110),
				array('file' => 'gd-trong-nuoc-04.png', 'alt' => 'Đại học FPT', 'w' => 194, 'h' => 76),
				array('file' => 'gd-trong-nuoc-05.png', 'alt' => 'Đại học Kinh doanh và Công nghệ Hà Nội', 'w' => 177, 'h' => 113),
				array('file' => 'gd-trong-nuoc-06.png', 'alt' => 'Đại học Đại Nam', 'w' => 132, 'h' => 120),
				array('file' => 'gd-trong-nuoc-07.png', 'alt' => 'Cao đẳng Y Dược Tuệ Tĩnh Hà Nội', 'w' => 125, 'h' => 125),
				array('file' => 'gd-trong-nuoc-08.png', 'alt' => 'Cao đẳng Quốc tế Hà Nội', 'w' => 186, 'h' => 80),
				array('file' => 'gd-trong-nuoc-09.png', 'alt' => 'Đại học Hòa Bình', 'w' => 312, 'h' => 272),
				array('file' => 'gd-trong-nuoc-10.png', 'alt' => 'Học viện Báo chí và Tuyên truyền', 'w' => 228, 'h' => 230),
			),
		),
		array(
			'title' => 'ĐỐI TÁC GIÁO DỤC QUỐC TẾ',
			'logos' => array(
				array('file' => 'gd-quoc-te-01.png', 'alt' => 'Royal Roads University', 'w' => 146, 'h' => 106),
				array('file' => 'gd-quoc-te-02.png', 'alt' => 'Griffith University', 'w' => 118, 'h' => 111),
				array('file' => 'gd-quoc-te-03.png', 'alt' => 'Trine University', 'w' => 178, 'h' => 119),
				array('file' => 'gd-quoc-te-04.png', 'alt' => 'Nanyang Institute of Management', 'w' => 130, 'h' => 118),
				array('file' => 'gd-quoc-te-05.png', 'alt' => 'Academies Australasia', 'w' => 193, 'h' => 109),
				array('file' => 'gd-quoc-te-06.png', 'alt' => 'Guangdong City Technician College', 'w' => 182, 'h' => 120),
				array('file' => 'gd-quoc-te-07.png', 'alt' => 'Junior Achievement', 'w' => 204, 'h' => 68),
				array('file' => 'gd-quoc-te-08.png', 'alt' => 'Cheongam College', 'w' => 193, 'h' => 61),
				array('file' => 'gd-quoc-te-09.png', 'alt' => 'LAS Liberal Arts School', 'w' => 200, 'h' => 77),
				array('file' => 'gd-quoc-te-10.png', 'alt' => 'Gyeonggi University of Science and Technology', 'w' => 218, 'h' => 81),
				// TODO: logo không chứa tên đầy đủ, cần client xác nhận tên đối tác.
				array('file' => 'gd-quoc-te-11.png', 'alt' => 'Đối tác giáo dục quốc tế', 'w' => 173, 'h' => 116),
				array('file' => 'gd-quoc-te-12.png', 'alt' => 'Mohawk College', 'w' => 198, 'h' => 42),
				array('file' => 'gd-quoc-te-13.png', 'alt' => 'Songgok University', 'w' => 114, 'h' => 114),
				array('file' => 'gd-quoc-te-14.svg', 'alt' => 'Suseong University', 'w' => 105, 'h' => 105),
				array('file' => 'gd-quoc-te-15.png', 'alt' => 'Gimhae College', 'w' => 99, 'h' => 100),
			),
		),
		array(
			'title' => 'ĐỐI TÁC DOANH NGHIỆP TRONG NƯỚC',
			'logos' => array(
				array('file' => 'dn-trong-nuoc-01.png', 'alt' => 'HiUPWork', 'w' => 188, 'h' => 81),
				array('file' => 'dn-trong-nuoc-02.svg', 'alt' => 'BYD', 'w' => 149, 'h' => 29),
				array('file' => 'dn-trong-nuoc-03.png', 'alt' => 'Chery', 'w' => 176, 'h' => 67),
				array('file' => 'dn-trong-nuoc-04.png', 'alt' => 'FPT Shop', 'w' => 209, 'h' => 57),
				array('file' => 'dn-trong-nuoc-05.png', 'alt' => 'Bell System24', 'w' => 178, 'h' => 49),
				array('file' => 'dn-trong-nuoc-06.png', 'alt' => 'Viettel', 'w' => 183, 'h' => 39),
				array('file' => 'dn-trong-nuoc-07.png', 'alt' => 'VPBank', 'w' => 197, 'h' => 45),
				array('file' => 'dn-trong-nuoc-08.png', 'alt' => 'TPBank', 'w' => 197, 'h' => 51),
				array('file' => 'dn-trong-nuoc-09.png', 'alt' => 'FAST', 'w' => 179, 'h' => 54),
				array('file' => 'dn-trong-nuoc-10.png', 'alt' => 'Nét Huế', 'w' => 183, 'h' => 114),
				// TODO: logo không chứa tên đầy đủ, cần client xác nhận tên đối tác.
				array('file' => 'dn-trong-nuoc-11.png', 'alt' => 'Đối tác doanh nghiệp trong nước', 'w' => 141, 'h' => 88),
				array('file' => 'dn-trong-nuoc-12.png', 'alt' => 'Hanoi Tax', 'w' => 209, 'h' => 53),
				array('file' => 'dn-trong-nuoc-13.png', 'alt' => 'Sen Tây Hồ', 'w' => 161, 'h' => 95),
				array('file' => 'dn-trong-nuoc-14.png', 'alt' => 'WinCommerce', 'w' => 194, 'h' => 27),
				array('file' => 'dn-trong-nuoc-15.png', 'alt' => 'Vinpearl', 'w' => 179, 'h' => 116),
			),
		),
		array(
			'title' => 'ĐỐI TÁC DOANH NGHIỆP QUỐC TẾ',
			'logos' => array(
				array('file' => 'dn-quoc-te-01.png', 'alt' => 'Honda', 'w' => 188, 'h' => 80),
				array('file' => 'dn-quoc-te-02.png', 'alt' => 'InterContinental', 'w' => 204, 'h' => 73),
				array('file' => 'dn-quoc-te-03.png', 'alt' => 'Goertek', 'w' => 186, 'h' => 72),
				array('file' => 'dn-quoc-te-04.png', 'alt' => 'LG Display', 'w' => 198, 'h' => 81),
				array('file' => 'dn-quoc-te-05.png', 'alt' => 'LG Electronics', 'w' => 195, 'h' => 29),
				array('file' => 'dn-quoc-te-06.png', 'alt' => 'Daikin', 'w' => 199, 'h' => 43),
				array('file' => 'dn-quoc-te-07.png', 'alt' => 'Foxconn', 'w' => 206, 'h' => 116),
				array('file' => 'dn-quoc-te-08.png', 'alt' => 'Lotte Hotels', 'w' => 186, 'h' => 82),
				array('file' => 'dn-quoc-te-09.png', 'alt' => 'AEON', 'w' => 158, 'h' => 53),
			),
		),
	);
}

/**
 * Trang Tin tức — 6 tab chủ đề (Figma node 548:9518, hàng y=766).
 *
 * 'cat' = slug category; rỗng = chính trang này (tab "ECSGES" = tất cả tin).
 * Tab render bằng <a> trỏ tới archive category thật (render bởi category.php),
 * KHÔNG phải tab chuyển nội dung tại chỗ.
 * 'icon' = tên file svg (không đuôi) trong assets/img — dùng lại đúng 5 icon
 * của "Lĩnh vực hoạt động" (ecsges_ecosystem_tabs()) vì 5 tab sau trùng tên;
 * tab "ECSGES" dùng logo mark (hero-mark.svg, vốn tô đặc màu cam) thay vì icon
 * outline — template gắn thêm class .ecs-ecosystem__icon--fill để ép fill
 * theo currentColor, ăn theo đúng màu ghi/trắng-khi-hover của các icon kia.
 */
function ecsges_news_tabs()
{
	return array(
		array('label' => 'ECSGES', 'cat' => '', 'icon' => 'hero-mark'),
		array('label' => 'HƯỚNG NGHIỆP', 'cat' => 'huong-nghiep', 'icon' => 'icon-huongnghiep'),
		array('label' => 'TUYỂN SINH', 'cat' => 'tuyen-sinh', 'icon' => 'icon-tuyensinh'),
		array('label' => 'ĐÀO TẠO', 'cat' => 'dao-tao', 'icon' => 'icon-daotao'),
		array('label' => 'VIỆC LÀM', 'cat' => 'viec-lam', 'icon' => 'icon-vieclam'),
		array('label' => 'TRUYỀN THÔNG', 'cat' => 'truyen-thong', 'icon' => 'icon-truyenthong'),
	);
}

/**
 * Khối "TIN NỔI BẬT": 1 bài lớn (cột trái 816px) + 2 bài nhỏ (cột phải 413px).
 *
 * GIAI ĐOẠN 1: hardcode theo nội dung placeholder trong Figma. GIAI ĐOẠN 2: đổi
 * thân hàm sang WP_Query (markup và SCSS không phải sửa).
 */
function ecsges_news_featured()
{
	$title   = 'Lễ ký kết hợp tác ECS GLOBAL và Học viện Quản lý NanYang';
	$excerpt = 'ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm.';
	$img     = 'tin-tuc/news-placeholder.jpg';

	return array(
		'main' => array('title' => $title, 'excerpt' => $excerpt, 'img' => $img, 'href' => '#'),
		'side' => array(
			array('title' => $title, 'img' => $img, 'href' => '#'),
			array('title' => $title, 'img' => $img, 'href' => '#'),
		),
	);
}

/**
 * Khối "KIẾN THỨC": lưới 3 card/trang, phân trang bằng JS thuần
 * (dùng lại initNewsPagination() qua các attribute data-news*).
 *
 * Figma vẽ 6 dot → 18 item = 6 trang x 3. Cùng ghi chú GIAI ĐOẠN 1/2 như trên.
 */
function ecsges_news_knowledge()
{
	$items = array();
	for ($i = 0; $i < 18; $i++) {
		$items[] = array(
			'title' => 'Lễ ký kết hợp tác ECS GLOBAL và Học viện Quản lý NanYang',
			'excerpt' => 'ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm.',
			'img' => 'tin-tuc/news-placeholder.jpg',
			'href' => '#',
		);
	}
	return $items;
}

/**
 * Trang chủ — khối TIN TỨC, 4 tab "loại tin" (Figma mẫu: Tin tức / Sự kiện /
 * Hình ảnh / Video). Khoá = SLUG CHUYÊN MỤC thật trong WordPress; template
 * gom bài của cả 4 chuyên mục này rồi để initNewsFilter() lọc tại chỗ.
 *
 * Chuyên mục chưa được tạo trong admin thì tab vẫn hiện nhưng rỗng — đó là
 * hành vi cố ý, không phải lỗi.
 */
function ecsges_news_types()
{
	return array(
		'tin-tuc' => 'Tin tức',
		'su-kien' => 'Sự kiện',
		'hinh-anh' => 'Hình ảnh',
		'video' => 'Video',
	);
}

/**
 * Trang chủ — khối TIN TỨC, select "Định dạng". Khoá là giá trị của
 * data-format trên card, lấy từ field ACF 'media_type' (mỗi bài tự chọn
 * Hình ảnh/Video trong màn sửa bài — xem inc/acf-fields.php), KHÔNG dùng
 * post format gốc của WordPress nữa.
 */
function ecsges_news_formats()
{
	return array(
		'hinh-anh' => 'Hình ảnh',
		'video' => 'Video',
	);
}

/**
 * Giá trị field 'media_type' của một bài, mặc định 'hinh-anh' nếu ACF chưa
 * bật hoặc bài chưa từng lưu field (khớp default_value khai trong
 * inc/acf-fields.php nên bài cũ vẫn lọc đúng thay vì rơi vào diện rỗng).
 *
 * @param int $post_id
 * @return string
 */
function ecsges_news_format_key($post_id)
{
	if (function_exists('get_field')) {
		$value = get_field('media_type', $post_id);
		if ('video' === $value || 'hinh-anh' === $value) {
			return $value;
		}
	}
	return 'hinh-anh';
}
