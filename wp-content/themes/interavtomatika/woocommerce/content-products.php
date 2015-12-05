<?php
/**
 * The template for displaying products content.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;

?>

<body <?php body_class("products-page"); ?>>

<?php get_template_part('chunks/header-in-body'); ?>

<div class="container-fluid middle-container-wrap">
    <div class="middle-container">


        <?php do_action( 'woocommerce_before_main_content' ); ?>
        <?php do_action( 'woocommerce_archive_description' ); ?>

        <?php show_breadcrumbs($post->ID,'product_cat'); ?>

        <div class="content-aside-wrap">

            <div class="title-parameters-delete-wrap">
                <div class="catalog-title">
                    <h1>Индуктивные датчики, Asco Numatics (Германия)</h1>
                    <a class="back" href="#" onclick="history.back();return true">Назад</a>
                </div>

                <div class="filter-parameters-delete">
                    <div class="filter-brand-items"></div>
                    <div class="filter-phases-items"></div>
                    <div class="filter-juice-items"></div>
                    <div class="filter-output-items"></div>
                    <div class="filter-radiator-items"></div>
                </div>
            </div>

            <aside class="col-sm-4">

                <?php get_template_part('chunks/filter'); ?>

                <div class="products-banners-wrap display-none-less-640">
                    <?php get_template_part('chunks/products-banners'); ?>
                </div>

            </aside>

            <div class="content col-lg-16">

                <div class="search-results-products advanced-pagination-all-wrap">

<!--                    --><?php //do_action( 'woocommerce_before_shop_loop' ); ?>

                    <div class="brand-image img-wrap">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/demo/brand-on-product.png" alt=""/>
                    </div>

                    <?php woocommerce_result_count() ?>


                    <div class="in-stock-wrap">
                        <div class="in-stock">
                            <label>
                                <input type="checkbox" name="in-stock" class="display-none"/>

                                <div class="glyphicon glyphicon-ok"></div>
                                <span>Товары на складе</span>
                            </label>
                        </div>
                    </div>

                    <?php woocommerce_catalog_ordering() ?>

                    <div class="results-products-items advanced-pagination-items">

                        <div class="search-product-items-header">
                            <div class="backlight-cells">
                                <div class="backlight-cells-row clearfix">
                                    <div class="photo">
                                        <span>ФОТО</span>
                                    </div>
                                    <div class="product-denomination">
                                        <span>НАМИЕНОВАНИЕ ТОВАРА</span>
                                    </div>
                                    <div class="manufacturer">
                                        <span>ПРОИЗВОДИТЕЛЬ</span>
                                    </div>
                                    <div class="product-number">
                                        <span>АРТИКУЛ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="stockroom">
                                <span>СКЛАД</span>
                            </div>
                            <div class="cart">
                                <span>КОРЗИНА</span>
                            </div>
                        </div>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php global $product, $woocommerce_loop; ?>

                            <?php
                            if ( empty( $woocommerce_loop['loop'] ) ) {
                                $woocommerce_loop['loop'] = 0;
                            }
                            ?>

                            <?php if ( $product || $product->is_visible() ) { ?>

                                <?php $woocommerce_loop['loop']++; ?>
                                <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

                                <?php $brands = wp_get_post_terms( $product->id, 'yith_product_brand' ); ?>
                                <?php $brand = $brands[0]; ?>

                                <div class="results-product-item advanced-pagination-item">
                                <div class="backlight-cells">
                                    <div class="backlight-cells-row">
                                        <div class="photo">
                                            <a href="<?php the_permalink(); ?>" class="img-wrap">
                                                <?php woocommerce_template_loop_product_thumbnail(); ?>
                                            </a>
                                        </div>
                                        <div class="product-denomination">
                                            <div class="wrap">
                                                <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words($product->post->post_excerpt,25,'...'); ?></a>
                                            </div>
                                        </div>
                                        <div class="product-number"><?php echo $product->get_sku(); ?></div>
                                        <div class="manufacturer">
                                            <div class="wrap">
                                                <?php $pdf = get_pdf_info($product); ?>
                                                <div class="name"><span><?php echo $brand->name; ?></span></div>
                                                <a href="<?php echo $pdf['url']; ?>" class="file">
                                                    <div class="small-image-pdf">PDF</div>
                                                    <div class="size-text">(<?php echo $pdf['size'];  ?>)</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if( $product->is_in_stock() ) { ?>
                                    <div class="stockroom">В наличии</div>
                                <?php } else { ?>
                                    <div class="stockroom bespoke">Под заказ</div>
                                <?php } ?>
                                <div class="cart">
                                    <div class="wrap">
                                        <div class="cart-image icon-empty-cart"></div>
                                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>

                        <?php endwhile; // end of the loop. ?>

                    </div>

                    <div class="pagination pagination-loading-more">
                        <div class="show-more">
                            <div class="swirl-arrows-image"></div>
                            <div class="show-more-text">Показать ещё 25 товаров</div>
                        </div>
                    </div>

                    <div class="wc-pagination-wrap">
                        <?php woocommerce_pagination(); ?>
                    </div>

                    <div class="social-buttons">
                        <?php echo get_option('social_buttons'); ?>
                    </div>

                </div>

                <?php get_template_part('chunks/viewed-products'); ?>

                <?php do_action( 'woocommerce_after_main_content' ); ?>

            </div>

            <aside class="col-sm-4 display-block-less-640 display-none">

                <?php get_template_part('chunks/products-banners'); ?>

            </aside>

            <div class="in-the-subject-wrap">
                <?php //get_template_part('chunks/articles-in-the-subject'); ?>
                <?php //get_template_part('chunks/video-in-the-subject'); ?>
            </div>
        </div>

    </div>
</div>
