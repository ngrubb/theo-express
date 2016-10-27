<?php
/*
Plugin Name: FX Testimonials
Plugin URI: http://webpagefx.com
Description: Add testimonials functionality
Version: 1.0
Author: WebpageFX
Author URI: http://webpagefx.com/
*/
namespace FX\Testimonials;

if ( ! defined('ABSPATH') ) exit;

if ( ! defined('DS') )
    define('DS', DIRECTORY_SEPARATOR);



// Fires the plugin once all plugins are ready
add_action( 'plugins_loaded', array( Testimonials::instance(), 'plugin_setup' ) );

// register activation hooks
register_activation_hook( __FILE__, array( Testimonials::instance(), 'on_activate' ));
register_deactivation_hook( __FILE__, array( Testimonials::instance(), 'on_deactivate' ));


final class Testimonials
{
    /**
     * Version of the plugin.
     *
     * @type int
     */
    const VERSION = '1.0';

    /**
     * Domain of the plugin.
     *
     * @type int
     */
    const DOMAIN = 'fx-testimonials';

    /**
     * Plugin instance.
     *
     * @see instance()
     * @type object
     */
    protected static $instance = NULL;

    /**
     * Weather or not to output scripts
     *
     * @type object
     */
    public static $enqueue_scripts = false;

    /**
     * URL to this plugin's directory.
     *
     * @type string
     */
    public $plugin_url = '';

    /**
     * Path to this plugin's directory.
     *
     * @type string
     */
    public $plugin_path = '';

    /**
     * URL to ajax directory.
     *
     * @type string
     */
    public $ajax_url = '';




    /**
     * Empty constructor see @plugin_setup
     *
     * @return void
     */

    protected function __construct( ) {}


    /**
     * Static Singleton Factory Method
     *
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



    /**
     * Initializes plugin and setup common variables.
     *
     * @return void
     */

    public function plugin_setup()
    {
        // Settings
        $this->plugin_url  = trailingslashit(plugins_url( '/', __FILE__ ));
        $this->plugin_path = trailingslashit(plugin_dir_path( __FILE__ ));
        $this->ajax_url    = admin_url( 'admin-ajax.php', 'relative' );

        // Autoload classes
        if ( function_exists( "__autoload" ) )
            spl_autoload_register( "__autoload" );

        spl_autoload_register( array( $this, 'auto_load_file' ) );


        // Load Dependencies
        $this->load();

        // Hooks
        add_action( 'init', array( $this, 'init'), 100 );
        add_action( 'admin_init', array( $this, 'admin_init'), 100 );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_assets'));
        add_action( 'wp_enqueue_scripts', array($this, 'frontend_assets'));

        add_filter('site_transient_update_plugins', array($this,'remove_update_nag'));

    }



    /**
     * Auto_loads Required files for plugin
     *
     * @return void
     */

    public function auto_load_file($class)
    {
        // convert class name to equivulent file path
        $file = strtolower(str_replace(array(__NAMESPACE__.'\\', '\\'), array('', DS), self::plugin_path().$class).'.php');

        // include the file
        if ( is_readable($file ) ) {
            include_once $file;


            // create instances if singleton classes
            if(method_exists($class, 'instance')){
                $class::instance();
            }

            return;
        }
    }


    /**
     * Include required files
     *
     * @return void
     */

    private function load()
    {
        // Dependency
        new \FX\Testimonials\Models\Testimonial;
        new \FX\Testimonials\Models\Category;


        // Shortcodes
        include_once $this->plugin_path.'shortcodes/testimonial.php';
        include_once $this->plugin_path.'shortcodes/testimonials.php';

        // Widgets
        include_once $this->plugin_path.'widgets/testimonial.php';

        if(is_admin())
            $this->load_admin();
    }

    private function load_admin()
    {
        \FX\Testimonials\Controllers\Admin\Testimonial::instance();
    }



    /**
     * Runs when wordpress fires init action
     *
     * @return void
     */

    public function init($hook)
    {

    }


    public function admin_init()
    {
        self::check_update();
    }

    /**
     * Load any front end assets that are need
     *
     * @return void
     */
    public function frontend_assets() {}

    /**
     * Load any assets needed for editing in the admin
     *
     * @return void
     */
    public function admin_assets($hook) {}




    /**
     * Handles plugin activation
     * Checks for database table and adds if it doesn't exist.
     *
     * @return void
     */

    public static function on_activate()
    {
        flush_rewrite_rules();
    }



    /**
     * Handles plugin Deactivation
     *
     * @return void
     */

    public static function on_deactivate()
    {
        flush_rewrite_rules();
    }

    /**
     * Runs any database updates that need run
     *
     * @return void
     */

    public static function check_update()
    {
        $version = get_option('fx_testimonials_version');

        if($version != self::VERSION)
        {
            update_option('fx_testimonials_version', self::VERSION);
            do_action( 'fx_testimonials_updated' );
        }
    }


    /**
     * Get the plugin url.
     *
     * @return string
     */

    public static function plugin_url()
    {
        $self = self::instance();
        return $self->plugin_url;
    }



    /**
     * Get the plugin path.
     *
     * @return string
     */

    public static function plugin_path()
    {
        $self = self::instance();
        return $self->plugin_path;
    }


    /**
     * Get Ajax URL.
     *
     * @return string
     */

    public static function ajax_url()
    {
        $self = self::instance();
        return $self->ajax_url;
    }

    /**
     * We are using the same file name of some other plug
     * which causes weird update things so we tell it
     * to ignore the update
     * @param  object
     * @return object
     */
    public function remove_update_nag($plugins)
    {
        if(isset($plugins->response[ plugin_basename(__FILE__) ]))
            unset($plugins->response[ plugin_basename(__FILE__) ]);

        return $plugins;
    }

}
