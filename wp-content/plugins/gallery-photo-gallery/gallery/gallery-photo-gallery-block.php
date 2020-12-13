<?php
    /**
     * Enqueue front end and editor JavaScript
     */

    function ays_gpg_gutenberg_scripts() {
        $blockPath = 'gallery-photo-gallery-block.js';
        
        // Enqueue the bundled block JS file
        wp_enqueue_script(
            'gallery-photo-gallery-block-js',
            AYS_GPG_BASE_URL ."/gallery/". $blockPath,
            array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ),
            AYS_GALLERY_VERSION, true
        );
        // Enqueue the bundled block CSS file
        wp_enqueue_style(
            'gallery-photo-gallery-block-css',
            AYS_GPG_BASE_URL ."/gallery/gallery-photo-gallery-block.css",
            array(),
            AYS_GALLERY_VERSION, 'all'
        );
    }

    function ays_gpg_gutenberg_block_register() {
        
        global $wpdb;
        $block_name = 'gallery';
        $block_namespace = 'gallery-photo-gallery/' . $block_name;
        
        $sql = "SELECT * FROM ". $wpdb->prefix . "ays_gallery";
        $results = $wpdb->get_results($sql, "ARRAY_A");
        
        register_block_type(
            $block_namespace, 
            array(
                'render_callback'   => 'gallery_p_gallery_render_callback',
                'editor_script'     => 'gallery-photo-gallery-block-js',
                'style'             => 'gallery-photo-gallery-block-css',
                'attributes'	    => array(
                    'idner' => $results,
                    'metaFieldValue' => array(
                        'type'  => 'integer', 
                    ),
                    'shortcode' => array(
                        'type'  => 'string',				
                    ),
                ),
            )
        );
    }    
    
    function gallery_p_gallery_render_callback( $attributes ) {
        $ays_html = "<p style='text-align:center;'>" . __('Please select gallery') . "</p>";
        if(!empty($attributes["shortcode"])) {
            $ays_html = do_shortcode( $attributes["shortcode"] );
        }
        return $ays_html;
    }

if(function_exists("register_block_type")){
        // Hook scripts function into block editor hook
    add_action( 'enqueue_block_editor_assets', 'ays_gpg_gutenberg_scripts' );
    add_action( 'init', 'ays_gpg_gutenberg_block_register' );
} 