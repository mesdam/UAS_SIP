<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/admin
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Gallery_Photo_Gallery_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $gallery_obj;
    private $cats_obj;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_filter( 'set-screen-option', array( __CLASS__, 'set_screen' ), 10, 3 );
        $per_page_array = array(
            'galleries_per_page',
            'gallery_categories_per_page',
        );
        foreach($per_page_array as $option_name){
            add_filter('set_screen_option_'.$option_name, array(__CLASS__, 'set_screen'), 10, 3);
        }

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook_suffix) {
        
	    wp_enqueue_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-color-picker' );
        
        if(false === strpos($hook_suffix, $this->plugin_name))
            return;

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gallery_Photo_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gallery_Photo_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.4.1/css/all.css', array(), $this->version, 'all');
		wp_enqueue_style( 'ays_pb_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name."-mosaic.css", plugin_dir_url( __FILE__ ) . 'css/jquery.mosaic.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name."-masonry.css", plugin_dir_url( __FILE__ ) . 'css/masonry.pkgd.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gallery-photo-gallery-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'animate.css', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook_suffix) {
        global $wp_version;
        
        $version1 = $wp_version;
        $operator = '>=';
        $version2 = '5.5';
        $versionCompare = $this->versionCompare($version1, $operator, $version2);

        if ($versionCompare) {
            wp_enqueue_script( $this->plugin_name.'-wp-load-scripts', plugin_dir_url(__FILE__) . 'js/ays-wp-load-scripts.js', array(), $this->version, true);
        }

        if (false !== strpos($hook_suffix, "plugins.php")){
            wp_enqueue_script( 'sweetalert-js', '//cdn.jsdelivr.net/npm/sweetalert2@7.26.29/dist/sweetalert2.all.min.js', array('jquery'), $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-adminjs', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, true );
            wp_localize_script($this->plugin_name . '-adminjs',  'ays_gpg_admin_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
        }
        
        if(false === strpos($hook_suffix, $this->plugin_name))
            return;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gallery_Photo_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gallery_Photo_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_media();
        
		wp_enqueue_script( "ays_pb_popper", 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_style('ays_gpg_code_mirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.css', array(), $this->version, 'all');
		wp_enqueue_script( "ays_pb_bootstrap", 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( 'select2js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', array('jquery'), $this->version, true );
        wp_enqueue_script( 'imagesloaded.min.js', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name."-mosaic.js", plugin_dir_url( __FILE__ ) . 'js/jquery.mosaic.min.js', array( 'jquery', 'wp-color-picker'  ), $this->version, true );
		wp_enqueue_script( $this->plugin_name."-masonry.js", plugin_dir_url( __FILE__ ) . 'js/masonry.pkgd.min.js', array( 'jquery', 'wp-color-picker'  ), $this->version, true );
		wp_enqueue_script( $this->plugin_name."-cookie.js", plugin_dir_url( __FILE__ ) . 'js/cookie.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gallery-photo-gallery-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
        $cats = $this->ays_get_gallery_categories();
        wp_localize_script($this->plugin_name,  'ays_gpg_admin', array(
            'categories' => $cats
        ));
        wp_enqueue_script( $this->plugin_name.'-wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wp-color-picker-alpha.min.js',array( 'wp-color-picker' ),$this->version, true );

        $color_picker_strings = array(
            'clear'            => __( 'Clear', $this->plugin_name ),
            'clearAriaLabel'   => __( 'Clear color', $this->plugin_name ),
            'defaultString'    => __( 'Default', $this->plugin_name ),
            'defaultAriaLabel' => __( 'Select default color', $this->plugin_name ),
            'pick'             => __( 'Select Color', $this->plugin_name ),
            'defaultLabel'     => __( 'Color value', $this->plugin_name ),
        );
        wp_localize_script( $this->plugin_name.'-wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );
	}

    function codemirror_enqueue_scripts($hook) {
        if (false === strpos($hook, $this->plugin_name)){
            return;
        }
        if(function_exists('wp_enqueue_code_editor')){
            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
                'type' => 'text/css',
                'codemirror' => array(
                    'inputStyle' => 'contenteditable',
                    'theme' => 'cobalt',
                )
            ));

            wp_enqueue_script('wp-theme-plugin-editor');
            wp_localize_script('wp-theme-plugin-editor', 'cm_gpg_settings', $cm_settings);
        
            wp_enqueue_style('wp-codemirror');
        }
    }

    function versionCompare($version1, $operator, $version2) {
   
        $_fv = intval ( trim ( str_replace ( '.', '', $version1 ) ) );
        $_sv = intval ( trim ( str_replace ( '.', '', $version2 ) ) );
       
        if (strlen ( $_fv ) > strlen ( $_sv )) {
            $_sv = str_pad ( $_sv, strlen ( $_fv ), 0 );
        }
       
        if (strlen ( $_fv ) < strlen ( $_sv )) {
            $_fv = str_pad ( $_fv, strlen ( $_sv ), 0 );
        }
       
        return version_compare ( ( string ) $_fv, ( string ) $_sv, $operator );
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {
        
        $hook_gallery = add_menu_page( 
            __('Photo Gallery', $this->plugin_name), 
            __('Photo Gallery', $this->plugin_name), 
            'manage_options', 
            $this->plugin_name, 
            array($this, 'display_plugin_setup_page'), AYS_GPG_ADMIN_URL . 'images/gall_icon.png', 6);
        add_action( "load-$hook_gallery", array( $this, 'screen_option_gallery' ) );
        
        $hook_gallery = add_submenu_page(
            $this->plugin_name,
            __('Galleries', $this->plugin_name),
            __('Galleries', $this->plugin_name),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );
        add_action( "load-$hook_gallery", array( $this, 'screen_option_gallery' ) );

        $hook_gallery_categories = add_submenu_page(
            $this->plugin_name,
            __('Categories', $this->plugin_name),
            __('Categories', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-categories',
            array($this, 'display_plugin_gpg_categories_page')
        );

        add_action("load-$hook_gallery_categories", array($this, 'screen_option_gallery_cats'));

        add_submenu_page(
            $this->plugin_name,
            __('PRO Features', $this->plugin_name),
            __('PRO Features', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-pro-features',
            array($this, 'display_plugin_gpg_features_page')
        );
        
        add_submenu_page(
            $this->plugin_name,
            __('Featured Plugins', $this->plugin_name),
            __('Featured Plugins', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_gpg_featured_plugins_page')
        );

    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
        $action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';

        switch ( $action ) {
            case 'add':
                include_once( 'partials/actions/gallery-photo-gallery-admin-actions.php' );
                break;
            case 'edit':
                include_once( 'partials/actions/gallery-photo-gallery-admin-actions.php' );
                break;
            default:
                include_once( 'partials/gallery-photo-gallery-admin-display.php' );
        }
    }

    public function display_plugin_gpg_categories_page(){
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
            case 'add':
                include_once('partials/categories/actions/gallery-photo-gallery-categories-actions.php');
                break;
            case 'edit':
                include_once('partials/categories/actions/gallery-photo-gallery-categories-actions.php');
                break;
            default:
                include_once('partials/categories/gallery-photo-gallery-categories-display.php');
        }
    }

    public function display_plugin_gpg_features_page()
    {
        include_once('partials/features/gallery-photo-gallery-features-display.php');
    }
    
    public function display_plugin_gpg_featured_plugins_page()
    {
        include_once('partials/features/gallery-photo-gallery-featured-plugins.php');
    }

    public static function set_screen( $status, $option, $value ) {
        return $value;
    }


    public function screen_option_gallery() {
        $option = 'per_page';
        $args   = [
            'label'   => __('Galleries', $this->plugin_name),
            'default' => 20,
            'option'  => 'galleries_per_page'
        ];

        add_screen_option( $option, $args );
        $this->gallery_obj = new Galleries_List_Table($this->plugin_name);
    }

    public function screen_option_gallery_cats() {
        $option = 'per_page';
        $args   = array(
            'label'   => __('Categories', $this->plugin_name),
            'default' => 5,
            'option'  => 'gallery_categories_per_page',
        );

        add_screen_option($option, $args);
        $this->cats_obj = new Gpg_Categories_List_Table($this->plugin_name);
    }

    public static function ays_get_gallery_categories(){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_gallery_categories";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    public static function ays_get_gpg_options(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ays_gallery';
        $res = $wpdb->get_results("SELECT id, title, width, height FROM ".$table_name."");
        $aysGlobal_array = array();

        foreach($res as $ays_res_options){
            $aysStatic_array = array();
            $aysStatic_array[] = $ays_res_options->id;
            $aysStatic_array[] = $ays_res_options->title;
            $aysStatic_array[] = $ays_res_options->width;
            $aysStatic_array[] = $ays_res_options->height;
            $aysGlobal_array[] = $aysStatic_array;
        }
        return $aysGlobal_array;
      }
    
    function ays_gpg_register_tinymce_plugin($plugin_array) {
        $plugin_array['ays_gpg_button_mce'] = AYS_GPG_BASE_URL .'/ays_gpg_shortcode.js';
        return $plugin_array;
    }
    
    function ays_gpg_add_tinymce_button($buttons) {
        $buttons[] = "ays_gpg_button_mce";
        return $buttons;
    }
    
    function gen_ays_gpg_shortcode_callback() {
        $shortcode_data = $this->ays_get_gpg_options();

        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title><?php echo __( 'Gallery Photo Gallery', $this->plugin_name ); ?></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>

                <?php
                    wp_print_scripts('jquery');
                ?>
                <base target="_self">
            </head>
            <body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" dir="ltr" class="forceColors">
                <div class="select-sb">

              <table align="center">
                  <tr>
                    <td><label for="ays_gpg">Gallery</label></td>
                    <td>
                      <span>
                        <select id="ays_gpg" style="padding: 2px; height: 25px; font-size: 16px;width:100%;">
                            <option>--Select Gallery--</option>
                                <?php foreach($shortcode_data as $index=>$data)
                                    echo '<option id="'.$data[0].'" value="'.$data[0].'" mw="'.$data[2].'" mh="'.$data[3].'" class="ays_gpg_options">'.$data[1].'</option>';
                                ?>
                        </select>
                        </span>
                    </td>
                  </tr>
              </table>
                </div>
                <div class="mceActionPanel">
                    <input type="submit" id="insert" name="insert" value="Insert" onClick="gpg_insert_shortcode();"/>
                </div>
            <script type="text/javascript">
                function gpg_insert_shortcode() {
                    var tagtext = '[gallery_p_gallery id="' + document.getElementById('ays_gpg')[document.getElementById('ays_gpg').selectedIndex].id + '"]';
                    window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
                    tinyMCEPopup.close();
                }
              </script>

            </body>
          </html>
          <?php
          die();
      }
    
    
    public function ays_get_all_image_sizes() {
        $image_sizes = array();
        global $_wp_additional_image_sizes;
        $default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );

        foreach ( $default_image_sizes as $size ) {
            $image_sizes[$size]['width']	= intval( get_option( "{$size}_size_w") );
            $image_sizes[$size]['height'] = intval( get_option( "{$size}_size_h") );
            $image_sizes[$size]['crop']	= get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
        }

        if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) )
            $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );

        return $image_sizes;
    }

    public static function ays_restriction_string($type, $x, $length){
        $output = "";
        switch($type){
            case "char":                
                if(strlen($x)<=$length){
                    $output = $x;
                } else {
                    $output = substr($x,0,$length) . '...';
                }
                break;
            case "word":
                $res = explode(" ", $x);
                if(count($res)<=$length){
                    $output = implode(" ",$res);
                } else {
                    $res = array_slice($res,0,$length);
                    $output = implode(" ",$res) . '...';
                }
            break;
        }
        return $output;
    }
    
    public function vc_before_init_actions() {
        require_once( AYS_GPG_DIR.'pb_templates/gallery_photo_gallery_wpbvc.php' );
    }

    public function gpg_el_widgets_registered() {
        // We check if the Elementor plugin has been installed / activated.

        if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
            // get our own widgets up and running:
            // copied from widgets-manager.php
            if ( class_exists( 'Elementor\Plugin' ) ) {
                if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {
                    $elementor = Elementor\Plugin::instance();
                    if ( isset( $elementor->widgets_manager ) ) {
                        if ( method_exists( $elementor->widgets_manager, 'register_widget_type' ) ) {
                            $widget_file   = 'plugins/elementor/gallery_photo_gallery_elementor.php';
                            $template_file = locate_template( $widget_file );
                            if ( !$template_file || !is_readable( $template_file ) ) {
                                $template_file = AYS_GPG_DIR.'pb_templates/gallery_photo_gallery_elementor.php';
                            }
                            if ( $template_file && is_readable( $template_file ) ) {
                                require_once $template_file;
                                Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_GPG_Custom_Elementor_Thing() );
                            }
                        }
                    }
                }
            }
        }
    }

    public function deactivate_plugin_option(){
        $request_value = $_REQUEST['upgrade_plugin'];
        $upgrade_option = get_option('ays_gallery_photo_gallery_upgrade_plugin','');
        if($upgrade_option === ''){
            add_option('ays_gallery_photo_gallery_upgrade_plugin',$request_value);
        }else{
            update_option('ays_gallery_photo_gallery_upgrade_plugin',$request_value);
        }
        echo json_encode(array('option'=>get_option('ays_gallery_photo_gallery_upgrade_plugin','')));
        wp_die();
    }
}
