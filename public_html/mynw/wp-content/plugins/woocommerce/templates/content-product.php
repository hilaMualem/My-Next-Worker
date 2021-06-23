<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<?php 
	// // woocommerce_single_product_summary();
	// woocommerce_template_single_title();
	// woocommerce_template_single_price();
	// woocommerce_template_single_excerpt(); ?>
<?php $product_id = get_the_ID(); ?>

<div class="product">
	<div class="product__card product-card">
		<div class="product-card__top">
			<div class="product-card__price">
				₪<?php echo wc_get_product( $product_id )->get_sale_price(); ?>
			</div>
			<div class="product-card__label">לחבילה</div>
		</div>
		<div class="product-card__bottom">
			<div class="product-card__title"><?php echo get_the_title($product_id); ?></div>
			<div class="product-card__about-product">
			<?php the_excerpt(); ?>
			</div>
			<div class="product-card__btn">בחר/י</div>
		</div>
	</div>
</div>

