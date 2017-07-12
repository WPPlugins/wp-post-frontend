<?php
/*
 * this is main plugin class
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/* ======= the model main class =========== */
if(!class_exists('NM_Framwork_V1_PostFront')){
	$_framework = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'nm-framework.php';
	if( file_exists($_framework))
		include_once($_framework);
	else
		die('Reen, Reen, BUMP! not found '.$_framework);
}


/*
 * [1]
 * TODO: change the class name of your plugin
 */
class NM_PLUGIN_PostFront extends NM_Framwork_V1_PostFront{

	static $tbl_list = 'nm_lists';
	var $post_files;
	/*
	 * plugin constructur
	 */
	function __construct(){
		
		//setting plugin meta saved in config.php
		$this -> plugin_meta = postfront_get_plugin_meta();

		//getting saved settings
		$this -> plugin_settings = array_map( 'esc_attr', get_option($this->plugin_meta['shortname'].'_settings') );
		
		// file upload dir name
		$this -> post_files = 'post_files';
		
		/*
		 * [2]
		 * TODO: update scripts array for SHIPPED scripts
		 * only use handlers
		 */
		//setting shipped scripts
		$this -> wp_shipped_scripts = array('jquery');
		
		
		/*
		 * [4]
		* TODO: localized array that will be used in JS files
		* Localized object will always be your pluginshortname_vars
		* e.g: pluginshortname_vars.ajaxurl
		*/
		$this -> localized_vars = array('ajaxurl' => admin_url( 'admin-ajax.php' ),
				'plugin_url' 		=> $this->plugin_meta['url'],
				'settings'			=> $this -> plugin_settings,
				'file_upload_path_thumb' => $this -> get_file_dir_url ( true ),
				'file_upload_path' => $this -> get_file_dir_url (),
				'runtime'			=> $this->get_runtime(),);
		
		
		/*
		 * [5]
		 * TODO: this array will grow as plugin grow
		 * all functions which need to be called back MUST be in this array
		 * setting callbacks
		 */
		//following array are functions name and ajax callback handlers
		$this -> ajax_callbacks = array('save_settings' 	=> false,		//do not change this action, is for admin
										'load_post_form' 	=> false,
										'save_post' 		=> false,
										'upload_file' 		=> false,);
		
		/*
		 * plugin localization being initiated here
		 */
		add_action('init', array($this, 'wpp_textdomain'));
		
		
		/*
		 * plugin main shortcode if needed
		 */
		add_shortcode('nm-post-front', array($this , 'render_shortcode_template'));

		
		/*
		 * registering callbacks
		*/
		$this -> do_callbacks();
	}
	
	
	
	/*
	 * =============== NOW do your JOB ===========================
	 * 
	 */
	

	 function load_post_form(){
	 	
		$this -> load_template('post-frontend-form.php');
		die(0);
	 }

	 // i18n and l10n support here
	// plugin localization
	function wpp_textdomain() {
		$locale_dir = $this -> plugin_meta['path'] . '/locale/';
		load_plugin_textdomain('nm-postfront', false, $locale_dir);
	}
	
	function save_post(){

		global $current_user;
		get_currentuserinfo();
		
		extract($_REQUEST);
		//print_r($_REQUEST); exit;
		$post_contents = ( isset($_POST['post_description']) ? $_POST['post_description'] : $_POST['postcontents'] );
		
		$allowed_html = array (
				'a' => array (
						'href' => array (),
						'title' => array () 
				),
				'br' => array (),
				'h1' => array (),
				'h2' => array (),
				'h3' => array (),
				'h4' => array (),
				'h5' => array (),
				'h6' => array (),
				'em' => array (),
				'strong' => array (),
				'p' => array (),
				'ul' => array (),
				'li' => array (),
				'img' => array (
						'src' => array()
				),
				);
		
		
		$the_post = array(
				'post_title' => sanitize_text_field($post_title),
				'post_content' => wp_kses ( $post_contents, $allowed_html ),
				'post_status' => $action_save = ($this -> get_option("_save_action")) ? $this -> get_option("_save_action") : 'private',	// --connect with action --
				'post_type'		=> $this -> get_option("_post_type"), // --connect with action--
				'post_author' => $current_user -> ID,
				'comment_status'	=> 'closed',
				'ping_status'	=> 'closed'
		);
		
		
		//print_r($the_post); exit;
		
		// Insert the post into the database
		$the_post_id = wp_insert_post( $the_post );
		
		foreach ($post_taxonomy as $taxonomy => $terms){

			//converting cates IDs into INTs using intval as per required by wp_set_post_terms function
			//handling taxonomies
			$terms = array_map('intval', $terms);
			wp_set_object_terms( $the_post_id , $terms, $taxonomy);
		}
		 
		
		//adding post meta
		//update_post_meta($the_post_id, 'post_infourl', $post_infourl);
		
		
		// setting the featured image
		$image_base_url = $this -> get_file_dir_url();
		if($featured_image_uploaded){
			
			//echo 'uploaded file '.$this -> uploadedFileName;
			$filename = sanitize_file_name( $featured_image_uploaded );
			$featured_image_url = $image_base_url . $filename;
			$featured_image_url_path = $this -> get_file_dir_path() . $filename;
			$wp_filetype = wp_check_filetype(basename( $featured_image_url ), null );
			
			$attachment = array(
					'guid' => $featured_image_url,
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => basename($featured_image_url),
					'post_content' => '',
					'post_status' => 'inherit'
			);
	
			$attach_id = wp_insert_attachment($attachment, $featured_image_url, $the_post_id);
			
			wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata($attach_id, $featured_image_url_path ));
			
			update_post_meta( $the_post_id, '_thumbnail_id', $attach_id );
		
		}
		
		//print_r( $resp );

		die(0);
	}



	/*
	 * saving admin setting in wp option data table
	 */
	function save_settings(){
	
		if( ! current_user_can('administrator') ) {
			
			_e('Sorry, you cannot update options', 'nm-postfront');
			die(0);
		}
		
		//postfront_pa($_POST);
		check_admin_referer( 'postfront-nonce');
		
		
		$save_settings = array('nm_postfront_post_type', 'nm_postfront_rich_editor', 'nm_postfront_media_upload',
								'nm_postfront_featured_image','nm_postfront_save_action','nm_postfront_show_taxonomy',
								'nm_postfront_exclude_taxonomy','nm_postfront_exclude_term','nm_postfront_feature_btn_label',
								'nm_postfront_feature_btn_fontsize','nm_postfront_feature_btn_color','nm_postfront_feature_btn_bgcolor',
								'nm_postfront_publish_btn_label','nm_postfront_publish_btn_label','nm_postfront_publish_btn_fontsize',
								'nm_postfront_publish_btn_color','nm_postfront_publish_btn_bgcolor','nm_postfront_show_icons',
								'nm_postfront_form_background_color','nm_postfront_custom_styles','nm_postfront_success_message',
								'nm_postfront_error_message','nm_postfront_wait_message');
		$settings_array = '';
		// sanitizing admin settings
		foreach($_POST as $key => $val) {
			if( in_array($key, $save_settings) ) {
				
				$settings_array[$key] = sanitize_text_field( $val );
			}
		}
		
		//postfront_pa($settings_array); exit;
		
		update_option($this->plugin_meta['shortname'].'_settings', $settings_array);
		_e('All options are updated', 'nm-postfront');
		die(0);
	}


	/*
	 * rendering template against shortcode
	*/
	function render_shortcode_template($atts){

		extract(shortcode_atts(array(), $atts));
	
		if($this -> get_option("_show_icons") == 'yes'){
			wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
		}
		
		// rendering js
		wp_enqueue_script('postfront-js', $this->plugin_meta['url'].'js/script.js',
							array('jquery', 'plupload','plupload-all'), true);
		wp_localize_script('postfront-js', $this->plugin_meta['shortname'].'_vars', $this->localized_vars);
		
		wp_enqueue_style($this->plugin_meta['shortname'].'-styles', $this->plugin_meta['url'].'templates/post-frontend-style.css');
		//getting dynamic css
		ob_start();
		$this -> load_template('dynamic-css.php');
		$output_css = ob_get_contents();
		ob_end_clean();
		wp_add_inline_style( $this->plugin_meta['shortname'].'-styles', $output_css );
		wp_add_inline_style( $this->plugin_meta['shortname'].'-styles', $this -> get_option("_custom_styles") );
		
		
		if ( is_user_logged_in()) {

			ob_start();
			
			$this -> load_template('post-frontend-form.php');
			$output_string = ob_get_contents();
			ob_end_clean();
				
			return $output_string;
		}else{
			
			echo '<script type="text/javascript">
			window.location = "'.wp_login_url( get_permalink() ).'"
			</script>';
		}
		
	}
	
	/** the callback funcition
	 * upload file to server
	 */
	
	function upload_file() {
	
	
		header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . " GMT" );
		header ( "Cache-Control: no-store, no-cache, must-revalidate" );
		header ( "Cache-Control: post-check=0, pre-check=0", false );
		header ( "Pragma: no-cache" );
		
		$file_name = sanitize_file_name( $_REQUEST['name'] );
		/* ========== Invalid File type checking ========== */
		$file_type = wp_check_filetype_and_ext($file_dir_path, $file_name);
		
		
		$good_types = apply_filters('postfront_file_types', array('jpg', 'png', 'gif', 'zip','pdf','JPG','PNG') );
		
		if( ! in_array($file_type['ext'], $good_types ) ){
			$response ['status'] = 'error';
			$response ['message'] = __ ( 'File type not valid', 'nm-postfront' );
			die ( json_encode($response) );
		}
		/* ========== Invalid File type checking ========== */
	
		// setting up some variables
		$file_dir_path = $this->setup_file_directory ();
		$response = array ();
		if ($file_dir_path == 'errDirectory') {
				
			$response ['status'] = 'error';
			$response ['message'] = __ ( 'Error while creating directory', 'nm-postfront' );
			die ( 0 );
		}
	
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
	
		// 5 minutes execution time
		@set_time_limit ( 5 * 60 );
	
		// Uncomment this one to fake upload time
		// usleep(5000);
	
		// Get parameters
		$chunk = isset ( $_REQUEST ["chunk"] ) ? intval ( $_REQUEST ["chunk"] ) : 0;
		$chunks = isset ( $_REQUEST ["chunks"] ) ? intval ( $_REQUEST ["chunks"] ) : 0;
		
		// Clean the fileName for security reasons
		$file_name = preg_replace ( '/[^\w\._]+/', '_', $file_name );
		$file_name = strtolower($file_name);
	
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists ( $file_dir_path . $file_name )) {
			$ext = strrpos ( $file_name, '.' );
			$file_name_a = substr ( $file_name, 0, $ext );
			$file_name_b = substr ( $file_name, $ext );
				
			$count = 1;
			while ( file_exists ( $file_dir_path . $file_name_a . '_' . $count . $file_name_b ) )
				$count ++;
				
			$file_name = $file_name_a . '_' . $count . $file_name_b;
		}
	
		// Remove old temp files
		if ($cleanupTargetDir && is_dir ( $file_dir_path ) && ($dir = opendir ( $file_dir_path ))) {
			while ( ($file = readdir ( $dir )) !== false ) {
				$tmpfilePath = $file_dir_path . $file;
	
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match ( '/\.part$/', $file ) && (filemtime ( $tmpfilePath ) < time () - $maxFileAge) && ($tmpfilePath != "{$file_path}.part")) {
					@unlink ( $tmpfilePath );
				}
			}
				
			closedir ( $dir );
		} else
			die ( '{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}' );
	
		$file_path = $file_dir_path . $file_name;
	
		// Look for the content type header
		if (isset ( $_SERVER ["HTTP_CONTENT_TYPE"] ))
			$contentType = $_SERVER ["HTTP_CONTENT_TYPE"];
	
		if (isset ( $_SERVER ["CONTENT_TYPE"] ))
			$contentType = $_SERVER ["CONTENT_TYPE"];
			
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos ( $contentType, "multipart" ) !== false) {
			if (isset ( $_FILES ['file'] ['tmp_name'] ) && is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
				// Open temp file
				$out = fopen ( "{$file_path}.part", $chunk == 0 ? "wb" : "ab" );
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen ( $_FILES ['file'] ['tmp_name'], "rb" );
						
					if ($in) {
						while ( $buff = fread ( $in, 4096 ) )
							fwrite ( $out, $buff );
					} else
						die ( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
					fclose ( $in );
					fclose ( $out );
					@unlink ( $_FILES ['file'] ['tmp_name'] );
				} else
					die ( '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}' );
			} else
				die ( '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}' );
		} else {
			// Open temp file
			$out = fopen ( "{$file_path}.part", $chunk == 0 ? "wb" : "ab" );
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen ( "php://input", "rb" );
	
				if ($in) {
					while ( $buff = fread ( $in, 4096 ) )
						fwrite ( $out, $buff );
				} else
					die ( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
	
				fclose ( $in );
				fclose ( $out );
			} else
				die ( '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}' );
		}
	
		// Check if file has been uploaded
		if (! $chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename ( "{$file_path}.part", $file_path );
				
			// making thumb if images
			if($this -> is_image($file_name))
			{
				$thumb_size = array(array('h' => 600, 'w' => 600, 'crop' => false),
									array('h' => 300, 'w' => 300, 'crop' => true)
				);
				$thumb_meta = $this -> create_thumb($file_dir_path, $file_name, $thumb_size);
	
				$response = array(
						'file_name'		=> $file_name,
						'thumb_meta'	=> $thumb_meta,
						'status'		=> 'success');
			}else{
				$response = array(
						'file_name'			=> $file_name,
						'file_w'			=> 'na',
						'file_h'			=> 'na',
						'status'			=> 'success');
			}
		}
			
		// Return JSON-RPC response
		//die ( '{"jsonrpc" : "2.0", "result" : '. json_encode($response) .', "id" : "id"}' );
		die ( json_encode($response) );
	
	
	}



	// ================================ SOME HELPER FUNCTIONS =========================================
	
	function create_thumb($dest, $image_name, $thumb_size) {
	
		// using wp core image processing editor, 6 May, 2014
		$image = wp_get_image_editor ( $dest . $image_name );
		
		$thumbs_resp = '';
		if( is_array($thumb_size) ){
			
			foreach($thumb_size as $size){
				$thumb_name = $size['h'].'x'.$size['w'].'-'.$image_name;
				$thumb_dest = $dest . 'thumbs/' . $thumb_name;
				if (! is_wp_error ( $image )) {
					$image->resize ( $size['h'], $size['w'], $size['crop'] );
					$image->save ( $thumb_dest );
					$thumbs_resp[$thumb_name] = array('name' => $thumb_name, 'thumb_size' => getimagesize($thumb_dest) );
				}
			}
		}
		
	
		return $thumbs_resp;
	}
	
	/*
	 * check if file is image and return true
	*/
	function is_image($file){
	
		$type = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
	
		if (($type == "gif") || ($type == "jpeg") || ($type == "png") || ($type == "pjpeg") || ($type == "jpg"))
			return true;
		else
			return false;
	}
	
	/*
	 * getting file URL
	*/
	function get_file_dir_url($thumbs = false) {
	
		$upload_dir = wp_upload_dir ();
	
		if ($thumbs)
			return $upload_dir ['baseurl'] . '/' . $this -> post_files . '/thumbs/';
		else
			return $upload_dir ['baseurl'] . '/' . $this -> post_files . '/';
	}
	
	function get_file_dir_path() {
		$upload_dir = wp_upload_dir ();
		return $upload_dir ['basedir'] . '/' . $this -> post_files . '/';
	}
	
	/*
	 * setting up user directory
	*/
	function setup_file_directory() {
		$upload_dir = wp_upload_dir ();
	
		$dirPath = $upload_dir ['basedir'] . '/' . $this -> post_files . '/';
	
		if (! is_dir ( $dirPath )) {
			if (mkdir ( $dirPath, 0775, true ))
				$dirThumbPath = $dirPath . 'thumbs/';
			if (mkdir ( $dirThumbPath, 0775, true ))
				return $dirPath;
			else
				return 'errDirectory';
		} else {
			$dirThumbPath = $dirPath . 'thumbs/';
			if (! is_dir ( $dirThumbPath )) {
				if (mkdir ( $dirThumbPath, 0775, true ))
					return $dirPath;
				else
					return 'errDirectory';
			} else {
				return $dirPath;
			}
		}
	}

	
	/**
	 * getting the runtime for file uploader instace
	 */
	 function get_runtime(){
	 	
		$upload_runtime = '';
		if(!(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))){
				$upload_runtime = 'html5,flash,silverlight,html4,browserplus,gear';
			}else{
				$upload_runtime = 'flash';
		}
		return $upload_runtime;
	}
	
	function activate_plugin(){

		// so far so good

	}

	function deactivate_plugin(){

		//do nothing so far.
	}
}