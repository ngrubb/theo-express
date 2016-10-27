<?php

/**
 * FX_Admin_Slideshow
 * makes any customizations to the admin views
 * for product post type
 *
 * @category admin
 * @author WebpageFX
 */

if ( ! defined('ABSPATH') )
    exit;


class FX_Admin_Slideshow
{

    protected static $instance;



    /**
     * Initializes variables and sets up WordPress hooks/actions.
     *
     * @return void
     */

    protected function __construct( )
    {
        add_action( 'add_meta_boxes', array($this, 'add_meta_boxes'), 10 );
        add_action( 'admin_init', array($this, 'add_meta_boxes'), 1 );
        add_action( 'save_post', array($this, 'save'), 10, 2 );
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
     * Registers our custom meta boxes
     */

    public function add_meta_boxes($post)
    {
        $instance = FX_Slideshow::instance();

        // set our path to our metaboxes and pull in the list of files
        $path = $instance::plugin_path().'/includes/admin/metaboxes/';
        $metaboxes = array_diff(scandir($path), array('..', '.'));

        // loop through each metabox file
        foreach ($metaboxes as $box)
        {
            // Grabs Comment Block at top for our form
            // returns an assoc array
            // http://phpdoc.wordpress.org/trunk/WordPress/_wp-includes---functions.php.html#functionget_file_data
           $data = get_file_data($path.$box, array(
                 'title'     => 'Title'
                ,'post type' => 'Post Type'
                ,'context'   => 'Context'
                ,'priority'  => 'Priority'
            ));

            $data['form'] = $path.$box;

            // Add Each Metabox
            add_meta_box(
                 strtolower(str_replace(' ', '_', $data['title']))
                ,$data['title']
                ,array( FX_Admin_Slideshow::instance(), 'render' )
                ,$data['post type']
                ,$data['context']
                ,$data['priority']
                ,$data
            );
        } // foreach

    }


    /**
     * Renders the html of each metabox
     *
     * @param $post Object, The current post Object
     * @param $metabox Array, The Current metabox with any callback args
     */

    public function render($post, $metabox)
    {
        //include the display of our form.
        include_once $metabox['args']['form'];
    }


    public function add_nounce()
    {
        $this->nonce = wp_create_nonce('wpfx_meta');
        echo '<input type="hidden" name="wpfx_meta_nounce" value="'.$this->nonce.'" />';
    }


    /**
     * Saves the custom post data
     *
     * @param $post_id int, The current post ID
     */

    public function save($post_id, $post )
    {

        if ( ! isset($_POST['post_meta']) )
            return;

        if ( $_POST['post_type'] != 'slideshow')
            return;

        // make sure user has permissions
        if ( ! current_user_can( 'edit_page', $post_id ) )
        {
            return;
        }
        else
        {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return;
        }

        // loop through each box and do some magic
        foreach($_POST['post_meta'] as $key => $field)
        {

            if($key == 'features')
                $field = explode('|', htmlentities($field));

            if(is_array($field))
            {
                array_walk_recursive($field, function(&$val, $key) {
                    $val = sanitize_text_field($val);
                });
                $data = $field;
            }
            else
            {
                $data = sanitize_text_field($field);
            }

            add_post_meta($post_id, $key, $data, true) || update_post_meta($post_id, $key, $data);
        }

    }

}