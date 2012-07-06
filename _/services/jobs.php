<?php
/* this file needs to be here until we get a cron job to automate like checking. a recent update seems to have screwed up forking http connections */


require('functions.php');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

backgroundLikePoll();
echo json_encode(array("status"=>"done"));