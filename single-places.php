<?php get_header(); ?>

<div class="sixteen columns pagetitle">
	
	<h2>- <?php the_title(); ?> -</h2>

<hr />
</div>


<div class="single page places eleven columns">
	
	<?php rewind_posts(); ?>
	<?php if(have_posts()) : ?> <?php while(have_posts()) : the_post(); ?>
	<?php $mainPic = get_post_meta($post->ID, 'wpcf-photos', true); ?>
	<?php $allPics = get_post_meta($post->ID, 'wpcf-photos', false); ?>
	<?php $aboutPlace = get_post_meta($post->ID, 'wpcf-place_about', true); ?>
	
	<div class="section top">
		<a class="mainPic" rel="lightbox" href="<?php echo $mainPic; ?>" style="background-image: url('<?php echo $mainPic; ?>');"></a>
	
		<div class="infoWrap">
			<a class="facebook" href="#">&rarr; Facebook</a>
			<a class="twitter" href="#">&rarr; Twitter</a>
			<a class="website" href="#">&rarr; Website</a>
			<a class="map" href="#">&rarr; View on Map</a>
			<a class="contact" href="#">&rarr; Contact</a>
		</div><!-- /info wrap -->
		
	</div><!-- /top section -->
	
	<div class="section about">
		<?php echo $aboutPlace; ?>
	</div><!-- /about -->
	
	<hr />
	
	<?php include (TEMPLATEPATH . '/social-buttons.php'); ?>
	
	<?php endwhile; ?> <?php else : ?> <?php endif; ?>
	
</div><!-- /single places page -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>