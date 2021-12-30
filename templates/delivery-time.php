<div class="dt-container">
	<div class="dt-info">
		<?php
			$color_css = '';
		if ( ! empty( $color ) ) {
			$color_css = "style='color: {$color}'";
		}
		?>
		<?php if ( empty( $is_delivery_description ) ) : ?>
		<p class="dt-delivery-time" <?php echo $color_css; ?> >
			<?php echo sprintf( _n( 'Delivery time: %s day', 'Delivery time: %s days', $delivery_time, 'dtw-customization' ), $delivery_time ); ?>
			
		</p>
	<?php else : ?>
		<p id="<?php echo esc_attr( get_the_ID() ); ?>" class="dt-delivery-time dt-cursor" <?php echo $color_css; ?> >
			<?php echo sprintf( _n( 'Delivery time: %s day', 'Delivery time: %s days', $delivery_time, 'dtw-customization' ), $delivery_time ); ?>
		</p>

		<p class="dt-hide dt-extra-info"></p>
	<?php endif; ?>
	</div>
</div>
