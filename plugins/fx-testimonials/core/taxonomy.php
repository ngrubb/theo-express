<?php
namespace FX\Testimonials\Core;


class Taxonomy
{
    public  $name       = '';
    private $post_types = array();
    private $labels     = array();
    private $config     = array();
    private $tags       = array();

    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     *
     * @return void
     */

    public function __construct( )
    {
        add_action( 'init', array($this, 'register') );
        add_action( 'init', array($this, 'set_query_variables') );
    }



    /**
     * Adds our custom query variables publicly
     * so they are passed to query object. Makes
     * custom rewrite variables work
     *
     * @return  null
     */
    public function set_query_variables()
    {
        $tags = apply_filters( $this->name.'_rewrite_tags', $this->tags);

        if(!empty($tags)) {
            foreach ($tags as $tag => $replace) {
                add_rewrite_tag($tag, $replace['regex'], $replace['rule']);
            }
        }
    }

    /**
     *  Registers model to system
     */

    public function register()
    {
        $args             = apply_filters( $this->name.'_taxonomy_config', $this->config );
        $args['labels']   = apply_filters( $this->name.'_taxonomy_labels', $this->labels);
        $this->post_types = apply_filters( $this->name.'_taxonomy_related_post_types', $this->post_types );

        register_taxonomy(
             $this->name
            ,$this->post_types
            ,$args
        );
    }

}
