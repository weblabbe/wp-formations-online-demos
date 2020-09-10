<!-- <div class="body-decor">
	<img src="<?php //echo CBSB_BASE_URL . 'images/V2/body-decor.png'; ?>">
</div> -->

<!-- main container of all the page elements -->
<div id="wrapper">
	<!-- contain main informative part of the site -->
	<main id="main">
		<div class="head-block">
			<div class="top-block">
				<!-- page logo -->
				<div class="startbooking-logo" id="startbooking-logo">
					<a href="#">
						<img src="<?php echo CBSB_BASE_URL . 'public/images/startbooking-logo.svg'; ?>" alt="Start Booking">
					</a>
				</div>
				<h1><?php _e( 'Welcome to Start Booking', 'calendar-booking' ); ?></h1>
				<p><?php _e( 'Start Booking powers thousands of service based individuals and businesses. Get started booking today!', 'calendar-booking' ); ?></p>
			</div>
		</div>
		<!-- container holder -->
		<div class="container-holder">
			<!-- registration form -->
			<div class="form">
				<form method="POST" id="signup">
					<div class="row">
						<div class="col-sm">
							<label for="first_name"><?php _e( 'First Name', 'calendar-booking' ); ?> *</label>
						</div>
						<div class="col-md">

							<div class="form-field">
								<input autofocus class="text-input" tabindex="1" name="first_name" type="text" id="first_name" placeholder="First Name" required data-validation="length" data-validation-length="min1">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm">
							<label for="last_name"><?php _e( 'Last Name', 'calendar-booking' ); ?> *</label>
						</div>
						<div class="col-md">
							<div class="form-field">
								<input class="text-input" tabindex="2" name="last_name" type="text" id="last_name" placeholder="Last Name" required data-validation="length" data-validation-length="min1">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm">
							<label for="email"><?php _e( 'Email Address', 'calendar-booking' ); ?> *</label>
						</div>
						<div class="col-md">
							<div class="form-field">
								<input class="text-input" tabindex="3" name="email" type="email" id="email" placeholder="my.email@gmail.com" required data-validation="email">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm">
							<label for="password"><?php _e( 'Password', 'calendar-booking' ); ?> *</label>
						</div>
						<div class="col-md">
							<div class="form-field">
								<input class="text-input" tabindex="5" name="password" type="password" id="password" required data-validation="strength" data-validation-strength="2">
							</div>
						</div>
					</div>
					<button tabindex="6" class="button-override" type="submit"><?php _e( 'Continue to next step', 'calendar-booking' ); ?> &rarr;</button>
				</form>
			</div>
			<!-- testimonials -->
			<div class="testimonials">
				<h2><?php _e( 'Testimonials', 'calendar-booking' ); ?></h2>
				<blockquote>
					<q>“<?php _e( 'Start Booking was game changing in helping us schedule and manage our customers. Won\'t open another location without it.', 'calendar-booking' ); ?>”</q>
					<cite>Tyler Devere <span><?php _e( 'Barbershop Owner', 'calendar-booking' ); ?></span></cite>
				</blockquote>
			</div>
		</div>

		<!-- <div class="container-holder">
			<div class="block-video">
				<a href="#" class="play-sb-video">
					<img width="810" src="<?php //echo CBSB_BASE_URL; ?>public/images/video-thumbnail.png" alt="Start Booking Video">
				</a>
			</div>
		</div> -->

		<div class="container-holder" style="margin-top: 30px;">
			<div class="block">
				<h2 style="margin-top:15px; text-align: center;font-size:22px;font-weight:500;"><?php _e( 'Better Scheduling Software', 'calendar-booking' ); ?></h2>
				<p style="text-align: center;"><?php _e( 'Start Booking helps you stay focused on what\'s most important while providing you with the best online scheduling tools to grow your business. We have a lot of features that empower you to get more bookings!', 'calendar-booking' ); ?></p>

				<div class="get-started-feature">
					<div class="get-started-feature-inner clearfix">
						<div class="feature-icon">
							<picture>
								<source srcset="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-services.png, <?php echo CBSB_BASE_URL; ?>public/images/icons/icon-services@2x.png 2x">
								<img src="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-services.png" alt="Services">
							</picture>
						</div>
						<div class="feature-copy">
							<h3><strong>Book appointments</strong> for your <strong>services</strong></h3>
							<p>With Start Booking, it's never been easier for your customers to book appointments with you. Simply, create your services and we'll display your availability straight to your customers.</p>
						</div>
					</div>
				</div>

				<div class="get-started-feature">
					<div class="get-started-feature-inner clearfix">
						<div class="feature-icon">
							<picture>
								<source srcset="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-classes.png, <?php echo CBSB_BASE_URL; ?>public/images/icons/icon-classes@2x.png 2x">
								<img src="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-classes.png" alt="Services">
							</picture>
						</div>
						<div class="feature-copy">
							<h3>Recurring <strong>classes and group events</strong></h3>
							<p>Need to hold a class or group event(s)? No worries, with Start Booking you can easily create classes, set your customer capacity and define how your class occurs.</p>
						</div>
					</div>
				</div>

				<div class="get-started-feature">
					<div class="get-started-feature-inner clearfix">
						<div class="feature-icon">
							<picture>
								<source srcset="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-api.png, <?php echo CBSB_BASE_URL; ?>public/images/icons/icon-api@2x.png 2x">
								<img src="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-api.png" alt="Services">
							</picture>
						</div>
						<div class="feature-copy">
							<h3>Powerful <strong>integrations with Google, Stripe</strong> and more</h3>
							<p>At Start Booking, we understand that it often takes many products and tools to accomplish your goals. Our focus is to deliver the world's best online scheduling tool while empowering you to integrate with other great softwares for anything else.</p>
						</div>
					</div>
				</div>

				<div class="get-started-feature">
					<div class="get-started-feature-inner clearfix">
						<div class="feature-icon">
							<picture>
								<source srcset="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-text.png, <?php echo CBSB_BASE_URL; ?>public/images/icons/icon-text@2x.png 2x">
								<img src="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-text.png" alt="Services">
							</picture>
						</div>
						<div class="feature-copy">
							<h3><strong>Email and text message</strong> confirmations and reminders</h3>
							<p>Clear communication is a key aspect to ensuring your customers arrive when they say they will. We provide email and text message communications to help you limit your no shows.</p>
						</div>
					</div>
				</div>

				<div class="get-started-feature">
					<div class="get-started-feature-inner clearfix">
						<div class="feature-icon">
							<picture>
								<source srcset="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-design.png, <?php echo CBSB_BASE_URL; ?>public/images/icons/icon-design@2x.png 2x">
								<img src="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-design.png" alt="Services">
							</picture>
						</div>
						<div class="feature-copy">
							<h3><strong>Custom fields</strong> with booking form <strong>visual editor</strong></h3>
							<p>One size does not fit all. With Start Booking, you get the ability to extend your booking form with custom form fields as well as our visual editor to make sure your booking form matches your brand.</p>
						</div>
					</div>
				</div>

				<div class="get-started-feature">
					<div class="get-started-feature-inner clearfix">
						<div class="feature-icon">
							<picture>
								<source srcset="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-embed.png, <?php echo CBSB_BASE_URL; ?>public/images/icons/icon-embed@2x.png 2x">
								<img src="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-embed.png" alt="Services">
							</picture>
						</div>
						<div class="feature-copy">
							<h3>Multiple <strong>display</strong> and <strong>embed options</strong></h3>
							<p>Displaying your booking form with WordPress's Gutenberg blocks provides a powerful visual embedding experience. Don't worry though, if you prefer shortcodes, we have those as well.</p>
						</div>
					</div>
				</div>

				<div class="get-started-feature">
					<div class="get-started-feature-inner clearfix">
						<div class="feature-icon">
							<picture>
								<source srcset="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-chat.png, <?php echo CBSB_BASE_URL; ?>public/images/icons/icon-chat@2x.png 2x">
								<img src="<?php echo CBSB_BASE_URL; ?>public/images/icons/icon-chat.png" alt="Services">
							</picture>
						</div>
						<div class="feature-copy">
							<h3><strong>Live chat</strong> support with <strong>real humans</strong></h3>
							<p>We understand that many people want the ability to chat with a real human to help them with their questions. We're here and available to help you in your journey.</p>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="container-holder" style="margin-top: 30px;">
			<div style="width:100%">
				<a style="margin:0 auto; display:block;width:300px;" class="button-override" href="#startbooking-logo"><?php _e( 'Get Started', 'calendar-booking' ); ?></a>
			</div>
		</div>

		<div class="container-holder" style="margin-top: 30px;">
			<a href="#">
				<img width="810" src="<?php echo CBSB_BASE_URL; ?>public/images/product-screenshot.png" alt="Start Booking Product">
			</a>
		</div>

		<div class="container-holder" style="margin-top: 30px;">
			<div style="width:100%">
				<p style="text-align:center;">Powered by <a style="color: #5b636a;" href="https://www.startbooking.com/" target="_blank" title="Start Booking">Start Booking</a> | <a style="color: #5b636a;" href="https://www.startbooking.com/support/" title="Start Booking Support" target="_blank">Get Help</p>
			</div>
		</div>

	</main>
	<!-- bottom panel -->
	<div class="bottom-panel">
		<div class="frame">
			<p>
				<?php _e( 'Already have an account with us?', 'calendar-booking' ); ?> <a href="#"><?php _e( 'Let\'s get your site connected', 'calendar-booking' ); ?></a>
			</p>
		</div>
		<!-- <form method="POST" id="navigate">
			<input type="hidden" name="page" value="connect" />
			<input type="hidden" name="action" value="cbsb_navigate" />
			<button type="submit" class="button button-gray"><?php _e( 'Connect Account', 'calendar-booking' ); ?></button>
		</form> -->
		<a href="<?php echo admin_url( 'admin.php?page=cbsb-connect' ); ?>" class="button-override button-gray"><?php _e( 'Connect Account', 'calendar-booking' ); ?></a>
	</div>
</div>
