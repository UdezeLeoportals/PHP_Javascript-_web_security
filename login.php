<?php
	require_once("./includes/initialize.php");
	//echo add_header($session->username, $session->type);
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

	if($session->is_logged_in()) {
		die("<script type=\"text/javascript\">
window.location.href = 'https://www.adonaibaibul.com/index.php';
</script>");
	}
		$message="";

	if(isset($_POST["submit_login"])){
	    if(filter_var(test_input($_POST['username']), FILTER_VALIDATE_EMAIL)){
		$username = htmlspecialchars(trim($_POST['username']));
		$password = md5(htmlspecialchars(trim($_POST['password'])));
		
		//$found_user = User::authenticate($username, $password);
		//ob_start();
		$failure = Failed_log::find_fail($username);
		$failc=0; $found=0;
		foreach($failure as $fails){
		    $failc++;
		}
		$found_user = User::find_email($username);
		$verified = Verifymail::find_by_user_id($found_user->id);
		$verify=0; $twofa=0;
		foreach($verified as $very){
		    if($very->valid==1) $verify=1;
		    if($very->twofa==1) $twofa =1;
		}
		if (password_verify($password, $found_user->argonpassword)) $found=1;
		if ($found==1 && $failc<5 && $verify==1) {
		    if($twofa==0){
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
    		$fail->username = $username;
    		$fail->attempt = 3; //successful login
    		$fail->timestamp = date(DateTime::RFC1123, gettime());
    		$fail->createv();
		
			header("Location: https://www.adonaibaibul.com/index.php");
			
			log_action("Log in", $messg);
		die("<script type=\"text/javascript\">
window.location.href = 'https://www.adonaibaibul.com/index.php';
</script>");
        }else if($twofa==1){
     Failed_log::mailotp($username, $found_user->id);
  
        }
		       //echo date_timestamp_get();
        } else {
	
    		$latest = Failed_log::find_last();
            $lid=0;
            foreach($latest as $l){
                $lid = $l->id;
            }
            	
            $lid++;
    		$fail = new Failed_log();
    		$fail->id = $lid;
    		$fail->username = $username;
    		$fail->attempt = 1;
    		$fail->timestamp = date(DateTime::RFC1123, gettime());
    		$fail->createv();
    		if($failc>=5) {
    		    $message = "Five incorrect matches exceeded, Please click on Forgot password for an OTP";
    		    if($failc==5) Failed_log::mailadmin($username);
    		}
    		else if($verify==0) $message = "Email address has not been validated from your mailbox.";
    		else if($found==0)
    		$message = "Username and password do not match.";
       }
	}
	}
	
	
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\'; style-src \'self\' https://www.w3schools.com/w3css/4/w3.css https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css \'unsafe-inline\' ;connect-src \'self\'; img-src \'self\' \'unsafe-inline\' data:;  font-src \'self\' ; frame-src \'self\' ; frame-ancestors \'self\'; report-uri /csp_report.php');
header("Expect-CT: enforce; max-age=30; report-uri='https://www.adonaibaibul.com.report-uri.io/r/default/ct/enforce'");

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
    
  background: url(images/uweLogo3.jpg) ;
   
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
 .container tr td input, .container tr td select{
    width: 100%;
}
.container tr td {
    width: 50%;
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
<?php
	
?>

	<table class="w3-table" border="0" style="max-width: 100vw; ">
		<tr >
			<td colspan="4" height=80>
			<table class="w3-table" style="background-color: #00AEFF; width: 100vw; opacity: 0.89" ><tr><form action="bible.php" method="POST" enctype="multipart/form-data" onsubmit="return validsearch(this);">
		<input type="hidden" name="option" id="option" value="2" />
		<input type="hidden" name="id" id="id" value="3" />
		<td style=" width: 80%;"><input type="text" style=" width: 95%;" name="search_field"  id="search_field" class="field2" placeholder="KJV Bible Search..."/>
		</td><td><button type="submit" name="search" class="button" style="width:auto;"  value="Search" onclick="return validsearch();">Search</button>
		</td></tr></form></table>
		</td>
			
		</tr></table>
		<table style="width: 100vw"><tr><td align=right style="width:auto; float:right;"><button onclick="document.getElementById('id02').style.display='block'" style="width:auto; float:right; opacity: 0.89">Sign Up</button></td><td align=left style="width: 5px"></td><td style="width:auto; float:left;">
      <button onclick="document.getElementById('id01').style.display='block'" style="width:auto; opacity: 0.89" >Login</button> </td></tr>
      </table>
		<center><span class="error" id="loginerror" style="color: black"><h3><?php 
		
		if(!empty($message))echo $message; 
		if(!empty($_GET['message'])) echo htmlspecialchars($_GET['message']); 
	
		?></h3></span></center>
	<div class="flexboxJesus">
                <br><br></div>
                <!--  Load an icon library to show a hamburger menu (bars) on small screens -->
<div class="topnav flexboxJesus" style="opacity: 0.80">
  <a href="#home" class="active">Vulnerability links</a>
  <!-- Navigation links (hidden by default) -->
  <div id="myLinks2">
  <!--  <a href="#news">News</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a> -->
  <!--<a href="JesusChrist_igbo.php" >Baịbul&nbsp;Nsọ&nbsp;Igbo</a>-->
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
<!--  </div>  -->           
              
		<!--	<p align="left">
			<img border="0" style="width:30vw; height: auto;" src="images/Jesus_Christ.jpg"></p> <p align="top">
			<img border="0" style="width:40vw;  height: auto; " src="images/JesusChrist_images/JESUS_CHRIST_LOV.png"></p> --> 
			

				<div id="id02" class="modal" >
				  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
				  <form class="modal-content animate" action="index.php" method="post" onsubmit="return validats(this);" id="signupform">
				    <div class="container" >
				        <table style="width: 100%"><tr><td>
				   <!-- <center><img src="images/leologo.jpg" alt="Leoportals" class="avatar" ></center><br>-->
				    <label ><b>SURNAME:<span class="error" >*</span></b></label>
				    </td><td><input type="text"  name="surname" placeholder="Enter Surname" id="surname" onkeyup="validsurname(this.value)" required/><br>
				    <span class="error" id="surnamespan"></span></td></tr>
				    <tr><td><label ><b>FIRSTNAME:</b></label></td>
				    <td><input type="text"   name="first_name" id="first_name" placeholder="Enter First name" onkeyup="validname(this.value)"/><br>
				    <span class="error" id="namespan"></span></td></tr>
				    <tr><td></td>
				    <td><select name="DOB_day" id="DOB_d"><option disabled="disabled">--Choose day--</option>
						<?php
						for($i=1; $i<32; $i++){
							echo '<option value="'.$i.'" >'.$i.'</option>';
						}
						?>
				    </select></td></tr>
				    <tr><td><label><b>DATE OF BIRTH: </b></label></td><td><select name="DOB_month" id="DOB_m"><option disabled="disabled">-- Choose month--</option>
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
				    </select></td></tr>
				    <tr><td></td><td><select name="DOB_year" id="DOB_y"><option disabled="disabled">--Choose year--</option>-->
						<?php
						for($i=1940; $i<2011; $i++){
							echo '<option value="'.$i.'" >'.$i.'</option>';
						}
						?>
				    </select></td></tr>
				    <tr><td><label ><b>PHONE NUMBER</b></label></td>
				    <td><input type="text" name="phone_no"  id="phone" placeholder="Enter Phone number with no special character" onkeyup="validatePhone(this.value)" required/><br>
				      <span class="error" id="phonespan"></span>
				      <input type="hidden" id="validphone"></td></tr>
				     <tr><td> <label><b>EMAIL:<span class="error" >*</span></b></label></td>
				      <td><input type="text" placeholder="Enter Email" id="email" name="email" onkeyup="validateEmail(this.value)" required><br>
				      <span class="error" id="mailspan"></span></td></tr>
				     <tr><td> <label ><b>GENDER:</b></label></td>
					<td><select  name="sex" id="gender"><option disabled="disabled">-Choose gender-</option>
										<option value="male">male</option>
										<option value="female">female</option>
					</select>
				<br></td></tr>
				<tr><td><b>EMAIL 2-FACTOR AUTHENTICATION:</b></td>
				<td>I agree&nbsp;<input align="left" type="checkbox" name="twoFA" value="1" checked/></td></tr>
				      <tr><td><label><b>PASSWORD:<span class="error" >*</span></b></label></td>
				      <td><input type="password" placeholder="Enter Password" id="psw" name="psw" onkeyup="validatepass1(this.value)" required><br>
				      <span class="error" id="pass1span"></span>
				<br></td></tr>
				     <tr><td> <label><b>REPEAT PASSWORD:<span class="error" >*</span></b></label></td>
				     <td> <input type="password" placeholder="Repeat Password" id="pswrepeat" name="pswrepeat" onkeyup="validatepass2(this.value)" required><br>
				      <span class="error" id="pass2span"></span>
				      <br>
				     </td></tr>
				
				      <div class="clearfix">
					<tr><td><button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn2">Cancel</button></td>
					<td><button type="submit" class="signupbtn" name="signup" style="opacity: 0.89" onclick="return validats();" value="Sign Up">Sign Up</button></td></tr>
					</table>
				      </div>
				    </div>
				  </form>
				</div>
<!--<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
			<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Sign up</button>-->
<div id="id01" class="modal">
  
  <form class="modal-content animate"  action="login.php" method="post" onsubmit="return validlog(this);">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
     <!-- <img src="images/leologo.jpg" alt="Leoportals" class="avatar">-->
    </div>

    <div class="container">
   <center>
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Email" name="username" id="username" required>
<br>
      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" id="password" required>
        
      <button type="submit" name="submit_login"  style="opacity: 0.89" value="Login" onclick="return validlog();">Login</button><br>
     
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw"> <a href="http://adonaibaibul.com/passwdmail.php">Forgot password?</a></span>
    </div>
  </form>
  </center>
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

function validlog(){
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var x = document.getElementById('username');
    if(x.value.match(mailformat)) return true; 
    else return false;
}
function validsearch(){
    var searchformat = /^[\w,;'"\s\.?!-]+$/;
    var field = document.getElementById('search_field');
    var x = document.getElementById('option');
    var y = document.getElementById('id');
    if(field.value.match(searchformat) && x.value==2 && y.value==3) return true; 
    else return false;
}

</script>

			


</body>

</html>
