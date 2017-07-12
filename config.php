<?php
/*
 * this file contains pluing meta information and then shared
 * between pluging and admin classes
 * 
 * [1]
 * TODO: change this meta as plugin needs
 */
 
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$plugin_meta		= array('name'			=> 'Post Front',
							'shortname'		=> 'nm_postfront',
							'path'			=> plugin_dir_path(__FILE__),
							'url'			=> plugin_dir_url(__FILE__),
							'db_version'	=> 1.0,
							'logo'			=> plugin_dir_url(__FILE__) . 'images/logo.png',
							'menu_position'	=> 95);

/*
 * TODO: change the function name
*/
function postfront_get_plugin_meta(){
	
	global $plugin_meta;
	
	//print_r($plugin_meta);
	
	return $plugin_meta;
}


function postfront_pa($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

/**
* this function should be MOVED from HERE
*/
function postfront_render_term_tree($termid, $taxonomy){

	$single_term = get_term($termid, $taxonomy);
	//postfront_pa($single_term);
	echo '<li>';
	echo '<input type="checkbox" name="post_taxonomy['.$taxonomy.'][]" id="cat_'.$termid.'" value="'.$termid.'">';
	echo '<label for="cat_'.$termid.'">'.$single_term->name.'</label>';

	$childrens = get_term_children($termid, $taxonomy);
	if($childrens){

		//postfront_pa($childrens);
		echo '<ul class="tax-styles">';
		foreach ($childrens as $term_child) {

			postfront_render_term_tree($term_child, $taxonomy);					
		}
	echo "</ul>";	
	}
	

	'</li>';

	
}