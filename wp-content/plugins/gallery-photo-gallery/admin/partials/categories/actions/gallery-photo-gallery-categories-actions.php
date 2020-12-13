<?php
    $action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
    $heading = '';
    $id = ( isset( $_GET['gallery_category'] ) ) ? absint( intval( $_GET['gallery_category'] ) ) : null;
    $gallery_category = array(
        'id'            => '',
        'title'         => '',
        'description'   => ''
    );
    switch( $action ) {
        case 'add':
            $heading = __('Add new category', $this->plugin_name);
            break;
        case 'edit':
            $heading = __('Edit category', $this->plugin_name);
            $gallery_category = $this->cats_obj->get_gallery_category( $id );
            break;
    }
    if( isset( $_POST['ays_submit'] ) ) {
        $_POST['id'] = $id;
        $result = $this->cats_obj->add_edit_gallery_category( $_POST );
    }
    if(isset($_POST['ays_apply'])){
        $_POST["id"] = $id;
        $_POST['ays_change_type'] = 'apply';
        $this->cats_obj->add_edit_gallery_category($_POST);
    }
?>
<div class="wrap">
    <div class="container-fluid">
        <h1><?php echo $heading; ?></h1>
        <hr/>
        <form class="ays-gpg-category-form" id="ays-gpg-category-form" method="post">
            <div class="form-group row">
                <div class="col-sm-2">
                    <label for='ays-title'>
                        <?php echo __('Title', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Title of the category',$this->plugin_name)?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-10">
                    <input class='ays-text-input' id='ays-title' name='ays_title' required type='text' value='<?php echo (stripslashes(htmlentities($gallery_category['title']))); ?>'>
                </div>
            </div>

            <hr/>
            <div class='ays-field'>
                <label for='ays-description'>
                    <?php echo __('Description', $this->plugin_name); ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Provide more information about the gallery category',$this->plugin_name)?>">
                        <i class="ays_fa ays_fa_info_circle"></i>
                    </a>
                </label>
                <?php
                $content = (stripslashes(htmlentities($gallery_category['description'])));
                $editor_id = 'ays-gpg-description';
                $settings = array('editor_height'=>'4','textarea_name'=>'ays_description','editor_class'=>'ays-textarea');
                wp_editor($content,$editor_id,$settings);
                ?>
            </div>

            <hr/>
            <?php
                wp_nonce_field('gallery_category_action', 'gallery_category_action');
                $other_attributes = array( 'id' => 'ays-button' );
                submit_button( __( 'Save and close', $this->plugin_name ), 'primary', 'ays_submit', true, $other_attributes );
                submit_button( __( 'Save', $this->plugin_name), '', 'ays_apply', true, $other_attributes);
                ?>
        </form>
    </div>
</div>