<?php
/**
 * Chi tiết tuyển dụng — nội dung chính: mỗi khối là một thẻ trắng riêng
 * (Mô tả công việc / Yêu cầu ứng viên / Quyền lợi ứng viên / Địa điểm và thời
 * gian). Mỗi field là WYSIWYG nên nội dung được echo nguyên HTML của editor
 * (đã lọc qua ecsges_rich_text()); giá trị cũ dạng textarea "mỗi dòng 1 ý"
 * vẫn tự dựng lại thành <ul><li>.
 *
 * Theo ảnh mẫu, nút "Ứng tuyển ngay" thứ hai nằm trong thẻ CUỐI CÙNG — nên
 * danh sách khối được lọc bỏ khối rỗng TRƯỚC khi render để biết đâu là thẻ cuối.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id    = get_the_ID();
$jd_title = get_the_title();

$jd_blocks = array(
	array(
		'title' => 'Mô tả công việc',
		'body'  => ecsges_field_page( $jd_id, 'job_description', '' ),
	),
	array(
		'title' => 'Yêu cầu ứng viên',
		'body'  => ecsges_field_page( $jd_id, 'job_requirements', '' ),
	),
	array(
		'title' => 'Quyền lợi ứng viên',
		'body'  => ecsges_field_page( $jd_id, 'job_benefits', '' ),
	),
	array(
		'title' => 'Địa điểm và thời gian',
		'body'  => ecsges_field_page( $jd_id, 'job_how_to_apply', '' ),
	),
);

// Lọc trước: chỉ giữ khối thật sự có nội dung sau khi qua ecsges_rich_text().
$jd_rendered = array();
foreach ( $jd_blocks as $jd_block ) {
	$jd_html = ecsges_rich_text( $jd_block['body'] );
	if ( '' === $jd_html ) {
		continue;
	}
	$jd_rendered[] = array(
		'title' => $jd_block['title'],
		'html'  => $jd_html,
	);
}

$jd_last = count( $jd_rendered ) - 1;
?>
<?php foreach ( $jd_rendered as $jd_i => $jd_block ) : ?>
	<section class="ecs-job-detail__card ecs-job-detail__block">
		<h2 class="ecs-job-detail__block-title"><?php echo esc_html( ecsges_t( $jd_block['title'] ) ); ?></h2>
		<div class="ecs-job-detail__block-body">
			<?php echo $jd_block['html']; // phpcs:ignore WordPress.Security.EscapingOutput.OutputNotEscaped -- đã lọc bằng wp_kses_post() trong ecsges_rich_text(). ?>
		</div>

		<?php if ( $jd_i === $jd_last ) : ?>
			<button type="button" class="ecs-job-detail__apply" data-job-apply data-job-title="<?php echo esc_attr( $jd_title ); ?>" aria-haspopup="dialog"><?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?></button>
		<?php endif; ?>
	</section>
<?php endforeach; ?>
