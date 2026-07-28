<?php
/**
 * GIAI ĐOẠN 2 — Đăng ký ACF field groups bằng PHP (portable, không cần DB).
 *
 * ACF Free: KHÔNG có Options Page & Repeater. Vì vậy nội dung được gắn vào
 * Trang đặt làm "Trang chủ" (Page Type = Front Page); nội dung lặp (tab lĩnh vực,
 * cột footer) dùng field phẳng / textarea (mỗi dòng = 1 mục). Menu header dùng
 * wp_nav_menu (native); tin tức tạm để tĩnh.
 *
 * Mọi field đều có default_value = nội dung hiện tại để màn admin có sẵn dữ liệu.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'acf/init',
	function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$tabs = ecsges_ecosystem_tabs();

		/** Helper tạo field tab (nhóm hiển thị trong admin). */
		$tab = function ( $key, $label ) {
			return array(
				'key'       => 'field_ecsges_tab_' . $key,
				'label'     => $label,
				'name'      => '',
				'type'      => 'tab',
				'placement' => 'top',
			);
		};
		/** Helper text. */
		$text = function ( $key, $label, $default = '', $instructions = '' ) {
			return array(
				'key'           => 'field_ecsges_' . $key,
				'label'         => $label,
				'name'          => $key,
				'type'          => 'text',
				'default_value' => $default,
				'instructions'  => $instructions,
			);
		};
		/** Helper textarea. */
		$textarea = function ( $key, $label, $default = '', $instructions = '', $rows = 3 ) {
			return array(
				'key'           => 'field_ecsges_' . $key,
				'label'         => $label,
				'name'          => $key,
				'type'          => 'textarea',
				'default_value' => $default,
				'instructions'  => $instructions,
				'new_lines'     => '',
				'rows'          => $rows,
			);
		};
		/** Helper WYSIWYG (trình soạn thảo đầy đủ — in đậm, danh sách, link, bảng…). */
		$wysiwyg = function ( $key, $label, $default = '', $instructions = '' ) {
			return array(
				'key'           => 'field_ecsges_' . $key,
				'label'         => $label,
				'name'          => $key,
				'type'          => 'wysiwyg',
				'default_value' => $default,
				'instructions'  => $instructions,
				'tabs'          => 'all',
				'toolbar'       => 'full',
				'media_upload'  => 1,
				'delay'         => 0,
			);
		};
		/** Helper image (trả về URL). */
		$image = function ( $key, $label, $instructions = '' ) {
			return array(
				'key'           => 'field_ecsges_' . $key,
				'label'         => $label,
				'name'          => $key,
				'type'          => 'image',
				'return_format' => 'url',
				'preview_size'  => 'medium',
				'library'       => 'all',
				'instructions'  => $instructions,
			);
		};

		$fields = array();

		/* ---------------- CHUNG ---------------- */
		$fields[] = $tab( 'general', 'Chung' );
		$fields[] = $image( 'header_logo', 'Logo header', 'Để trống dùng logo mặc định.' );

		/* ---------------- HERO ---------------- */
		$fields[] = $tab( 'hero', 'Hero' );
		$fields[] = $image( 'hero_banner', 'Ảnh banner (1920x792)', 'Ảnh banner trang chủ — chữ đã nằm sẵn trong ảnh. Để trống dùng mặc định.' );
		// Các field dưới đây chỉ dùng cho bản hero cũ (template-parts/section-hero.php).
		$fields[] = $text( 'hero_eyebrow', 'Dòng nhỏ trên', 'ECS GLOBAL EDUCATION SYSTEM' );
		$fields[] = $text( 'hero_script', 'Chữ script (xanh)', 'Kiến tạo' );
		$fields[] = $textarea( 'hero_heading', 'Tiêu đề lớn (mỗi dòng 1 hàng)', "HỆ SINH THÁI\nGIÁO DỤC TOÀN CẦU", 'Mỗi dòng sẽ xuống hàng.', 2 );
		$fields[] = $text( 'hero_badge', 'Nhãn xanh', 'Vì Tương Lai Việt Nam' );
		$fields[] = $text( 'hero_cta_label', 'Nút — chữ', 'TÌM HIỂU THÊM' );
		$fields[] = $text( 'hero_cta_link', 'Nút — link', '', 'Để trống = tự trỏ về chuyên mục "ve-ecs" (/category/ve-ecs/).' );
		$fields[] = $image( 'hero_mark', 'Biểu tượng trong vòng tròn', 'Để trống dùng mặc định.' );

		/* ---------------- ABOUT ---------------- */
		$fields[] = $tab( 'about', 'Về ECS' );
		$fields[] = $text( 'about_eyebrow', 'Dòng nhỏ trên', 'ECSGES' );
		$fields[] = $textarea( 'about_heading', 'Tiêu đề (mỗi dòng 1 hàng)', "KIẾN TẠO HỆ SINH THÁI\nGIÁO DỤC TOÀN CẦU", 'Dòng cuối tô màu cam.', 2 );
		$fields[] = $textarea( 'about_body', 'Nội dung (mỗi đoạn cách nhau 1 dòng trống)', "ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề dày kinh nghiệm của đội ngũ lãnh đạo trẻ, cùng với sự năng động, sáng tạo, đoàn kết của nhiều lớp nhân viên.\n\nSau hơn 9 năm, ECS Global đã khẳng định được vị thế trên thị trường ở các lĩnh vực tuyển sinh, hướng nghiệp khởi nghiệp, việc làm, giáo dục, truyền thông và công nghệ số.", '', 6 );
		$fields[] = $text( 'about_cta_label', 'Link — chữ', 'Tìm hiểu thêm' );
		$fields[] = $text( 'about_cta_link', 'Link — địa chỉ', '', 'Để trống = tự trỏ về chuyên mục "linh-vuc-hoat-dong".' );

		/* ---------------- JOURNEY ---------------- */
		$fields[] = $tab( 'journey', 'Hành trình' );
		$fields[] = $textarea( 'journey_heading', 'Tiêu đề (mỗi dòng 1 hàng)', "ĐỒNG HÀNH CÙNG NHỮNG\nHÀNH TRÌNH PHÁT TRIỂN", '', 2 );
		$fields[] = $textarea( 'journey_body', 'Nội dung', 'ECSGES đồng hành cùng cá nhân, tổ chức và cộng đồng trên hành trình học tập, phát triển năng lực và mở rộng cơ hội trong bối cảnh hiện đại toàn cầu.', '', 4 );
		$fields[] = $text( 'journey_cta_label', 'Link — chữ', 'Tìm hiểu thêm' );
		$fields[] = $text( 'journey_cta_link', 'Link — địa chỉ', '', 'Để trống = tự trỏ về chuyên mục "phat-trien-ben-vung".' );
		$fields[] = $image( 'journey_img_1', 'Ảnh 1 (góc trên phải)' );
		$fields[] = $image( 'journey_img_2', 'Ảnh 2 (giữa)' );
		$fields[] = $image( 'journey_img_3', 'Ảnh 3 (dưới trái)' );
		$fields[] = $image( 'journey_img_4', 'Ảnh 4 (dưới phải)' );

		/* ---------------- ECOSYSTEM ---------------- */
		$fields[] = $tab( 'ecosystem', 'Lĩnh vực' );
		$fields[] = $textarea( 'ecosystem_heading', 'Tiêu đề (mỗi dòng 1 hàng)', "HỆ SINH THÁI\nKẾT NỐI ĐA LĨNH VỰC", '', 2 );
		$fields[] = $textarea( 'ecosystem_intro', 'Đoạn giới thiệu', 'Mỗi lĩnh vực hoạt động của ECSGES là một mắt xích quan trọng, cùng đồng hành với người học trên hành trình học tập, rèn luyện và lập nghiệp.', '', 3 );
		$fields[] = $image( 'ecosystem_image', 'Ảnh minh hoạ (chung cho các tab)' );
		foreach ( $tabs as $i => $t ) {
			$n = $i + 1;
			$fields[] = $text( "ecosystem_tab{$n}_label", "Tab {$n} — nhãn", $t['label'] );
			$fields[] = $text( "ecosystem_tab{$n}_title", "Tab {$n} — tiêu đề", $t['title'] );
			$fields[] = $textarea( "ecosystem_tab{$n}_body", "Tab {$n} — nội dung", $t['body'], '', 4 );
		}

		/* ---------------- BRANCH ---------------- */
		$fields[] = $tab( 'branch', 'Chi nhánh' );
		$fields[] = $textarea( 'branch_heading', 'Tiêu đề (mỗi dòng 1 hàng)', "HỆ THỐNG\nCHI NHÁNH VĂN PHÒNG", '', 2 );
		$fields[] = $image( 'branch_map', 'Ảnh bản đồ' );
		$fields[] = $textarea( 'branch_provinces', 'Tỉnh/thành (mỗi dòng 1 mục)', implode( "\n", ecsges_branch_provinces() ), '', 5 );
		$fields[] = $textarea( 'branch_addresses', 'Gợi ý địa chỉ (mỗi dòng 1 mục)', implode( "\n", ecsges_branch_addresses() ), '', 4 );

		/* ---------------- FOOTER ---------------- */
		$cols     = ecsges_footer_columns();
		$contact  = ecsges_footer_contact();
		$fields[] = $tab( 'footer', 'Footer' );
		$fields[] = $image( 'footer_logo', 'Logo footer (bản trắng)' );
		foreach ( $cols as $i => $col ) {
			$n = $i + 1;
			$fields[] = $text( "footer_col{$n}_title", "Cột {$n} — tiêu đề", $col['title'] );
			$fields[] = $textarea( "footer_col{$n}_links", "Cột {$n} — danh sách (mỗi dòng 1 mục)", implode( "\n", $col['links'] ), '', 5 );
		}
		$fields[] = $text( 'footer_address', 'Địa chỉ', $contact['address'] );
		$fields[] = $text( 'footer_email', 'Email', $contact['email'] );
		$fields[] = $text( 'footer_phone', 'Điện thoại', $contact['phone'] );
		$fields[] = $text( 'footer_facebook', 'Facebook URL', '#' );
		$fields[] = $text( 'footer_youtube', 'YouTube URL', '#' );
		$fields[] = $text( 'footer_tiktok', 'TikTok URL', '#' );

		acf_add_local_field_group(
			array(
				'key'                   => 'group_ecsges_home',
				'title'                 => 'Trang chủ ECSGES — Nội dung',
				'fields'                => $fields,
				'location'              => array(
					array(
						array(
							'param'    => 'page_type',
							'operator' => '==',
							'value'    => 'front_page',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'active'                => true,
				'description'           => 'Nội dung landing page ECSGES. Để trống 1 field sẽ dùng lại nội dung mặc định.',
				'hide_on_screen'        => array( 'the_content' ),
			)
		);

		/* ---------------- CHI TIẾT TUYỂN DỤNG ---------------- */
		acf_add_local_field_group(
			array(
				'key'            => 'group_ecsges_job_detail',
				'title'          => 'Chi tiết tuyển dụng — Nội dung',
				'fields'         => array(
					$text( 'job_salary', 'Mức lương', 'Thoả thuận' ),
					$text( 'job_location', 'Địa điểm', 'Hà Nội' ),
					$text( 'job_department', 'Phòng ban', 'Phòng Công nghệ thông tin và Truyền thông' ),
					$text( 'job_type', 'Loại công việc', 'Toàn thời gian' ),
					$text( 'job_deadline', 'Hạn nộp hồ sơ', 'Thời hạn: 20/7/2026' ),
					array(
						'key'           => 'field_ecsges_job_hot',
						'label'         => 'Đánh dấu Hot',
						'name'          => 'job_hot',
						'type'          => 'true_false',
						'default_value' => 0,
						'ui'            => 1,
						'instructions'  => 'Bật để hiện badge "Hot" trên card ngoài trang danh sách.',
					),
					$wysiwyg(
						'job_description',
						'Mô tả công việc',
						"<ul>\n<li>Xây dựng và triển khai kế hoạch digital marketing theo tháng/quý.</li>\n<li>Quản lý các kênh quảng cáo Facebook, Google, TikTok.</li>\n<li>Theo dõi, đo lường hiệu quả chiến dịch và đề xuất tối ưu.</li>\n<li>Phối hợp với đội Content/Design để sản xuất ấn phẩm truyền thông.</li>\n</ul>",
						'Soạn thảo tự do: danh sách gạch đầu dòng, in đậm, link, bảng… Nội dung cũ nhập kiểu mỗi dòng 1 ý vẫn hiển thị đúng.'
					),
					$wysiwyg(
						'job_requirements',
						'Yêu cầu ứng viên',
						"<ul>\n<li>Tốt nghiệp Cao đẳng/Đại học chuyên ngành Marketing, Truyền thông hoặc liên quan.</li>\n<li>Có ít nhất 1 năm kinh nghiệm ở vị trí tương đương.</li>\n<li>Thành thạo Facebook Ads Manager, Google Ads.</li>\n<li>Có tư duy sáng tạo, chủ động trong công việc.</li>\n</ul>"
					),
					$wysiwyg(
						'job_benefits',
						'Quyền lợi',
						"<ul>\n<li>Lương thoả thuận theo năng lực, review 6 tháng/lần.</li>\n<li>Bảo hiểm đầy đủ theo quy định, thưởng lễ Tết.</li>\n<li>Môi trường làm việc trẻ, năng động, nhiều cơ hội đào tạo.</li>\n<li>Được tham gia các hoạt động team building định kỳ.</li>\n</ul>"
					),
					$wysiwyg(
						'job_how_to_apply',
						'Cách ứng tuyển',
						"<ul>\n<li>Nộp CV trực tiếp qua nút \"Ứng tuyển ngay\" trên trang này.</li>\n<li>Hoặc gửi CV về email tuyendung@ecs.edu.vn, tiêu đề: [Vị trí] - Họ tên.</li>\n<li>Ứng viên phù hợp sẽ được liên hệ phỏng vấn trong vòng 5 ngày làm việc.</li>\n</ul>"
					),
				),
				'location'       => array(
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'page-tuyen-dung-chi-tiet.php',
						),
					),
				),
				'menu_order'     => 1,
				'position'       => 'normal',
				'style'          => 'default',
				'label_placement' => 'top',
				'active'         => true,
				'description'    => 'Nội dung 1 tin tuyển dụng. Gán template "Chi tiết tuyển dụng" cho Page này để field group xuất hiện.',
				'hide_on_screen' => array( 'the_content' ),
			)
		);
	}
);
