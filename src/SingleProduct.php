<?php

namespace WPFactory\DeliveryTime;

defined( 'ABSPATH' ) || exit;

/**
 * Class SingleProduct
 * @package WPFactory\DeliveryTime
 */

class SingleProduct extends DeliveryTime {

	/**
	 * Construct the plugin.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'display_delivery_info' ) );
	}

	/**
	 * Display delivery info.
	 * @return void
	 */
	public function display_delivery_info() {
		$this->page = 'single_product_page';
		$this->display();
	}
}
