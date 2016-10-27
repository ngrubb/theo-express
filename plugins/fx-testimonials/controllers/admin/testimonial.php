<?php
namespace FX\Testimonials\Controllers\Admin;
use \FX\Testimonials\Testimonials;


class Testimonial
{

	protected static $instance;

	/**
	 * Initializes plugin variables and sets up WordPress hooks/actions.
	 *
	 * @return void
	 */

	protected function __construct( )
	{
		add_action('restrict_manage_posts', array($this, 'add_taxonomy_filters') );

		add_action( 'add_meta_boxes', array($this, 'add_meta_boxes'), 10 );
        add_action( 'admin_init', array($this, 'add_meta_boxes'), 1 );
        add_action( 'save_post_testimonial', array($this, 'save'), 10,3 );
        add_action( 'wp_ajax_testimonials_quick_meta', array($this, 'save_meta_ajax') );

        add_filter('manage_edit-testimonial_columns', array($this, 'add_column_head'));
        add_action('manage_testimonial_posts_custom_column', array($this, 'manage_column_content'));
	}

	/**
	 * Static Singleton Factory Method
	 *
	 * @return [class] Makes sure that only a single instance of this class is running
	 */

	public static function instance()
	{
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}



     /**
     * Saves the custom post data
     *
     * @param $post_id int, The current post ID
     */

    public function save($post_id, $post, $update )
    {
        // Make sure we have some of our custom meta boxes
        if ( ! isset($_POST['post_meta']) )
            return;

        // make sure user has permissions
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return;
        }


        // loop through each box and do some magic
        foreach($_POST['post_meta'] as $key => $field) {

            add_post_meta($post_id, $key, $field, true) || update_post_meta($post_id, $key, $field);
        }

    } // public method save



    public function save_meta_ajax()
    {
        $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
        $field = filter_var($_POST['field'], FILTER_SANITIZE_STRING);
        $value = filter_var($_POST['value'], FILTER_SANITIZE_STRING);

        $result = update_post_meta( $post_id, $field, $value);

        die(json_encode(array('post_id' => $post_id, $field => $value, 'result' => $result )));
    }




	public function add_taxonomy_filters()
	{
		global $typenow;

		// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array('testimonial_category');

		// must set this to the post type you want the filter(s) displayed on
		if( $typenow == 'testimonial' )
		{
			foreach ($taxonomies as $slug)
			{
				$tax_obj = get_taxonomy($slug);
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($slug);

				if(!empty($terms))
				{
					echo "<select name='$slug' id='$slug' class='postform'>";
					echo "<option value=''>Show All ".str_replace(' Categories','',$tax_name)."</option>";
					foreach ($terms as $term) {
						echo '<option value='. $term->slug, $_GET[$slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}
	}



    public function add_column_head($old_columns)
    {
        $new_columns = array();

        foreach($old_columns as $key => $title)
        {
            if ($key == 'date')
            {
                $new_columns['featured']  = 'Featured';
                $new_columns['shortcode'] = 'Shortcode';
                $new_columns['thumbnail'] = 'Image';
            }
            $new_columns[$key] = $title;
        }

        return $new_columns;
    }



    public function manage_column_content($current_column)
    {
        global $post;

        switch ($current_column)
        {
            case 'featured':
                echo '<input class="post_meta_quick"
                             id="post_meta_featured_'.$post->ID.'"
                             name="featured"
                             data-post_id="'.$post->ID.'"
                             type="checkbox"
                             value="1"
                             '. checked( get_post_meta( $post->ID, 'featured', true ), 1, false) . '>';
                break;

            case 'thumbnail':
                echo get_the_post_thumbnail( $post->ID, array(50,50) );
                break;

            case 'shortcode':
                echo '[testimonial id="'.$post->ID.'"]';
                break;
        }
    }



	/**
     * Registers our custom meta boxes
     */

    public function add_meta_boxes($post)
    {
        $path = Testimonials::plugin_path().'/views/admin/metaboxes/';

        // List of metaboxes to add
        $metaboxes = array(
        	// 'client-information',
            'featured'
        );


        // loop through each metabox file
        foreach ($metaboxes as $box)
        {
            $include = $path.$box.'.php';

            // Grabs Comment Block at top for our form
            // returns an assoc array
            // http://phpdoc.wordpress.org/trunk/WordPress/_wp-includes---functions.php.html#functionget_file_data
            $data = get_file_data($include, array(
                 'title'     => 'Title'
                ,'post type' => 'Post Type'
                ,'context'   => 'Context'
                ,'priority'  => 'Priority'
            ));

            $data['form'] = $include;

            // Add Each Metabox
            add_meta_box(
                 strtolower(str_replace(' ', '_', $data['title']))
                ,$data['title']
                ,array( $this, 'render' )
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
}
