<?php
/**
 * Explore Theme Customizer
 *
 * @package ThemeGrill
 * @subpackage Explore
 * @since Explore 1.0
 */

function explore_customize_register( $wp_customize ) {
   // Transport postMessage variable set
   $customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

   $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
   $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
   $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


   if ( isset( $wp_customize->selective_refresh ) ) {
      $wp_customize->selective_refresh->add_partial( 'blogname', array(
         'selector'        => '#site-title a',
         'render_callback' => 'explore_customize_partial_blogname',
      ) );

      $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
         'selector'        => '#site-description',
         'render_callback' => 'explore_customize_partial_blogdescription',
      ) );
   }

   // Theme important links started
   class Explore_Important_Links extends WP_Customize_Control {

      public $type = "explore-important-links";

      public function render_content() {
         //Add Theme instruction, Support Forum, Demo Link, Rating Link
         $important_links = array(
            'support' => array(
               'link' => esc_url('https://themegrill.com/support-forum/'),
               'text' => __('Free Support', 'explore'),
            ),
            'documentation' => array(
               'link' => esc_url('https://themegrill.com/theme-instruction/explore/'),
               'text' => __('Documentation', 'explore'),
            ),
            'demo' => array(
               'link' => esc_url('https://demo.themegrill.com/explore/'),
               'text' => __('View Demo', 'explore'),
            ),
            'rating' => array(
               'link' => esc_url('http://wordpress.org/themes/explore/'),
               'text' => __('Rate this theme', 'explore'),
            ),
         );
         foreach ($important_links as $important_link) {
            echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr($important_link['text']) . ' </a></p>';
         }
         ?>
         <div align="center" style="padding:5px; background-color:#fafafa;border: 1px solid #CCC;margin-bottom: 10px;">
            <strong><?php esc_html_e( 'If you like our work. Buy us a beer.', 'explore' ); ?></strong>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
               <input type="hidden" name="cmd" value="_s-xclick">
               <input type="hidden" name="hosted_button_id" value="8AHDCA8CDGAJG">
               <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal">
               <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
            </form>
         </div>
         <?php
      }

   }

   $wp_customize->add_section('explore_important_links', array(
      'priority' => 700,
      'title' => __('About Explore', 'explore'),
   ));

   /**
    * This setting has the dummy Sanitization function as it contains no value to be sanitized
    */
   $wp_customize->add_setting('explore_important_links', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_links_sanitize'
   ));

   $wp_customize->add_control(new Explore_Important_Links($wp_customize, 'important_links', array(
      'section' => 'explore_important_links',
      'settings' => 'explore_important_links'
   )));
   // Theme Important Links Ended

   // Start of the Header Options
   // Header Options Area
   $wp_customize->add_panel('explore_header_options', array(
      'priority' => 500,
      'capabitity' => 'edit_theme_options',
      'title' => __('Header Options', 'explore')
   ));

   // Header logo and text display type option
   $wp_customize->add_setting('explore_show_header_logo_text', array(
      'default' => 'text_only',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control('explore_show_header_logo_text', array(
      'type' => 'radio',
      'label' => __('Choose the option that you want.', 'explore'),
      'section' => 'title_tagline',
      'choices' => array(
         'logo_only' => __( 'Header Logo Only', 'explore' ),
         'text_only' => __( 'Header Text Only', 'explore' ),
         'both' => __( 'Show Both', 'explore' ),
         'none' => __( 'Disable', 'explore' )
      )
   ));

   // Sticky Menu activate option
   $wp_customize->add_section('explore_sticky_menu_activate_section', array(
      'priority' => 2,
      'title' => __('Sticky Menu', 'explore'),
      'panel' => 'explore_header_options'
   ));

   $wp_customize->add_setting('explore_sticky_menu_activate', array(
      'default' => 1,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_checkbox_sanitize'
   ));

   $wp_customize->add_control('explore_sticky_menu_activate', array(
      'type' => 'checkbox',
      'label' => __('Check to make the primary menu sticky.', 'explore'),
      'section' => 'explore_sticky_menu_activate_section',
      'settings' => 'explore_sticky_menu_activate'
   ));

   // Header image position option
   $wp_customize->add_section('explore_header_image_position_section', array(
      'priority' => 3,
      'title' => __('Header Image Position', 'explore'),
      'panel' => 'explore_header_options'
   ));

   $wp_customize->add_setting('explore_header_image_position', array(
      'default' => 'above',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control('explore_header_image_position', array(
      'type' => 'radio',
      'label' => __('Choose top header image display position.', 'explore'),
      'section' => 'explore_header_image_position_section',
      'choices' => array(
         'above' => __( 'Position Above (Default): Display the Header image just above the site title and main menu part.', 'explore' ),
         'below' => __( 'Position Below: Display the Header image just below the site title and main menu part.', 'explore' )
      )
   ));

   // New Responsive Menu
   $wp_customize->add_section('explore_new_menu_style', array(
      'priority' => 4,
      'title' => esc_html__('Responsive Menu Style', 'explore'),
      'panel' => 'explore_header_options'
   ));
   $wp_customize->add_setting('explore_new_menu', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_checkbox_sanitize'
   ));
   $wp_customize->add_control('explore_new_menu', array(
      'type' => 'checkbox',
      'label' => esc_html__('Switch to new responsive menu', 'explore'),
      'section' => 'explore_new_menu_style',
      'settings' => 'explore_new_menu'
   ));
   // End of the Header Options

   // Start of the Design Options
   $wp_customize->add_panel('explore_design_options', array(
      'priority' => 505,
      'capabitity' => 'edit_theme_options',
      'title' => __('Design Options', 'explore')
   ));

   // site layout setting
   $wp_customize->add_section('explore_site_layout_section', array(
      'priority' => 2,
      'title' => __('Site Layout', 'explore'),
      'panel' => 'explore_design_options'
   ));

   $wp_customize->add_setting('explore_site_layout', array(
      'default'           => 'wide_layout',
      'capability'        => 'edit_theme_options',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control('explore_site_layout', array(
      'type' => 'radio',
      'label' => __('Choose your site layout. The change is reflected in whole site.', 'explore'),
      'choices' => array(
         'boxed_layout' => __( 'Boxed layout', 'explore' ),
         'wide_layout' => __( 'Wide layout', 'explore' ),
      ),
      'section' => 'explore_site_layout_section'
   ));

   class Explore_Image_Radio_Control extends WP_Customize_Control {

      public function render_content() {

         if ( empty( $this->choices ) )
            return;

         $name = '_customize-radio-' . $this->id;

         ?>
         <style>
            #explore-img-container .explore-radio-img-img {
               border: 3px solid #DEDEDE;
               margin: 0 5px 5px 0;
               cursor: pointer;
               border-radius: 3px;
               -moz-border-radius: 3px;
               -webkit-border-radius: 3px;
            }
            #explore-img-container .explore-radio-img-selected {
               border: 3px solid #AAA;
               border-radius: 3px;
               -moz-border-radius: 3px;
               -webkit-border-radius: 3px;
            }
            input[type=checkbox]:before {
               content: '';
               margin: -3px 0 0 -4px;
            }
         </style>
         <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
         <ul class="controls" id='explore-img-container'>
         <?php
            foreach ( $this->choices as $value => $label ) :
               $class = ($this->value() == $value)?'explore-radio-img-selected explore-radio-img-img':'explore-radio-img-img';
               ?>
               <li style="display: inline;">
               <label>
                  <input <?php $this->link(); ?>style='display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
                  <img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
               </label>
               </li>
               <?php
            endforeach;
         ?>
         </ul>
         <script type="text/javascript">
            jQuery(document).ready(function($) {
               $('.controls#explore-img-container li img').click(function(){
                  $('.controls#explore-img-container li').each(function(){
                     $(this).find('img').removeClass ('explore-radio-img-selected') ;
                  });
                  $(this).addClass ('explore-radio-img-selected') ;
               });
            });
         </script>
         <?php
      }
   }

   // default layout setting
   $wp_customize->add_section('explore_default_layout_section', array(
      'priority' => 3,
      'title' => __('Default layout', 'explore'),
      'panel'=> 'explore_design_options'
   ));

   $wp_customize->add_setting('explore_default_layout', array(
      'default' => 'both_sidebar',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control(new Explore_Image_Radio_Control($wp_customize, 'explore_default_layout', array(
      'type' => 'radio',
      'label' => __('Select default layout. This layout will be reflected in whole site archives, search etc. The layout for a single post and page can be controlled from below options.', 'explore'),
      'section' => 'explore_default_layout_section',
      'settings' => 'explore_default_layout',
      'choices' => array(
         'right_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/right_sidebar.png',
         'left_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/left_sidebar.png',
         'both_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/both_sidebar.jpg',
         'no_sidebar_full_width' => EXPLORE_ADMIN_IMAGES_URL . '/no_sidebar_full_width_layout.png',
         'no_sidebar_content_centered' => EXPLORE_ADMIN_IMAGES_URL . '/no_sidebar_content_centered_layout.png'
      )
   )));

   // default layout for pages
   $wp_customize->add_section('explore_default_page_layout_section', array(
      'priority' => 4,
      'title' => __('Default layout for pages only', 'explore'),
      'panel'=> 'explore_design_options'
   ));

   $wp_customize->add_setting('explore_pages_default_layout', array(
      'default' => 'both_sidebar',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control(new Explore_Image_Radio_Control($wp_customize, 'explore_pages_default_layout', array(
      'type' => 'radio',
      'label' => __('Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page.', 'explore'),
      'section' => 'explore_default_page_layout_section',
      'settings' => 'explore_pages_default_layout',
      'choices' => array(
         'right_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/right_sidebar.png',
         'left_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/left_sidebar.png',
         'both_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/both_sidebar.jpg',
         'no_sidebar_full_width' => EXPLORE_ADMIN_IMAGES_URL . '/no_sidebar_full_width_layout.png',
         'no_sidebar_content_centered' => EXPLORE_ADMIN_IMAGES_URL . '/no_sidebar_content_centered_layout.png'
      )
   )));

   // default layout for single posts
   $wp_customize->add_section('explore_default_single_posts_layout_setting', array(
      'priority' => 5,
      'title' => __('Default layout for single posts only', 'explore'),
      'panel'=> 'explore_design_options'
   ));

   $wp_customize->add_setting('explore_single_posts_default_layout', array(
      'default' => 'both_sidebar',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control(new Explore_Image_Radio_Control($wp_customize, 'explore_single_posts_default_layout', array(
      'type' => 'radio',
      'label' => __('Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post.', 'explore'),
      'section' => 'explore_default_single_posts_layout_setting',
      'settings' => 'explore_single_posts_default_layout',
      'choices' => array(
         'right_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/right_sidebar.png',
         'left_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/left_sidebar.png',
         'both_sidebar' => EXPLORE_ADMIN_IMAGES_URL . '/both_sidebar.jpg',
         'no_sidebar_full_width' => EXPLORE_ADMIN_IMAGES_URL . '/no_sidebar_full_width_layout.png',
         'no_sidebar_content_centered' => EXPLORE_ADMIN_IMAGES_URL . '/no_sidebar_content_centered_layout.png'
      )
   )));

   // blog posts display type
   $wp_customize->add_section('explore_blog_posts_display_section', array(
      'priority' => 6,
      'title' => __('Blog Posts display type', 'explore'),
      'panel' => 'explore_design_options'
   ));

   $wp_customize->add_setting('explore_archive_display_type', array(
      'default' => 'blog_medium',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control('explore_archive_display_type', array(
      'type' => 'radio',
      'label' => __('Choose the display type for your blog or category page', 'explore'),
      'choices' => array(
         'blog_large' => __( 'Large image and summary text', 'explore' ),
         'blog_medium' => __( 'Medium image and summary text', 'explore' ),
         'blog_medium_alternate' => __( 'Alternate position medium image and summary text', 'explore' ),
         'blog_full_content' => __( 'Large image and full content', 'explore' ),
      ),
      'section' => 'explore_blog_posts_display_section'
   ));

   // Site primary color option
   $wp_customize->add_section('explore_primary_color_section', array(
      'priority' => 7,
      'title'    => __('Primary color option', 'explore'),
      'panel'    => 'explore_design_options',
   ));

   $wp_customize->add_setting('explore_primary_color', array(
      'default'              => '#4cb0c6',
      'capability'           => 'edit_theme_options',
      'transport'            => 'postMessage',
      'sanitize_callback'    => 'explore_color_option_hex_sanitize',
      'sanitize_js_callback' => 'explore_color_escaping_option_sanitize'
   ));

   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'explore_primary_color', array(
      'label'    => __('This will reflect in links, buttons and many others. Choose a color to match your site.', 'explore'),
      'section'  => 'explore_primary_color_section',
      'settings' => 'explore_primary_color'
   )));

   // Site dark light skin option
   $wp_customize->add_section('explore_site_skin_section', array(
      'priority' => 8,
      'title' => __('Color Skin', 'explore'),
      'panel' => 'explore_design_options'
   ));

   $wp_customize->add_setting('explore_color_skin', array(
      'default' => 'light',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control('explore_color_skin', array(
      'type' => 'radio',
      'label' => __('Choose the light or dark skin. This will be reflected in whole site.', 'explore'),
      'section' => 'explore_site_skin_section',
      'settings' => 'explore_color_skin',
      'choices' => array(
         'light' => __('Light', 'explore'),
         'dark' => __('Dark', 'explore')
      )
   ));

	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
	   // Custom CSS setting
	   $wp_customize->add_section('explore_custom_css_section', array(
	      'priority' => 9,
	      'title' => __('Custom CSS', 'explore'),
	      'panel' => 'explore_design_options'
	   ));

	   $wp_customize->add_setting('explore_custom_css', array(
	      'default' => '',
	      'capability' => 'edit_theme_options',
	      'sanitize_callback' => 'wp_filter_nohtml_kses',
	      'sanitize_js_callback' => 'wp_filter_nohtml_kses'
	   ));

	   $wp_customize->add_control('explore_custom_css', array(
	      'type' => 'textarea',
	      'label' => __('Write your custom CSS code here and design live.', 'explore'),
	      'section' => 'explore_custom_css_section',
	      'settings' => 'explore_custom_css'
	   ));
	}
   // End of the Design Options

   // Start of the Additional Options
   $wp_customize->add_panel('explore_additional_options', array(
      'priority' => 515,
      'title' => __('Additional Options', 'explore'),
      'capability' => 'edit_theme_options',
   ));

   // related posts
   $wp_customize->add_section('explore_related_posts_section', array(
      'priority' => 1,
      'title' => __('Related Posts', 'explore'),
      'panel' => 'explore_additional_options'
   ));

   $wp_customize->add_setting('explore_related_posts_activate', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_checkbox_sanitize'
   ));

   $wp_customize->add_control('explore_related_posts_activate', array(
      'type' => 'checkbox',
      'label' => __('Check to activate the related posts.', 'explore'),
      'section' => 'explore_related_posts_section',
      'settings' => 'explore_related_posts_activate'
   ));

   $wp_customize->add_setting('explore_related_posts', array(
      'default' => 'categories',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_radio_select_sanitize'
   ));

   $wp_customize->add_control('explore_related_posts', array(
      'type' => 'radio',
      'label' => __('Related Posts To Be Shown As:', 'explore'),
      'section' => 'explore_related_posts_section',
      'settings' => 'explore_related_posts',
      'choices' => array(
         'categories' => __('Related Posts By Categories', 'explore'),
         'tags' => __('Related Posts By Tags', 'explore')
      )
   ));

   // featured image disable in single post check
   $wp_customize->add_section('explore_featured_image_disable_section', array(
      'priority' => 2,
      'title' => __('Remove Featured Image', 'explore'),
      'panel' => 'explore_additional_options'
   ));

   $wp_customize->add_setting('explore_featured_image_disable', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_checkbox_sanitize'
   ));

   $wp_customize->add_control('explore_featured_image_disable', array(
      'type' => 'checkbox',
      'label' => __('Check to disable the featured images in single post.', 'explore'),
      'section' => 'explore_featured_image_disable_section',
      'settings' => 'explore_featured_image_disable'
   ));

   // author bio enable/disable
   $wp_customize->add_section('explore_enable_author_bio_section', array(
      'priority' => 3,
      'title' => __('Author Bio', 'explore'),
      'panel' => 'explore_additional_options'
   ));

   $wp_customize->add_setting('explore_enable_author_bio', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'explore_checkbox_sanitize'
   ));

   $wp_customize->add_control('explore_enable_author_bio', array(
      'type' => 'checkbox',
      'label' => __('Check to enable the Author Bio in single post.', 'explore'),
      'section' => 'explore_enable_author_bio_section',
      'settings' => 'explore_enable_author_bio'
   ));
   // End of the Additional Options

   // Start of the Slider Options
   $wp_customize->add_panel('explore_slider_options', array(
      'priority' => 520,
      'title' => __('Slider Options', 'explore'),
      'capability' => 'edit_theme_options',
   ));

   // slider section
   $wp_customize->add_section('explore_slider_activate_section', array(
      'priority' => 1,
      'title' => __('Activate slider', 'explore'),
      'panel' => 'explore_slider_options',
      'description' => __('In order to show a slider, you must have the featured image associated with the respective page choosen from below option.', 'explore')
   ));

   $wp_customize->add_setting('explore_activate_slider', array(
      'default'           => 0,
      'capability'        => 'edit_theme_options',
      'transport'         => $customizer_selective_refresh,
      'sanitize_callback' => 'explore_checkbox_sanitize'
   ));

   $wp_customize->add_control('explore_activate_slider', array(
      'type'     => 'checkbox',
      'label'    => __('Check to activate slider.', 'explore'),
      'section'  => 'explore_slider_activate_section',
      'settings' => 'explore_activate_slider'
   ));

   // Selective refresh for slider activation
   if ( isset( $wp_customize->selective_refresh ) ) {
      $wp_customize->selective_refresh->add_partial( 'explore_activate_slider', array(
         'selector'        => '.bx-wrapper',
         'render_callback' => '',
      ) );
   }

   // slider pages select
   for( $i = 1; $i <= 5; $i++ ) {

      $wp_customize->add_section('explore_slider_image_section'.$i, array(
         'title' => __( 'Slider #', 'explore' ).$i,
         'panel' => 'explore_slider_options',
      ));

      $wp_customize->add_setting('explore_slider_image'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'explore_slider_page_sanitize_integer'
      ));

      $wp_customize->add_control('explore_slider_image'.$i, array(
         'label' => __( 'Slider Page ', 'explore' ).$i,
         'section' => 'explore_slider_image_section'.$i,
         'type'   => 'dropdown-pages',
      ));

      // slider options settings one
      $wp_customize->add_setting('explore_slider_first_button_text'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'wp_filter_nohtml_kses'
      ));

      $wp_customize->add_control('explore_slider_first_button_text'.$i, array(
         'label' => __( 'Enter the first button text.', 'explore' ),
         'description' => '<strong>'.__('When this field is empty, Read More button is shown.','explore').'</strong>',
         'section' => 'explore_slider_image_section'.$i,
      ));

      $wp_customize->add_setting('explore_slider_first_button_link'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'esc_url_raw'
      ));

      $wp_customize->add_control('explore_slider_first_button_link'.$i, array(
         'label' => __( 'Enter link to redirect for the first button.', 'explore' ),
         'description' => '<strong>'.__('When this field is empty, the link will be redirected default to the page link.','explore').'</strong>',
         'section' => 'explore_slider_image_section'.$i,
      ));

      // slider options settings two
      $wp_customize->add_setting('explore_slider_second_button_text'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'wp_filter_nohtml_kses'
      ));

      $wp_customize->add_control('explore_slider_second_button_text'.$i, array(
         'label' => __( 'Enter the second button text.', 'explore' ),
         'section' => 'explore_slider_image_section'.$i,
      ));

      $wp_customize->add_setting('explore_slider_second_button_link'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'esc_url_raw'
      ));

      $wp_customize->add_control('explore_slider_second_button_link'.$i, array(
         'label' => __( 'Enter link to redirect for the second button.', 'explore' ),
         'section' => 'explore_slider_image_section'.$i,
      ));

   }
   // End of the Slider Options

   // Sanitization start
   // radio/select buttons sanitization
   function explore_radio_select_sanitize( $input, $setting ) {
      // Ensuring that the input is a slug.
      $input = sanitize_key( $input );
      // Get the list of choices from the control associated with the setting.
      $choices = $setting->manager->get_control( $setting->id )->choices;
      // If the input is a valid key, return it, else, return the default.
      return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
   }

   // checkbox sanitize
   function explore_checkbox_sanitize($input) {
      if ( $input == 1 ) {
         return 1;
      } else {
         return '';
      }
   }

   // color sanitization
   function explore_color_option_hex_sanitize($color) {
      if ($unhashed = sanitize_hex_color_no_hash($color))
         return '#' . $unhashed;

      return $color;
   }

   function explore_color_escaping_option_sanitize($input) {
      $input = esc_attr($input);
      return $input;
   }

   // slider pages number sanitization
   function explore_slider_page_sanitize_integer( $input ) {
      if( is_numeric( $input ) ) {
        return intval( $input );
      }
   }

   // sanitization of links
   function explore_links_sanitize() {
      return false;
   }

}

add_action('customize_register', 'explore_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since explore 1.0.8
 */
function explore_customize_preview_js() {
   wp_enqueue_script( 'explore-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), false, true );
}
add_action( 'customize_preview_init', 'explore_customize_preview_js' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function explore_customize_partial_blogname() {
   bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function explore_customize_partial_blogdescription() {
   bloginfo( 'description' );
}

