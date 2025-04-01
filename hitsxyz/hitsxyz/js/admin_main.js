/** Mega Menu **/
jQuery(function($){
	"use strict";
	
	if( $('p.field-hits-is-megamenu').length > 0 ){
		$(document).on('change', 'p.field-hits-is-megamenu input[type="checkbox"]', function(){
			var is_megamenu = $(this).is(':checked');
			var megamenu_field = $(this).parents('p.field-hits-is-megamenu');
			var li_parent = $(this).parents('li.menu-item');
			
			var menu_li_child = li_parent.nextUntil('.menu-item-depth-0');
			if( is_megamenu ){
				megamenu_field.siblings('.hits-custom-menu, .wp-editor-wrap').show();
			}
			else{
				megamenu_field.siblings('.hits-custom-menu, .wp-editor-wrap').hide();
			}
			menu_li_child.find('.hits-custom-menu, .wp-editor-wrap').hide();
		});
		
		$(document).on('mouseup', 'ul#menu-to-edit li.menu-item a.item-edit', function(){
			$(this).parents('li.menu-item').trigger('click');
		});
		
		$(document).on('click', 'ul#menu-to-edit > li', function(){
			if( $(this).hasClass('menu-item-depth-0') ){
				var is_megamenu = $(this).find('.edit-menu-item-hits-is-megamenu').is(':checked');
				var menu_li_child = $(this).nextUntil('.menu-item-depth-0');
				if( is_megamenu ){
					$(this).find('.hits-custom-menu, .wp-editor-wrap').show();
				}
				else{
					$(this).find('.hits-custom-menu, .wp-editor-wrap').hide();
				}
				$(this).find('.field-hits-is-megamenu').show(); /* Always show checkbox */
				menu_li_child.find('.hits-custom-menu, .wp-editor-wrap').hide();
				$(this).find('.field-hits-bg-color').show(); /* background color */
			}
			else{
				$(this).find('.hits-custom-menu, .wp-editor-wrap').hide();
				$(this).find('.field-hits-bg-color').hide(); /* background color */
				$(this).find('.field-hits-bg-color .edit-menu-item-hits-bg-color').val(''); /* background color */
			}
		});
		
		$('#menu-to-edit').on('sortstop', function(event, ui){
			var current_item = ui.item;
			setTimeout(function(){
				current_item.trigger('click');
			},100);
		});
		
		/* Upload thumbnail */
		$(document).on('click', '.hits_mega_menu_upload_image', function(){
			var current_add_ele = $(this);
			var current_rmv_ele = $(this).siblings('a.hits_mega_menu_clear_image');
			var preview = $(this).siblings('span.preview-thumbnail-wrapper');
			var thumbnail_id_value = $(this).siblings('.thumbnail-id-hidden');  
			wp.media.editor.send.attachment = function(props, attachment){
				var thumb_id  = attachment.id;
				var thumb_url = '';
				if( typeof(attachment.sizes.thumbnail) !== 'undefined' ){
					thumb_url = attachment.sizes.thumbnail.url;
				}else{
					thumb_url = attachment.sizes[props.size].url;
				}
				var img_html = '<img src="'+thumb_url+'" width="32" height="32" >';
				preview.html(img_html);
				thumbnail_id_value.val(thumb_id);
				
				current_add_ele.hide();
				current_rmv_ele.show();
			}
			wp.media.editor.open(current_add_ele);
		}); 

		$(document).on('click', '.hits_mega_menu_clear_image', function(){
			var current_rmv_ele = $(this);
			var current_add_ele = $(this).siblings('a.hits_mega_menu_upload_image');
			var preview = $(this).siblings('span.preview-thumbnail-wrapper');
			var thumbnail_id_value = $(this).siblings('.thumbnail-id-hidden');  
			preview.html('');
			thumbnail_id_value.val('');
			current_add_ele.show();
			current_rmv_ele.hide();
			return false;  
		}); 
	}
	
	/* Sub Label Background Color */
	if( typeof $.fn.wpColorPicker == 'function' ){
		$('.field-hits-sub-label-bg-color input, .field-hits-bg-color input').wpColorPicker();
		$(document).on('menu-item-added', function(e, added_menu){
			added_menu.find('.field-hits-sub-label-bg-color input, .field-hits-bg-color input').wpColorPicker();
		});
	}
});
/** End Mega Menu **/

/** Meta Boxes - Widgets **/
jQuery(function($){
	"use strict";
	
	$(document).on('click', '.hits_meta_box_upload_button', function(){
		var button = $(this);
		var clear_button = button.siblings('.hits_meta_box_clear_image_button');
		var input_field = button.siblings('.upload_field');   
		wp.media.editor.send.attachment = function(props, attachment){
			var attachment_url = '';
			attachment_url = attachment.sizes[props.size].url;
			input_field.val(attachment_url);
			if( input_field.siblings('.preview-image').length > 0 ){
				input_field.siblings('.preview-image').attr('src', attachment_url);
			}
			else{
				var img_html = '<img class="preview-image" src="' + attachment_url + '" />';
				input_field.parent().append(img_html);
			}
			clear_button.attr('disabled', false);
			input_field.trigger('change'); /* For widget */
		}
		wp.media.editor.open(button);
	}); 
	
	$(document).on('click', '.hits_meta_box_clear_image_button', function(){
		var button = $(this);
		button.attr('disabled', true);
		button.siblings('.upload_field').val('');
		button.siblings('.preview-image').fadeOut(250, function(){
			button.siblings('.preview-image').remove();
		});
		button.siblings('.upload_field').trigger('change'); /* For widget */
	});
	
	$(document).on('change', '.hits-meta-box-field .upload_field, .widget .upload_field', function(){
		var input_field = $(this);
		var input_value = input_field.val().trim();
		if( input_value == '' ){
			input_field.siblings('.hits_meta_box_clear_image_button').trigger('click'); /* don't loop because button is disabled */
		}
		else{
			if( input_field.siblings('.preview-image').length > 0 ){
				input_field.siblings('.preview-image').attr('src', input_value);
			}
			else{
				var img_html = '<img class="preview-image" src="' + input_value + '" />';
				input_field.parent().append(img_html);
			}
			input_field.siblings('.hits_meta_box_clear_image_button').attr('disabled', false);
		}
	});
	
	/* Gallery */
	var file_frame;
	var _add_img_button;
	$('.hits-gallery-box .add-image').on('click', function(event){
		event.preventDefault();
		_add_img_button = jQuery(this);
        
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        var _states = [new wp.media.controller.Library({
            filterable: 'uploaded',
            title: hitsxyz_admin_texts.select_images,
            multiple: true,
            priority:  20
        })];
			 
        file_frame = wp.media.frames.file_frame = wp.media({
            states: _states,
            button: {
                text: hitsxyz_admin_texts.use_images
            }
        });

        file_frame.on( 'select', function() {
			var object = file_frame.state().get('selection').toJSON();
			
			var img_html = '';
			if( object.length > 0 ){
				for( var i = 0; i < object.length; i++ ){
					var image_url = object[i].url;
					if( typeof object[i].sizes.thumbnail != "undefined" ){
						image_url = object[i].sizes.thumbnail.url;
					}
					img_html += '<li class="image"><span class="del-image"></span><img src="'+image_url+'" alt="" data-id="'+object[i].id+'"/></li>';
				}
			}
			
			_add_img_button.siblings('ul.images').append(img_html);
			
			var arr_ids = new Array();
			_add_img_button.siblings('ul.images').find('li img').each(function(index, ele){
				arr_ids.push( $(ele).data('id') );
			});
			
			_add_img_button.siblings('.meta-value').val(arr_ids.join(','));
        });
		 
        file_frame.open();
	});
	
	$(document).on('click', '.hits-gallery-box .del-image', function(){
		var image = $(this).parent('.image');
		var container = $(this).parents('.hits-gallery-box');
		image.fadeOut(300, function(){
			image.remove();
			update_gallery_ids_field( container );
		});
	});
	
	if( typeof $.fn.sortable == 'function' ){
		$('.hits-gallery-box .images').sortable({revert: true, update: function(e, ui){ update_gallery_ids_field($(ui.item).parents('.hits-gallery-box')); }});
		$('.hits-gallery-box .images').disableSelection();
	}
	
	function update_gallery_ids_field(container){
		var arr_ids = new Array();
		container.find('.images img').each(function(index, ele){
			arr_ids.push( $(ele).data('id') );
		});
		container.find('.meta-value').val( arr_ids.join(',') );
	}
	
	/* Colorpicker */
	if( typeof $.fn.wpColorPicker == 'function' ){
		var params = {
			change: function(e, ui){
				$(e.target).val( ui.color.toString() );
				$(e.target).trigger('change');
			}
		};
		$('.hits-meta-box-field .colorpicker, #widgets-right .colorpicker').wpColorPicker( params );
		$(document).on('widget-updated widget-added', function(e, widget){
			widget.find('.colorpicker').wpColorPicker( params );
		});
	}
	
	/* Table */
	$(document).on('click', '.hits-meta-box-field.table .table-button', function(e){
		e.preventDefault();
		var table = $(this).closest('table');
		var action = $(this).attr('class').replace('table-button', '').replace(' ', '');
		switch( action ){
			case 'add-col':
				if( table.find('thead td').length > 20 ){
					return;
				}
				var col = $(this).parent('td');
				var index = col.parent().children('td').index(col);
				var tbody = $(this).closest('thead').siblings('tbody');
				col.after( col.clone() );
				tbody.find('tr').each(function(i, e){
					var row = $(e);
					var col = row.find('td').eq(index);
					var new_col = col.clone();
					new_col.find('input').val('');
					col.after( new_col );
				});
			break;
			case 'del-col':
				if( table.find('thead td').length == 2 ){
					return;
				}
				var col = $(this).parent('td');
				var index = col.parent().children('td').index(col);
				var tbody = $(this).closest('thead').siblings('tbody');
				col.remove();
				tbody.find('tr').each(function(i, e){
					$(e).find('td').eq(index).remove();
				});
			break;
			case 'add-row':
				var row = $(this).closest('tr');
				var new_row = row.clone();
				new_row.find('input').val('');
				row.after( new_row );
			break;
			case 'del-row':
				if( table.find('tbody tr').length == 1 ){
					table.find('tbody tr input').val('');
				}
				else{
					$(this).closest('tr').remove();
				}
			break;
		}
		update_table_value( table );
	});
	
	$(document).on('change', '.hits-meta-box-field.table table input', function(){
		update_table_value( $(this).closest('table') );
	});
	
	if( $('.hits-meta-box-field.table').length ){
		$('.hits-meta-box-field.table table').each(function(){
			update_table_value( $(this) );
		});
	}
	
	function update_table_value( table ){
		var value = new Array();
		table.find('tbody tr').each(function(){
			var row_val = new Array();
			var empty_cols = 0;
			$(this).find('input').each(function(i, e){
				row_val.push( $(e).val() );
				if( !$(e).val() ){
					empty_cols++;
				}
			});
			if( empty_cols != row_val.length ){
				value.push( row_val );
			}
		});
		table.siblings('.table-value').val( value.length ? JSON.stringify(value) : '' );
	}
	
	/* Multi Select */
	$('.hits-meta-box-field.multi-select select').on('change', function(){
		$(this).siblings('.select-value').val( $(this).val() );
	});
	
	$('.hits-meta-box-field.multi-select select').trigger('change');
	
	if( typeof $.fn.selectWoo == 'function' ){
		$('.hits-meta-box-field.multi-select select').selectWoo();
	}
});
/** End Meta Boxes **/

/** Page Template - Page Options **/
jQuery(function($){
	"use strict";
	
	if( $('select#page_template').length > 0 ){
		$('select#page_template').on('change initial', function(){
			var template = $(this).val();
			if( template == 'page-templates/blank-page-template.php' ){
				$('#page_options').addClass('hits-hidden');
			}
			else{
				$('#page_options').removeClass('hits-hidden');
			}
		});
		$('select#page_template').trigger('initial');
	}
	
	/* Transparent header */
	$('.hits-meta-box-field #hits_header_layout').on('change', function(){
		if( $.inArray( $(this).val(), ['v1','v2','v5'] ) != -1 ){
			$('#hits_header_transparent').parents('.hits-meta-box-field').show();
		}
		else{
			$('#hits_header_transparent').parents('.hits-meta-box-field').hide();
			$('#hits_header_transparent').val(0);
		}
		$('.hits-meta-box-field #hits_header_transparent').trigger('change');
	});
	
	$('.hits-meta-box-field #hits_header_transparent').on('change', function(){
		if( $(this).val() == 1 ){
			$('#hits_header_text_color').parents('.hits-meta-box-field').show();
		}
		else{
			$('#hits_header_text_color').parents('.hits-meta-box-field').hide();
		}
	});
	
	$('.hits-meta-box-field #hits_header_layout').trigger('change');
	
	/* Fullwidth layout */
	$('#page_options #hits_layout_fullwidth').on('change', function(){
		var val = $(this).val();
		if( val == '1' ){
			$('#hits_header_layout_fullwidth').parents('.hits-meta-box-field').fadeIn();
			$('#hits_main_content_layout_fullwidth').parents('.hits-meta-box-field').fadeIn();
			$('#hits_footer_layout_fullwidth').parents('.hits-meta-box-field').fadeIn();
			
			$('#hits_layout_style').parents('.hits-meta-box-field').fadeOut();
		}
		else{
			$('#hits_header_layout_fullwidth').parents('.hits-meta-box-field').fadeOut();
			$('#hits_main_content_layout_fullwidth').parents('.hits-meta-box-field').fadeOut();
			$('#hits_footer_layout_fullwidth').parents('.hits-meta-box-field').fadeOut();
			
			$('#hits_layout_style').parents('.hits-meta-box-field').fadeIn();
		}
	});
	$('#page_options #hits_layout_fullwidth').trigger('change');
});
/** End Page Template **/

/** Custom Sidebar **/
jQuery(function($){
	"use strict";
	
	var add_sidebar_form = $('#hits-form-add-sidebar');
	if( add_sidebar_form.length > 0 ){
		var add_sidebar_form_new = add_sidebar_form.clone();
		add_sidebar_form.remove();
		jQuery('#widgets-right').append('<div style="clear:both;"></div>');
		jQuery('#widgets-right').append(add_sidebar_form_new);
		
		$('#hits-add-sidebar').on('click', function(e){
			e.preventDefault();
			var sidebar_name = $.trim( $(this).siblings('#sidebar_name').val() );
			var sidebar_nonce = $('#hits_custom_sidebar_nonce').val();
			if( sidebar_name != '' ){
				$('#hits-form-add-sidebar').addClass('loading');
				$(this).attr('disabled', true);
				var data = {
					action: 'hitsxyz_add_custom_sidebar'
					,sidebar_name: sidebar_name
					,sidebar_nonce: sidebar_nonce
				};
				
				$.ajax({
					type : 'POST'
					,url : ajaxurl	
					,data : data
					,success : function(response){
						if( response ){
							alert( response );
						}
						window.location.reload(true);
					}
				});
			}
		});
	}
	
	if( $('.sidebar-hits-custom-sidebar').length > 0 ){
		var delete_button = '<span class="delete-sidebar"></span>';
		$('.sidebar-hits-custom-sidebar .sidebar-name').prepend(delete_button);
		
		$('.sidebar-hits-custom-sidebar .delete-sidebar').on('click', function(){
			var sidebar_name = $(this).parent().find('h2').text();
			var widget_block = $(this).parents('.widgets-holder-wrap');
			var sidebar_nonce = $('#hits_custom_sidebar_nonce').val();
			var ok = confirm( hitsxyz_admin_texts.delete_sidebar_confirm );
			if( ok ){
				widget_block.hide();
				var data = {
					action: 'hitsxyz_delete_custom_sidebar'
					,sidebar_name: sidebar_name
					,sidebar_nonce: sidebar_nonce
				};
				
				$.ajax({
					type : 'POST'
					,url : ajaxurl	
					,data : data
					,success : function(response){
						if( response != '' ){
							widget_block.remove();
						}
						else{
							widget_block.show();
							alert( hitsxyz_admin_texts.delete_sidebar_failed );
						}
					}
				});
			}
		});
	}
});

/** Product Category **/
jQuery(function($){
	"use strict";
	
	/* Only show the "remove image" button when needed */
	$('.hits-product-cat-upload-field').each(function(){
		if( ! $(this).find('.value-field').val() ){
			$(this).find('.remove-button').hide();
		}
	});

	/* Uploading files */
	var file_frame;
	var upload_button;

	$( document ).on( 'click', '.hits-product-cat-upload-field .upload-button', function( event ) {

		event.preventDefault();
		
		upload_button = $(this);

		/* If the media frame already exists, reopen it. */
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		/* Create the media frame. */
		file_frame = wp.media.frames.downloadable_file = wp.media({
			title: hitsxyz_admin_texts.choose_an_image,
			button: {
				text: hitsxyz_admin_texts.use_image
			},
			multiple: false
		});

		/* When an image is selected, run a callback. */
		file_frame.on( 'select', function() {
			var attachment = file_frame.state().get( 'selection' ).first().toJSON();
			var thumb_url = attachment.url;
			if( typeof attachment.sizes.thumbnail != 'undefined' ){
				thumb_url = attachment.sizes.thumbnail.url;
			}

			upload_button.siblings('.value-field').val( attachment.id );
			upload_button.parents('.hits-product-cat-upload-field').find('.preview-image img').attr( {'src': thumb_url, 'width': '', 'height': ''} );
			upload_button.siblings('.remove-button').show();
		});

		/* Finally, open the modal. */
		file_frame.open();
	});

	$( document ).on( 'click', '.hits-product-cat-upload-field .remove-button', function() {
		var button = $(this);
		button.parents('.hits-product-cat-upload-field').find('.preview-image img').remove();
		button.parents('.hits-product-cat-upload-field').find('.preview-image').append( '<img src="' + button.siblings('.placeholder-image-url').val() + '" class="woocommerce-placeholder wp-post-image" width="60" height="60" alt="Placeholder" />' );
		button.siblings('.value-field').val('');
		button.hide();
		return false;
	});
	
	if( typeof $.fn.wpColorPicker == 'function' ){
		$('.hits-color-picker').wpColorPicker();
	}
});