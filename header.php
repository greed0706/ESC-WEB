<?php
/**
 * Header: <head>, mở <body>, SiteHeader (port SiteHeader.tsx).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_nav      = ecsges_get_nav();
$ecsges_logo     = ecsges_field_img( 'header_logo', 'logo-ecsges.svg' );
$ecsges_langs    = ecsges_languages();
$ecsges_cur_lang = 'VI';
foreach ( $ecsges_langs as $ecsges_l ) {
	if ( ! empty( $ecsges_l['current_lang'] ) ) {
		$ecsges_cur_lang = strtoupper( $ecsges_l['slug'] );
		break;
	}
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script>document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="ecs-page">
	<header class="site-header ecs-header">
		<div class="ecs-header__row">
			<a href="<?php echo esc_url( function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' ) ); ?>" class="ecs-header__logo-link" aria-label="ECSGES — Trang chủ">
				<img src="<?php echo esc_url( $ecsges_logo ); ?>" alt="ECSGES" class="ecs-header__logo">
			</a>

			<div class="ecs-header__actions">
				<nav aria-label="Chính" class="ecs-header__nav">
					<ul class="ecs-header__nav-list">
						<?php foreach ( $ecsges_nav as $item ) : ?>
							<?php $has_children = ! empty( $item['children'] ); ?>
							<li class="ecs-header__nav-item<?php echo $has_children ? ' has-children' : ''; ?>">
								<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-header__nav-link">
									<?php echo esc_html( $item['label'] ); ?>
								</a>
								<?php if ( $has_children ) : ?>
									<div class="ecs-header__dropdown">
										<ul class="ecs-header__dropdown-list">
											<?php foreach ( $item['children'] as $child ) : ?>
												<li>
													<a href="<?php echo esc_url( $child['href'] ); ?>" class="ecs-header__dropdown-link"><?php echo esc_html( $child['label'] ); ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<span class="ecs-header__divider"></span>

				<button type="button" aria-label="Tìm kiếm" class="ecs-header__search-btn">
					<?php echo ecsges_icon( 'search', 17, '', 2 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
				<div class="ecsges-lang" data-lang>
					<button type="button" data-lang-toggle class="ecs-header__lang-toggle" aria-haspopup="true" aria-expanded="false" aria-label="Đổi ngôn ngữ">
						<?php echo esc_html( $ecsges_cur_lang ); ?> <?php echo ecsges_icon( 'chevron-down', 13, 'ecsges-lang-caret', 2.5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
					<div class="ecsges-lang-panel">
						<ul class="ecs-header__lang-list">
							<?php foreach ( $ecsges_langs as $l ) : ?>
								<li>
									<a href="<?php echo esc_url( $l['url'] ); ?>" class="ecs-header__lang-link<?php echo ! empty( $l['current_lang'] ) ? ' ecs-header__lang-link--current' : ''; ?>">
										<?php echo esc_html( $l['name'] ); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<button type="button" id="ecsges-menu-toggle" aria-expanded="false" aria-controls="mobile-menu" aria-label="Mở menu" class="ecs-header__menu-toggle">
					<span data-menu-open><?php echo ecsges_icon( 'menu', 22, '', 2 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span data-menu-close class="is-hidden"><?php echo ecsges_icon( 'x', 22, '', 2 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</button>
			</div>
		</div>

		<nav id="mobile-menu" aria-label="Chính (di động)" class="ecs-header__mobile is-hidden">
			<div class="ecs-header__mobile-inner">
				<ul class="ecs-header__mobile-list">
					<?php foreach ( $ecsges_nav as $i => $item ) : ?>
						<?php $has_children = ! empty( $item['children'] ); ?>
						<li class="ecs-header__mobile-item">
							<div class="ecs-header__mobile-row">
								<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-header__mobile-link" data-menu-link><?php echo esc_html( $item['label'] ); ?></a>
								<?php if ( $has_children ) : ?>
									<button type="button" data-submenu-toggle aria-expanded="false" aria-controls="submenu-<?php echo esc_attr( $i ); ?>" aria-label="Mở menu con <?php echo esc_attr( $item['label'] ); ?>" class="ecs-header__mobile-sub-toggle">
										<?php echo ecsges_icon( 'chevron-down', 16, '', 2.5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</button>
								<?php endif; ?>
							</div>
							<?php if ( $has_children ) : ?>
								<ul id="submenu-<?php echo esc_attr( $i ); ?>" class="ecs-header__mobile-sublist is-hidden">
									<?php foreach ( $item['children'] as $child ) : ?>
										<li>
											<a href="<?php echo esc_url( $child['href'] ); ?>" class="ecs-header__mobile-sublink" data-menu-link><?php echo esc_html( $child['label'] ); ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
					<li class="ecs-header__mobile-lang">
						<span class="ecs-header__mobile-lang-title"><?php echo esc_html( ecsges_t( 'Ngôn ngữ' ) ); ?></span>
						<?php foreach ( $ecsges_langs as $l ) : ?>
							<a href="<?php echo esc_url( $l['url'] ); ?>" class="ecs-header__mobile-lang-link<?php echo ! empty( $l['current_lang'] ) ? ' ecs-header__mobile-lang-link--current' : ''; ?>">
								<?php echo esc_html( $l['name'] ); ?>
							</a>
						<?php endforeach; ?>
					</li>
				</ul>
			</div>
		</nav>
	</header>
