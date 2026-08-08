<?php
/**
 * Lĩnh vực hoạt động — 5 khối xếp dọc, xen kẽ ảnh/chữ (Figma node 23:2121).
 *
 * Đo từ Figma (frame 1920 rộng, container 323 → 1594 = 1271):
 *   - 2 cột 603px, gap 66px; cột ảnh và cột chữ đổi bên qua từng khối
 *     (lẻ = chữ trái, chẵn = ảnh trái).
 *   - Ảnh 603×347 (node img_Vision) → aspect-ratio 603/347.
 *   - Tiêu đề 50px/68px, ls 1px, #000 (Roboto Flex Medium).
 *   - Thân 18px/32px, ls 0.25px, #2d2d2d, canh đều (Roboto Light).
 *   - Nút "Xem thêm" 103×34, bo 20px, nền #f05a28, chữ 16px trắng,
 *     dính mép phải của cột chữ.
 *   - Khoảng cách giữa các khối 73px.
 *
 * Kích thước px của Figma được quy về TỈ LỆ của container theme ($page-max)
 * đúng như quy ước trong CLAUDE.md, nên bố cục giữ nguyên tương quan ở
 * mọi bề rộng.
 *
 * Thay cho template-parts/linh-vuc-tabs.php (bố cục tab/panel cũ) — trang này
 * KHÔNG còn dùng initEcosystemTabs() nữa.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lv_tabs = ecsges_tr_deep( ecsges_linh_vuc_tabs() );

/**
 * Tách chuỗi 'paragraph' nhiều dòng thành các khối để render.
 *
 * Mỗi dòng bắt đầu bằng '-' là một mục danh sách; dòng thường đứng ngay
 * trước một chuỗi bullet được coi là NHÃN của danh sách đó (vd "Việc làm
 * trong nước:"), các dòng còn lại là đoạn văn.
 *
 * @param string $raw Chuỗi gốc.
 * @return array<int,array{type:string,text?:string,label?:string,items?:string[]}>
 */
function ecsges_lv_parse_blocks( $raw ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	$lines = array_values( array_filter( array_map( 'trim', $lines ), static function ( $l ) {
		return '' !== $l;
	} ) );

	$blocks = array();
	$count  = count( $lines );
	$i      = 0;

	while ( $i < $count ) {
		$is_bullet = ( 0 === strpos( $lines[ $i ], '-' ) );
		$next_is_bullet = ( $i + 1 < $count && 0 === strpos( $lines[ $i + 1 ], '-' ) );

		if ( ! $is_bullet && ! $next_is_bullet ) {
			$blocks[] = array(
				'type' => 'p',
				'text' => $lines[ $i ],
			);
			$i++;
			continue;
		}

		$label = '';
		if ( ! $is_bullet ) {
			$label = $lines[ $i ];
			$i++;
		}

		$items = array();
		while ( $i < $count && 0 === strpos( $lines[ $i ], '-' ) ) {
			$items[] = trim( ltrim( $lines[ $i ], '-' ) );
			$i++;
		}

		$blocks[] = array(
			'type'  => 'list',
			'label' => $label,
			'items' => $items,
		);
	}

	return $blocks;
}
?>
<section aria-labelledby="linh-vuc-heading" class="ecs-lv">
	<div class="ecs-lv__inner">
		<h2 id="linh-vuc-heading" class="ecs-lv__visually-hidden"><?php echo esc_html( ecsges_t( 'Lĩnh vực hoạt động' ) ); ?></h2>

		<?php foreach ( $lv_tabs as $i => $tab ) : ?>
			<?php
			$blocks = ecsges_lv_parse_blocks( $tab['paragraph'] );

			// Figma: khối "Việc làm" xếp 2 nhóm danh sách cạnh nhau. Áp dụng
			// chung: hễ phần thân có từ 2 danh sách trở lên thì chia 2 cột.
			$lists = array_values( array_filter( $blocks, static function ( $b ) {
				return 'list' === $b['type'];
			} ) );
			$paras = array_values( array_filter( $blocks, static function ( $b ) {
				return 'p' === $b['type'];
			} ) );
			$two_col_lists = count( $lists ) >= 2;

			// Lẻ (0,2,4) = chữ trái/ảnh phải; chẵn (1,3) = ảnh trái/chữ phải.
			$reversed = ( 1 === $i % 2 );

			// Đích nút "Xem thêm", theo thứ tự ưu tiên:
			//   1. Page chi tiết lĩnh vực (template page-linh-vuc-chi-tiet.php,
			//      slug trùng $tab['id']) nếu đã được tạo trong wp-admin;
			//   2. archive chuyên mục cùng slug — ĐÍCH MẶC ĐỊNH hiện nay, dùng
			//      chung ecsges_category_link() với các link "Lĩnh vực hoạt động"
			//      ở footer (ecsges_footer_columns()) để hai nơi không lệch nhau.
			// Cả hai đều chưa có thì nút render thành <span> bất hoạt.
			$detail_url = ecsges_linh_vuc_detail_url( $tab['id'] );
			if ( '' === $detail_url ) {
				$detail_url = ecsges_category_link( $tab['id'], '' );
			}
			?>
			<article
				id="lv-<?php echo esc_attr( $tab['id'] ); ?>"
				class="ecs-lv__block<?php echo $reversed ? ' ecs-lv__block--reversed' : ''; ?>"
				data-aos="fade-up"
			>
				<div class="ecs-lv__media">
					<img
						src="<?php echo esc_url( ecsges_img( $tab['image'] ) ); ?>"
						alt="<?php echo esc_attr( $tab['label'] ); ?>"
						loading="lazy"
						decoding="async"
						class="ecs-lv__image">
				</div>

				<div class="ecs-lv__body">
					<h3 class="ecs-lv__title"><?php echo esc_html( $tab['label'] ); ?></h3>

					<div class="ecs-lv__text">
						<?php if ( ! empty( $tab['title'] ) ) : ?>
							<p class="ecs-lv__lead"><?php echo esc_html( $tab['title'] ); ?></p>
						<?php endif; ?>

						<?php foreach ( $paras as $para ) : ?>
							<p><?php echo esc_html( $para['text'] ); ?></p>
						<?php endforeach; ?>

						<?php if ( $lists ) : ?>
							<div class="ecs-lv__lists<?php echo $two_col_lists ? ' ecs-lv__lists--split' : ''; ?>">
								<?php foreach ( $lists as $list ) : ?>
									<div class="ecs-lv__list-group">
										<?php if ( '' !== $list['label'] ) : ?>
											<p class="ecs-lv__list-label"><?php echo esc_html( $list['label'] ); ?></p>
										<?php endif; ?>
										<ul class="ecs-lv__list">
											<?php foreach ( $list['items'] as $item ) : ?>
												<li><?php echo esc_html( $item ); ?></li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php
					// Nút sang Page chi tiết của lĩnh vực. Chưa tạo Page (slug =
					// $tab['id'], template "Chi tiết lĩnh vực") thì vẫn hiện nút
					// nhưng bất hoạt — giống card tuyển dụng chưa có Page thật.
					?>
					<div class="ecs-lv__actions">
						<?php if ( '' !== $detail_url ) : ?>
							<a href="<?php echo esc_url( $detail_url ); ?>" class="ecs-lv__more"><?php echo esc_html( ecsges_t( 'Xem thêm' ) ); ?></a>
						<?php else : ?>
							<span class="ecs-lv__more ecs-lv__more--inert" aria-disabled="true"><?php echo esc_html( ecsges_t( 'Xem thêm' ) ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
