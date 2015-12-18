<?php
/**
 * The template for displaying product category.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $woocommerce_loop, $post;

?>

<body <?php body_class("catalog-page"); ?>>

<?php get_template_part('chunks/header-in-body'); ?>

<div class="container-fluid middle-container-wrap">
    <div class="middle-container">

        <?php do_action( 'woocommerce_before_main_content' ); ?>
        <?php do_action( 'woocommerce_archive_description' ); ?>

        <?php show_breadcrumbs('product_cat'); ?>

        <div class="content-aside-wrap">
            <div class="content col-lg-16 col-lg-push-4">
                <div class="catalog-title">
                    <h1>Преобразователи электричеких сигналов</h1>
                    <a class="back" href="#" onclick="history.back();return true">Назад</a>
                </div>

                <div class="catalog-previews-wrap">
                    <div class=" " data-scroll-step="1">
                        <div class="catalog-previews slider-container clearfix">


                            <?php foreach ($product_categories as $key => $category) { ?>

                                    <div class="general-preview">
                                        <?php $cat_link = get_term_link( $category->slug, 'product_cat' ); ?>
                                        <div class="preview-product-count"><?php echo $category->count ?></div>
                                        <a href="<?php echo $cat_link; ?>" class="img-wrap"><?php do_action( 'woocommerce_before_subcategory_title', $category ); ?></a>
                                        <a class="link-as-text" href="<?php echo $cat_link ?>">
                                            <div class="preview-title"><?php echo qtranxf_useCurrentLanguageIfNotFoundShowAvailable ( $category->cat_name );?></div>
                                        </a>
                                    </div>

                            <?php } ?>

                        </div>
                    </div>

                    <div class="left-rewind-grey"></div>
                    <div class="left-rewind-blue"></div>
                    <div class="right-rewind-grey"></div>
                    <div class="right-rewind-blue"></div>

                </div>

                <div class="catalog-article clearfix">
                    <h6 class="catalog-article-title">Что мы знаем про перобразователи сигналов</h6>
                    <div class="img-wrap">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                    </div>
                    <div class="catalog-article-text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci alias aspernatur
                            consectetur consequatur distinctio dolorem dolorum hic id illo illum incidunt laboriosam
                            maiores nulla numquam odit perspiciatis possimus, quas quos recusandae reiciendis saepe sed
                            sequi suscipit temporibus. Expedita, voluptatem.</p>

                        <p>Accusamus consequatur deserunt dolorem, dolorum eaque excepturi facere maiores nam neque
                            nesciunt numquam optio pariatur quo sapiente voluptate. A cumque harum iusto laboriosam
                            maiores nulla officia quam repudiandae vel? Corporis cum excepturi fugiat fugit maxime
                            molestias odio quibusdam, sequi temporibus?</p>

                        <p>A at dolores ducimus eaque maiores quos, vel vero. Delectus facere, facilis mollitia nobis
                            quisquam rem sint sunt veritatis voluptas. Aliquam asperiores autem blanditiis expedita
                            impedit in itaque quo reiciendis saepe voluptate. Cumque cupiditate distinctio maiores
                            molestias nisi pariatur quos.</p>
                    </div>
                </div>

                <?php get_template_part('chunks/viewed-products') ?>
                <?php get_template_part('chunks/articles-in-the-subject') ?>
                <?php get_template_part('chunks/video-in-the-subject') ?>

                <?php do_action( 'woocommerce_after_main_content' ); ?>

            </div>

            <aside class="col-sm-4 col-sm-pull-16">
                <a href="#" class="price-banner-wrap">
                    <div class="price-banner">

                        <img src="<?php echo get_template_directory_uri() ?>/images/pdf-doc.png" class="image-pdf">

                        <div class="price-banner-label">
                            <div class="price-banner-label-text visible-lg">ПРАЙС</div>
                            <div class="price-banner-label-text hidden-lg">ПРАЙС ЛИСТ</div>
                        </div>
                    </div>
                </a>

                <div class="banner list with-numbers">
                    <a href="#" class="banner-header">
                        <span class="banner-header-title">РАЗДЕЛЫ</span>
                    </a>

                    <div class="banner-content align-left">
                        <a href="#">
                            <div class="glyphicon glyphicon-menu-right"></div>
                            <span class="text-wrap">Автоматика</span>
                            <span class="number">4502</span>
                        </a>
                        <a href="#">
                            <div class="glyphicon glyphicon-menu-right"></div>
                            <span class="text-wrap">Электроника</span>
                            <span class="number">772</span>
                        </a>
                        <a href="#">
                            <div class="glyphicon glyphicon-menu-right"></div>
                            <span class="text-wrap">Гидравлика и пневматика</span>
                            <span class="number">2312</span>
                        </a>
                        <a href="#">
                            <div class="glyphicon glyphicon-menu-right"></div>
                            <span class="text-wrap">Производство ТЕНов</span>
                            <span class="number">4502</span>
                        </a>
                        <a href="#">
                            <div class="glyphicon glyphicon-menu-right"></div>
                            <span class="text-wrap">Нащи разработки</span>
                            <span class="number">4502</span>
                        </a>
                    </div>
                </div>

            </aside>

        </div>
    </div>
</div>
