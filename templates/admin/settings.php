<?php 
/*
 * this file rendering admin options for the plugin
* options are defined in admin/admin-options.php
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$this -> load_template('admin/options.php');
//$this -> pa($this -> the_options);

//$this -> pa($this -> plugin_settings);


?>

<style>
	
	.nm-help{
		font-size: 11px;
	}
	.the-button{
		float: right;
		}
	.nm-saving-settings{
	float: left;
	margin-right: 5px;
	display: block;
	margin-top: 5px;
}
</style>

<h2>
	<?php printf(__("%s", 'nm-postfront'), $this->plugin_meta['name']);?>
</h2>
<p><b>Help</b>: Add this shortcode <b>[nm-post-front]</b> where you want to show frontend post form. <a href="https://vimeo.com/110471477" target="_blank">more</a></p>
<div id="nm_postfront-tabs" class="wrap">
	<ul class='etabs'>
		<?php foreach($this -> the_options as $id => $option){
			
			?>

		<li class='tab'><a href="#<?php echo $id?>"><?php echo $option['name']?>
		</a></li>

		<?php }?>
	</ul>

	<form id="nm-admin-form-<?php echo $id?>" class="nm-admin-form">
	<?php wp_nonce_field('postfront-nonce'); ?>
	<input type="hidden" name="action" value="<?php echo $this->plugin_meta['shortname']?>_save_settings" />
	
	<?php foreach($this -> the_options as $id => $options){
		
		// reseting the update data array
		
		?>

	<div id="<?php echo $id?>">
		
		<p>
			<?php echo $options['desc']?>
		</p>

		<table class="form-table">
		<?php foreach($options['meat'] as $key => $data){
			
				$label 		 	= $data['label'];
				$type 		 	= $data['type'];
				$help 			= (isset($data['help']) ? $data['help'] : '');
				
			?>
				<tr valign="top" <?php if ($type == 'heading') { echo 'style="background-color: #E3E8E3;"';} ?>>
					<th <?php if ($type == 'heading') { echo 'style="padding-left: 15px;;"';} ?> scope="row" width="25%"><?php printf(__('%s', 'nm-postfront'), $label);?>
						
					</th>
					<td width="30%">
						<?php $this -> render_settings_input($data); ?>
					</td>
					<td width="40%">
						<span class="nm-help"><?php echo $help?></span>
					</td>
				</tr>
				
			
			
			<?php
				}
			?>
		
		</table>
	</div>
	
	<?php
	}	
	?>
	<p class="the-button"><button class="button button-primary"><?php _e('Save settings', 'nm-postfront')?></button><span class="nm-saving-settings"></span></p>
	</form>
	
	
</div>
