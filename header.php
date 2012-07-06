<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="icon" href="<?php bloginfo('template_url'); ?>/_/img/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/_/img/favicon.ico" type="image/x-icon" />
    
<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>	

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/_/styles/layout.css" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php // comments_popup_script(); off by default //?>
	<?php wp_head(); ?>
	
</head>
<body>

<div id="fb-root"></div>

<div class="lightbox"></div>


<div class="background">
	<div class="bgWrap">
	
		<img class="bg-v-left" src="<?php bloginfo('template_url'); ?>/_/img/bg-v-left.png" alt="bg-v-left" width="158" height="1128" />
		
		<img class="bg-v-right" src="<?php bloginfo('template_url'); ?>/_/img/bg-v-right.png" alt="bg-v-right" width="158" height="1128" />
	
	</div>
</div><!-- /background -->


<!-- #begin container
================================================== -->
<div class="container">

<div class="header section">
	
	
	<!-- #MORE - need something?
	================================================== -->
	<div class="more section">
		<div class="moreWrap sixteen columns">
			
			<div class="desc">
				
				<h1>Need something now?</h1>
				<p class="subtitle">
					A limo? A house? <!-- A pool full of KY Jelly and two wrestling models?  --><br />
					Seriously, anything you need, we got you.
				</p>
				
				<p class="instruct">
					Fill out the form and your Personal VEGASiTES Concierge will get back to you within 30 minutes. 
				</p>
				
			</div><!-- /desc -->
			
			<form id="homeForm" class="form dark" action="<?php bloginfo('template_url'); ?>/_/services/process-home-form.php" method="POST">
				
				<input type="text" name="name" placeholder="Name" required="required" />
				<input type="email" name="email" placeholder="Email" required="required" />
				<input type="text" name="tel" placeholder="Cell Number" required="required" />
				<textarea name="message" placeholder="What can we do for you?" required="required"></textarea>
				
				<div class="loadForm">
					<input type="submit" class="submit" name="submit" value="Send" />
				</div>
				
				<span class="errorSuccess" style="display:none"></span>
				
			</form>
			
		</div><!-- / morewrap -->
	</div><!-- /more -->
	
	
	<div class="socialWrap sixteen columns">
		
		<div class="vWrap">
		
			<a href="javascript:;" class="iconV">
				<img src="<?php bloginfo('template_url'); ?>/_/img/icon-v.png" alt="icon-v" width="26" height="26" />
			</a>
			
			<span class="cta moreCta">
				<img src="<?php bloginfo('template_url'); ?>/_/img/cta-more.png" alt="cta-more" width="158" height="24" />
			</span>
		
		</div><!-- /vwrap -->
		
		<div class="social">
		
			<span class="cta socialCta">
				<img src="<?php bloginfo('template_url'); ?>/_/img/cta-social.png" alt="cta-social" width="149" height="21" />
			</span>
			
			<a class="iconFb" href="http://facebook.com/vegasites" target="_blank"></a>
			<a class="iconTwitter" href="http://twitter.com/vegasites" target="_blank"></a>
		
		</div><!-- /social -->
		
	</div><!-- /socialWrap -->
	
	
	<hr />
	
	
	<div class="logoConnect sixteen columns">
		
		<a class="logo" href="<?php bloginfo('url'); ?>/">
			<img src="<?php bloginfo('template_url'); ?>/_/img/logo.png" alt="logo" width="318" height="61" />
		</a>
		
		<div class="connectWrap">
			
			<!-- not connected -->
			<div class="notConnected">
				<div class="connectCta">
					<img src="<?php bloginfo('template_url'); ?>/_/img/cta-connect.png" alt="cta-connect" width="195" height="39" />
				</div>
				
				<!-- #FB LOGIN 
				================================================== -->
				<!--  <div class="fb-login-button" scope="email,user_birthday,user_website,user_checkins,user_events,user_photos,user_status,friends_photos,publish_stream,status_update,photo_upload,share_item,publish_checkins">Connect with Facebook</div>  -->
			
				<a id="fbConnect" href="javascript:;"><img src="<?php bloginfo('template_url'); ?>/_/img/fbconnect.png" alt="fbconnect" width="169" height="23" /></a>
			
			</div><!-- /not connected -->
			
			<div class="connected" style="display:none;">
				
				<div class="fbPic"></div>
				<div class="fbName"></div>
				<div class="fbNav">
					<a href="#" style="border:none!important;">View Profile</a>
					<a href="#">Edit Profile</a>
					<a class="fbLogout" href="javascript:;">Logout</a>
				</div><!-- /fbNav -->
				
			</div><!-- /connected -->
			
		</div><!-- /connectWrap -->
		
	</div><!-- /logoConnect -->
	
	<!-- #navigation
	================================================== -->
	<div class="navigation sixteen columns">
	
		<ul class="section navWrap">
			
			<li class="outside" style="border-left: 0;">
				<a class="primary" href="javascript:;">PEOPLE</a>
				<ul class="subnav">
					<li><a href="<?php bloginfo('url'); ?>/positions/hosts/">HOSTS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/models/">MODELS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/djs/">DJS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/poker-players/">POKER PLAYERS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/bartenders/">BARTENDERS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/bottle-poppers/">BOTTLE POPPERS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/influential/">INFLUENTIAL</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/ladies-in-charge/">LADIES IN CHARGE</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/chefs/">CHEFS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/positions/talent/">TALENT</a></li>
				</ul>
			</li>
			
			<li class="outside">
				<a class="primary" href="javascript:;">PLACES</a>
				<ul class="subnav">
					<li><a href="<?php bloginfo('url'); ?>/dining/">DINING</a></li>
					<li><a href="<?php bloginfo('url'); ?>/place-types/hotels/">HOTELS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/place-types/nightclubs/">NIGHTCLUBS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/place-types/dayclubs/">DAYCLUBS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/place-types/lounges/">LOUNGES</a></li>
					<li><a href="<?php bloginfo('url'); ?>/place-types/bars/">BARS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/place-types/spas/">SPAS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/place-types/stripclubs/">STRIPCLUBS</a></li>
					<li><a href="<?php bloginfo('url'); ?>/attractions/">ATTRACTIONS</a></li>
				</ul>
			</li>
			
			<li class="outside">
				<a class="primary" href="javascript:;">RIGHT NOW</a>
				<ul class="subnav">
					<li><a href="#">TODAY</a></li>
					<li><a href="#">TOMORROW</a></li>
					<li><a href="#">VIEW ALL</a></li>
				</ul>
			</li>
			
			<li class="outside">
				<a class="primary" href="javascript:;">STORE</a>
				<ul class="subnav">
					<li><a href="#">VIEW ALL</a></li>
					<li><a href="#">VILLAS</a></li>
					<li><a href="#">APPAREL</a></li>
					<li><a href="#">BPONG</a></li>
				</ul>
			</li>
			
			<li class="outside" style="border-right: 0;">
				<a class="primary" href="javascript:;">BLOG</a>
				<ul class="subnav">
					<li><a href="#">FEATURED</a></li>
					<li><a href="#">NIGHTLIFE</a></li>
					<li><a href="#">DINING</a></li>
					<li><a href="#">CONTRIBUTORS</a></li>
					<li><a href="#">ARCHIVE</a></li>
				</ul>
			</li>
			
		</ul> <!-- /navwrap -->
	
	</div><!-- /navigation -->

</div><!-- /header -->




<div id="page-content" class="section">