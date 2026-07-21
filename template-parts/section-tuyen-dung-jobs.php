<?php
/**
 * Section Bộ lọc + Danh sách việc làm — trang Tuyển dụng.
 * Dữ liệu tĩnh từ ecsges_jobs() (inc/data.php), phân trang 4 job/trang bằng
 * JS thuần (giống cơ chế initNewsPagination() ở section-news.php).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_jobs_all  = ecsges_jobs();
$ecsges_jobs_per  = 4;
$ecsges_jobs_pgs  = array_chunk( $ecsges_jobs_all, $ecsges_jobs_per );
$ecsges_jobs_pgct = count( $ecsges_jobs_pgs );
$ecsges_jobs_arw  = ecsges_img( 'arrow.svg' );
?>
<section id="tuyen-dung-jobs" aria-labelledby="tuyen-dung-jobs-heading" class="ecs-jobs">
	<div class="ecs-jobs__inner">
		<div class="ecs-jobs__filters" data-aos="fade-up">
			<h2 class="ecs-jobs__filters-title">Bộ lọc</h2>

			<div class="ecs-jobs__field">
				<label class="ecs-jobs__label" for="jobs-filter-area">Khu vực</label>
				<select id="jobs-filter-area" class="ecs-jobs__select">
					<option value="" selected disabled>- Chọn khu vực -</option>
				</select>
			</div>

			<div class="ecs-jobs__field">
				<label class="ecs-jobs__label" for="jobs-filter-dept">Phòng ban</label>
				<select id="jobs-filter-dept" class="ecs-jobs__select">
					<option value="" selected disabled>- Chọn phòng ban -</option>
				</select>
			</div>

			<div class="ecs-jobs__field">
				<label class="ecs-jobs__label" for="jobs-filter-level">Cấp bậc</label>
				<select id="jobs-filter-level" class="ecs-jobs__select">
					<option value="" selected disabled>- Chọn cấp bậc -</option>
				</select>
			</div>
		</div>

		<div class="ecs-jobs__list-col">
			<h2 id="tuyen-dung-jobs-heading" class="ecs-jobs__list-title">Tất cả công việc</h2>

			<div class="ecs-jobs__list" data-aos="fade-up" data-aos-delay="120" data-jobs>
				<?php foreach ( $ecsges_jobs_pgs as $ji => $ecsges_jobs_page ) : ?>
					<div data-jobs-page="<?php echo esc_attr( $ji ); ?>" class="ecs-jobs__page<?php echo 0 === $ji ? ' is-active' : ''; ?>">
						<?php foreach ( $ecsges_jobs_page as $ecsges_job ) : ?>
							<article class="ecs-jobs__card">
								<h3 class="ecs-jobs__card-title"><?php echo esc_html( $ecsges_job['title'] ); ?></h3>

								<?php if ( ! empty( $ecsges_job['tag'] ) ) : ?>
									<div class="ecs-jobs__badge ecs-jobs__badge--<?php echo esc_attr( $ecsges_job['tag'] ); ?>">
										<img src="<?php echo esc_url( ecsges_img( 'hot' === $ecsges_job['tag'] ? 'tuyen-dung/star-hot.svg' : 'tuyen-dung/star-new.svg' ) ); ?>" alt="" class="ecs-jobs__badge-star">
										<span class="ecs-jobs__badge-label"><?php echo esc_html( 'hot' === $ecsges_job['tag'] ? 'Hot' : 'Mới' ); ?></span>
									</div>
								<?php endif; ?>

								<ul class="ecs-jobs__info">
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/pin.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['location'] ); ?>
									</li>
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/home.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['department'] ); ?>
									</li>
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/time.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['type'] ); ?>
									</li>
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/file.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['deadline'] ); ?>
									</li>
								</ul>

								<button type="button" class="ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $ecsges_job['title'] ); ?>" aria-haspopup="dialog">ỨNG TUYỂN NGAY &gt;&gt;</button>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $ecsges_jobs_pgct > 1 ) : ?>
				<div class="ecs-jobs__pagination" data-jobs-pagination data-page-count="<?php echo esc_attr( $ecsges_jobs_pgct ); ?>">
					<button type="button" data-jobs-prev aria-label="Trang trước" class="ecs-jobs__arrow">
						<img src="<?php echo esc_url( $ecsges_jobs_arw ); ?>" alt="" class="ecs-jobs__arrow-img">
					</button>

					<div class="ecs-jobs__dots" role="tablist" aria-label="Trang việc làm">
						<?php for ( $i = 0; $i < $ecsges_jobs_pgct; $i++ ) : ?>
							<button type="button" data-jobs-dot="<?php echo esc_attr( $i ); ?>" aria-label="Trang <?php echo esc_attr( $i + 1 ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" class="ecs-jobs__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"></button>
						<?php endfor; ?>
					</div>

					<button type="button" data-jobs-next aria-label="Trang sau" class="ecs-jobs__arrow">
						<img src="<?php echo esc_url( $ecsges_jobs_arw ); ?>" alt="" class="ecs-jobs__arrow-img ecs-jobs__arrow-img--next">
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="ecs-job-modal" data-job-modal aria-hidden="true">
		<div class="ecs-job-modal__overlay" data-job-modal-close></div>
		<div class="ecs-job-modal__panel" role="dialog" aria-modal="true" aria-labelledby="job-modal-title" data-job-modal-panel tabindex="-1">
			<button type="button" class="ecs-job-modal__close" data-job-modal-close aria-label="Đóng">&times;</button>

			<h2 id="job-modal-title" class="ecs-job-modal__title">
				<span class="ecs-job-modal__title-line">NỘP ĐƠN ỨNG TUYỂN</span>
				<span class="ecs-job-modal__title-line ecs-job-modal__title-job" data-job-modal-position>VỊ TRÍ ...</span>
			</h2>

			<form class="ecs-job-modal__form" data-job-modal-form>
				<div class="ecs-job-modal__field">
					<label for="job-apply-name">Họ và tên</label>
					<input type="text" id="job-apply-name" name="name" placeholder="Nhập họ và tên" required>
				</div>

				<div class="ecs-job-modal__field">
					<label for="job-apply-email">Địa chỉ email</label>
					<input type="email" id="job-apply-email" name="email" placeholder="Nhập địa chỉ email" required>
				</div>

				<div class="ecs-job-modal__field">
					<label for="job-apply-phone">Số điện thoại</label>
					<input type="tel" id="job-apply-phone" name="phone" placeholder="Nhập số điện thoại" required>
				</div>

				<label class="ecs-job-modal__upload">
					<input type="file" name="cv" hidden data-job-modal-file>
					<span class="ecs-job-modal__upload-title">CV của bạn</span>
					<span class="ecs-job-modal__upload-hint" data-job-modal-filename>Click để chọn và tải lên CV của bạn</span>
				</label>

				<label class="ecs-job-modal__upload">
					<input type="file" name="portfolio" hidden data-job-modal-file>
					<span class="ecs-job-modal__upload-title">Portfolio của bạn</span>
					<span class="ecs-job-modal__upload-hint" data-job-modal-filename>Click để chọn và tải lên Portfolio của bạn</span>
				</label>

				<button type="submit" class="ecs-job-modal__submit">NỘP ĐƠN ỨNG TUYỂN</button>
			</form>
		</div>
	</div>
</section>
