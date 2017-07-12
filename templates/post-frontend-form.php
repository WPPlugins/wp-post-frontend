<?php
/*
 * sample cotact form template file
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $postfront;
	
	$wp_editor_settings = array(
		'wpautop' => false,
		'textarea_rows' => 5,
		'tinymce' => true,
	);

/*
 * Validate Media Buttons
 */

	if($postfront -> get_option("_media_upload") == 'yes'){
		$wp_editor_settings['media_buttons'] = true;
	}else{
		$wp_editor_settings['media_buttons'] = false;
	}

/*
 * Validate Richtext Editor
 */

	if($postfront -> get_option("_rich_editor") == 'yes'){
		$wp_editor_settings['tinymce'] = true;
	}else{
		$wp_editor_settings['tinymce'] = false;
	}



$post_content = '';

?>
 

<div id="form-buttons-bar" class="clearfix">
</div>
		
<!-- the html meat -->
 <form id="nm-post-front-form">
 <input type="hidden" name="featured_image_uploaded" id="featured_image_uploaded" />

	<div id="form-main-area" class="container">
		
		
		<label class="heading">Title</label>
		<div class="clearfix"></div>

		<input maxlength="95" name="post_title" id="post_title" type="text" value="">
		<div class="clearfix"></div>

		<label class="heading">Description</label>
		<div class="clearfix"></div>

		<?php wp_editor($post_content, 'post_description', $wp_editor_settings );
			//wp_editor('','post_description');
			?>
		<div class="clearfix"></div>

<?php if($postfront -> get_option("_show_taxonomy") == 'yes'){ 
$exclude_taxonomy = explode(',', $postfront -> get_option('_exclude_taxonomy'));
	?>
		
		
		

		<?php
			$posttype = $postfront -> get_option('_post_type');
			$taxonomy_names = get_object_taxonomies( $posttype );
   			foreach($taxonomy_names as $taxonomy){

   				if(!in_array($taxonomy, $exclude_taxonomy)){

   					echo '<label class="heading">Select '.$taxonomy.'</label>';
					echo '<div class="clearfix"></div>';

					$terms_args = array( 'hide_empty'        => false, 
						'parent'      => 0,
						'exclude'	=> $postfront -> get_option('_exclude_term') );
					$terms = get_terms($taxonomy, $terms_args);
					if($terms){

						echo '<ul class="tax-styles">';
						foreach ($terms as $term) {
							
							postfront_render_term_tree($term->term_id, $taxonomy);					
						}
						echo "</ul>";
					}	
   				}
				

   			}		
   		?>
		
<?php } ?>

<?php if($postfront -> get_option("_featured_image") == 'yes'){ ?>
		
		<label class="heading">Featured Image</label>
		<div class="clearfix"></div>
		<a href="javascript:;" id="select-button" class="form-button"><i class="fa fa-upload"></i>
			<?php echo ($postfront -> get_option("_feature_btn_label")) ? $postfront -> get_option("_feature_btn_label") : 'Upload Image' ; ?>
		</a>
		<div id="filelist-featuredimage" class="filelist"></div>
		
<?php } ?>
		
		<div id="form-buttons-bar" class="clearfix">
			<button type="submit" id="publish-button" class="form-button form-button-publish">
				<i class="fa fa-floppy-o"></i>
				<?php echo ($postfront -> get_option("_publish_btn_label")) ? $postfront -> get_option("_publish_btn_label") : 'Publish' ; ?>
			</button>
			<p style="text-align:center" id="saving-response"></p> 
		</div>
		
	</div>
	</form>
	<!-- Main Container ENDS -->