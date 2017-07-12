<?php
//prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
//header( "Content-type: text/css; charset: UTF-8" );

global $postfront;
$btn1_font_size = ($postfront -> get_option("_feature_btn_fontsize") == '' ? 12 : $postfront -> get_option("_feature_btn_fontsize"));
$btn1_color = ($postfront -> get_option("_feature_btn_color") == '' ? '#fffff' : $postfront -> get_option("_feature_btn_color"));
$btn1_bgcolor = ($postfront -> get_option("_feature_btn_bgcolor") == '' ? 'ffccc' : $postfront -> get_option("_feature_btn_bgcolor"));

$btn2_font_size = ($postfront -> get_option("_publish_btn_fontsize") == '' ? 12 : $postfront -> get_option("_publish_btn_fontsize"));
$btn2_color = ($postfront -> get_option("_publish_btn_color") == '' ? '#fffff' : $postfront -> get_option("_publish_btn_color"));
$btn2_bgcolor = ($postfront -> get_option("_publish_btn_bgcolor") == '' ? 'ffccc' : $postfront -> get_option("_publish_btn_bgcolor"));

$form_bg = ($postfront -> get_option("_form_background_color") == '' ? '#ccc' : $postfront -> get_option("_form_background_color"));?>


#select-button {
		font-size: <?php echo $btn1_font_size; ?>px;
		color: <?php echo $btn1_color; ?>;
		background-color: <?php echo $btn1_bgcolor; ?>;
	}
	#publish-button {
		font-size: <?php echo $btn2_font_size; ?>px !important;
		color: <?php echo $btn2_color; ?> !important;
		background-color: <?php echo $btn2_bgcolor; ?> !important;	
	}
	#form-main-area {
		background-color: <?php echo $form_bg; ?>;
	}