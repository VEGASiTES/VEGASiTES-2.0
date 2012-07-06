<?php 
  // Include WordPress
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
require('functions.php'); //this file will grab the required wp-load stuff

  //$myID = $_GET['myId'];
  //query_posts('showposts=1&cat=12&p=' . $myID );

$UID = isset($_GET['UID'])?$_GET['UID']:'';
$fbtoken = isset($_GET['token'])?$_GET['token']:'';
$found=false;

$authenticated=FB_check_token($UID,$fbtoken);

if ($authenticated):
	$args = array( 
			 'meta_key'=>'wpcf-uid',
			 'meta_value'=>$UID
		);

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$found=true;
		endwhile;
	else :
		$found=false;
	endif;

	// Reset Post Data
	wp_reset_postdata();
endif;

//JSON is the best way to send stuff back because it's easier to add more fields and we don't have to worry about white-spaces or anything
$results=array('userfound'=>$found,'authenticated'=>$authenticated);
echo json_encode($results);