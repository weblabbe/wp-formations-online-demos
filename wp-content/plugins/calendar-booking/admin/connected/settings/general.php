<?php
global $cbsb;
$current_settings = cbsb_current_settings();

$booking_window_start_qty = $current_settings['booking_window_start_qty'];
$booking_window_end_qty = $current_settings['booking_window_end_qty'];

?>
<section id="content">
				
	<div class="block">

		<h3><?php _e( 'General Settings', 'calendar-booking' ); ?></h3>
		<br />

		<h4><?php _e( 'Openings Interval', 'calendar-booking' ); ?></h4>
		<div class="text-sm">
			<p><?php _e('Set the interval of time for available openings. Default is every 30 minutes.', 'calendar-booking') ?></p>
			<a href="<?php echo CBSB_APP_URL; ?>/account/settings?utm_source=plugin&utm_medium=settings&utm_content=adjust-interval"><?php _e('Adjust on Start Booking &rarr;', 'calendar-booking') ?></a>
		</div>

		<hr />

		<h4><?php _e( 'Type of Location', 'calendar-booking' ); ?></h4>
		<div class="text-sm">
			<p><?php _e('This setting will change whether we display your address to customers. i.e. physical or digital.', 'calendar-booking') ?></p>
			<a href="<?php echo CBSB_APP_URL; ?>/account/settingsutm_source=plugin&utm_medium=settings&utm_content=location-type"><?php _e('Adjust on Start Booking &rarr;', 'calendar-booking') ?></a>
		</div>

		<hr />

		<h4><?php _e( 'Currency', 'calendar-booking' ); ?></h4>
		<div class="text-sm">
			<p><?php _e('Change the currency that is displayed.', 'calendar-booking') ?></p>
			<a href="<?php echo CBSB_APP_URL; ?>/account/settingsutm_source=plugin&utm_medium=settings&utm_content=currency"><?php _e('Adjust on Start Booking &rarr;', 'calendar-booking') ?></a>
		</div>

		<hr />

		<h4><?php _e( 'Cancellations', 'calendar-booking' ); ?></h4>
		<div class="text-sm">
			<p><?php _e('This setting will add a link to the appointment confirmation email allowing the customer to cancel their own appointments.', 'calendar-booking') ?></p>
			<a href="<?php echo CBSB_APP_URL; ?>/account/settingsutm_source=plugin&utm_medium=settings&utm_content=cancellations"><?php _e('Adjust on Start Booking &rarr;', 'calendar-booking') ?></a>
		</div>

		<hr />

		<form class="booking-form">
			<div class="row">
				<label for="endorse"><?php _e( 'Endorse Us', 'calendar-booking' ); ?></label>
				<div class="form-field">
					<div class="checkbox">
						<input id="endorse" type="checkbox" name="endorse-us" <?php checked( $current_settings['endorse_us'], 'true', true ); ?>/>
					</div>
				</div>
			</div>
			<div class="text-sm">
				<p><?php _e( 'Display a small powered by Start Booking at the end of checkout to help support Start Booking.', 'calendar-booking' ); ?></p>
			</div>

			<hr />

			<div class="row">
				<label for="additional_data"><?php _e( 'Additional Data', 'calendar-booking' ); ?></label>
				<div class="form-field">
					<div class="checkbox">
						<input id="additional_data" type="checkbox" name="additional-data" <?php checked( $current_settings['allow_data_collection'], 'true', true ); ?>/>
					</div>
				</div>
			</div>
			<div class="text-sm">
				<p><?php _e( 'Empower the Start Booking team to make data driven decisions by sharing basic information with us. This does not contain any confidential or sensitive information.', 'calendar-booking' ); ?></p>
			</div>

		</form>

	</div>
</section>