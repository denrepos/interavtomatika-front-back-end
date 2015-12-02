<?php

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

// include css and js
function interavtomatika_scripts() {
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

// woocommerce settings

add_filter('woocommerce_product_subcategories_hide_empty',function(){return true;});

// woocommerce functions


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
