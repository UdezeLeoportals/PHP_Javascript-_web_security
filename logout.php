<?php require_once("./includes/initialize.php"); ?>
<?php
    $messg="";
	$latest = Failed_log::find_last();
            $lid=0;
            foreach($latest as $l){
                $lid = $l->id;
            }
            	
            $lid++;
    		$fail = new Failed_log();
    		$fail->id = $lid;
    		$fail->username = $session->username;
    		$fail->attempt = 4; //logout
    		$fail->timestamp = date(DateTime::RFC1123, gettime());
    		$fail->createv();
	log_action("Log out", $messg);
    $session->logout();
    die("<script type='text/javascript'>
window.location.href = 'http://www.adonaibaibul.com/login.php';
</script>");
?>
