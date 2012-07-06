<div class="socialButtons section">

<!-- #twitter
================================================== -->
<span class="twitterSocial">
<a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="VEGASiTES">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</span>

<!-- #google
================================================== -->
<span class="googleSocial">
<!-- Place this tag where you want the +1 button to render -->
<g:plusone size="tall"></g:plusone>

<!--  Place this tag after the last plusone tag -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</span>

<!-- #facebook
================================================== -->
<span class="fbSocial">
<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="verdana"></div>
</span>

<!-- #pinterest
================================================== -->
<span class="pinSocial">
	<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $the_photo ?>&description=<?php wp_title(); ?>%20on%20VEGASiTES.%20<?php echo wp_get_shortlink(); ?>" class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
</span>

<span class="linkedSocial">
<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-url="<?php the_permalink(); ?>" data-counter="top"></script>
</span>

</div><!-- /social buttons -->