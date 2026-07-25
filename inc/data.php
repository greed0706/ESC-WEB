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
			'body' => 'ECSGES đồng hành cùng học sinh, sinh viên trên hành trình khám phá bản thân, định hình mục tiêu nghề nghiệp và lựa chọn lộ trình học tập phù hợp. Thông qua các chương trình tư vấn, trải nghiệm thực tế và cập nhật xu hướng thị trường lao động, chúng tôi giúp người học xây dựng nền tảng vững chắc để phát triển trong môi trường làm việc hiện đại và hội nhập.',
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
			// 'cats' = nhãn VN gốc → slug category. Footer dò theo nhãn VN (không phải
			// nhãn đã dịch/ACF ghi đè) rồi lấy link archive thật qua ecsges_category_link();
			// category chưa tồn tại thì tự rơi về '#'.
			'cats' => array(
				'Hướng nghiệp' => 'huong-nghiep',
				'Tuyển sinh' => 'tuyen-sinh',
				'Đào tạo' => 'dao-tao',
				'Việc làm' => 'viec-lam',
				'Truyền thông' => 'truyen-thong',
			),
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
			'body' => 'Năm 2008, đổi tên thành công ty cổ phần truyền thông BTS Việt Nam. Chuyển đổi sang các lĩnh vực hướng nghiệp, tuyển sinh và đào tạo.',
		),
		array(
			'years' => '2019 - 2025',
			'title' => 'PHÁT TRIỂN NỘI LỰC VÀ KIỆN TOÀN TỔ CHỨC',
			'body' => 'Năm 2019, đổi tên thành Công ty cổ phần hỗ trợ và phát triển chọn nghề khởi nghiệp ECS Global
. Mở rộng các pháp nhân
. Ứng dụng công nghệ và kiện toàn tổ chức',
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
		array('value' => '50+', 'label' => 'Chi nhánh văn phòng toàn quốc', 'icon' => '3.svg'),
		array('value' => '235.000+', 'label' => 'Học sinh, sinh viên được tư vấn, định hướng nghề nghiệp', 'icon' => '4.svg'),
		array('value' => '20.000+', 'label' => 'Sinh viên Đại học, Cao đẳng được đào tạo', 'icon' => '5.svg'),
		array('value' => '50+', 'label' => 'Trường Đại học, Cao đẳng, Trung cấp, liên cấp được hỗ trợ và tư vấn', 'icon' => '6.svg'),
		array('value' => '2000+', 'label' => 'Đối tác, tổ chức hỗ trợ và phát triển', 'icon' => '7.svg'),
		array('value' => '200+', 'label' => 'CBGVNV với 50+ tiến sĩ, thạc sĩ','icon' => '8.svg'),
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
			'icon' => 'icon-huongnghiep',
			'image' => $img,
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
			'image' => $img,
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
			'image' => $img,
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
			'image' => $img,
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
			'image' => $img,
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
	$img  = 'phat-trien-ben-vung/van-hoa.png'; // ảnh minh hoạ (Rectangle 306 trong Figma).
	$base = 'phat-trien-ben-vung/';
	return array(
		array(
			'title' => 'TẬN TÂM',
			'icon' => $base . '1.svg',
			'image' => $img,
			'href' => '#',
			'category' => 'tan-tam', // nút "Xem thêm" → /category/tan-tam/ (tạo trong admin)
			'text' => 'Chúng tôi tin rằng sự tận tâm là nền tảng của mọi giá trị bền vững. Mỗi cán bộ, giảng viên và chuyên gia của ECSGES luôn làm việc bằng trách nhiệm, sự chân thành và tinh thần phụng sự, hướng đến lợi ích của người học, đối tác và cộng đồng.',
		),
		array(
			'title' => 'ĐỒNG HÀNH',
			'icon' => $base . '2.svg',
			'image' => $img,
			'href' => '#',
			'category' => 'dong-hanh', // nút "Xem thêm" → /category/dong-hanh/ (tạo trong admin)
			'text' => 'ECSGES không chỉ cung cấp dịch vụ giáo dục mà còn đồng hành cùng người học trên từng chặng đường phát triển. Từ định hướng nghề nghiệp, lựa chọn ngành học đến quá trình học tập và phát triển sự nghiệp, chúng tôi luôn là người bạn đồng hành đáng tin cậy.',
		),
		array(
			'title' => 'ĐỔI MỚI',
			'icon' => $base . '3.svg',
			'image' => $img,
			'href' => '#',
			'category' => 'doi-moi', // nút "Xem thêm" → /category/doi-moi/ (tạo trong admin)
			'text' => 'Đổi mới là động lực để ECSGES không ngừng phát triển. Với tư duy mở và tinh thần tiên phong, chúng tôi liên tục cập nhật xu hướng, nâng cao chất lượng và kiến tạo những giá trị mới nhằm đáp ứng yêu cầu của thời đại hội nhập.',
		),
	);
}

/**
 * Phát triển bền vững — VĂN HÓA ECS. Theo Figma: 3 thẻ hiện cùng lúc, mỗi thẻ = ảnh
 * trên cùng + tiêu đề + mô tả (không còn carousel). 'image' = ảnh minh hoạ trên thẻ.
 */
function ecsges_ptbv_culture()
{
	$img = 'phat-trien-ben-vung/van-hoa.png';
	return array(
		array(
			'title' => 'HỌC HỎI',
			'image' => $img,
			'text'  => 'ECSGES xây dựng môi trường khuyến khích học tập và phát triển liên tục. Thông qua các chương trình đào tạo nội bộ, hoạt động chia sẻ chuyên môn và cơ hội tham gia các khóa học nâng cao, đội ngũ cán bộ, giảng viên và nhân viên luôn được tạo điều kiện để cập nhật kiến thức, rèn luyện kỹ năng và phát triển năng lực nghề nghiệp.',
		),
		array(
			'title' => 'ĐỒNG HÀNH',
			'image' => $img,
			'text'  => 'ECSGES không chỉ cung cấp dịch vụ giáo dục mà còn đồng hành cùng người học trên từng chặng đường phát triển. Từ định hướng nghề nghiệp, lựa chọn ngành học đến quá trình học tập và phát triển sự nghiệp, chúng tôi luôn là người bạn đồng hành đáng tin cậy.',
		),
		array(
			'title' => 'ĐỔI MỚI',
			'image' => $img,
			'text'  => 'Đổi mới là động lực để ECSGES không ngừng phát triển. Với tư duy mở và tinh thần tiên phong, chúng tôi liên tục cập nhật xu hướng, nâng cao chất lượng và kiến tạo những giá trị mới nhằm đáp ứng yêu cầu của thời đại hội nhập.',
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
 */
function ecsges_news_tabs()
{
	return array(
		array('label' => 'ECSGES', 'cat' => ''),
		array('label' => 'HƯỚNG NGHIỆP', 'cat' => 'huong-nghiep'),
		array('label' => 'TUYỂN SINH', 'cat' => 'tuyen-sinh'),
		array('label' => 'ĐÀO TẠO', 'cat' => 'dao-tao'),
		array('label' => 'VIỆC LÀM', 'cat' => 'viec-lam'),
		array('label' => 'TRUYỀN THÔNG', 'cat' => 'truyen-thong'),
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
