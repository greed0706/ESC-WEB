<?php
/**
 * Trang Tin tức — thanh 6 tab chủ đề (Figma node 548:9518, hàng y=766 cao 68).
 *
 * Mỗi tab là một <a> ĐIỀU HƯỚNG tới archive category thật (render bởi category.php),
 * KHÔNG phải tab đổi nội dung tại chỗ. Tab "ECSGES" (cat rỗng) = chính trang này.
 *
 * Bố cục dùng justify-content: space-between thay vì hardcode toạ độ x của Figma.
 * Lý do: pill active phải đúng 203px và các nhãn còn lại giãn đều — toạ độ Figma
 * chỉ đúng cho trạng thái "ECSGES active" và cho nhãn tiếng Việt; bản EN nhãn dài
 * khác nên toạ độ cứng sẽ lệch. space-between giữ tab đầu sát lề trái và tab cuối
 * sát lề phải đúng như Figma, phần giữa tự chia.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tt_tabs    = ecsges_news_tabs();
$tt_current = isset( $args['current'] ) ? $args['current'] : '';
?>
<nav class="ecs-newsroom__tabs" aria-label="<?php echo esc_attr( ecsges_t( 'Chủ đề tin tức' ) ); ?>">
	<div class="ecs-newsroom__tabs-inner">
		<ul class="ecs-newsroom__tablist">
			<?php foreach ( $tt_tabs as $tab ) : ?>
				<?php
				$is_active = ( $tab['cat'] === $tt_current );
				// cat rỗng = trang Tin tức; ngược lại lấy link category thật,
				// category chưa tồn tại thì rơi về trang Tin tức.
				$tt_home = ecsges_translate_path( '/tin-tuc/' );
				$tt_href = '' === $tab['cat'] ? $tt_home : ecsges_category_link( $tab['cat'], $tt_home );
				?>
				<li class="ecs-newsroom__tabitem">
					<a
						href="<?php echo esc_url( $tt_href ); ?>"
						class="ecs-newsroom__tab<?php echo $is_active ? ' is-active' : ''; ?>"
						<?php echo $is_active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( ecsges_t( $tab['label'] ) ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
