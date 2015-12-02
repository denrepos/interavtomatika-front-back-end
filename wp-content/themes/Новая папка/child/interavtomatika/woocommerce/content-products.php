<?php
/**
 * The template for displaying products content.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


get_header();

?>

<body <?php body_class("products-page"); ?>>

<?php get_template_part('chunks/header-in-body'); ?>

<div class="container-fluid middle-container-wrap">
    <div class="middle-container">

        <ul class="breadcrumbs">
            <li><a href="/" class="bc-home"></a></li>
            <li><a href="#">Автоматика</a></li>
            <li><a href="#">Преобразователи сигнлов</a></li>
            <li>Индуктивные датчики</li>
        </ul>

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

                <div class="search-results-products">

                    <div class="brand-image img-wrap">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/demo/brand-on-product.png" alt=""/>
                    </div>

                    <h6 class="found-title">РЕЗУЛЬТАТЫ 1 -25 из 625</h6>

                    <div class="in-stock-wrap">
                        <div class="in-stock">
                            <label>
                                <input type="checkbox" name="in-stock" class="display-none"/>

                                <div class="glyphicon glyphicon-ok"></div>
                                <span>Товары на складе</span>
                            </label>
                        </div>
                    </div>

                    <div class="sort-by-wrap">
                        <select class="sort-by" name="sort-product-by">
                            <option value="popularity">Сортировать по популярности</option>
                            <option value="">Сортировать по дате</option>
                            <option value="">Сортировать по производителю</option>
                        </select>

                        <div class="custom-arrow glyphicon glyphicon-menu-down light-blue-text"></div>
                    </div>

                    <div class="results-products-items">

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
                                
                              
                                <div class="results-product-item">
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
                                                <div class="name"><span>ABIBAS</span></div>
                                                <a href="/docs/guid.pdf" class="file">
                                                    <div class="small-image-pdf">PDF</div>
                                                    <div class="size-text">(118 kb)</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="stockroom">В наличии</div>
                                <div class="cart">
                                    <div class="wrap">
                                        <div class="cart-image icon-empty-cart"></div>
                                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                                    </div>
                                </div>
                            </div>
                                
                                <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                                
                            <?php } ?>

                        <?php endwhile; // end of the loop. ?>


                    </div>

                    <div class="pagination">
                        <div class="show-more">
                            <div class="swirl-arrows-image"></div>
                            <div class="show-more-text">Показать ещё 25 товаров</div>
                        </div>

                        <div class="next-page">

                        </div>
                    </div>
                </div>

                <div class="search-results-text display-none">

                    <h4 class="found-title">Найдено статей: 34</h4>

                    <div class="results-text-items">
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                        <a href="#" class="results-text-item">
                            <h5 class="light-blue-text">Камеры высокого напряжения</h5>
                            <span class="item-text">ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic, имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и поставок промышленной автоматики и электроники индуктивный датчик. Головной офис OEM Automatic находится в Транасе..</span>
                        </a>
                    </div>

                    <div class="pagination">
                        <div class="show-more">
                            <div class="swirl-arrows-image"></div>
                            <div class="show-more-text">Показать ещё 25 статей</div>
                        </div>

                        <div class="next-page">

                        </div>
                    </div>

                </div>

                <?php get_template_part('chunks/viewed-products'); ?>

            </div>

            <aside class="col-sm-4 display-block-less-640 display-none">

                <div class="banner list with-numbers category-list">

                    <a href="#" class="banner-header">
                        <span class="banner-header-title">РАЗДЕЛЫ</span>
                    </a>

                    <div class="banner-content align-left">

                        <a href="#" class="active">
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

            <div class="in-the-subject-wrap">
                <?php get_template_part('chunks/articles-in-the-subject'); ?>
                <?php get_template_part('chunks/video-in-the-subject'); ?>
            </div>
        </div>

    </div>
</div>

<?php get_template_part('chunks/absolute-elements') ?>

<?php get_footer(); ?>

