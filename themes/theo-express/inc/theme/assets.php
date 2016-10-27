<?php 

// DO NOT REMOVE THIS FUNCTION AS IT LOADS THE PARENT THEME STYLESHEET
add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}


/**
 * Register and enqueue theme styles
 *
 * @return void
 */
function theo_styles()
{
    global $wp_styles;

    $dev = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '.min' : '';

    // Add Normalize.css
    wp_register_style(
        'normalize'
        ,get_stylesheet_directory_uri() . '/assets/css/normalize'.$dev.'.css'
    );

    // Add Main Stylesheet File
    wp_register_style(
        'site_main'
        ,get_stylesheet_directory_uri() . '/assets/css/main'.$dev.'.css'
        ,array('normalize')
    );

    // Add IE Stylesheet File
    wp_register_style(
        'site_ie'
        ,get_stylesheet_directory_uri() . '/assets/css/ie'.$dev.'.css'
    );
    $wp_styles->add_data( 'site_ie', 'conditional', 'IE' );


    if( ! is_admin() )
    {
        wp_enqueue_style( 'site_main' );
        wp_enqueue_style( 'site_ie' );
    }
}
add_action( 'wp_enqueue_scripts', 'theo_styles' );


/**
 * Register and enqueue theme scripts
 *
 * @return void
 */
function theo_scripts()
{
    $dev = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '.min' : '';

    // Add Modernizr js File
    wp_register_script(
        'modernizr'
        ,get_stylesheet_directory_uri() . '/assets/js/vendor/modernizr.min.js'
        ,false
        ,'2.8.2'
    );

    // Add Plugins js File
    wp_register_script(
        'site_plugins'
        ,get_stylesheet_directory_uri() . '/assets/js/plugins'.$dev.'.js'
        ,array('jquery')
        ,null
        ,true
    );

    // Add Global js File
    wp_register_script(
        'site_main'
        ,get_stylesheet_directory_uri() . '/assets/js/main'.$dev.'.js'
        ,array('jquery', 'site_plugins')
        ,null
        ,true
    );

    if( ! is_admin() )
    {
        wp_enqueue_script(  'modernizr' );
        wp_enqueue_script(  'site_main' );
        wp_localize_script( 'site_main', 'NG', array('ajaxurl' => admin_url( 'admin-ajax.php' ), 'siteurl' => site_url() ) );
    }
}
add_action( 'wp_enqueue_scripts', 'theo_scripts' );
