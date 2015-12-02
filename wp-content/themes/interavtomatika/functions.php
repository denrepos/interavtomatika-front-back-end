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

function getSize($file){
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
