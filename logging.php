<?php

require_once("./includes/initialize.php");


if (!($session->is_logged_in() && $session->type=="admin")) {
    
header("Location: http://www.adonaibaibul.com/index.php", true, 301);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd" >


<?php
	
 echo add_header($session->username, $session->type);
 ?>

<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
 <link rel="stylesheet" href="styles/chat_design.css" type="text/css" /> 
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    th{
        color: black;
    }
</style>
<center>
    <h2>AUTHENTICATION LOGS</h2>
    <table style="height: 100%; width: 75%; opacity: 0.8; font-size: 16px;" >
    <tr class="stripeEven"><th>S. NO.</th><th>USERNAME</th></th><th>LOG TYPE</th><th>SUCCESS STATUS</th><th>DATE & TIME</th></tr>
    <?php
        
        $all_users = Failed_log::find_all(); $n=1;
        foreach($all_users as $auser){
            $stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
            echo '<tr class="'.$stripe.'" style="font-size: 16px;">';
            echo '<td>'.$n++.'</td>';
            echo '<td><b>'.$auser->username.'</b></td>';
            echo '<td><b>';
            if($auser->attempt==4) echo 'LOGOUT';
            else if($auser->attempt==1|| $auser->attempt==3) echo 'LOGIN';
            echo '</b></td>';
            echo '<td><b>';
            if($auser->attempt==4 || $auser->attempt==3) echo 'SUCCESSFUL';
            else if($auser->attempt==1) echo 'FAILED';
            echo '</b></td><td><b>'.$auser->timestamp.'</b>';
            echo '</td></tr>';
        }
    ?>
</table>

    </center>
<?php echo footer(); ?>