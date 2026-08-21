<?php
/**
 * Dòng thông tin dưới <h1> bài viết: tác giả (kèm ảnh) · ngày đăng · ngày sửa.
 *
 * Tác giả lấy từ post type 'tac_gia' (inc/tac-gia.php) — KHÔNG dùng tài khoản
 * WordPress. Bài chưa gán tác giả thì phần tác giả tự ẩn, chỉ còn ngày.
 *
 * Ngày sửa chỉ hiện khi thực sự có sửa: so TIMESTAMP chứ không so chuỗi ngày,
 * vì hai lần lưu trong cùng một ngày vẫn khác giờ và so chuỗi sẽ luôn ra "đã
 * sửa". Ngưỡng 1 phút để bỏ qua chênh lệch lúc WordPress ghi bài lần đầu.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_pid = get_the_ID();
$ecsges_tg  = ecsges_tg_for_post( $ecsges_pid );

$ecsges_pub_ts = (int) get_post_time( 'U', true, $ecsges_pid );
$ecsges_mod_ts = (int) get_post_modified_time( 'U', true, $ecsges_pid );
$ecsges_edited = ( $ecsges_mod_ts - $ecsges_pub_ts ) > MINUTE_IN_SECONDS;
?>
<div class="ecs-byline">
	<?php if ( $ecsges_tg ) : ?>
		<?php
		$ecsges_tg_url   = get_permalink( $ecsges_tg->ID );
		$ecsges_tg_photo = ecsges_tg_photo( $ecsges_tg->ID, 'thumbnail' );
		$ecsges_tg_role  = (string) get_post_meta( $ecsges_tg->ID, 'ecsges_tg_role', true );
		?>
		<a href="<?php echo esc_url( $ecsges_tg_url ); ?>" class="ecs-byline__author" rel="author">
			<span class="ecs-byline__avatar">
				<?php if ( '' !== $ecsges_tg_photo ) : ?>
					<img src="<?php echo esc_url( $ecsges_tg_photo ); ?>" alt="" loading="lazy" decoding="async">
				<?php else : ?>
					<span class="ecs-byline__avatar-fallback" aria-hidden="true"><?php echo esc_html( mb_substr( get_the_title( $ecsges_tg->ID ), 0, 1 ) ); ?></span>
				<?php endif; ?>
			</span>
			<span class="ecs-byline__author-text">
				<span class="ecs-byline__author-name"><?php echo esc_html( get_the_title( $ecsges_tg->ID ) ); ?></span>
				<?php if ( '' !== $ecsges_tg_role ) : ?>
					<span class="ecs-byline__author-role"><?php echo esc_html( $ecsges_tg_role ); ?></span>
				<?php endif; ?>
			</span>
		</a>
	<?php endif; ?>

	<div class="ecs-byline__dates">
		<span class="ecs-byline__date">
			<?php echo esc_html( ecsges_t( 'Ngày đăng:' ) ); ?>
			<time datetime="<?php echo esc_attr( get_post_time( 'c', true, $ecsges_pid ) ); ?>"><?php echo esc_html( get_post_time( 'd/m/Y', false, $ecsges_pid ) ); ?></time>
		</span>

		<?php if ( $ecsges_edited ) : ?>
			<span class="ecs-byline__sep" aria-hidden="true"></span>
			<span class="ecs-byline__date">
				<?php echo esc_html( ecsges_t( 'Cập nhật:' ) ); ?>
				<time datetime="<?php echo esc_attr( get_post_modified_time( 'c', true, $ecsges_pid ) ); ?>"><?php echo esc_html( get_post_modified_time( 'd/m/Y', false, $ecsges_pid ) ); ?></time>
			</span>
		<?php endif; ?>
	</div>
</div>
