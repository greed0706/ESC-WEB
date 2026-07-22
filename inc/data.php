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
			'label' => 'HƯỚNG NGHIỆP',
			'title' => 'HƯỚNG NGHIỆP',
			'body' => 'ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm của đội ngũ lãnh đạo trẻ, cùng với sự năng động, sáng tạo, đoàn kết của nhiều lớp nhân viên. Sau hơn 9 năm, ECS Global đã khẳng định được vị thế trên thị trường ở các lĩnh vực tuyển sinh, hướng nghiệp khởi nghiệp, việc làm, giáo dục, truyền thông và công nghệ số.',
		),
		array(
			'id' => 'tuyen-sinh',
			'icon' => 'icon-tuyensinh',
			'label' => 'TUYỂN SINH',
			'title' => 'TUYỂN SINH',
			'body' => 'Kết nối người học với các chương trình đào tạo trong và ngoài nước, ECSGES tư vấn lộ trình phù hợp với năng lực, nguyện vọng và điều kiện của từng cá nhân trên hành trình chinh phục tri thức.',
		),
		array(
			'id' => 'dao-tao',
			'icon' => 'icon-daotao',
			'label' => 'ĐÀO TẠO',
			'title' => 'ĐÀO TẠO',
			'body' => 'Hệ thống chương trình đào tạo bám sát thực tiễn, trang bị kiến thức và kỹ năng cần thiết giúp người học sẵn sàng thích ứng và phát triển trong môi trường làm việc hiện đại.',
		),
		array(
			'id' => 'viec-lam',
			'icon' => 'icon-vieclam',
			'label' => 'VIỆC LÀM',
			'title' => 'VIỆC LÀM',
			'body' => 'Mạng lưới đối tác doanh nghiệp rộng khắp mở ra cơ hội thực tập và việc làm, đồng hành cùng người học từ khi rời ghế nhà trường đến khi vững vàng trong sự nghiệp.',
		),
		array(
			'id' => 'truyen-thong',
			'icon' => 'icon-truyenthong',
			'label' => 'TRUYỀN THÔNG',
			'title' => 'TRUYỀN THÔNG',
			'body' => 'Lan toả tri thức và giá trị tích cực tới cộng đồng thông qua các kênh truyền thông và nền tảng công nghệ số, kết nối con người với cơ hội học tập và phát triển.',
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

/** Các cột link trong footer. */
function ecsges_footer_columns()
{
	return array(
		array(
			'title' => 'VỀ ECSGES',
			'links' => array('Hành trình phát triển', 'Tầm nhìn', 'Sứ mệnh', 'Giá trị cốt lõi'),
		),
		array(
			'title' => 'LĨNH VỰC HOẠT ĐỘNG',
			'links' => array('Hướng nghiệp', 'Tuyển sinh', 'Đào tạo', 'Việc làm', 'Truyền thông'),
		),
		array(
			'title' => 'PHÁT TRIỂN BỀN VỮNG',
			'links' => array('Văn hoá ECS', 'Con người ECS', 'Trách nhiệm xã hội'),
		),
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
			'title' => 'CHUYỂN ĐỔI LĨNH VỰC',
			'body' => 'Năm 2008, đổi tên thành công ty cổ phần truyền thông BTS Việt NamChuyển đổi sang các lĩnh vực hướng nghiệp, tuyển sinh và đào tạo.',
		),
		array(
			'years' => '2019 - 2025',
			'title' => 'PHÁT TRIỂN NỘI LỰC VÀ KIỆN TOÀN TỔ CHỨC',
			'body' => 'Năm 2019, đổi tên thành Công ty cổ phần hỗ trợ và phát triển chọn nghề khởi nghiệp ECS Global
Mở rộng các pháp nhân
Ứng dụng công nghệ và kiện toàn tổ chức',
		),
		array(
			'years' => '2026',
			'title' => 'PHÁT TRIỂN BỀN VỮNG',
			'body' => 'Năm 2026, đổi tên thành Công ty cổ phần hỗ trợ và phát triển ECSGES, phát triển hệ thống chuỗi văn phòng',
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
		'Với sứ mệnh nâng tầm nguồn nhân lực Việt Nam, chúng tôi cam kết không ngừng nỗ lực xây dựng những sản phẩm, dịch vụ, giải pháp, có tính thực tiễn, sáng tạo, chuyên nghiệp và giá trị nhất đáp ứng nhu cầu phát triển nguồn nhân lực chất lượng cho xã hội. ',
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
		array('value' => '20+ năm', 'label' => 'Thành lập', 'icon' => '1.svg'),
		array('value' => '05', 'label' => 'Lĩnh vực hoạt động', 'icon' => '2.svg'),
		array('value' => '50+', 'label' => 'Chi nhánh văn phòng quốc tế', 'icon' => '3.svg'),
		array('value' => '235.000+', 'label' => 'Tư vấn, định hướng nghề nghiệp cho học sinh, sinh viên', 'icon' => '4.svg'),
		array('value' => '20.000+', 'label' => 'Đào tạo sinh viên Đại học, Cao đẳng', 'icon' => '5.svg'),
		array('value' => '50+', 'label' => 'Hỗ trợ và tư vấn trường Đại học, Cao đẳng, Trung cấp, liên cấp', 'icon' => '6.svg'),
		array('value' => '2000+', 'label' => 'Đối tác, tổ chức hỗ trợ và phát triển', 'icon' => '7.svg'),
		array('value' => '150+', 'label' => 'Tiến sĩ, Thạc sĩ', 'icon' => '8.svg'),
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
	$img = 'ecosystem-content.png'; // placeholder ảnh panel — thay ảnh thật sau
	return array(
		array(
			'id' => 'huong-nghiep',
			'label' => 'HƯỚNG NGHIỆP',
			'image' => $img,
			'paragraph' => 'Định hướng tương lai từ sự thấu hiểu năng lực
							ECSGES đồng hành cùng học sinh, sinh viên trên hành trình khám phá bản thân, định hình mục tiêu nghề nghiệp và lựa chọn lộ trình học tập phù hợp. Thông qua các chương trình tư vấn, trải nghiệm thực tế và cập nhật xu hướng thị trường lao động, chúng tôi giúp người học xây dựng nền tảng vững chắc để phát triển trong môi trường làm việc hiện đại và hội nhập.
							Các dịch vụ nổi bật:
							- Định hướng nghề nghiệp
							- Lựa chọn ngành học
							- Phát triển kỹ năng',
		),
		array(
			'id' => 'tuyen-sinh',
			'label' => 'TUYỂN SINH',
			'image' => $img,
			'paragraph' => 'Kết nối người học với cơ hội phát triển toàn diện
							Với mạng lưới đối tác giáo dục đa dạng và hệ thống tư vấn chuyên nghiệp, ECSGES triển khai các giải pháp tuyển sinh linh hoạt, đáp ứng nhu cầu học tập ở nhiều cấp độ và lĩnh vực khác nhau. Chúng tôi hướng tới việc mở rộng cơ hội tiếp cận giáo dục chất lượng cho mọi đối tượng người học.
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
			'image' => $img,
			'paragraph' => 'Nâng cao năng lực, gia tăng giá trị nghề nghiệp
							ECSGES phát triển các chương trình đào tạo đa dạng theo định hướng ứng dụng, kết hợp giữa kiến thức chuyên môn, kỹ năng thực tiễn và yêu cầu của thị trường lao động. Chúng tôi chú trọng xây dựng môi trường học tập hiện đại, linh hoạt và phù hợp với xu hướng phát triển của thời đại số.
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
			'image' => $img,
			'paragraph' => 'Kết nối nguồn nhân lực với cơ hội nghề nghiệp
							Là cầu nối giữa người lao động và doanh nghiệp, ECSGES cung cấp các giải pháp việc làm trong nước và quốc tế, góp phần nâng cao chất lượng nguồn nhân lực và thúc đẩy phát triển nghề nghiệp bền vững. Chúng tôi đồng hành cùng người lao động từ quá trình định hướng, đào tạo đến tìm kiếm cơ hội việc làm phù hợp.
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
			'image' => $img,
			'paragraph' => 'Lan tỏa giá trị bằng sức mạnh kết nối
							ECSGES cung cấp các giải pháp truyền thông toàn diện cho lĩnh vực giáo dục, góp phần nâng cao hình ảnh thương hiệu, tăng cường kết nối với người học và mở rộng sức ảnh hưởng tới cộng đồng. Chúng tôi kết hợp giữa truyền thông hiện đại và tổ chức sự kiện để tạo nên những chiến dịch hiệu quả và bền vững.
							Các dịch vụ chính:
							- Truyền thông online
							- Truyền thông offline
							- Tổ chức sự kiện'
		),
	);
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
 * Phát triển bền vững — 3 giá trị, mỗi giá trị 1 icon tròn. Chỉ TẬN TÂM có mô tả (theo Figma).
 * 'icon' = tên file svg trong assets/img.
 */
function ecsges_ptbv_values()
{
	return array(
		array(
			'title' => 'TẬN TÂM',
			'icon' => 'phat-trien-ben-vung/tan-tam.svg',
			'text' => 'Chúng tôi tin rằng sự tận tâm là nền tảng của mọi giá trị bền vững. Mỗi cán bộ, giảng viên và chuyên gia của ECSGES luôn làm việc bằng trách nhiệm, sự chân thành và tinh thần phụng sự, hướng đến lợi ích của người học, đối tác và cộng đồng.',
		),
		array(
			'title' => 'ĐỒNG HÀNH',
			'icon' => 'phat-trien-ben-vung/dong-hanh.svg',
			'text' => 'ECSGES không chỉ cung cấp dịch vụ giáo dục mà còn đồng hành cùng người học trên từng chặng đường phát triển. Từ định hướng nghề nghiệp, lựa chọn ngành học đến quá trình học tập và phát triển sự nghiệp, chúng tôi luôn là người bạn đồng hành đáng tin cậy.',
		),
		array(
			'title' => 'ĐỔI MỚI',
			'icon' => 'phat-trien-ben-vung/doi-moi.svg',
			'text' => 'Đổi mới là động lực để ECSGES không ngừng phát triển. Với tư duy mở và tinh thần tiên phong, chúng tôi liên tục cập nhật xu hướng, nâng cao chất lượng và kiến tạo những giá trị mới nhằm đáp ứng yêu cầu của thời đại hội nhập.',
		),
	);
}

/**
 * Phát triển bền vững — VĂN HÓA ECS (carousel). Figma chỉ thiết kế slide "HỌC HỎI"
 * + 3 chấm phân trang; 2 slide còn lại là nội dung tiếng Việt hợp lý (chỉnh sau).
 * 'title' + 'text' đổi theo từng chấm; ảnh bên trái giữ cố định.
 */
function ecsges_ptbv_culture()
{
	return array(
		array(
			'title' => 'HỌC HỎI',
			'text'  => 'ECSGES xây dựng môi trường khuyến khích học tập và phát triển liên tục. Thông qua các chương trình đào tạo nội bộ, hoạt động chia sẻ chuyên môn và cơ hội tham gia các khóa học nâng cao, đội ngũ cán bộ, giảng viên và nhân viên luôn được tạo điều kiện để cập nhật kiến thức, rèn luyện kỹ năng và phát triển năng lực nghề nghiệp.',
		),
		array(
			'title' => 'HỢP TÁC',
			'text'  => 'Chúng tôi đề cao tinh thần làm việc nhóm và sự phối hợp giữa các bộ phận. Mỗi thành viên đều được lắng nghe, tôn trọng và cùng nhau kiến tạo giá trị chung, biến sự khác biệt thành sức mạnh tập thể để hoàn thành những mục tiêu lớn.',
		),
		array(
			'title' => 'CHÍNH TRỰC',
			'text'  => 'Sự minh bạch và trung thực là nền tảng trong mọi hoạt động của ECSGES. Chúng tôi giữ vững cam kết với người học, đối tác và cộng đồng bằng thái độ làm việc chuẩn mực, có trách nhiệm và luôn đặt chữ tín lên hàng đầu.',
		),
	);
}

/**
 * Phát triển bền vững — TRÁCH NHIỆM XÃ HỘI (3 thẻ). Thẻ đầu tô nền cam (accent).
 */
function ecsges_ptbv_responsibility()
{
	return array(
		array(
			'title'  => 'TRI THỨC',
			'text'   => 'Lan tỏa cơ hội học tập và tiếp cận giáo dục cho nhiều đối tượng trong cộng đồng.',
			'accent' => true,
		),
		array(
			'title'  => 'NHÂN LỰC',
			'text'   => 'Góp phần đào tạo và phát triển nguồn nhân lực chất lượng cao phục vụ sự phát triển của đất nước.',
			'accent' => false,
		),
		array(
			'title'  => 'TƯƠNG LAI',
			'text'   => 'Đồng hành cùng thế hệ trẻ trên hành trình hội nhập, sáng tạo và kiến tạo giá trị cho xã hội.',
			'accent' => false,
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

