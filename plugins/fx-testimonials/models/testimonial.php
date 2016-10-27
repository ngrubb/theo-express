<?php
namespace FX\Testimonials\Models;
use \FX\Testimonials\Testimonials;

class Testimonial extends \FX\Testimonials\Core\Posttype
{
    /**
     * post type name, used for queries
     *
     * @type string
     */
    public $name = 'testimonial';


    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     *
     * @return void
     */

    public function __construct()
    {
        add_filter( $this->name.'_post_type_labels', array($this, 'set_labels'));
        add_filter( $this->name.'_post_type_config', array($this, 'set_config'));

        parent::__construct();
    }




    /**
     * Sets the labels for the post_type
     *
     * @hooked 'cat_{post_type_name}_post_type_labels'
     *
     * @param  array $labels the default labels
     * @return array labels for the posttype
     */
    public function set_labels($labels)
    {
        return array(
            'name'               => _x( 'Testimonials', 'testimonial post type general name', Testimonials::DOMAIN ),
            'singular_name'      => _x( 'Testimonial', 'testimonial post type singular name', Testimonials::DOMAIN ),
            'menu_name'          => _x( 'Testimonials', 'testimonial admin menu', Testimonials::DOMAIN ),
            'name_admin_bar'     => _x( 'Testimonial', 'testimonial add new on admin bar', Testimonials::DOMAIN ),
            'add_new'            => _x( 'Add New', 'testimonial add new', Testimonials::DOMAIN ),
            'add_new_item'       => __( 'Add Testimonial', Testimonials::DOMAIN ),
            'new_item'           => __( 'New Testimonial', Testimonials::DOMAIN ),
            'edit_item'          => __( 'Edit Testimonial', Testimonials::DOMAIN ),
            'view_item'          => __( 'View Testimonial', Testimonials::DOMAIN ),
            'all_items'          => __( 'All Testimonials', Testimonials::DOMAIN ),
            'search_items'       => __( 'Search testimonials', Testimonials::DOMAIN ),
            'parent_item_colon'  => __( 'Parent testimonial:', Testimonials::DOMAIN ),
            'not_found'          => __( 'No testimonials found.', Testimonials::DOMAIN ),
            'not_found_in_trash' => __( 'No testimonials found in Trash.', Testimonials::DOMAIN )
        );
    }


     /**
     * Sets the condif for the post_type
     *
     * @hooked 'cat_{post_type_name}_post_type_config'
     *
     * @param  array $config the default config
     * @return array  config for the posttype
     */
    public function set_config($config)
    {
        return array(
            'public'         => true
            ,'menu_position' => 20
            ,'has_archive'   => false
            ,'supports'      => array('title', 'editor', 'thumbnail')
            ,'menu_icon'     => 'dashicons-testimonial'
            ,'menu_position' => 20
        );
    }


}
