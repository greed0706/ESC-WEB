<?php
/**
 * Footer: SiteFooter (port SiteFooter.tsx) + wp_footer(), đóng thẻ.
 *
 * @package ECSGES
 */

if (!defined('ABSPATH')) {
	exit;
}

// Cột link chân trang: Theme Options → Footer Settings, lùi về mặc định tĩnh
// (ecsges_footer_columns) khi chưa cấu hình. Nhãn đã dịch sang ngôn ngữ đang
// xem và URL đã ánh xạ sang Page/chuyên mục cùng ngôn ngữ — xem
// ecsges_footer_links() trong inc/theme-options.php.
$ecsges_cols = ecsges_footer_links();

$ecsges_default_contact = ecsges_footer_contact();
$ecsges_contact = array(
	'entity' => ecsges_t($ecsges_default_contact['entity']),
	'address' => ecsges_field('footer_address', $ecsges_default_contact['address']),
	'email' => ecsges_field('footer_email', $ecsges_default_contact['email']),
	'phone' => ecsges_field('footer_phone', $ecsges_default_contact['phone']),
);

// Thanh cuối footer: pháp nhân + bản quyền + 3 trang pháp lý. $ecsges_legal
// rỗng = 3 Page chưa được tạo/publish trong admin (theme cố ý không in link chết).
$ecsges_entity = ecsges_footer_legal_entity();
$ecsges_legal = ecsges_footer_legal_links();

$ecsges_logo = ecsges_field_img('footer_logo', 'logo-ecsges-white.svg');
$ecsges_socials = array(
	array('label' => 'Facebook', 'href' => ecsges_field('footer_facebook', 'https://www.facebook.com/ecsglobal.edu.vn'), 'src' => 'social-facebook.svg'),
	array('label' => 'YouTube', 'href' => ecsges_field('footer_youtube', 'https://www.youtube.com/@ecs.global'), 'src' => 'social-youtube.svg'),
	array('label' => 'TikTok', 'href' => ecsges_field('footer_tiktok', 'https://www.tiktok.com/@ecsglobal'), 'src' => 'social-tiktok.svg'),
);
$ecsges_tel = preg_replace('/\./', '', $ecsges_contact['phone']);
?>
<footer class="ecs-footer">
	<div class="ecs-footer__inner">
		<img src="<?php echo esc_url($ecsges_logo); ?>" alt="ECSGES" class="ecs-footer__logo">

		<div class="ecs-footer__grid">
			<?php foreach ($ecsges_cols as $col): ?>
				<nav class="ecs-footer__col" aria-label="<?php echo esc_attr($col['title']); ?>">
					<h2 class="ecs-footer__col-title"><?php echo esc_html($col['title']); ?></h2>
					<ul class="ecs-footer__list">
						<?php foreach ($col['links'] as $link): ?>
							<li>
								<a href="<?php echo esc_url($link['url']); ?>" class="ecs-footer__link">
									<span aria-hidden="true" class="ecs-footer__dot"></span>
									<?php echo esc_html($link['label']); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>

			<div class="ecs-footer__col">
				<?php // Tiêu đề cột = tên thực thể (thay chữ "LIÊN HỆ"), địa chỉ giữ nguyên bên dưới. ?>
				<h2 class="ecs-footer__col-title ecs-footer__col-title--entity"><?php echo esc_html($ecsges_contact['entity']); ?></h2>
				<ul class="ecs-footer__contact">
					<li class="ecs-footer__contact-item">
						<img src="<?php echo esc_url(ecsges_img('footer-pin.svg')); ?>" alt="" aria-hidden="true"
							class="ecs-footer__contact-icon">
						<span><?php echo esc_html(ecsges_t('Địa chỉ:')); ?>
							<?php echo esc_html($ecsges_contact['address']); ?></span>
					</li>
					<li class="ecs-footer__contact-item">
						<img src="<?php echo esc_url(ecsges_img('footer-mail.svg')); ?>" alt="" aria-hidden="true"
							class="ecs-footer__contact-icon">
						<span href="mailto:<?php echo esc_attr($ecsges_contact['email']); ?>"
							>Email:
							<?php echo esc_html($ecsges_contact['email']); ?></span>
					</li>
					<li class="ecs-footer__contact-item">
						<img src="<?php echo esc_url(ecsges_img('footer-phone.svg')); ?>" alt="" aria-hidden="true"
							class="ecs-footer__contact-icon">
						<span href="tel:<?php echo esc_attr($ecsges_tel); ?>"
							><?php echo esc_html(ecsges_t('Điện thoại:')); ?>
							<?php echo esc_html($ecsges_contact['phone']); ?></span>
					</li>
				</ul>

				<ul class="ecs-footer__social">
					<?php foreach ($ecsges_socials as $s): ?>
						<li>
							<a href="<?php echo esc_url($s['href']); ?>" aria-label="<?php echo esc_attr($s['label']); ?>"
								class="ecs-footer__social-link">
								<img src="<?php echo esc_url(ecsges_img($s['src'])); ?>" alt=""
									class="ecs-footer__social-img">
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class="ecs-footer__bottom">
			<div class="ecs-footer__legal">
				<p class="ecs-footer__company"><?php echo esc_html($ecsges_entity['company']); ?></p>
				<p class="ecs-footer__tax"><?php echo esc_html(ecsges_t('Mã số thuế:')); ?>
					<?php echo esc_html($ecsges_entity['tax_id']); ?></p>
				<p class="ecs-footer__copyright"><?php echo esc_html(ecsges_footer_copyright()); ?></p>
			</div>

			<?php if ($ecsges_legal): ?>
				<nav class="ecs-footer__policies" aria-label="<?php echo esc_attr(ecsges_t('Chính sách và điều khoản')); ?>">
					<ul class="ecs-footer__policy-list">
						<?php foreach ($ecsges_legal as $ecsges_l): ?>
							<li>
								<a href="<?php echo esc_url($ecsges_l['url']); ?>"
									class="ecs-footer__policy-link"><?php echo esc_html($ecsges_l['label']); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>
		</div>
	</div>
</footer>
</div><!-- .ecs-page -->
<?php wp_footer(); ?>
</body>

</html>