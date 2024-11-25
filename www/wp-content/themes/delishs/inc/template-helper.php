<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package delishs
 */

/** 
 *
 * delishs header
 */
   
 function get_header_style($style){
    if ( $style == 'header-style-2'  ) {
        get_template_part( 'template-parts/header/header-2' );
    }
    elseif ( $style == 'header-style-3'  ) {
        get_template_part( 'template-parts/header/header-3' );
    }
    else{
        get_template_part( 'template-parts/header/header-1');
    }
}

function delishs_check_header() {
    $header_tabs = function_exists( 'get_field' ) ? get_field( 'header_tabs' ) : NULL;
    $header_style_meta = function_exists( 'get_field' ) ? get_field( 'header_style' ) : NULL;
    $elementor_header_template_meta = function_exists( 'get_field' ) ? get_field( 'header_templates' ) : NULL;

    $header_elementor_switch = get_theme_mod('header_elementor_switch', false);
    $header_default_style_customizer = get_theme_mod( 'choose_default_header', 'header-style-1' );
    $elementor_header_templates_customizer = get_theme_mod( 'header_templates' );
    
    if($header_tabs == 'default'){
        if($header_elementor_switch){
            if($elementor_header_templates_customizer){
                echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_header_templates_customizer);
            }
        }else{ 
            if($header_default_style_customizer){
                get_header_style($header_default_style_customizer);
            }else{
                get_template_part( 'template-parts/header/header-1' );
            }
        }
    }elseif($header_tabs == 'custom'){
        if ($header_style_meta) {
            get_header_style($header_style_meta);
        }else{
            get_header_style($header_default_style_customizer);
        }  
    }elseif($header_tabs == 'elementor'){
        if($elementor_header_template_meta){
            echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_header_template_meta);
        }else{
            echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_header_templates_customizer);
        }
    }else{
        if($header_elementor_switch){

            if($elementor_header_templates_customizer){
                echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_header_templates_customizer);
            }else{
                get_template_part( 'template-parts/header/header-1' );
            }
        }else{
            get_header_style($header_default_style_customizer);

        }
        
    }

}
add_action( 'delishs_header_style', 'delishs_check_header', 10 );

/**
 * [delishs_header_lang description]
 * @return [type] [description]
 */
function delishs_header_lang_default() {
    $delishs_header_lang = get_theme_mod( 'delishs_header_lang', false );
    if ( $delishs_header_lang ): ?>

    <ul>
        <li><a href="javascript:void(0)"><?php print esc_html__( 'English', 'delishs' );?> <i class="fas fa-angle-down"></i></a>
        <?php do_action( 'delishs_language' );?>
        </li>
    </ul>

    <?php endif;?>
<?php
}

/**
 * [delishs_language_list description]
 * @return [type] [description]
 */
function _delishs_language( $mar ) {
    return $mar;
}
function delishs_language_list() {

    $mar = '';
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    if ( !empty( $languages ) ) {
        $mar = '<ul>';
        foreach ( $languages as $lan ) {
            $active = $lan['active'] == 1 ? 'active' : '';
            $mar .= '<li class="' . $active . '"><a href="' . $lan['url'] . '">' . $lan['translated_name'] . '</a></li>';
        }
        $mar .= '</ul>';
    } else {
        //remove this code when send themeforest reviewer team
        $mar .= '<ul>';
        $mar .= '<li><a href="#">' . esc_html__( 'English', 'delishs' ) . '</a></li>';
        $mar .= '<li><a href="#">' . esc_html__( 'Dutch', 'delishs' ) . '</a></li>';
        $mar .= '<li><a href="#">' . esc_html__( 'Arabic', 'delishs' ) . '</a></li>';
        $mar .= '<li><a href="#">' . esc_html__( 'French', 'delishs' ) . '</a></li>';
        $mar .= ' </ul>';
    }
    print _delishs_language( $mar );
}
add_action( 'delishs_language', 'delishs_language_list' );


// header logo
function delishs_header_logo() { ?>
        <?php
        $delishs_logo_on = function_exists( 'get_field' ) ? get_field( 'is_enable_sec_logo' ) : NULL;
        $delishs_logo = get_template_directory_uri() . '/assets/imgs/logo/logo.png';
        $delishs_logo_secondery = get_template_directory_uri() . '/assets/imgs/logo/logo-white.png';

        $delishs_site_logo = get_theme_mod( 'logo', $delishs_logo );
        $delishs_secondary_logo = get_theme_mod( 'secondary_logo', $delishs_logo_secondery );
        ?>

        <?php if ( !empty( $delishs_logo_on ) ) : ?>
            <a href="<?php print esc_url( home_url( '/' ) );?>">
                <div class="logo">
                    <img src="<?php print esc_url( $delishs_secondary_logo );?>" alt="<?php print esc_attr__( 'logo', 'delishs' );?>">
                </div>
            </a>
        <?php else : ?>
            <a href="<?php print esc_url( home_url( '/' ) );?>">
                <div class="logo">
                    <img src="<?php print esc_url( $delishs_site_logo );?>" alt="<?php print esc_attr__( 'logo', 'delishs' );?>">
                </div>
            </a>
        <?php endif; ?>
   <?php
}

function delishs_header_logo_two() { ?>
        <?php
        $delishs_logo_on = function_exists( 'get_field' ) ? get_field( 'is_enable_sec_logo' ) : NULL;
        $delishs_logo = get_template_directory_uri() . '/assets/imgs/logo/logo-white-2.png';
        $delishs_logo_secondery = get_template_directory_uri() . '/assets/imgs/logo/logo.png';

        $delishs_site_logo = get_theme_mod( 'third_logo', $delishs_logo );
        $delishs_secondary_logo = get_theme_mod( 'secondary_logo', $delishs_logo_secondery );
        ?>

        <?php if ( !empty( $delishs_logo_on ) ) : ?>
            <a href="<?php print esc_url( home_url( '/' ) );?>">
                <div class="logo">
                    <img src="<?php print esc_url( $delishs_secondary_logo );?>" alt="<?php print esc_attr__( 'logo', 'delishs' );?>">
                </div>
            </a>
        <?php else : ?>
            <a href="<?php print esc_url( home_url( '/' ) );?>">
                <div class="logo">
                    <img src="<?php print esc_url( $delishs_site_logo );?>" alt="<?php print esc_attr__( 'logo', 'delishs' );?>">
                </div>
            </a>
        <?php endif; ?>
   <?php
}

// header logo
function delishs_header_sticky_logo() {?>
    <?php
        $delishs_logo_secondery = get_template_directory_uri() . '/assets/images/resources/logo-2.png';
        $delishs_secondary_logo = get_theme_mod( 'secondary_logo', $delishs_logo_secondery );
    ?>
      <a class="sticky-logo" href="<?php print esc_url( home_url( '/' ) );?>">
          <img src="<?php print esc_url( $delishs_secondary_logo );?>" alt="<?php print esc_attr__( 'logo', 'delishs' );?>" />
      </a>
    <?php
}

function delishs_search_logo() {
    
    $delishs_logo_secondery = get_template_directory_uri() . '/assets/imgs/logo/logo-white.png';
    $delishs_secondary_logo = get_theme_mod( 'secondary_logo', $delishs_logo_secondery );

    ?>

    <?php if ( !empty( $delishs_secondary_logo ) ): ?>
        <a href="<?php print esc_url( home_url( '/' ) );?>">
            <img src="<?php print esc_url( $delishs_secondary_logo );?>" alt="<?php print esc_attr__( 'logo', 'delishs' );?>">
        </a>
    <?php endif;?>



<?php }

/**
 * [delishs_header_social_profiles description]
 * @return [type] [description]
 */
function delishs_header_social_profiles() {
    $delishs_topbar_fb_url = get_theme_mod( 'delishs_topbar_fb_url', __( '#', 'delishs' ) );
    $delishs_topbar_twitter_url = get_theme_mod( 'delishs_topbar_twitter_url', __( '#', 'delishs' ) );
    $delishs_topbar_instagram_url = get_theme_mod( 'delishs_topbar_instagram_url', __( '#', 'delishs' ) );
    $delishs_topbar_pinterest_url = get_theme_mod( 'delishs_topbar_pinterest_url', __( '#', 'delishs' ) );
    $delishs_topbar_linkedin_url = get_theme_mod( 'delishs_topbar_linkedin_url' );
    $delishs_topbar_youtube_url = get_theme_mod( 'delishs_topbar_youtube_url' );
    ?>
        <?php if ( !empty( $delishs_topbar_fb_url ) ): ?>
            <li><a href="<?php print esc_url( $delishs_topbar_fb_url );?>"><i class="fab fa-facebook"></i></a></li>
        <?php endif;?>
        <?php if ( !empty( $delishs_topbar_twitter_url ) ): ?>
            <li><a href="<?php print esc_url( $delishs_topbar_twitter_url );?>"><i class="fab fa-twitter"></i></a></li>
        <?php endif;?>
        <?php if ( !empty( $delishs_topbar_instagram_url ) ): ?>
            <li><a href="<?php print esc_url( $delishs_topbar_instagram_url );?>"><i class="fab fa-youtube"></i></a></li>
        <?php endif;?>
        <?php if ( !empty( $delishs_topbar_pinterest_url ) ): ?>
            <li><a href="<?php print esc_url( $delishs_topbar_pinterest_url );?>"><i class="fab fa-pinterest-p"></i></a></li>
        <?php endif;?>
        <?php if ( !empty( $delishs_topbar_linkedin_url ) ): ?>
            <li><a href="<?php print esc_url( $delishs_topbar_linkedin_url );?>"><i class="fab fa-linkedin"></i></a></li>
        <?php endif;?>
        <?php if ( !empty( $delishs_topbar_youtube_url ) ): ?>
            <li><a href="<?php print esc_url( $delishs_topbar_youtube_url );?>"><i class="fab fa-youtube"></i></a></li>
        <?php endif;?>
    <?php
}

/**
 * [delishs_header_menu description]
 * @return [type] [description]
 */
function delishs_header_menu() {
    ?>
    <?php
        wp_nav_menu( [
            'theme_location' => 'main-menu',
            'menu_class'     => 'sub-menu main-menu__list',
            'container'      => '',
            'fallback_cb'    => 'Delishs_Navwalker_Class::fallback',
            'walker'         => new Delishs_Navwalker_Class,
        ] );
    ?>
    <?php
}

/**
 * [delishs_footer_bottom_menu description]
 * @return [type] [description]
 */
function delishs_footer_bottom_menu() {
    ?>
    <?php
        wp_nav_menu( [
            'theme_location' => 'footer-bottom-menu',
            'menu_class'     => 'copyright-list',
            'container'      => '',
            'fallback_cb'    => 'Delishs_Navwalker_Class::fallback',
            'walker'         => new Delishs_Navwalker_Class,
        ] );
    ?>
    <?php
}

/**
 * [delishs_header_menu description]
 * @return [type] [description]
 */
function delishs_mobile_menu() {
    ?>
    <?php
        $delishs_menu = wp_nav_menu( [
            'theme_location' => 'main-menu',
            'menu_class'     => '',
            'container'      => '',
            'menu_id'        => 'mobile-menu',
            'echo'           => false,
        ] );

    $delishs_menu = str_replace( "menu-item-has-children", "menu-item-has-children has-children", $delishs_menu );
        echo wp_kses_post( $delishs_menu );
    ?>
    <?php
}

/**
 *
 * delishs footer
 */

 function get_footer_style($style){
    if ( $style == 'footer-style-2'  ) {
        get_template_part( 'template-parts/footer/footer-2' );
    }
    else{
        get_template_part( 'template-parts/footer/footer-1');
    }
}

function delishs_check_footer() {
    $bixola_page_info = get_post_meta( get_the_ID(), 'bixola_page_info', true);
    
    $footer_tabs = function_exists( 'get_field' ) ? get_field( 'footer_tabs' ) : NULL;
    $footer_style_meta = function_exists( 'get_field' ) ? get_field( 'footer_style' ) : NULL;
    $elementor_footer_template_meta = function_exists( 'get_field' ) ? get_field( 'footer_templates' ) : NULL;

    $footer_elementor_switch = get_theme_mod('footer_elementor_switch', false);
    $footer_default_style_customizer = get_theme_mod( 'choose_default_footer', 'footer-style-1'  );
    $elementor_footer_templates_customizer = get_theme_mod( 'footer_templates' );
    
    if($footer_tabs == 'default'){
        if($footer_elementor_switch){
            if($elementor_footer_templates_customizer){
                echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_footer_templates_customizer);
            }
        }else{ 
            if($footer_default_style_customizer){
                get_footer_style($footer_default_style_customizer);
            }else{
                get_template_part( 'template-parts/footer/footer-1' );
            }
        }
    }elseif($footer_tabs == 'custom'){
        if ($footer_style_meta) {
            get_footer_style($footer_style_meta);
        }else{
            get_footer_style($footer_default_style_customizer);
        }  
    }elseif($footer_tabs == 'elementor'){
        if($elementor_footer_template_meta){
            echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_footer_template_meta);
        }else{
            echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_footer_templates_customizer);
        }
    }else{
        if($footer_elementor_switch){

            if($elementor_footer_templates_customizer){
                echo \Elementor\Plugin::$instance->frontend->get_builder_content($elementor_footer_templates_customizer);
            }else{
                get_template_part( 'template-parts/footer/footer-1' );
            }
        }else{
            get_footer_style($footer_default_style_customizer);

        }
        
    }

}
add_action( 'delishs_footer_style', 'delishs_check_footer', 10 );

// delishs_copyright_text
function delishs_copyright_text() {
   print get_theme_mod( 'delishs_copyright', esc_html__( 'Copyright ©2024 Delishs All Rights Reserved.', 'delishs' ) );
}


/**
 *
 * pagination
 */
if ( !function_exists( 'delishs_pagination' ) ) {

    function _delishs_pagi_callback( $pagination ) {
        return $pagination;
    }

    //page navegation
    function delishs_pagination( $prev, $next, $pages, $args ) {
        global $wp_query, $wp_rewrite;
        $menu = '';
        $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

        if ( $pages == '' ) {
            global $wp_query;
            $pages = $wp_query->max_num_pages;

            if ( !$pages ) {
                $pages = 1;
            }

        }

        $pagination = [
            'base'      => add_query_arg( 'paged', '%#%' ),
            'format'    => '',
            'total'     => $pages,
            'current'   => $current,
            'prev_text' => $prev,
            'next_text' => $next,
            'type'      => 'array',
        ];

        //rewrite permalinks
        if ( $wp_rewrite->using_permalinks() ) {
            $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
        }

        if ( !empty( $wp_query->query_vars['s'] ) ) {
            $pagination['add_args'] = ['s' => get_query_var( 's' )];
        }

        $pagi = '';
        if ( paginate_links( $pagination ) != '' ) {
            $paginations = paginate_links( $pagination );
            $pagi .= '<ul>';
            foreach ( $paginations as $key => $pg ) {
                $pagi .= '<li>' . $pg . '</li>';
            }
            $pagi .= '</ul>';
        }

        print _delishs_pagi_callback( $pagi );
    }
}

// theme color
function delishs_custom_color() {
    $delishs_color_option_prim = get_theme_mod( 'delishs_color_option_prim', '#3F5AF3' );
    $delishs_color_option_sec = get_theme_mod( 'delishs_color_option_sec', '#ffc226' );
    $delishs_color_option_heading = get_theme_mod( 'delishs_color_option_heading', '#171717' );
    $delishs_color_option_body = get_theme_mod( 'delishs_color_option_body', '#B0B2B7' );
    $delishs_color_option_white = get_theme_mod( 'delishs_color_option_white', '#ffffff' );
    $delishs_color_option_black = get_theme_mod( 'delishs_color_option_black', '#000000' );
    $delishs_color_option_dark = get_theme_mod( 'delishs_color_option_dark', '#232323' );
    $delishs_color_option_theme_bg = get_theme_mod( 'delishs_color_option_theme_bg', '#11151C' );
    $delishs_color_option_grey_1 = get_theme_mod( 'delishs_color_option_grey_1', '#F8F8F8' );
    $delishs_color_option_grey_2 = get_theme_mod( 'delishs_color_option_grey_2', '#2D343E' );
    $delishs_color_option_border_1 = get_theme_mod( 'delishs_color_option_border_1', '#1E2228' );
    $delishs_breadcrumb_bg_color = get_theme_mod( 'delishs_breadcrumb_bg_color', '#0A0A0A' );
  
    wp_enqueue_style( 'delishs-custom', DELISHS_THEME_CSS_DIR . 'delishs-custom.css', [] );
  
    if ( !empty($delishs_color_option_prim) || !empty($delishs_color_option_sec) || !empty($delishs_color_option_heading) || !empty($delishs_color_option_body) || !empty($delishs_color_option_white || !empty($delishs_color_option_black) || !empty($delishs_color_option_dark) || !empty($delishs_color_option_theme_bg) || !empty($delishs_color_option_grey_1) || !empty($delishs_color_option_grey_2) || !empty($delishs_color_option_border_1) ) || !empty($delishs_breadcrumb_bg_color) ) {
        $custom_css = '';
  
        $custom_css .= "html:root{ 
          --rr-color-theme-primary: " . $delishs_color_option_prim . ";
          --rr-color-theme-secondary: " . $delishs_color_option_sec . ";
          --rr-color-heading-primary: " . $delishs_color_option_heading . ";
          --rr-color-text-body: " . $delishs_color_option_body . ";
          --rr-color-common-white: " . $delishs_color_option_white . ";
          --rr-color-common-black: " . $delishs_color_option_black . ";
          --rr-color-common-dark: " . $delishs_color_option_dark . ";
          --rr-color-bg-1: " . $delishs_color_option_theme_bg . ";
          --rr-color-grey-1: " . $delishs_color_option_grey_1 . ";
          --rr-color-grey-2: " . $delishs_color_option_grey_2 . ";
          --rr-color-border-1: " . $delishs_color_option_border_1 . ";
        }";

        $custom_css .= ".breadcrumb__area.overly:after { background: " . $delishs_breadcrumb_bg_color . "!important}";
          
        wp_add_inline_style( 'delishs-custom', $custom_css );
    }
}
add_action( 'wp_enqueue_scripts', 'delishs_custom_color' );

function delishs_style_functions()
{
    wp_enqueue_style('delishs-custom', DELISHS_THEME_CSS_DIR . 'delishs-custom.css', []);

    $logo_size = get_theme_mod('logo_size', '170');
    if ($logo_size != '') {
        $custom_css = '';
        $custom_css .= ".header__logo, .search__logo { width: " . $logo_size . "px!important; max-width: " . $logo_size . "px!important}";
        wp_add_inline_style('delishs-custom', $custom_css);
    }    
}
add_action('wp_enqueue_scripts', 'delishs_style_functions');

// delishs_kses_intermediate
function delishs_kses_intermediate( $string = '' ) {
    return wp_kses( $string, delishs_get_allowed_html_tags( 'intermediate' ) );
}

function delishs_get_allowed_html_tags( $level = 'basic' ) {
    $allowed_html = [
        'b'      => [],
        'i'      => [],
        'u'      => [],
        'em'     => [],
        'br'     => [],
        'abbr'   => [
            'title' => [],
        ],
        'span'   => [
            'class' => [],
        ],
        'strong' => [],
        'a'      => [
            'href'  => [],
            'title' => [],
            'class' => [],
            'id'    => [],
        ],
    ];

    if ($level === 'intermediate') {
        $allowed_html['a'] = [
            'href' => [],
            'title' => [],
            'class' => [],
            'id' => [],
        ];
        $allowed_html['div'] = [
            'class' => [],
            'id' => [],
        ];
        $allowed_html['img'] = [
            'src' => [],
            'class' => [],
            'alt' => [],
        ];
        $allowed_html['del'] = [
            'class' => [],
        ];
        $allowed_html['ins'] = [
            'class' => [],
        ];
        $allowed_html['bdi'] = [
            'class' => [],
        ];
        $allowed_html['i'] = [
            'class' => [],
            'data-rating-value' => [],
        ];
    }

    return $allowed_html;
}


// WP kses allowed tags
// ----------------------------------------------------------------------------------------
function delishs_kses($raw){

   $allowed_tags = array(
      'a'                         => array(
         'class'   => array(),
         'href'    => array(),
         'rel'  => array(),
         'title'   => array(),
         'target' => array(),
      ),
      'abbr'                      => array(
         'title' => array(),
      ),
      'b'                         => array(),
      'blockquote'                => array(
         'cite' => array(),
      ),
      'cite'                      => array(
         'title' => array(),
      ),
      'code'                      => array(),
      'del'                    => array(
         'datetime'   => array(),
         'title'      => array(),
      ),
      'dd'                     => array(),
      'div'                    => array(
         'class'   => array(),
         'title'   => array(),
         'style'   => array(),
      ),
      'dl'                     => array(),
      'dt'                     => array(),
      'em'                     => array(),
      'h1'                     => array(),
      'h2'                     => array(),
      'h3'                     => array(),
      'h4'                     => array(),
      'h5'                     => array(),
      'h6'                     => array(),
      'i'                         => array(
         'class' => array(),
      ),
      'img'                    => array(
         'alt'  => array(),
         'class'   => array(),
         'height' => array(),
         'src'  => array(),
         'width'   => array(),
      ),
      'li'                     => array(
         'class' => array(),
      ),
      'ol'                     => array(
         'class' => array(),
      ),
      'p'                         => array(
         'class' => array(),
      ),
      'q'                         => array(
         'cite'    => array(),
         'title'   => array(),
      ),
      'span'                      => array(
         'class'   => array(),
         'title'   => array(),
         'style'   => array(),
      ),
      'iframe'                 => array(
         'width'         => array(),
         'height'     => array(),
         'scrolling'     => array(),
         'frameborder'   => array(),
         'allow'         => array(),
         'src'        => array(),
      ),
      'strike'                 => array(),
      'br'                     => array(),
      'strong'                 => array(),
      'data-wow-duration'            => array(),
      'data-wow-delay'            => array(),
      'data-wallpaper-options'       => array(),
      'data-stellar-background-ratio'   => array(),
      'ul'                     => array(
         'class' => array(),
      ),
      'svg' => array(
           'class' => true,
           'aria-hidden' => true,
           'aria-labelledby' => true,
           'role' => true,
           'xmlns' => true,
           'width' => true,
           'height' => true,
           'viewbox' => true, // <= Must be lower case!
       ),
       'g'     => array( 'fill' => true ),
       'title' => array( 'title' => true ),
       'path'  => array( 'd' => true, 'fill' => true,  ),
      );

   if (function_exists('wp_kses')) { // WP is here
      $allowed = wp_kses($raw, $allowed_tags);
   } else {
      $allowed = $raw;
   }

   return $allowed;
}

if ( !function_exists('delishs_post_navigation') ) {
	function delishs_post_navigation(){
		$delishs_next_post = get_next_post();
		$delishs_prev_post = get_previous_post();
		
		if ( $delishs_next_post || $delishs_prev_post ) : ?>

            <div class="blog__details-pagination mb-60 mb-xs-50 mt-35 mt-xs-30 d-flex flex-column flex-md-row align-items-center  justify-content-md-between">
                <a href="<?php echo get_permalink( $delishs_prev_post ); ?>" class="blog__details-pagination-prev d-flex align-items-center">
                    <?php if ( get_the_post_thumbnail($delishs_prev_post) ): ?>
                        <span class="thumb">
                            <?php print get_the_post_thumbnail($delishs_prev_post,'thumbnail');?>
                        </span>
                    <?php endif;?>
                    <span class="text">
                        <span class="title"><?php echo get_the_title( $delishs_prev_post ); ?></span>
                    </span>
                </a>

                <div class="dot"><img src="<?php print get_template_directory_uri(); ?>/assets/imgs/blog-details/dot.png" alt="not found"></div>

                <a href="<?php echo get_permalink( $delishs_next_post ); ?>" class="blog__details-pagination-next d-flex align-items-center">
                    <span class="text">
                        <span class="title">
                            <?php echo get_the_title( $delishs_next_post ); ?>
                        </span>
                    </span>

                    <?php if ( get_the_post_thumbnail($delishs_next_post) ): ?>
                        <span class="thumb">
                            <?php print get_the_post_thumbnail($delishs_next_post,'thumbnail');?>
                        </span>
                    <?php endif;?>
                </a>
            </div>
		
		<?php endif;
	}
}

/**
 * Social Share
 */
if ( !function_exists('delishs_blog_single_social') ) {
function delishs_blog_single_social(){
    $post_url = get_the_permalink();
    ?>
    <div class="share-social-media_wrapper">
        <Span><?php print esc_html( 'Social Share:', 'delishs' ); ?></Span>
        <div class="share-social-media">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($post_url);?>" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/share?url=<?php echo esc_url($post_url);?>" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/cws/share?url=<?php echo esc_url($post_url);?>" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://www.instagram.com/sharer.php?u=<?php echo esc_url($post_url);?>" class="instagram"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
   <?php return false;
    }
}