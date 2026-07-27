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

// Giữ luôn giá trị gốc (chưa dịch) của location/department/type để làm khoá lọc:
// bộ lọc so khớp data-* với value của <option>, không phụ thuộc ngôn ngữ hiển thị.
$ecsges_jobs_all = array();
foreach ( ecsges_jobs() as $ecsges_job_raw ) {
	$ecsges_job_tr                   = ecsges_tr_deep( $ecsges_job_raw );
	$ecsges_job_tr['key_location']   = $ecsges_job_raw['location'];
	$ecsges_job_tr['key_department'] = $ecsges_job_raw['department'];
	$ecsges_job_tr['key_type']       = $ecsges_job_raw['type'];
	$ecsges_jobs_all[]               = $ecsges_job_tr;
}

$ecsges_jobs_per  = 4;
$ecsges_jobs_pgs  = array_chunk( $ecsges_jobs_all, $ecsges_jobs_per );
$ecsges_jobs_pgct = count( $ecsges_jobs_pgs );
$ecsges_jobs_arw  = ecsges_img( 'arrow.svg' );

// Danh sách đổ vào 3 select bộ lọc (inc/data.php).
$ecsges_job_areas = ecsges_job_areas();
$ecsges_job_depts = ecsges_job_departments();
$ecsges_job_types = ecsges_job_types();
?>
<section id="tuyen-dung-jobs" aria-labelledby="tuyen-dung-jobs-heading" class="ecs-jobs">
	<div class="ecs-jobs__inner">
		<div class="ecs-jobs__filters" data-aos="fade-up">
			<h2 class="ecs-jobs__filters-title"><?php echo esc_html( ecsges_t( 'Bộ lọc' ) ); ?></h2>

			<div class="ecs-jobs__filters-box">
				<div class="ecs-jobs__field">
					<label class="ecs-jobs__label" for="jobs-filter-area"><?php echo esc_html( ecsges_t( 'Khu vực' ) ); ?></label>
					<select id="jobs-filter-area" class="ecs-jobs__select" data-jobs-filter="location">
						<option value=""><?php echo esc_html( ecsges_t( '- Chọn khu vực -' ) ); ?></option>
						<?php foreach ( $ecsges_job_areas as $ecsges_job_area ) : ?>
							<option value="<?php echo esc_attr( $ecsges_job_area ); ?>"><?php echo esc_html( ecsges_t( $ecsges_job_area ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="ecs-jobs__field">
					<label class="ecs-jobs__label" for="jobs-filter-dept"><?php echo esc_html( ecsges_t( 'Phòng ban' ) ); ?></label>
					<select id="jobs-filter-dept" class="ecs-jobs__select" data-jobs-filter="department">
						<option value=""><?php echo esc_html( ecsges_t( '- Chọn phòng ban -' ) ); ?></option>
						<?php foreach ( $ecsges_job_depts as $ecsges_job_dept ) : ?>
							<option value="<?php echo esc_attr( $ecsges_job_dept ); ?>"><?php echo esc_html( ecsges_t( $ecsges_job_dept ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="ecs-jobs__field">
					<label class="ecs-jobs__label" for="jobs-filter-type"><?php echo esc_html( ecsges_t( 'Loại công việc' ) ); ?></label>
					<select id="jobs-filter-type" class="ecs-jobs__select" data-jobs-filter="type">
						<option value=""><?php echo esc_html( ecsges_t( '- Chọn loại công việc -' ) ); ?></option>
						<?php foreach ( $ecsges_job_types as $ecsges_job_type ) : ?>
							<option value="<?php echo esc_attr( $ecsges_job_type ); ?>"><?php echo esc_html( ecsges_t( $ecsges_job_type ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<button type="button" class="ecs-jobs__search" data-jobs-search><?php echo esc_html( ecsges_t( 'TÌM KIẾM' ) ); ?></button>
			</div>
		</div>

		<div class="ecs-jobs__list-col">
			<h2 id="tuyen-dung-jobs-heading" class="ecs-jobs__list-title"><?php echo esc_html( ecsges_t( 'Tất cả công việc' ) ); ?></h2>

			<div class="ecs-jobs__list" data-aos="fade-up" data-aos-delay="120" data-jobs data-jobs-per="<?php echo esc_attr( $ecsges_jobs_per ); ?>">
				<?php foreach ( $ecsges_jobs_pgs as $ji => $ecsges_jobs_page ) : ?>
					<div data-jobs-page="<?php echo esc_attr( $ji ); ?>" class="ecs-jobs__page<?php echo 0 === $ji ? ' is-active' : ''; ?>">
						<?php foreach ( $ecsges_jobs_page as $ecsges_job ) : ?>
							<article class="ecs-jobs__card" data-job data-location="<?php echo esc_attr( $ecsges_job['key_location'] ); ?>" data-department="<?php echo esc_attr( $ecsges_job['key_department'] ); ?>" data-type="<?php echo esc_attr( $ecsges_job['key_type'] ); ?>">
								<h3 class="ecs-jobs__card-title"><?php echo esc_html( $ecsges_job['title'] ); ?></h3>

								<?php if ( ! empty( $ecsges_job['tag'] ) ) : ?>
									<div class="ecs-jobs__badge ecs-jobs__badge--<?php echo esc_attr( $ecsges_job['tag'] ); ?>">
										<img src="<?php echo esc_url( ecsges_img( 'hot' === $ecsges_job['tag'] ? 'tuyen-dung/star-hot.svg' : 'tuyen-dung/star-new.svg' ) ); ?>" alt="" class="ecs-jobs__badge-star">
										<span class="ecs-jobs__badge-label"><?php echo esc_html( ecsges_t( 'Hot' ) ); ?></span>
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

								<button type="button" class="ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $ecsges_job['title'] ); ?>" aria-haspopup="dialog"><?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?></button>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<p class="ecs-jobs__empty" data-jobs-empty hidden><?php echo esc_html( ecsges_t( 'Không có công việc nào phù hợp với bộ lọc.' ) ); ?></p>

			<?php if ( $ecsges_jobs_pgct > 1 ) : ?>
				<div class="ecs-jobs__pagination" data-jobs-pagination data-page-count="<?php echo esc_attr( $ecsges_jobs_pgct ); ?>" data-page-label="<?php echo esc_attr( ecsges_t( 'Trang' ) ); ?>">
					<button type="button" data-jobs-prev aria-label="<?php echo esc_attr( ecsges_t( 'Trang trước' ) ); ?>" class="ecs-jobs__arrow">
						<img src="<?php echo esc_url( $ecsges_jobs_arw ); ?>" alt="" class="ecs-jobs__arrow-img">
					</button>

					<div class="ecs-jobs__dots" data-jobs-dots role="tablist" aria-label="<?php echo esc_attr( ecsges_t( 'Trang việc làm' ) ); ?>">
						<?php for ( $i = 0; $i < $ecsges_jobs_pgct; $i++ ) : ?>
							<button type="button" data-jobs-dot="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( ecsges_t( 'Trang' ) . ' ' . ( $i + 1 ) ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" class="ecs-jobs__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"></button>
						<?php endfor; ?>
					</div>

					<button type="button" data-jobs-next aria-label="<?php echo esc_attr( ecsges_t( 'Trang sau' ) ); ?>" class="ecs-jobs__arrow">
						<img src="<?php echo esc_url( $ecsges_jobs_arw ); ?>" alt="" class="ecs-jobs__arrow-img ecs-jobs__arrow-img--next">
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>

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
					<label for="job-apply-name"><?php echo esc_html( ecsges_t( 'Họ và tên' ) ); ?></label>
					<input type="text" id="job-apply-name" name="name" placeholder="<?php echo esc_attr( ecsges_t( 'Nhập họ và tên' ) ); ?>" required>
				</div>

				<div class="ecs-job-modal__field">
					<label for="job-apply-email"><?php echo esc_html( ecsges_t( 'Địa chỉ email' ) ); ?></label>
					<input type="email" id="job-apply-email" name="email" placeholder="<?php echo esc_attr( ecsges_t( 'Nhập địa chỉ email' ) ); ?>" required>
				</div>

				<div class="ecs-job-modal__field">
					<label for="job-apply-phone"><?php echo esc_html( ecsges_t( 'Số điện thoại' ) ); ?></label>
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
</section>
