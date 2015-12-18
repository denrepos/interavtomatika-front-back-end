<?php $category_id = ia_get_current_product_cutegory_id() ?>
<?php $filter = get_filter_values($category_id); ?>
<?php global $ia_filter_url_vars; ?>

<?php $brands = get_terms('yith_product_brand'); ?>

<div class="banner filter">
<div class="banner-header">
    <span class="banner-header-title">ФИЛЬТР</span>
    <a href="<?php echo get_term_link($category_id, 'product_cat') ?>" class="float-right pointer filter-reset">Сбросить</a>

</div>

<div class="banner-content align-left">

<form id="filter">

<div class="banner-content-title">Бренд</div>

<div class="filter-brand">
    <div class="filter-items filter-brand-items" data-filter-class="filter-brand-items">

        <?php $brands = $filter['brand']['values'] ?>
        <?php unset($filter['brand']) ?>

        <?php foreach ($brands as $name => $prop) { ?>

            <?php $checked = $prop['active'] ? 'checked="checked"' : '' ?>
            <?php $flag = $prop['flag']; ?>
            <?php $url = $prop['url']; ?>
            <?php $translit_name = $prop['translit_name']; ?>
            <?php $not_available_class = $prop['available'] ? '' : 'not-available' ; ?>

            <div class="filter-item <?php echo $not_available_class; ?>">
                <div class="brand-flag icon-brand-flag-<?php echo $flag; ?>"></div>
                <label>
                    <input type="checkbox" name="filter-brands" class="display-none" value="<?php echo $translit_name; ?>" <?php echo $checked; ?>/>
                    <div class="dummy-checkbox glyphicon glyphicon-ok"></div>
                    <a href="<?php echo $url; ?>" class="item-name"><?php echo $name ?></a>
                </label>
            </div>

        <?php } ?>

    </div>
    <div class="another-brands link-button">Другие бренды (<?php echo count($brands) ?>)</div>

</div>

<div class="filter-juice">

    <?php $foreach_key = 'vyhodnoy_tok'; ?>
    <?php $foreach_val = $filter['vyhodnoy_tok']; ?>

    <?php $vyhodnoy_tok = $filter[$foreach_key]['values'] ? $filter[$foreach_key]['values'] : array(); ?>

    <div class="banner-content-title"><?php echo qtranxf_useCurrentLanguageIfNotFoundShowAvailable($filter[$foreach_key]['name']) ?></div>

    <?php unset( $filter[$foreach_key] ) ?>

    <div class="filter-items filter-<?php echo $foreach_key; ?>-items" data-filter-class="filter-<?php echo $foreach_key; ?>-items">


        <?php foreach( $vyhodnoy_tok as $value => $props) { ?>

            <?php $checked = $props['active'] ? 'checked="checked"' : '' ?>
            <?php $href = $props['available'] ? 'href="'.$props['url'].'"' : ''; ?>
            <?php $translit_name = $props['translit_name']; ?>
            <?php $not_available_class = $props['available'] ? '' : 'not-available' ; ?>

            <div class="filter-item <?php echo $not_available_class; ?>">
                <label>
                    <input type="checkbox" name="vyhodnoy_tok[]" value="<?php echo $translit_name; ?>" <?php echo $checked ?> class="display-none"/>
                    <div class="dummy-checkbox glyphicon glyphicon-ok"></div>
                    <a <?php echo $href; ?> class="item-name"><?php echo $value ?></a>
                </label>
            </div>

        <?php } ?>
        
    </div>

</div>



<?php foreach( $filter as $key=>$prop) { ?>

    <div class="filter-output">

        <div class="banner-content-title"><?php echo qtranxf_useCurrentLanguageIfNotFoundShowAvailable($prop['name']) ?></div>
        <div class="filter-items filter-<?php echo $key; ?>-items" data-filter-class="filter-<?php echo $key; ?>-items">

            <?php foreach( $prop['values'] as $value => $props ) { ?>

                <?php $checked = $props['active'] ? 'checked="checked"' : '' ?>
                <?php $href = $props['available'] ? 'href="'.$props['url'].'"' : ''; ?>
                <?php $translit_name = $props['translit_name']; ?>
                <?php $not_available_class = $props['available'] ? '' : 'not-available' ; ?>

                <?php $value = qtranxf_useCurrentLanguageIfNotFoundShowAvailable($value); ?>

                <div class="filter-item <?php echo $not_available_class; ?>">
                    <label>
                        <input type="checkbox" name="<?php echo $key; ?>[]" value="<?php echo $translit_name; ?>" <?php echo $checked ?>
                               class="display-none"/>

                        <div class="dummy-checkbox glyphicon glyphicon-ok"></div>
                        <a <?php echo $href; ?> class="item-name"><?php echo $value; ?></a>
                    </label>
                </div>

            <?php } ?>

        </div>

    </div>

<?php } ?>


</form>

</div>

</div>