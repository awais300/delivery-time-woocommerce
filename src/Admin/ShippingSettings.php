<?php

namespace WPFactory\DeliveryTime\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class ShippingSettings
 * @package WPFactory\DeliveryTime\Admin
 */

class ShippingSettings {

	/**
	 * Construct the plugin.
	 */
	public function __construct() {

		add_filter( 'woocommerce_get_sections_shipping', array( $this, 'add_shipping_settings_delivery_time_tab' ) );
		add_filter( 'woocommerce_get_settings_shipping', array( $this, 'delivery_time_settings' ), 10, 2 );
	}


	/**
	 * Global shipping settings.
	 * @param Array
	 * @return Array
	 */
	public function add_shipping_settings_delivery_time_tab( $section ) {
		$section['shipping_delivery_time'] = __( 'Delivery Time', 'dtw-customization' );
		return $section;
	}

	public function delivery_time_settings( $settings, $current_section ) {
		$custom_settings = array();

		if ( 'shipping_delivery_time' == $current_section ) {

			$custom_settings = array(

				array(
					'name' => __( 'Delivery Time Settings', 'dtw-customization' ),
					'type' => 'title',
					'id'   => 'dt_title',
				),

				array(
					'name'              => __( 'Delivery time', 'dtw-customization' ),
					'type'              => 'number',
					'class'             => 'dt-small',
					'desc'              => __( 'X days to delivery', 'dtw-customization' ),
					'desc_tip'          => true,
					'id'                => 'dt_delivery_time',
					'custom_attributes' => array(
						'step' => 'any',
						'min'  => '0',
					),

				),

				array(
					'name'     => __( 'Display on', 'dtw-customization' ),
					'type'     => 'multiselect',
					'class'    => 'select2',
					'desc'     => __( 'Select option to display on specific page. Defaults to single product page', 'dtw-customization' ),
					'desc_tip' => true,
					'id'       => 'dt_display',
					'options'  => array(
						'single_product_page'  => __( 'Single product page', 'dtw-customization' ),
						'archive_product_page' => __( 'Product archive page', 'dtw-customization' ),
					),
				),

				array(
					'name'     => __( 'Color', 'dtw-customization' ),
					'type'     => 'color',
					'desc'     => __( 'Color of the text', 'dtw-customization' ),
					'desc_tip' => true,
					'id'       => 'dt_color',

				),

				array(
					'type' => 'sectionend',
					'id'   => 'shipping_delivery_time',
				),

			);

			return $custom_settings;
		} else {
			return $settings;
		}

	}
}
