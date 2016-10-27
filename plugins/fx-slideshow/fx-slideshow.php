<?php
/**
 * Plugin Name: FX Slideshow
 * Plugin URI: http://webpagefx.com
 * Description: Create Slideshows to display on site.
 * Version: 0.1
 * Author: The WebpageFX Team
 * Author URI: http://webpagefx.com/
 *
 * Text Domain: webfx
 */


if ( ! defined('ABSPATH') ) exit;
if ( ! class_exists( 'FX_Slideshow' ) ) :

// Fires the plugin once all plugins are ready
add_action( 'plugins_loaded', array( 'FX_Slideshow', 'instance' ) );



/**
 * Main FX_Slideshow Class
 *
 * @class FX_Slideshow
 * @version 0.1
 */

final class FX_Slideshow
{
    const PREFIX   = 'FX';
    const POSTTYPE = 'slideshow';

    protected static $instance;
    protected static $options;
    protected $files;


    /**
     * Initializes plugin variables and sets up WordPress hooks/actions.
     *
     * @return void
     */

    protected function __construct( )
    {
        // Auto-load classes on demand
        if ( function_exists( "__autoload" ) )
            spl_autoload_register( "__autoload" );

        spl_autoload_register( array( $this, 'auto_load' ) );

        // Create a file list for quick autoloading
        $this->files = self::get_directory_list(self::plugin_path().'/includes');

        // Hooks
        add_action( current_filter(), array( $this, 'load' ), 30 );

        add_action( 'init', array( $this, 'init' ), 0 );
        add_action( 'after_setup_theme', array( $this, 'setup_environment' ) );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts') );
    }



    /**
     * Static Singleton Factory Method
     * @return self returns a single instance of our class
     */

    public static function instance()
    {
        if (!isset(self::$instance)) {
            $class_name = __CLASS__;
            self::$instance = new $class_name;
        }
        return self::$instance;
    }




/*
 | ------------------------------------------------------------------------
 | Theme features
 | ------------------------------------------------------------------------
 |
 | Functions for adding and setting up functionality that the plugin will
 | need to display theme / template things
 |
 */


    /**
     * Initialize on plugin wordpress init
     *
     * @return void;
     */

    public function init()
    {

    }


    /**
     * Setup theme support and image sizes..
     */

    public function setup_environment()
    {
        // Post thumbnail support
        if ( ! current_theme_supports( 'post-thumbnails') )
        {
            add_theme_support( 'post-thumbnails' );
            remove_post_type_support( 'post', 'thumbnail' );
            remove_post_type_support( 'page', 'thumbnail' );
        }
        else
        {
            add_post_type_support( FX_Slideshow::POSTTYPE, 'thumbnail' );
        }

        // Add image sizes
        add_image_size( 'slideshow', 2000, 887, true);
    }




    /**
     *  Add scripts to the admin
     */

    public function admin_scripts($hook_suffix)
    {

    }





/*
 | ------------------------------------------------------------------------
 | Loading functions
 | ------------------------------------------------------------------------
 |
 | Functions for including and setting up the autoloading functionality
 |
 |
 */



    /**
     * Include required files
     *
     * @return void
     */

    public function load()
    {
        // Core
        $this->auto_load(self::PREFIX.'_Posttypes');

        // Shortcodes
        $shortcodes = scandir(self::plugin_path() . '/includes/shortcodes/');
        $this->auto_load_array($shortcodes);

        if(is_admin())
        {
            $admin_files = scandir(self::plugin_path() . '/includes/admin/');
            $this->auto_load_array($admin_files);
        }

    }



    /**
     * Auto-load classes on demand
     *
     * @param [mixed] $include Name of either the file or the class
     * @return void
     */

    public function auto_load($include='')
    {
        // if include doesn't end in .php its the class name
        // and we need to create te files name

        if( self::is_class_name($include) )
        {
            $file = self::file_name($include);
            $class = $include;
        }
        else
        {
            $file = $include;
            $class = self::class_name($include);
        }
        //echo '<pre>'; print_r($file); echo '</pre>';
        //echo '<pre>'; print_r($class); echo '</pre>'; die;

        // checif files in list
        if(isset($this->files[$file]))
        {
            // assign file path
            $file = $this->files[$file];

            // include the file if readable
            if ( is_readable( $file ) )
            {
                include_once $file;

                // automatically create instances of singleton classes
                if(method_exists($class, 'instance'))
                    $class::instance();

                return;
            }
        }
    }


    /**
     * Auto-load a list of files
     *
     * @param [mixed] $include Name of either the file or the class
     * @return void
     */

    public function auto_load_array($files=array())
    {
        // return on empty files
        if(empty($files)) return;

        foreach($files as $file)
        {
            if( self::is_php_file($file) || self::is_class_name($file) )
            $this->auto_load($file);
        }
    }




/*
 | ------------------------------------------------------------------------
 | Helper functions
 | ------------------------------------------------------------------------
 |
 | The following functions are global plugin helper functions
 |
 |
 */


    /**
     * Get the plugin url.
     *
     * @return string
     */

    public static function plugin_url()
    {
        return untrailingslashit( plugins_url( '/', __FILE__ ) );
    }


    /**
     * Get the plugin path.
     *
     * @return string
     */

    public static function plugin_path()
    {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }


    /**
     * Get Ajax URL.
     *
     * @return string
     */

    public static function ajax_url()
    {
        return admin_url( 'admin-ajax.php', 'relative' );
    }


    /**
     * Get the file name of a class.
     *
     * @param [string] $class The name of the class
     * @return string
     */

    public static function file_name($class)
    {
        return strtolower('class-' . str_replace( '_', '-', $class ) . '.php');
    }


    /**
     * Get the class name of a file.
     *
     * @param [string] $file The name of the file
     * @return string
     */

    public static function class_name($file)
    {
        $file = str_ireplace(array('class-'.strtolower(self::PREFIX).'-','.php'), array('',''), $file);
        $parts = explode('-', $file);

        return self::PREFIX .'_'. implode('_', array_map("ucfirst", $parts));
    }



    /**
     * Check if a string is a php filename
     *
     * @param [string] $string
     * @return bool
     */

    public static function is_php_file($string)
    {
        return (substr($string, -4) === '.php') ? true : false;
    }



    /**
     * Check if string is a class name
     *
     * @param [string] $string
     * @return bool
     */

    public static function is_class_name($string)
    {
        return (substr($string, 0, strlen(self::PREFIX)) === self::PREFIX) ? true : false;
    }


    /**
     * Return list of files in 'filename' => 'filepath'
     *
     * @param  [string] $dir path to the folder to start looking for file in
     * @return array
     */

    public static function get_directory_list($dir = '.')
    {
        $root = scandir($dir);
        $files = array();

        foreach($root as $value)
        {
            if($value === '.' || $value === '..')
                continue;

            if( is_file("$dir/$value") )
            {
                $files[basename("$dir/$value")] = "$dir/$value";
                continue;
            }

            foreach(self::get_directory_list("$dir/$value") as $value)
            {
                $files[basename($value)] = $value;
            }
        }

        return $files;
    }

}

endif;

