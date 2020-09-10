<!-- main container of all the page elements -->
<div id="wrapper settings">

	<!-- header of the page --> 
	<?php include( CBSB_BASE_DIR . 'admin/connected/header.php' ); ?>

	<main id="main">
		<!-- twocolumns -->
		<div class="twocolumns">
			<!-- content -->

			<?php
				$plan = cbsb_get_plan();
				$nav = isset( $_GET['nav'] ) ? $_GET['nav'] : 'cbsb-embed';
				switch( $nav ) {
					case 'cbsb-embed' :
						include( CBSB_BASE_DIR . 'admin/connected/settings/embed.php' );
						break;

					case 'cbsb-general' :
						include( CBSB_BASE_DIR . 'admin/connected/settings/general.php' );
						break;
					case 'cbsb-users' :
						if ($plan) {
							include( CBSB_BASE_DIR . 'admin/connected/settings/users.php' );
						} else {
							include( CBSB_BASE_DIR . 'admin/connected/settings/user.php' );
						}
						break;

					case 'cbsb-addons' :
							include( CBSB_BASE_DIR . 'admin/connected/settings/addons.php' );
							break;
					
						case 'cbsb-integrations' :
						include( CBSB_BASE_DIR . 'admin/connected/settings/integrations.php' );
						break;

					case 'cbsb-connection' :
						include( CBSB_BASE_DIR . 'admin/connected/settings/connection.php' );
						break;

					default :
						include( CBSB_BASE_DIR . 'admin/connected/settings/embed.php' );
				
				}
			?>
			
			<!-- sidebar -->
			<aside id="sidebar">
				<h2 class="sub-heading"><?php _e( 'NAVIGATION', 'calendar-booking' ); ?></h2>
				<!-- sub navigation -->
				<ul class="sub-nav">
					<!-- To make the li active, class .active should be added to the li element. -->
					<li <?php if ( isset( $_GET['nav'] ) && $_GET['nav'] === 'cbsb-embed' || !isset( $_GET['nav'] ) ) { ?>class="active"<?php } ?>><a href="?page=cbsb-settings&nav=cbsb-embed"><?php _e( 'Embed Options', 'calendar-booking' ); ?></a></li>
					<li <?php if ( isset( $_GET['nav'] ) && $_GET['nav'] === 'cbsb-general' ) { ?>class="active"<?php } ?>><a href="?page=cbsb-settings&nav=cbsb-general"><?php _e( 'General Settings', 'calendar-booking' ); ?></a></li>
					<li <?php if ( isset( $_GET['nav'] ) && $_GET['nav'] === 'cbsb-addons' ) { ?>class="active"<?php } ?>><a href="?page=cbsb-settings&nav=cbsb-addons"><?php _e( 'Addons', 'calendar-booking' ); ?></a></li>
					<li <?php if ( isset( $_GET['nav'] ) && $_GET['nav'] === 'cbsb-integrations' ) { ?>class="active"<?php } ?>><a href="?page=cbsb-settings&nav=cbsb-integrations"><?php _e( 'Integrations', 'calendar-booking' ); ?></a></li>
					<li <?php if ( isset( $_GET['nav'] ) && $_GET['nav'] === 'cbsb-connection' ) { ?>class="active"<?php } ?>><a href="?page=cbsb-settings&nav=cbsb-connection"><?php _e( 'Connection', 'calendar-booking' ); ?> <div id="connection_indicator" class=""></div></a></li>
					<li <?php if ( isset( $_GET['nav'] ) && $_GET['nav'] === 'cbsb-users' ) { ?>class="active"<?php } ?>><a href="?page=cbsb-settings&nav=cbsb-users"><?php _e( 'Users', 'calendar-booking' ); ?></a></li>
				</ul>
			</aside>
		</div>

	</main>

</div>