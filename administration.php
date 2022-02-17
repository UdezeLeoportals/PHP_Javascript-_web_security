<?php

require_once("./includes/initialize.php");

//PHP code used to verify the access level of user accessing an admin page
//If the user is not an admin, s/he is redirected to the index page
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
    <h2>REGISTERED USERS</h2>
    <table style="height: 100%; width: 75%; opacity: 0.8; font-size: 16px;" >
    <tr><th>S. NO.</th><th>NAME</th><th>PHONE NUMBER</th><th>EMAIL ADDRESS</th></tr>
    <?php
        
        $all_users = Biodata::find_all(); $n=1;
        foreach($all_users as $auser){
            $stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
            echo '<tr class="'.$stripe.'" style="font-size: 16px;">';
            echo '<td>'.$n++.'</td>';
            echo '<td><b>'.$auser->surname.' '.$auser->first_name.'</b></td>';
            echo '<td><b>'.$auser->phone_no.'</b></td>';
            echo '<td><b>'.$auser->email.'</b></td></tr>';
        }
    ?>
</table>

<h2>ALL POSTS</h2>
<H3>SCHOLARSHIP POSTS</H3>
 <table style="height: 100%; width: 75%; opacity: 0.8; font-size: 16px;" >
    <tr><th>S. NO.</th><th>TOPIC</th><th>DATE TIME</th></tr>
    <?php
    $scholars = Scholars::find_public(); $n=1;
    foreach($scholars as $scholar){
        $stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
         echo '<tr class="'.$stripe.'" style="font-size: 16px;">';
            echo '<td>'.$n++.'</td>';
            echo '<td><b>'.$scholar->topic.'</b></td>';
            echo '<td><b>'.$scholar->datetime.'</b></td></tr>';
    }
    ?>
    </table>
    
<H3>CATHOLIC MASS READINGS</H3>
 <table style="height: 100%; width: 75%; opacity: 0.8; font-size: 16px;" >
    <tr><th>S. NO.</th><th>TOPIC</th><th>DATE TIME</th></tr>
    <?php
    $scholars = Jobs::find_public(); $n=1;
    foreach($scholars as $scholar){
        $stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
         echo '<tr class="'.$stripe.'" style="font-size: 16px;">';
            echo '<td>'.$n++.'</td>';
            echo '<td><b>'.$scholar->topic.'</b></td>';
            echo '<td><b>'.$scholar->datetime.'</b></td></tr>';
    }
    ?>
    </table>


<H3>DEVOTIONAL POSTS</H3>
 <table style="height: 100%; width: 75%; opacity: 0.8; font-size: 16px;" >
    <tr><th>S. NO.</th><th>TOPIC</th><th>DATE TIME</th></tr>
    <?php
    $scholars = Devotionals::find_public(); $n=1;
    foreach($scholars as $scholar){
        $stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
         echo '<tr class="'.$stripe.'" style="font-size: 16px;">';
            echo '<td>'.$n++.'</td>';
            echo '<td><b>'.$scholar->topic.'</b></td>';
            echo '<td><b>'.$scholar->datetime.'</b></td></tr>';
    }
    ?>
    </table>
    </center>
<?php echo footer(); ?>