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

    if ( ! apply_filters( 'woocommerce_product_subcategories_hide_empty', false ) ) {
        $product_categories = wp_list_filter( $product_categories, array( 'count' => 0 ), 'NOT' );
    }

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



function show_breadcrumbs($id,$taxonomy,$before = array()){

    $before = $before['name'] ? '<li><a href="'.$before['href'].'">'.$before['name'].'</a></li>' : '';

    $html = '<ul class="breadcrumbs"><li><a href="'.home_url().'" class="bc-home"></a></li>'.$before;

    $obj = wp_get_object_terms( $id, $taxonomy );

    if($obj) {

        $id = $obj[0]->parent;

        $tmp = '<li><span>' . $obj[0]->name . '</span></li>';

    }else{

        $obj = get_term_by( 'id', $id, $taxonomy );
        $id = $obj->parent;

        $tmp = '<li><span>'.$obj->name.'</span></li>';
    }

    while($obj = get_term_by('id', $id, $taxonomy )){

        $name = $obj->name;
        $href = get_term_link($id,$taxonomy);

        $tmp = '<li><a href="'.$href.'">'.$name.'</a></li>'.$tmp;

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

    global $wpdb;
    
    $sql = $wpdb->prepare( 'SELECT * FROM `'.$wpdb->prefix.'postmeta` as pm
        JOIN '.$wpdb->prefix.'term_relationships as tr ON (tr.object_id = pm.post_id )
        JOIN '.$wpdb->prefix.'posts as p ON (p.ID = pm.post_id AND p.post_type = "product" AND p.post_status = "publish" )
        WHERE tr.term_taxonomy_id  = %d AND pm.meta_key = "_product_attributes"',$category_id);
    $results = $wpdb->get_results( $sql );

    $filter = array();
    foreach($results as $res){

        $attributes = unserialize($res->meta_value);
        unset($attributes['pdf']);

        foreach($attributes as $key => $val){

            if( gettype( @array_search(  $val['value'], $filter[$key]['values'] ) ) != 'integer' ){

                $filter[$key]['name'] = $val['name'];
                $filter[$key]['values'][] = $val['value'];
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

        if( $filter_parameters[$str] ){

            return $filter_parameters[$str];

        }else {

            $rus = array('/',' ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
            $lat = array('-','_', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');

            $translit = str_replace($rus, $lat, $str);

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


add_action('init', 'addRoutes');

function addRoutes(){
global $wp_rewrite;
//    add_rewrite_tag('%filter%', '.*');
    flush_rewrite_rules();
//    PC::debug($wp_rewrite);
}

add_filter( 'rewrite_rules_array','ia_filter_rewrite_rules' );
function ia_filter_rewrite_rules($rules){

    $newrules = array();
    $newrules['catalog/(.+?)/filter/(.+?)/page/?([0-9]{1,})/?$'] = 'index.php?product_cat=$matches[1]&filter=$matches[2]&paged=$matches[3]';
    $newrules['catalog/(.+?)/filter/(.+?)/?$'] = 'index.php?product_cat=$matches[1]&filter=$matches[2]';
    return $newrules + $rules;
}

add_filter( 'query_vars', 'ia_filter_query_vars' );
function ia_filter_query_vars( $query_vars )
{
    $query_vars[] = 'filter';
    return $query_vars;
}
//
//add_action( 'init', 'process_products_filter' );
//function process_products_filter() {
//    PC::debug(get_query_var( 'filter' ));
//}


add_action( 'posts_join_paged', 'ia_filter_add_join' );
function ia_filter_add_join($join)
{

    global $wp_query;
    global $wpdb;

    if ($filter_vars = get_query_var('filter')) {

        $term_id = get_term_by('slug', $wp_query->query_vars['product_cat'], 'product_cat')->term_id;

        $filter_vars = explode('/',$filter_vars);

        $reg = array();
        foreach( $filter_vars as $f_var) {

            $f_var_vals = explode( ';', $f_var );
            $name = $f_var_vals[0];
            unset($f_var_vals[0]);

            foreach( $f_var_vals as $f_var_val ) {

                $f_var_val = translitFilterParameters( $f_var_val, 'decode', $term_id);

                if( $f_var_val )
                    $reg[] = '(:"' . esc_sql($name) . '";[^{]*\{[^}]*:"value";s:[^}]*:"[^}]*' . $f_var_val . '[^}]*";\})';
            }
        }

        if($reg) {

            $rlikes = implode('|', $reg);

            return $join . " INNER JOIN " . $wpdb->prefix . "postmeta as prod_attr_postmeta ON ( " . $wpdb->prefix . "posts.ID = prod_attr_postmeta.post_id AND prod_attr_postmeta.meta_key = '_product_attributes' AND prod_attr_postmeta.meta_value REGEXP '" . $rlikes . "' )";
        }
    }

    return $join;
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