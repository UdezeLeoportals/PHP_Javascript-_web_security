<?php
	require_once("./includes/initialize.php");
	//echo add_header($session->username, $session->type);
	 /* 	
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\' https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js \'unsafe-inline\'; style-src \'self\' https://www.w3schools.com/w3css/4/w3.css https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css \'unsafe-inline\' ;connect-src \'self\'; img-src \'self\' \'unsafe-inline\' data:;  font-src \'self\' ; frame-src \'self\' ; frame-ancestors \'self\'; report-uri /csp_report.php');
header("Expect-CT: enforce; max-age=30; report-uri='https://www.adonaibaibul.com.report-uri.io/r/default/ct/enforce'"); */
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
	if($session->is_logged_in()) {
		die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/indexv.php';
</script>");
	}
		$message="";
	//echo phpinfo();
	if(isset($_POST["submit_login"])){
		$username = trim($_POST['username']);
		$password = md5(trim($_POST['password']));
		//http_response_code(403);
		//header('HTTP/1.1 403 Forbidden');
		//$found_user = User::authenticatev($username, $password);
		//ob_start();
		$found = User::find_mail($username);
		$default_argon = empty($found) ? 'null': $found->argonpassword;
		$found_user = User::authenticatev($username, $password, $default_argon) ;
		if ($found_user) {
		    //header('HTTP/1.1 200 OK');
		    //http_response_code(200);
			$session->login($found_user);
			$session->instantiate();
		   /* $latest = Failed_log::find_last();
            $lid=0;
            foreach($latest as $l){
                $lid = $l->id;
            }
            	
            $lid++;
    		$fail = new Failed_log();
    		$fail->id = $lid;
    		$fail->username = $username;
    		$fail->attempt = 3; //successful login
    		$fail->timestamp = date(DateTime::RFC1123, gettime());
    		$fail->createv();
		*/
		
			header("Location: http://www.adonaibaibul.com/indexv.php");
			
			log_action("Log in", $messg);
		die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/indexv.php';
</script>");
		       //echo date_timestamp_get();
        } else {
           //http_response_code(403);
		//echo md5(trim($_POST['password']));
		//echo '<br>'.md5(13/095243001);
		$message = "Username and password do not match.";
       }
	}
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" >
<head profile="http://www.w3.org/2005/10/profile">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:image" content="http://adonaibaibul.com/images/leologo.jpg">
<meta property="og:image:type" content="image/jpg">
<meta property="og:type" content="business">
 <meta property="og:url" content="http://adonaibaibul.com/">
  <meta property="og:site_name" content="Thesis domain">
      <meta property="og:title" content="UWE Cybersecurity project domain">
    <meta property="og:description" content="A vulnerability testing artefact...">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<meta property="og:image:width" content="315">
<meta property="og:image:height" content="110">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Thesis Domain UWE</title>
<!--<link rel="stylesheet" href="styles/login.css" type="text/css" /> -->
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<link rel="icon" 
      type="image/png" 
      href="http://adonaibaibul.com/favicon.ico">
      <link rel="shortcut icon" href="http://adonaibaibul.com/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="scripts/validates.js"></script>
<style>
    body{
        
        opacity: 1;
    
  background: url(images/uweLogo4.jpg) ;
   background-size: cover;
  display: block;
  position: relative;
  margin: 0 auto;
  
}
.flexboxJesus{
    flex-direction: row;
    display: flex;
    flex-wrap: wrap;
}
bdy::after {
  
  content: "";
  opacity: 1;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  
}

html, body{
    max-width: 100vw;
    height: 100vh;
}
body{
 overflow-x: hidden;
 overflow-y: hidden;
 overflow-x: hidden;
}
iframe {
 max-width:100%;
}
/*
img{
 max-width: 100%;
 display: block;
}*/
</style>
</head>

<body topmargin="0"  style="background-color: #FEEFFF; 
           max-width: 100vw;
          overflow: auto;
        clear: both;
      ">


	<table class="w3-table" border="0" style="max-width: 100vw; ">
		<tr >
			<td colspan="4" height=80>
			<table class="w3-table" style="background-color: #00AEFF; width: 100vw; opacity: 0.89" ><tr><form action="biblev.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="option" value="2" />
		<input type="hidden" name="id" value="3" />
		<td style=" width: 80%;"><input type="text" style=" width: 100%;" name="search_field"  class="field2" placeholder="KJV Bible Search..."/>
		</td><td><button type="submit" name="search" class="button" style="width:auto;">Search</button>
		</td></tr></form></table>
		</td>
			
		</tr></table>
		</tr></table>
		<table style="width: 100vw"><tr><td align=right style="width:auto; float:right;"><button onclick="document.getElementById('id02').style.display='block'" style="width:auto; float:right; opacity: 0.89">Sign Up</button></td><td align=left style="width: 5px"></td><td style="width:auto; float:left;">
      <button onclick="document.getElementById('id01').style.display='block'" style="width:auto; opacity: 0.89">Login</button> </td></tr>
      </table>
		<center><span class="error" id="loginerror" style="color: black"><h3><?php if(!empty($message))echo $message; 
	
		?></h3></span>
		<h2>PLEASE THIS PAGE IS DELIBERATELY RENDERED VULNERABLE FOR ACADEMIC DEMONSTRATION PURPOSES</h2>
		</center>
	<div class="flexboxJesus">
                <br><br></div>
                <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
<div class="topnav flexboxJesus" style="opacity: 0.80">
  <a href="#home" class="active">Vulnerabilities addressed</a>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks2">
  <!--  <a href="#news">News</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a> -->
  <!--<a href="JesusChrist_igbo.php" >Baịbul&nbsp;Nsọ&nbsp;Igbo</a>-->
  <a href="login.php" >Back to secure page</a>
             <a href="vulnerable.php" >Broken&nbsp;Access&nbsp;Contol</a>
              <a href="vulnerable.php" >Cryptographic&nbsp;Failure</a>
                <a href="vulnerable.php" >SQL&nbsp;Injection</a>
            <a href="vulnerable.php" >Cross&nbsp;site&nbsp;Scripting</a>
            <a href="vulnerable.php" >Authentication&nbsp;Failure</a>
           <a href="vulnerable.php" >Security&nbsp;Misconfiguration</a>
            <a href="vulnerable.php" >Improper&nbsp;Input&nbsp;Validation</a>
            <a href="vulnerable.php" >Others</a>
            
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction2()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<br><br>
<!-- Top Navigation Menu -->
<!--<div class="mobile-container">-->
<!-- Top Navigation Menu -->
<!--<div class="mobile-container">-->
<div class="topnav flexboxJesus" style="opacity: 0.80">
  <a href="#home" class="active">Short Videos</a>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks">
  <!--  <a href="#news">News</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a> -->
    <a href="JesusChrist_live.php" >Stations&nbsp;of&nbsp;the&nbsp;Cross&nbsp;</a><br>
    <a href="JesusChrist_live.php?Christ=1">Jesus&nbsp;Christ&nbsp;-&nbsp;Bread&nbsp;of&nbsp;Life&nbsp;</a><br>
    <a href="JesusChrist_live.php?Christ=2" >Jesus&nbsp;Christ&nbsp;Born&nbsp;Again&nbsp; </a><br>
   <a href="JesusChrist_live.php?Christ=3">Conversion&nbsp;of&nbsp;St&nbsp;Paul</a><br>
   <a href="JesusChrist_live.php?Christ=4" >Jesus&nbsp;Christ&nbsp;to&nbsp;St.&nbsp;Peter</a><br>
   <a href="JesusChrist_live.php?Christ=5">Jesus&nbsp;Christ&nbsp;raises&nbsp;the&nbsp;dead</a>
  </div>
  <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>


				<div id="id02" class="modal" >
				  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
				  <form class="modal-content animate" action="indexv.php" method="post">
				    <div class="container" >
				   <!-- <center><img src="images/leologo.jpg" alt="Leoportals" class="avatar" ></center><br>-->
				    <label ><b>SURNAME:<span class="error" >*</span></b></label>
				    <input type="text"  name="surname" placeholder="Enter Surname"  required/><br>
				    <label ><b>FIRSTNAME:</b></label>
				    <input type="text"   name="first_name" placeholder="Enter First name" required/>
				    <label >&nbsp;</label>
				    <select name="DOB_day"><option>--Choose day--</option>
						<?php
						for($i=1; $i<32; $i++){
							echo '<option value="'.$i.'" >'.$i.'</option>';
						}
						?>
				    </select><label><b>DATE OF BIRTH: </b></label>
				    <select name="DOB_month"><option>-- Choose month--</option>
										<option value="january">january</option>
										<option value="february">february</option>
										<option value="march">march</option>
										<option value="april">april</option>
										<option value="may">may</option>
										<option value="june">june</option>
										<option value="july">july</option>
										<option value="august">august</option>
										<option value="september">september</option>
										<option value="october">october</option>
										<option value="november">november</option>
										<option value="december">december</option>
				    </select><label>&nbsp;</label>
				    <select name="DOB_year"><option>--Choose year--</option>-->
						<?php
						for($i=1940; $i<2011; $i++){
							echo '<option value="'.$i.'" >'.$i.'</option>';
						}
						?>
				    </select>
				    <label ><b>PHONE NUMBER</b></label><input type="text" name="phone_no"  placeholder="Enter Phone number" required/>
				      <label><b>EMAIL:<span class="error" >*</span></b></label>
				      <input type="text" placeholder="Enter Email" id="email" name="email"  required>
				      <label ><b>GENDER:</b></label>
					<select  name="sex"><option>-Choose gender-</option>
										<option value="male">male</option>
										<option value="female">female</option>
					</select>
				<br>
				<label ><b>SECURITY QUESTION:</b></label>
					<select  name="question" required><option>-Choose a security question</option>
										<option value="pet">What is the name of your favorite pet</option>
										<option value="brother">What is your brother's middle name</option>
										<option value="mother">What is your mother's maiden name</option>
					</select>
				<br>
				<label><b>SECURITY:<span class="error" >*</span></b></label>
				      <input type="text" placeholder="Enter Security Answer" id="answer" name="answer"  required><br>
				      <label><b>PASSWORD:<span class="error" >*</span></b></label>
				      <input type="password" placeholder="Enter Password" id="psw" name="psw"  required>
				<br>
				      <label><b>REPEAT PASSWORD:<span class="error" >*</span></b></label>
				      <input type="password" placeholder="Repeat Password" id="pswrepeat" name="pswrepeat"  required>
				      <br>
				      <div class="clearfix">
					<button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn2">Cancel</button>
					<button type="submit" class="signupbtn" name="signup" style="opacity: 0.89">Sign Up</button>
				      </div>
				    </div>
				  </form>
				</div>
<!--<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
			<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign up</button>-->
<div id="id01" class="modal">
  
  <form class="modal-content animate"  action="vulnerable.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
     <!-- <img src="images/leologo.jpg" alt="Leoportals" class="avatar">-->
    </div>
<center>
    <div class="container">
    <br>
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Email" name="username" id="username" required>
<br>
      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" id="password" required>
        
     <button type="submit" name="submit_login"  style="opacity: 0.89" value="Login">Login</button><br>
      
    </div>
</center>
    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw"> <a href="http://adonaibaibul.com/questionreset.php">Forgot password?</a></span>
    </div>
  </form>
</div>

<script>
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
function myFunction2() {
  var x = document.getElementById("myLinks2");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
// Get the modal for login
var modal1 = document.getElementById('id01');
// Get the modal for signup
var modal2 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}


</script>

			


</body>

</html>
