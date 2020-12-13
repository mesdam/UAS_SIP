(function( $ ) {
	'use strict';	
	$(document).ready(function(){
        $(document).on('click', '.notice-dismiss', function(e) {
            let linkModified = location.href.split('?')[1].split('&');
            linkModified.pop(linkModified[linkModified.length - 1]);
            linkModified.pop(linkModified[linkModified.length - 1]);
            linkModified = linkModified.join('&');
            window.history.replaceState({}, document.title, '?' + linkModified);
        });
        
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function(e){
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.nav-tab-wrapper a.nav-tab').each(function(){
            if( $(this).hasClass('nav-tab-active') ){
                $(this).removeClass('nav-tab-active');
            }
            });
            $(this).addClass('nav-tab-active');
                $(document).find('.ays-gallery-tab-content').each(function(){
                if( $(this).hasClass('ays-gallery-tab-content-active') )
                    $(this).removeClass('ays-gallery-tab-content-active');
            });
            $(document).find("[name='ays_gpg_settings_tab']").val(active_tab);
            $('.ays-gallery-tab-content' + elemenetID).addClass('ays-gallery-tab-content-active');
            e.preventDefault();
        });
        
        $(document).find('.ays_admin_pages a.ays_page').on('click', function(e){
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.ays_admin_pages a.ays_page').each(function(){
            if( $(this).hasClass('ays_page_active') ){
                $(this).removeClass('ays_page_active');
            }
            });
            $(this).addClass('ays_page_active');
                $(document).find('.ays_accordion').each(function(){
                if( $(this).hasClass('ays_accordion_active') )
                    $(this).removeClass('ays_accordion_active');
            });
            deleteCookie('ays_gpg_page_tab_free');
            setCookie('ays_gpg_page_tab_free', active_tab, {
                expires: 3600,
                path: '/'
            })
            $('.paged_ays_accordion .ays_accordion' + elemenetID).addClass('ays_accordion_active');
            e.preventDefault();
        });

        $(document).find('.ays_gpg_lightbox_color').wpColorPicker();
        $(document).find('.ays_gpg_hover_color').wpColorPicker();
        $(document).find('.ays_gpg_border_color').wpColorPicker();
        $(document).find('.ays_gallery_live_preview').hover(function () {
            $('.ays_gallery_live_preview').popover('show');
        }, function () {
            $('.ays_gallery_live_preview').popover('hide');
        });
		let current_fs, next_fs, previous_fs; //fieldsets
		let left, opacity, scale; //fieldset properties which we will animate
		let animating; //flag to prevent quick multi-click glitches

        $(document).find('.gpg_opacity_demo').css('opacity', $(document).find('.gpg_opacity_demo_val').val())
        $(document).on('input', '.gpg_opacity_demo_val', function(){
            $(document).find('.gpg_opacity_demo').css('opacity', $(this).val());
        });
        
		$(document).on('click', '.ays-add-multiple-images', function(e){
			openMediaUploader_forMultiple(e, $(this));
		});        

        setTimeout(function(){
            if($(document).find('#gallery_custom_css').length > 0){
                let CodeEditor = null;
                if(wp.codeEditor){
                    CodeEditor = wp.codeEditor.initialize($(document).find('#gallery_custom_css'), cm_gpg_settings);
                }
                if(CodeEditor !== null){
                    CodeEditor.codemirror.on('change', function(e, ev){
                        $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                        $(document).find('#gallery_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
                    });
                }

            }
        }, 500);
        $(document).find('a[href="#tab3"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#gallery_custom_css').length > 0){
                    var ays_custom_css = $(document).find('#gallery_custom_css').html();
                    if(wp.codeEditor){
                        $(document).find('#gallery_custom_css').next('.CodeMirror').remove();
                        var CodeEditor = wp.codeEditor.initialize($(document).find('#gallery_custom_css'), cm_gpg_settings);                        
                        CodeEditor.codemirror.on('change', function(e, ev){
                            $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                            $(document).find('#gallery_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
                        });
                        ays_custom_css = CodeEditor.codemirror.getValue();
                        $(document).find('#gallery_custom_css').html(ays_custom_css);
                    }
                }
            }, 500);            
        });

        $(document).find('#gallery_title').on('input', function(e){
            var val = stripHTML($(this).val());
            $(document).find('.ays_gpg_title_in_top').html(val);
        });

        $(document).click( function(e){
            create_submit_name(e);
        });

        $(document).on('submit', '#ays-gpg-form', function(e){
            create_select_category_name(e, $(this));
        });
		
		$(document).on('click', '.ays-add-video', function(e){
			openMediaUploader_forVideo(e, $(this));
		});
		
		$("#ays_admin_pagination").on('change', function(e){
			$(document).find('#ays_submit_apply').trigger("click");
		});
        
        $(".ays_gpg_sort").on('click', function(e){
            e.preventDefault();
            var page_value = $( "#ays_admin_pagination" ).val();
            if (page_value == "all") {
                var accordion_ul = $('.ays-accordion'); // your parent ul element
                accordion_ul.children().each(function(i,li){
                    accordion_ul.prepend(li)
                });                
            }else{
                var accordion_ul_avtive = $('.ays_accordion_active'); // your parent ul element
                accordion_ul_avtive.children().each(function(i,li){
                    accordion_ul_avtive.prepend(li)
                }); 
            }            
        });
		
        if($(document).find('#show_title').prop('checked')){
            $(document).find('.show_with_date').css('display', 'inline-block');
        }else{            
            $(document).find('.show_with_date').css('display', 'none');
        }
        
        if($(document).find('input.ays_hover_effect_radio:checked').val() == "simple" ){
            $(document).find('.ays_effect_simple').show();
            $(document).find('.ays_effect_dir_aware').hide();
        }
        
        if($(document).find('input.ays_hover_effect_radio:checked').val() == "dir_aware" ){
            $(document).find('.ays_effect_simple').hide();
            $(document).find('.ays_effect_dir_aware').show();
        }
        $(document).find('input.ays_hover_effect_radio').on('click', function(){
            if($(document).find('input.ays_hover_effect_radio:checked').val() == "simple" ){
                $(document).find('.ays_effect_simple').show(500);
                $(document).find('.ays_effect_dir_aware').hide(150);
            }

            if($(document).find('input.ays_hover_effect_radio:checked').val() == "dir_aware" ){
                $(document).find('.ays_effect_simple').hide(150);
                $(document).find('.ays_effect_dir_aware').show(500);
            }
        });

        // Images loading effect --AV--
        if($(document).find('input#ays_gpg_images_lazy_loading:checked').val() == "current_loaded" ){
            $(document).find('.show_load_effect').show();
            $(document).find('.ays_hide_hr').show();
        }
        
        if($(document).find('input#ays_gpg_images_global_loading:checked').val() == "all_loaded" ){
            $(document).find('.show_load_effect').hide();
            $(document).find('.ays_hide_hr').hide();
        }

        $(document).find('label#gpg_image_lazy_loading').on('click', function(){
            $(document).find('.show_load_effect').show(500);
            $(document).find('.ays_hide_hr').show(500);
        });

        $(document).find('label#gpg_image_global_loading').on('click', function(){
            $(document).find('.show_load_effect').hide(150);
            $(document).find('.ays_hide_hr').hide(150);
        });
        // ----
        
        $(document).find('.ays-category').select2();

		$(document).find('#ays-view-type').select2({
			placeholder: 'Select view'
		});
		$(document).find('#gallery_img_hover_simple').select2({
			placeholder: 'Select animation'
		});
		$(document).find('#gallery_img_hover_dir_aware').select2({
			placeholder: 'Select animation'
		});
		$(document).find('.ays_gpg_border_options > select').select2({
			placeholder: 'Select border style'
		});
        
        $(document).find('#show_title').on('click', function(){
            if($(document).find('#show_title').prop('checked')){
                $(document).find('.show_with_date').css('display', 'inline-block');
            }else{            
                $(document).find('.show_with_date').css('display', 'none');
            }
        });
        
        $(document).find('#gpg_resp_width').on('click', function(){
            if($(document).find('#gpg_resp_width').prop('checked')){
                $(document).find('.pakel3').css('display', 'none');
                $(document).find('.bacel').css('display', 'flex');
            }else{            
                $(document).find('.pakel3').css('display', 'flex');
                $(document).find('.bacel').css('display', 'none');
            }
        });
        
        
        $(document).find('input.ays_enable_disable:checked').each(function(){
            if($(this).val() == "true" ){
                $(this).parent().parent().parent().find(".ays_hidden").show();
            }else{
                $(this).parent().parent().parent().find(".ays_hidden").hide();
            }
        });
        
        $(document).find('input.ays_enable_disable').on('click', function(){
            if($(this).parent().parent().find('input.ays_enable_disable:checked').val() == "true" ){
                $(this).parent().parent().parent().find(".ays_hidden").show(500);
            }
            if($(this).parent().parent().find('input.ays_enable_disable:checked').val() == "false" ){
                $(this).parent().parent().parent().find(".ays_hidden").hide(150);
            }
        });
        
        $(document).on('click', '#ays_gpg_images_border', function(e){
            if($(document).find('#ays_gpg_images_border').prop('checked')){
                $(document).find('.ays_gpg_border_options').css('display', "inline-block");
            }else{
                $(document).find('.ays_gpg_border_options').css('display', "none");
            }
        });
        
        if($(document).find('#ays_gpg_images_border').prop('checked')){
            $(document).find('.ays_gpg_border_options').css('display', "inline-block");
        }else{
            $(document).find('.ays_gpg_border_options').css('display', "none");
        }
        $(document).find('.ays_gpg_images_border_width').on('input', function(){
            if($(this).val() > 10){
                $(this).css('box-shadow', '0px 0px 5px red');
                $(this).val(10);
            }else{
                $(this).css('box-shadow', 'none');
            }
            if($(this).val() < 0){
                $(this).val(0);
                $(this).css('box-shadow', '0px 0px 5px red');
            }else{
                $(this).css('box-shadow', 'none');
            }
        });
        
		$(document).on('click', '.ays_image_add_icon', function(e){
			openMediaUploader(e, $(this), 'ays_image_add_icon');
		});
		
		$(document).on('click', '.ays_select_all_images', function(e){            
            $(document).find('.ays_del_li').prop("checked", "true");	
            if($(document).find('.ays_bulk_del_images').prop('disabled')){
                $(document).find('.ays_bulk_del_images').removeProp('disabled');
            }
            $(this).addClass("ays_clear_images");
            $(this).removeClass("ays_select_all_images");
		});
		
		
		$(document).on('click', '.ays_clear_images', function(e){            
            $(document).find('.ays_del_li').removeProp("checked");	
            if(! $(document).find('.ays_bulk_del_images').prop('disabled')){
                $(document).find('.ays_bulk_del_images').prop('disabled', "true");
            }
            $(this).addClass("ays_select_all_images");
            $(this).removeClass("ays_clear_images");
		});
		
		$(document).on('click', '.ays_image_edit', function(e){
			openMediaUploader(e, $(this), 'ays_image_edit');
		});
		$(document).on('click', 'ul.ays-accordion li .ays_del_li', function(e){
            if($(document).find('.ays_bulk_del_images').prop('disabled')){
                $(document).find('.ays_bulk_del_images').removeProp('disabled');
            }
            if($(document).find('ul.ays-accordion li .ays_del_li:checked').length == 0){
                $(document).find('.ays_bulk_del_images').attr('disabled','disabled');
            }

		});
                 
        $(document).find('#gallery_img_hover_dir_aware').on('change', function(){
            if($(this).find("option:selected").val() == "rotate3d"){
                $(document).find('input[name="ays-gpg-images-border-radius"]').val(0);
                $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', true);
            }else{
                $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', false);
            }
        });
        
        if( $(document).find(".ays_hover_effect_radio:checked").val() == "dir_aware" && $(document).find('#gallery_img_hover_dir_aware option:selected').val() == "rotate3d" ){
            $(document).find('input[name="ays-gpg-images-border-radius"]').val(0);
            $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', true);
        }else{
            $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', false);
        }        
        
		$(document).on('click', '.ays_bulk_del_images', function(e){
            let accordion = $(document).find('ul.ays-accordion'),
				accordion_el = $(document).find('ul.ays-accordion li .ays_del_li'),
				accordion_el_length = accordion_el.length;
            accordion_el.each(function(){
                if($(this).prop('checked')){
                    $(this).parents("li").css({
                        'animation-name': 'slideOutLeft',
                        'animation-duration': '.3s'
                    });
                    let a = $(this);
                    setTimeout(function(){
                        a.parents('li').remove();
                    }, 300);
                }
            });
            setTimeout(function(){
                if($(document).find('ul.ays-accordion li').length == 0){
                    $(document).find('div.ays_admin_pages').remove();
                }
            }, 310);
            $(document).find('.ays_bulk_del_images').attr('disabled','disabled');
		});
		

		/*$(document).find('.ays-add-images').on('click', function(e){
            console.log('tutuz');
            e.preventDefault();
			let accordion = $(document).find('ul.ays-accordion'),
				accordion_el = $(document).find('ul.ays-accordion li'),
				accordion_el_length = accordion_el.length,
                ays_title_tooltip = $(document).find("#ays_image_lang_title").val(),
                ays_alt_tooltip = $(document).find("#ays_image_lang_alt").val(),
                ays_desc_tooltip = $(document).find("#ays_image_lang_desc").val(),
                ays_url_tooltip = $(document).find("#ays_image_lang_url").val(),
                noimage_path = $(document).find('#noimage_path').val();
                if(accordion.length > 1){
                    accordion = $(document).find('ul.ays-accordion.ays_accordion_active');
                }
				let newLi = '<li>' +
                    '           <input type="hidden" name="ays-image-path[]">' +
					'			<div class="ays-image-attributes">' +
                    '               <div class="ays-move-images_div"><i class="ays-move-images"></i></div>' +
                    '               <div class="ays_image_div">' +
                    '                   <div class="ays_image_add_div">' +
                    '                       <span class="ays_ays_img"></span>' +
                    '                       <div class="ays_image_add_icon"><i class="ays-upload-btn"></i></div>' +
                    '                   </div>' +
                    '                   <div class="ays_image_thumb" style="display: none;">' +
                    '                       <div class="ays_image_edit_div"><i class="ays_image_edit"></i></div>' +
                    '                       <div class="ays_image_thumb_img"><img></div>' +                    
                    '                   </div>' +
                    '               </div>' + 
                    '               <div class="ays_image_attr_item_cat">' +
                    '                    <div class="ays_image_attr_item_parent">' +
                    '                       <div class="ays_image_attr_item">' +
                    '                   <label>Image title'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_title_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
					'	                <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="Image title"/>' +
                    '                   </div>' +
                    '                   <div class="ays_image_attr_item">' +
                    '                   <label>Image alt'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_alt_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
                    '                   <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="Image alt"/>' +
                    '                   </div>' +
                    '                   <div class="ays_image_attr_item">' +
                    '                   <label>Image description'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_desc_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
                    '                   <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="Image description"/>' +
                    '                   </div>' +
                    '                   <div class="ays_image_attr_item">' +
                    '                   <label>URL'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_url_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
                    '                   <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="URL"/>' +
                    '                   </div>' +
                    '               </div>' +

                    '               <input type="hidden" name="ays-image-date[]" class="ays_img_date"/>' +
                    '               <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>'+
                    '               <div class="ays-delete-image_div"><i class="ays-delete-image"></i></div>' +
					'           </div>' +                    
					'         </li>';

				accordion.prepend(newLi);
                $('[data-toggle="tooltip"]').tooltip();
		});*/


        $('.open-lightbox').on('click', function (e) {
            e.preventDefault();
            var image = $(this).attr('href');
            $('html').addClass('no-scroll');
            $('.ays-gpg-row ').append('<div class="lightbox-opened"><img src="' + image + '"></div>');
        });

        $('body').on('click', '.lightbox-opened', function () {
            $('html').removeClass('no-scroll');
            $('.lightbox-opened').remove();
        });
        
        $(document).find('ul.ays-accordion').sortable({
            handle: '.ays-move-images',
			axis: 'y',
			opacity: 0.8,
			placeholder: 'clone',
            cursor: 'move'
        });

		$(document).on('click', '.ays-delete-image', function(){
            $(this).parent().parent().parent().css({
                'animation-name': 'slideOutLeft',
                'animation-duration': '.3s'
            });
            var a = $(this);
            setTimeout(function(){
                a.parent().parent().parent().remove();
            }, 300);
		});

        $(document).on('click', '.delete a[href]', function(){
            return confirm('Do you want to delete?');
        });

        function openMediaUploader(e,element, where){
            e.preventDefault();
            let aysGalleryUploader = wp.media.frames.items = wp.media({
                title: 'Upload image',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: ['image']
                },
                multiple: false,
                frame: 'select',
            }).on('select', function(e){
				if(where == 'ays_image_add_icon'){
                    var state = aysGalleryUploader.state();
                    var selection = selection || state.get('selection');
                    if (! selection) return;
                    
                    var attachment = selection.first();
                    var display = state.display(attachment).toJSON();
                    attachment = attachment.toJSON();
                    
                    var d = new Date()
                    var date = d.getTime();
                    date = Math.floor(date/1000);

                    var imgurl = attachment.url;//sizes[display.size].url;
                    var thumbnail_imgurl = attachment.sizes['thumbnail'].url;

					element.parent().parent().children('.ays_image_thumb').children('.ays_image_thumb_img').children('img').attr('src', thumbnail_imgurl);
                    element.parent().parent().children('.ays_image_thumb').css({'display':'block','position':'relative'});//av
					element.parent().parent().children('.ays_image_thumb').children('.ays_image_edit_div').css('position','absolute');//av
                    element.parent().parent().parent().parent().children('input[type="hidden"]').val(imgurl);                    
                    element.parent().parent().parent().find('.ays_img_title').val(attachment.title);
                    element.parent().parent().parent().find('.ays_img_alt').val(attachment.title);
                    element.parent().parent().parent().find('.ays_img_date').val(date);
					element.parent().parent().children('.ays_image_add_div').remove();   

				}else{
					if(where == 'ays_image_edit'){	
                        var state = aysGalleryUploader.state();
                        var selection = selection || state.get('selection');
                        if (! selection) return;

                        var attachment = selection.first();
                        var display = state.display(attachment).toJSON();

                        attachment = attachment.toJSON();
                        
                        var d = new Date()
                        var date = d.getTime();
                        date = Math.floor(date/1000);
                        
                        var imgurl = attachment.url;//sizes[display.size].url;
                        var thumbnail_imgurl = attachment.sizes['thumbnail'].url;

						element.parent().parent().children('.ays_image_thumb_img').children('img').attr('src', thumbnail_imgurl);
						element.parent().parent().parent().parent().parent().children('input[type="hidden"]').val(imgurl);
                        element.parent().parent().parent().parent().children('.ays_image_attr_item').find('.ays_img_title').val(attachment.title);
                        element.parent().parent().parent().parent().children('.ays_image_attr_item').find('.ays_img_alt').val(attachment.title);
                        element.parent().parent().parent().parent().find('.ays_img_date').val(date);
					    element.parent().parent().children('ays_image_thumb_img').children('img').css('background-image', 'none');
                        
					}
				}
			}).open();
            return false;

        }
        
        function openMediaUploader_forVideo(e,element){
            e.preventDefault();
            let aysUploader = wp.media.frames.aysUploader = wp.media({
                title: 'Upload video',
                button: {
                    text: 'Upload'
                },
                multiple: false,
                library: {
                    type: ['video']
                },
                frame:    "video",
                state:    "video-details"
            }).on('select', function() {
                var state = aysUploader.state();
                var selection = selection || state.get('selection');
                if (! selection) return;

                var attachment = selection.first();
                var display = state.display(selection).toJSON();

                var attachment = selection.toJSON();
			}).open();
            return;
        }

        function create_submit_name(e){
            var submit_name = $(document).find('#ays_submit_name');
            var element_type = e.target.getAttribute('gpg_submit_name');
            if (element_type !== null) {
                submit_name.attr('name', element_type);
            }
        }

        function create_select_category_name(e,element){
            e.preventDefault();
            var sel_cat_val = '';
            var sel_cat = $(document).find('select.ays-category');
            sel_cat.each(function(){
                if ($(this).val() !== null) {
                    sel_cat_val = $(this).val().join();
                }else{
                    sel_cat_val = '';
                }

                var select_name =  $(this).parent().find('.for_select_name');
                select_name.val(sel_cat_val);
            });
            
            $(document).find("#ays-gpg-form")[0].submit();
        }

        function openMediaUploader_forMultiple(e,element){
            e.preventDefault();
            let aysUploader = wp.media.frames.aysUploader = wp.media({
                title: 'Upload images',
                button: {
                    text: 'Upload'
                },
                multiple: true,
                library: {
                    type: ['image']
                },
                frame:    "select"
            }).on('select', function() {
                var state = aysUploader.state();
                var selection = selection || state.get('selection');
                if (! selection) return;

                var attachment = selection.first();
                var display = state.display(selection).toJSON();

                var attachment = selection.toJSON();
                var d = new Date()
                var date = d.getTime();
                date = Math.floor(date/1000);

                for(let i=0; i<attachment.length; i++){
                    let accordion = $(document).find('ul.ays-accordion'),
                    accordion_el = $(document).find('ul.ays-accordion li'),
                    ays_title_tooltip = $(document).find("#ays_image_lang_title").val(),
                    ays_alt_tooltip = $(document).find("#ays_image_lang_alt").val(),
                    ays_desc_tooltip = $(document).find("#ays_image_lang_desc").val(),
                    ays_url_tooltip = $(document).find("#ays_image_lang_url").val(),
                    ays_img_cat_tooltip = $(document).find("#ays_image_cat").val(),
                    accordion_el_length = accordion_el.length;
                        if(accordion.length > 1){
                            accordion = $(document).find('ul.ays-accordion.ays_accordion_active');
                        }
                        let newListImage = '<li class="ays-accordion_li">' +
                        '           <input type="hidden" name="ays-image-path[]" value="'+attachment[i].url+'">' +
                        '           <div class="ays-image-attributes">' +
                        '               <div class="ays-move-images_div"><i class="ays-move-images"></i></div>' +
                        '               <div class="ays_image_div">' +                        
                        '                   <div class="ays_image_thumb" style="display: block; position: relative;">' +
                        '                       <div class="ays_image_edit_div" style="position: absolute;"><i class="ays_image_edit"></i></div>' +
                        '                       <div class="ays_image_thumb_img"><img class="ays_ays_img" alt="" src="'+attachment[i].url+'"></div>' +                    
                        '                   </div>' +
                        '               </div>' + 
                        '               <div class="ays_image_attr_item_cat">' +
                            '               <div class="ays_image_attr_item_parent">' +
                            '                   <div class="ays_image_attr_item">' +
                        '                   <label>Title'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_title_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_title" type="text" name="ays-image-title[]" value="'+(attachment[i].title)+'" placeholder="Image title"/>' +
                        '               </div>' +
                        '               <div class="ays_image_attr_item">' +
                        '                   <label>Alt'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_alt_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_alt" type="text" name="ays-image-alt[]" value="'+(attachment[i].title)+'" placeholder="Image alt"/>' +
                        '               </div>' +
                        '               <div class="ays_image_attr_item">' +
                        '                   <label>Description'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_desc_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="Image description"/>' +
                        '               </div>' +
                        '               <div class="ays_image_attr_item">' +
                        '                   <label>URL'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_url_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="URL"/>' +
                        '                   </div>' +
                        '               </div>' +
                        '               <div class="ays_image_cat">' +
                        '                   <label>Image Category'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_img_cat_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <select class="ays-category form-control" multiple="multiple">';
                        
                            for (var j = 0; j < ays_gpg_admin['categories'].length; j++) {
                                newListImage += '<option value="'+ays_gpg_admin['categories'][j]['id']+'">'+ays_gpg_admin['categories'][j]['title']+'</option>';
                            }

                        newListImage +='</select>' +
                        '<input type="hidden" class="for_select_name" name="ays_gallery_category[]">' +
                        '                </div>' +
                        '           </div>' +
                        '               <input type="hidden" name="ays-image-date[]" class="ays_img_date" value="'+(date)+'"/>' +
                        '               <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>'+
                        '               <div class="ays-delete-image_div"><i class="ays-delete-image"></i></div>' +
                        '           </div>' +
                        '         </li>';

                        accordion.prepend(newListImage);
                        $(document).find('.ays-category').select2();
                        $('[data-toggle="tooltip"]').tooltip();
                }
			}).open();
            return;

        }
        if($(document).find('input.ays-view-type:checked').val() == "grid" || 
           $(document).find('input.ays-view-type:checked').val() == "masonry"){
            $(document).find('#ays-columns-count').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
        }else{
            $(document).find('#ays-columns-count').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            setTimeout(function(){ $(document).find('#ays-columns-count').css({'display': 'none'}); }, 480);

        }

        if($(document).find('input.ays-view-type:checked').val() == "grid"){
            if($(document).find('#gpg_resp_width').prop('checked')){
                $(document).find('#ays_height_width_ratio').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
            }else{
                $(document).find('#ays-thumb-height').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
            }
            
            $(document).find('#ays_gpg_resp_width').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
        }else{
            $(document).find('#ays-thumb-height').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            $(document).find('#ays_height_width_ratio').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            $(document).find('#ays_gpg_resp_width').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            setTimeout(function(){ $(document).find('#ays-thumb-height').css({'display': 'none'}); }, 480);
            setTimeout(function(){ $(document).find('#ays_height_width_ratio').css({'display': 'none'}); }, 480);
            setTimeout(function(){ $(document).find('#ays_gpg_resp_width').css({'display': 'none'}); }, 480);
        }        
        
        if($(document).find('input.ays-view-type:checked').val() == 'masonry'){
            $(document).find('.ays_hover_effect_radio_simple').prop('checked', true);
            $(document).find('.ays_hover_effect_radio_dir_aware').removeProp('checked');
            $(document).find('.ays_effect_simple').show(500);
            $(document).find('.ays_effect_dir_aware').hide(150);                    
            $(document).find('.ays_hover_effect_radio_dir_aware').prop('disabled', true);
            $(document).find('.ays_hover_effect_radio_dir_aware').parent().css('color', '#ccc');
        }
        $(document).find('a[data-tab="tab2"]').on('click', function(){
            if($(this).find('span.badge').length > 0){
                $(this).find('span.badge').remove();
                $(document).find('#ays-columns-count')[0].scrollIntoView({block: "center", behavior: "smooth"});
            }
        });
        
        $(document).find('input.ays-view-type').on('click', function(){
            if($(document).find('input.ays-view-type:checked').val() == "grid" || 
               $(document).find('input.ays-view-type:checked').val() == "masonry"){
                $(document).find('#ays-columns-count').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});                
            }else{
                $(document).find('#ays-columns-count').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                setTimeout(function(){ $(document).find('#ays-columns-count').css({'display': 'none'}); }, 480);
            }

            if($(document).find('input.ays-view-type:checked').val() == "grid" ){
                if($(document).find('#gpg_resp_width').prop('checked')){
                    $(document).find('#ays_height_width_ratio').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
                }else{
                    $(document).find('#ays-thumb-height').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
                }
                $(document).find('#ays_gpg_resp_width').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
                $(document).find('#ays-columns-count + hr').css({'display': 'block'});
                $(document).find('.hr_pakel').css({'display': 'block'});
            }else{
                $(document).find('#ays-thumb-height').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                $(document).find('#ays_height_width_ratio').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                $(document).find('#ays_gpg_resp_width').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                setTimeout(function(){ $(document).find('#ays-thumb-height').css({'display': 'none'}); }, 480);
                setTimeout(function(){ $(document).find('#ays_height_width_ratio').css({'display': 'none'}); }, 480);
                setTimeout(function(){ $(document).find('#ays_gpg_resp_width').css({'display': 'none'}); }, 480);
                $(document).find('.hr_pakel').css({'display': 'none'});
            }

            if($(document).find('input.ays-view-type:checked').val() == "mosaic"){
                $(document).find('#ays-columns-count + hr').css({'display': 'none'});
                $(document).find('.pakel').css({'display': 'none'});
            }else{
                $(document).find('#ays-columns-count + hr').css({'display': 'block'});
                $(document).find('.pakel').css({'display': 'block'});            
            }
            
            if($(document).find('input.ays-view-type:checked').val() == "masonry" ){
                $(document).find('.ays_hover_effect_radio_simple').prop('checked', true);
                $(document).find('.ays_hover_effect_radio_dir_aware').removeProp('checked');
                $(document).find('.ays_effect_simple').show(500);
                $(document).find('.ays_effect_dir_aware').hide(150);
                $(document).find('.ays_hover_effect_radio_dir_aware').prop('disabled', true);
                $(document).find('.ays_hover_effect_radio_dir_aware').parent().css('color', '#ccc');
                $(document).find('#ays-columns-count + hr').css({'display': 'none'});
            }else{            
                $(document).find('.ays_hover_effect_radio_dir_aware').removeProp('disabled');
                $(document).find('.ays_hover_effect_radio_dir_aware').parent().css('color', '#000');
            }
        });
        
        $('[data-toggle="tooltip"]').tooltip();
        
        $(document).on('click', '.ays_live_preview_close', function(){
            $(document.body).css('overflow', 'auto');
            $(document).find('div.ays_gallery_live_preview_popup').css({
                animation: 'fadeOut .5s'
            });
            setTimeout(function(){
                $(document).find('div.ays_gallery_live_preview_popup').css({
                    display: 'none'
                });
            },450);
        });
        $(document).on('click', '.ays_gallery_live_preview', function(){
            
            $(document.body).css('overflow', 'hidden');
            var ays_gallery_containers = document.getElementsByClassName('ays_gallery_container');
            var ays_gallery_container;
            
            for(var ays_i = 0; ays_i < ays_gallery_containers.length; ays_i++){
               do{
                    ays_gallery_container = ays_gallery_containers[ays_i].parentElement.parentElement;
                   if(ays_gallery_container.style.position === 'relative'){
                       ays_gallery_container.style.position = 'static';
                   }
                }
                while(ays_gallery_container.tagName == 'body');
                
            }
            
            let popup_view = $(document).find('div.ays_gallery_live_preview_popup .ays_gallery_container'),
                accordion_el = $(document).find('ul.ays-accordion li.ays-accordion_li'),
                accordion_el_length = accordion_el.length,
                ays_admin_url = $(document).find('#ays_gpg_admin_url').val(),
                noimage_path = $(document).find('#noimage_path').val(),
                gallery_title = $(document).find('#gallery_title').val(),
                gallery_desc = $(document).find('#gallery_description').val(),
                gallery_title_show = $(document).find('input[name="ays_gpg_title_show"]').prop('checked'),
                gallery_desc_show = $(document).find('input[name="ays_gpg_desc_show"]').prop('checked');
            let view_type = $(document).find('input.ays-view-type:checked').val(),
                column_count = $(document).find('input[name="ays-columns-count"]').val(),
                type_class, type_column_class, type_mosaic_class, type_masonry_class, $hover_icon, $ays_gpg_lazy_load, $columns, 
                $show_with_date = $(document).find("#show_with_date").prop('checked'), $show_title_in_hover, $ays_show_title,
                $ays_show_with_date, $show_title_on = $(document).find('.ays_gpg_show_title_on:checked').first().val(),
                $show_title = $(document).find('#show_title').prop('checked'),
                $ays_hover_icon = $(document).find('input[name="ays-gpg-image-hover-icon"]:checked').first().val(),
                $images_loading = $(document).find('input[name="ays_images_loading"]:checked').first().val(),
                $images_path = $(document).find('input[name="ays-image-path[]"]'),
                $images_title = $(document).find('input[name="ays-image-title[]"]'),
                $images_desc = $(document).find('input[name="ays-image-description[]"]'),
                $images_alt = $(document).find('input[name="ays-image-alt[]"]'),
                $images_url = $(document).find('input[name="ays-image-url[]"]'),
                $hover_effect = $(document).find('#gallery_img_hover_simple').val(),
                $hover_out_effect, $image_dates = $(document).find('.ays_img_date'),
                $images_distance = $(document).find('input[name="ays-gpg-images-distance"]').val(),
                $hover_zoom = $(document).find('input[name="ays_gpg_hover_zoom"]:checked').first().val(),
                $hover_opacity = $(document).find('.gpg_opacity_demo_val').val(),
                $images_border_radius = $(document).find('input[name="ays-gpg-images-border-radius"]').val(),
                $ays_images_hover_dir_aware = $(document).find('#gallery_img_hover_dir_aware').val(),
                $ays_images_hover_effect = $(document).find('input[name="ays_images_hover_effect"]:checked').val(),
                $ays_gpg_loader = $(document).find('input[name="ays_gpg_loader"]:checked'),
                $gallery_width = $(document).find('#gallery_width').val();
                if($gallery_width == 0 || $gallery_width == NaN || $gallery_width == null || $gallery_width == false){
                    $gallery_width = "90%";
                }
                popup_view.css('width',$gallery_width);
            
                $hover_out_effect = $hover_effect.split('');
                $hover_out_effect.splice($hover_out_effect.indexOf('I'),2,"O",'u','t');
                $hover_out_effect = $hover_out_effect.join('');
            if (column_count == 0) {
                column_count = 3;
            }
            $columns = 100 / column_count;
            if($images_loading == 'all_loaded'){
                let $ays_images_all_loaded;                
                $ays_images_all_loaded = "<div class='gpg_loader'>"+$ays_gpg_loader.next()[0].outerHTML+"</div>";
                $(document).find('.ays_gallery_live_preview_popup').prepend($ays_images_all_loaded);
            }
            switch(view_type){
                case 'grid':
                    type_class = 'ays_grid_row';
                    type_column_class = 'ays_grid_column';
                    break;
                case 'mosaic':                        
                    type_class = 'mosaic';
                    type_mosaic_class = 'item withImage ';
                    type_column_class = 'ays_mosaic_column_item';
                    break;
                case 'masonry':                        
                    type_class = 'ays_masonry_grid';
                    type_masonry_class = 'ays_masonry_grid-item ';
                    type_column_class = 'ays_masonry_item';
                    break;
            }            
            switch($ays_hover_icon){
                case 'none':
                    $hover_icon = "";
                    break;
                case 'search_plus':
                    $hover_icon = "<i class='fas fa-search-plus'></i>";
                    break;
                case 'search':
                    $hover_icon = "<i class='fas fa-search'></i>";
                    break;
                case 'plus':
                    $hover_icon = "<i class='fas fa-plus'></i>";
                    break;
                case 'plus_circle':
                    $hover_icon = "<i class='fas fa-plus-circle'></i>";
                    break;
                case 'plus_square_fas': 
                    $hover_icon = "<i class='fas fa-plus-square'></i>";
                    break;
                case 'plus_square_far':
                    $hover_icon = "<i class='far fa-plus-square'></i>";
                    break;
                case 'expand':
                    $hover_icon = "<i class='fas fa-expand'></i>";
                    break;
                case 'image_fas':
                    $hover_icon = "<i class='fas fa-image'></i>";
                    break;
                case 'image_far':
                    $hover_icon = "<i class='far fa-image'></i>";
                    break;
                case 'images_fas':
                    $hover_icon = "<i class='fas fa-images'></i>";
                    break;
                case 'images_far':
                    $hover_icon = "<i class='far fa-images'></i>";
                    break;
                case 'eye_fas':
                    $hover_icon = "<i class='fas fa-eye'></i>";
                    break;
                case 'eye_far':
                    $hover_icon = "<i class='far fa-eye'></i>";
                    break;
                case 'camera_retro':
                    $hover_icon = "<i class='fas fa-camera-retro'></i>";
                    break;
                case 'camera':
                    $hover_icon = "<i class='fas fa-camera'></i>";
                    break;
                default:
                    $hover_icon = "<i class='fas fa-search-plus'></i>";
                    break;
            }
            if(view_type == 'mosaic'){
                var mosaic_clear = "style='clear:both;'";
            }else{
                var mosaic_clear = "";
            }
            let ays_popup_view = "<div class='"+type_class+"' "+mosaic_clear+">";
            for(let i = 0; i < accordion_el_length; i++){
                if($show_title){
                    if($show_with_date){
                        let iamgeDate = new Date(null);
                        iamgeDate.setTime(parseInt($image_dates[i].value)*1000);
                        $ays_show_with_date = "<span>"+iamgeDate.toLocaleString()+"</span>";
                    }else{
                        $ays_show_with_date = "";
                    }
                    $ays_show_title = "<div class='ays_image_title'><span>"+$images_title[i].value+"</span>"+$ays_show_with_date+"</div>";
                }else{
                    $ays_show_title = '';
                }
                if($images_url[i].value == ""){
                    var $images_url_i = "";
                }else{
                    var $images_url_i = "<button type='button' class='ays_image_url'><i class='fas fa-link'></i></button>";
                }
                
                
                if($show_title_on == 'gallery_image'){
                    $show_title_in_hover = "<div class='ays_hover_mask animated'><div>"+$hover_icon+$images_url_i+"</div></div>"+$ays_show_title;
                }else{
                    if($show_title_on == 'image_hover'){
                        $show_title_in_hover = "<div class='ays_hover_mask animated'><div>"+$hover_icon+$images_url_i+"</div> "+$ays_show_title+"</div>";
                    }
                }
                
                if(view_type == 'grid' || view_type == 'masonry'){
                    var grid_column_width = "width: "+($columns-2)+"%;";
                    var masonry_column_margin = "margin-bottom: "+(parseInt($images_distance))+"px;";
                }else{
                    var grid_column_width = "";
                    var masonry_column_margin = "";
                }
                let newColumn = "<div class='"+type_mosaic_class+" "+type_masonry_class+" "+type_column_class+"' style='border-radius:"+$images_border_radius+"px; "+grid_column_width+"; "+masonry_column_margin+"'><a href='javascript:void(0);'><div class='ays_image_loading_div'><img src='"+ays_admin_url+"images/flower.svg'></div><img src='"+$images_path[i].value+"' alt='"+$images_alt[i].value+"' title='"+$images_title[i].value+"'/>"+$show_title_in_hover+"</a></div>";
                ays_popup_view += newColumn;
            }
            ays_popup_view += "</div>";
            if(gallery_title_show){
                var show_gallery_title = "<h2 class='ays_gallery_title'>"+gallery_title+"</h2>";
            }else{
                var show_gallery_title = '';
            }
            if(gallery_desc_show){
                var show_gallery_desc = "<h4 class='ays_gallery_description'>"+gallery_desc+"</h4>";
            }else{
                var show_gallery_desc = '';
            }
            let ays_gallery_header = "<div class='ays_gallery_header'>"+show_gallery_title+" "+show_gallery_desc+"</div>";
            popup_view.html(ays_gallery_header);
            popup_view.append(ays_popup_view);
            
            if($ays_images_hover_effect == "simple"){
                $(document).find('.'+type_column_class).hover(function(){
                    $(this).find('.ays_hover_mask').css('animation-name', $hover_effect);
                    $(this).find('.ays_hover_mask').css('animation-duration', '.5s');
                    if($hover_zoom == 'yes'){
                        $(this).find('a > img').css('transform', 'scale(1.15)');
                    }
                }, 
                function(){
                    $(this).find('.ays_hover_mask').css('animation-name', $hover_out_effect);
                    $(this).find('.ays_hover_mask').css('animation-duration', '.5s');                
                    if($hover_zoom == 'yes'){
                        $(this).find('a > img').css('transform', 'scale(1)');
                    }
                });
            }else{
            if($ays_images_hover_effect == "dir_aware"){
                if($ays_images_hover_dir_aware == "slide"){
                    $(document).find('.'+type_column_class).hover(function(e){
                        var ays_overlay = $(this).find('.ays_hover_mask');
                        let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                        switch(parseInt(ays_hover_dir)) {
                             case 0:
                                ays_overlay.css('display', 'flex');
                                ays_overlay.css('animation', 'slideInDown .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                             case 1:
                                ays_overlay.css('display', 'flex')
                                ays_overlay.css('animation', 'slideInRight .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                             case 2:
                                ays_overlay.css('display', 'flex')
                                ays_overlay.css('animation', 'slideInUp .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                             case 3:
                                ays_overlay.css('display', 'flex')
                                ays_overlay.css('animation', 'slideInLeft .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                        }

                    },
                   function(e){
                        var ays_overlay = $(this).find('.ays_hover_mask');
                        let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                        switch(parseInt(ays_hover_dir)) {
                             case 0:
                                ays_overlay.css('animation', 'slideOutUp .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none');}, 250);
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                             case 1:
                                ays_overlay.css('animation', 'slideOutRight .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none');}, 250);
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                             case 2:
                                ays_overlay.css('animation', 'slideOutDown .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none');}, 250);
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                             case 3:
                                ays_overlay.css('animation', 'slideOutLeft .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none'); }, 250)
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                        }
                    });
                }else{
                    if($ays_images_hover_dir_aware == "rotate3d"){
                        $(document).find('.'+type_column_class).hover(function(e){
                            let ays_overlay = $(this).find('div.ays_hover_mask');
                            let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                            switch(parseInt(ays_hover_dir)) {
                                 case 0:
                                    ays_overlay.css('display', 'flex');
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-top');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                                 case 1:
                                    ays_overlay.css('display', 'flex')
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-right');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                                 case 2:
                                    ays_overlay.css('display', 'flex')
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-bottom');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                                 case 3:
                                    ays_overlay.css('display', 'flex')
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-left');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                            }

                        },
                       function(e){
                            let ays_overlay = $(this).find('div.ays_hover_mask');
                            let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                            switch(parseInt(ays_hover_dir)) {
                                 case 0:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-top');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0');}, 350);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                                 case 1:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-right');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0');}, 350);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                                 case 2:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-bottom');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0');}, 350);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                                 case 3:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-left');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0'); }, 570);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                            }
                        });
                    }
                }
            }
            }
            
            $(document).find('.ays_gallery_container .mosaic').Mosaic({
                innerGap: parseInt($images_distance)
            });
            
            var aysgrid = $(document).find('.ays_masonry_grid').masonry({
                percentPosition: false,
                itemSelector: '.ays_masonry_grid-item',
                columnWidth: '.ays_masonry_item',
                transitionDuration: '1s',
                gutter: parseInt($images_distance)

            });
            
            $(document).find('.ays_hover_mask').css('background-color', 'rgba(0,0,0,'+$hover_opacity+')');
            
            $(document).find('.gpg_loader').css({'display': 'flex', 'animation-name': 'fadeIn'});
            if($images_loading == 'all_loaded'){
                $(document).find('.gpg_loader').css({'display': 'flex', 'animation-name': 'fadeIn'});
                $('.ays_gallery_container').css({'display': 'none'});
                var ays_duration = Math.floor(Math.random()*1000)+700;
                setTimeout(function(){
                    $('.ays_gallery_container').css({'display': 'block', 'animation-name': 'fadeIn'});
                    $(document).find('.gpg_loader').css({'display': 'none', 'animation-name': 'fadeOut'});
                    $(document).find('.ays_gallery_container .mosaic').Mosaic({
                        innerGap: parseInt($images_distance)
                    });
                    aysgrid.masonry('layout');
                },ays_duration);
            }
            if($images_loading == 'current_loaded'){
                $(document).find('.ays_gallery_container a > img').each( function( instance, image ) {
                    var ays_duration = Math.floor(Math.random()*2000)+700;
                    setTimeout(function(){
                        $(image).parent().find('.ays_image_loading_div').css({
                            'opacity': '1',
                            'animation-name': 'fadeOut',
                            'animation-duration': '1.2s',
                        });
                        setTimeout(function(){                                    
                            $(image).parent().find('.ays_image_loading_div').css({
                                'display': 'none'
                            });                                  
                            $(image).parent().find('div.ays_hover_mask').css({
                                'display': 'flex'
                            });
                            $(image).css({
                                'opacity': '1',
                                'display': 'block',
                                'animation': 'fadeInUp .5s',
                                'z-index': 10000,
                            });
                        },400);
                        
                        $(document).find('.ays_gallery_container .mosaic').Mosaic({
                            innerGap: parseInt($images_distance)
                        });
                        aysgrid.masonry('layout');
                    }, ays_duration);
                });
            }else{
                $(document).find('.ays_image_loading_div').css({
                    'display': 'none',
                });
            }
            
            $(document).find('div.ays_gallery_live_preview_popup').css({
                display: 'block',
                animation: 'fadeIn .5s'
            });
            $(document).find('.ays_gallery_container .mosaic').Mosaic({
                innerGap: parseInt($images_distance)
            });
        });
    });

        // Gallery form submit
        // Checking the issues
        $(document).find('#ays-gpg-category-form').on('submit', function(e){
            
            if($(document).find('#ays-gpg-title').val() == ''){
                $(document).find('#ays-gpg-title').val('Gallery').trigger('input');
            }
            var $this = $(this)[0];
            if($(document).find('#ays-gpg-title').val() != ""){
                $this.submit();
            }else{
                e.preventDefault();
                $this.submit();
            }
        });

})( jQuery );

function ays_getDirectionKey(ev, obj) {
    let ays_w = obj.offsetWidth,
        ays_h = obj.offsetHeight,
        ays_x = (ev.pageX - obj.offsetLeft - (ays_w / 2) * (ays_w > ays_h ? (ays_h / ays_w) : 1)),
        ays_y = (ev.pageY - obj.offsetTop - (ays_h / 2) * (ays_h > ays_w ? (ays_w / ays_h) : 1)),
        ays_d = Math.round( Math.atan2(ays_y, ays_x) / 1.57079633 + 5 ) % 4;
    return ays_d;
}

function selectElementContents(el) {
    if (window.getSelection && document.createRange) {
        var sel = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(el);
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (document.selection && document.body.createTextRange) {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.select();
    }
}

function stripHTML(dirtyString) {
  var container = document.createElement('div');
  var text = document.createTextNode(dirtyString);
  container.appendChild(text);
  return container.innerHTML; // innerHTML will be a xss safe string
}