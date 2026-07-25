<?php
/**
 * Form tìm kiếm dùng chung (get_search_form()) — ô nhập + nút cam.
 * Header dùng biến thể riêng (.ecs-search--header) trong header.php.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="ecs-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="ecs-search__label" for="ecs-search-field"><?php echo esc_html( ecsges_t( 'Tìm kiếm' ) ); ?></label>
	<input type="search" id="ecs-search-field" class="ecs-search__input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( ecsges_t( 'Nhập từ khoá...' ) ); ?>">
	<button type="submit" class="ecs-search__submit"><?php echo esc_html( ecsges_t( 'TÌM KIẾM' ) ); ?></button>
</form>
