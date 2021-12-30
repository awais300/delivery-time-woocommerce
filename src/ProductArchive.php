<?php

namespace WPFactory\DeliveryTime;

defined( 'ABSPATH' ) || exit;

/**
 * Class ProductArchive
 * @package WPFactory\DeliveryTime
 */

class ProductArchive extends DeliveryTime {

	/**
	 * Construct the plugin.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'display_delivery_info' ) );
	}

	/**
	 * Display delivery info.
	 * @return void
	 */
	public function display_delivery_info() {
		$this->page = 'archive_product_page';
		$this->display();
	}
}
