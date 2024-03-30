<?php
/*
Plugin Name: Post View Count
Description: Show post view count into any post content page using shortcode [postvc_view_count id="1"/]
Version:     1.0.0
Author:      Md. Abdul Hannan
Author URI:  #
Text Domain: postvc
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die;

/**
 * Autoload require
 */
require_once __DIR__ . "/vendor/autoload.php";

/**
 * Define required constants
 */
define( 'POSTVC_VER', '1.0.0' );
define( 'POSTVC_URL', plugins_url('', __FILE__) );
define( 'POSTVC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'POSTVC_URL_ASSETS', POSTVC_URL . '/assets' );

/**
 * Class Postvc_Post_View_Count
 */
if ( ! class_exists( 'Postvc_Post_View_Count' ) ) {
    class Postvc_Post_View_Count {
        /**
		 * Properties
		 */
        private static $instance = null;

        /**
		 * Instance
		 */
        public static function get_instance() {
			if ( self::$instance == null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

        /**
		 * Constructors
		 */
        public function __construct() {
            // Actions
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'wp_loaded', array( $this, 'initialize_features' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_frontend_assets' ) );
		}

		/**
		 * Run init
		 */
		public function init(){
			// init funnctions 
			new WedevsAcademy\WpPostViewCount\Functions();
			$this->post_view_count();
		}

        /**
		 * Initialize features
		 */
		public function initialize_features() {
			load_plugin_textdomain( 'postvc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Enqueue frontend assets
		 */
		public function wp_enqueue_frontend_assets( ) {
			wp_enqueue_style( 'postvc-style', POSTVC_URL_ASSETS . '/css/frontend.css', array(), POSTVC_VER, 'all' );
			wp_enqueue_script( 'postvc-script', POSTVC_URL_ASSETS . '/js/frontend.js', array( 'jquery' ), POSTVC_VER, true );
		}

		/**
		 * activation update options
		 */
		public function activate()
		{

			$installer = new WedevsAcademy\WpPostViewCount\Installer();
			$installer->run();

		}

		/**
		 * View count process
		 */
		public function post_view_count(){
			new WedevsAcademy\WpPostViewCount\ViewCount();
		}

    }

    /**
	 * Instantiate
	 */
	Postvc_Post_View_Count::get_instance();
	
}