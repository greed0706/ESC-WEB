<?php
/**
 * Trang Tuyển dụng — tiêu đề, thanh tìm kiếm ngang và lưới card 2 cột
 * (Figma node 724:1878).
 *
 * Đo từ Figma (frame 1920, container 325→1596 = 1271):
 *   - Tiêu đề 2 dòng canh giữa, 50px Medium, line-height 68; dòng 2 màu cam.
 *   - Thanh tìm kiếm: dải #f0f0f0 cao 70 chiếm trọn container, chia 3 ô bởi
 *     2 gạch dọc dài 44, nút "Tìm kiếm" 183×41 bo 20px nền #f26522 ở mép phải.
 *   - Vùng card có nền xám #f0f0f0 chạy hết chiều ngang màn hình.
 *   - Card 625×190 nền trắng, 2 cột, gap 19 ngang / 22 dọc. Trong card:
 *       ô logo 79×79 (lề trái 27, trên 16), tiêu đề 26px Medium lh 32,
 *       badge "Nổi bật" 87×26 nền #f05a28 góc trên phải,
 *       2 thẻ tag 29px cao nền #f0f0f0 (lương, địa điểm),
 *       đường kẻ ngang rồi ghi chú kinh nghiệm 18px Light #a4a4a4.
 *
 * Thay cho bố cục "Bộ lọc cột trái + danh sách cột phải" cũ. GIỮ NGUYÊN các
 * hook JS của initJobsFilter() (assets/js/main.js): [data-jobs], [data-jobs-per],
 * [data-jobs-page], [data-job], [data-jobs-filter], [data-jobs-search],
 * [data-jobs-empty] — nên lọc và phân trang vẫn chạy y như cũ.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Giữ luôn giá trị gốc (chưa dịch) của location/department/type để làm khoá lọc:
// bộ lọc so khớp data-* với value của <option>, không phụ thuộc ngôn ngữ hiển thị.
$ecsges_jobs_all = array();
foreach ( ecsges_jobs_list() as $ecsges_job_raw ) {
	$ecsges_job_tr                   = ecsges_tr_deep( $ecsges_job_raw );
	$ecsges_job_tr['key_location']   = $ecsges_job_raw['location'];
	$ecsges_job_tr['key_department'] = $ecsges_job_raw['department'];
	$ecsges_job_tr['key_type']       = $ecsges_job_raw['type'];
	$ecsges_job_tr['key_level']      = isset( $ecsges_job_raw['level'] ) ? $ecsges_job_raw['level'] : '';
	$ecsges_jobs_all[]               = $ecsges_job_tr;
}

// Figma vẽ 10 card (5 hàng x 2 cột) trên một trang.
$ecsges_jobs_per  = 10;
$ecsges_jobs_pgs  = array_chunk( $ecsges_jobs_all, $ecsges_jobs_per );
$ecsges_jobs_pgct = count( $ecsges_jobs_pgs );
$ecsges_jobs_arw  = ecsges_img( 'arrow.svg' );
// Logo mặc định khi job chưa gán ảnh đại diện riêng (field ACF 'job_logo' —
// xem inc/acf-fields.php / inc/data.php::ecsges_jobs_list()).
$ecsges_jobs_logo = ecsges_img( 'hero-mark.svg' );

/*
 * 3 câu tiêu đề chạy luân phiên (inc/data.php::ecsges_jobs_headlines()).
 *
 * QUY TẮC NGẮT DÒNG: xuống dòng ngay sau MỌI dấu phẩy. Dấu phẩy có thể nằm ở
 * cuối một cụm (câu 1: "GIA NHẬP ECSGES," | "KIẾN TẠO…") hoặc nằm giữa một cụm
 * (câu 2: "PHÁT TRIỂN," | "CỐNG HIẾN…") nên phải xử lý cả hai chỗ. Câu không có
 * dấu phẩy giữ nguyên một dòng.
 *
 * Dựng sẵn HTML ở đây cho phần markup bên dưới gọn; chuỗi đã qua esc_html()
 * trước khi chèn <br> nên an toàn.
 */
$ecsges_jobs_headlines = array();
foreach ( ecsges_jobs_headlines() as $ecsges_hl ) {
	$ecsges_hl_html = '';
	$ecsges_hl_prev = '';
	foreach ( $ecsges_hl as $ecsges_hl_part ) {
		$ecsges_hl_txt = ecsges_t( $ecsges_hl_part['text'] );
		$ecsges_hl_cls = 'ecs-jobs__heading-line';
		if ( ! empty( $ecsges_hl_part['accent'] ) ) {
			$ecsges_hl_cls .= ' ecs-jobs__heading-line--accent';
		}
		if ( '' !== $ecsges_hl_html ) {
			// Cụm trước kết thúc bằng dấu phẩy → ngắt dòng thay cho dấu cách.
			$ecsges_hl_html .= ( ',' === substr( rtrim( $ecsges_hl_prev ), -1 ) ) ? '<br>' : ' ';
		}
		$ecsges_hl_html .= '<span class="' . esc_attr( $ecsges_hl_cls ) . '">'
			// Dấu phẩy nằm GIỮA cụm: cắt luôn khoảng trắng đi sau nó.
			. str_replace( ', ', ',<br>', esc_html( $ecsges_hl_txt ) )
			. '</span>';
		$ecsges_hl_prev = $ecsges_hl_txt;
	}
	$ecsges_jobs_headlines[] = $ecsges_hl_html;
}

// Danh sách đổ vào 3 select bộ lọc (inc/data.php).
$ecsges_job_areas  = ecsges_job_areas();
$ecsges_job_depts  = ecsges_job_departments();
$ecsges_job_levels = ecsges_job_levels();
?>
<section id="tuyen-dung-jobs" aria-labelledby="tuyen-dung-jobs-heading" class="ecs-jobs">
	<div class="ecs-jobs__head">
		<div class="ecs-jobs__head-inner">
			<h1 id="tuyen-dung-jobs-heading" class="ecs-jobs__heading" data-aos="fade-up" data-jobs-headline data-interval="4000">
				<?php foreach ( $ecsges_jobs_headlines as $ecsges_hl_i => $ecsges_headline ) : ?>
					<span class="ecs-jobs__heading-slide<?php echo 0 === $ecsges_hl_i ? ' is-active' : ''; ?>" data-jobs-headline-slide><?php echo $ecsges_headline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — đã escape từng cụm ở trên ?></span>
				<?php endforeach; ?>
			</h1>

			<div class="ecs-jobs__searchbar" data-aos="fade-up" data-aos-delay="80">
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
					<label class="ecs-jobs__label" for="jobs-filter-level"><?php echo esc_html( ecsges_t( 'Cấp bậc' ) ); ?></label>
					<select id="jobs-filter-level" class="ecs-jobs__select" data-jobs-filter="level">
						<option value=""><?php echo esc_html( ecsges_t( '- Chọn cấp bậc -' ) ); ?></option>
						<?php foreach ( $ecsges_job_levels as $ecsges_job_level ) : ?>
							<option value="<?php echo esc_attr( $ecsges_job_level ); ?>"><?php echo esc_html( ecsges_t( $ecsges_job_level ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<button type="button" class="ecs-jobs__search" data-jobs-search>
					<?php echo ecsges_icon( 'search', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php echo esc_html( ecsges_t( 'Tìm kiếm' ) ); ?></span>
				</button>
			</div>
		</div>
	</div>

	<div class="ecs-jobs__body">
		<div class="ecs-jobs__inner">
			<div class="ecs-jobs__list" data-aos="fade-up" data-jobs data-jobs-per="<?php echo esc_attr( $ecsges_jobs_per ); ?>">
				<?php foreach ( $ecsges_jobs_pgs as $ji => $ecsges_jobs_page ) : ?>
					<div data-jobs-page="<?php echo esc_attr( $ji ); ?>" class="ecs-jobs__page<?php echo 0 === $ji ? ' is-active' : ''; ?>">
						<?php foreach ( $ecsges_jobs_page as $ecsges_job ) : ?>
							<?php
							$job_href = ! empty( $ecsges_job['href'] ) ? $ecsges_job['href'] : '';
							$job_tag  = 'ecs-job-card';
							if ( '' === $job_href ) {
								$job_tag .= ' ecs-job-card--inert';
							}
							?>
							<article
								class="<?php echo esc_attr( $job_tag ); ?>"
								data-job
								data-location="<?php echo esc_attr( $ecsges_job['key_location'] ); ?>"
								data-department="<?php echo esc_attr( $ecsges_job['key_department'] ); ?>"
								data-type="<?php echo esc_attr( $ecsges_job['key_type'] ); ?>"
								data-level="<?php echo esc_attr( $ecsges_job['key_level'] ); ?>">

								<?php if ( ! empty( $ecsges_job['tag'] ) ) : ?>
									<span class="ecs-job-card__badge"><?php echo esc_html( ecsges_t( 'Nổi bật' ) ); ?></span>
								<?php endif; ?>

								<?php $ecsges_job_logo_src = ! empty( $ecsges_job['logo'] ) ? $ecsges_job['logo'] : $ecsges_jobs_logo; ?>
								<div class="ecs-job-card__top">
									<span class="ecs-job-card__logo" aria-hidden="true">
										<img src="<?php echo esc_url( $ecsges_job_logo_src ); ?>" alt="" loading="lazy" decoding="async">
									</span>

									<div class="ecs-job-card__main">
										<h3 class="ecs-job-card__title">
											<?php if ( '' !== $job_href ) : ?>
												<a href="<?php echo esc_url( $job_href ); ?>"><?php echo esc_html( $ecsges_job['title'] ); ?></a>
											<?php else : ?>
												<?php echo esc_html( $ecsges_job['title'] ); ?>
											<?php endif; ?>
										</h3>

										<?php
										// Tên đơn vị tuyển dụng — field ACF 'company_name' riêng từng tin (xem
										// inc/data.php::ecsges_jobs_list()); dữ liệu tĩnh cũ (ecsges_jobs()) không
										// có key này nên rơi về tên công ty mặc định.
										$job_company = isset( $ecsges_job['company'] ) ? trim( (string) $ecsges_job['company'] ) : trim( ecsges_company_info()['name'] );
										?>
										<?php if ( '' !== $job_company ) : ?>
											<p class="ecs-job-card__company"><?php echo esc_html( $job_company ); ?></p>
										<?php endif; ?>

										<?php
										// Figma: 2 thẻ tag — mức lương rồi địa điểm. Thiếu field nào
										// thì bỏ thẻ đó, không hiện ô rỗng.
										$job_tags = array_filter(
											array(
												isset( $ecsges_job['salary'] ) ? $ecsges_job['salary'] : '',
												$ecsges_job['location'],
											),
											static function ( $v ) {
												return '' !== trim( (string) $v );
											}
										);
										?>
										<?php if ( $job_tags ) : ?>
											<ul class="ecs-job-card__tags">
												<?php foreach ( $job_tags as $job_tag_text ) : ?>
													<li class="ecs-job-card__tag"><?php echo esc_html( $job_tag_text ); ?></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</div>
								</div>

								<?php
								$job_note = isset( $ecsges_job['experience'] ) ? trim( (string) $ecsges_job['experience'] ) : '';
								if ( '' === $job_note ) {
									$job_note = trim( (string) $ecsges_job['department'] );
								}
								?>
								<p class="ecs-job-card__note"><?php echo esc_html( $job_note ); ?></p>
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
</section>
