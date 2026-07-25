<?php
/**
 * Section Branch (port BranchSection.tsx) — tìm chi nhánh + bản đồ.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$branch_lines     = ecsges_field_lines( 'branch_heading', array( 'HỆ THỐNG', 'CHI NHÁNH VĂN PHÒNG' ) );
$ecsges_provinces = ecsges_field_lines( 'branch_provinces', ecsges_branch_provinces() );
$ecsges_addresses = ecsges_field_lines( 'branch_addresses', ecsges_branch_addresses() );
$branch_map       = ecsges_field_img( 'branch_map', 'branch-map.png' );
?>
<section id="lien-he" aria-labelledby="branch-heading" class="ecs-branch">
	<div class="ecs-branch__inner">
		<div data-aos="fade-up">
			<?php
			ecsges_section_heading(
				array(
					'id'    => 'branch-heading',
					'align' => 'center',
					'lines' => $branch_lines,
					'class' => 'ecs-branch__heading',
				)
			);
			?>
		</div>

		<div class="ecs-branch__grid">
			<div class="ecs-branch__panel" data-aos="fade-up">
				<label class="ecs-branch__search">
					<?php echo ecsges_icon( 'search', 22, 'ecs-branch__search-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<input type="search" placeholder="<?php echo esc_attr( ecsges_t( 'Tìm tên đường và tỉnh thành' ) ); ?>" class="ecs-branch__search-input">
				</label>

				<div class="ecs-branch__divider">
					<span class="ecs-branch__divider-line"></span>
					<?php echo esc_html( ecsges_t( 'hoặc chọn nhanh' ) ); ?>
					<span class="ecs-branch__divider-line"></span>
				</div>

				<div class="ecs-branch__select-wrap">
					<select aria-label="Tỉnh/thành phố" class="ecs-branch__select">
						<option value="" disabled selected><?php echo esc_html( ecsges_t( 'Tỉnh/thành phố' ) ); ?></option>
						<?php foreach ( $ecsges_provinces as $p ) : ?>
							<option value="<?php echo esc_attr( $p ); ?>"><?php echo esc_html( $p ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php echo ecsges_icon( 'chevron-down', 20, 'ecs-branch__select-caret' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>

				<div class="ecs-branch__suggest">
					<p class="ecs-branch__suggest-title"><?php echo esc_html( ecsges_t( 'Gợi ý' ) ); ?></p>
					<hr class="ecs-branch__suggest-divider">
					<ul class="ecs-branch__suggest-list">
						<?php foreach ( $ecsges_addresses as $i => $addr ) : ?>
							<li>
								<?php if ( $i > 0 ) : ?>
									<hr class="ecs-branch__suggest-divider ecs-branch__suggest-divider--dashed">
								<?php endif; ?>
								<a href="#lien-he" class="ecs-branch__suggest-link">
									<span class="ecs-branch__suggest-dot"></span>
									<?php echo esc_html( $addr ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<img src="<?php echo esc_url( $branch_map ); ?>" alt="<?php echo esc_attr( ecsges_t( 'Bản đồ vị trí chi nhánh ECSGES' ) ); ?>" data-aos="fade-up" data-aos-delay="120" class="ecs-branch__map">
		</div>
	</div>
</section>
