<?php

function cbsb_load_textdomain() {
	load_plugin_textdomain( 'calendar-booking', false, basename( CBSB_BASE_DIR ) . '/languages/' );
}
add_action( 'plugins_loaded', 'cbsb_load_textdomain' );

function cbsb_create_booking_page( $title ) {

	$content = '[startbooking flow="services"]';

	$post = array(
		'post_title'     => $title,
		'post_content'   => $content,
		'post_status'    => 'publish',
		'post_type'      => 'page',
	);
	$create = wp_insert_post( $post );
	if ( $create ) {
		update_option( 'cbsb_booking_page', $create );
		$response = array( 'status' => 'success', 'message' => 'Booking Page Created.', 'reload' => true );
	} else {
		$response = array( 'status' => 'error', 'message' => 'Unable to create page.', 'reload' => false );
	}
}

function cbsb_add_services( $wp_data ) {
	if ( isset( $_GET['add_service'] ) ) {
		$wp_data['initialState']->services = array();
		if ( ! is_array( $_GET['add_service'] ) ) { $_GET['add_service'] = array( $_GET['add_service'] ); }
		$wp_data['initialState']->services = array_map( 'esc_html', $_GET['add_service'] );
		$service_details = cbsb_api_request( 'services' );
		if ( 'Success' == $service_details->message && isset( $service_details->services ) ) {
			$wp_data['initialState']->total_duration = 0;
			foreach ( $service_details->services as $service ) {
				if ( in_array( $service->url_string, $wp_data['initialState']->services ) ) {
					$wp_data['initialState']->total_duration += $service->duration;
					$wp_data['initialState']->service_names[] = $service->name;

					//TODO this is temp until we can get the front end in sync
					$service->uid = $service->url_string;
					if ( is_array( $service->types ) ) {
						foreach ( $service->types as $type ) {
							$type->uid = $type->url_string;
						}
					}
					//End TODO

					$wp_data['initialState']->default_cart[] = $service;
				}
			}
			$wp_data['skipSteps'][] = 'services';
		}
	}
	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_add_services', 20, 1 );

function cbsb_get_account_timezone() {
	$details = cbsb_account_details();
	if ( isset( $details['account_details'] ) && property_exists( $details['account_details'], 'timezone' ) ) {
		return $details['account_details']->timezone;
	} else {
		return false;
	}
}

function cbsb_get_account_location_type() {
	$details = cbsb_account_details();
	if ( isset( $details['account_details'] ) && property_exists( $details['account_details'], 'location_type' ) ) {
		return $details['account_details']->location_type;
	} else {
		return false;
	}
}

function cbsb_account_details( $wp_data = array() ) {
	global $cbsb;
	$details = $cbsb->get( 'account/details' );
	if ( 'success' == $details['status'] && isset( $details['data'] ) ) {
		$wp_data['account_details'] = $details['data'];
		$wp_data['account_details']->domain = get_site_url();
		if (property_exists($wp_data['account_details'], 'address')) {
			$wp_data['account_details']->account_uid = $wp_data['account_details']->address->account_url_string;
		}
		$wp_data['account_details']->days_closed = array();
		$days = array_flip( array(
			'Sunday',
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday'
		) );
		if ( isset( $wp_data['account_details'] ) && property_exists( $wp_data['account_details'], 'location_hours' ) && is_array( $wp_data['account_details']->location_hours ) ) {
			foreach ( $wp_data['account_details']->location_hours as $weekday ) {
				if ( 'closed' == $weekday->day_type ) {
					$wp_data['account_details']->days_closed[] = $days[$weekday->day];
				}
			}
		}
		if ( isset( $wp_data['account_details']->payments ) ) {
			$wp_data['account_details']->payments->plugin_name = 'WordPress: Calendar Booking by Start Booking';
			$wp_data['account_details']->payments->plugin_version = CBSB_VERSION;
			$wp_data['account_details']->payments->site_url = site_url();
		}
	}

	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_account_details', 10, 1 );

function cbsb_cast_settings($settings) {
	foreach ( $settings as $key => $value ) {
		if ( 'true' === $value ) {
			$settings[ $key ] = true;
		}
		if ( 'false' === $value ) {
			$settings[ $key ] = false;
		}
	}
	return $settings;
}

function cbsb_get_banner() {
	if ( ! cbsb_is_connected() ) { return false; }
	$banner = cbsb_api_request( 'banner', array(), 'GET', 900 );
	return $banner;
}

function cbsb_current_settings() {
	$defaults = array(
		'btn_bg_color'                      => '000',
		'btn_txt_color'                     => 'fff',
		'endorse_us'                        => false,
		'show_progress'                     => true,
		'allow_data_collection'             => false,
		'is_connected'                      => ( get_option( 'cbsb_connection' ) ) ? true : false,
		'disable_booking'                   => false,
		'expedited_single_service'          => true,
		'expedited_single_service_type'     => true,
		'expedited_qty_services'            => true,
		'booking_window'                    => 0,
		'default_class_view'                => 'list',
		'show_sold_out_classes'             => true,
		'show_room_details'                 => true,
		'show_remaining_availability'       => true,
		'class_destination'                 => '',
		'service_destination'               => '',
		'automatic_provider'                => true,
		'appointment_use_visitor_timezone'  => true,
		'use_visitor_timezone'              => true,
		'booking_window_start_qty'          => 0,
		'booking_window_end_qty'            => 0,
		'booking_window_start_type'         => 'none',
		'booking_window_end_type'           => 'none',
		'calendar_locale'                   => 'en',
		'hour_format'                       => 12,
		'api_communication'                 => null
	);

	$current_settings = get_option( 'start_booking_settings' );

	$current_settings = wp_parse_args( $current_settings, $defaults );

	$channel_settings = cbsb_api_request( 'channel/wordpress', array(), 'GET', 30 );

	if ( isset( $channel_settings->data ) ) {
		$channel_settings = (array) $channel_settings->data;
		$channel_settings = array_diff( $channel_settings, array( null ) );
		$current_settings = wp_parse_args( $channel_settings, $current_settings );
	}

	$editors = cbsb_api_request( 'editors/settings', array(), 'GET', 30 );
	if ( ! isset( $editors->error ) && isset($editors->data->settings) ) {
		$current_settings['booking_window_start_qty'] = intval( $editors->data->settings->booking_window_start_qty );
		$current_settings['booking_window_end_qty'] = intval( $editors->data->settings->booking_window_end_qty );
		$current_settings['booking_window_start_type'] = $editors->data->settings->booking_window_start_type;
		$current_settings['booking_window_end_type'] = $editors->data->settings->booking_window_end_type;
		$current_settings['use_visitor_timezone'] = $editors->data->settings->use_visitor_timezone;
		$current_settings['allow_data_collection'] = $editors->data->settings->allow_data_collection;
		$current_settings['calendar_locale'] = $editors->data->settings->calendar_locale;
	}

	$current_settings = cbsb_calculate_window( $current_settings );
	return cbsb_cast_settings( $current_settings );
}

function cbsb_calculate_window( $settings ) {
	$settings['booking_window_start_qty'] = (int) $settings['booking_window_start_qty'];
	$settings['booking_window_end_qty'] = (int) $settings['booking_window_end_qty'];

	switch ( $settings['booking_window_start_type'] ) {
		case 'days':
			$start_multiplier = DAY_IN_SECONDS;
			break;
		case 'weeks':
			$start_multiplier = WEEK_IN_SECONDS;
			break;
		case 'months':
			$start_multiplier = MONTH_IN_SECONDS;
			break;
		default:
			$start_multiplier = 0;
			break;
	}

	$end_multiplier = 0;
	switch ( $settings['booking_window_end_type'] ) {
		case 'days':
			$end_multiplier = DAY_IN_SECONDS;
			break;
		case 'weeks':
			$end_multiplier = WEEK_IN_SECONDS;
			break;
		case 'months':
			$end_multiplier = MONTH_IN_SECONDS;
			break;
		default:
			$end_multiplier = 0;
			break;
	}

	$settings['booking_window_start'] = $settings['booking_window_start_qty'] * $start_multiplier;

	$settings['booking_window_end'] = $settings['booking_window_end_qty'] * $end_multiplier;

	return $settings;
}

function cbsb_account_subscription() {
	if ( ! cbsb_is_connected() ) { return false; }
	$account_status = cbsb_api_request( 'account/billing/status' );
	if ( is_object( $account_status ) && property_exists( $account_status, 'valid' ) ) {
		return $account_status->valid;
	} else {
		return false;
	}
}

function cbsb_active_subscription( $wp_data ) {
	$wp_data['account_status'] = cbsb_account_subscription();
	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_active_subscription', 10, 1 );

function cbsb_get_rest_api() {
	$settings = cbsb_current_settings();
	if ( $settings['api_communication'] == 'direct' ) {
		$rest_api = CBSB_API_URL . 'api';
	} else {
		$rest_api = get_rest_url() . 'startbooking';
	}
	return $rest_api;
}

function cbsb_copy_transfer( $wp_data ) {
	$wp_data['copy'] = cbsb_get_copy();
	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_copy_transfer', 10, 1 );

function cbsb_array_merge_recursive_simple() {

	if (func_num_args() < 2) {
		trigger_error(__FUNCTION__ .' needs two or more array arguments', E_USER_WARNING);
		return;
	}
	$arrays = func_get_args();
	$merged = array();
	while ($arrays) {
		$array = array_shift($arrays);
		if (!is_array($array)) {
			trigger_error(__FUNCTION__ .' encountered a non array argument', E_USER_WARNING);
			return;
		}
		if (!$array)
			continue;
		foreach ($array as $key => $value)
			if (is_string($key))
				if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key]))
					$merged[$key] = call_user_func(__FUNCTION__, $merged[$key], $value);
				else
					$merged[$key] = $value;
			else
				$merged[] = $value;
	}
	return $merged;
}

function cbsb_get_brightness($hex) {
	$hex = str_replace('#', '', $hex);
	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}

function cbsb_set_groups( $wp_data ) {
	if ( cbsb_is_connected() ) {
		$groups = cbsb_api_request( 'classes' );
		if ( 'Success' == $groups->message && isset( $groups->data ) ) {
			$wp_data['groups'] = array();
			foreach ($groups->data as $group) {
				$wp_data['groups'][] = (array) $group;
			}
		}
	}
	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_set_groups', 10, 1 );

function cbsb_set_locale( $wp_data ) {
	$wp_data['locale'] = $wp_data['settings']['calendar_locale'];
	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_set_locale', 10, 1 );

function cbsb_set_users( $wp_data ) {
	if ( cbsb_is_connected() ) {
		$users = cbsb_api_request( 'services/providers' );
		if ( $users && is_array( $users ) && count( $users ) > 0 ) {
			foreach ( $users as $k => $user ) {
				$user->fullname = $user->first_name . ' ' . $user->last_name;
				$users[ $k ] = $user;
			}
			$wp_data['users'] = $users;
		}
	}
	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_set_users', 10, 1 );

function cbsb_set_integrations( $wp_data ) {
	if ( cbsb_is_connected() ) {
		$integrations = cbsb_api_request( 'integrations' );
		if ( 'Success' == $integrations->message && isset( $integrations->data ) ) {
			$wp_data['integrations'] = $integrations->data;
		}
	}
	return $wp_data;
}
add_filter( 'cbsb_react_fe', 'cbsb_set_integrations', 10, 1 );

function cbsb_get_plan() {
	global $cbsb;
	$account_details = $cbsb->get( 'account/details' );
	if ( isset( $account_details['data'] ) && property_exists( $account_details['data'], 'billing' ) ) {
		$plan = $account_details['data']->billing->has_valid_subscription;
	} else {
		$plan = 'free';
	}
	return $plan;
}

function cbsb_get_application_loader() {
	return '
	<div class="sb-loader">
		<div style="width: 300px; text-align: \'center\'; line-height:\'initial\'; margin:\'auto\'">
			<p>' . __( 'Loading', 'calendar-booking' ) . '</p>
			<svg style="display: \'block\'; margin: \'auto\'"
				version="1.1"
				xmlns="http://www.w3.org/2000/svg"
				xmlnsXlink="http://www.w3.org/1999/xlink"
				enableBackground="new 0 0 0 0"
				xmlSpace="preserve"
			>
				<circle fill="#888" stroke="none" cx="100" cy="50" r="6">
					<animate
						attributeName="opacity"
						dur="2s"
						values="0;1;0"
						repeatCount="indefinite"
						begin="0"
					/>
				</circle>
				<circle fill="#888" stroke="none" cx="150" cy="50" r="6">
					<animate
						attributeName="opacity"
						dur="2s"
						values="0;1;0"
						repeatCount="indefinite"
						begin="0.5"
					/>
				</circle>
				<circle fill="#888" stroke="none" cx="200" cy="50" r="6">
					<animate
						attributeName="opacity"
						dur="2s"
						values="0;1;0"
						repeatCount="indefinite"
						begin="1"
					/>
				</circle>
			</svg>
		</div>
		<noscript>
			For online booking to function it is necessary to enable JavaScript.
			Here are the <a href="https://www.enable-javascript.com/" target="_blank">
			instructions to enable JavaScript in your web browser</a>.
		</noscript>
	</div>';
}

function cbsb_get_locale_map() {
	$map = array(
		'af' => array(
			'name' => 'Afrikaans',
			'code' => 'af',
		),
		'ak' => array(
			'name' => 'Akan',
			'code' => 'ak',
		),
		'sq' => array(
			'name' => 'Albanian',
			'code' => 'sq',
		),
		'am' => array(
			'name' => 'Amharic',
			'code' => 'am',
		),
		'ar' => array(
			'name' => 'Arabic',
			'code' => 'ar',
		),
		'hy' => array(
			'name' => 'Armenian',
			'code' => 'hy',
		),
		'rup_MK' => array(
			'name' => 'Aromanian',
			'code' => 'rup',
		),
		'as' => array(
			'name' => 'Arabic',
			'code' => 'as',
		),
		'ar' => array(
			'name' => 'Assamese',
			'code' => 'ar',
		),
		'az' => array(
			'name' => 'Azerbaijani',
			'code' => 'az',
		),
		'az_TR' => array(
			'name' => 'Azerbaijani (Turkey)',
			'code' => 'az-tr',
		),
		'ba' => array(
			'name' => 'Bashkir',
			'code' => 'ba',
		),
		'eu' => array(
			'name' => 'Basque',
			'code' => 'eu',
		),
		'bel' => array(
			'name' => 'Belarusian',
			'code' => 'bel',
		),
		'bn_BD' => array(
			'name' => 'Bengali',
			'code' => 'bn',
		),
		'bs_BA' => array(
			'name' => 'Bosnian',
			'code' => 'bs',
		),
		'bg_BG' => array(
			'name' => 'Bulgarian',
			'code' => 'bg',
		),
		'my_MM' => array(
			'name' => 'Burmese',
			'code' => 'mya',
		),
		'ca' => array(
			'name' => 'Catalan',
			'code' => 'ca',
		),
		'bal' => array(
			'name' => 'Catalan (Balear)',
			'code' => 'bal',
		),
		'zh_CN' => array(
			'name' => 'Chinese (China)',
			'code' => 'zh-cn',
		),
		'zh_HK' => array(
			'name' => 'Chinese (China)',
			'code' => 'zh-hk',
		),
		'zh_TW' => array(
			'name' => 'Chinese (Taiwan)',
			'code' => 'zh-tw',
		),
		'co' => array(
			'name' => 'Corsican',
			'code' => 'co',
		),
		'hr' => array(
			'name' => 'Croatian',
			'code' => 'hr',
		),
		'cs_CZ' => array(
			'name' => 'Czech',
			'code' => 'cs',
		),
		'da_DK' => array(
			'name' => 'Danish',
			'code' => 'da',
		),
		'cs_CZ' => array(
			'name' => 'Czech',
			'code' => 'cs',
		),
		'dv' => array(
			'name' => 'Dhivehi',
			'code' => 'dv',
		),
		'nl_NL' => array(
			'name' => 'Dutch',
			'code' => 'nl',
		),
		'nl_BE' => array(
			'name' => 'Dutch (Belgium)',
			'code' => 'nl-be',
		),
		'en_US' => array(
			'name' => 'English',
			'code' => 'en',
		),
		'en_AU' => array(
			'name' => 'English (Australia)',
			'code' => 'en-au',
		),
		'en_CA' => array(
			'name' => 'English (Canada)',
			'code' => 'en-ca',
		),
		'en_GB' => array(
			'name' => 'English (UK)',
			'code' => 'en-gb',
		),
		'eo' => array(
			'name' => 'Esperanto',
			'code' => 'eo',
		),
		'et' => array(
			'name' => 'Estonian',
			'code' => 'et',
		),
		'fo' => array(
			'name' => 'Faroese',
			'code' => 'fo',
		),
		'fi' => array(
			'name' => 'Finnish',
			'code' => 'fi',
		),
		'fr_BE' => array(
			'name' => 'French (Belgium)',
			'code' => 'fr-be',
		),
		'fr_FR' => array(
			'name' => 'French (France)',
			'code' => 'fr',
		),
		'fy' => array(
			'name' => 'Frisian',
			'code' => 'fy',
		),
		'fuc' => array(
			'name' => 'Fulah',
			'code' => 'fuc',
		),
		'gl_ES' => array(
			'name' => 'Galician',
			'code' => 'gl',
		),
		'ka_GE' => array(
			'name' => 'Georgian',
			'code' => 'ka',
		),
		'de_DE' => array(
			'name' => 'German',
			'code' => 'de',
		),
		'de_CH' => array(
			'name' => 'German (Switzerland)',
			'code' => 'de-ch',
		),
		'el' => array(
			'name' => 'Greek',
			'code' => 'el',
		),
		'gn' => array(
			'name' => 'Guaraní',
			'code' => 'gn',
		),
		'gu_IN' => array(
			'name' => 'Gujarati',
			'code' => 'gu',
		),
		'haw_US' => array(
			'name' => 'Hawaiian',
			'code' => 'haw',
		),
		'haz' => array(
			'name' => 'Hazaragi',
			'code' => 'haz',
		),
		'he_IL' => array(
			'name' => 'Hebrew',
			'code' => 'he',
		),
		'hi_IN' => array(
			'name' => 'Hindi',
			'code' => 'hi',
		),
		'hu_HU' => array(
			'name' => 'Hungarian',
			'code' => 'hu',
		),
		'is_IS' => array(
			'name' => 'Icelandic',
			'code' => 'is',
		),
		'ido' => array(
			'name' => 'Ido',
			'code' => 'ido',
		),
		'id_ID' => array(
			'name' => 'Indonesian',
			'code' => 'id',
		),
		'ga' => array(
			'name' => 'Irish',
			'code' => 'ga',
		),
		'it_IT' => array(
			'name' => 'Italian',
			'code' => 'it',
		),
		'ja' => array(
			'name' => 'Japanese',
			'code' => 'ja',
		),
		'jv_ID' => array(
			'name' => 'Javanese',
			'code' => 'jv',
		),
		'kn' => array(
			'name' => 'Kannada',
			'code' => 'kn',
		),
		'kk' => array(
			'name' => 'Kazakh',
			'code' => 'kk',
		),
		'km' => array(
			'name' => 'Khmer',
			'code' => 'km',
		),
		'kin' => array(
			'name' => 'Kinyarwanda',
			'code' => 'kin',
		),
		'ky_KY' => array(
			'name' => 'Kirghiz',
			'code' => 'ky',
		),
		'ko_KR' => array(
			'name' => 'Korean',
			'code' => 'ko',
		),
		'ckb' => array(
			'name' => 'Kurdish (Sorani)',
			'code' => 'ckb',
		),
		'lo' => array(
			'name' => 'Lao',
			'code' => 'lo',
		),
		'lv' => array(
			'name' => 'Latvian',
			'code' => 'lv',
		),
		'li' => array(
			'name' => 'Limburgish',
			'code' => 'li',
		),
		'lin' => array(
			'name' => 'Lingala',
			'code' => 'lin',
		),
		'lt_LT' => array(
			'name' => 'Lithuanian',
			'code' => 'lt',
		),
		'lb_LU' => array(
			'name' => 'Luxembourgish',
			'code' => 'lb',
		),
		'mk_MK' => array(
			'name' => 'Macedonian',
			'code' => 'mk',
		),
		'mg_MG' => array(
			'name' => 'Malagasy',
			'code' => 'mg',
		),
		'ms_MY' => array(
			'name' => 'Malay',
			'code' => 'ms',
		),
		'ml_IN' => array(
			'name' => 'Malayalam',
			'code' => 'ml',
		),
		'lb_LU' => array(
			'name' => 'Luxembourgish',
			'code' => 'lb',
		),
		'xmf' => array(
			'name' => 'Mingrelian',
			'code' => 'xmf',
		),
		'mn' => array(
			'name' => 'Mongolian',
			'code' => 'mn',
		),
		'me_ME' => array(
			'name' => 'Montenegrin',
			'code' => 'me',
		),
		'ne_NP' => array(
			'name' => 'Nepali',
			'code' => 'ne',
		),
		'nb_NO' => array(
			'name' => 'Norwegian (Bokmål)',
			'code' => 'nb',
		),
		'nn_NO' => array(
			'name' => 'Norwegian (Nynorsk)',
			'code' => 'nn',
		),
		'ory' => array(
			'name' => 'Oriya',
			'code' => 'ory',
		),
		'os' => array(
			'name' => 'Ossetic',
			'code' => 'os',
		),
		'ps' => array(
			'name' => 'Pashto',
			'code' => 'ps',
		),
		'fa_IR' => array(
			'name' => 'Persian',
			'code' => 'fa',
		),
		'fa_AF' => array(
			'name' => 'Persian (Afghanistan)',
			'code' => 'fa-af',
		),
		'pl_PL' => array(
			'name' => 'Polish',
			'code' => 'pl',
		),
		'pt_BR' => array(
			'name' => 'Portuguese (Brazil)',
			'code' => 'pt-br',
		),
		'pt_PT' => array(
			'name' => 'Portuguese (Portugal) ',
			'code' => 'pt',
		),
		'pa_IN' => array(
			'name' => 'Punjabi',
			'code' => 'pa',
		),
		'rhg' => array(
			'name' => 'Rohingya',
			'code' => 'rhg',
		),
		'ro_RO' => array(
			'name' => 'Romanian',
			'code' => 'ro',
		),
		'ru_RU' => array(
			'name' => 'Russian',
			'code' => 'ru',
		),
		'ru_UA' => array(
			'name' => 'Russian (Ukraine)',
			'code' => 'ru-ua',
		),
		'rue' => array(
			'name' => 'Rusyn',
			'code' => 'rue',
		),
		'sah' => array(
			'name' => 'Sakha',
			'code' => 'sah',
		),
		'sa_IN' => array(
			'name' => 'Sanskrit',
			'code' => 'sa-in',
		),
		'srd' => array(
			'name' => 'Sardinian',
			'code' => 'srd',
		),
		'gd' => array(
			'name' => 'Scottish Gaelic',
			'code' => 'gd',
		),
		'sr_RS' => array(
			'name' => 'Serbian',
			'code' => 'sr',
		),
		'sd_PK' => array(
			'name' => 'Sindhi',
			'code' => 'sd',
		),
		'si_LK' => array(
			'name' => 'Sinhala',
			'code' => 'si',
		),
		'sk_SK' => array(
			'name' => 'Slovak',
			'code' => 'sk',
		),
		'sl_SI' => array(
			'name' => 'Slovenian',
			'code' => 'sl',
		),
		'so_SO' => array(
			'name' => 'Somali',
			'code' => 'so',
		),
		'azb' => array(
			'name' => 'South Azerbaijani',
			'code' => 'azb',
		),
		'es_AR' => array(
			'name' => 'Spanish (Argentina)',
			'code' => 'es-ar',
		),
		'es_CL' => array(
			'name' => 'Spanish (Chile)',
			'code' => 'es-cl',
		),
		'es_CO' => array(
			'name' => 'Spanish (Colombia)',
			'code' => 'es-co',
		),
		'es_MX' => array(
			'name' => 'Spanish (Mexico)',
			'code' => 'es-mx',
		),
		'es_PE' => array(
			'name' => 'Spanish (Peru)',
			'code' => 'es-pe',
		),
		'es_PR' => array(
			'name' => 'Spanish (Puerto Rico)',
			'code' => 'es-pr',
		),
		'es_ES' => array(
			'name' => 'Spanish (Spain)',
			'code' => 'es',
		),
		'es_VE' => array(
			'name' => 'Spanish (Venezuela)',
			'code' => 'es-ve',
		),
		'su_ID' => array(
			'name' => 'Sundanese',
			'code' => 'su',
		),
		'sw' => array(
			'name' => 'Swahili',
			'code' => 'sw',
		),
		'sv_SE' => array(
			'name' => 'Swedish',
			'code' => 'sv',
		),
		'gsw' => array(
			'name' => 'Swiss German',
			'code' => 'gsw',
		),
		'tl' => array(
			'name' => 'Tagalog',
			'code' => 'tl',
		),
		'tg' => array(
			'name' => 'Tajik',
			'code' => 'tg',
		),
		'tzm' => array(
			'name' => 'Tamazight (Central Atlas)',
			'code' => 'tzm',
		),
		'ta_IN' => array(
			'name' => 'Tamil',
			'code' => 'ta',
		),
		'ta_LK' => array(
			'name' => 'Tamil (Sri Lanka)',
			'code' => 'ta-lk',
		),
		'tt_RU' => array(
			'name' => 'Tatar',
			'code' => 'tt',
		),
		'te' => array(
			'name' => 'Telugu',
			'code' => 'te',
		),
		'th' => array(
			'name' => 'Thai',
			'code' => 'th',
		),
		'bo' => array(
			'name' => 'Tibetan',
			'code' => 'bo',
		),
		'tir' => array(
			'name' => 'Tigrinya',
			'code' => 'tir',
		),
		'tr_TR' => array(
			'name' => 'Turkish',
			'code' => 'tr',
		),
		'tuk' => array(
			'name' => 'Turkmen',
			'code' => 'tuk',
		),
		'ug_CN' => array(
			'name' => 'Uighur',
			'code' => 'ug',
		),
		'uk' => array(
			'name' => 'Ukrainian',
			'code' => 'uk',
		),
		'ur' => array(
			'name' => 'Urdu',
			'code' => 'ur',
		),
		'uz_UZ' => array(
			'name' => 'Uzbek',
			'code' => 'uz',
		),
		'vi' => array(
			'name' => 'Vietnamese',
			'code' => 'vi',
		),
		'wa' => array(
			'name' => 'Walloon',
			'code' => 'wa',
		),
		'cy' => array(
			'name' => 'Welsh',
			'code' => 'cy',
		),
		'yor' => array(
			'name' => 'Yoruba',
			'code' => 'yor',
		),
	);
	return $map;
}

function cbsb_is_connected() {
	$connection = get_option( 'cbsb_connection', false );
	return ( get_option( 'cbsb_connection', false ) ) ? true : false;
}

function cbsb_format_minutes( $duration ) {
	$hours = 0;
	$minutes = 0;
	$parts = $duration / 60;
	$hours = floor( $parts );
	$min_parts = $parts - $hours;
	$minutes = $min_parts * 60;
	$output = '';
	if ( 1 === $hours ) {
		$output .= '1 ' . __( 'hour', 'calendar-booking');
	} else if ( $hours > 1 ) {
		$output .= $hours . ' ' . __( 'hours', 'calendar-booking');
	}
	$output .= ' ';
	if ( 1 === $minutes ) {
		$output .= '1 ' . __( 'minute', 'calendar-booking');
	} else if ( $minutes > 1 ) {
		$output .= $minutes . ' ' . __( 'minutes', 'calendar-booking');
	}
	return trim( $output );
}

function cbsb_get_startbooking_global() {
	if ( cbsb_is_connected() ) {
		$account = cbsb_api_request( 'account/details' );
		$channel = cbsb_api_request( 'channel/wordpress' );
		if ( property_exists( $channel, 'message' ) && 'Success' === $channel->message && property_exists( $channel, 'data' ) ) {
			$channel = $channel->data;
		}
	} else {
		return array();
	}

	$rest_token = get_transient( 'cbsb_rest_token', false );
	if ( false === $rest_token ) {
		$rest_token = cbsb_generate_rest_token();
	}

	$settings = cbsb_current_settings();
	if ( $settings['api_communication'] == 'direct' ) {
		global $wp_version;
		$connection = get_option( 'cbsb_connection' );
		$token = isset( $connection['token'] ) ? $connection['token'] : null;
		$account_url_string = isset( $connection['account'] ) ? $connection['account'] : null;
		$direct = array(
			'user_agent'  => 'WP:BK:Direct/' . $wp_version . ':' . CBSB_VERSION . ':StartBookingComAPI; ' . home_url(),
			'token'       => $token,
			'account'     => $account_url_string
		);
	}

	$integrations = cbsb_api_request( 'integrations', array(), 'GET', 30 );

	if ( is_object( $integrations ) &&
		!isset($integrations->error) &&
		'Success' == $integrations->message &&
		isset( $integrations->data ) ) {
		$integrations = (array) $integrations->data;
	} else {
		$integrations = array();
	}

	$return = array(
		'rest_api'        => cbsb_get_rest_api(),
		'base_url'        => CBSB_BASE_URL,
		'app_url'         => CBSB_APP_URL,
		'api_url'         => CBSB_API_URL,
		'wp_url'          => home_url(),
		'wp_admin_url'    => admin_url(),
		'settings'        => cbsb_current_settings(),
		'token'           => $rest_token,
		'connected'       => ( cbsb_is_connected() ) ? 'true' : 'false',
		'product'         => ( isset( $account->billing->product ) ) ? $account->billing->product : null,
		'direct'          => ( isset( $direct ) ) ? $direct : null,
		'integrations'    => ( isset( $integrations ) ) ? $integrations : null,
	);

	if ( ! is_null( $account ) ) {
		$default_store = new StdClass;
		$default_store->account = $account;
		$default_store->account->channel_settings = $channel;
		$return['default_store'] = $default_store;
	}

	return array_filter( $return );
}

function cbsb_check_token( $token ) {
	$active_token = get_transient( 'cbsb_rest_token', false );
	$recent_tokens = get_option( 'cbsb_rest_token_history', array() );
	if ( $token === $active_token ) {
		return 'active';
	}

	if ( in_array( $token, $recent_tokens ) ) {
		return 'recent';
	}

	return 'invalid';
}

function cbsb_generate_rest_token() {
	$rest_token = wp_generate_password( 10, false );
	set_transient( 'cbsb_rest_token', $rest_token, 4 * HOUR_IN_SECONDS );
	$rest_token_history = get_option( 'cbsb_rest_token_history', array() );
	foreach ( $rest_token_history as $timestamp => $token ) {
		if ( $timestamp < ( time() -  ( DAY_IN_SECONDS * 2 ) ) ) {
			unset( $rest_token_history[ $timestamp ] );
		}
	}
	$rest_token_history[ time() ] = $rest_token;
	update_option( 'cbsb_rest_token_history', $rest_token_history );
	return $rest_token;
}

function cbsb_captive_flow() {
	echo "<style type='text/css'>
		#adminmenuwrap, #adminmenuback {display: none;}
		#wpcontent, #wpfooter { margin-left: 0px; padding-left:0px;}
		.bottom-panel {left: 0; width: 100%;}
	</style>";
}

function cbsb_suppress_notices() {
	if ( isset( $_GET['page'] ) && false !== strpos( $_GET['page'], 'cbsb-' ) ) {
		?>
		<style type="text/css">
			.update-nag,
			.notice,
			.notice-error,
			.notice-warning,
			.notice-success,
			.notice-info {
				display:none;
			}
		</style>
		<?php
	}
}

function cbsb_activate( $plugin ) {
	if ( $plugin == 'calendar-booking/start-booking.php' && get_option( 'cbsb_connection', false ) == false && 50 > mt_rand( 0, 99 ) ) {
		set_transient( 'cbsb_onboard_details', array( 'time' => time(), 'type' => 'notice' ), ( 7 * DAY_IN_SECONDS ) );
		exit( wp_redirect( admin_url( 'plugins.php' ) ) );
	}
	if ( $plugin == 'calendar-booking/start-booking.php' && get_option( 'cbsb_connection', false ) == false ) {
		set_transient( 'cbsb_onboard_details', array( 'time' => time(), 'type' => 'redirect' ), DAY_IN_SECONDS * 7 );
		exit( wp_redirect( admin_url( 'admin.php?page=cbsb-signup' ) ) );
	}
}
add_action( 'activated_plugin', 'cbsb_activate' );

function cbsb_not_connected_notice(){
	if ( get_option( 'cbsb_connection', false ) == false ) {
		$onboard_details = get_transient( 'cbsb_onboard_details', false );
		if ( $onboard_details !== false && isset( $onboard_details['type'] ) && 'notice' == $onboard_details['type'] ) {
			echo '<div class="notice notice-info">
				<p>Connect your Start Booking account to <a href="admin.php?page=cbsb-signup">get started</a>.</p>
				</div>';
		}
	}
}
add_action( 'admin_notices', 'cbsb_not_connected_notice' );

function cbsb_booking_flow() {
	return "[startbooking flow='services']";
}

function cbsb_force_booking_flow() {
	if (isset($_GET['cbsb_force']) && true == $_GET['cbsb_force']) {
		$allowed_params = array('type', 'service', 'add_services', 'provider', 'date');
		nocache_headers();
		cbsb_load_service_block_scripts_styles();
		add_filter( 'the_content', 'cbsb_booking_flow', 9 );
	}
}
add_action( 'init', 'cbsb_force_booking_flow' );
