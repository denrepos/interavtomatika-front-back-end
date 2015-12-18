<?php
/**
 * storefront engine room
 *
 * @package storefront
 */

/**
 * Initialize all the things.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woothemes/theme-customisations
 */


//switch off admin panel
show_admin_bar(false);


//for url hierarchy
add_filter( 'woocommerce_taxonomy_args_product_cat', function($args){
    $args['rewrite']['hierarchical'] = false;
    return  $args;
} );

//disable auto update for "all import" plugin
function filter_plugin_updates( $update ) {
	$disable_update = array( 'wp-all-import','woocommerce');
	if( !is_array($disable_update) || count($disable_update) == 0 ){  return $update;  }
	foreach( $update->response as $name => $val ){
		foreach( $disable_update as $plugin ){
			if( stripos($name,$plugin) !== false ){
				unset( $update->response[ $name ] );
			}
		}
	}
	return $update;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );



add_theme_support( 'woocommerce' );


// change location of main style.css
function wpi_stylesheet_dir_uri($stylesheet_dir_uri, $theme_name){

	$subdir = '/css';
	return $stylesheet_dir_uri.$subdir;

}
add_filter('stylesheet_directory_uri','wpi_stylesheet_dir_uri',10,2);

//disable woocommerce default stylesheets
add_filter( 'woocommerce_enqueue_styles', function(){return array();} );

// include css and js
function interavtomatika_scripts() {
	wp_enqueue_style( 'sprites', get_template_directory_uri() . '/css/sprites.css' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'main-style', get_stylesheet_uri(), array('bootstrap') );
	wp_enqueue_script( 'jquery-requestAnimationFrame', get_template_directory_uri() . '/js/jquery/jquery.requestAnimationFrame.min.js', array(), '1.0.0');
	wp_enqueue_script( 'jquery-colorbox', get_template_directory_uri() . '/js/jquery.colorbox-min.js', array(), '1.0.0');
	wp_enqueue_script( 'jquery-event-move', get_template_directory_uri() . '/js/jquery.event.move.js', array(), '1.0.0');
	wp_enqueue_script( 'jquery-event-swipe', get_template_directory_uri() . '/js/jquery.event.swipe.js', array(), '1.0.0');
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0.0');
	wp_enqueue_script( 'functions', get_template_directory_uri() . '/js/functions.js', array(), '1.0.0');
}

add_action( 'wp_enqueue_scripts', 'interavtomatika_scripts' );

// support custom appearance
$args = array(
	'default-image' => get_template_directory_uri() . '/images/main_logo.png',
);
add_theme_support( 'custom-header', $args );

// rewritten woocommerce functions

function ia_woocommerce_product_subcategories( $args = array() ) {
    global $wp_query;

    $defaults = array(
        'before'        => '',
        'after'         => '',
        'force_display' => false
    );

    $args = wp_parse_args( $args, $defaults );

    extract( $args );

    // Main query only
    if ( ! is_main_query() && ! $force_display ) {
        return;
    }

    // Don't show when filtering, searching or when on page > 1 and ensure we're on a product archive
    if ( is_search() || is_filtered() || is_paged() || ( ! is_product_category() && ! is_shop() ) ) {
        return;
    }

    // Check categories are enabled
    if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == '' ) {
        return;
    }

    // Find the category + category parent, if applicable
    $term 			= get_queried_object();
    $parent_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

    if ( is_product_category() ) {
        $display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

        switch ( $display_type ) {
            case 'products' :
                return;
                break;
            case '' :
                if ( get_option( 'woocommerce_category_archive_display' ) == '' ) {
                    return;
                }
                break;
        }
    }

    // NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( http://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
    $product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
        'parent'       => $parent_id,
        'menu_order'   => 'ASC',
        'hide_empty'   => 0,
        'hierarchical' => 1,
        'taxonomy'     => 'product_cat',
        'pad_counts'   => 1
    ) ) );

//    if ( ! apply_filters( 'woocommerce_product_subcategories_hide_empty', false ) ) {
        $product_categories = wp_list_filter( $product_categories, array( 'count' => 0 ), 'NOT' );
//    }

    if ( $product_categories ) {

        wc_get_template( 'content-product_cat.php', array(
            'product_categories' => $product_categories
        ) );

        // If we are hiding products disable the loop and pagination
        if ( is_product_category() ) {
            $display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

            switch ( $display_type ) {
                case 'subcategories' :
                    $wp_query->post_count    = 0;
                    $wp_query->max_num_pages = 0;
                    break;
                case '' :
                    if ( get_option( 'woocommerce_category_archive_display' ) == 'subcategories' ) {
                        $wp_query->post_count    = 0;
                        $wp_query->max_num_pages = 0;
                    }
                    break;
            }
        }

        if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
            $wp_query->post_count    = 0;
            $wp_query->max_num_pages = 0;
        }

        echo $after;

        return true;
    }
}

function ia_get_categories($parent_id = false){

	$args = array(
		'menu_order'   => 'ASC',
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'taxonomy'     => 'product_cat',
		'pad_counts'   => 0
	);

	if($parent_id !== false){
		$args['parent'] = $parent_id;
	}

	$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', $args) );

	if ( ! apply_filters( 'woocommerce_product_subcategories_hide_empty', false ) ) {
		$product_categories = wp_list_filter( $product_categories, array( 'count' => 0 ), 'NOT' );
	}

	return $product_categories;

}


// helpers
function get_pdf_info($product){

    $pdf = array();
    $attributes = $product->get_attributes();
    $pdf['name'] = $attributes['pdf']['value'];
    $pdf['url'] = content_url('uploads/docs/'.$pdf['name']);

    $up_dir = wp_upload_dir();
    $pdf['size'] = get_size($up_dir['basedir'].'/docs/'.$pdf['name']);

    return $pdf;
}


function get_size($file){
    $bytes = @filesize($file);
    if($bytes) {
        $s = array('b', 'Kb', 'Mb', 'Gb');
        $e = floor(log($bytes) / log(1024));
    }
    return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
}

load_theme_textdomain( 'interavtomatika', TEMPLATEPATH . '/languages' );

function ia_get_current_product_cutegory_id(){
    global $wp_query;
    return get_term_by('slug', $wp_query->query_vars['product_cat'], 'product_cat')->term_id;
}

function show_breadcrumbs($taxonomy,$before = array()){

    $id = ia_get_current_product_cutegory_id();

    $before = $before['name'] ? '<li><a href="'.$before['href'].'">'.$before['name'].'</a></li>' : '';

    $html = '<ul class="breadcrumbs"><li><a href="'.home_url().'" class="bc-home"></a></li>'.$before;

    $obj = wp_get_object_terms( $id, $taxonomy );

    if($obj) {

        $id = $obj[0]->parent;

        $tmp = '<li><span>' . qtranxf_useCurrentLanguageIfNotFoundShowAvailable( $obj[0]->name ) . '</span></li>';

    }else{

        $obj = get_term_by( 'id', $id, $taxonomy );
        $id = $obj->parent;

        $tmp = '<li><span>'. qtranxf_useCurrentLanguageIfNotFoundShowAvailable( $obj->name ) .'</span></li>';
    }

    while($obj = get_term_by('id', $id, $taxonomy )){

        $name = $obj->name;
        $href = get_term_link($id,$taxonomy);

        $tmp = '<li><a href="'.$href.'">'. qtranxf_useCurrentLanguageIfNotFoundShowAvailable( $name ) .'</a></li>'.$tmp;

        $id = $obj->parent;

    }

    echo $html.$tmp.'</ul>';
}

// add custom field in admin panel
add_action('admin_init', 'additional_general_section');
function additional_general_section() {
    add_settings_section(
        'additional_settings_section', // Section ID
        __('Additional options','interavtomatika'), // Section Title
        'additional_options_callback', // Callback
        'general' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'social_buttons', // Option ID
        __('Social buttons','interavtomatika').' ('.__('code','interavtomatika').')', // Label
        'options_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed (General Settings)
        'additional_settings_section', // Name of our section
        array( // The $args
            'social_buttons' // Should match Option ID
        )
    );

    add_settings_field( // Option 2
        'option_2', // Option ID
        'Option 2', // Label
        'options_textbox_callback', // !important - This is where the args go!
        'general', // Page it will be displayed
        'additional_settings_section', // Name of our section (General Settings)
        array( // The $args
            'option_2' // Should match Option ID
        )
    );

    register_setting('general','social_buttons');
    //register_setting('general','option_2', 'esc_attr');
}

function additional_options_callback() { // Section Callback
//    echo '<p>'._e('Social buttons','interavtomatika').'</p>';
}

function options_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<textarea id="'. $args[0] .'" name="'. $args[0] .'">' . $option . '</textarea>';
}

// products filter
function get_filter_values($category_id)
{

    if(  $ia_filter_values = wp_cache_get('ia_filter_values') ) return $ia_filter_values;

    global $wpdb;
    global $ia_filter_url_vars;

    if( $selected_filter_params_join = get_join_from_url_filter_parameters() ) {

        if( !strpos( $selected_filter_params_join, 'relship_brand' )){

            $brand_join = 'INNER JOIN wp_term_relationships as relship_brand ON (wp_posts.ID = relship_brand.object_id) INNER JOIN wp_term_taxonomy ON ( wp_term_taxonomy.term_taxonomy_id = relship_brand.term_taxonomy_id AND wp_term_taxonomy.taxonomy = "yith_product_brand" ) INNER JOIN wp_terms ON ( wp_terms.term_id = wp_term_taxonomy.term_id )';
        }else{
            $brand_join = '';
        }

        $sql = "SELECT wp_terms.name, pm.meta_value FROM " . $wpdb->prefix . "posts
            INNER JOIN ".$wpdb->prefix."postmeta as pm ON (" . $wpdb->prefix . "posts.ID = pm.post_id  AND pm.meta_key = '_product_attributes' )
            INNER JOIN ".$wpdb->prefix."postmeta as pmv ON ( " . $wpdb->prefix . "posts.ID = pmv.post_id AND pmv.meta_key = '_visibility' AND CAST(pmv.meta_value AS CHAR) IN ('visible','catalog') )
            INNER JOIN " . $wpdb->prefix . "term_relationships ON (" . $wpdb->prefix . "posts.ID = " . $wpdb->prefix . "term_relationships.object_id)
            ".$brand_join."
            " . $selected_filter_params_join . "

            WHERE 1=1  AND (
              " . $wpdb->prefix . "term_relationships.term_taxonomy_id IN (" . $category_id . ")
            ) AND " . $wpdb->prefix . "posts.post_type = 'product' AND (" . $wpdb->prefix . "posts.post_status = 'publish' OR " . $wpdb->prefix . "posts.post_status = 'private')
            GROUP BY " . $wpdb->prefix . "posts.ID ";

        $results = $wpdb->get_results($sql);
    }


    $filter_selected = collect_filter_attrs($results);
    if( $ia_filter_url_vars['brand'] ){

        $filter_selected['brand']['name'] = 'brand';
        $filter_selected['brand']['values'][key($ia_filter_url_vars['brand'])] = array();

    }elseif( $results ) {
        foreach ($results as $res) {
            $filter_selected['brand']['name'] = 'brand';
            $filter_selected['brand']['values'][$res->name] = array();
        }
    }

    $sql = $wpdb->prepare( '
        SELECT pm.meta_value FROM '.$wpdb->prefix.'posts as p
            JOIN '.$wpdb->prefix.'postmeta as pm ON (p.ID = pm.post_id  AND pm.meta_key = "_product_attributes" )
            JOIN '.$wpdb->prefix.'postmeta pmv ON ( p.ID = pmv.post_id AND pmv.meta_key = "_visibility" AND CAST(pmv.meta_value AS CHAR) IN ("visible","catalog") )
            JOIN '.$wpdb->prefix.'term_relationships as tr ON (tr.object_id = pm.post_id )
        WHERE tr.term_taxonomy_id  = %d AND p.post_type = "product" AND p.post_status = "publish"',$category_id);
    $results = $wpdb->get_results( $sql );

    $filter = collect_filter_attrs($results);

    //for sorting
    $vt_tmp['vyhodnoy_tok'] = $filter['vyhodnoy_tok'];
    unset($attributes['vyhodnoy_tok']);
    $filter =  $vt_tmp  + $filter;

    $brands = get_terms('yith_product_brand');

    $filter = array('brand'=>array()) + $filter;
    $filter['brand']['name'] = 'brand';
    $filter['brand']['values'] = array();

    foreach( $brands as $brand ){

        $filter['brand']['values'][$brand->name] = array(
            'flag' => get_field( 'flag','yith_product_brand_'.$brand->term_id ),
            'id' => $brand->term_id
        );
    }

    $filter_url_parameter = get_query_var('filter');

    $filter_url_parameter = explode('/',$filter_url_parameter);

    foreach ($filter_url_parameter as $key => $fup_group) {
        $fup_group_array = explode(';',$fup_group);
        $fup_name = array_shift($fup_group_array);
        $filter_url_parameters_array[$fup_name] = $fup_group_array;
    }

    foreach ($filter as $attrs_name => $attrs) {

        if( $attrs['values'] )
        foreach ($attrs['values'] as $attr_name => $attr) {
            
            $fup_for_foreach = $filter_url_parameters_array;

            $attr_name_translit = translitFilterParameters($attr_name, 'encode');

            $active = isset($ia_filter_url_vars[$attrs_name][$attr_name_translit]) && $ia_filter_url_vars[$attrs_name][$attr_name_translit];

            if ($active) {

                $key =  array_search( $attr_name_translit, $fup_for_foreach[$attrs_name] );
                if( $key !== false ) unset($fup_for_foreach[$attrs_name][$key]);

            } else {

                if ($attrs_name == 'brand') {

                    $fup_for_foreach[$attrs_name][0] = $attr_name_translit;

                } else {

                    $fup_for_foreach[$attrs_name][] = $attr_name_translit;

                }


            }

            if( count( $fup_for_foreach ) ){

                ksort( $fup_for_foreach, SORT_NATURAL );

                $filter_url = '';
                foreach ($fup_for_foreach as $group_name => $group_val) {

                    if( $group_val = array_filter( $group_val ) ) {

                        $filter_url .= '/' . $group_name . ';';

                        sort($group_val, SORT_NATURAL);

                        $filter_url .= implode(';', $group_val);
                    }
                }

                if( $filter_url ){

                    $filter_url = 'filter'.$filter_url;
                }


            }else{
                $filter_url = '';
            }

            $url = get_term_link(get_queried_object()->term_id,'product_cat')
                   .$filter_url;

            $filter[$attrs_name]['values'][$attr_name]['url'] = $url;
            $filter[$attrs_name]['values'][$attr_name]['active'] = $active;
            $filter[$attrs_name]['values'][$attr_name]['available'] = empty($filter_selected) || $filter_selected[$attrs_name]['values'][$attr_name] !== null;
            $filter[$attrs_name]['values'][$attr_name]['translit_name'] = translitFilterParameters( $attr_name, 'encode');
        }

        if( $filter[$attrs_name]['values'] )
        ksort( $filter[$attrs_name]['values'], SORT_NUMERIC );

    }

    wp_cache_set( 'ia_filter_values', $filter );

    return $filter;
}

function collect_filter_attrs($results){

    $filter = array();

    if($results)
    foreach($results as $res){

        $attributes = unserialize($res->meta_value);
        unset($attributes['pdf']);

        foreach($attributes as $key => $val){

            if( gettype( @array_search(  $val['value'], $filter[$key]['values'] ) ) != 'integer' ){

                $attrs_name = $val['name'];
                $attrs_val = $val['value'];
                $filter[$key]['name'] = $attrs_name;
                $filter[$key]['values'][$attrs_val] = array();
            }
        }

    }
    return $filter;
}

function translitFilterParameters($str, $dir, $term_id = false){

    if( !$term_id && !$term_id = get_queried_object()->term_id ){
        return false;
    }
    
    global $wpdb;

    if( !$filter_parameters = wp_cache_get( 'filter_translit_'.$term_id )){

        $results = $wpdb->get_results( 'SELECT * FROM `'.$wpdb->prefix.'filter_parameters_translit` WHERE `term_id` = '.$term_id );

        if( $results[0] && $filter_parameters = unserialize( $results[0]->filter_parameters ) ){

            wp_cache_set( 'filter_translit_'.$term_id, $filter_parameters );

            if(count($filter_parameters) > 1000){
                $up_res = $wpdb->update(
                    $wpdb->prefix.'filter_parameters_translit',
                    array( 'filter_parameters' => '' ),
                    array( 'term_id' => $term_id )
                );
            }
        }
    }

    if($dir == 'encode') {

        $str = qtranxf_use( 'ru', $str );

        if( $filter_parameters[$str] ){

            return $filter_parameters[$str];

        }else {

            $rus = array('~','/',' ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
            $lat = array('-','-','_', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');

            $translit = str_replace($rus, $lat, $str );

            $translit = urlencode($translit);

            $filter_parameters[$str] = $translit;

            wp_cache_set( 'filter_translit_'.$term_id, $filter_parameters );

            $filter_parameters_ser = serialize( $filter_parameters );

            $up_res = $wpdb->update(
                $wpdb->prefix.'filter_parameters_translit',
                array( 'filter_parameters' => $filter_parameters_ser ),
                array( 'term_id' => $term_id ),
                array( '%s' ),
                array( '%d' )
            );

            if(!$up_res){
                $wpdb->insert(
                    $wpdb->prefix.'filter_parameters_translit',
                    array( 'term_id' => $term_id, 'filter_parameters' => $filter_parameters_ser  )
                );
            }

            return $translit;
        }
    }

    
    if($dir == 'decode') {

        return @array_search($str,$filter_parameters);
    }
}



//add_action('init', 'addRoutes');
//function addRoutes(){
//global $wp_rewrite;
//    flush_rewrite_rules();
//}

add_filter( 'rewrite_rules_array','ia_filter_rewrite_rules' );
function ia_filter_rewrite_rules($rules){


    $newrules = array();
    $newrules['catalog/(.+?)/filter/(.+?)/outofstock/(show|hide)/page/?([0-9]{1,})/?$'] = 'index.php?product_cat=$matches[1]&filter=$matches[2]&outofstock=$matches[3]&paged=$matches[4]';
    $newrules['catalog/(.+?)/filter/(.+?)/page/?([0-9]{1,})/?$'] = 'index.php?product_cat=$matches[1]&filter=$matches[2]&paged=$matches[3]';
    $newrules['catalog/(.+?)/filter/(.+?)/page/?([0-9]{1,})/?$'] = 'index.php?product_cat=$matches[1]&filter=$matches[2]&paged=$matches[3]';
    $newrules['catalog/(.+?)/filter/(.+?)/outofstock/(show|hide)/?$'] = 'index.php?product_cat=$matches[1]&filter=$matches[2]&outofstock=$matches[3]';
    $newrules['catalog/(.+?)/filter/(.+?)/?$'] = 'index.php?product_cat=$matches[1]&filter=$matches[2]';
    $newrules['catalog/(.+?)/outofstock/(show|hide)/?$'] = 'index.php?product_cat=$matches[1]&outofstock=$matches[2]';
    $newrules['catalog/(.+?)/outofstock/(show|hide)/page/?([0-9]{1,})/?$'] = 'index.php?product_cat=$matches[1]&outofstock=$matches[2]&paged=$matches[3]';
    return $newrules + $rules;
}

add_filter( 'query_vars', 'ia_filter_query_vars' );
function ia_filter_query_vars( $query_vars )
{
    $query_vars[] = 'filter';
    $query_vars[] = 'outofstock';
    return $query_vars;
}

add_action( 'posts_join_paged', 'ia_filter_add_join' );
function ia_filter_add_join( $join ){

    return $join.get_join_from_url_filter_parameters();
}

function get_join_from_url_filter_parameters(){

    if( $join = wp_cache_get('ia_join_from_url_filter_parameters') ){
        return $join;
    }


    global $wpdb;

    global $ia_filter_url_vars;
    $ia_filter_url_vars = array();

    $join = '';

    if ($filter_vars = get_query_var('filter')) {

        $term_id = ia_get_current_product_cutegory_id();

        $filter_vars = explode('/',$filter_vars);

        $reg = array();
        $brand_join = '';
        foreach( $filter_vars as $f_var) {

            $f_var_vals = explode( ';', $f_var );
            $name = $f_var_vals[0];
            unset($f_var_vals[0]);
            $f_var_vals = array_filter($f_var_vals);



            if( $name == 'brand' ){

                $ia_filter_url_vars['brand'][$f_var_vals[1]] = true;

                $brand_join = ' INNER JOIN ' . $wpdb->prefix . 'term_relationships as relship_brand ON (' . $wpdb->prefix . 'posts.ID = relship_brand.object_id)'
                    .' INNER JOIN ' . $wpdb->prefix . 'term_taxonomy ON ( ' . $wpdb->prefix . 'term_taxonomy.term_taxonomy_id = relship_brand.term_taxonomy_id AND ' . $wpdb->prefix . 'term_taxonomy.taxonomy = "yith_product_brand" )'
                    .' INNER JOIN ' . $wpdb->prefix . 'terms ON ( ' . $wpdb->prefix . 'terms.term_id = ' . $wpdb->prefix . 'term_taxonomy.term_id AND ' . $wpdb->prefix . 'terms.name = "'.esc_sql($f_var_vals[1]).'" ) ';

            }else {

                foreach ($f_var_vals as $f_var_val) {

                    $ia_filter_url_vars[$name][$f_var_val] = true;

                    $f_var_val = translitFilterParameters($f_var_val, 'decode', $term_id);


                    if ($f_var_val)
//                        $reg[] = '(:"' . esc_sql($name) . '";[^{]*\{[^}]*:"value";s:[^}]*:"' . $f_var_val . '";\})';
                        $reg[] = '(:"' . esc_sql($name) . '";[^{]*\{[^}]*:"value";s:[^}]*((:")|(\\\\]))' . $f_var_val . '((\\\\[:[^}]*)|(";))\})';
                }
            }
        }

        if( $brand_join ) {

            $join .= $brand_join;
        }

        if( $reg ) { 

            $rlikes = implode("' AND prod_attr_postmeta.meta_value REGEXP '", $reg);
            $rlikes = " AND prod_attr_postmeta.meta_value REGEXP '".$rlikes."'";

            $join .= " INNER JOIN " . $wpdb->prefix . "postmeta as prod_attr_postmeta ON ( " . $wpdb->prefix . "posts.ID = prod_attr_postmeta.post_id AND prod_attr_postmeta.meta_key = '_product_attributes' " . $rlikes . " ) ";
        }
    }

    wp_cache_set( 'ia_join_from_url_filter_parameters', $join );

    return $join;
}


//create post from filter request
add_action( 'init', 'ia_create_post_type' );
function ia_create_post_type() {
    register_post_type( 'ia_filter_page',

        array(
            'label'               => __( 'Filter products page', 'interavtomatika' ),
            'labels'              =>  array(
                                            'name' => __( 'Filter products page', 'interavtomatika' ),
                                            'singular_name' => __( 'Filter products', 'interavtomatika' )
                                        ),
            'taxonomies'          => array( 'filter_page' ),
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
        )


    );
}

function ia_add_filter_page($title){


    $uri_hash = ia_get_hash_uri();

    if(!ia_get_filter_page_paremeters($uri_hash)) {

        $post = array(
            'comment_status' => 'closed', //'closed' - комментирование закрыто.
            'ping_status' => 'closed', //'closed' - отключает pingbacks или trackbacks
            'post_category' => array(2065), //Добавление ID категорий.
            'post_status' => 'private', //Статус для нового поста.
            'post_title' => $title, //Название вашего поста.
            'post_type' => 'post', //Тип поста: статья, страница, ссылка, пункт меню, иной тип.
        );

    }
}

//get filter page parameters
function ia_get_filter_page_paremeters($uri_hash = false){

    global $wpdb;

    if(!$uri_hash){
        $uri_hash = ia_get_hash_uri();
    }

    if( $cache = wp_cache_get('ia_filter_urlid_'.$uri_hash) ){

        return $cache;
    }

    $res = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'posts
                        INNER JOIN '.$wpdb->prefix.'postmeta ON ( '.$wpdb->prefix.'posts.ID = '.$wpdb->prefix.'postmeta.post_id )
                        WHERE  '.$wpdb->prefix.'postmeta.meta_key = "ia_filter_page_urlid"
                        AND '.$wpdb->prefix.'postmeta.meta_value = "'.$uri_hash.'"
                        AND '.$wpdb->prefix.'posts.post_type = "post" ');

    $res = $res[0];

    wp_cache_set( 'ia_filter_urlid_'.$uri_hash, $res );

    return $res;
}

function ia_get_hash_uri(){
    
    $request_hash = get_term_by('id',ia_get_current_product_cutegory_id(), 'product_cat')->slug
                    .get_query_var('filter');

    return 'sha256_'.hash('sha256',$request_hash);
}


function ia_get_title_from_filter_attributes( $filter_items ){

    global $ia_filter_url_vars;

    $enabled_langs = get_option('qtranslate_enabled_languages');

    if( $filter_page_paremeters = ia_get_filter_page_paremeters() ) {

        $title = $filter_page_paremeters->post_title;

    }else{

        $title = '';
        foreach ( $enabled_langs as $lang ) {

            $title .= '[:'.$lang.']';

            $title .= qtranxf_use( $lang, get_term_by('id', ia_get_current_product_cutegory_id(), 'product_cat')->name );

            if( $filter_items )
            foreach ($filter_items as $items_name => $items) {
                if( $items['values'] )
                foreach ($items['values'] as $item_name => $value) {
                    if (isset($ia_filter_url_vars[$items_name][$value['translit_name']])) {
                        $title .= ', ' . qtranxf_use( $lang,$item_name );
                    }
                }
            }
        }
        $title .= '[:]';

    }

    return $title;
}

// out of stock button
add_filter('option_woocommerce_hide_out_of_stock_items', function($opt){

        $opt = get_query_var('outofstock');

        if( $opt == 'hide' ){
            return 'yes';
        }elseif( $opt == 'show' ){
            return 'no';
        }else{
            return $opt;
        }

    }
);

function outofstock_get_permalink($op){
    $permalink = get_term_link(ia_get_current_product_cutegory_id(), 'product_cat');
    $permalink = substr($permalink, -1) == '/' ? $permalink : $permalink.'/';

    $filter = get_query_var('filter');
    $filter = $filter ? 'filter/'.$filter.'/' : '';

    if( $op == 'show' ){
        return $permalink.$filter.'outofstock/show/';
    }elseif( $op == 'hide' ){
        return $permalink.$filter.'outofstock/hide/';
    }else{
        return $permalink.$filter;
    }
}

// for php < 5.5

if(!function_exists("array_column"))
{

    function array_column($array,$column_name)
    {

        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

    }

}


// add .html to end
//function true_add_html_on_pages() {
//    // при работе с $wp_rewrite, как и с $wpdb, в первую очередь глобально определяем класс
//    global $wp_rewrite;
//
//    // метод $wp_rewrite->get_page_permastruct() возвращает нам структуру URL страниц, по умолчанию %pagename%
//    // функцией strpos() мы делаем проверку, не присутствует ли уже расширение .html (%pagename%.html)
//    if ( !strpos($wp_rewrite->get_page_permastruct(), '.html')){
//        // если не присутствует, то добавляем его
//        $wp_rewrite->page_structure = $wp_rewrite->page_structure . '.html';
//        // метод flush_rules() применяет сделанные изменения
//        $wp_rewrite->flush_rules();
//    }
//}
//
//// вешаем на хук init
//add_action('init', 'true_add_html_on_pages', -1);
//
//// вроде бы всё ок, вот только WordPress добавляет слэши на конце и у нас получается %pagename%.html/ - сейчас мы это исправим
//function true_remove_slash_on_pages( $url, $post_type){
//    global $wp_rewrite;
//
//    // $wp_rewrite->using_permalinks() возвращает true, если постоянные ссылки используются на сайте
//    // $wp_rewrite->use_trailing_slashes равен true, если слэши добавляются на конце URL
//    // нам нужно удалить слэши только с страниц, поэтому $post_type должен быть равен page
//    if ($wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes==true && $post_type == 'page'){
//        // удаляем слэш
//        return untrailingslashit( $url );
//    } else {
//        // возвращаем всё как есть
//        return $url;
//    }
//}
//
//// вешаем на фильтр user_trailingslashit
//add_filter('user_trailingslashit', 'true_remove_slash_on_pages',70,2);