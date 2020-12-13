<?php
global $wpdb;
if (!isset($_COOKIE['ays_gpg_page_tab_free'])) {
    setcookie('ays_gpg_page_tab_free', 'tab_0', time() + 3600);
}
if(isset($_GET['ays_gpg_settings_tab'])){
    $ays_gpg_tab = $_GET['ays_gpg_settings_tab'];
}else{
    $ays_gpg_tab = 'tab1';
}
$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
$heading = '';
$id = ( isset( $_GET['gallery'] ) ) ? absint( intval( $_GET['gallery'] ) ) : null;
$g_options = array(
    'columns_count'         => '3',
    'view_type'             => 'grid',
    "border_radius"         => "0",
    "admin_pagination"      => "all",
    "hover_zoom"            => "no",
    "show_gal_title"        => "on",
    "show_gal_desc"         => "on",
    "images_hover_effect"   => "simple",
    "hover_dir_aware"       => "slide",
    "images_border"         => "",
    "images_border_width"   => "1",
    "images_border_style"   => "solid",
    "images_border_color"   => "#000000",
    "hover_effect"          => "fadeIn",
    "hover_opacity"         => "0.5",
    "image_sizes"           => "full_size",
    "lightbox_color"        => "rgba(0,0,0,0)",
    "images_orderby"        => "noordering",
    "hover_icon"            => "search_plus",
    "show_title"            => "",
    "show_title_on"         => "gallery_image",
    "title_position"        => "bottom",
    "show_with_date"        => "",
    "images_distance"       => "5",
    "images_loading"        => "current_loaded",
    "gallery_loader"        => "flower",
    "hover_icon_size"       => "20",
    "thumbnail_title_size"  => "12",
    "thumb_height_mobile"   => "170",
    "thumb_height_desktop"  => "260",
    "enable_light_box"      => "off",
    "ays_filter_cat"        => "off",
    "filter_thubnail_opt"   => "none",
    "ordering_asc_desc"     => "ascending",
    "custom_class"          => ""
);
$g_l_options = array(
    "lightbox_counter"      => "true",
    "lightbox_autoplay"     => "true",
    "lb_pause"              => "5000",
    "lb_show_caption"       => "true",
    "filter_lightbox_opt"   => "none",
);
$gallery = array(
    "id"                => "",
    "title"             => "Demo title",
    "description"       => "Demo description",
    "images"            => "",
    "images_titles"     => "",
    "images_descs"      => "",
    "images_alts"       => "",
    "images_urls"       => "",
    "categories_id"     => "",
    "width"             => "",
    "height"            => "1000",
    "options"           => json_encode($g_options,true),
    "lightbox_options"  => json_encode($g_l_options,true),
    "custom_css"        => "",
    "images_dates"      => "",
);
switch( $action ) {
    case 'add':
        $heading = __('Add new gallery', $this->plugin_name);
        break;
    case 'edit':
        $heading = __('Edit gallery', $this->plugin_name);
        $gallery = $this->gallery_obj->get_gallery_by_id($id);
        break;
}

if(isset($_POST["ays-submit"]) || isset($_POST["ays-submit-top"])){
    $_POST["id"] = $id;
    $this->gallery_obj->add_or_edit_gallery($_POST);
}
if(isset($_POST["ays-apply"]) || isset($_POST["ays-apply-top"])){
    $_POST["id"] = $id;
    $_POST["submit_type"] = 'apply';
    $this->gallery_obj->add_or_edit_gallery($_POST);
}
$this_site_path = trim(get_site_url(), "https:");
$gal_options            = json_decode($gallery['options'], true);
$gal_lightbox_options   = json_decode($gallery['lightbox_options'], true);

$show_gal_title = (!isset($gal_options['show_gal_title'])) ? 'on' : $gal_options['show_gal_title'];
$show_gal_desc = (!isset($gal_options['show_gal_desc'])) ? 'on' : $gal_options['show_gal_desc'];

$admin_pagination = (!isset($gal_options['admin_pagination']) ||
                     $gal_options['admin_pagination'] == null ||
                     $gal_options['admin_pagination'] == '') ? "all" : $gal_options['admin_pagination'];
$ays_hover_zoom = (!isset($gal_options['hover_zoom']) ||
                   $gal_options['hover_zoom'] == null ||
                   $gal_options['hover_zoom'] == '') ? "no" : $gal_options['hover_zoom'];
$ays_hover_scale = (!isset($gal_options['hover_scale']) ||
                   $gal_options['hover_scale'] == null ||
                   $gal_options['hover_scale'] == '') ? "no" : $gal_options['hover_scale'];
$show_thumb_title_on = (!isset($gal_options['show_title_on']) || 
                       $gal_options['show_title_on'] == false ||
                       $gal_options['show_title_on'] == "") ? "gallery_image" : $gal_options['show_title_on'];
$thumb_title_position = (!isset($gal_options['title_position']) || 
                       $gal_options['title_position'] == false ||
                       $gal_options['title_position'] == "") ? "bottom" : $gal_options['title_position'];
$ays_images_hover_effect = (!isset($gal_options['images_hover_effect']) || 
                            $gal_options['images_hover_effect'] == '' ||
                            $gal_options['images_hover_effect'] == null) ? 'simple' : $gal_options['images_hover_effect'];
$ays_images_hover_dir_aware = (!isset($gal_options['hover_dir_aware']) ||
                              $gal_options['hover_dir_aware'] == null ||
                              $gal_options['hover_dir_aware'] == "") ? "slide" : $gal_options['hover_dir_aware'];
$ays_images_border = (!isset($gal_options['images_border'])) ? '' : $gal_options['images_border'];
$ays_images_border_width    = (!isset($gal_options['images_border_width'])) ? '1' : $gal_options['images_border_width'];
$ays_images_border_style    = (!isset($gal_options['images_border_style'])) ? 'solid' : $gal_options['images_border_style'];
$ays_images_border_color    = (!isset($gal_options['images_border_color'])) ? '#000000' : $gal_options['images_border_color'];
$ays_gallery_loader  = (!isset($gal_options['gallery_loader'])) ? "flower" : $gal_options['gallery_loader'];

if ($ays_gallery_loader == 'default') {
    $ays_gallery_loader = "flower";
}

$ays_gpg_view_type = (!isset($gal_options['view_type']) || $gal_options['view_type'] == "") ? "grid" : $gal_options['view_type'];

$ays_gpg_border_radius = !isset($gal_options['border_radius']) ? "0" : ($gal_options['border_radius']);
$ays_gpg_hover_icon_size = !isset($gal_options['hover_icon_size']) ? "20" : ($gal_options['hover_icon_size']);
$ays_gpg_thumbnail_title_size = !isset($gal_options['thumbnail_title_size']) ? "12" : ($gal_options['thumbnail_title_size']);
$ays_thumb_height_mobile = !isset($gal_options['thumb_height_mobile']) ? "170" : ($gal_options['thumb_height_mobile']);
$ays_thumb_height_desktop = !isset($gal_options['thumb_height_desktop']) ? "260" : ($gal_options['thumb_height_desktop']);

$ays_gpg_lightbox_counter           = (!isset($gal_lightbox_options['lightbox_counter'])) ? "true" : $gal_lightbox_options['lightbox_counter'];
$ays_gpg_lightbox_autoplay          = (!isset($gal_lightbox_options['lightbox_autoplay'])) ? "true" : $gal_lightbox_options['lightbox_autoplay'];
$ays_gpg_lightbox_pause             = (!isset($gal_lightbox_options['lb_pause'])) ? "5000" : $gal_lightbox_options['lb_pause'];
$ays_gpg_show_caption               = (!isset($gal_lightbox_options['lb_show_caption'])) ? "true" : $gal_lightbox_options['lb_show_caption'];

// Gallery image position
$gallery_img_position_l = (isset($gal_options['gallery_img_position_l']) && $gal_options['gallery_img_position_l'] != "") ? $gal_options['gallery_img_position_l'] : 'center';
$gallery_img_position_r = (isset($gal_options['gallery_img_position_r']) && $gal_options['gallery_img_position_r'] != "") ? $gal_options['gallery_img_position_r'] : 'center';

$image_sizes = $this->ays_get_all_image_sizes();
$image_no_photo = AYS_GPG_ADMIN_URL .'images/no-photo.png';

$gallery_categories = $this->ays_get_gallery_categories();

$img_load_effect = isset($gal_options['img_load_effect']) ? $gal_options['img_load_effect'] : 'fadeIn';

$ordering_asc_desc = (isset($gal_options['ordering_asc_desc']) && $gal_options['ordering_asc_desc'] != '') ? $gal_options['ordering_asc_desc'] : 'ascending';
$custom_class = (isset($gal_options['custom_class']) && $gal_options['custom_class'] != "") ? $gal_options['custom_class'] : '';
$gpg_height_width_ratio = isset($gal_options['height_width_ratio']) ? $gal_options['height_width_ratio'] : '1';

$responsive_width = (!isset($gal_options['resp_width'])) ? 'on' : $gal_options['resp_width'];
?>

<div class="wrap">
    <div class="container-fluid">
    <form id="ays-gpg-form" method="post">
    <input type="hidden" id="ays_submit_name">
    <input type="hidden" name="ays_gpg_settings_tab" value="<?php echo $ays_gpg_tab; ?>">
    <h1 class="wp-heading-inline">
        <?php echo $heading; ?>
        <input type="submit" name="ays-submit-top" class="ays-submit action-button button-primary" value="<?php echo __("Save and close", $this->plugin_name);?>" gpg_submit_name="ays-submit" />
        <!-- <?php // if($id != null): ?> -->
        <input type="submit" name="ays-apply-top" class="ays-submit action-button button" value="<?php echo __("Save", $this->plugin_name);?>" gpg_submit_name="ays-apply"/>
        <!-- <?php //endif; ?> -->
    </h1>
    <div>
        <p class="ays-subtitle">
            <strong class="ays_gpg_title_in_top">
                <?php echo stripslashes(htmlentities($gallery["title"])); ?>
            </strong>
        </p>
        <?php if($id !== null): ?>
        <div class="row">
            <div class="col-sm-3">
                <label> <?php echo __( "Shortcode text for editor", $this->plugin_name ); ?> </label>
            </div>
            <div class="col-sm-9">
                <p style="font-size:14px; font-style:italic;">
                    <?php echo __("To insert the Gallery into a page, post or text widget, copy shortcode", $this->plugin_name); ?>
                    <strong onClick="selectElementContents(this)" style="font-size:16px; font-style:normal;"><?php echo "[gallery_p_gallery id=".$id."]"; ?></strong>
                    <?php echo " " . __( "and paste it at the desired place in the editor.", $this->plugin_name); ?>
                </p>
            </div>
        </div>
        <?php endif;?>
    </div>
    <hr>
    <?php
        echo "<style>
                .ays_ays_img {
                    display: block;
                    width: 100%;
                    height: 100%;
                    background-image: url('".AYS_GPG_ADMIN_URL .'images/no-photo.png'."');
                    background-size: cover;
                    background-position: center center;
                }
            </style>";
    ?>
    <div class="nav-tab-wrapper">
        <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_gpg_tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
            <?php echo __("Images", $this->plugin_name);?>
        </a>
        <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_gpg_tab == 'tab2') ? 'nav-tab-active' : ''; ?>">
            <?php echo __("Settings", $this->plugin_name);?>
        </a>
        <a href="#tab3" data-tab="tab3" class="nav-tab <?php echo ($ays_gpg_tab == 'tab3') ? 'nav-tab-active' : ''; ?>">
            <?php echo __("Styles", $this->plugin_name);?>
        </a>
        <a href="#tab4" data-tab="tab4" class="nav-tab <?php echo ($ays_gpg_tab == 'tab4') ? 'nav-tab-active' : ''; ?>">
            <?php echo __("Lightbox settings", $this->plugin_name);?>
        </a>
        <a href="#tab5" data-tab="tab5" class="nav-tab <?php echo ($ays_gpg_tab == 'tab5') ? 'nav-tab-active' : ''; ?>">
            <?php echo __("Lightbox effects", $this->plugin_name);?>
        </a>
    </div>
    <div id="tab1" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab1') ? 'ays-gallery-tab-content-active' : ''; ?>">
        <br>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="gallery_title">
                    <?php echo __("Gallery Title", $this->plugin_name);?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("In this field is noted the name of the gallery", $this->plugin_name ); ?>">
                       <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input type="text" required name="gallery_title" id="gallery_title" class="ays-text-input" placeholder="<?php echo __("Gallery Title", $this->plugin_name);?>" value="<?php echo stripslashes(htmlentities($gallery["title"])); ?>"/>
            </div>
        </div>
        <hr/>
        <div class="ays-field">
            <label for="gallery_description">
                <?php echo __("Gallery Description", $this->plugin_name);?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This section is noted for the description of the gallery", $this->plugin_name ); ?>">
                   <i class="fas fa-info-circle"></i>
                </a>
            </label>
            <textarea class="ays-textarea" name="gallery_description" id="gallery_description" placeholder="<?php echo __("Gallery Description", $this->plugin_name);?>"><?php echo wp_unslash($gallery["description"]); ?></textarea>
        </div>
        <hr/>
        <p class="ays-subtitle"><?php echo  __('Add Images', $this->plugin_name) ?></p>
        <h6><?php echo  __('Upload images for your gallery', $this->plugin_name) ?></h6>
        <!-- <button type="button" class="ays-add-images button"><?php //echo __("Add image +", $this->plugin_name); ?></button> -->
        <button type="button" class="ays-add-multiple-images button"><?php echo __("Add multiple images +", $this->plugin_name); ?></button>
<!--        <button class="ays-add-video button"><?php //echo __("Add video +", $this->plugin_name); ?></button>-->
        <button type="button" class="ays_bulk_del_images button" disabled><?php echo __("Delete", $this->plugin_name); ?></button>
        <button type="button" class="ays_select_all_images button"><?php echo __("Select all", $this->plugin_name); ?></button>
        <input type="hidden" id="ays_image_lang_title" value="<?php echo __("It shows the name of the inserted picture", $this->plugin_name ); ?>">
        <input type="hidden" id="ays_image_lang_alt" value="<?php echo __("This field shows the alternate text when the picture is not loaded or not found", $this->plugin_name ); ?>">
        <input type="hidden" id="ays_image_lang_desc" value="<?php echo __("This field shows the description of the chosen image", $this->plugin_name ); ?>">
        <input type="hidden" id="ays_image_lang_url" value="<?php echo __("This section is for the URL address", $this->plugin_name ); ?>">
        <input type="hidden" id="ays_image_cat" value="<?php echo __("Select image categories", $this->plugin_name ); ?>">
        <hr/>
        <div class="ays_gpg_page_sort">
            <div id="ays_gpg_pagination">
                <select name="ays_admin_pagination" id="ays_admin_pagination">
                    <option <?php echo $admin_pagination == "all" ? "selected" : ""; ?> value="all"><?php echo __( "All", $this->plugin_name ); ?></option>
                    <option <?php echo $admin_pagination == "5" ? "selected" : ""; ?> value="5"><?php echo __( "5", $this->plugin_name ); ?></option>
                    <option <?php echo $admin_pagination == "10" ? "selected" : ""; ?> value="10"><?php echo __( "10", $this->plugin_name ); ?></option>
                    <option <?php echo $admin_pagination == "15" ? "selected" : ""; ?> value="15"><?php echo __( "15", $this->plugin_name ); ?></option>
                    <option <?php echo $admin_pagination == "20" ? "selected" : ""; ?> value="20"><?php echo __( "20", $this->plugin_name ); ?></option>
                    <option <?php echo $admin_pagination == "25" ? "selected" : ""; ?> value="25"><?php echo __( "25", $this->plugin_name ); ?></option>
                    <option <?php echo $admin_pagination == "30" ? "selected" : ""; ?> value="30"><?php echo __( "30", $this->plugin_name ); ?></option>
                </select>            
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field is for the creation of pagination", $this->plugin_name ); ?>">
                   <i class="fas fa-info-circle"></i>
                </a>
                <span class="ays_gpg_image_hover_icon_text"><?php echo __( "Image pagination", $this->plugin_name ); ?></span>
            </div>
            <div id="ays_gpg_sort_cont">    
            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Change the ordering", $this->plugin_name ); ?>">
                   <i class="fas fa-info-circle"></i>
                </a>            
                <button class="ays_gpg_sort">
                   <i class="fas fa-exchange-alt"></i>
               </button>
                              
            </div>
        </div>
        <hr/>
        <div class="paged_ays_accordion">
        <?php
            if($id == null) :
        ?>
        <ul class="ays-accordion">
            <li class="ays-accordion_li">
                <input type="hidden" name="ays-image-path[]">
                <div class="ays-image-attributes">
                    <div class='ays-move-images_div'><i class="ays-move-images"></i></div>
                    <div class='ays_image_div'>
                        <div class="ays_image_add_div">
                            <span class="ays_ays_img"></span>
                            <div class="ays_image_add_icon"><i class="ays-upload-btn"></i></div>
                        </div>
                        <div class="ays_image_thumb">
                            <div class="ays_image_edit_div"><i class="ays_image_edit"></i></div>
                            <div class='ays_image_thumb_img'><img></div>
                        </div>
                    </div>
                    <div class="ays_image_attr_item_cat">
                        <div class="ays_image_attr_item_parent">
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo __("Title", $this->plugin_name);?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("It shows the name of the inserted picture", $this->plugin_name ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="<?php echo __("Image title", $this->plugin_name);?>"/>
                            </div>
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo __("Alt", $this->plugin_name);?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the alternate text when the picture is not loaded or not found", $this->plugin_name ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="<?php echo __("Image alt", $this->plugin_name);?>"/>
                            </div>
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo __("Description", $this->plugin_name);?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the description of the chosen image", $this->plugin_name ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="<?php echo __("Image description", $this->plugin_name);?>"/>
                            </div>
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo __("URL", $this->plugin_name);?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This section is for the URL address", $this->plugin_name ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="<?php echo __("URL", $this->plugin_name);?>"/>
                            </div>
                        </div>
                        <div class="ays_image_cat">
                            <label>
                                <?php echo __("Image Category", $this->plugin_name);?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Select image categories", $this->plugin_name ); ?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                            <select class="ays-category form-control" multiple="multiple">
                                <?php                                
                                foreach ( $gallery_categories as $gallery_category ) {
                                    echo "<option value='".$gallery_category['id']."'>".$gallery_category['title']."</option>";
                                }                                            
                                ?>
                            </select>
                            <input type="hidden" class="for_select_name" name="ays_gallery_category[]">
                        </div>
                    </div>
                    <input type="hidden" name="ays-image-date[]" class="ays_img_date"/>
                    <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>
                    <div class='ays-delete-image_div'><i class="ays-delete-image"></i></div>
                </div>
            </li>
        </ul>
            <?php
                else:
                    $images = explode( "***", $gallery["images"] );
                    $images_titles = explode( "***", $gallery["images_titles"] );
                    $images_descriptions = explode( "***", $gallery["images_descs"] );
                    $images_alts = explode( "***", $gallery["images_alts"] );
                    $images_urls = explode( "***", $gallery["images_urls"] );
                    $images_dates = explode( "***", $gallery["images_dates"] );
                    $gal_cat_ids = isset($gallery['categories_id']) && $gallery['categories_id'] != '' ? explode( "***", $gallery["categories_id"] ) : array();
                    if($admin_pagination != "all"){
                        $pages = intval(ceil(count($images)/$admin_pagination));
                        $qanak = 0;
                        if(isset($_COOKIE['ays_gpg_page_tab_free'])){
                            $ays_page_cookie = explode("_", $_COOKIE['ays_gpg_page_tab_free']);
                            if($ays_page_cookie[1] >= $pages){
                                unset($_COOKIE['ays_gpg_page_tab_free']);
                                setcookie('ays_gpg_page_tab_free', "", time() - 3600, "/");
                                setcookie('ays_gpg_page_tab_free', 'tab_'.($pages-1), time() + 3600);
                                $_COOKIE['ays_gpg_page_tab_free'] = 'tab_'.($pages-1);
                            }
                        }
                        for($i = 0; $i < $pages; $i++){
                            $accordion_active = (isset($_COOKIE['ays_gpg_page_tab_free']) && $_COOKIE['ays_gpg_page_tab_free'] == "tab_".($i)) ? 'ays_accordion_active' : '';
                ?>
                <ul class="ays-accordion ays_accordion <?php echo $accordion_active; ?>" id="page_<?php echo $i; ?>">
                <?php
                    for ($key = $qanak, $j = 0; $key < count($images); $key++, $j++ ) {
                        if($j >= $admin_pagination){
                            $qanak = $key;
                            break;
                        }

                        if(strpos(trim($images[$key], "https:"), $this_site_path) !== false){
                            $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_type` = 'attachment' AND `guid` = '".$images[$key]."'";
                            $result_img =  $wpdb->get_results( $query, "ARRAY_A" );
                            if(!empty($result_img)){
                                $img_thmb_size = wp_get_attachment_image_src($result_img[0]['ID'],  'thumbnail');
                                if($img_thmb_size === false){
                                   $img_thmb_size = $images[$key];
                                }else{
                                   $img_thmb_size = !empty($img_thmb_size) ? $img_thmb_size[0] : $image_no_photo;
                                }
                            }else{
                                $img_thmb_size = $images[$key];
                            }
                        }else{
                            $img_thmb_size = $images[$key];
                        }
                        $img_thmb_html = !empty($img_thmb_size) ? '<img class="ays_ays_img" style="background-image:none;" src="'.$img_thmb_size.'">' : '<img class="ays_ays_img">';
                        ?>
                        <li class="ays-accordion_li">
                            <input type="hidden" name="ays-image-path[]" value="<?php echo $images[$key]; ?>">
                            <div class="ays-image-attributes">
                                <div class='ays-move-images_div'><i class="ays-move-images"></i></div>
                                <div class='ays_image_div'>
                                    <div class="ays_image_thumb" style="display: block; position: relative;">
                                        <div class="ays_image_edit_div" style="position: absolute;"><i class="ays_image_edit"></i></div>
                                        <div class='ays_image_thumb_img'><?php echo $img_thmb_html; ?></div>
                                    </div>
                                </div>
                                <div class="ays_image_attr_item_cat">
                                    <div class="ays_image_attr_item_parent">
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("Title", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("It shows the name of the inserted picture", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="<?php echo __("Image title", $this->plugin_name);?>" value="<?php echo $images_titles[$key]; ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("Alt", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the alternate text when the picture is not loaded or not found", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="<?php echo __("Image alt", $this->plugin_name);?>" value="<?php echo $images_alts[$key]; ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("Description", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the description of the chosen image", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="<?php echo __("Image description", $this->plugin_name);?>" value="<?php echo $images_descriptions[$key]; ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("URL", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This section is for the URL address", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="<?php echo __("URL", $this->plugin_name);?>" value="<?php echo $images_urls[$key]; ?>"/>
                                        </div>
                                    </div>
                                    <div class="ays_image_cat">
                                        <label>
                                            <?php echo __("Image Category", $this->plugin_name);?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Select image categories", $this->plugin_name ); ?>">
                                               <i class="fas fa-info-circle"></i>
                                            </a>
                                        </label>
                                        <select class="ays-category form-control" multiple="multiple">
                                            <?php
                                            $gal_cats_ids = isset($gal_cat_ids[$key]) && $gal_cat_ids[$key] != '' ? explode( ",", $gal_cat_ids[$key] ) : array();
                                            foreach ( $gallery_categories as $gallery_category ) {
                                                $checked = (in_array($gallery_category['id'], $gal_cats_ids)) ? "selected" : "";
                                                echo "<option value='".$gallery_category['id']."' ".$checked.">".$gallery_category['title']."</option>";
                                            }                                            
                                            ?>
                                        </select>
                                        <input type="hidden" class="for_select_name" name="ays_gallery_category[]">
                                    </div>
                                </div>
                                <input type="hidden" name="ays-image-date[]" class="ays_img_date" value="<?php echo $images_dates[$key]; ?>" />
                                <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>
                                <div class='ays-delete-image_div'><i class="ays-delete-image"></i></div>
                            </div>
                        </li>
                        <?php
                        }
                    ?>
                </ul>
                    <?php 
                        }
                    }else{
                ?>
                <ul class="ays-accordion">
                <?php                    
                    foreach ( $images as $key => $image ) {
                        if(strpos(trim($images[$key], "https:"), $this_site_path) !== false){
                            $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_type` = 'attachment' AND `guid` = '".$images[$key]."'";
                            $result_img =  $wpdb->get_results( $query, "ARRAY_A" );
                            if(!empty($result_img)){
                                $img_thmb_size = wp_get_attachment_image_src($result_img[0]['ID'],  'thumbnail');
                                if($img_thmb_size === false){
                                   $img_thmb_size = $images[$key];
                                }else{
                                   $img_thmb_size = !empty($img_thmb_size) ? $img_thmb_size[0] : $image_no_photo;
                                }
                            }else{
                                $img_thmb_size = $images[$key];
                            }
                        }else{
                            $img_thmb_size = $images[$key];
                        }

                        $img_thmb_html = !empty($img_thmb_size) ? '<img class="ays_ays_img" style="background-image:none;" src="'.$img_thmb_size.'">' : '<img class="ays_ays_img">';
                        ?>
                        <li class="ays-accordion_li">
                            <input type="hidden" name="ays-image-path[]" value="<?php echo $image; ?>">
                            <div class="ays-image-attributes">
                                <div class='ays-move-images_div'><i class="ays-move-images"></i></div>
                                <div class='ays_image_div'>                                
                                    <div class="ays_image_thumb" style="display: block; position: relative;">
                                        <div class="ays_image_edit_div" style="position: absolute;"><i class="ays_image_edit"></i></div>
                                        <div class='ays_image_thumb_img'>
                                            <?php echo $img_thmb_html; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays_image_attr_item_cat">
                                    <div class="ays_image_attr_item_parent">
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("Title", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("It shows the name of the inserted picture", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="<?php echo __("Image title", $this->plugin_name);?>" value="<?php echo $images_titles[$key]; ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("Alt", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the alternate text when the picture is not loaded or not found", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="<?php echo __("Image alt", $this->plugin_name);?>" value="<?php echo $images_alts[$key]; ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("Description", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the description of the chosen image", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>                                    
                                            </label>
                                            <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="<?php echo __("Image description", $this->plugin_name);?>" value="<?php echo $images_descriptions[$key]; ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo __("URL", $this->plugin_name);?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This section is for the URL address", $this->plugin_name ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="<?php echo __("URL", $this->plugin_name);?>" value="<?php echo $images_urls[$key]; ?>"/>
                                        </div>
                                    </div>
                                    <div class="ays_image_cat">
                                        <label>
                                            <?php echo __("Image Category", $this->plugin_name);?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Select image categories", $this->plugin_name ); ?>">
                                               <i class="fas fa-info-circle"></i>
                                            </a>
                                        </label>
                                        <select class="ays-category form-control" multiple="multiple">
                                            <?php
                                            $gal_cats_ids = isset($gal_cat_ids[$key]) && $gal_cat_ids[$key] != '' ? explode( ",", $gal_cat_ids[$key] ) : array();
                                            foreach ( $gallery_categories as $gallery_category ) {
                                                $checked = (in_array($gallery_category['id'], $gal_cats_ids)) ? "selected" : "";
                                                echo "<option value='".$gallery_category['id']."' ".$checked.">".$gallery_category['title']."</option>";
                                            }                                            
                                            ?>
                                        </select>
                                        <input type="hidden" class="for_select_name" name="ays_gallery_category[]">
                                    </div>
                                </div>
                                <input type="hidden" name="ays-image-date[]" class="ays_img_date" value="<?php echo $images_dates[$key]; ?>" /> 
                                <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>
                                <div class='ays-delete-image_div'><i class="ays-delete-image"></i></div>
                            </div>
                        </li>
                        <?php
                        }
                    }
                endif;
            ?>
            </ul>
            </div>
            <div class="ays_admin_pages">
                <ul>
                    <?php
                        if($admin_pagination != "all"){
                            if($pages > 0){
                                for($page = 0; $page < $pages; $page++ ){
                                    if(isset($_COOKIE['ays_gpg_page_tab_free']) && $_COOKIE['ays_gpg_page_tab_free'] == "tab_".($page)){
                                        $page_active = 'ays_page_active';
                                    }else{                                        
                                        $page_active = '';
                                    }
                                    echo "<li><a class='ays_page $page_active' data-tab='tab_".($page)."' href='#page_".($page)."'>".($page+1)."</a></li>";
                                }
                            }
                        }
                    ?>
                </ul>
            </div>
		</div>
		<div id="tab2" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab2') ? 'ays-gallery-tab-content-active' : ''; ?>">
            <h6 class="ays-subtitle"><?php echo  __('General options', $this->plugin_name) ?></h6>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_filter_cat">
                        <?php echo __("Enable filter by categories", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("You can decide whether to show the filter by category of the gallery or not. This option is compatible only with the Grid layout.", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="checkbox" id="ays_filter_cat" class="" name="ays_filter_cat" <?php echo (isset($gal_options['ays_filter_cat']) && $gal_options['ays_filter_cat'] == "on") ? "checked" : ""; ?> />
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Show gallery head", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("You can decide whether to show the title and description of the gallery or not", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Show gallery title ", $this->plugin_name);?>
                        <input type="checkbox" class="" name="ays_gpg_title_show" <?php
                           echo ($show_gal_title == "on") ? "checked" : ""; ?>/>
                        <a class="ays_help poqr_tooltip" data-toggle="tooltip" title="<?php echo __("If it is marked it will show the title", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Show gallery description ", $this->plugin_name);?>
                        <input type="checkbox" class="" name="ays_gpg_desc_show" <?php
                           echo ($show_gal_desc == "on") ? "checked" : ""; ?>/>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If it is marked it will show the description", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_image_sizes">
                        <?php echo __("Thumbnail Size", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The size of the image in the thumbnail", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">            
                    <select name="ays_image_sizes" id="ays_image_sizes">
                        <option value="full_size"><?php echo __( 'Full size' ); ?></option>
                        <?php
                            foreach($image_sizes as $key => $size):
                        ?>
                            <option <?php echo $gal_options["image_sizes"] == $key ? 'selected' : ''; ?> value="<?php echo $key; ?>">
                                <?php 
                                    $name = ucfirst($key); 
                                    echo __( "$name ({$size['width']}x{$size['height']})" ); 
                                ?>
                            </option>
                        <?php
                            endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_images_ordering">
                        <?php echo __("Images order by", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field arranges the images by parameters of title, date, random", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-3">				
                    <select name="ays_images_ordering" class="ays-text-input ays-text-input-short" id="ays_images_ordering">
                        <option <?php echo ($gal_options['images_orderby'] == "noordering") ? "selected" : ""; ?> value="noordering"><?php echo __("No ordering", $this->plugin_name);?></option>
                        <option <?php echo ($gal_options['images_orderby'] == "title") ? "selected" : ""; ?> value="title"><?php echo __("Title", $this->plugin_name);?></option>
                        <option <?php echo ($gal_options['images_orderby'] == "date") ? "selected" : ""; ?> value="date"><?php echo __("Date", $this->plugin_name);?></option>
                        <option <?php echo ($gal_options['images_orderby'] == "random") ? "selected" : ""; ?> value="random"><?php echo __("Random", $this->plugin_name);?></option>
                    </select>
                </div>
                <div class="col-sm-6">              
                    <select name="ays_gpg_ordering_asc_desc" class="ays-text-input ays-text-input-short" id="ays_gpg_ordering_asc_desc">
                        <option <?php echo ($ordering_asc_desc == "ascending") ? "selected" : ""; ?> value="ascending"><?php echo __("Ascending", $this->plugin_name);?></option>
                        <option <?php echo ($ordering_asc_desc == "descending") ? "selected" : ""; ?> value="descending"><?php echo __("Descending", $this->plugin_name);?></option>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images loading", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The images are loaded according to two principles: already loaded gallery with images and at first opens gallery after then the images", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <div>
                        <label class="ays_gpg_image_hover_icon" id="gpg_image_global_loading"><?php echo __("Global loading ", $this->plugin_name);?>
                            <input type="radio" id="ays_gpg_images_global_loading" name="ays_images_loading" <?php
                               if($gal_options['images_loading'] == '' || $gal_options['images_loading'] == null){ echo 'checked'; }
                               echo ($gal_options['images_loading'] == "all_loaded") ? "checked" : ""; ?> value="all_loaded"/>
                        </label>
                        <label class="ays_gpg_image_hover_icon" id="gpg_image_lazy_loading"><?php echo __("Lazy loading ", $this->plugin_name);?> <input type="radio" id="ays_gpg_images_lazy_loading" name="ays_images_loading" <?php echo ($gal_options['images_loading'] == "current_loaded") ? "checked" : ""; ?> value="current_loaded"/></label>
                    </div>
                </div>
            </div>
            <hr class="ays_hide_hr" />
            <div class="form-group row show_load_effect">
                <div class="col-sm-3">
                    <label for="gallery_img_loading_effect">
                        <?php echo __("Images loading effect", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose Images loading animation", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <select id="gallery_img_loading_effect" class="ays-text-input ays-text-input-short" name="ays_img_load_effect">
                        <optgroup label="Fading Entrances">
                            <option <?php echo 'fadeIn' == $img_load_effect ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                            <option <?php echo 'fadeInDown' == $img_load_effect ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                            <option <?php echo 'fadeInLeft' == $img_load_effect ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                            <option <?php echo 'fadeInRight' == $img_load_effect ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                            <option <?php echo 'fadeInUp' == $img_load_effect ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                        </optgroup>
                        <optgroup label="Sliding Entrances">
                            <option <?php echo ($img_load_effect == "slideInUp") ? "selected" : ""; ?> value="slideInUp"><?php echo __("Slide Up", $this->plugin_name);?></option>
                            <option <?php echo ($img_load_effect == "slideInDown") ? "selected" : ""; ?> value="slideInDown"><?php echo __("Slide Down", $this->plugin_name);?></option>
                            <option <?php echo ($img_load_effect == "slideInLeft") ? "selected" : ""; ?> value="slideInLeft"><?php echo __("Slide Left", $this->plugin_name);?></option>
                            <option <?php echo ($img_load_effect == "slideInRight") ? "selected" : ""; ?> value="slideInRight"><?php echo __("Slide Right", $this->plugin_name);?></option>
                        </optgroup>                                
                        <optgroup label="Zoom Entrances">
                            <option <?php echo 'zoomIn' == $img_load_effect ? 'selected' : ''; ?> value="zoomIn">Zoom In</option> 
                            <option <?php echo 'zoomInDown' == $img_load_effect ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option> 
                            <option <?php echo 'zoomInLeft' == $img_load_effect ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option> 
                            <option <?php echo 'zoomInRight' == $img_load_effect ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option> 
                            <option <?php echo 'zoomInUp' == $img_load_effect ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option> 
                        </optgroup>
                    </select>
                </div>
            </div>
            <hr/>           
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="show_title">
                        <?php echo __("Show title on thumbnail", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The name of the image is written in the below of it", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label class="ays_gpg_image_hover_icon"><?php echo __( "Show title ", $this->plugin_name); ?><input type="checkbox" id="show_title" class="" name="ays_gpg_show_title" <?php echo ($gal_options['show_title'] == "on") ? "checked" : ""; ?>/></label>
                        </div>
                        <div class="col-sm-9 show_with_date">
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label >
                                        <?php echo __("Show on", $this->plugin_name); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If you choose the case of Thumbnail hover the title will appear when the mouse cursor stops on the image, otherwise the title by default will appear at the bottom of the image.", $this->plugin_name);?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="ays_gpg_image_hover_icon"><?php echo __( "Thumbnail hover ", $this->plugin_name); ?><input type="radio" class="ays_gpg_show_title_on" name="ays_gpg_show_title_on" <?php echo ($show_thumb_title_on == "image_hover") ? "checked" : ""; ?> value="image_hover"/></label>
                                    <label class="ays_gpg_image_hover_icon"><?php echo __( "Gallery thumbnail ", $this->plugin_name); ?><input type="radio" class="ays_gpg_show_title_on" name="ays_gpg_show_title_on" <?php echo ($show_thumb_title_on == "gallery_image") ? "checked" : ""; ?> value="gallery_image"/></label>
                                </div>                                
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label >
                                        <?php echo __("Image title position", $this->plugin_name);?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Show title: in the bottom or on top", $this->plugin_name);?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <label class="ays_gpg_image_hover_icon"><?php echo __("Bottom", $this->plugin_name);?> <input type="radio" class="image_title_position_bottom" name="image_title_position" <?php echo ($thumb_title_position == "bottom") ? "checked" : ""; ?> value="bottom"/></label>
                                    <label class="ays_gpg_image_hover_icon"><?php echo __("Top", $this->plugin_name);?> <input type="radio" class="image_title_position_top" name="image_title_position" <?php echo ($thumb_title_position == "top") ? "checked" : ""; ?> value="top"/></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label><?php echo __( "Show with date ", $this->plugin_name); ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If you choose the Show with a date of adding the image to the gallery will appear on the date with the title.", $this->plugin_name);?>">
                                               <i class="fas fa-info-circle"></i>
                                            </a>
                                    </label>
                                </div>    
                                <div class="col-sm-8">
                                    <label class="ays_gpg_image_hover_icon"><?php echo __("Yes", $this->plugin_name);?> <input type="radio" class="image_title_position_bottom" name="ays_gpg_show_with_date" <?php echo ($gal_options['show_with_date'] == "on") ? "checked" : ""; ?> value="on"/></label>
                                    <label class="ays_gpg_image_hover_icon"><?php echo __("No", $this->plugin_name);?> <input type="radio" class="image_title_position_bottom" name="ays_gpg_show_with_date" <?php echo ($gal_options['show_with_date'] == "") ? "checked" : ""; ?> value=""/></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="light_box">
                        <?php echo __("Disable lightbox", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("By checking this option it will disable lightbox on image click", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="checkbox" id="light_box" class="" name="av_light_box" <?php echo (isset($gal_options['enable_light_box']) && $gal_options['enable_light_box'] == "on") ? "checked" : ""; ?> />
                </div>
            </div>  
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="gpg_search_img">
                        <?php echo __("Enable search for image", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This option is not compatible with the Mosaic layout.", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="checkbox" id="gpg_search_img" class="" name="gpg_search_img" <?php echo (isset($gal_options['enable_search_img']) && $gal_options['enable_search_img'] == "on") ? "checked" : ""; ?> />
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="gallery_width">
                        <?php echo __("Gallery Width (px)", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the width of the Gallery", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" id="gallery_width" class="ays-text-input ays-text-input-short" name="gallery_width" placeholder="<?php echo __("Gallery Width", $this->plugin_name);?>" value="<?php echo $gallery["width"] == 0 ? '' : $gallery["width"]; ?>"/>
                    <span class="ays_gpg_image_hover_icon_text"><?php echo __("For 100% leave blank", $this->plugin_name);?></span>
                </div>
            </div>
           
            <?php
                $bacel = $gal_options['view_type'] == 'grid' ? "style='display: flex;'" : "style='display: none;'";
                $resp_width = $responsive_width == "on" && $gal_options['view_type'] == 'grid' ? true : false;

                if ($resp_width) {
                    $height_width_ratio = "style='display: flex;'";
                    $thumb_height = "style='display: none;'";
                }else{
                    $height_width_ratio = "style='display: none;'";
                    $thumb_height = "style='display: flex;'";
                }

                switch ($gal_options['view_type']) {
                    case 'mosaic':
                        $pakel1 = "style='display: none;'";
                        $pakel2 = "style='display: none;'";
                        break;
                    case 'masonry':
                        $pakel1 = "style='display: none;'";
                        $pakel2 = "style='display: block;'";
                        break;
                    
                    default:
                        $pakel1 = "style='display: block;'";
                        $pakel2 = "style='display: block;'";
                        break;
                }
                
            ?>
            <hr class="hr_pakel" <?php echo $pakel1;?> >
            <div class="form-group row" id="ays_gpg_resp_width" <?php echo $bacel;?>>
                <div class="col-sm-3">
                    <label for="gpg_resp_width">
                        <?php echo __("Responsive Width/Height", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable the option if you want to assign the values to height and weight by ratio.", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="checkbox" id="gpg_resp_width" class="" name="gpg_resp_width" <?php echo ($responsive_width == "on") ? "checked" : ""; ?> />
                </div>
            </div>
            <hr class="hr_pakel" <?php echo $pakel1;?> >
            <div class="form-group row bacel" id="ays_height_width_ratio" <?php echo $height_width_ratio;?>>
                <div class="col-sm-3">
                    <label for="gpg_height_width_ratio">
                        <?php echo __("Height / Width ratio", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This ratio indicates the quantitative relation between height and width. For example, if you give 1.2 value to ratio while the width is 300, then the height will be 300x1.2=360.", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="number" class="ays-text-input ays-text-input-short ays_gpg_height_width_ratio" name="gpg_height_width_ratio" id="gpg_height_width_ratio" step="0.1" value="<?php echo $gpg_height_width_ratio; ?>" placeholder="Example: 1 or 1.2 ...">
                </div>
            </div>
            
            <div id="ays-thumb-height" class="form-group row pakel3" <?php echo $thumb_height;?>>
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Thumbnails height", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The height of the thumbnails of the Gallery", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9" style="border-left:1px solid #ccc;">                   
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_thumb_height_mobile">
                                <?php echo __("For mobile (px):", $this->plugin_name);?>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="number" id="ays_thumb_height_mobile" name="ays-thumb-height-mobile" class="ays-text-input ays-text-input-short" value="<?php echo $ays_thumb_height_mobile; ?>"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_thumb_height_desktop">
                                <?php echo __("For desktop (px):", $this->plugin_name);?>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="number" id="ays_thumb_height_desktop" name="ays-thumb-height-desktop" class="ays-text-input ays-text-input-short" value="<?php echo $ays_thumb_height_desktop; ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <hr class='pakel' <?php echo $pakel2;?> >
            <div id="ays-columns-count" class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_columns_count">
                        <?php echo __("Columns count. Default: 3", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The counts of the columns of the Gallery", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="number" id="ays_columns_count" name="ays-columns-count" class="ays-text-input ays-text-input-short" placeholder="<?php echo __("Default", $this->plugin_name);?>: 3" value="<?php echo isset($gal_options['columns_count']) ? $gal_options['columns_count'] : 3; ?>"/>
                </div>
            </div>
		</div>
        <?php
            $view_type_names = array(
                "grid"      => "grid.PNG",
                "mosaic"    => "mosaic.png",
                "masonry"   => "masonry.png",
                "view_1"    => "view_1.png",
                "view_2"    => "view_2.png",
                "view_3"    => "view_3.png",
                "view_4"    => "view_4.png",
                "view_5"    => "view_5.png",
                "view_6"    => "view_6.png",
                "view_7"    => "view_7.png",
                "view_8"    => "view_8.png",
                "view_9"    => "view_9.png",
                "view_10"   => "view_10.png",
                "view_11"   => "view_11.png",
                "view_12"   => "view_12.png",
                "view_13"   => "view_13.png",
                "view_14"   => "view_14.png",
                "view_15"   => "view_15.png",
                "view_16"   => "view_16.png",
                "view_17"   => "view_17.png",
                "view_18"   => "view_18.png",
                "view_19"   => "view_19.png",
                "view_20"   => "view_20.png",
                "view_21"   => "view_21.png",
                "view_22"   => "view_22.png",
                "view_23"   => "view_23.png",
                "view_24"   => "view_24.png",
                "fb_view_1"   => "fb_view_1.PNG",
                "fb_view_2"   => "fb_view_2.PNG",
                "fb_view_3"   => "fb_view_3.PNG"
            );
        ?>
        <div id="tab3" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab3') ? 'ays-gallery-tab-content-active' : ''; ?>">
            <h6 class="ays-subtitle"><?php echo  __('Style options', $this->plugin_name) ?></h6>            
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Gallery view type", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo  __('This section notes the type of the Gallery that is in what sequence should the pictures be', $this->plugin_name) ?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <div>
                        <?php
                            foreach($view_type_names as $key => $name):
                        ?>
                        <label class="ays_gpg_view_type_radio">
                            <input type="radio" class="ays-view-type" name="ays-view-type" 
                                   <?php echo ($ays_gpg_view_type == $key) ? "checked" : ""; ?>
                                   <?php echo ("grid" == $key || "mosaic" == $key || "masonry" == $key) ? "" : "disabled"; ?>
                                   value="<?php echo $key; ?>"/>
                            <?php if($key == "grid" || $key == "mosaic" || $key == "masonry"): ?>
                            <span><?php echo __( ucfirst($key)." ", $this->plugin_name);?></span>
                            <?php endif; ?>
                            <?php if($key == "grid" || $key == "mosaic" || $key == "masonry"): ?>
                            <img src="<?php echo AYS_GPG_ADMIN_URL . "images/" . $name; ?>">
                            <?php else: ?>
                            <a href="https://ays-pro.com/wordpress/photo-gallery" target="_blank" style="display: block;" class="ays_disabled" title="<?php echo __("This feature will available in PRO version", $this->plugin_name); ?>">
                                <div></div>
                                <img src="<?php echo AYS_GPG_ADMIN_URL . "images/" . $name; ?>">
                            </a>
                            <?php endif; ?>
                        </label>
                        <?php
                            endforeach;
                        ?>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images hover effect", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Effect intended for hover according to animation", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <div>
                        <label class="ays_gpg_image_hover_icon"><?php echo __("Simple animation ", $this->plugin_name);?>
                            <input type="radio" class="ays_hover_effect_radio ays_hover_effect_radio_simple" name="ays_images_hover_effect" <?php
                               echo ($ays_images_hover_effect == "simple") ? "checked" : ""; ?> value="simple"/>
                        </label>
                        <label class="ays_gpg_image_hover_icon"><?php echo __("Direction-aware ", $this->plugin_name);?> <input type="radio" class="ays_hover_effect_radio ays_hover_effect_radio_dir_aware" name="ays_images_hover_effect" <?php echo ($ays_images_hover_effect == "dir_aware") ? "checked" : ""; ?> value="dir_aware"/></label>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="ays-field ays_effect_simple">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="gallery_img_hover_simple">
                            <?php echo __("Images hover animation", $this->plugin_name);?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Hover appearing animation of the images of Gallery", $this->plugin_name);?>">
                               <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="gallery_img_hover_simple" class="ays-text-input ays-text-input-short" name="ays_hover_simple">
                            <optgroup label="Fading Entrances">
                                <option <?php echo 'fadeIn' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                                <option <?php echo 'fadeInDown' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                                <option <?php echo 'fadeInLeft' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                                <option <?php echo 'fadeInRight' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                                <option <?php echo 'fadeInUp' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                            </optgroup>
                            <optgroup label="Sliding Entrances">
                                <option <?php echo ($gal_options['hover_effect'] == "slideInUp") ? "selected" : ""; ?> value="slideInUp"><?php echo __("Slide Up", $this->plugin_name);?></option>
                                <option <?php echo ($gal_options['hover_effect'] == "slideInDown") ? "selected" : ""; ?> value="slideInDown"><?php echo __("Slide Down", $this->plugin_name);?></option>
                                <option <?php echo ($gal_options['hover_effect'] == "slideInLeft") ? "selected" : ""; ?> value="slideInLeft"><?php echo __("Slide Left", $this->plugin_name);?></option>
                                <option <?php echo ($gal_options['hover_effect'] == "slideInRight") ? "selected" : ""; ?> value="slideInRight"><?php echo __("Slide Right", $this->plugin_name);?></option>
                            </optgroup>                                
                            <optgroup label="Zoom Entrances">
                                <option <?php echo 'zoomIn' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomIn">Zoom In</option> 
                                <option <?php echo 'zoomInDown' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option> 
                                <option <?php echo 'zoomInLeft' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option> 
                                <option <?php echo 'zoomInRight' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option> 
                                <option <?php echo 'zoomInUp' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option> 
                            </optgroup>
                        </select>
                    </div>
                </div>
                <hr/>
            </div>
            <div class="ays-field ays_effect_dir_aware">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="gallery_img_hover_dir_aware">
                            <?php echo __("Images hover animation", $this->plugin_name);?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Hover appearing animation of the images of Gallery", $this->plugin_name);?>">
                               <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <select id="gallery_img_hover_dir_aware" class="ays-text-input ays-text-input-short" name="ays_hover_dir_aware">
                            <option <?php echo 'slide' == $ays_images_hover_dir_aware ? 'selected' : ''; ?> value="slide"><?php echo __("Slide", $this->plugin_name);?></option>
                            <option <?php echo 'rotate3d' == $ays_images_hover_dir_aware ? 'selected' : ''; ?> value="rotate3d"><?php echo __("Rotate 3D", $this->plugin_name);?></option>
                        </select>
                    </div>
                </div>
                <hr/>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="gallery_img_position_l">
                        <?php echo __("Image position", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The position image of the gallery", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <select id="gallery_img_position_l" class="ays-text-input ays-text-input-short short_select" name="gallery_img_position_l">
                        <option <?php echo 'center' == $gallery_img_position_l ? 'selected' : ''; ?> value="center"><?php echo __("Center", $this->plugin_name);?></option>
                        <option <?php echo 'left' == $gallery_img_position_l ? 'selected' : ''; ?> value="left"><?php echo __("Left", $this->plugin_name);?></option>
                        <option <?php echo 'right' == $gallery_img_position_l ? 'selected' : ''; ?> value="right"><?php echo __("Right", $this->plugin_name);?></option>                        
                    </select>
                    <select id="gallery_img_position_r" class="ays-text-input ays-text-input-short short_select" name="gallery_img_position_r">
                        <option <?php echo 'center' == $gallery_img_position_r ? 'selected' : ''; ?> value="center"><?php echo __("Center", $this->plugin_name);?></option>
                        <option <?php echo 'top' == $gallery_img_position_r ? 'selected' : ''; ?> value="top"><?php echo __("Top", $this->plugin_name);?></option>
                        <option <?php echo 'bottom' == $gallery_img_position_r ? 'selected' : ''; ?> value="bottom"><?php echo __("Bottom", $this->plugin_name);?></option>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images hover opacity", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The transparency degree of the image hover", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-3 gpg_range_div">
                    <div>
                        <input class="gpg_opacity_demo_val form-control-range" id="formControlRange" name="ays-gpg-image-hover-opacity" type="range" min="0" max="1" step="0.01" value="<?php echo isset($gal_options['hover_opacity']) ? $gal_options['hover_opacity'] : '0.5'; ?>">
                    </div>                    
                </div>
                <div class="col-sm-6">                    
                    <div class="gpg_opacity_demo"><?php echo __("Hover opacity preview", $this->plugin_name);?></div>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images hover color", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The color of the image hover", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input name="ays-gpg-hover-color" class="ays_gpg_hover_color" data-alpha="true" type="text" value="<?php echo isset($gal_options['hover_color']) ? wp_unslash($gal_options['hover_color']) : '#000000'; ?>" data-default-color="#000000">
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images hover zoom effect", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("During image hover, the zoom effect of the image", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Yes ", $this->plugin_name); ?><input name="ays_gpg_hover_zoom" type="radio" value="yes" <?php echo ($ays_hover_zoom == "yes") ? "checked" : ''; ?>></label>
                    <label class="ays_gpg_image_hover_icon"><?php echo __("No ", $this->plugin_name); ?><input name="ays_gpg_hover_zoom" type="radio" value="no" <?php echo ($ays_hover_zoom == "no") ? "checked" : ''; ?>></label>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images hover scale box shadow effect", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("During image hover, the scale box shadow effect of the image", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Yes ", $this->plugin_name); ?><input name="ays_gpg_hover_scale" type="radio" value="yes" <?php echo ($ays_hover_scale == "yes") ? "checked" : ''; ?>></label>
                    <label class="ays_gpg_image_hover_icon"><?php echo __("No ", $this->plugin_name); ?><input name="ays_gpg_hover_scale" type="radio" value="no" <?php echo ($ays_hover_scale == "no") ? "checked" : ''; ?>></label>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_gpg_filter_thubnail">
                        <?php echo __("Choose filter for thumbnail", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The filter property defines visual effects to images of Gallery", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <select id="ays_gpg_filter_thubnail" class="ays-text-input ays-text-input-short" name="ays_gpg_filter_thubnail_opt">
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "none") ? "selected" : ""; ?> value="none"><?php echo __("Default none", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "blur") ? "selected" : ""; ?> value="blur"><?php echo __("Blur", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "brightness") ? "selected" : ""; ?> value="brightness"><?php echo __("Brightness", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "contrast") ? "selected" : ""; ?> value="contrast"><?php echo __("Contrast", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "grayscale") ? "selected" : ""; ?> value="grayscale"><?php echo __("Grayscale", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "hue_rotate") ? "selected" : ""; ?> value="hue_rotate"><?php echo __("Hue Rotate", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "invert") ? "selected" : ""; ?> value="invert"><?php echo __("Invert", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "saturate") ? "selected" : ""; ?> value="saturate"><?php echo __("Saturate", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_options['filter_thubnail_opt']) && $gal_options['filter_thubnail_opt'] == "sepia") ? "selected" : ""; ?> value="sepia"><?php echo __("Sepia", $this->plugin_name);?></option>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Loader style", $this->plugin_name);?>
                    </label>
                </div>
                <div class="col-sm-9">
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="flower" <?php echo ($ays_gallery_loader == 'flower') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/flower.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="ball" <?php echo ($ays_gallery_loader == 'ball') ? 'checked' : ''; ?> />
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/ball.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="bars" <?php echo ($ays_gallery_loader == 'bars') ? 'checked' : ''; ?> />
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/bars.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="curved_bar" <?php echo ($ays_gallery_loader == 'curved_bar') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/curved_bar.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="react" <?php echo ($ays_gallery_loader == 'react') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/react.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="gallery" <?php echo ($ays_gallery_loader == 'gallery') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/gallery.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="fracox" <?php echo ($ays_gallery_loader == 'fracox') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/fracox.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="fracoxner" <?php echo ($ays_gallery_loader == 'fracoxner') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/fracoxner.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="frik" <?php echo ($ays_gallery_loader == 'frik') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/frik.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="clock_frik" <?php echo ($ays_gallery_loader == 'clock_frik') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/clock_frik.svg' ?>">
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input name="ays_gpg_loader" type="radio" value="in_yan" <?php echo ($ays_gallery_loader == 'in_yan') ? 'checked' : ''; ?>>
                        <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/in_yan.svg' ?>">
                    </label>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images hover icon", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("During hover, the icon seen on the image", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <?php 
                        if($gal_options['hover_icon'] == false || $gal_options['hover_opacity'] == ''){
                            $ays_hover_icon = 'search_plus';
                        }else{
                            $ays_hover_icon = $gal_options['hover_icon'];
                        }
                    ?>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="none" <?php echo $ays_hover_icon == 'none' ? 'checked' : ''; ?> />
                        <i>None</i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="search_plus" <?php echo $ays_hover_icon == 'search_plus' ? 'checked' : ''; ?> />
                        <i class="fas fa-search-plus"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="search" <?php echo $ays_hover_icon == 'search' ? 'checked' : ''; ?>/>
                        <i class="fas fa-search"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="plus" <?php echo $ays_hover_icon == 'plus' ? 'checked' : ''; ?>/>
                        <i class="fas fa-plus"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="plus_circle" <?php echo $ays_hover_icon == 'plus_circle' ? 'checked' : ''; ?>/>
                        <i class="fas fa-plus-circle"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="plus_square_fas" <?php echo $ays_hover_icon == 'plus_square_fas' ? 'checked' : ''; ?>/>
                        <i class="fas fa-plus-square"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="plus_square_far" <?php echo $ays_hover_icon == 'plus_square_far' ? 'checked' : ''; ?>/>
                        <i class="far fa-plus-square"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="expand" <?php echo $ays_hover_icon == 'expand' ? 'checked' : ''; ?>/>
                        <i class="fas fa-expand"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="image_fas" <?php echo $ays_hover_icon == 'image_fas' ? 'checked' : ''; ?>/>
                        <i class="fas fa-image"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="image_far" <?php echo $ays_hover_icon == 'image_far' ? 'checked' : ''; ?>/>
                        <i class="far fa-image"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="images_fas" <?php echo $ays_hover_icon == 'images_fas' ? 'checked' : ''; ?>/>
                        <i class="fas fa-images"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="images_far" <?php echo $ays_hover_icon == 'images_far' ? 'checked' : ''; ?>/>
                        <i class="far fa-images"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="eye_fas" <?php echo $ays_hover_icon == 'eye_fas' ? 'checked' : ''; ?>/>
                        <i class="fas fa-eye"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="eye_far" <?php echo $ays_hover_icon == 'eye_far' ? 'checked' : ''; ?>/>
                        <i class="far fa-eye"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="camera_retro" <?php echo $ays_hover_icon == 'camera_retro' ? 'checked' : ''; ?>/>
                        <i class="fas fa-camera-retro"></i>
                    </label>
                    <label class="ays_gpg_image_hover_icon">
                        <input type="radio" name="ays-gpg-image-hover-icon" value="camera" <?php echo $ays_hover_icon == 'camera' ? 'checked' : ''; ?>/>
                        <i class="fas fa-camera"></i>
                    </label>
                    <p class="ays_gpg_image_hover_icon_text"><span><?php echo __("Select icon for the gallery images", $this->plugin_name);?></span></p>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images hover icon size (px)", $this->plugin_name);?>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input name="ays-gpg-hover-icon-size" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $ays_gpg_hover_icon_size; ?>">
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images distance (px)", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The distance among images with pixels", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input name="ays-gpg-images-distance" class="ays-text-input ays-text-input-short" type="number" value="<?php echo !isset($gal_options['images_distance']) ? '5' : ($gal_options['images_distance']); ?>">
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_gpg_images_border">
                        <?php echo __("Images border", $this->plugin_name);?>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input id="ays_gpg_images_border" name="ays_gpg_images_border" class="" type="checkbox" <?php echo ($ays_images_border == 'on') ? 'checked' : ''; ?>>
                    <div class="ays_gpg_border_options">
                        <input type="number" class="ays_gpg_images_border_width" style="width: 50px;" min="0" max="10" maxlength="2" name="ays_gpg_images_border_width" value="<?php echo $ays_images_border_width; ?>" onkeypress="if(this.value.length==2) return false;">
                        <span style="color: grey; font-style:italic; font-size: 18px;">px</span>
                        <select name="ays_gpg_images_border_style">
                            <option value="solid" <?php echo $ays_images_border_style == "solid" ? 'selected' : ''; ?>>Solid</option>
                            <option value="dashed" <?php echo $ays_images_border_style == "dashed" ? 'selected' : ''; ?>>Dashed</option>
                            <option value="dotted" <?php echo $ays_images_border_style == "dotted" ? 'selected' : ''; ?>>Dotted</option>
                            <option value="double" <?php echo $ays_images_border_style == "double" ? 'selected' : ''; ?>>Double</option>
                            <option value="groove" <?php echo $ays_images_border_style == "groove" ? 'selected' : ''; ?>>Groove</option>
                            <option value="ridge" <?php echo $ays_images_border_style == "ridge" ? 'selected' : ''; ?>>Ridge</option>
                            <option value="inset" <?php echo $ays_images_border_style == "inset" ? 'selected' : ''; ?>>Inset</option>
                            <option value="outset" <?php echo $ays_images_border_style == "outset" ? 'selected' : ''; ?>>Outset</option>
                            <option value="none" <?php echo $ays_images_border_style == "none" ? 'selected' : ''; ?>>None</option>
                        </select>
                        <input name="ays_gpg_border_color" class="ays_gpg_border_color" type="text" data-alpha="true" value="<?php echo $ays_images_border_color; ?>" data-default-color="#000000">
                    </div>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Images border radius (px)", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The degree of borders curvature of images", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input name="ays-gpg-images-border-radius" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $ays_gpg_border_radius ?>">
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Thumbnail title icon size (px)", $this->plugin_name);?>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input name="ays_gpg_thumbnail_title_size" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $ays_gpg_thumbnail_title_size; ?>">
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label>
                        <?php echo __("Background color of the Gallery thumbnail title", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The color of the background of the Gallery Thumbnail title", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input name="ays-gpg-lightbox-color" class="ays_gpg_lightbox_color" data-alpha="true" type="text" value="<?php echo isset($gal_options['lightbox_color']) ? wp_unslash($gal_options['lightbox_color']) : 'rgba(0,0,0,0)'; ?>" data-default-color="rgba(0,0,0,0)">
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="custom_class">
                        <?php echo __("Custom class", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Custom HTML class for gallery container. You can use your class for adding your custom styles for gallery container.", $this->plugin_name ); ?>">
                        <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="ays_custom_class" id="custom_class" class="ays-text-input ays-text-input-short" placeholder="<?php echo __("myClass myAnotherClass...", $this->plugin_name);?>" value="<?php echo $custom_class; ?>"/>
                </div>
            </div>
            <hr/>
            <div class="ays-field">
                <label for="gallery_custom_css">
                    <?php echo __("Custom CSS", $this->plugin_name);?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("You can add your CSS", $this->plugin_name);?>">
                       <i class="fas fa-info-circle"></i>
                    </a>
                </label>
                <textarea class="ays-textarea" name="gallery_custom_css" id="gallery_custom_css"><?php echo (isset($gallery['custom_css']) && $gallery['custom_css'] != '') ? $gallery['custom_css'] : ''; ?></textarea>
            </div>
        </div>
        <div id="tab4" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab4') ? 'ays-gallery-tab-content-active' : ''; ?>">
            <h6 class="ays-subtitle"><?php echo  __('Lightbox options', $this->plugin_name) ?></h6>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label>
                        <?php echo __("Images counter", $this->plugin_name);?>
                    </label>
                </div>
                <div class="col-sm-10">
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Enable ", $this->plugin_name);?>
                        <input type="radio" class="" name="ays_gpg_lightbox_counter" <?php echo ($ays_gpg_lightbox_counter == "true") ? "checked" : ""; ?> value="true"/>
                    </label>
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Disable ", $this->plugin_name);?> 
                        <input type="radio" class="" name="ays_gpg_lightbox_counter" <?php echo ($ays_gpg_lightbox_counter == "false") ? "checked" : ""; ?> value="false"/>
                    </label>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label>
                        <?php echo __("Show caption in lightbox", $this->plugin_name);?>
                    </label>
                </div>
                <div class="col-sm-10">
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Enable ", $this->plugin_name);?>
                        <input type="radio" class="" name="ays_gpg_show_caption" <?php echo ($ays_gpg_show_caption == "true") ? "checked" : ""; ?> value="true"/>
                    </label>
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Disable ", $this->plugin_name);?> 
                        <input type="radio" class="" name="ays_gpg_show_caption" <?php echo ($ays_gpg_show_caption == "false") ? "checked" : ""; ?> value="false"/>
                    </label>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label>
                        <?php echo __("Images slide show", $this->plugin_name);?>
                    </label>
                </div>
                <div class="col-sm-2">
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Enable ", $this->plugin_name);?>
                        <input type="radio" class="ays_enable_disable" name="ays_gpg_lightbox_autoplay" <?php echo ($ays_gpg_lightbox_autoplay == "true") ? "checked" : ""; ?> value="true"/>
                    </label>
                    <label class="ays_gpg_image_hover_icon"><?php echo __("Disable ", $this->plugin_name);?> 
                        <input type="radio" class="ays_enable_disable" name="ays_gpg_lightbox_autoplay" <?php echo ($ays_gpg_lightbox_autoplay == "false") ? "checked" : ""; ?> value="false"/>
                    </label>
                </div>
                <div class="col-sm-8 ays_hidden">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo __("Slide duration (ms)", $this->plugin_name);?>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="number" class="ays-text-input" name="ays_gpg_lightbox_pause" value="<?php echo $ays_gpg_lightbox_pause; ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="ays_gpg_filter_lightbox">
                        <?php echo __("Choose filter for lightbox", $this->plugin_name);?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("The filter property defines visual effects to images of Gallery", $this->plugin_name);?>">
                           <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-10">
                    <select id="ays_gpg_filter_lightbox" class="ays-text-input ays-text-input-short" name="ays_gpg_filter_lightbox_opt">
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "none") ? "selected" : ""; ?> value="none"><?php echo __("Default none", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "blur") ? "selected" : ""; ?> value="blur"><?php echo __("Blur", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "brightness") ? "selected" : ""; ?> value="brightness"><?php echo __("Brightness", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "contrast") ? "selected" : ""; ?> value="contrast"><?php echo __("Contrast", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "grayscale") ? "selected" : ""; ?> value="grayscale"><?php echo __("Grayscale", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "hue_rotate") ? "selected" : ""; ?> value="hue_rotate"><?php echo __("Hue Rotate", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "invert") ? "selected" : ""; ?> value="invert"><?php echo __("Invert", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "saturate") ? "selected" : ""; ?> value="saturate"><?php echo __("Saturate", $this->plugin_name);?></option>
                        <option <?php echo (isset($gal_lightbox_options['filter_lightbox_opt']) && $gal_lightbox_options['filter_lightbox_opt'] == "sepia") ? "selected" : ""; ?> value="sepia"><?php echo __("Sepia", $this->plugin_name);?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 only_pro">
                    <div class="pro_features">
                        <div>
                            <p>
                                <?php echo __("This feature available only in ", $this->plugin_name); ?>
                                <a href="https://ays-pro.com/index.php/wordpress/photo-gallery/" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                            </p>
                        </div>
                    </div>
                    <img class="pro_img_style" src="<?php echo AYS_GPG_ADMIN_URL; ?>images/features/lighbox_settings.png">
                </div>
            </div>
        </div>
        <div id="tab5" class="only_pro ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab5') ? 'ays-gallery-tab-content-active' : ''; ?>" style="padding-top: 15px;">
            <div class="pro_features">
                <div>
                    <p>
                        <?php echo __("This feature available only in ", $this->plugin_name); ?>
                        <a href="https://ays-pro.com/index.php/wordpress/photo-gallery/" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                    </p>
                </div>
            </div>
            <img class="pro_img_style" src="<?php echo AYS_GPG_ADMIN_URL; ?>images/features/lighbox_effect.png">
        </div>
        <?php
            wp_nonce_field('ays_gallery_action', 'ays_gallery_action');
        ?>
        <hr/>
		<div class="ays_submit_button">
        	<input type="submit" name="ays-submit" class="ays-submit button-primary" value="<?php echo __("Save and close", $this->plugin_name);?>" gpg_submit_name="ays-submit" />
            <!-- <?php // if($id != null): ?> -->
        	<input type="submit" name="ays-apply" id="ays_submit_apply" class="ays-submit button" value="<?php echo __("Save", $this->plugin_name);?>" gpg_submit_name="ays-apply"/>
            <!-- <?php // endif; ?> -->
		</div>
        <button type="button" class="ays_gallery_live_preview" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo __("View your gallery in live preview. In the preview you can’t see Thumbnail size and Image order changes.", $this->plugin_name);?>" data-original-title="<?php echo __("Gallery preview", $this->plugin_name);?>"><i class="fas fa-search-plus"></i></button>    
        <button class="ays_gallery_live_save" type="submit" name="ays-apply"><i class="far fa-save" gpg_submit_name="ays-apply"></i></button>
        <input type="hidden" id="ays_gpg_admin_url" value="<?php echo AYS_GPG_ADMIN_URL; ?>"/>
    </form>
    </div>
    
    <!--  Start modal preview -->
    <div class="ays_gallery_live_preview_popup">
        <a class="ays_live_preview_close"><i class="ays_gpg_fa ays_gpg_fa_times_circle"></i></a>
        <div class='ays_gallery_container'>
        </div>
        <div class="ays_gpg_live_overlay"></div>
    </div>
    <!--  End modal preview -->
</div>