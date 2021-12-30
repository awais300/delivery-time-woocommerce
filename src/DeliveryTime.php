<?php

namespace WPFactory\DeliveryTime;

defined( 'ABSPATH' ) || exit;

/**
 * Class DeliveryTime
 *
 * @package WPFactory\DeliveryTime
 */

class DeliveryTime {

	/**
	 * Page type.
	 *
	 * @var loader
	 */
	protected $page = null;


	/**
	 * loads a template.
	 *
	 * @var loader
	 */
	private $loader = null;


	/**
	 * Construct the plugin.
	 */
	public function __construct() {
		$this->loader = TemplateLoader::get_instance();
		add_action( 'wp_ajax_get_delivery_info', array( $this, 'get_delivery_info' ) );
		add_action( 'wp_ajax_nopriv_get_delivery_info', array( $this, 'get_delivery_info' ) );
	}

	/**
	 * Display delivery time info.
	 * @return void
	 */
	public function display() {
		$product_id = get_the_ID();
		$product    = wc_get_product( $product_id );

		if ( ! is_a( $product, 'WC_Product' ) ) {
			throw new \Exception( __( 'Not a WooCommerce product', 'dtw-customization' ) );
		}

		$delivery_time        = ! empty( $product->get_meta( 'dt_delivery_time' ) ) ? $product->get_meta( 'dt_delivery_time' ) : get_option( 'dt_delivery_time' );
		$delivery_description = $product->get_meta( 'dt_delivery_time_desc' );
		$display_on           = get_option( 'dt_display' );
		$color                = get_option( 'dt_color' );

		// No delivery time is set.
		if ( empty( $delivery_time ) || $delivery_time == '-1' ) {
			return;
		}

		// Is it allowed to display.
		if ( ! empty( $display_on ) ) {

			// Single product page.
			if ( is_product() ) {
				if ( ! in_array( $this->page, $display_on, true ) ) {
					return;
				}
			}

			// Archive page.
			if ( is_product_category() ) {
				if ( ! in_array( $this->page, $display_on, true ) ) {
					return;
				}
			}
		} else {
			// Default only to single product.
			if ( is_product_category() ) {
				return;
			}
		}

		$data = array(
			'delivery_time'           => $delivery_time,
			'is_delivery_description' => $delivery_description,
			'color'                   => $color,
		);

		$this->loader->get_template(
			'delivery-time.php',
			$data,
			DTW_CUST_PLUGIN_DIR_PATH . '/templates/',
			true
		);
	}


	/**
	 * Ajax callback to display extra info for product deliver time.
	 * @return JSON
	 */
	public function get_delivery_info() {
		if ( wp_doing_ajax() ) {
			if ( ! check_ajax_referer( 'ajax', '_ajax_nonce', false ) ) {
				wp_die( esc_html__( 'Unauthrorized access!', 'dtw-customizations' ) );
			}
		}

		if ( isset( $_POST['id'] ) ) {
			$product_id = filter_var( $_POST['id'], FILTER_SANITIZE_NUMBER_INT );
			if ( ! is_numeric( $product_id ) ) {
				wp_die( esc_html__( 'Invalid ID', 'dtw-customization' ) );
			}
		}

		$product = wc_get_product( $product_id );

		if ( ! is_a( $product, 'WC_Product' ) ) {
			wp_die( esc_html__( 'Not a WooCommerce product', 'dtw-customization' ) );
		}

		$description = $product->get_meta( 'dt_delivery_time_desc' );
		$data        = array(
			'content' => $description,
			'error'   => false,
		);

		wp_send_json( $data, 200 );
	}
}
