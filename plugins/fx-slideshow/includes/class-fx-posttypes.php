<?php

/**
 * FX_Posttypes
 * registers any custom data
 */

if ( ! defined('ABSPATH') )
    exit;


class FX_Posttypes
{
    protected static $instance;



    /**
     * Initializes variables and sets up WordPress hooks/actions.
     *
     * @return void
     */

    protected function __construct( )
    {
        add_action( 'init', array( $this, 'register_post_type'));
    }



    /* Static Singleton Factory Method */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }



    /**
     * Registers our custom post type
     *
     * @return void
     */

    public function register_post_type()
    {
        register_post_type(
            FX_Slideshow::POSTTYPE
            ,array(
                'labels' => array(
                     'name' => 'slide'
                    ,'singular_name' => 'Slide'
                    ,'add_new' => 'New Slide'
                    ,'add_new_item' => 'Add New Slide'
                    ,'edit_item' => 'Edit Slide'
                    ,'new_item' => 'New Slide'
                    ,'all_items' => 'All Slides'
                    ,'view_item' => 'View Slide'
                    ,'search_items' => 'Search Slides'
                    ,'not_found' =>  'No slides found'
                    ,'not_found_in_trash' => 'No slides found in trash'
                    ,'parent_item_colon' => ''
                    ,'menu_name' => 'Slideshow'
                )
                ,'public' => true
                ,'publicly_queryable' => false
                ,'exclude_from_search' => true
                ,'has_archive' => false
                ,'show_ui' => true
                ,'show_in_nav_menus' => false
                ,'show_in_menu' => true
                ,'supports' => array('title','thumbnail')
                ,'menu_icon' => 'dashicons-format-gallery'
            )
        );
    }

}
