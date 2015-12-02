<?php get_header(); ?>

<body <?php body_class('main-page'); ?>>

	<?php get_template_part('chunks/header-in-body'); ?>

        <div class="container-fluid middle-container-wrap">
            <div class="middle-container">

                <div class="content col-lg-16 col-lg-push-4">
                    <div class="automation-components">
                        <h2 class="automation-components-title">Компоненты промышленной автоматики, гидравлики и электроники</h2>
                        <div class="slider-window-wrap">
                            <div class="slider-window" data-scroll-step="1">
                                <div class="automation-components-previews slider-container">
	                                <?php foreach( ia_get_categories(0) as $category ) { ?>

		                                <div class="general-preview start">
	                                        <div class="preview-product-count"><?php echo $category->count ?></div>
	                                        <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="img-wrap"><?php do_action( 'woocommerce_before_subcategory_title', $category ); ?></a>
	                                        <a class="link-as-text" href="#">
	                                            <div class="preview-title"><?php echo $category->cat_name;?></div>
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
                        <div class="block-under-previews">
                            <ul>
                                <li>27 000 наименований товара</li>
                                <li>513 категорий ассортимента</li>
                                <li>Вся продукция напрямую от поставщика</li>
                            </ul>
                            <div class="right-under-previews">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/demo/social.png" alt=""/>
                                <span class="social-text">Поделиться информацией в соцсетях</span>
                            </div>
                        </div>
                    </div>

                    <div class="popular-products">

                        <div class="previews-title">ПОПУЛЯРНОЕ ОБОРУДОВАНИЕ
                            <button class="upstairs-button">Наверх</button>
                        </div>
                        <div class="slider-window-wrap">

                            <div class="slider-window">
                    <div class="popular-previews slider-container">
                    <div class="general-preview">
                        <a href="#" class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </a>
                        <a class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и черные
                            Брызгозащитные клавишные переключатели серии, красного цвета и черные </a>

                        <div class="feedback-thumb icon-thumb">(1)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(2)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(3)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(4)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(5)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(6)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(7)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(8)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(9)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(10)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(11)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(12)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(13)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(14)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(15)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(16)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(17)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(18)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(19)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    <div class="general-preview">
                        <div class="img-wrap">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/demo/switcher.png" alt=""/>
                        </div>
                        <div class="popular-preview-title text-center"> Брызгозащитные клавишные переключатели серии, красного цвета и
                            черные Брызгозащитные клавишные переключатели серии, красного цвета и черные
                        </div>
                        <div class="feedback-thumb icon-thumb">(20)</div>
                        <div class="rating-1-star">
                            <div class="grey-star icon-grey-star"></div>
                            <div class="yellow-star icon-yellow-star"></div>
                        </div>
                        <div class="popular-preview-brand">Hydronix</div>
                        <div class="cart-image icon-empty-cart"></div>
                        <div class="cart-image-hover cart-popup-button icon-cart-hover"></div>
                    </div>
                    </div>
                    </div>

                            <div class="left-rewind-grey"></div>
                            <div class="left-rewind-blue"></div>
                            <div class="right-rewind-grey"></div>
                            <div class="right-rewind-blue"></div>

                        </div>
                    </div>
                    <div class="manufacturers">

                        <?php get_template_part('chunks/brand-previews.php') ?>

                        <div class="block-under-previews">
                            <ul>
                                <li>23 бренда (партнёра) из 8 стран мира</li>
                                <li>40 различных видов импортного оборудования</li>
                            </ul>
                            <div class="right-under-previews">
                                <button class="general-button">Обзор брендов</button>
                            </div>
                        </div>
                    </div>
                    <div class="design-development">
                        <div class="previews-title">ПРОЕКТИРОВАНИЕ И РАЗРАБОТКА ЭЛЕТКРОННЫХ УСТРОЙСТВ
                            <button class="upstairs-button">Наверх</button>
                        </div>
                        <div class="slider-window-wrap">
                            <div class="slider-window" data-scroll-step="1">

                                <div class="design-development-previews slider-container">
                                    <div class="general-preview">
                                        <div>iForse</div>
                                        <a class="img-wrap" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/demo/develop.png" alt=""/></a>
                                        <a class="development-previews-description link-as-text" href="#">Прибор можно держать и управлять
                                            одной рукой. Разработана 4х слойная плата ВЧ и ещё много чего....</a>
                                    </div>
                                    <div class="general-preview">
                                        <div>iForse</div>
                                        <a class="img-wrap" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/demo/develop.png" alt=""/></a>
                                        <a class="development-previews-description link-as-text" href="#">Прибор можно держать и управлять
                                            одной рукой. Разработана 4х слойная плата ВЧ и ещё много чего....</a>
                                    </div>
                                    <div class="general-preview">
                                        <div>iForse</div>
                                        <a class="img-wrap" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/demo/develop.png" alt=""/></a>
                                        <a class="development-previews-description link-as-text" href="#">Прибор можно держать и управлять
                                            одной рукой. Разработана 4х слойная плата ВЧ и ещё много чего....</a>
                                    </div>
                                    <div class="general-preview">
                                        <div>iForse</div>
                                        <a class="img-wrap" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/demo/develop.png" alt=""/></a>
                                        <a class="development-previews-description link-as-text" href="#">Прибор можно держать и управлять
                                            одной рукой. Разработана 4х слойная плата ВЧ и ещё много чего....</a>
                                    </div>
                                    <div class="general-preview">
                                        <div>iForse</div>
                                        <a class="img-wrap" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/demo/develop.png" alt=""/></a>
                                        <a class="development-previews-description link-as-text" href="#">Прибор можно держать и управлять
                                            одной рукой. Разработана 4х слойная плата ВЧ и ещё много чего....</a>
                                    </div>

                                </div>

                            </div>

                            <div class="left-rewind-grey"></div>
                            <div class="left-rewind-blue"></div>
                            <div class="right-rewind-grey"></div>
                            <div class="right-rewind-blue"></div>

                        </div>

                        <div class="block-under-previews">
                            <ul>
                                <li>Проэктирование электронных устройсвт</li>
                                <li>Разработка програмного обеспечения</li>
                                <li>Интеграция оборудования в единую систему</li>
                                <li>Проведение научно-исследовательских работ</li>
                                <li>Разработка оборудования</li>
                                <li>Проэктирование систем автоматизации управления</li>
                            </ul>
                            <div class="right-under-previews">
                                <button class="general-button">Подробнее о сервисе</button>
                            </div>
                        </div>
                    </div>
                    <?php get_template_part('chunks/products/viewed-products.php') ?>
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
            <div class="banner novelty">
                <a href="#" class="banner-header">
                    <span class="banner-header-title">НОВИНКИ</span>
                </a>

                <div class="banner-content align-left">
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Камеры сгорания</span></a>
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Датчики высокго давления</span></a>
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Противопожарные системы полива помещений</span></a>
                </div>
            </div>
            <div class="banner certificate icon-inside">
                <a href="#" class="banner-header">
                    <span class="banner-header-title">СЕРТИФИКАТЫ</span>
                </a>

                <div class="banner-content banner-content-carousel align-center">

                    <div id="banner-carousel" class="carousel slide" data-interval="0" data-ride="carousel">
                        <!-- Carousel indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#banner-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#banner-carousel" data-slide-to="1" class=""></li>
                            <li data-target="#banner-carousel" data-slide-to="2" class=""></li>
                            <li data-target="#banner-carousel" data-slide-to="3" class=""></li>
                        </ol>
                        <!-- Carousel items -->
                        <div class="carousel-inner">

                            <div class="item active">
                                <div class="banner-carousel-title"><a href="#">Hydronix</a></div>
                                <div class="banner-carousel-img-wrap">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/certificate.png" alt=""/>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/certificate.png" alt=""/>

                                    <div class="glyphicon glyphicon-search"></div>
                                </div>
                            </div>
                            <div class="item ">
                                <div class="banner-carousel-title"><a href="#">Hydronix</a></div>
                                <div class="banner-carousel-img-wrap">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/novelty.png" alt=""/>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/novelty.png" alt=""/>

                                    <div class="glyphicon glyphicon-search"></div>
                                </div>
                            </div>
                            <div class="item ">
                                <div class="banner-carousel-title"><a href="#">Hydronix</a></div>
                                <div class="banner-carousel-img-wrap">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/certificate.png" alt=""/>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/certificate.png" alt=""/>

                                    <div class="glyphicon glyphicon-search"></div>
                                </div>
                            </div>
                            <div class="item ">
                                <div class="banner-carousel-title"><a href="#">Hydronix</a></div>
                                <div class="banner-carousel-img-wrap">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/certificate.png" alt=""/>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/demo/certificate.png" alt=""/>

                                    <div class="glyphicon glyphicon-search"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>  
            </div>
            <div class="banner blog">
                <a href="#" class="banner-header">
                    <span class="banner-header-title">БЛОГ</span>
                    <span class="banner-header-all">Все</span>
                </a>

                <div class="banner-content align-left">
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Стандарты качества приборов</a></span>
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Как использовать индуктивные датчики</a></span>
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Проектирование фотоэлементов в лабаратории</a></span>
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Таблицы маркировок блочных элементов</a></span>
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Внедрение в производство</a></span>
                    <a href="#">
                        <div class="glyphicon glyphicon-menu-right"></div>
                        <span class="text-wrap">Автоматика технологических процессов</a></span>
                </div>
            </div>
        </aside>


                <div class="text-under-footer col-lg-16 col-lg-push-4">
            <div class="text-under-footer-title">Мы рады приветствовать Вас на нашем сайте!
                <button class="upstairs-button">Наверх</button>
            </div>
            <div class="text-under-footer-content">
                Наше предприятие поставляет компоненты промышленной автоматики, электроники, пневматики и гидравлики для
                производителей промышленного оборудования, машин и шкафов управления, системных интеграторов, сервисных служб,
                дистрибьюторов и конечных потребителей.
                <br/><br/>
                Наш генеральный партнер-поставщик – международный концерн ОЕМ Automatic
                <br/><br/>
                ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic,
                имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и
                поставок промышленной автоматики и электроники. Головной офис OEM Automatic находится в Транасе (Швеция), акции
                фирмы котируются на Стокгольмской фондовой бирже.
                <br/><br/>
                ООО "Интеравтоматика" с 2007 года является официальным дистрибьютором международного концерна OEM Automatic,
                имеющего филиалы в двенадцати европейских странах и более чем сорокалетний опыт работы в области производства и
                поставок промышленной автоматики и электроники. Головной офис OEM Automatic находится в Транасе (Швеция), акции
                фирмы котируются на Стокгольмской фондовой бирже.
            </div>
        </div>

            </div>
        </div>

        <?php get_footer(); ?>

</body>
</html>