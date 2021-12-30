<?php

namespace WPFactory\DeliveryTime\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Class Product
 * @package WPFactory\DeliveryTime\Admin
 */

class Product {

	/**
	 * Construct the plugin.
	 */
	public function __construct() {

		add_action( 'woocommerce_product_options_shipping', array( $this, 'shipping_product_delivery_time' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'delivery_time_fields_save' ), 10, 1 );

	}

	/**
	 *  Delivery time options for product.
	*/
	public function shipping_product_delivery_time() {
		$value = esc_html( get_post_meta( get_the_ID(), 'dt_delivery_time', true ) );
		woocommerce_wp_text_input(
			array(
				'id'                => 'dt_delivery_time',
				'value'             => $value,
				'label'             => __( 'Delivery Time', 'dtw-customization' ),
				'placeholder'       => '',
				'description'       => __( 'X days to delivery', 'dtw-customization' ),
				'type'              => 'number',
				'desc_tip'          => true,
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '-1',
				),
			)
		);

		$value = esc_textarea( get_post_meta( get_the_ID(), 'dt_delivery_time_desc', true ) );
		woocommerce_wp_textarea_input(
			array(
				'id'          => 'dt_delivery_time_desc',
				'value'       => $value,
				'label'       => __( 'Delivery Time Description', 'dtw-customization' ),
				'placeholder' => '',
				'description' => __( 'Enter delivery details', 'dtw-customization' ),
				'desc_tip'    => true,
			)
		);
	}


	/**
	 * Save delivery fields.
	 * @param  integer $post_id
	 * @return void
	 */
	public function delivery_time_fields_save( $post_id ) {
		$product = wc_get_product( $post_id );

		$field = (int) ( $_POST['dt_delivery_time'] );
		$product->update_meta_data( 'dt_delivery_time', $field );

		$field = sanitize_textarea_field( $_POST['dt_delivery_time_desc'] );
		$product->update_meta_data( 'dt_delivery_time_desc', $field );

		$product->save();
	}
}
