<?php
namespace FX\Testimonials\Models;
use \FX\Testimonials\Testimonials;

class Category extends \FX\Testimonials\Core\Taxonomy
{

    public $name = 'testimonial_category';


    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     *
     * @return void
     */

    public function __construct( )
    {
        add_filter( $this->name.'_taxonomy_labels', array($this, 'set_labels'));
        add_filter( $this->name.'_taxonomy_config', array($this, 'set_config'));
        add_filter( $this->name.'_taxonomy_related_post_types', array($this, 'set_post_types'));
        add_filter( $this->name.'_rewrite_tags', array($this, 'set_tags'));

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
            'name'              => _x( 'Categories', 'testimonial category general name', Testimonials::DOMAIN  ),
            'singular_name'     => _x( 'Category', 'testimonial category singular name', Testimonials::DOMAIN  ),
            'search_items'      => __( 'Search Categories' ),
            'all_items'         => __( 'All Categories' ),
            'parent_item'       => __( 'Parent Category' ),
            'parent_item_colon' => __( 'Parent Category:' ),
            'edit_item'         => __( 'Edit Category' ),
            'update_item'       => __( 'Update Category' ),
            'add_new_item'      => __( 'Add New Category' ),
            'new_item_name'     => __( 'New Category Name' ),
            'menu_name'         => __( 'Categories' )
        );
    }


     /**
     * Sets the config for the post_type
     *
     * @hooked 'cat_{post_type_name}_post_type_config'
     *
     * @param  array $config the default config
     * @return array  config for the posttype
     */
    public function set_config($config)
    {
        return array(
            'rewrite' => array(
                'slug' => 'testimonials/category'
                ,'with_front' => false
            )
            ,'hierarchical' => true
            ,'show_admin_column' => true
        );
    }

    /**
     * Sets the associated post types
     * @param [type] $post_types [description]
     */
    public function set_post_types($post_types)
    {
        return array(
            'testimonial'
        );
    }


    public function set_tags($tags)
    {
        return array();
    }



    public static function find_or_new($name)
    {
        $options = array(
            'description' => ''
        );

        $taxonomy = strtolower(str_replace(__NAMESPACE__.'\\', '', get_called_class()));

        // check if this name is already a term
        if(! $term_obj = term_exists($name, $taxonomy)) {
            // insert the new term
            $term_obj = wp_insert_term($name, $taxonomy, $options);
        }
        return $term_obj;
    }


}
