<div class="body-decor">
	<img src="<?php echo CBSB_BASE_URL . 'public/images/body-decor.png'; ?>">
</div>

	<!-- main container of all the page elements -->
<div id="wrapper">
	<!-- contain main informative part of the site -->
	<main id="main">
		<div style="height:56px;display:block;" class="clearfix">
			<form method="POST" id="set_plan" class="pull-right">
				<input id="plan_selected" type="hidden" name="plan" value="" />
				<input id="term_selected" type="hidden" name="term" value="month" />
				<input id="onboard_id" type="hidden" name="onboard_id" value="<?php echo get_option( 'cbsb_onboard' ); ?>" />
				<button style="display:none!important;" type="submit" class="button-override button-continue"><?php _e( 'Continue', 'calendar-booking' ); ?> &rarr;</button>
			</form>
		</div>
		<div class="head-block">
			<div class="top-block">
				<!-- page logo -->
				<div class="startbooking-logo">
					<a href="#">
						<img src="<?php echo CBSB_BASE_URL . 'public/images/startbooking-logo.svg'; ?>" alt="Start Booking">
					</a>
				</div>
				<h1><?php _e( 'Select the plan that fits your needs', 'calendar-booking' ); ?></h1>
				<p><?php _e( 'Finally Easy Booking Without the High Costs', 'calendar-booking' ); ?></p>
			</div>
		</div>
		<!-- tabs switcher -->
		<div class="tabset-holder">
			<ul class="tabset">
				<li style="margin-bottom:0px;">
					<a id="month" href="#"><?php _e( 'Monthly', 'calendar-booking' ); ?></a>
				</li>
				<li style="margin-bottom:0px;">
					<a id="annual" href="#"><?php _e( 'Annually', 'calendar-booking' ); ?></a>
				</li>
			</ul>
		</div>
		<!-- tabs content holder -->
		<div class="tab-content">

				<!-- plan list -->
			<div class="plan-list">
				<div class="plan plan-free">
					<div class="frame">
						<div class="head">
							<h2><?php _e( 'Free', 'calendar-booking' ); ?></h2>
							<strong class="sub-head">$<span id="price_free">0</span></strong>
						</div>
						<ul>
						</ul>
						<a id="free" href="#" style="width:100%;display:block;" class="button-override select-plan"><?php _e( 'Select this plan', 'calendar-booking' ); ?></a>
					</div>
				</div>
				<div class="plan plan-individual">
					<div class="frame">
						<div class="head">
							<h2><?php _e( 'Individual', 'calendar-booking' ); ?></h2>
							<strong class="sub-head"><span id="price_individual">15</span><span id="price_term">/<?php _e( 'month', 'calendar-booking' ); ?></span></strong>
						</div>
						<ul>
						</ul>
						<a id="individual" href="#" style="width:100%;display:block;" class="button-override select-plan"><?php _e( 'Select this plan', 'calendar-booking' ); ?></a>
					</div>
				</div>
				<div class="plan plan-business">
					<div class="frame">
						<div class="head">
							<h2><?php _e( 'Business', 'calendar-booking' ); ?></h2>
							<strong class="sub-head"><span id="price_business">35</span><span id="price_term">/<?php _e( 'month', 'calendar-booking' ); ?></span></strong>
						</div>
						<ul>
						</ul>
						<a id="business" href="#" style="width:100%;display:block;" class="button-override select-plan"><?php _e( 'Select this plan', 'calendar-booking' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</main>

</div>
