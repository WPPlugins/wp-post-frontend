/*
 * NOTE: all actions are prefixed by plugin shortnam_action_name
 */
var file_count_featuredimage = 1;
var uploader_featuredimage;
	
jQuery(function($){
	
	setTimeout(function() {
		$( "ul.login-menus li:nth-child(4)" ).find("a").attr("href", "javascript:load_post_form()");
	}, 2000);
	
	
	// Alert messages
	var successMsg;
	var failedMsg;
	var waitMsg;

	if (get_option('_success_message')) {
		successMsg = get_option('_success_message');
	} else{
		successMsg = 'Post is saved successfully...';
	};
	if (get_option('_error_message')) {
		errorMsg = get_option('_error_message');
	} else{
		errorMsg = 'Please provide missing details above...';
	};
	if (get_option('_wait_message')) {
		waitMsg = get_option('_wait_message');
	} else{
		waitMsg = 'Please wait while saving...';
	};

	//posting form
	$("#nm-post-front-form").submit(function(e){
		e.preventDefault();

		$("#saving-response").html(waitMsg);
		
		var content;
		
		if (get_option('_rich_editor') == 'yes') {

			var editor = tinyMCE.get('post_description');
			if (editor) {
			    // Ok, the active tab is Visual
			    content = editor.getContent();
			} else {
			    // The active tab is HTML, so just query the textarea
			    content = $('#post_description').val();
			}
		}
		
		
		//console.log( content ); return false;
			
		if( is_valid() ){
			
			var post_data = $(this).serialize();
			post_data = post_data + '&action=nm_postfront_save_post&postcontents='+content;
			//post_data = post_data + '&action=nm_postfront_save_post';
			
			
			$.post(nm_postfront_vars.ajaxurl, post_data, function(resp){
				
				//console.log(resp);
				$("#saving-response").html(successMsg).css({'color':'green'});
				window.location.reload();
			});
			
			
		}else{
			$("#saving-response").html(errorMsg).css({'color':'red'});
		}
		
		
	});

	// Taxonomy Dropdown Scripts

	$('.tax-styles li:has(ul)').addClass('expand').find('ul').hide();
	$('.tax-styles li.expand>label').after('<span>[ + ]</span>');

	
	$('.tax-styles').on('click', 'li.collapse span', function (e) {
		$(this).text('[ + ]').parent().addClass('expand').removeClass('collapse').find('>ul').slideUp();
		e.stopImmediatePropagation();
	});

	$('.tax-styles').on('click', 'li.expand span', function (e) {
		$(this).text('[ - ]').parent().addClass('collapse').removeClass('expand').find('>ul').slideDown();
		e.stopImmediatePropagation();
	});

	$('.tax-styles').on('click', 'li.collapse li:not(.collapse)', function (e) {
		e.stopImmediatePropagation();
	}); 	
	
	/* ================ PLUPLOAD INSTACE ====================== */
	// file uploader script
    var $filelist_DIV = $('#filelist-featuredimage');
    uploader_featuredimage = new plupload.Uploader({
		runtimes 			: nm_postfront_vars.runtime,
		browse_button 		: 'select-button', // you can pass in id...
		container			: 'form-main-area', // ... or DOM Element itself
		drop_element		: 'form-main-area',
		url 				: nm_postfront_vars.ajaxurl,
		multipart_params 	: {'action' : 'nm_postfront_upload_file'},
		max_file_size 		: '1000mb',
		max_file_count 		: 5,
	    
	    chunk_size: '2mb',
		
	    // Flash settings
		flash_swf_url 		: nm_postfront_vars.plugin_url + 'js/plupload/js/Moxie.swf',
		// Silverlight settings
		silverlight_xap_url : nm_postfront_vars.plugin_url + 'js/plupload/js/Moxie.xap',
		
		filters : {
			mime_types: [
				{title : "Image files", extensions : "jpg,png,gif"}
			]
		},
		
		init: {
			PostInit: function() {
				$filelist_DIV.html('');

				$('#uploadfiles-featuredimage').bind('click', function() {
					uploader_featuredimage.start();
					return false;
				});
			},

			FilesAdded: function(up, files) {

				var files_added = up.files.length;
				var max_count_error = false;

				
			    plupload.each(files, function (file) {

			    	if(file_count_featuredimage > uploader_featuredimage.settings.max_file_count){
			        
			      		max_count_error = true;
			        }else{
			            // Code to add pending file details, if you want
			            add_thumb_box(file, $filelist_DIV, up);
			        }
			        
			        file_count_featuredimage++;
			    });

			    
			    if(max_count_error)
				    alert(uploader_featuredimage.settings.max_file_count + nm_postfront_vars.mesage_max_files_limit);

			    setTimeout('uploader_featuredimage.start()', 100);    
				
			},
			
			FileUploaded: function(up, file, info){
				
				/* console.log(up);
				console.log(file);*/

				var obj_resp = $.parseJSON(info.response);
				//console.log(obj_resp);
				var file_thumb 	= ''; 

				if(obj_resp.status == 'error'){
					alert(obj_resp.message);
					window.location.reload();
				}
				
				// checking if uploaded file is thumb
				ext = obj_resp.file_name.substring(obj_resp.file_name.lastIndexOf('.') + 1);					
				ext = ext.toLowerCase();
				
				if(ext == 'png' || ext == 'gif' || ext == 'jpg' || ext == 'jpeg'){

					var thumb_count = 0;
					$.each(obj_resp.thumb_meta, function(i, item){

						if(thumb_count === 0){
							
							file_thumb = nm_postfront_vars.file_upload_path_thumb + item.name;
							$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_thumb').append('<img width="100" src="'+file_thumb+ '" id="thumb_'+file.id+'" />');
						}

						thumb_count++;
					});
					//$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_thumb').append('<input type="hidden" name="imagemeta_'+file.id+'" value="'+JSON.stringify(obj_resp.thumb_meta)+'" >');
					
					var file_full 	= nm_postfront_vars.file_upload_path + obj_resp.file_name;
					// thumb thickbox only shown if it is image
					$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_thumb').append('<div style="display:none" id="u_i_c_big' + file.id + '"><img src="'+file_full+ '" /></div>');
					
					//file name	
					$filelist_DIV.find('#u_i_c_' + file.id).find('.progress_bar').html(obj_resp.file_name);
					// zoom effect
					//$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_tools_zoom').append('<a href="#TB_inline?width=500&height=500&inlineId=u_i_c_big'+file.id+'" class="thickbox" title="'+obj_resp.file_name+'"><img width="15" src="'+nm_postfront_vars.plugin_url+'/images/zoom.png" /></a>');
					is_image = true;
				}else{
					file_thumb = nm_postfront_vars.plugin_url+'/images/file.png';
					$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_thumb').html('<img src="'+file_thumb+ '" id="thumb_'+file.id+'" />');
					is_image = false;
				}
				
				// adding checkbox input to Hold uploaded file name as array
				//$filelist_DIV.append('<input style="display:none" checked="checked" type="checkbox" value="'+obj_resp.file_name+'" name="featuredimage['+file.id+']" />');
				$("#featured_image_uploaded").val(obj_resp.file_name);
			},

			UploadProgress: function(up, file) {
				//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
				//console.log($filelist_DIV.find('#' + file.id).find('.progress_bar_runner'));
				$filelist_DIV.find('#u_i_c_' + file.id).find('.progress_bar_number').html(file.percent + '%');
				$filelist_DIV.find('#u_i_c_' + file.id).find('.progress_bar_runner').css({'display':'block', 'width':file.percent + '%'});
			},

			Error: function(up, err) {
				//document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
				alert("\nError #" + err.code + ": " + err.message);
			}
		}
		

	});

    uploader_featuredimage.init();

});

function add_thumb_box(file, $filelist_DIV){

		var inner_html 	= '<table style="display:noned;width:100%;margin-bottom: 20px;" data-fileid="'+file.id+'">';
		
		inner_html		+= '<tr style="background: #ccc;">';
		// inner_html		+= '<td style="text-align:center;height: 25px;vertical-align: middle;"><input type="radio" name="set_featured" value="'+file.id+'">';
		// inner_html		+= 'Set featured?<br />';
		inner_html		+= '<div class="progress_bar"><span class="progress_bar_runner"></span><span class="progress_bar_number">(' + plupload.formatSize(file.size) + ')<span></div>';
		inner_html		+= '</td></tr>';
		
		inner_html		+= '<tr><td style="vertical-align: top;"><div class="u_i_c_thumb"></div></td>';
		inner_html		+= '</tr>';
		inner_html		+= '</table>';
		  
		jQuery( '<div />', {
			'id'	: 'u_i_c_'+file.id,
			'class'	: 'u_i_c_box',
			'html'	: inner_html,
			
		}).appendTo($filelist_DIV);

		// clearfix
		// 1- removing last clearfix first
		$filelist_DIV.find('.u_i_c_box_clearfix').remove();
		
		jQuery( '<div />', {
			'class'	: 'u_i_c_box_clearfix',				
		}).appendTo($filelist_DIV);
	}


function load_post_form(){
	
	var uri_string = encodeURI('action=nm_postfront_load_post_form&&width=960&height=500');
	
	var url = nm_postfront_vars.ajaxurl + '?' + uri_string;
	tb_show('Create New Post', url);
}



function is_valid(){
	
	var valid_flag = true;
	if(jQuery("#post_title").val() == ''){
		jQuery("#post_title").css({'border':'1px solid red'});
		valid_flag = false
	}
	
	/*if(jQuery("#post_description").val() == ''){
		jQuery("#post_description").css({'border':'1px solid red'});
		valid_flag = false
	}*/
	
	return valid_flag;
}

function get_option(key){
	
	/*
	 * TODO: change plugin shortname
	 */
	var keyprefix = 'nm_postfront';
	
	key = keyprefix + key;
	
	var req_option = '';
	
	jQuery.each(nm_postfront_vars.settings, function(k, option){
		
		//console.log(k);
		
		if (k == key)
			req_option = option;		
	});
	
	//console.log(req_option);
	return req_option;
	
}