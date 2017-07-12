<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$meatGeneral = array('post-type' => array(	'label'		=> __('Post Type Name/Slug', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_post_type',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('Provide any post type name', 'nm-postfront')
											),

					'rich-editor' => array(	'label'		=> __('Enable Rich Editor', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_rich_editor',
											'type'		=> 'checkbox',
											'options'	=> array(
															'yes'	=> __('Enable', 'nm-postfront'),
														),
											'default'	=> '',
											'help'		=> __('It enables tinyMCE editor on frontend post form when checked', 'nm-postfront')
											),

					'media-upload' => array('label'	=> __('Enable Media Upload', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_media_upload',
											'type'		=> 'checkbox',
											'options'	=> array(
															'yes'	=> __('Enable', 'nm-postfront'),
														),
											'default'	=> '',
											'help'		=> __('Toggle media upload button on frontend post form', 'nm-postfront')
											),

					'featured-image' => array('label'	=> __('Enable Featured Image', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_featured_image',
											'type'		=> 'checkbox',
											'options'	=> array(
															'yes'	=> __('Enable', 'nm-postfront'),
														),
											'default'	=> '',
											'help'		=> __('Toggle featured image on frontend post form', 'nm-postfront')
											),

					'save-action' => array('label'		=> __('Action on Save', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_save_action',
											'type'		=> 'select',
											'options'	=> array(
															'publish'	=> __('Publish', 'nm-postfront'),
															'private'	=> __('Private', 'nm-postfront'),
														),										
											'help'		=> __('Select action when post is saved', 'nm-postfront')
											),

					'show-taxonomy' => array('label'	=> __('Show Taxonomy', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_show_taxonomy',
											'type'		=> 'checkbox',
											'options'	=> array(
															'yes'	=> __('Show', 'nm-postfront'),
														),
											'default'	=> '',
											'help'		=> __('It only shows taxonomy related to post type', 'nm-postfront')
											),

					'exclude-taxonomy' => array('label'	=> __('Exclude Taxonomy', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_exclude_taxonomy',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('Provide names of taxonomies you want to exclude seperated by commas', 'nm-postfront')
											),

					'exclude-term' => array('label'	=> __('Exclude Term', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_exclude_term',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('Provide term IDs you want to exclude from taxonomies list seperated by commas', 'nm-postfront')
											),
					
);

$meatStyles = array('heading-for-feature' => array(	'label'		=> __('Featured Image Button', 'nm-postfront'),
											'type'		=> 'heading',
											'default'	=> 'Select options for Featured Image Button',
											),

					'feature-btn-label' => array(	'label'		=> __('Label', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_feature_btn_label',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('Provide label for featured image button', 'nm-postfront')
											),

					'feature-btn-fontsize' => array(	'label'		=> __('Font Size', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_feature_btn_fontsize',
											'type'		=> 'select',
											'default'	=> __('Select option', 'nm-postfront'),
											'options'	=> array(
															'14'	=> __('14px', 'nm-postfront'),
															'16'	=> __('16px', 'nm-postfront'),
															'18'	=> __('18px', 'nm-postfront'),
															'20'	=> __('20px', 'nm-postfront'),
															'22'	=> __('22px', 'nm-postfront'),
															'24'	=> __('24px', 'nm-postfront'),
															'26'	=> __('26px', 'nm-postfront'),
														),
											'help'		=> __('Choose font size for button label', 'nm-postfront')
											),

					'feature-btn-color' => array(	'label'		=> __('Font Color', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_feature_btn_color',
											'type'		=> 'color',
											'default'	=> '#616161',
											'help'		=> __('Choose font color for featured image button label', 'nm-postfront')
											),

					'feature-btn-bgcolor' => array(	'label'		=> __('Background Color', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_feature_btn_bgcolor',
											'type'		=> 'color',
											'default'	=> '#f7f7f7',
											'help'		=> __('Choose font background color for featured image button label', 'nm-postfront')
											),

					'heading-for-publish' => array(	'label'		=> __('Publish Button', 'nm-postfront'),
											'type'		=> 'heading',
											'default'	=> 'Select options for Publish Button',
											),

					'publish-btn-label' => array(	'label'		=> __('Label', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_publish_btn_label',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('Provide label for post publish button', 'nm-postfront')
											),

					'publish-btn-fontsize' => array(	'label'		=> __('Font Size', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_publish_btn_fontsize',
											'type'		=> 'select',
											'default'	=> __('Select option', 'nm-postfront'),
											'options'	=> array(
															'14'	=> __('14px', 'nm-postfront'),
															'16'	=> __('16px', 'nm-postfront'),
															'18'	=> __('18px', 'nm-postfront'),
															'20'	=> __('20px', 'nm-postfront'),
															'22'	=> __('22px', 'nm-postfront'),
															'24'	=> __('24px', 'nm-postfront'),
															'26'	=> __('26px', 'nm-postfront'),
														),
											'help'		=> __('Choose publish button font size', 'nm-postfront')
											),

					'publish-btn-color' => array(	'label'		=> __('Font Color', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_publish_btn_color',
											'type'		=> 'color',
											'default'	=> '#FFF',
											'help'		=> __('Choose label color for publish button', 'nm-postfront')
											),

					'publish-btn-bgcolor' => array(	'label'		=> __('Background Color', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_publish_btn_bgcolor',
											'type'		=> 'color',
											'default'	=> '#1e8cbe',
											'help'		=> __('Choose background color for publish button', 'nm-postfront')
											),

					'other-settings' => array(	'label'		=> __('Other Settings', 'nm-postfront'),
											'type'		=> 'heading',
											'default'	=> 'Select options for Publish Button',
											),

					'show-icons' => array(	'label'		=> __('Show icons with buttons', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_show_icons',
											'type'		=> 'checkbox',
											'options'	=> array(
															'yes'	=> __('Enable', 'nm-postfront'),
														),
											'default'	=> '',
											'help'		=> __('Enable to show icons with buttons. (Reduce server load: leave uncheck)', 'nm-postfront')
											),

					'form-background-color' => array(	'label'		=> __('Form background color', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_form_background_color',
											'type'		=> 'color',
											'default'	=> '#F1F1F1',
											'help'		=> __('Choose background color for main wrapper', 'nm-postfront')
											),
					
					'custom-styles' => array(	'label'		=> __('Custom Styles', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_custom_styles',
											'type'		=> 'textarea',
											'default'	=> '',
											'help'		=> __('Edit styles for frontend editor, it will be pasted above the frontend post form', 'nm-postfront')
											),

					

);


$alertMessages = array('success-message' => array(	'label'		=> __('Success Message', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_success_message',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('This message will show when post will be saved successfully', 'nm-postfront')
											),
						'error-message' => array(	'label'		=> __('Error Message', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_error_message',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('This message will show when there will be any error while saving', 'nm-postfront')
											),
						'wait-message' => array(	'label'		=> __('Wait Message', 'nm-postfront'),
											'desc'		=> __('', 'nm-postfront'),
											'id'		=> $this->plugin_meta['shortname'].'_wait_message',
											'type'		=> 'text',
											'default'	=> '',
											'help'		=> __('This message will show while form is being saved', 'nm-postfront')
											),

);

$this -> the_options = array('general-settings'	=> array(	'name'		=> __('Basic Setting', 'nm-postfront'),
															'type'	=> 'tab',
															'desc'	=> __('Set options as per your need', 'nm-postfront'),
															'meat'	=> $meatGeneral,
														
														),
							'frontend-styles'	=> array(	'name'		=> __('Layout Style', 'nm-postfront'),
															'type'	=> 'tab',
															'desc'	=> __('Set options as per your need', 'nm-postfront'),
															'meat'	=> $meatStyles,
														
														),
							'alert-messages'	=> array(	'name'		=> __('Alert Messages', 'nm-postfront'),
															'type'	=> 'tab',
															'desc'	=> __('Set options as per your need', 'nm-postfront'),
															'meat'	=> $alertMessages,
														
														),
		
						
);

//print_r($repo_options);