<?php

namespace WPFactory\DeliveryTime;

use WPFactory\DeliveryTime\Admin\Product;
use WPFactory\DeliveryTime\Admin\ShippingSettings;

defined( 'ABSPATH' ) || exit;

/**
 * Class Bootstrap
 * @package WPFactory\DeliveryTime
 */

class Bootstrap {

	private $version = '1.0.0';

	/**
	 * Instance to call certain functions globally within the plugin.
	 *
	 * @var _instance
	 */
	protected static $_instance = null;

	/**
	 * Construct the plugin.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'load_plugin' ), 0 );
	}

	/**
	 * Main Customization instance.
	 *
	 * Ensures only one instance is loaded or can be loaded.
	 *
	 * @static
	 * @return self Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Determine which plugin to load.
	 */
	public function load_plugin() {
		$this->define_constants();
		$this->init_hooks();
	}

	/**
	 * Define WC Constants.
	 */
	private function define_constants() {
		// Path related defines
		$this->define( 'DTW_CUST_PLUGIN_FILE', DTW_CUST_PLUGIN_FILE );
		$this->define( 'DTW_CUST_PLUGIN_BASENAME', plugin_basename( DTW_CUST_PLUGIN_FILE ) );
		$this->define( 'DTW_CUST_PLUGIN_DIR_PATH', untrailingslashit( plugin_dir_path( DTW_CUST_PLUGIN_FILE ) ) );
		$this->define( 'DTW_CUST_PLUGIN_DIR_URL', untrailingslashit( plugins_url( '/', DTW_CUST_PLUGIN_FILE ) ) );
	}

	/**
	 * Collection of hooks.
	 */
	public function init_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'init', array( $this, 'init' ), 1 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Localisation
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'dtw-customization', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		new ShippingSettings();
		new Product();
		new SingleProduct();
		new ProductArchive();
	}

	/**
	 * Enqueue all styles.
	 */
	public function enqueue_styles() {
		if ( is_product() || is_product_category() ) {
			wp_enqueue_style( 'dtw-customization-frontend', DTW_CUST_PLUGIN_DIR_URL . '/assets/css/dtw-customization-frontend.css', array(), null, 'all' );
		}
	}

	/**
	 * Enqueue all scripts.
	 */
	public function enqueue_scripts() {
		if ( is_product() || is_product_category() ) {
			$wp_localize_data = array(
				'ajax_url'    => admin_url( 'admin-ajax.php' ),
				'_ajax_nonce' => wp_create_nonce( 'ajax' ),
				'asset_url'   => DTW_CUST_PLUGIN_DIR_URL . '/assets',
			);
			wp_enqueue_script( 'dtw-customization-frontend', DTW_CUST_PLUGIN_DIR_URL . '/assets/js/dtw-customization-frontend.js', array( 'jquery' ) );
			wp_localize_script( 'dtw-customization-frontend', 'LOCAL_OBJ', $wp_localize_data );
		}

	}

	/**
	 * Define constant if not already set.
	 *
	 * @param  string $name
	 * @param  string|bool $value
	 */
	public function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

}
