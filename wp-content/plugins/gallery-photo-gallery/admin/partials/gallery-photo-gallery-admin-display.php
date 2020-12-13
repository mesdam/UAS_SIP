<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/admin/partials
 */


    $action = ( isset($_GET['action']) ) ? $_GET['action'] : '';
    $id     = ( isset($_GET['gallery']) ) ? $_GET['gallery'] : null;
    if($action == 'duplicate'){
        $this->gallery_obj->duplicate_galleries($id);
    }
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php
        if (!isset($_COOKIE['ays_gpg_page_tab_free'])) {
            setcookie('ays_gpg_page_tab_free', 'tab_0', time() + 3600);
        } else {
            $_COOKIE['ays_gpg_page_tab_free'] = 'tab_0';
        }
        echo esc_html(get_admin_page_title());
        echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action">%s</a>', esc_attr( $_REQUEST['page'] ), 'add', __("Add New", $this->plugin_name));
        ?>
    </h1>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                        $this->gallery_obj->prepare_items();
                        $this->gallery_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>
