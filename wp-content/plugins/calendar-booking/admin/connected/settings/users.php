<?php 
$users = cbsb_api_request( 'services/providers', array(), 'GET', 30 );
?>
<section id="content">
	<div class="heading">
		<a class="button button-override" target="_blank" href="<?php echo CBSB_APP_URL; ?>account/users?utm_source=plugin&utm_medium=handoff&utm_content=add-user"><?php _e( 'Add User', 'calendar-booking' ); ?></a>
		<h2><?php _e( 'Users', 'calendar-booking' ); ?></h2>
	</div>
	<div class="services-block">
		<ul class="services-list">
			<?php
			foreach ($users as $user) {
				?>
				<li>
					<span><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
					<div class="links">
						<a target="_blank" href="<?php echo CBSB_APP_URL . 'account/user/' . $user->url_string; ?>">
							<?php _e( 'Edit', 'calendar-booking' ); ?>
						</a>
						&nbsp;|&nbsp;
						<a target="_blank" href="<?php echo CBSB_APP_URL . 'account/user/' . $user->url_string . '/settings'; ?>"><?php _e( 'Notifications', 'calendar-booking' ); ?>
						</a>
						&nbsp;|&nbsp;
						<a target="_blank" href="<?php echo CBSB_APP_URL . 'account/availability'; ?>">
							<?php _e( 'Availability', 'calendar-booking' ); ?>
						</a>
					</div>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</section>