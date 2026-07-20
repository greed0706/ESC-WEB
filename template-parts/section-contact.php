<?php
/**
 * Section Contact (trang Liên hệ) — form liên hệ + thông tin trụ sở.
 *
 * Nội dung trụ sở dùng lại ecsges_footer_contact() (địa chỉ/email/điện thoại)
 * để đồng nhất với footer. Form hiện là tĩnh (chưa nối backend gửi mail) —
 * xem ghi chú trong page-lien-he.php.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_office = ecsges_footer_contact();
$ecsges_tel    = preg_replace( '/\./', '', $ecsges_office['phone'] );

// Các trường của form (label + type + name + textarea?).
$ecsges_fields = array(
	array( 'name' => 'ho-ten', 'label' => 'Họ và tên', 'type' => 'text',     'autocomplete' => 'name' ),
	array( 'name' => 'phone',  'label' => 'Điện thoại', 'type' => 'tel',      'autocomplete' => 'tel' ),
	array( 'name' => 'email',  'label' => 'Email',      'type' => 'email',    'autocomplete' => 'email' ),
	array( 'name' => 'address','label' => 'Địa chỉ',    'type' => 'text',     'autocomplete' => 'street-address' ),
	array( 'name' => 'message','label' => 'Nội dung',   'type' => 'textarea', 'autocomplete' => '' ),
);
?>
<section aria-labelledby="contact-form-heading" class="ecs-contact">
	<div class="ecs-contact__inner">
		<div class="ecs-contact__grid">

			<!-- Cột trái: form -->
			<div class="ecs-contact__form-col" data-aos="fade-up">
				<h2 id="contact-form-heading" class="ecs-contact__title"><?php echo esc_html( ecsges_t( 'LIÊN HỆ VỚI CHÚNG TÔI' ) ); ?></h2>

				<form class="ecs-contact__form" method="post" novalidate>
					<?php foreach ( $ecsges_fields as $f ) : ?>
						<div class="ecs-contact__field">
							<label for="contact-<?php echo esc_attr( $f['name'] ); ?>" class="ecs-contact__label"><?php echo esc_html( ecsges_t( $f['label'] ) ); ?></label>
							<?php if ( 'textarea' === $f['type'] ) : ?>
								<textarea id="contact-<?php echo esc_attr( $f['name'] ); ?>" name="<?php echo esc_attr( $f['name'] ); ?>" rows="3" class="ecs-contact__input ecs-contact__input--textarea"></textarea>
							<?php else : ?>
								<input
									type="<?php echo esc_attr( $f['type'] ); ?>"
									id="contact-<?php echo esc_attr( $f['name'] ); ?>"
									name="<?php echo esc_attr( $f['name'] ); ?>"
									<?php echo $f['autocomplete'] ? 'autocomplete="' . esc_attr( $f['autocomplete'] ) . '"' : ''; ?>
									class="ecs-contact__input">
							<?php endif; ?>
						</div>
					<?php endforeach; ?>

					<div class="ecs-contact__actions">
						<button type="submit" class="ecs-contact__submit"><?php echo esc_html( ecsges_t( 'GỬI NỘI DUNG' ) ); ?></button>
					</div>
				</form>
			</div>

			<!-- Cột phải: trụ sở -->
			<div class="ecs-contact__office-col" data-aos="fade-up" data-aos-delay="100">
				<h2 class="ecs-contact__title"><?php echo esc_html( ecsges_t( 'TRỤ SỞ' ) ); ?></h2>

				<ul class="ecs-contact__office">
					<li class="ecs-contact__office-item">
						<?php echo ecsges_icon( 'map-pin', 18, 'ecs-contact__office-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php echo esc_html( ecsges_t( 'Địa chỉ:' ) ); ?> <?php echo esc_html( $ecsges_office['address'] ); ?></span>
					</li>
					<li class="ecs-contact__office-item">
						<?php echo ecsges_icon( 'mail', 18, 'ecs-contact__office-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<a href="mailto:<?php echo esc_attr( $ecsges_office['email'] ); ?>" class="ecs-contact__office-link">Email: <?php echo esc_html( $ecsges_office['email'] ); ?></a>
					</li>
					<li class="ecs-contact__office-item">
						<?php echo ecsges_icon( 'phone', 18, 'ecs-contact__office-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<a href="tel:<?php echo esc_attr( $ecsges_tel ); ?>" class="ecs-contact__office-link"><?php echo esc_html( ecsges_t( 'Điện thoại:' ) ); ?> <?php echo esc_html( $ecsges_office['phone'] ); ?></a>
					</li>
				</ul>
			</div>

		</div>
	</div>
</section>
