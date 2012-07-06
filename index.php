<?php get_header(); ?>

<!-- #begin home page
================================================== -->
<div class="section home">

<!-- #slider wrap
================================================== -->
		<div class="sixteen columns sliderWrap swipe" id="slider">
		
			<ul style="float:left; width:100%; height:100%; position: relative; margin: 0; padding: 0;">

			<?php rewind_posts(); ?>
			<?php if(have_posts()) : ?> 
				<?php query_posts('post_type=featured&showposts=9&orderby=rand'); ?>
			<?php while(have_posts()) : the_post(); ?>
			
			<?php  $imgorvid = get_post_meta($post->ID, 'wpcf-image_or_video', true); ?>
			<?php  $featImg = get_post_meta($post->ID, 'wpcf-feat_img', true); ?>
			<?php  $featVid = get_post_meta($post->ID, 'wpcf-vid_embed', true); ?>
			<?php  $imgLink = get_post_meta($post->ID, 'wpcf-img_link', true); ?>
			
				<li class="slideLi" style="display: none; background-image:url('<?php echo $featImg; ?>'); background-size:cover; background-position: top center; float:left; width:100%; height:100%; position: relative; margin: 0; padding: 0;">
					
					<?php if ($imgorvid == "2") : ?>
						<?php echo $featVid; ?>	
					<?php endif; ?>
					
					<?php if ($imgorvid == "1") : ?>
						<a class="featuredLink" href="<?php echo $imgLink; ?>" target="_self" style="float:left; height:100%; width:100%;"></a>
					<?php endif; ?>
					
				</li><!-- /featured1 -->
			
			<?php endwhile; ?> <?php else : ?> <?php endif; ?>
			
			</ul>
								
		</div><!-- / sliderwrap -->
	
		<div class="sliderNav sixteen columns">
		    <a class="prev" href="javascript:;"><img src="<?php bloginfo('template_url'); ?>/_/img/arrow-left.png" alt="arrow-left" width="40" height="14" /></a>

		    	<a class="navDot selected 0" id="0" href="javascript:;"></a>
		    	<a class="navDot 1" id="1" href="javascript:;"></a>
		    	<a class="navDot 2" id="2" href="javascript:;"></a>
		    	<a class="navDot 3" id="3" href="javascript:;"></a>
		    	<a class="navDot 4" id="4" href="javascript:;"></a>
		    	<a class="navDot 5" id="5" href="javascript:;"></a>
		    	<a class="navDot 6" id="6" href="javascript:;"></a>
		    	<a class="navDot 7" id="7" href="javascript:;"></a>
		    	<a class="navDot 8" id="8" href="javascript:;"></a>

		    <a class="next" href="javascript:;"><img src="<?php bloginfo('template_url'); ?>/_/img/arrow-right.png" alt="arrow-right" width="39" height="14" /></a>
		</div><!-- /sliderNav -->

<hr />
	
<!-- #Home grid
================================================== -->
<div class="sixteen columns gridWrap">

	<a class="one-third column grid alpha">
		<img src="<?php bloginfo('template_url'); ?>/_/img/home-nightclubs.jpg" alt="nightclubs" width="300" height="200" />
	</a>
	
	<a class="one-third column grid">
		<img src="<?php bloginfo('template_url'); ?>/_/img/home-dining.jpg" alt="dining" width="300" height="200" />
	</a>
	
	<a class="one-third column grid omega">
		<img src="<?php bloginfo('template_url'); ?>/_/img/home-hotels.jpg" alt="hotels" width="300" height="200" />
	</a>
	
	<a class="one-third column grid alpha">
		<img src="<?php bloginfo('template_url'); ?>/_/img/home-hosts.jpg" alt="las vegas hosts" width="300" height="200" />
	</a>
	
	<a class="one-third column grid">
		<img src="<?php bloginfo('template_url'); ?>/_/img/home-dayclubs.jpg" alt="dayclubs" width="300" height="200" />
	</a>
	
	<a class="one-third column grid omega">
		<img src="<?php bloginfo('template_url'); ?>/_/img/home-rightnow.jpg" alt="what to do in vegas" width="300" height="200" />
	</a>

</div><!-- /grid wrap -->


<hr />
	
<!-- #Twitter
================================================== -->	
<div class="sixteen columns twitterWrap">

	<div class="tweetCircle two columns alpha">
		<img src="<?php bloginfo('template_url'); ?>/_/img/tweet-circle.png" alt="tweet-circle" width="90" height="87" />
	</div>
	
	<a class="followUs" href="http://twitter.com/vegasites" target="_blank">
		<img src="<?php bloginfo('template_url'); ?>/_/img/follow-us.png" alt="follow-us" width="29" height="209" />
	</a>
	
	<!-- #vegasites tweets
	================================================== -->
	<div class="vegasitesTweets five columns">
		<h2>What we are tweeting:</h2>
		<div class="vdivider"></div>
		
		<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'profile',
			  rpp: 4,
			  interval: 10000,
			  width: 260,
			  height: 176,
			  theme: {
			    shell: {
			      background: '#ffffff',
			      color: '#351330'
			    },
			    tweets: {
			      background: '#ffffff',
			      color: '#444444',
			      links: '#342634'
			    }
			  },
			  features: {
			    scrollbar: false,
			    loop: false,
			    live: false,
			    hashtags: true,
			    timestamp: true,
			    avatars: false,
			    behavior: 'all'
			  }
			}).render().setUser('vegasites').start();
			</script>
			
	</div><!-- /vegasitesTweets -->
	
	
	<!-- #people tweets
	================================================== -->
	<div class="peopleTweets four columns">
		<h2>What the People are tweeting:</h2>
		<div class="vdivider"></div>
		
		<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'list',
			  rpp: 30,
			  interval: 10000,
			  title: 'People',
			  subject: '',
			  width: 260,
			  height: 260,
			  theme: {
			    shell: {
			      background: '#ffffff',
			      color: '#444444'
			    },
			    tweets: {
			      background: '#ffffff',
			      color: '#444444',
			      links: '#342634'
			    }
			  },
			  features: {
			    scrollbar: false,
			    loop: true,
			    live: true,
			    hashtags: true,
			    timestamp: true,
			    avatars: true,
			    behavior: 'default'
			  }
			}).render().setList('VEGASiTES', 'people-3').start();
			</script>
			
	</div><!-- /peopleTweets -->
	
	
	<!-- #places tweets
	================================================== -->
	<div class="placesTweets four columns omega">
		<h2>What the Places are tweeting:</h2>

		<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'list',
			  rpp: 30,
			  interval: 10000,
			  title: 'Places',
			  subject: '',
			  width: 260,
			  height: 260,
			  theme: {
			    shell: {
			      background: '#ffffff',
			      color: '#444444'
			    },
			    tweets: {
			      background: '#ffffff',
			      color: '#444444',
			      links: '#342634'
			    }
			  },
			  features: {
			    scrollbar: false,
			    loop: true,
			    live: true,
			    hashtags: true,
			    timestamp: true,
			    avatars: true,
			    behavior: 'default'
			  }
			}).render().setList('VEGASiTES', 'places-3').start();
			</script>
			
	</div><!-- /placesTweets -->

</div><!-- /twitterWrap -->


	
</div><!-- /home -->

<?php get_footer(); ?>