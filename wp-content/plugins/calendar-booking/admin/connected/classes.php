<!-- main container of all the page elements -->
<div id="wrapper services">
	<!-- header of the page --> 
	<?php include( CBSB_BASE_DIR . 'admin/connected/header.php' ); ?>

	<main id="main">
		<!-- twocolumns -->
		<div class="twocolumns">
			<aside id="sidebar">
				<h2><?php _e( 'Upgrade for classes', 'calendar-booking' ); ?></h2>
				<p><?php _e('Manage and schedule classes with ease with our online class and scheduling system. From yoga to spinning, hikes to education and so much more.', 'calendar-booking' ); ?></p>
				<p><span style="margin-right: 6px;"><img src="<?php echo CBSB_BASE_URL; ?>/public/images/checkmark.png"></span>
					<strong><?php _e( 'Customizable', 'calendar-booking' ); ?></strong> <?php __( 'Emails', 'calendar-booking' ); ?>
				</p>
				<p><span style="margin-right: 6px;"><img src="<?php echo CBSB_BASE_URL; ?>/public/images/checkmark.png"></span>
					<strong><?php _e( 'Custom', 'calendar-booking' ); ?></strong> <?php _e( 'Schedules', 'calendar-booking' ); ?>
				</p>
				<p style="margin-bottom: 25px;"><span style="margin-right: 6px;"><img src="<?php echo CBSB_BASE_URL; ?>/public/images/checkmark.png"></span>
					<strong><?php _e( 'Recurring', 'calendar-booking' ); ?></strong> <?php _e( 'Classes', 'calendar-booking' ); ?>
				</p>
				<a href="<?php echo CBSB_APP_URL; ?>account/billing/upgrade?utm_source=plugin&utm_medium=upgrade&utm_content=classes" class="button button-override"><?php _e( 'Select Upgrade', 'calendar-booking' ); ?></a>
			</aside>
			<section id="content">
				<img src="<?php echo CBSB_BASE_URL; ?>/public/images/class-calendar.png" title="Start Booking - Classes" alt="Start Booking - Classes" style="width:100%;">
			</section>
		</div>
	</main>

</div>