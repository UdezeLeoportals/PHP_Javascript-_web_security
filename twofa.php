<?php require_once("./includes/initialize.php"); 
require_once "./Mailing/Mail.php";
?>
<html>
<head>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/chat_design.css" type="text/css" /> 
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
<link rel="stylesheet" href="styles/update_styles.css" type="text/css" /> 

<script type="text/javascript" src="scripts/validates.js"></script>
<style>
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
     body,html {
    width: 100vw;
    height: 100vh;
}
</style>
</head>
<body style="height: 100%; width: 100%; overflow: scroll;  width: 100%;
          height: 100%;
          overflow: auto;
           background: lightblue url(images/uweLogo4.jpg);
            background-size: cover;
          clear: both;">
    </body>
    
    <?php
    $submit_message ="";
        if(isset($_POST['submit'])){
            $user = User::find_otpid(htmlspecialchars($_POST['id']));
            $pins = Mailpin::find_pin($user->username, $_POST['otp']);
            if(!empty($pins)){
        foreach($pins as $p){
            $newr = new Mailpin();
            $newr->id = $p->id;
            $newr->used = 1;
            $newr->email = $p->email;
            $newr->pin = $p->pin;
        if($newr->update())
           $found_user = User::find_email($user->username);
         $session->login($found_user);
			$session->instantiate();
			 $latest = Failed_log::find_last();
            $lid=0;
            foreach($latest as $l){
                $lid = $l->id;
            }
            	
            $lid++;
    		$fail = new Failed_log();
    		$fail->id = $lid;
    		$fail->username = $user->username;
    		$fail->attempt = 3; //successful login
    		$fail->timestamp = date(DateTime::RFC1123, gettime());
    		$fail->createv();
		
			header("Location: http://www.adonaibaibul.com/index.php");
			log_action("Log in", $messg);
		die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/index.php';
</script>");
        }
    }else $submit_message =  'Could not find this Pin';
            
        }
    ?>
<div class="card">
  <img src="/images/leologo.jpg" alt="Leoportals" style="width:50%">
  <div class="container">
    <h1>Leoportals Network</h1>
    <p class="title">EMAIL TWO-FACTOR AUTHENTICATION</p>
   
    <?php if(!empty($submit_message)) echo '<h2>'.$submit_message.'</h2>'; ?>
     <div style="margin: 24px 0;" id="maildiv">
    <form action="twofa.php" method="post" id="form" enctype="multipart/form-data" >
   <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['a']); ?>" />
        <label>One-time password:</label>
        <input type="text"  name="otp" id="otp" placeholder="Enter the OTP that was sent to your mailbox" required/>
  
   <p>
       <input class="button" type="submit" value="Submit" name="submit"><br>
        <center><div id="preview"></div></center>
        <center><span id="succeed" style="color: blue"></span></center></p>
    </form> </div></div></div>
    </html>