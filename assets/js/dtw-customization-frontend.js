jQuery( document ).ready(
	function($) {
		$( document ).on(
			'click',
			'.dt-cursor',
			function(e) {
				e.preventDefault();

				$this         = $( this );
				$display_area = $this.next();

				if ( ! $display_area.is( ':hidden' )) {
					$display_area.hide();
				} else {
					get_delivery_info( $this, $this.attr( 'id' ) );
				}
			}
		);

		/* Ajax call to get the info*/
		function get_delivery_info($ele, id) {
			$display_area = $ele.next();
			if (id == '') {
				console.log( 'No ID found' );
				return;
			}

			listing_ajax_start( $ele );
			$.ajax(
				{
					url: LOCAL_OBJ.ajax_url,
					type: 'POST',
					dataType: 'JSON',
					data: {
						'_ajax_nonce': LOCAL_OBJ._ajax_nonce,
						'action': 'get_delivery_info',
						'id': id
					},
					success: function(response) {
						if (response.content != '') {
							$display_area.html( response.content );
							$display_area.css( 'display', 'block' );
						}

						listing_ajax_stop( $ele );
					},
					error: function(xhr, status, error) {
						alert( error );
						listing_ajax_stop( $ele );
					}
				}
			);
		}

		/* Utitlity functions */
		function listing_ajax_start($ele) {
			$ele.prepend( "<span id='dt-spinner'><img src='" + LOCAL_OBJ.asset_url + "/images/loading.gif' /></span>" );
			$( '#dt-spinner' ).css( 'display', 'block' );
		}

		function listing_ajax_stop($ele) {
			$( '#dt-spinner' ).remove();
		}
	}
);
