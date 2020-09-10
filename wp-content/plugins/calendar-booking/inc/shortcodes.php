<?php 

function cbsb_legacy_service_flow() {
	add_action( 'wp_footer', 'cbsb_fe_styles' );
	add_action( 'wp_footer', 'cbsb_fe_script' );
	$markup = '
	<div id="startbooking-flow">
		<div id="startbooking-appointment-flow">
			' . cbsb_get_application_loader() . '
		</div>
	</div>';
	return $markup;
}

function cbsb_legacy_classes_flow() {
	add_action( 'wp_footer', 'cbsb_fe_styles' );
	add_action( 'wp_footer', 'cbsb_fe_script' );
	$markup = '
	<div id="startbooking-flow">
		<div id="startbooking-class-flow">
			' . cbsb_get_application_loader() . '
		</div>
	</div>';
	return $markup;
}

function cbsb_classes_block_to_shortcode( $class_url_string ) {
	add_action( 'wp_footer', 'cbsb_fe_classes_styles' );
	add_action( 'wp_footer', 'cbsb_fe_classes_script' );
	if ( is_null( $class_url_string ) ) {
		$markup = '<div id="startbooking-classes"></div>';
	} else {
		$markup = '<div id="startbooking-classes" data-group="' . $class_url_string . '"></div>';
	}
	return $markup;
}

function cbsb_service_block_to_shortcode() {
	cbsb_load_service_block_scripts_styles();
	$markup = '
		<div class="wp-block-calendar-booking-default-booking-flow">
			<div id="startbooking-block-default">' . cbsb_get_application_loader() . '</div>
		</div>
	';
	return $markup;
}

function cbsb_single_service_block_to_shortcode( $atts ) {
	if ( is_array( $atts ) ) {
		$atts = array_map( 'trim', $atts );
	}
	cbsb_load_single_service_block_scripts_styles();
	if ( ! isset( $atts['service'] ) ) {
		return '<div><p style="color: red; font-weight:bold;">Service is a required parameter with single service shortcode.</p></div>';
	}

	if ( ! isset( $atts['details'] ) || ! in_array( $atts['details'], array( 'true', 'false' ) ) ) {
		$atts['details'] = 'true';
	}

	if ( $atts['details'] === 'true' ) {
		global $cbsb;
		$editors = $cbsb->get( 'editors', array(), 300 );
		$service = $cbsb->get( 'services/' . $atts['service'], array(), 300 );

		if ( 'success' === $editors['status'] && property_exists( $editors['data'], 'data' ) ) {
			$editors = $editors['data']->data;
		} else {
			return '<div id="startbooking-block-single-service" class="wp-block-calendar-booking-single-service-flow startbooking-block-single-service"
				data-block-service="' . trim( $atts['service'] ) . '"
				data-block-display-service="' . trim( $atts['details'] ) . '"
			></div>';
		}

		if ( 'success' === $service['status'] && property_exists( $service['data'], 'data' ) ) {
			$service = $service['data']->data;
		} else {
			return '<div id="startbooking-block-single-service" class="wp-block-calendar-booking-single-service-flow startbooking-block-single-service"
				data-block-service="' . trim( $atts['service'] ) . '"
				data-block-display-service="' . trim( $atts['details'] ) . '"
			></div>';
		}

		$markup = '<div class="wp-block-calendar-booking-single-service-flow startbooking-block-single-service"><div class="items-list"><div class="item"><div class="item-head">';

		if ( ! $editors->services->hide_price ) {
			$markup .= '<strong style="color:' . $editors->services->price_color . '" class="price">' . $service->readable_price . '</strong>';
		}

		$markup .= '<h2>'. $service->name . '</h2></div>';

		if ( ! $editors->services->hide_description ) {
			$markup .= '<p>' . $service->description . '</p>';
		}

		$markup .= '<div class="item-footer">';
		if ( ! $editors->services->hide_duration ) {
			$markup .= '<div class="time">' . cbsb_format_minutes( $service->duration ) . '</div>';
		} else {
			$markup .= '<div class="time"></div>';
		}

		$button_style = "
			background: linear-gradient(180deg, " . $editors->settings->default_button_background_color . " 0%, " . $editors->settings->default_button_background_color . "aa 100%);
			color: " . $editors->settings->default_button_text_color . ";
			box-shadow: inset 0 0 0 2px " . $editors->settings->default_button_background_color . ";
			border-radius: 4px;
			font-size: 14px;
			font-weight: bold;
			line-height: 1.2;
			display: inline-block;
			text-align: center;
			padding: 10px 13px;
			cursor: pointer;
			text-decoration: none;
		";
		$button_style = trim( str_replace( array("\r", "\n"), '', $button_style ) );

		$markup .= '<a dusk="select-service" style="' . $button_style . '" href="?cbsb_force=true&service=' . $atts['service'].'" >' . __('Select', 'calendar-booking' ) . '</a>';
		$markup .= '</div></div></div></div>';
	} else {
		$markup = '<div id="startbooking-block-single-service" class="wp-block-calendar-booking-single-service-flow startbooking-block-single-service"
				data-block-service="' . trim( $atts['service'] ) . '"
				data-block-display-service="' . trim( $atts['details'] ) . '"
			></div>';
	}
	return $markup;
}

function cbsb_sc_flow( $atts ) {
	if ( is_array( $atts ) ) {
		$atts = array_map( 'trim', $atts );
	}
	$atts = wp_parse_args( $atts, array( 'flow' => null, 'service' => null, 'class' => null ) );
	switch ( $atts['flow'] ) {
		case 'services':
			$markup = cbsb_service_block_to_shortcode();
			break;
		case 'classes':
			$markup = cbsb_classes_block_to_shortcode( $atts['class'] );
			break;
		case 'class':
			$markup = cbsb_classes_block_to_shortcode( $atts['class'] );
			break;
		case 'legacy-classes':
			$markup = cbsb_legacy_classes_flow();
			break;
		case 'single-service':
			$markup = cbsb_single_service_block_to_shortcode( $atts );
			break;
		case 'legacy':
			$markup = cbsb_legacy_service_flow();
			break;
		default:
			$markup = cbsb_service_block_to_shortcode();
			break;
	}
	return $markup;
}
add_shortcode( 'startbooking', 'cbsb_sc_flow' );

function cbsb_sc_book_items( $atts, $content = 'Book Now' ) {
	if ( is_array( $atts ) ) {
		$atts = array_map( 'trim', $atts );
	}
	$booking_page_id = get_option( 'cbsb_booking_page' );

	if ( false === get_option( 'cbsb_connection' ) ) {
		return '<p>Unable to display quick book link because StartBooking is not connected.';
	}

	if ( isset( $_GET['in_page_book'] ) && $_GET['in_page_book'] ) {
		return cbsb_sc_flow();
	}

	$default_atts = array(
		'services' => array(),
	);
	if ( isset( $atts['services'] ) ) {
		$atts['services'] = explode( ',', $atts['services'] );
	}

	$atts = wp_parse_args( $atts, $default_atts );

	$args = array(
		'cbsb_force' => true,
		'add_service' => $atts['services']
	);

	if ( is_numeric( $booking_page_id ) ) {
		$booking_url = get_permalink( $booking_page_id );
	} else {
		$booking_url = get_permalink( get_the_ID() );
	}
	$booking_url = add_query_arg( $args, $booking_url );
	$href = $booking_url . '#appointment-page';
	return "<a href='" . $href . "'>" . $content . "</a>";
}
add_shortcode( 'startbooking_cta', 'cbsb_sc_book_items' );

function cbsb_sc_class_flow( $atts = array(), $content = null ) {
	add_action( 'wp_footer', 'cbsb_fe_styles' );
	add_action( 'wp_footer', 'cbsb_fe_script' );
	$markup = '
	<div id="startbooking-flow">
		<div id="startbooking-class-flow">
			' . cbsb_get_application_loader() . '
		</div>
	</div>';
	return $markup;
}
add_shortcode( 'startbooking_classes', 'cbsb_sc_class_flow' );