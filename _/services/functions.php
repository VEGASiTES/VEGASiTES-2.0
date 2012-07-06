<?php
require dirname(__FILE__).'/fb_sdk/facebook.php';
define('WP_USE_THEMES', false);
require_once('/home/90965/domains/preview.vegasites.com/html/wp-load.php');

$appId="186397981389259";
$secret="";
$FB_like_check_gap=15;//minimum time (in secs) between asking facebook how many likes a post has

/* check a users facebook token to make sure they aren't lying */
function FB_check_token($uid,$token){
	global $appId,$secret;
	return true; //get rid of this line once we have the secret
	$facebook = new Facebook(array(
	  'appId'  => $appId,
	  'secret' => $secret,
	));
    
	// See if there is a user from a cookie
	$user = $facebook->getUser();
	if (!$user) return false;
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		var_dump($e);
		return false;
	}
	return $user_profile;
}








if (isset($_GET['fbupdate']) && $_GET['fbupdate']=='true'){
	header("Content-Type: text/plain");
	facebook_fullrefresh();
}

//Fork a facebook like check into the background
function backgroundLikePoll(){
	$last=get_option('KTBCUSTOM_facebookUpdate_timestamp',0);
	if (time()-$last<20){
		return;
	}
	delete_option('KTBCUSTOM_facebookUpdate_timestamp');
	add_option('KTBCUSTOM_facebookUpdate_timestamp',time(),'','no');
	$url=get_bloginfo('template_url')."/_/services/functions.php?fbupdate=true";
	forkHTTP($url);
	return;
}

//Initiate a php script on the server and disconnect
function forkHTTP($url) 
{
	$parts=parse_url($url);
	$script=$parts['path'];
	if ($parts['query']!=""){
		$script.="?".$parts['query'];
	}
	$webport=$parts['port'];
	if ($webport==""){$webport=80;}
	$host = $parts['host'];
	$conn = @fsockopen($host, $webport);
	if ($conn) {
		$cmd = "GET $script HTTP/1.1\r\n";
		$cmd .= "Host: $host\r\n\r\n";
		@fwrite($conn, $cmd);
		while (!feof($conn)) {
			$var=fgets($conn, 128);
		}
		@fclose($conn);
		return true;
	}
	return false;
}

function facebook_fullrefresh(){
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	$page=1;
	while ($count=fetch_batch_likes($page)){
		echo "likes complete for $count posts in page $page";
		$page++;
	}
}
function fetch_batch_likes($page=1){
	global $FB_like_check_gap;
	$postIDs=Array();
	$args = array (
			"post_status" => "publish",
			"post_type" => "any",
			 'orderby' => 'title', 
			 'order' => 'DESC',
			 'showposts' => 100,
			 'paged'=>$page
			);
	$query = new WP_Query( $args );
	$fbqueries=Array();
	
	$message="";
	if (count($query->posts)==0) return false;
	foreach ($query->posts as $post){
		$ptitle=$post->post_title;
		$post_id=$post->ID;
				
		if (trim(get_post_meta($post->ID,'ninetyday_likes',true))==""){
			delete_post_meta($post_id,'ninetyday_likes');
			add_post_meta($post_id,'ninetyday_likes',0, true) or 
			update_post_meta($post->ID,'ninetyday_likes',0);
		}
		if (trim(get_post_meta($post->ID,'facebook_likes',true))==""){
			delete_post_meta($post_id,'facebook_likes');
			add_post_meta($post_id,'facebook_likes',0,true) or 
			update_post_meta($post->ID,'facebook_likes',0);
			$message.="found new post $ptitle ($post_id) likes set to ".get_post_meta($post->ID,'facebook_likes',true)."\n";
		}
		
		
		if ((time()-getLocalLikeTime($post->ID))<$FB_like_check_gap && !isset($_GET['fullrefresh'])){
			$checktime=date('h:i:s',getLocalLikeTime($post->ID));
			$currenttime=date('h:i:s');
			$difference=time()-getLocalLikeTime($post->ID);
			$currentlikes=get_post_meta($post->ID,'facebook_likes',true);
			print("Post has been checked within last $FB_like_check_gap seconds (difference of $difference secs). Checked @ $checktime, current time is $currenttime. Skipping. Current likes: $currentlikes>\n\n");
		} else {
			$post_url=get_permalink($post->ID);
			print("Queuing Query for $ptitle ($post_id) $post_url\n");
			if ($post_url!==""){
				$QUERY='SELECT like_count, total_count, share_count, click_count from link_stat where url="'.$post_url.'"';
				$urlQUERY=$QUERY;
				$fbqueries[$post_id]=$urlQUERY;
			}
			
		}
	}

	print("\n\n+++++++++++++++++++RUNNING BATCH OF QUERIES+++++++++++++++++\n");
	$jsonqueries=urlencode(json_encode($fbqueries));
	$url="https://api.facebook.com/method/fql.multiquery?format=JSON&queries=$jsonqueries";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	$data=curl_exec($ch);
	$results=json_decode($data,true);
	foreach ($results as $queryresult){
		if (isset($queryresult['name'])&&isset($queryresult['fql_result_set'])&&isset($queryresult['fql_result_set'][0]['total_count'])){
			if ($queryresult['fql_result_set'][0]['like_count']==0){
				$likes=$queryresult['fql_result_set'][0]['like_count'];
			} else {
				$likes=$queryresult['fql_result_set'][0]['total_count'];
			}
			$pid=$queryresult['name'];
			$title=get_the_title(addslashes($pid));
			$url=$fbqueries[$pid];
			print("received $likes likes for post $pid ($title)\n");
			//print_r($queryresult);print("\n\n");
			if ($likes>-1){
				if (get_post_meta($pid,'facebook_likes',true)!==$likes){
					$change=$likes-get_post_meta($pid,'facebook_likes',true);
					$message.="received $likes likes for post $pid ($title) a $change change\n";
					setPostLikes($pid,$likes);
				}
			} else {
				//die('badfbookresponse');
			}
		} else {
			print("failure\n");//print_r($queryresult);
		}
	}
    print($message);
	$subject="Background Like Poll: ".date('r');
	if (trim($message)!=""){
		debugtokevin($message,$subject);
	}
	return count($query->posts);
}
/* returns last facebook like check timestamp for a post */
function getLocalLikeTime($post_id){
	$timestamp=get_post_meta($post_id,'facebook_likes_update_time',true);
	if (trim($timestamp)==""){$timestamp=0;}
	return $timestamp;
}

/* set the like count for a post */
function setPostLikes($post_id,$likes){
	$post_id=(int)$post_id;
	$likes=(int)$likes;
	$timestamp=time();
	delete_post_meta($post_id,'facebook_likes');
	delete_post_meta($post_id,'facebook_likes_update_time');
	add_post_meta($post_id,'facebook_likes',$likes,true) || update_post_meta($post_id,'facebook_likes',$likes);
	add_post_meta($post_id,'facebook_likes_update_time',$timestamp,true) || update_post_meta($post_id,'facebook_likes_update_time',$timestamp);
	//echo "likes for $post_id set to ".get_post_meta($post_id,'facebook_likes',true)."\n";
}

function debugtokevin($message,$subject="Vegasites Debug "){
	$to="vegasitesmessages@inlinecore.com";
	mail($to, $subject, $message);
}