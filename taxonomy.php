<?php get_header(); ?>

<?php //include (TEMPLATEPATH . '/ad-top.php'); ?>

<?php
$term =	$wp_query->queried_object;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$queryargs=array("meta_key"=>"facebook_likes","orderby"=>"meta_value_num",
				"order"=>"DESC","paged"=>"$paged",
				'tax_query' => array(
										array(
											'taxonomy' => $term->taxonomy,
											'field' => 'id',
											'terms' => $term->term_id
										)
									)
			);
?>

<div class="sixteen columns pagetitle">
	
	<h2>- <?php echo $term->name; ?> -</h2>

<hr />
</div>

<ol class="eleven columns catList">

<?php rewind_posts(); ?>
<?php if(have_posts()) : ?>
<?php query_posts($queryargs);?>
<?php while(have_posts()) : the_post(); ?>
<?php $pic = get_post_meta($post->ID, 'wpcf-photos', true); ?>
<?php $fblikes = get_post_meta($post->ID, 'facebook_likes', true);?>

	<li class="section">
		<a class="section" href="<?php the_permalink(); ?>">
			<div class="pic" style="background-image: url('<?php echo $pic; ?>');"></div>
			
			<div class="infoWrap">
				<h3><?php the_title(); ?></h3>
				<p>desc, fb likes=<?=$fblikes?></p>
				<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false" data-font="verdana"></div>
			</div><!-- /infowrap -->
			
			<img class="peopleCta" src="<?php bloginfo('template_url'); ?>/_/img/places-cta.png" alt="places-cta" width="105" height="54" />
		</a>
	</li>

<?php endwhile; ?> <?php else : ?> <?php endif; ?>

</ol> <!-- /catList -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>