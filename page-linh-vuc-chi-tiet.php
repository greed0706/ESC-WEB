<?php
/**
 * Template Name: Chi tiết lĩnh vực
 *
 * Gán template này cho 1 WP Page = 1 lĩnh vực hoạt động (Page Attributes →
 * Template, trong wp-admin). Cùng cách làm với "Chi tiết tuyển dụng":
 * một template dùng chung cho nhiều Page, nội dung riêng của từng Page.
 *
 * GHÉP VỚI NÚT "XEM CHI TIẾT" ở trang Lĩnh vực hoạt động: khớp theo SLUG của
 * Page — phải đúng 'id' trong ecsges_linh_vuc_tabs() (inc/data.php):
 *   huong-nghiep | tuyen-sinh | dao-tao | viec-lam | truyen-thong
 * Xem ecsges_linh_vuc_detail_map(). Chưa tạo Page thì nút hiện nhưng bất hoạt.
 *
 * NỘI DUNG: hiện tạm dùng trình soạn thảo của Page (the_content). Khi đã chốt
 * bộ field ACF thì thay khối .ecs-lv-detail__body bằng các part đọc field qua
 * ecsges_field_page( get_the_ID(), ... ) — xem inc/acf-fields.php,
 * template-parts/job-chi-tiet-content.php làm mẫu.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Link về trang cha "Lĩnh vực hoạt động": ưu tiên Page cha thật (nếu Page này
// được đặt làm con), ngược lại tra theo slug để không hardcode đường dẫn.
$lvd_parent_id  = wp_get_post_parent_id( get_the_ID() );
$lvd_parent     = $lvd_parent_id ? get_post( $lvd_parent_id ) : get_page_by_path( 'linh-vuc-hoat-dong' );
$lvd_parent_url = $lvd_parent ? get_permalink( $lvd_parent ) : '';

get_header();
?>
	<main class="ecs-lv-detail">
		<?php
		get_template_part(
			'template-parts/page',
			'hero',
			array(
				'title'   => 'LĨNH VỰC HOẠT ĐỘNG',
				'id'      => 'linh-vuc-detail-hero',
				'bg'      => 'banner-page.png',
				'variant' => 'banner',
				'banner_title' => true,
			)
		);
		?>

		<div class="ecs-lv-detail__inner">
			<?php // Dùng lại đúng kiểu breadcrumb của single/chi tiết tuyển dụng. ?>
			<nav class="ecs-single__breadcrumb" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( ecsges_t( 'Trang chủ' ) ); ?></a>
				<?php if ( '' !== $lvd_parent_url ) : ?>
					<span aria-hidden="true">/</span>
					<a href="<?php echo esc_url( $lvd_parent_url ); ?>"><?php echo esc_html( ecsges_t( 'Lĩnh vực hoạt động' ) ); ?></a>
				<?php endif; ?>
				<span aria-hidden="true">/</span>
				<span class="ecs-single__breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
			</nav>

			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'ecs-lv-detail__article' ); ?>>
					<h1 class="ecs-lv-detail__title"><?php the_title(); ?></h1>

					<?php // TẠM: nội dung nhập ở trình soạn thảo. Thay bằng các field ACF khi đã chốt thiết kế. ?>
					<div class="ecs-lv-detail__body">
						<?php the_content(); ?>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</main>
<?php
get_footer();
