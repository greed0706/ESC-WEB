<?php
/**
 * Dịch nội dung mặc định sang English cho site đa ngôn ngữ (Polylang).
 *
 * Cơ chế: mọi text mặc định của theme là tiếng Việt. Khi ngôn ngữ hiện tại là
 * 'en', các helper (ecsges_field*, dữ liệu trong data.php, nav, see_more) chạy
 * chuỗi qua từ điển VN→EN dưới đây. Chuỗi không có trong từ điển giữ nguyên
 * (vd tên riêng, email, ngày, đường dẫn). Nếu client nhập ACF tiếng Anh riêng
 * cho trang bản English thì giá trị đó được dùng trực tiếp (không tra từ điển).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Đang xem bản tiếng Anh? */
function ecsges_is_en() {
	return function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' );
}

/** Từ điển VN → EN (khóa = đúng chuỗi tiếng Việt mặc định). */
function ecsges_en_map() {
	static $map = null;
	if ( null !== $map ) {
		return $map;
	}
	$map = array(

		/* Nav + nhãn chung */
		'Về ECS'                 => 'About ECS',
		'Lĩnh vực hoạt động'     => 'Our Fields',
		'Phát triển bền vững'    => 'Sustainability',
		'Tin tức'                => 'News',
		'Tuyển dụng'             => 'Careers',
		'Liên hệ'                => 'Contact',
		'Tìm hiểu thêm'          => 'Learn more',
		'TÌM HIỂU THÊM'          => 'LEARN MORE',
		'Xem thêm'               => 'See more',
		'Ngôn ngữ'               => 'Language',
		'Tìm kiếm'               => 'Search',
		'Đổi ngôn ngữ'           => 'Change language',

		/* Hero */
		'Kiến tạo'               => 'Building',
		'HỆ SINH THÁI'           => 'THE ECOSYSTEM',
		'GIÁO DỤC TOÀN CẦU'      => 'FOR GLOBAL EDUCATION',
		'Vì Tương Lai Việt Nam'  => 'For The Future Of Vietnam',

		/* About */
		'KIẾN TẠO HỆ SINH THÁI'  => 'BUILDING THE ECOSYSTEM',
		'ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm của đội ngũ lãnh đạo trẻ, cùng với sự năng động, sáng tạo, đoàn kết của nhiều lớp nhân viên.'
			=> 'ECS Global has grown strongly under the dedicated leadership and deep experience of a young management team, together with the dynamism, creativity and unity of many generations of staff.',
		'Sau hơn 9 năm, ECS Global đã khẳng định được vị thế trên thị trường ở các lĩnh vực tuyển sinh, hướng nghiệp khởi nghiệp, việc làm, giáo dục, truyền thông và công nghệ số.'
			=> 'After more than 9 years, ECS Global has affirmed its market position across admissions, career & startup guidance, employment, education, media and digital technology.',

		/* Journey (home) */
		'ĐỒNG HÀNH CÙNG NHỮNG'   => 'ACCOMPANYING EVERY',
		'HÀNH TRÌNH PHÁT TRIỂN'  => 'GROWTH JOURNEY',
		'ECSGES đồng hành cùng cá nhân, tổ chức và cộng đồng trên hành trình học tập, phát triển năng lực và mở rộng cơ hội trong bối cảnh hiện đại toàn cầu.'
			=> 'ECSGES accompanies individuals, organizations and communities on their journey of learning, capacity building and expanding opportunities in a modern, global context.',

		/* Ecosystem */
		'KẾT NỐI ĐA LĨNH VỰC'    => 'CONNECTING MULTIPLE FIELDS',
		'Mỗi lĩnh vực hoạt động của ECSGES là một mắt xích quan trọng, cùng đồng hành với người học trên hành trình học tập, rèn luyện và lập nghiệp.'
			=> 'Each of ECSGES\'s fields is a vital link, accompanying learners throughout their journey of study, practice and career building.',
		'HƯỚNG NGHIỆP'           => 'CAREER GUIDANCE',
		'TUYỂN SINH'             => 'ADMISSIONS',
		'ĐÀO TẠO'                => 'TRAINING',
		'VIỆC LÀM'               => 'EMPLOYMENT',
		'TRUYỀN THÔNG'           => 'MEDIA',
		'ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm của đội ngũ lãnh đạo trẻ, cùng với sự năng động, sáng tạo, đoàn kết của nhiều lớp nhân viên. Sau hơn 9 năm, ECS Global đã khẳng định được vị thế trên thị trường ở các lĩnh vực tuyển sinh, hướng nghiệp khởi nghiệp, việc làm, giáo dục, truyền thông và công nghệ số.'
			=> 'ECS Global has grown strongly under the dedicated leadership and deep experience of a young management team, together with the dynamism, creativity and unity of many generations of staff. After more than 9 years, ECS Global has affirmed its market position across admissions, career & startup guidance, employment, education, media and digital technology.',
		'Kết nối người học với các chương trình đào tạo trong và ngoài nước, ECSGES tư vấn lộ trình phù hợp với năng lực, nguyện vọng và điều kiện của từng cá nhân trên hành trình chinh phục tri thức.'
			=> 'Connecting learners with training programs at home and abroad, ECSGES advises pathways suited to each person\'s ability, aspirations and circumstances on their journey to master knowledge.',
		'Hệ thống chương trình đào tạo bám sát thực tiễn, trang bị kiến thức và kỹ năng cần thiết giúp người học sẵn sàng thích ứng và phát triển trong môi trường làm việc hiện đại.'
			=> 'A practice-oriented training system equips learners with the knowledge and skills needed to adapt and thrive in a modern working environment.',
		'Mạng lưới đối tác doanh nghiệp rộng khắp mở ra cơ hội thực tập và việc làm, đồng hành cùng người học từ khi rời ghế nhà trường đến khi vững vàng trong sự nghiệp.'
			=> 'An extensive network of corporate partners opens internship and job opportunities, accompanying learners from graduation to a stable career.',
		'Lan toả tri thức và giá trị tích cực tới cộng đồng thông qua các kênh truyền thông và nền tảng công nghệ số, kết nối con người với cơ hội học tập và phát triển.'
			=> 'Spreading knowledge and positive values to the community through media channels and digital platforms, connecting people with opportunities to learn and grow.',

		/* News */
		'TIN TỨC'                => 'NEWS',
		'Lễ ký kết hợp tác ECS GLOBAL và Học viện Quản lý NanYang'
			=> 'ECS GLOBAL signs a cooperation agreement with NanYang Institute of Management',
		'ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm.'
			=> 'ECS Global has grown strongly under dedicated leadership and deep experience.',

		/* Branch */
		'HỆ THỐNG'                       => 'OUR OFFICE',
		'CHI NHÁNH VĂN PHÒNG'            => 'NETWORK',
		'Tìm tên đường và tỉnh thành'    => 'Search street and province',
		'hoặc chọn nhanh'                => 'or pick quickly',
		'Gợi ý'                          => 'Suggestions',
		'Tỉnh/thành phố'                 => 'Province / City',

		/* Footer */
		'VỀ ECSGES'              => 'ABOUT ECSGES',
		'LĨNH VỰC HOẠT ĐỘNG'     => 'OUR FIELDS',
		'PHÁT TRIỂN BỀN VỮNG'    => 'SUSTAINABILITY',
		'ĐỊA CHỈ'                => 'ADDRESS',
		'Hành trình phát triển'  => 'Development journey',
		'Tầm nhìn'               => 'Vision',
		'Sứ mệnh'                => 'Mission',
		'Giá trị cốt lõi'        => 'Core values',
		'Hướng nghiệp'           => 'Career guidance',
		'Tuyển sinh'             => 'Admissions',
		'Đào tạo'                => 'Training',
		'Việc làm'               => 'Employment',
		'Truyền thông'           => 'Media',
		'Văn hoá ECS'            => 'ECS culture',
		'Con người ECS'          => 'ECS people',
		'Trách nhiệm xã hội'     => 'Social responsibility',
		'Địa chỉ:'               => 'Address:',
		'Điện thoại:'            => 'Phone:',

		/* Trang "Về ECS" */
		'Từ những bước đi đầu tiên đến hệ sinh thái giáo dục đa lĩnh vực hôm nay, mỗi giai đoạn phát triển của ECSGES đều gắn liền với khát vọng nâng cao chất lượng giáo dục, mở rộng cơ hội học tập và phát triển nguồn nhân lực cho cộng đồng.'
			=> 'From its very first steps to today\'s multi-sector education ecosystem, every stage of ECSGES\'s growth is tied to the aspiration of improving education quality, expanding learning opportunities and developing human resources for the community.',
		'ĐẶT NỀN MÓNG'                   => 'LAYING THE FOUNDATION',
		'MỞ RỘNG SỨ MỆNH GIÁO DỤC'       => 'EXPANDING THE EDUCATION MISSION',
		'CỦNG CỐ NỘI LỰC'                => 'STRENGTHENING CAPACITY',
		'BỨT PHÁ TĂNG TRƯỞNG'            => 'BREAKTHROUGH GROWTH',
		'HỘI NHẬP VÀ PHÁT TRIỂN'         => 'INTEGRATION & DEVELOPMENT',
		'2024 - NAY'                     => '2024 - NOW',
		'ECSGES được thành lập với các hoạt động kinh doanh và cung cấp giải pháp công nghệ thông tin, thiết bị công nghệ và văn phòng. Đây là giai đoạn đặt nền móng về năng lực vận hành, phát triển thị trường và xây dựng đội ngũ cho những bước phát triển tiếp theo.'
			=> 'ECSGES was founded with business activities providing IT solutions, technology and office equipment. This period laid the foundation for operational capacity, market development and team building for the next stages of growth.',
		'Nhận thấy nhu cầu ngày càng lớn về định hướng nghề nghiệp và phát triển nguồn nhân lực, ECSGES từng bước mở rộng sang các hoạt động hướng nghiệp, tuyển sinh và đào tạo, đánh dấu bước chuyển mình quan trọng trên hành trình phát triển.'
			=> 'Recognizing the growing demand for career orientation and human resource development, ECSGES gradually expanded into career guidance, admissions and training, marking an important transformation in its growth journey.',
		'Tập trung nâng cao chất lượng hoạt động, ứng dụng công nghệ trong quản lý và đào tạo, đồng thời từng bước chuẩn hóa quy trình và hệ thống vận hành.'
			=> 'Focusing on improving operational quality, applying technology in management and training, while gradually standardizing processes and operating systems.',
		'Mở rộng quy mô đào tạo, phát triển mạng lưới đối tác và doanh nghiệp, tạo thêm nhiều cơ hội học tập, thực tập và việc làm cho người học.'
			=> 'Expanding training scale, developing the network of partners and businesses, and creating more opportunities for study, internship and employment for learners.',
		'Bước vào giai đoạn phát triển mới với định hướng xây dựng hệ sinh thái giáo dục đa lĩnh vực, thúc đẩy chuyển đổi số, mở rộng hợp tác quốc tế và phát triển bền vững.'
			=> 'Entering a new stage of growth with a vision to build a multi-sector education ecosystem, accelerate digital transformation, expand international cooperation and pursue sustainable development.',

		'TẦM NHÌN'   => 'VISION',
		'SỨ MỆNH'    => 'MISSION',
		'Trở thành hệ sinh thái giáo dục tiên phong tại Việt Nam, kết nối giáo dục, doanh nghiệp và xã hội trong một chuỗi giá trị toàn diện; góp phần phát triển nguồn nhân lực chất lượng cao, có năng lực hội nhập quốc tế và thích ứng với sự thay đổi của thời đại.'
			=> 'To become a pioneering education ecosystem in Vietnam, connecting education, business and society in a comprehensive value chain; contributing to the development of high-quality human resources capable of international integration and adapting to the changes of the era.',
		'Kiến tạo hệ sinh thái giáo dục toàn diện, đồng hành cùng người học trên hành trình từ định hướng nghề nghiệp, lựa chọn ngành học, phát triển năng lực đến kết nối việc làm.'
			=> 'Building a comprehensive education ecosystem, accompanying learners from career orientation, choosing a major and developing skills to connecting with employment.',
		'Ứng dụng công nghệ, đổi mới sáng tạo và mở rộng hợp tác trong nước, quốc tế nhằm mang đến những giải pháp giáo dục hiệu quả, góp phần nâng cao chất lượng nguồn nhân lực và tạo ra giá trị bền vững cho cộng đồng.'
			=> 'Applying technology, innovation and expanding domestic and international cooperation to deliver effective education solutions, improving human resource quality and creating lasting value for the community.',

		'GIÁ TRỊ CỐT LÕI' => 'CORE VALUES',
		'TÂM'  => 'HEART',
		'TRÍ'  => 'MIND',
		'SÁNG' => 'CREATIVITY',
		'BỀN'  => 'RESILIENCE',
		'HỢP'  => 'UNITY',
		'Tận tâm, tâm lực, tâm hợp'        => 'Dedication, devotion, harmony',
		'Trí thức, trí tuệ, trí lực'       => 'Knowledge, intellect, capability',
		'Sáng tạo, sáng suốt, sáng rạng'   => 'Creative, insightful, radiant',
		'Bền vững, bền bỉ, bền chặt'       => 'Sustainable, persistent, steadfast',
		'Hợp lực, hợp nhất, hợp tác'       => 'Joining forces, unity, cooperation',
		'ECSGES cam kết phục vụ & hành động với sự tận tâm, nhiệt huyết và đam mê.'
			=> 'ECSGES is committed to serving and acting with dedication, enthusiasm and passion.',
		'Thông qua việc khuyến khích cá nhân và tổ chức học tập, chúng tôi không ngừng phát triển và sáng tạo để đảm bảo chất lượng cao nhất cho từng sản phẩm và dịch vụ của mình.'
			=> 'By encouraging individuals and organizations to keep learning, we continuously grow and innovate to ensure the highest quality for every product and service.',
		'ECSGES coi sáng tạo là hạt giống của sự thay đổi và tiến bộ.'
			=> 'ECSGES sees creativity as the seed of change and progress.',
		'ECSGES luôn bền bỉ và kiên định trong việc phát triển sản phẩm và dịch vụ hướng tới giá trị lâu dài cho khách hàng, đối tác và đồng nghiệp.'
			=> 'ECSGES is always persistent and steadfast in developing products and services aimed at long-term value for customers, partners and colleagues.',
		'ECSGES luôn đề cao sự hợp tác & phát triển. Với tinh thần này, chúng tôi tin rằng đây sẽ là nền tảng để nâng cao sự chuyên nghiệp, bền vững và mở rộng những giải pháp sáng tạo và toàn diện hơn.'
			=> 'ECSGES always values cooperation & development. With this spirit, we believe this will be the foundation to enhance professionalism, sustainability and to expand more creative and comprehensive solutions.',

		'NHỮNG CON SỐ ẤN TƯỢNG' => 'IMPRESSIVE NUMBERS',
		'18 năm'                          => '18 years',
		'Thành lập và phát triển'         => 'Of establishment and growth',
		'Chi nhánh văn phòng quốc tế'     => 'International offices',
		'HSSV được tư vấn'                => 'Students advised',
		'SV đã đào tạo'                   => 'Students trained',
		'Trường ĐH, CĐ, TC được tư vấn'   => 'Universities & colleges advised',
		'Đơn vị hỗ trợ và phát triển'     => 'Supporting & development partners',
		'Nhân sự'                         => 'Staff',
	);
	return $map;
}

/**
 * Dịch 1 chuỗi sang English nếu đang ở bản 'en' và có trong từ điển.
 *
 * @param mixed $text
 * @return mixed
 */
function ecsges_t( $text ) {
	if ( ! is_string( $text ) || '' === $text || ! ecsges_is_en() ) {
		return $text;
	}
	$map = ecsges_en_map();
	return isset( $map[ $text ] ) ? $map[ $text ] : $text;
}

/**
 * Dịch đệ quy: chuỗi → dịch; mảng → dịch từng phần tử (khóa giữ nguyên).
 *
 * @param mixed $value
 * @return mixed
 */
function ecsges_tr_deep( $value ) {
	if ( is_string( $value ) ) {
		return ecsges_t( $value );
	}
	if ( is_array( $value ) ) {
		foreach ( $value as $k => $v ) {
			$value[ $k ] = ecsges_tr_deep( $v );
		}
	}
	return $value;
}
