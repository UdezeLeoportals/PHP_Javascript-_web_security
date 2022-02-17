<?php require_once("./includes/initialize.php"); ?>
<?php //if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
//echo add_header($session->username, $session->type);
?>
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<style type="text/css">
	.bold{
		margin: 30px auto;
		border-collapse: collapse;
		border:#400000 5px solid;
		height:   40px;
	}
	.high{
        height: 10em;
	 }
	.low{
        height: 30em;
	}
	.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 600px;
  margin: auto;
  text-align: center;
  font-family: arial;
  background-color: white;
}
body{
    background-color: #6def8e
}
.container {
  padding: 0 16px;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
</style>
<?php

$date=date(DateTime::RFC1123, time());
$bulk = 1;
//if(isset($_POST['send'])){
   
   // }
  
   // if(isset($_POST['send'])){
        $snt = "Leoportals Network";
        $from = "udezechinedu@leoportals.com";
	    $to = "udezeleonard@gmail.com";
	   // if($sms_id==1 || $sms_id==2) $phone = $staf->phone_no;
	    if(!empty($to)){
	    $headers  = 'MIME-Version: 1.0' . "\r\n";
	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
	    //$headers .= 'To: '.$name.'<'.$to.'>' . "\r\n";
            $headers .= 'From: '.$snt.'<'.$from.'>' . "\r\n";
	   // $headers .= 'Cc: dezleon20@gmail.com' . "\r\n";
           // $headers .= 'Bcc: dezleon20@gmail.com' . "\r\n";
	 
	    $subject = "test mail";
	    
	     //$subject = $_POST['subject_field'];
	    
	    //$message = "<html>";
	   // $message .= "<head><title>A GOD SENT TIMELY MESSAGE<title/></head>";
	   // $message .= "<body>";
	    $message .= "<center><p><img border='0' src='http://leoportals.com/images/leologo.jpg'></p>";
        $message .= "<p>Please use these details to log in; you can change the password after the first use.</p>";
        $message .= "<p>USERNAME: ".$to."</p>";
        $message .= "<p>PASSWORD: 1</p>";
        $message .= "<br><p>Thank you for using this network.</p>";
        $message .= "<br><br>Courtesy: Leoportals Suport Team.</center>";
	    //$message .= "</html>";
	    
	    $result = mail($to, $subject, $message, $headers);
	    echo $result ? 'sent' : 'error';
	    }
	   
       
   // }

?>
<h2 style="text-align:center">Password Retrieval</h2>

<div class="card">
  <img src="/images/leologo.jpg" alt="Leoportals" style="width:50%">
  <div class="container">
    <h1>Leoportals Network</h1>
    <p class="title">Please note that we will have to reset your password</p>
    <p>You will get a mail with a temporary password. You can change it as you log in.</p>
    <form action="passwdmail.php" method="post">
    <div style="margin: 24px 0;">
        <label>Username( Email ):</label>
        <input type="text" name="email" placeholder="Enter the email you use as a username" />
   </div>
   <p><button type="submit" name="resett">SUBMIT</button></p>
    </form>
  </div>
</div>

<?php //echo footer(); ?>