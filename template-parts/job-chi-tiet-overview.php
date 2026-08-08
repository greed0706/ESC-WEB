<?php
/**
 * Chi tiết tuyển dụng — khối "Tổng quan" (Figma node 715:1458, y=530).
 *
 * 3 hàng nhãn + thẻ chip: Yêu cầu / Quyền lợi / Chuyên môn.
 * Đo từ Figma: nhãn 18px Light #000 ở cột trái, chip cao 40 bo 20px cách nhau
 * 15px. Hai hàng đầu chip nền #f0f0f0 chữ #747272; hàng "Chuyên môn" chip nền
 * trắng viền mảnh chữ #000.
 *
 * Nguồn dữ liệu: 3 field ACF dạng textarea, MỖI DÒNG 1 chip. Hàng nào rỗng thì
 * bỏ hẳn; cả 3 rỗng thì không render khối nào.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id = get_the_ID();

/** Tách textarea thành mảng chip, bỏ dòng trắng. */
$jd_chips = static function ( $raw ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	return array_values(
		array_filter(
			array_map( 'trim', $lines ),
			static function ( $l ) {
				return '' !== $l;
			}
		)
	);
};

// Mặc định = nội dung mẫu trong Figma (quy ước ecsges_field*(): field rỗng thì
// rơi về mặc định để khối không bị khuyết).
$jd_rows = array(
	array(
		'label'   => 'Yêu cầu',
		'items'   => $jd_chips( ecsges_field_page( $jd_id, 'job_tags_requirements', "2 năm kinh nghiệm chuyên môn\nCao Đẳng trở lên" ) ),
		'variant' => '',
	),
	array(
		'label'   => 'Quyền lợi',
		'items'   => $jd_chips( ecsges_field_page( $jd_id, 'job_tags_benefits', "Bảo hiểm xã hội\nLương tháng 13\nDu lịch hàng năm" ) ),
		'variant' => '',
	),
	array(
		'label'   => 'Chuyên môn',
		'items'   => $jd_chips( ecsges_field_page( $jd_id, 'job_tags_specialty', "Digital Marketing\nMarketing/Quảng cáo" ) ),
		'variant' => 'outline',
	),
);

$jd_rows = array_values(
	array_filter(
		$jd_rows,
		static function ( $row ) {
			return ! empty( $row['items'] );
		}
	)
);

if ( empty( $jd_rows ) ) {
	return;
}
?>
<section class="ecs-job-detail__block ecs-job-detail__overview">
	<h2 class="ecs-job-detail__block-title"><?php echo esc_html( ecsges_t( 'Tổng quan' ) ); ?></h2>

	<dl class="ecs-job-detail__facts">
		<?php foreach ( $jd_rows as $jd_row ) : ?>
			<div class="ecs-job-detail__fact">
				<dt class="ecs-job-detail__fact-label"><?php echo esc_html( ecsges_t( $jd_row['label'] ) ); ?>:</dt>
				<dd class="ecs-job-detail__fact-chips">
					<?php foreach ( $jd_row['items'] as $jd_chip ) : ?>
						<span class="ecs-job-detail__chip<?php echo 'outline' === $jd_row['variant'] ? ' ecs-job-detail__chip--outline' : ''; ?>"><?php echo esc_html( ecsges_t( $jd_chip ) ); ?></span>
					<?php endforeach; ?>
				</dd>
			</div>
		<?php endforeach; ?>
	</dl>
</section>
