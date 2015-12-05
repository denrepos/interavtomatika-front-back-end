<?php

/*
Plugin Name: Advanced functions for "All import" and "Woocommerce" plagins
Description: 1)Create product atributes from unknown fields in import file 2)Translate fields in import file   
Version: 1.0
Author: den
*/

 
  
// PC::debug($wpdb->get_results('select * FROM wp_allimport_translate_transients'),'sql');
	// PC::debug($wpdb->last_error,'er');	

  

// Create settings page

// ajax callback

add_action( 'wp_ajax_allimport_translation_correction', 'allimport_translation_correction_callback' );

function allimport_translation_correction_callback() {
	global $wpdb; // this is how you get access to the database

	$whatever = intval( $_POST['whatever'] );

	$whatever += 10;

		echo '$whatever';

	wp_die(); // this is required to terminate immediately and return a proper response
}


//add item to "all import" menu in admin panel	
	
add_action('admin_menu', 'register_my_custom_submenu_page',20);
 
function register_my_custom_submenu_page() {

    add_submenu_page( 'pmxi-admin-home', 'Translate addon', 'Translate addon', 'manage_options', 'allimport-translate-addon', 'unknown_fields_addon_callback' ); 
    add_submenu_page( 'pmxi-admin-home', 'WP All Import', 'Translate addon', 'manage_options', 'allimport-translate-addon', 'unknown_fields_addon_callback' ); 
}  


// fire when click on item in menu
function unknown_fields_addon_callback() {
	
	require_once __DIR__.'/options.php';
	
}

// create "All import" addon
include "rapid-addon.php";

$addon = new RapidAddon('Add unknown fields', 'unknown-fields');

$addon->add_field('from', 'Add unknown fields from the document to product atributes starting with: (including the specified number)', 'text');//Добавить неизвестные поля документа в атрибуты товара начиная со столбца: (по порядку слева включая указанный номер)
//$addon->add_field('translate_categories', 'translate to ukranian', 'checkbox');

// $addon->add_field('xpath', 'xpath <br/> default - ./*[not(self::category or self::product or self::brand or self::articles or self::pdf or self::photo or self::description)]/text()[normalize-space()]', 'text');

$addon->set_import_function('AllImportiUnknownFields::main');

session_start();

foreach(explode(',',get_option('all_import_fields_to_translation')) as $field){
	AllImportiUnknownFields::$columns_to_translate[] = trim($field); 
}

$addon->run();


class AllImportiUnknownFields{
	
	public static $columns_to_translate = array();
	
	public static function main($post_id,$data,$options){

		global $wpdb;
		global $addon;
		
		add_filter('pmxi_saved_post',function($pid,$rootNode) use ($post_id,$data,$addon){

			global $wpdb;
            $add_unknown_fields = true;
			$unknown_fields_from = $data['from']; 
			$translate_categories = true;  //$data['translate_categories'];

			if($post_id == $pid && $unknown_fields_from){


                //add unknown fields to product attributes
                if($add_unknown_fields) {
                    $attributes = get_post_meta($pid, '_product_attributes');
                    $attributes = $attributes[0];

                    $i = 1;
                    foreach ($rootNode[0] as $key => $node) {

                        $value = (string)$node;

                        if ($unknown_fields_from > $i++) continue;
                        if (!$value) continue;

                        $attributes[$key] = array(
                            'name' => self::translate(trim($_SESSION['allimport_translit_fields'][$key])),
                            'value' => $value   //translate
                        );
                    }

                    if ($attributes) update_post_meta($pid, '_product_attributes', $attributes);
                }

				//translate categories
				if($translate_categories){
					
					$query = 'SELECT wt.term_id,wt.name,wtt.parent FROM '.$wpdb->prefix.'term_relationships wtr
					  JOIN '.$wpdb->prefix.'term_taxonomy wtt ON(wtr.term_taxonomy_id = wtt.term_taxonomy_id AND wtt.taxonomy = "product_cat")
					  JOIN '.$wpdb->prefix.'terms wt ON(wt.term_id = wtt.term_id)
					  WHERE object_id = '.$post_id;

					$wpdb_res = $wpdb->get_results($query); 

					self::ai_addon_update_terms($wpdb_res);   	
				}	
			}
		
		},10,2);	
		


	}


	public static function translate($text,$field_name = true,$dir = 'ru-uk'){

		global $wpdb;

		if(!$field_name || !$text){ 
			return $text;
		}
		if($field_name && !in_array($field_name,self::$columns_to_translate)){ 
			return $text;
		} 

		$yandex_error = PMXI_Plugin::$session->get('yandex_error');
		if($yandex_error > 3) return $text;
	
		global $addon;
		$source_text = $text;
  	
		//if lang mark for yandex and qtranslate is different
		$tags_to = array('ru-uk' => 'ua');

		$tag_from = isset($tags_from[$dir]) ? '[:'.$tags_from[$dir].']' : '[:'.substr($dir,0,2).']';
		$tag_to = isset($tags_to[$dir]) ? '[:'.$tags_to[$dir].']' : '[:'.substr($dir,3).']';
		
		if(strrpos($text,$tag_to) !== false){ 
			return $text;
		}
		
		$transl_from = strrpos($text,$tag_from);
		
		if($transl_from !== false){ 
			
			$translate = substr($text,$transl_from + strlen($tag_to));
			$transl_to = strrpos($translate,'[:');
			$translate = $transl_to ? substr($translate,0,$transl_to) : $translate; 
			
		}elseif(strrpos($text,'[:]') === false){
			$translate = $text;
			$text = $tag_from.$translate.'[:]'; 
		}else{
			return $text;
		}
		
		$transient = $wpdb->get_row('SELECT `to` FROM `'.$wpdb->prefix.'allimport_translate_transients` WHERE `direction` = "'.$dir.'" AND `from` = "'.esc_sql( $translate ).'"');

        $yandex = array();
		if($transient->to){
			
			$yandex_translate = $transient->to;
			
		}else{
		
			$yandex = json_decode(
				file_get_contents(
					'https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20151121T123602Z.c647c65268af9cdb.8923072f049a821f33b0ff4fa11ef99285963325&text='
						.urlencode($translate)
						.'&lang='.$dir,
					false,
					stream_context_create(array(
						'http' => array('ignore_errors' => true)
					))
				)
			);
			$yandex_translate = $yandex->text[0];

			$wpdb->insert(
				'wp_allimport_translate_transients',
				array( 'direction' => $dir, 'from' => esc_sql( $translate ), 'to' =>  esc_sql( $yandex_translate ) )
			);
			
		}
				
		
		if($yandex){
			$yandex_code = $yandex->code;
			if($yandex_code == '404') PMXI_Plugin::$session->set( 'yandex_error',  ++$yandex_error );
		}
		
		if($yandex_translate){
			$return = $tag_to.$yandex_translate.$text;
		}else{
			$return = $source_text;
		}
		
		return  $return;
	} 


	public static function ai_addon_update_terms($wpdb_res){
	
	
	 
	global $wpdb;

		foreach($wpdb_res as $row){

			if($created_category = PMXI_Plugin::$session->get('created_category')){
				
				if(in_array( $row->term_id, $created_category )) continue;
				
				$created_category[] = $row->term_id;
				PMXI_Plugin::$session->set( 'created_category',  $created_category );
				 
			}else{
				
				PMXI_Plugin::$session->set( 'created_category',  array($row->term_id) );
				
			}
		
			$wpdb->update(''.$wpdb->prefix.'terms',array('name'=>$row->name),array('term_id'=>$row->term_id)); //translate
		
			$query = 'SELECT wt.term_id, wt.name, wtt.parent  FROM '.$wpdb->prefix.'term_taxonomy wtt 
			  JOIN '.$wpdb->prefix.'terms wt ON(wt.term_id = wtt.term_id)
			  WHERE wtt.term_taxonomy_id = '.$row->parent.' AND wtt.taxonomy = "product_cat"';
 
			$row_res = $wpdb->get_results($query);  
			
			self::ai_addon_update_terms($row_res);
		}		
	}
}
