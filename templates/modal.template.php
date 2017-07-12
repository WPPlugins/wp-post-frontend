<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $postfront, $upload_runtime;

?>

<link rel="stylesheet" type="text/css" href="<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/css/default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/css/component.css" />
<script src="<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/js/modernizr.custom.js"></script>

<div class="md-modal md-effect-16" id="modal-16">
			<div class="md-content">
				<h3>Create New Post</h3>
				<div>
					
					<?php $postfront -> load_template('post-frontend-form.php');?>
					
					<button class="md-close">Close me!</button>
				</div>
			</div>
		</div>
		
<button class="md-trigger" data-modal="modal-16">Create New Post</button>

<script src="<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/js/classie.js"></script>
<script src="<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/js/modalEffects.js"></script>
<script>
			// this is important for IEs
	var polyfilter_scriptpath = '<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/js/';
</script>
<script src="<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/js/cssParser.js"></script>
<script src="<?php echo $postfront -> plugin_meta['url']?>/js/ModalWindowEffects/js/css-filters-polyfill.js"></script>