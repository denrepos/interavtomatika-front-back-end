<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>


<?php if( ia_get_categories(get_queried_object()->term_id) ) { ?>

    <?php ia_woocommerce_product_subcategories(); ?>

<?php }else{ ?>

    <?php wc_get_template_part( 'content', 'products' ); ?>

<?php } ?>

<?php get_footer(); ?>
