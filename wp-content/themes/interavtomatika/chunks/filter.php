<?php $term = wp_get_object_terms($post->ID,'product_cat'); ?>
<?php $filter = get_filter_values($term[0]->term_id); ?>

<?php $brends = get_terms('yith_product_brand'); ?>

<div class="banner filter">
<div href="#" class="banner-header">
    <span class="banner-header-title">ФИЛЬТР</span>
    <span class="float-right pointer">Сбросить</span>
</div>

<div class="banner-content align-left">

<form id="filter">

<div class="banner-content-title">Бренд</div>

<div class="filter-brand">
    <div class="filter-items filter-brand-items" data-filter-class="filter-brand-items">

        <?php foreach ($brends as $brend) { ?>

            <div class="filter-item">
                <div class="brand-flag icon-brand-flag-<?php echo get_field( 'flag','yith_product_brand_'.$brend->term_id ); ?>"></div>
                <label>
                    <input type="checkbox" name="filter-brands" class="display-none" value="<?php echo translitFilterParameters($brend->name,'encode') ?>"/>
                    <div class="dummy-checkbox glyphicon glyphicon-ok"></div>
                    <span class="item-name"><?php echo $brend->name ?></span>
                </label>
            </div>

        <?php } ?>

    </div>
    <div class="another-brands link-button">Другие бренды (<?php echo count($brends) ?>)</div>

</div>

<div class="filter-juice">

    <div class="banner-content-title"><?php echo qtranxf_useCurrentLanguageIfNotFoundShowAvailable($filter['vyhodnoy_tok']['name']) ?></div>

    <div class="filter-items filter-juice-items" data-filter-class="filter-juice-items">

        <?php $vyhodnoy_tok = $filter['vyhodnoy_tok']['values'] ?>
        <?php sort( $vyhodnoy_tok, SORT_NUMERIC ) ?>
        <?php unset( $filter['vyhodnoy_tok'] ) ?>

        <?php foreach( $vyhodnoy_tok as $value ) { ?>

            <div class="filter-item">
                <label>
                    <input type="checkbox" name="filter-juice[]" value="<?php echo translitFilterParameters($value,'encode') ?>" class="display-none"/>
                    <div class="dummy-checkbox glyphicon glyphicon-ok"></div>
                    <span class="item-name"><?php echo $value ?></span>
                </label>
            </div>

        <?php } ?>
        
    </div>

</div>



<?php foreach( $filter as $key=>$prop) { ?>

    <div class="filter-output">

        <div class="banner-content-title"><?php echo qtranxf_useCurrentLanguageIfNotFoundShowAvailable($prop['name']) ?></div>
        <div class="filter-items filter-output-items" data-filter-class="filter-output-items">

            <?php sort( $prop['values'], SORT_NUMERIC ); ?>
            <?php foreach( $prop['values'] as $value ) { ?>

                <?php $value = qtranxf_useCurrentLanguageIfNotFoundShowAvailable($value); ?>

                <div class="filter-item">
                    <label>
                        <input type="checkbox" name="<?php echo $key; ?>[]" value="<?php echo translitFilterParameters($value,'encode') ?>" class="display-none"/>

                        <div class="dummy-checkbox glyphicon glyphicon-ok"></div>
                        <span class="item-name"><?php echo $value; ?></span>
                    </label>
                </div>

            <?php } ?>

        </div>

    </div>

<?php } ?>


</form>

</div>

</div>