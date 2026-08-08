<?php
/**
 * Chi tiết tuyển dụng — cột phải: thẻ công ty + thẻ "Thông tin chung"
 * (Figma node 715:1458, cột x=1236 rộng 360).
 *
 * Đo từ Figma:
 *   - Thẻ công ty 360×326 nền trắng: ô logo 88×88 (viền 0.5px #d3d3d3) + tên
 *     công ty 24px/30px letter-spacing 1px bề ngang 218px đặt cách logo 12px,
 *     rồi 3 dòng "Quy mô / Lĩnh vực / Địa điểm" (nhãn 18px Light #747272, giá
 *     trị 18px Light #000), rồi nút "Xem trang công ty" 323×52 bo 30px viền cam.
 *   - Logo + tên lấy từ ecsges_company_info() — đổi ảnh/tên sửa ở đó.
 *   - Thẻ "Thông tin chung" 360×418 nền trắng: tiêu đề 24px Medium, mỗi dòng
 *     là vòng tròn Ø50 + nhãn 18px Light #747272 + giá trị 18px Light #000.
 *
 * Dòng nào không có dữ liệu thì bỏ hẳn, không hiện nhãn rỗng.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id      = get_the_ID();
$jd_company = ecsges_tr_deep( ecsges_company_info() );

// "Thông tin chung" — nhãn cố định theo Figma, giá trị từ ACF của từng Page.
// Giá trị mặc định lấy đúng nội dung mẫu trong Figma, theo đúng quy ước
// ecsges_field*(): field rỗng thì rơi về mặc định để trang không bị khuyết khối.
// 'icon' = file trong assets/img/tuyen-dung/ (export từ Figma). Lưu ý 3 file
// cap-bac / so-luong / loai-hinh đã VẼ SẴN vòng tròn Ø50 #F0F0F0 bên trong, còn
// hoc-van / hinh-thuc thì không — nên vòng tròn vẫn do .ecs-job-side__row-dot
// (CSS) đảm nhiệm, icon chỉ căn giữa lên trên; hai lớp tròn cùng màu, cùng Ø50
// nên chồng khít, không lộ viền.
$jd_general = array(
	array( 'icon' => 'cap-bac.svg', 'label' => 'Cấp bậc', 'value' => ecsges_field_page( $jd_id, 'job_level', 'Chuyên viên' ) ),
	array( 'icon' => 'hoc-van.svg', 'label' => 'Học vấn', 'value' => ecsges_field_page( $jd_id, 'job_education', 'Cao đẳng trở lên' ) ),
	array( 'icon' => 'so-luong.svg', 'label' => 'Số lượng tuyển', 'value' => ecsges_field_page( $jd_id, 'job_headcount', '2 người' ) ),
	array( 'icon' => 'hinh-thuc.svg', 'label' => 'Hình thức làm việc', 'value' => ecsges_field_page( $jd_id, 'job_work_form', 'Làm việc tại văn phòng' ) ),
	array( 'icon' => 'loai-hinh.svg', 'label' => 'Loại hình làm việc', 'value' => ecsges_field_page( $jd_id, 'job_work_type', 'Toàn thời gian' ) ),
);
$jd_general = array_values(
	array_filter(
		$jd_general,
		static function ( $row ) {
			return '' !== trim( (string) $row['value'] );
		}
	)
);
?>
<aside class="ecs-job-side">
	<div class="ecs-job-side__card ecs-job-side__company">
		<div class="ecs-job-side__head">
			<span class="ecs-job-side__logo" aria-hidden="true">
				<img src="<?php echo esc_url( ecsges_img( $jd_company['logo'] ) ); ?>" alt="" loading="lazy" decoding="async">
			</span>
			<?php if ( '' !== trim( (string) $jd_company['name'] ) ) : ?>
				<?php // nl2br giữ chỗ xuống dòng bắt buộc lấy từ Figma (xem ecsges_company_info). ?>
				<p class="ecs-job-side__name"><?php echo nl2br( esc_html( $jd_company['name'] ) ); ?></p>
			<?php endif; ?>
		</div>

		<ul class="ecs-job-side__facts">
			<?php foreach ( $jd_company['facts'] as $jd_fact ) : ?>
				<li class="ecs-job-side__fact">
					<span class="ecs-job-side__fact-icon" aria-hidden="true"><?php echo ecsges_inline_svg( 'tuyen-dung/' . $jd_fact['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span class="ecs-job-side__fact-label"><?php echo esc_html( $jd_fact['label'] ); ?>:</span>
					<span class="ecs-job-side__fact-value"><?php echo esc_html( $jd_fact['value'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if ( '' !== $jd_company['url'] ) : ?>
			<a href="<?php echo esc_url( $jd_company['url'] ); ?>" class="ecs-job-side__link"><?php echo esc_html( ecsges_t( 'Xem trang công ty' ) ); ?></a>
		<?php endif; ?>
	</div>

	<?php if ( $jd_general ) : ?>
		<div class="ecs-job-side__card ecs-job-side__general">
			<h2 class="ecs-job-side__title"><?php echo esc_html( ecsges_t( 'Thông tin chung' ) ); ?></h2>

			<ul class="ecs-job-side__rows">
				<?php foreach ( $jd_general as $jd_row ) : ?>
					<li class="ecs-job-side__row">
						<span class="ecs-job-side__row-dot" aria-hidden="true"><?php echo ecsges_inline_svg( 'tuyen-dung/' . $jd_row['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span class="ecs-job-side__row-text">
							<span class="ecs-job-side__row-label"><?php echo esc_html( ecsges_t( $jd_row['label'] ) ); ?></span>
							<span class="ecs-job-side__row-value"><?php echo esc_html( $jd_row['value'] ); ?></span>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</aside>
