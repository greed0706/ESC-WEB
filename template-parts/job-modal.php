<?php
/**
 * Modal "Nộp đơn ứng tuyển" — dùng chung cho trang danh sách tuyển dụng
 * (section-tuyen-dung-jobs.php) và template chi tiết tuyển dụng
 * (page-tuyen-dung-chi-tiet.php). Chỉ có MỘT bản trong DOM mỗi trang;
 * assets/js/main.js (initJobModal()) tìm nó qua [data-job-modal] rồi gắn
 * listener cho mọi nút [data-job-apply] trên trang, bất kể nút đó nằm ở
 * đâu trong markup.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="ecs-job-modal" data-job-modal aria-hidden="true">
	<div class="ecs-job-modal__overlay" data-job-modal-close></div>
	<div class="ecs-job-modal__panel" role="dialog" aria-modal="true" aria-labelledby="job-modal-title" data-job-modal-panel tabindex="-1">
		<button type="button" class="ecs-job-modal__close" data-job-modal-close aria-label="<?php echo esc_attr( ecsges_t( 'Đóng' ) ); ?>">&times;</button>

		<h2 id="job-modal-title" class="ecs-job-modal__title">
			<span class="ecs-job-modal__title-line"><?php echo esc_html( ecsges_t( 'NỘP ĐƠN ỨNG TUYỂN' ) ); ?></span>
			<span class="ecs-job-modal__title-line ecs-job-modal__title-job" data-job-modal-position><?php echo esc_html( ecsges_t( 'VỊ TRÍ ...' ) ); ?></span>
		</h2>

		<form class="ecs-job-modal__form" data-job-modal-form>
			<div class="ecs-job-modal__field">
				<label for="job-apply-name"><?php echo esc_html( ecsges_t( 'Họ và tên' ) ); ?><span class="ecs-job-modal__required" aria-hidden="true">*</span></label>
				<input type="text" id="job-apply-name" name="name" placeholder="<?php echo esc_attr( ecsges_t( 'Nhập họ và tên' ) ); ?>" required>
			</div>

			<div class="ecs-job-modal__field">
				<label for="job-apply-email"><?php echo esc_html( ecsges_t( 'Địa chỉ email' ) ); ?><span class="ecs-job-modal__required" aria-hidden="true">*</span></label>
				<input type="email" id="job-apply-email" name="email" placeholder="<?php echo esc_attr( ecsges_t( 'Nhập địa chỉ email' ) ); ?>" required>
			</div>

			<div class="ecs-job-modal__field">
				<label for="job-apply-phone"><?php echo esc_html( ecsges_t( 'Số điện thoại' ) ); ?><span class="ecs-job-modal__required" aria-hidden="true">*</span></label>
				<input type="tel" id="job-apply-phone" name="phone" placeholder="<?php echo esc_attr( ecsges_t( 'Nhập số điện thoại' ) ); ?>" required>
			</div>

			<label class="ecs-job-modal__upload">
				<input type="file" name="cv" hidden data-job-modal-file>
				<span class="ecs-job-modal__upload-title"><?php echo esc_html( ecsges_t( 'CV của bạn' ) ); ?></span>
				<span class="ecs-job-modal__upload-hint" data-job-modal-filename><?php echo esc_html( ecsges_t( 'Click để chọn và tải lên CV của bạn' ) ); ?></span>
			</label>

			<label class="ecs-job-modal__upload">
				<input type="file" name="portfolio" hidden data-job-modal-file>
				<span class="ecs-job-modal__upload-title"><?php echo esc_html( ecsges_t( 'Portfolio của bạn' ) ); ?></span>
				<span class="ecs-job-modal__upload-hint" data-job-modal-filename><?php echo esc_html( ecsges_t( 'Click để chọn và tải lên Portfolio của bạn' ) ); ?></span>
			</label>

			<button type="submit" class="ecs-job-modal__submit"><?php echo esc_html( ecsges_t( 'NỘP ĐƠN ỨNG TUYỂN' ) ); ?></button>
		</form>
	</div>
</div>
