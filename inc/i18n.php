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

		/* Tin tức (page-tin-tuc.php) */
		'TIN NỔI BẬT'                    => 'FEATURED NEWS',
		'KIẾN THỨC'                      => 'KNOWLEDGE',
		'Chủ đề tin tức'                 => 'News topics',
		'Trang kiến thức'                => 'Knowledge pages',

		/* Đối tác (page-doi-tac.php) */
		'ĐỐI TÁC'                        => 'PARTNERS',
		'ĐỐI TÁC GIÁO DỤC TRONG NƯỚC'    => 'DOMESTIC EDUCATION PARTNERS',
		'ĐỐI TÁC GIÁO DỤC QUỐC TẾ'       => 'INTERNATIONAL EDUCATION PARTNERS',
		'ĐỐI TÁC DOANH NGHIỆP TRONG NƯỚC' => 'DOMESTIC CORPORATE PARTNERS',
		'ĐỐI TÁC DOANH NGHIỆP QUỐC TẾ'   => 'INTERNATIONAL CORPORATE PARTNERS',
		'Đối tác giáo dục quốc tế'       => 'International education partner',
		'Đối tác doanh nghiệp trong nước' => 'Domestic corporate partner',
		'Đại học Đông Đô'                => 'Dong Do University',
		'Đại học Sao Đỏ'                 => 'Saodo University',
		'Đại học Công nghệ Giao thông Vận tải' => 'University of Transport Technology',

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

		/* Nhãn dùng chung bổ sung */
		'Địa chỉ'                => 'Address',
		'Điện thoại'             => 'Phone',
		'Họ và tên'              => 'Full name',
		'Nội dung'               => 'Message',
		'Mới'                    => 'New',
		'Hà Nội'                 => 'Hanoi',
		'TP. Hồ Chí Minh'        => 'Ho Chi Minh City',
		'Đà Nẵng'                => 'Da Nang',
		'Hải Phòng'              => 'Hai Phong',
		'Cần Thơ'                => 'Can Tho',
		'146 Phố Tây Sơn, Đống Đa, Thành phố Hà Nội' => '146 Tay Son Street, Dong Da, Hanoi',
		'Toà ROX Tower Goldmark City 136 Hồ Tùng Mậu, Phú Diễn, Hà Nội'
			=> 'ROX Tower, Goldmark City, 136 Ho Tung Mau, Phu Dien, Hanoi',

		/* Section About (trang chủ) */
		'VƯƠN RA THẾ GIỚI'                   => 'REACHING OUT TO THE WORLD',
		'VỚI HỆ SINH THÁI GIÁO DỤC KẾT NỐI'  => 'WITH A CONNECTED EDUCATION ECOSYSTEM',
		'ECSGES phát triển hệ sinh thái giáo dục với mạng lưới đơn vị thành viên, đối tác và các lĩnh vực hoạt động được kết nối trong một chiến lược thống nhất, hướng tới nâng cao chất lượng giáo dục và phát triển nguồn nhân lực Việt Nam.'
			=> 'ECSGES develops an education ecosystem in which member units, partners and fields of operation are connected within one unified strategy, aiming to raise education quality and develop Vietnam\'s human resources.',

		/* Section Journey (trang chủ) */
		'Học viên ECS Global'    => 'ECS Global learners',
		'Hoạt động đào tạo'      => 'Training activities',
		'Sự kiện ECS Global'     => 'ECS Global events',
		'Cộng đồng ECS Global'   => 'ECS Global community',

		/* Section Contact + trang Liên hệ */
		'LIÊN HỆ VỚI CHÚNG TÔI'  => 'CONTACT US',
		'GỬI NỘI DUNG'           => 'SEND MESSAGE',
		'TRỤ SỞ'                 => 'HEAD OFFICE',
		'Liên hệ với ECSGES'     => 'Contact ECSGES',

		/* Tin tức (category/single/index) */
		'TIN TỨC - THÔNG BÁO'    => 'NEWS & ANNOUNCEMENTS',
		'Chưa có bài viết.'      => 'No posts yet.',
		'Không có nội dung.'     => 'No content.',

		/* Trang kết quả tìm kiếm (search.php) + ô tìm kiếm ở header */
		'Kết quả tìm kiếm'       => 'Search results',
		'Tìm thấy %d kết quả.'   => 'Found %d results.',
		'Không tìm thấy nội dung nào phù hợp. Hãy thử từ khoá khác.'
			=> 'No matching content found. Try another keyword.',
		'Nhập từ khoá...'        => 'Enter a keyword...',

		/* Hệ sinh thái — nội dung 5 tab (bản cập nhật) */
		'ECSGES đồng hành cùng học sinh, sinh viên trên hành trình khám phá bản thân, định hình mục tiêu nghề nghiệp và lựa chọn lộ trình học tập phù hợp. Thông qua các chương trình tư vấn, trải nghiệm thực tế và cập nhật xu hướng thị trường lao động, chúng tôi giúp người học xây dựng nền tảng vững chắc để phát triển trong môi trường làm việc hiện đại và hội nhập.'
			=> 'ECSGES accompanies pupils and students on their journey of self-discovery, shaping career goals and choosing a suitable learning path. Through advisory programs, real-world experience and up-to-date labour market insights, we help learners build a solid foundation to grow in a modern, globally integrated working environment.',
		'Với mạng lưới đối tác giáo dục đa dạng và hệ thống tư vấn chuyên nghiệp, ECSGES triển khai các giải pháp tuyển sinh linh hoạt, đáp ứng nhu cầu học tập ở nhiều cấp độ và lĩnh vực khác nhau. Chúng tôi hướng tới việc mở rộng cơ hội tiếp cận giáo dục chất lượng cho mọi đối tượng người học.'
			=> 'With a diverse network of education partners and a professional advisory system, ECSGES delivers flexible admissions solutions that meet learning needs across many levels and fields. We aim to widen access to quality education for every learner.',
		'ECSGES phát triển các chương trình đào tạo đa dạng theo định hướng ứng dụng, kết hợp giữa kiến thức chuyên môn, kỹ năng thực tiễn và yêu cầu của thị trường lao động. Chúng tôi chú trọng xây dựng môi trường học tập hiện đại, linh hoạt và phù hợp với xu hướng phát triển của thời đại số.'
			=> 'ECSGES develops diverse, application-oriented training programs that combine specialist knowledge, practical skills and labour market requirements. We focus on building a modern, flexible learning environment aligned with the trends of the digital era.',
		'Là cầu nối giữa người lao động và doanh nghiệp, ECSGES cung cấp các giải pháp việc làm trong nước và quốc tế, góp phần nâng cao chất lượng nguồn nhân lực và thúc đẩy phát triển nghề nghiệp bền vững. Chúng tôi đồng hành cùng người lao động từ quá trình định hướng, đào tạo đến tìm kiếm cơ hội việc làm phù hợp.'
			=> 'As a bridge between workers and businesses, ECSGES provides domestic and international employment solutions, helping raise the quality of human resources and promote sustainable career development. We accompany workers from orientation and training through to finding the right job.',
		'ECSGES cung cấp các giải pháp truyền thông toàn diện cho lĩnh vực giáo dục, góp phần nâng cao hình ảnh thương hiệu, tăng cường kết nối với người học và mở rộng sức ảnh hưởng tới cộng đồng. Chúng tôi kết hợp giữa truyền thông hiện đại và tổ chức sự kiện để tạo nên những chiến dịch hiệu quả và bền vững.'
			=> 'ECSGES provides comprehensive media solutions for the education sector, enhancing brand image, strengthening connections with learners and expanding community reach. We combine modern media with event organisation to create effective, lasting campaigns.',

		/* Trang "Lĩnh vực hoạt động" — tiêu đề 5 tab */
		'Định hướng tương lai từ sự thấu hiểu năng lực'      => 'Shaping the future through a true understanding of ability',
		'Kết nối người học với cơ hội phát triển toàn diện'  => 'Connecting learners with well-rounded development opportunities',
		'Nâng cao năng lực, gia tăng giá trị nghề nghiệp'    => 'Building capability, increasing professional value',
		'Kết nối nguồn nhân lực với cơ hội nghề nghiệp'      => 'Connecting talent with career opportunities',
		'Lan tỏa giá trị bằng sức mạnh kết nối'              => 'Spreading value through the power of connection',

		/* Trang "Lĩnh vực hoạt động" — đoạn mô tả 5 tab.
		   Khoá viết 1 dòng (ecsges_norm_key gộp khoảng trắng); GIÁ TRỊ phải giữ
		   nguyên xuống dòng vì template tách theo dòng để dựng danh sách gạch đầu dòng. */
		'ECSGES đồng hành cùng học sinh, sinh viên trên hành trình khám phá bản thân, định hình mục tiêu nghề nghiệp và lựa chọn lộ trình học tập phù hợp. Thông qua các chương trình tư vấn, trải nghiệm thực tế và cập nhật xu hướng thị trường lao động, chúng tôi giúp người học xây dựng nền tảng vững chắc để phát triển trong môi trường làm việc hiện đại và hội nhập. Các dịch vụ nổi bật: - Định hướng nghề nghiệp - Lựa chọn ngành học - Phát triển kỹ năng'
			=> 'ECSGES accompanies pupils and students on their journey of self-discovery, shaping career goals and choosing a suitable learning path. Through advisory programs, real-world experience and up-to-date labour market insights, we help learners build a solid foundation to grow in a modern, globally integrated working environment.
Key services:
- Career orientation
- Choosing a major
- Skills development',
		'Với mạng lưới đối tác giáo dục đa dạng và hệ thống tư vấn chuyên nghiệp, ECSGES triển khai các giải pháp tuyển sinh linh hoạt, đáp ứng nhu cầu học tập ở nhiều cấp độ và lĩnh vực khác nhau. Chúng tôi hướng tới việc mở rộng cơ hội tiếp cận giáo dục chất lượng cho mọi đối tượng người học. Các chương trình tuyển sinh: - Chính quy Đại học, Cao đẳng - Du học - Liên thông - Chương trình 9+ - E-Learning - Các khóa học ngắn hạn'
			=> 'With a diverse network of education partners and a professional advisory system, ECSGES delivers flexible admissions solutions that meet learning needs across many levels and fields. We aim to widen access to quality education for every learner.
Admissions programs:
- Full-time university & college
- Study abroad
- Degree transfer programs
- 9+ programs
- E-Learning
- Short courses',
		'ECSGES phát triển các chương trình đào tạo đa dạng theo định hướng ứng dụng, kết hợp giữa kiến thức chuyên môn, kỹ năng thực tiễn và yêu cầu của thị trường lao động. Chúng tôi chú trọng xây dựng môi trường học tập hiện đại, linh hoạt và phù hợp với xu hướng phát triển của thời đại số. Các lĩnh vực đào tạo: - Chính quy Đại học, Cao đẳng - Du học - Liên thông - Kỹ năng - Chương trình 9+ - E-Learning'
			=> 'ECSGES develops diverse, application-oriented training programs that combine specialist knowledge, practical skills and labour market requirements. We focus on building a modern, flexible learning environment aligned with the trends of the digital era.
Training areas:
- Full-time university & college
- Study abroad
- Degree transfer programs
- Skills
- 9+ programs
- E-Learning',
		'Là cầu nối giữa người lao động và doanh nghiệp, ECSGES cung cấp các giải pháp việc làm trong nước và quốc tế, góp phần nâng cao chất lượng nguồn nhân lực và thúc đẩy phát triển nghề nghiệp bền vững. Chúng tôi đồng hành cùng người lao động từ quá trình định hướng, đào tạo đến tìm kiếm cơ hội việc làm phù hợp. Việc làm trong nước: - Lao động phổ thông - Lao động thời vụ - Lao động tay nghề cao - Lao động có kinh nghiệm Việc làm quốc tế: - Xuất khẩu lao động phổ thông - Xuất khẩu lao động kỹ sư'
			=> 'As a bridge between workers and businesses, ECSGES provides domestic and international employment solutions, helping raise the quality of human resources and promote sustainable career development. We accompany workers from orientation and training through to finding the right job.
Domestic employment:
- General workers
- Seasonal workers
- Highly skilled workers
- Experienced professionals
International employment:
- General labour export
- Engineer labour export',
		'ECSGES cung cấp các giải pháp truyền thông toàn diện cho lĩnh vực giáo dục, góp phần nâng cao hình ảnh thương hiệu, tăng cường kết nối với người học và mở rộng sức ảnh hưởng tới cộng đồng. Chúng tôi kết hợp giữa truyền thông hiện đại và tổ chức sự kiện để tạo nên những chiến dịch hiệu quả và bền vững. Các dịch vụ chính: - Truyền thông online - Truyền thông offline - Tổ chức sự kiện'
			=> 'ECSGES provides comprehensive media solutions for the education sector, enhancing brand image, strengthening connections with learners and expanding community reach. We combine modern media with event organisation to create effective, lasting campaigns.
Core services:
- Online media
- Offline media
- Event organisation',

		/* Trang "Về ECS" — timeline (bản cập nhật) */
		'CHUYỂN ĐỔI LĨNH VỰC'                      => 'SHIFTING THE FIELD',
		'PHÁT TRIỂN NỘI LỰC VÀ KIỆN TOÀN TỔ CHỨC'  => 'BUILDING INTERNAL STRENGTH & CONSOLIDATING THE ORGANISATION',
		'Tiền thân là công ty cổ phần HSC hoạt động trong lĩnh vực công nghệ thông tin và thiết bị máy tính. Triển khai các giải pháp quản lý đào tạo cho trung tâm tin học. Xây dựng nền tảng quản trị và định hướng phát triển trong lĩnh vực giáo dục.'
			=> 'Formerly HSC Joint Stock Company, operating in information technology and computer equipment.
Deployed training management solutions for IT centres.
Built the management foundation and development direction in the education field.',
		'Năm 2008, đổi tên thành công ty cổ phần truyền thông BTS Việt Nam. Chuyển đổi sang các lĩnh vực hướng nghiệp, tuyển sinh và đào tạo.'
			=> 'In 2008, renamed BTS Vietnam Media Joint Stock Company. Shifted into career guidance, admissions and training.',
		'Năm 2019, đổi tên thành Công ty cổ phần hỗ trợ và phát triển chọn nghề khởi nghiệp ECS Global. Mở rộng các pháp nhân. Ứng dụng công nghệ và kiện toàn tổ chức'
			=> 'In 2019, renamed ECS Global Career & Startup Support and Development Joint Stock Company.
Expanded the group of legal entities.
Applied technology and consolidated the organisation',
		'Năm 2026, đổi tên thành Công ty cổ phần hỗ trợ và phát triển ECSGES, phát triển hệ thống chuỗi văn phòng'
			=> 'In 2026, renamed ECSGES Support and Development Joint Stock Company, expanding the chain of offices',

		/* Trang "Về ECS" — tầm nhìn / sứ mệnh (bản cập nhật) */
		'Trở thành một tổ chức hàng đầu cung cấp sản phẩm, dịch vụ và giải pháp trong lĩnh vực hướng nghiệp, tuyển sinh, đào tạo, việc làm, truyền thông. ECSGES sẽ là doanh nghiệp đáng tin cậy và chuyên nghiệp trong cung cấp nguồn nhân lực chất lượng quốc tế.'
			=> 'To become a leading organisation providing products, services and solutions in career guidance, admissions, training, employment and media. ECSGES will be a trusted, professional business supplying human resources of international quality.',
		'Với sứ mệnh nâng tầm nguồn nhân lực Việt Nam, chúng tôi cam kết không ngừng nỗ lực xây dựng những sản phẩm, dịch vụ, giải pháp, có tính thực tiễn, sáng tạo, chuyên nghiệp và giá trị nhất đáp ứng nhu cầu phát triển nguồn nhân lực chất lượng cho xã hội.'
			=> 'With the mission of raising the standard of Vietnam\'s human resources, we are committed to relentlessly building the most practical, creative, professional and valuable products, services and solutions to meet society\'s need for high-quality human resource development.',

		/* Trang "Về ECS" — số liệu (bản cập nhật) */
		'20+ năm'                                                            => '20+ years',
		'Thành lập'                                                          => 'Since establishment',
		'Chi nhánh văn phòng toàn quốc'                                      => 'Branch offices nationwide',
		'Học sinh, sinh viên được tư vấn, định hướng nghề nghiệp'            => 'Pupils and students advised on career orientation',
		'Sinh viên Đại học, Cao đẳng được đào tạo'                           => 'University and college students trained',
		'Trường Đại học, Cao đẳng, Trung cấp, liên cấp được hỗ trợ và tư vấn' => 'Universities, colleges, vocational and multi-level schools supported',
		'Đối tác, tổ chức hỗ trợ và phát triển'                              => 'Partners and supporting organisations',
		'CBGVNV với 50+ tiến sĩ, thạc sĩ'                                    => 'Staff and lecturers, including 50+ PhDs and Masters',

		/* Trang "Phát triển bền vững" */
		'Giám đốc kinh doanh'    => 'Business Director',
		'TẬN TÂM'                => 'DEDICATION',
		'ĐỒNG HÀNH'              => 'COMPANIONSHIP',
		'ĐỔI MỚI'                => 'INNOVATION',
		'Chúng tôi tin rằng sự tận tâm là nền tảng của mọi giá trị bền vững. Mỗi cán bộ, giảng viên và chuyên gia của ECSGES luôn làm việc bằng trách nhiệm, sự chân thành và tinh thần phụng sự, hướng đến lợi ích của người học, đối tác và cộng đồng.'
			=> 'We believe dedication is the foundation of every lasting value. Every officer, lecturer and expert at ECSGES works with responsibility, sincerity and a spirit of service, always for the benefit of learners, partners and the community.',
		'ECSGES không chỉ cung cấp dịch vụ giáo dục mà còn đồng hành cùng người học trên từng chặng đường phát triển. Từ định hướng nghề nghiệp, lựa chọn ngành học đến quá trình học tập và phát triển sự nghiệp, chúng tôi luôn là người bạn đồng hành đáng tin cậy.'
			=> 'ECSGES does not merely provide education services; we walk with learners through every stage of their growth. From career orientation and choosing a major to studying and building a career, we are always a trusted companion.',
		'Đổi mới là động lực để ECSGES không ngừng phát triển. Với tư duy mở và tinh thần tiên phong, chúng tôi liên tục cập nhật xu hướng, nâng cao chất lượng và kiến tạo những giá trị mới nhằm đáp ứng yêu cầu của thời đại hội nhập.'
			=> 'Innovation is the driving force behind ECSGES\'s continuous growth. With an open mindset and a pioneering spirit, we constantly follow new trends, raise quality and create new value to meet the demands of an integrated era.',
		'HỌC HỎI'                => 'LEARNING',
		'HỢP TÁC'                => 'COLLABORATION',
		'CHÍNH TRỰC'             => 'INTEGRITY',
		'ECSGES xây dựng môi trường khuyến khích học tập và phát triển liên tục. Thông qua các chương trình đào tạo nội bộ, hoạt động chia sẻ chuyên môn và cơ hội tham gia các khóa học nâng cao, đội ngũ cán bộ, giảng viên và nhân viên luôn được tạo điều kiện để cập nhật kiến thức, rèn luyện kỹ năng và phát triển năng lực nghề nghiệp.'
			=> 'ECSGES builds an environment that encourages continuous learning and development. Through in-house training programs, professional knowledge sharing and access to advanced courses, our officers, lecturers and staff are always supported to refresh their knowledge, practise their skills and grow professionally.',
		'Chúng tôi đề cao tinh thần làm việc nhóm và sự phối hợp giữa các bộ phận. Mỗi thành viên đều được lắng nghe, tôn trọng và cùng nhau kiến tạo giá trị chung, biến sự khác biệt thành sức mạnh tập thể để hoàn thành những mục tiêu lớn.'
			=> 'We value teamwork and coordination across departments. Every member is heard and respected, and together we create shared value, turning differences into collective strength to achieve big goals.',
		'Sự minh bạch và trung thực là nền tảng trong mọi hoạt động của ECSGES. Chúng tôi giữ vững cam kết với người học, đối tác và cộng đồng bằng thái độ làm việc chuẩn mực, có trách nhiệm và luôn đặt chữ tín lên hàng đầu.'
			=> 'Transparency and honesty underpin everything ECSGES does. We keep our commitments to learners, partners and the community through principled, responsible work, always putting trust first.',
		'TRI THỨC'               => 'KNOWLEDGE',
		'NHÂN LỰC'               => 'HUMAN RESOURCES',
		'TƯƠNG LAI'              => 'THE FUTURE',
		'Lan tỏa cơ hội học tập và tiếp cận giáo dục cho nhiều đối tượng trong cộng đồng.'
			=> 'Spreading learning opportunities and access to education across many groups in the community.',
		'Góp phần đào tạo và phát triển nguồn nhân lực chất lượng cao phục vụ sự phát triển của đất nước.'
			=> 'Contributing to the training and development of high-quality human resources for the country\'s growth.',
		'Đồng hành cùng thế hệ trẻ trên hành trình hội nhập, sáng tạo và kiến tạo giá trị cho xã hội.'
			=> 'Walking with the young generation on their journey of integration, creativity and creating value for society.',
		'Hướng dẫn nạp tiền'             => 'How to top up',
		'Hướng dẫn kích hoạt gói'        => 'How to activate a package',
		'Hướng dẫn KYC tài khoản'        => 'How to complete account KYC',
		'Hướng dẫn kích hoạt gói trả góp' => 'How to activate an instalment package',

		/* Trang "Tuyển dụng" */
		'Nhân viên Digital Marketing'            => 'Digital Marketing Officer',
		'Nhân viên Media'                        => 'Media Officer',
		'Nhân viên Designer'                     => 'Designer',
		'Phòng Công nghệ thông tin và Truyền thông' => 'IT & Communications Department',
		'Toàn thời gian'                         => 'Full-time',
		'Thời hạn: 20/7/2026'                    => 'Deadline: 20/7/2026',

		/* Tiêu đề section vốn hardcode trong HTML (nay đã bọc ecsges_t) */
		'Trang chủ'              => 'Home',
		'Giá trị'                => 'Values',
		'Hướng dẫn'              => 'Guides',
		'ĐỘI NGŨ LÃNH ĐẠO'       => 'LEADERSHIP TEAM',
		// 'VĂN HÓA ECS' viết "HÓA", khác dấu với 'Văn hoá ECS' ở footer → cần khoá riêng.
		'VĂN HÓA ECS'            => 'ECS CULTURE',

		/* Trang Tuyển dụng — bộ lọc + form ứng tuyển */
		'Bộ lọc'                 => 'Filters',
		'Khu vực'                => 'Location',
		'- Chọn khu vực -'       => '- Select location -',
		'Phòng ban'              => 'Department',
		'- Chọn phòng ban -'     => '- Select department -',
		'Cấp bậc'                => 'Level',
		'- Chọn cấp bậc -'       => '- Select level -',
		'Loại công việc'         => 'Job type',
		'- Chọn loại công việc -' => '- Select job type -',
		'Không có công việc nào phù hợp với bộ lọc.' => 'No jobs match the selected filters.',

		/* Trang Tuyển dụng — giá trị trong 3 select bộ lọc */
		'Bắc Ninh'                               => 'Bac Ninh',
		'Hải Phòng'                              => 'Hai Phong',
		'Hải Dương'                              => 'Hai Duong',
		'Phòng Tuyển sinh'                       => 'Admissions Department',
		'Phòng Đào tạo'                          => 'Training Department',
		'Phòng Hành chính'                       => 'Administration Department',
		'Phòng Nhân sự'                          => 'Human Resources Department',
		'Phòng Tài chính kế toán'                => 'Finance & Accounting Department',
		'Phòng Dịch vụ công tác học sinh sinh viên' => 'Student Affairs Department',
		'Phòng Hỗ trợ doanh nghiệp và khởi nghiệp' => 'Business Support & Startup Department',
		'Phòng Hợp tác quốc tế'                  => 'International Cooperation Department',
		'Phòng Marketing'                        => 'Marketing Department',
		'Phòng Khảo thí và đảm bảo chất lượng'   => 'Testing & Quality Assurance Department',
		'Phòng Pháp chế'                         => 'Legal Department',
		'Khối giảng viên'                        => 'Teaching Staff',
		'Bán thời gian'                          => 'Part-time',
		'Thực tập'                               => 'Internship',
		'Tất cả công việc'       => 'All jobs',
		'ỨNG TUYỂN NGAY'         => 'APPLY NOW',
		'NỘP ĐƠN ỨNG TUYỂN'      => 'SUBMIT YOUR APPLICATION',
		'VỊ TRÍ ...'             => 'POSITION ...',
		'Nhập họ và tên'         => 'Enter your full name',
		'Địa chỉ email'          => 'Email address',
		'Nhập địa chỉ email'     => 'Enter your email address',
		'Số điện thoại'          => 'Phone number',
		'Nhập số điện thoại'     => 'Enter your phone number',
		'CV của bạn'             => 'Your CV',
		'Portfolio của bạn'      => 'Your portfolio',
		'Click để chọn và tải lên CV của bạn'        => 'Click to choose and upload your CV',
		'Click để chọn và tải lên Portfolio của bạn' => 'Click to choose and upload your portfolio',

		/* aria-label / alt (trình đọc màn hình) */
		'Mở menu con'            => 'Open submenu',
		'Đóng'                   => 'Close',
		'Trang trước'            => 'Previous page',
		'Trang sau'              => 'Next page',
		'Trang việc làm'         => 'Job pages',
		'Trang'                  => 'Page',
		'Hình ảnh minh hoạ lĩnh vực'  => 'Illustration for the field of',
		'Biểu tượng ECS Global'       => 'ECS Global emblem',
		'Bản đồ vị trí chi nhánh ECSGES' => 'Map of ECSGES branch locations',
		'Tầm nhìn ECSGES'                => 'ECSGES vision',
		'Sứ mệnh ECSGES'                 => 'ECSGES mission',
		'Biểu đồ tăng trưởng của ECSGES qua các giai đoạn'
			=> 'Chart of ECSGES growth across its stages',
		'Biểu đồ tăng trưởng của ECSGES qua các giai đoạn, trên nền bản đồ thế giới'
			=> 'Chart of ECSGES growth across its stages, over a world map',
	);
	return $map;
}

/**
 * Chuẩn hoá 1 chuỗi trước khi tra từ điển.
 *
 * Text gõ trong wp-admin thường ở dạng Unicode TỔ HỢP (NFD: "ư" + dấu sắc rời)
 * còn chuỗi trong file .php ở dạng dựng sẵn (NFC: "ứ"). Hai chuỗi nhìn giống hệt
 * nhưng khác byte → so khớp === trượt. Vì vậy luôn đưa cả 2 vế về NFC, đổi
 * NBSP/ZWSP thành space và gộp khoảng trắng (kể cả xuống dòng + tab thụt đầu
 * dòng trong data.php) trước khi so.
 *
 * @param string $text
 * @return string
 */
function ecsges_norm_key( $text ) {
	$s = (string) $text;
	if ( class_exists( 'Normalizer' ) ) {
		$n = Normalizer::normalize( $s, Normalizer::FORM_C );
		if ( is_string( $n ) ) {
			$s = $n;
		}
	}
	$s = str_replace( array( "\xC2\xA0", "\xE2\x80\x8B" ), ' ', $s );
	$s = preg_replace( '/\s+/u', ' ', $s );
	return trim( (string) $s );
}

/** Chỉ mục tra cứu đã chuẩn hoá: exact (phân biệt hoa/thường) + ci (không). */
function ecsges_en_index() {
	static $idx = null;
	if ( null !== $idx ) {
		return $idx;
	}
	$idx = array(
		'exact' => array(),
		'ci'    => array(),
	);
	foreach ( ecsges_en_map() as $vi => $en ) {
		$k = ecsges_norm_key( $vi );
		if ( '' === $k ) {
			continue;
		}
		$idx['exact'][ $k ] = $en;
		$lc                 = mb_strtolower( $k, 'UTF-8' );
		if ( ! isset( $idx['ci'][ $lc ] ) ) {
			$idx['ci'][ $lc ] = $en;
		}
	}
	return $idx;
}

/** Có phải chuỗi viết HOA toàn bộ (và thực sự có chữ cái)? */
function ecsges_is_upper( $s ) {
	return $s === mb_strtoupper( $s, 'UTF-8' ) && $s !== mb_strtolower( $s, 'UTF-8' );
}

/**
 * Ép bản dịch về đúng "dáng" hoa/thường của chuỗi nguồn.
 *
 * Chỉ dùng cho nhánh tra không phân biệt hoa/thường: bản EN khớp được có thể
 * đến từ ngữ cảnh khác ('ĐỊA CHỈ' => 'ADDRESS') nên không được bê nguyên si.
 *
 * @param string $en     Bản dịch trong từ điển.
 * @param string $source Chuỗi nguồn tiếng Việt.
 * @return string
 */
function ecsges_match_case( $en, $source ) {
	$src_upper = ecsges_is_upper( $source );
	$en_upper  = ecsges_is_upper( $en );
	if ( $src_upper && ! $en_upper ) {
		return mb_strtoupper( $en, 'UTF-8' );
	}
	if ( ! $src_upper && $en_upper ) {
		$lower = mb_strtolower( $en, 'UTF-8' );
		return mb_strtoupper( mb_substr( $lower, 0, 1, 'UTF-8' ), 'UTF-8' ) . mb_substr( $lower, 1, null, 'UTF-8' );
	}
	return $en;
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
	$key = ecsges_norm_key( $text );
	if ( '' === $key ) {
		return $text;
	}
	$idx = ecsges_en_index();
	if ( isset( $idx['exact'][ $key ] ) ) {
		return $idx['exact'][ $key ];
	}
	// Tên mục menu client gõ tay hay lệch hoa/thường ("Tuyển Dụng" vs "Tuyển dụng").
	$lc = mb_strtolower( $key, 'UTF-8' );
	if ( isset( $idx['ci'][ $lc ] ) ) {
		return ecsges_match_case( $idx['ci'][ $lc ], $text );
	}
	return $text;
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
