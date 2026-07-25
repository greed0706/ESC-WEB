<?php
/**
 * Footer: SiteFooter (port SiteFooter.tsx) + wp_footer(), đóng thẻ.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_default_cols = ecsges_footer_columns();
$ecsges_cols         = array();
foreach ( $ecsges_default_cols as $i => $col ) {
	$n              = $i + 1;
	$ecsges_labels  = ecsges_field_lines( "footer_col{$n}_links", $col['links'] );
	$ecsges_hrefs   = array();
	// Nhãn hiển thị có thể đã dịch (EN) hoặc bị ACF ghi đè, nên href dò theo nhãn VN
	// gốc CÙNG VỊ TRÍ trong $col['links']. Nếu ACF đổi số dòng thì lệch vị trí → '#'.
	foreach ( $ecsges_labels as $ecsges_li => $ecsges_unused ) {
		$ecsges_vn   = isset( $col['links'][ $ecsges_li ] ) ? $col['links'][ $ecsges_li ] : '';
		$ecsges_slug = ( ! empty( $col['cats'] ) && isset( $col['cats'][ $ecsges_vn ] ) ) ? $col['cats'][ $ecsges_vn ] : '';
		$ecsges_hrefs[ $ecsges_li ] = $ecsges_slug ? ecsges_category_link( $ecsges_slug, '#' ) : '#';
	}
	$ecsges_cols[] = array(
		'title' => ecsges_field( "footer_col{$n}_title", $col['title'] ),
		'links' => $ecsges_labels,
		'hrefs' => $ecsges_hrefs,
	);
}

$ecsges_default_contact = ecsges_footer_contact();
$ecsges_contact         = array(
	'address' => ecsges_field( 'footer_address', $ecsges_default_contact['address'] ),
	'email'   => ecsges_field( 'footer_email', $ecsges_default_contact['email'] ),
	'phone'   => ecsges_field( 'footer_phone', $ecsges_default_contact['phone'] ),
);

$ecsges_logo    = ecsges_field_img( 'footer_logo', 'logo-ecsges-white.svg' );
$ecsges_socials = array(
	array( 'label' => 'Facebook', 'href' => ecsges_field( 'footer_facebook', '#' ), 'src' => 'social-facebook.svg' ),
	array( 'label' => 'YouTube',  'href' => ecsges_field( 'footer_youtube', '#' ),  'src' => 'social-youtube.svg' ),
	array( 'label' => 'TikTok',   'href' => ecsges_field( 'footer_tiktok', '#' ),   'src' => 'social-tiktok.svg' ),
);
$ecsges_tel = preg_replace( '/\./', '', $ecsges_contact['phone'] );
?>
	<footer class="ecs-footer">
		<div class="ecs-footer__inner">
			<img src="<?php echo esc_url( $ecsges_logo ); ?>" alt="ECSGES" class="ecs-footer__logo">

			<div class="ecs-footer__grid">
				<?php foreach ( $ecsges_cols as $ci => $col ) : ?>
					<nav class="ecs-footer__col" aria-label="<?php echo esc_attr( $col['title'] ); ?>">
						<h2 class="ecs-footer__col-title"><?php echo esc_html( $col['title'] ); ?></h2>
						<ul class="ecs-footer__list">
							<?php foreach ( $col['links'] as $li => $link ) : ?>
								<li>
									<a href="<?php echo esc_url( isset( $col['hrefs'][ $li ] ) ? $col['hrefs'][ $li ] : '#' ); ?>" class="ecs-footer__link">
										<span aria-hidden="true" class="ecs-footer__dot"></span>
										<?php echo esc_html( $link ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</nav>
				<?php endforeach; ?>

				<div class="ecs-footer__col">
					<h2 class="ecs-footer__col-title"><?php echo esc_html( ecsges_t( 'ĐỊA CHỈ' ) ); ?></h2>
					<ul class="ecs-footer__contact">
						<li class="ecs-footer__contact-item">
							<img src="<?php echo esc_url( ecsges_img( 'footer-pin.svg' ) ); ?>" alt="" aria-hidden="true" class="ecs-footer__contact-icon">
							<span><?php echo esc_html( ecsges_t( 'Địa chỉ:' ) ); ?> <?php echo esc_html( $ecsges_contact['address'] ); ?></span>
						</li>
						<li class="ecs-footer__contact-item">
							<img src="<?php echo esc_url( ecsges_img( 'footer-mail.svg' ) ); ?>" alt="" aria-hidden="true" class="ecs-footer__contact-icon">
							<a href="mailto:<?php echo esc_attr( $ecsges_contact['email'] ); ?>" class="ecs-footer__contact-link">Email: <?php echo esc_html( $ecsges_contact['email'] ); ?></a>
						</li>
						<li class="ecs-footer__contact-item">
							<img src="<?php echo esc_url( ecsges_img( 'footer-phone.svg' ) ); ?>" alt="" aria-hidden="true" class="ecs-footer__contact-icon">
							<a href="tel:<?php echo esc_attr( $ecsges_tel ); ?>" class="ecs-footer__contact-link"><?php echo esc_html( ecsges_t( 'Điện thoại:' ) ); ?> <?php echo esc_html( $ecsges_contact['phone'] ); ?></a>
						</li>
					</ul>

					<ul class="ecs-footer__social">
						<?php foreach ( $ecsges_socials as $s ) : ?>
							<li>
								<a href="<?php echo esc_url( $s['href'] ); ?>" aria-label="<?php echo esc_attr( $s['label'] ); ?>" class="ecs-footer__social-link">
									<img src="<?php echo esc_url( ecsges_img( $s['src'] ) ); ?>" alt="" class="ecs-footer__social-img">
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</footer>
</div><!-- .ecs-page -->
<?php wp_footer(); ?>
</body>
</html>
