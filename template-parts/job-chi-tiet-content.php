<?php
/**
 * Chi tiết tuyển dụng — nội dung chính: 4 khối Mô tả công việc / Yêu cầu ứng
 * viên / Quyền lợi / Cách ứng tuyển. Mỗi field là WYSIWYG nên nội dung được
 * echo nguyên HTML của editor (đã lọc qua ecsges_rich_text()); giá trị cũ dạng
 * textarea "mỗi dòng 1 ý" vẫn tự dựng lại thành <ul><li>.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id = get_the_ID();

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
		'title' => 'Quyền lợi',
		'body'  => ecsges_field_page( $jd_id, 'job_benefits', '' ),
	),
	array(
		'title' => 'Cách ứng tuyển',
		'body'  => ecsges_field_page( $jd_id, 'job_how_to_apply', '' ),
	),
);
?>
<div class="ecs-job-detail__content">
	<?php foreach ( $jd_blocks as $jd_block ) : ?>
		<?php
		$jd_html = ecsges_rich_text( $jd_block['body'] );
		if ( '' === $jd_html ) {
			continue;
		}
		?>
		<section class="ecs-job-detail__block">
			<h2 class="ecs-job-detail__block-title"><?php echo esc_html( ecsges_t( $jd_block['title'] ) ); ?></h2>
			<div class="ecs-job-detail__block-body">
				<?php echo $jd_html; // phpcs:ignore WordPress.Security.EscapingOutput.OutputNotEscaped -- đã lọc bằng wp_kses_post() trong ecsges_rich_text(). ?>
			</div>
		</section>
	<?php endforeach; ?>
</div>
