jQuery(function($){

	$('#nm_postfront-tabs').tabs();
	
	//submitting form foreach setting/tabs
	$(".nm-admin-form").submit(function(event){
		event.preventDefault();
		
		$(".nm-saving-settings").html('<img src="'+nm_postfront_vars.doing+'" />');
		var form_data = $(this).serialize();
		//console.log(form_data);
		$.post(ajaxurl, form_data, function(resp){
			
			//console.log(resp);
			$(".nm-saving-settings").html(resp);
			//window.location.reload(true);
		});
	});
	
    /* =========== wpColorPicker =============== */
    $('.wp-color-field').wpColorPicker();
    /* =========== wpColorPicker =============== */	
});

