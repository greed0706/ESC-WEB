<?php
/**
 * Chi tiết tuyển dụng — nội dung chính: 4 khối Mô tả công việc / Yêu cầu ứng
 * viên / Quyền lợi / Cách ứng tuyển. Mỗi field textarea (1 dòng = 1 ý) được
 * tách thành <ul><li>, đúng cách linh-vuc-tabs.php đang xử lý paragraph/bullet.
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
		$jd_lines = array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $jd_block['body'] ) ), 'strlen' ) );
		if ( empty( $jd_lines ) ) {
			continue;
		}
		?>
		<section class="ecs-job-detail__block">
			<h2 class="ecs-job-detail__block-title"><?php echo esc_html( ecsges_t( $jd_block['title'] ) ); ?></h2>
			<ul class="ecs-job-detail__block-list">
				<?php foreach ( $jd_lines as $jd_line ) : ?>
					<li><?php echo esc_html( $jd_line ); ?></li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endforeach; ?>
</div>
