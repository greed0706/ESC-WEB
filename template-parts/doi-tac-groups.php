<?php
/**
 * Trang Đối tác — 4 khối logo (Figma node 539:372).
 *
 * Mỗi khối = tiêu đề cam-đen căn giữa + lưới 5 cột các ô 233x153 (viền 0.5px #a4a4a4).
 * Logo giữ đúng kích thước px của Figma qua inline style (cùng cách section-about.php
 * đặt toạ độ pin) — ô card cố định nên logo không được scale đồng loạt.
 *
 * Dữ liệu: ecsges_partner_groups() trong inc/data.php.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$partner_groups = ecsges_tr_deep( ecsges_partner_groups() );
?>
<div class="ecs-partners">
	<?php foreach ( $partner_groups as $gi => $group ) : ?>
		<?php
		$group_n  = $gi + 1;
		$group_id = 'doi-tac-' . $group_n;
		?>
		<section id="<?php echo esc_attr( $group_id ); ?>" aria-labelledby="<?php echo esc_attr( $group_id ); ?>-heading" class="ecs-partners__group">
			<div class="ecs-partners__inner">
				<h2 id="<?php echo esc_attr( $group_id ); ?>-heading" class="ecs-partners__heading" data-aos="fade-up"><?php echo esc_html( $group['title'] ); ?></h2>

				<ul class="ecs-partners__grid" data-aos="fade-up" data-aos-delay="80">
					<?php foreach ( $group['logos'] as $logo ) : ?>
						<?php
						// Bỏ hẳn ô nếu file ảnh chưa được export vào theme — thà thiếu
						// một ô còn hơn hiện ô rỗng/ảnh vỡ. Thả đúng tên file vào
						// assets/img/doi-tac/ là ô tự xuất hiện lại.
						if ( ! file_exists( get_theme_file_path( 'assets/img/doi-tac/' . $logo['file'] ) ) ) {
							continue;
						}
						?>
						<li class="ecs-partners__cell">
							<?php
							// width/height attribute = cỡ Figma (giữ aspect-ratio, chống layout shift).
							// --logo-w = cùng số đó nhưng KHÔNG đơn vị: SCSS chia cho 233 (bề rộng ô
							// trong Figma) để ra % bề rộng ô, nên tỉ lệ logo/ô đúng Figma ở mọi màn.
							?>
							<img
								src="<?php echo esc_url( ecsges_img( 'doi-tac/' . $logo['file'] ) ); ?>"
								alt="<?php echo esc_attr( $logo['alt'] ); ?>"
								width="<?php echo esc_attr( $logo['w'] ); ?>"
								height="<?php echo esc_attr( $logo['h'] ); ?>"
								loading="lazy"
								decoding="async"
								class="ecs-partners__logo"
								style="--logo-w:<?php echo esc_attr( $logo['w'] ); ?>">
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endforeach; ?>
</div>
