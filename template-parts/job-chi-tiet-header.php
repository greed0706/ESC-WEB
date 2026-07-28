<?php
/**
 * Chi tiết tuyển dụng — breadcrumb + thẻ tóm tắt.
 *
 * Thẻ tóm tắt theo ảnh mẫu: tiêu đề, mức lương (cam), một hàng 3 ô meta
 * (Địa điểm / Kinh nghiệm / Thời hạn ứng tuyển — mỗi ô là icon + nhãn trên,
 * giá trị dưới), rồi nút "Ứng tuyển ngay" pill cam căn giữa. Nút mở lại đúng
 * .ecs-job-modal đã có ở section-tuyen-dung-jobs.php (JS bắt [data-job-apply]).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id       = get_the_ID();
$jd_title    = get_the_title();
$jd_salary   = ecsges_field_page( $jd_id, 'job_salary', 'Thoả thuận' );
$jd_list_url = ecsges_translate_path( '/tuyen-dung/' );

// Giao diện mới đã có nhãn "Thời hạn ứng tuyển" riêng nên ô giá trị chỉ để
// ngày. Các Page nhập trước đây còn tiền tố "Thời hạn: " trong DB → cắt bỏ để
// không thành "Thời hạn ứng tuyển / Thời hạn: 20/7/2026".
$jd_deadline = preg_replace( '/^\s*(Thời hạn|Deadline)\s*:\s*/ui', '', ecsges_field_page( $jd_id, 'job_deadline', '15/08/2026' ) );

// 3 ô meta của thẻ tóm tắt — icon lấy từ assets/img/tuyen-dung/.
$jd_metas = array(
	array(
		'icon'  => 'tuyen-dung/pin.svg',
		'label' => 'Địa điểm',
		'value' => ecsges_field_page( $jd_id, 'job_location', 'Hà Nội' ),
	),
	array(
		'icon'  => 'tuyen-dung/exp.svg',
		'label' => 'Kinh nghiệm',
		'value' => ecsges_field_page( $jd_id, 'job_experience', '3 năm' ),
	),
	array(
		'icon'  => 'tuyen-dung/file.svg',
		'label' => 'Thời hạn ứng tuyển',
		'value' => $jd_deadline,
	),
);
?>
<nav class="ecs-single__breadcrumb" aria-label="Breadcrumb">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( ecsges_t( 'Trang chủ' ) ); ?></a>
	<span aria-hidden="true">/</span>
	<a href="<?php echo esc_url( $jd_list_url ); ?>"><?php echo esc_html( ecsges_t( 'Tuyển dụng' ) ); ?></a>
</nav>

<header class="ecs-job-detail__card ecs-job-detail__summary">
	<h1 class="ecs-job-detail__title"><?php echo esc_html( $jd_title ); ?></h1>
	<p class="ecs-job-detail__salary"><?php echo esc_html( $jd_salary ); ?></p>

	<ul class="ecs-job-detail__meta">
		<?php foreach ( $jd_metas as $jd_meta ) : ?>
			<li class="ecs-job-detail__meta-item">
				<img src="<?php echo esc_url( ecsges_img( $jd_meta['icon'] ) ); ?>" alt="" class="ecs-job-detail__meta-icon">
				<span class="ecs-job-detail__meta-text">
					<span class="ecs-job-detail__meta-label"><?php echo esc_html( ecsges_t( $jd_meta['label'] ) ); ?></span>
					<span class="ecs-job-detail__meta-value"><?php echo esc_html( $jd_meta['value'] ); ?></span>
				</span>
			</li>
		<?php endforeach; ?>
	</ul>

	<button type="button" class="ecs-job-detail__apply ecs-job-detail__apply--hero" data-job-apply data-job-title="<?php echo esc_attr( $jd_title ); ?>" aria-haspopup="dialog">
		<span class="ecs-job-detail__apply-icon" aria-hidden="true"><?php echo ecsges_inline_svg( 'tuyen-dung/hand.svg' ); // phpcs:ignore WordPress.Security.EscapingOutput.OutputNotEscaped -- file SVG của theme. ?></span>
		<?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?>
	</button>
</header>
