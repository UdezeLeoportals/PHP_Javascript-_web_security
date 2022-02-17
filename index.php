<?php 

session_start();
require_once("./includes/initialize.php"); 
?>
<?php 
//index.php

 if (!($session->is_logged_in()) && !(isset($_POST['signup']))) {
    
header("Location: https://www.adonaibaibul.com/login.php", true, 301);
}
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());

require_once "./Mailing/Mail.php";
require_once "./Mailing/Mail_Mime/Mail/mime.php";
// SIGN UP FORM SUBMISSION
 if(isset($_POST['signup'])){
      if(filter_var(test_input($_POST['email']), FILTER_VALIDATE_EMAIL) && preg_match("/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/",test_input($_POST['phone_no'])) && preg_match("/^[a-zA-Z ]*$/",test_input($_POST['surname'])) && preg_match("/^[a-zA-Z ]*$/",test_input($_POST['first_name'])) && preg_match("/^[a-zA-Z ]*$/",test_input($_POST['DOB_month'])) && preg_match("/^[a-zA-Z ]*$/",test_input($_POST['sex'])) && filter_var(test_input($_POST['DOB_day']), FILTER_VALIDATE_INT) && filter_var(test_input($_POST['DOB_year']), FILTER_VALIDATE_INT) && preg_match("/^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{12,}$/",test_input($_POST['psw']))){
        $checks = User::find_by_mail(test_input($_POST['email']));
               if(empty($checks))
               {
                  
                   if(strcmp(test_input($_POST['psw']),test_input($_POST['pswrepeat']))==0){
                   $latest = User::find_last();
                    $lid=0;
                    foreach($latest as $l){
                        $lid = $l->id;
                    }
                    $lid++;
		$new_user = new User();
		$new_user->id = $lid;
		 $new_user->username  = test_input($_POST['email']);
		$new_user->argonpassword  =password_hash( md5(test_input($_POST['psw'])), PASSWORD_ARGON2ID, ['memory_cost' => '65536','time_cost'=>4, 'threads'=>2]);
		$new_user->type      = 'blogger';
		$new_user->status    = 1;
		$new_user->online    = 1;
		if($new_user->create()){
		     $latest = Biodata::find_last();
                    $lid=0;
                    foreach($latest as $l){
                        $lid = $l->id;
                    }
                    $lid++;
			$new_biodata = new Biodata();
			$new_biodata->id = $lid;
			$new_biodata->user_id = $new_user->id;
			$new_biodata->surname = test_input($_POST['surname']);
			$new_biodata->first_name = test_input($_POST['first_name']);
			$new_biodata->DOB_day = test_input($_POST['DOB_day']);
			$new_biodata->DOB_month = test_input($_POST['DOB_month']);
			$new_biodata->DOB_year = test_input($_POST['DOB_year']);
			$new_biodata->phone_no = test_input($_POST['phone_no']);
			$new_biodata->email = test_input($_POST['email']);
			$new_biodata->sex = test_input($_POST['sex']);
			$new_biodata->sign_up_date = date(DateTime::RFC1123, gettime());
			$new_biodata->create();
			$messg = $new_user->username.' '.$new_user->type;
			log_action("Log in", $messg);	
		}
		//$found_user = User::find_email(test_input($_POST['email']));
		//$session->login($found_user);
		//$session->instantiate();
		
		//Create Verifymail()
		$latest = Verifymail::find_last();
                $lid=0;
                foreach($latest as $l){
                    $lid = $l->id;
                }
                $lid++;
        $twofa = 0;
        if(isset($_POST['twoFA']) && htmlspecialchars($_POST['twoFA'])==1) $twofa=1;
      
		$very = new Verifymail();
		$very->id = $lid;
		$very->user_id = $new_user->id;
		$very->valid = 0;
		$very->twofa = $twofa;
		$very->create();
		//code to send verification mail
                $to = test_input($_POST['email']);
        
                //send a link
               
                  $from = "support@adonaibaibul.com";
                  
                 $host = "mail.adonaibaibul.com";
            $port = "587";
            $username = "account";
            $password = "password";
           
                $message = "<center><table  style ='width: 65%;  background-color: lightblue;'><tr><td>EMAIL CONFIRMATION</td></tr>";
        	    $message .= "<tr><td><center><img src='https://adonaibaibul.com/images/leologo.jpg' height=150 width=450/> </center></td></tr>" ;
        	    $message .= "<tr><td>Please click on the link below to confirm your email address. You will have to use the Login button to log into your account</td></tr>";
        	    $message .= "<tr><td><a href='http://adonaibaibul.com/confirmmail.php?a=".$new_user->id."' style ='color: red'>Click here</a></td></tr>";
        	    $message .= "<tr><td>Thank you for using this website.<br>Courtesy: Leoportals Suport Team.</td></tr></table></center>";
        	    
                //$message = wordwrap($message, 70);
                $subject = "Verification of Email";
                
                $headers = array ('From' => $from,
              'To' => $to,
              'Subject' => $subject);
              
              //$file = '/confirmations/yourbooking.pdf';
              
	            $mime = new Mail_mime();
	           // $mime->setTXTBody($text);
                $mime->setHTMLBody($message);
              //  $mime->addAttachment($file, 'text/plain');
              $body = $mime->get();
                $headers = $mime->headers($headers);
                
                 $smtp = Mail::factory('smtp',
              array ('host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password));
                
                //send mail and get response.
                $mail = $smtp->send($to, $headers, $body);
            
            if (PEAR::isError($mail)) {
              $message = $mail->getMessage();
             } else {
              $message ="Please check your mailbox, click the link to activate your account";
             }
               
                       die("<script type=\"text/javascript\">
window.location.href = 'login.php?message=".$message."';
</script>");
                   }else{
                       $message ="Passwords do not match";
                       die("<script type=\"text/javascript\">
window.location.href = 'login.php?message=".$message."';
</script>");
                   } 
               
               }
               else
               {
                        $message ="Email already exists in the database";
                       die("<script type=\"text/javascript\">
window.location.href = 'login.php?message=".$message."';
</script>");
                }
               }else{
                   if(!filter_var(test_input($_POST['email']), FILTER_VALIDATE_EMAIL)) $message ="Invalid Email address";
                   else if(!preg_match("/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/",test_input($_POST['phone_no']))) $message ="Invalid Phone number";
                   else if(!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['surname'])) || !preg_match("/^[a-zA-Z ]*$/",test_input($_POST['first_name'])) ) $message ="Invalid Name";
                   else if(!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['DOB_month'])) || !filter_var(test_input($_POST['DOB_day']), FILTER_VALIDATE_INT) || !filter_var(test_input($_POST['DOB_year']), FILTER_VALIDATE_INT)) $message ="Invalid Date of birth";
                   else if(!preg_match("/^[a-zA-Z ]*$/",test_input($_POST['sex']))) $message ="Invalid gender";
                   else if(!preg_match("/^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{12,}$/",test_input($_POST['psw']))) $message ="Invalid password";
                       die("<script type=\"text/javascript\">
window.location.href = 'login.php?message=".$message."';
</script>");
                   }
	}
  
?>
<?php

echo add_header($session->username, $session->type);
?>

<!-- ####################################################################################################### -->

<!-- ####################################################################################################### 
INDEX CENTRAL IMAGE
-->
<style>
.button{
        color: white;
        background: #400000;
    }
</style>
<link rel="stylesheet" href="styles/login.css" type="text/css" />
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />

<script type="text/javascript" src="scripts/validates.js"></script>
<div></div>
<div class="wrapper col3" style="background: url(images/uweLogo3.jpg) ; background-size: cover;">
   
  <div id="featured_slide">
    <div id="featured_wrap">
      <ul id="featured_tabs">
        <li><a href="#fc1"><br />
          <span></span></a></li>
        <li><a href="#fc2"><br />
          <span></span></a></li>
        <li><a href="#fc3"><br />
          <span></span></a></li>
        <li class="last"><a href="#fc4"><br />
          <span></span></a></li>
      </ul>
      <div id="featured_content">
        <div class="featured_box" id="fc1"><img src="images/sugUwe.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc2"><img src="images/COVID_Background.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc3"><img src="images/study.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc4"><img src="images/uweLogo2.jpg" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ####################################################################################################### 
WRITING OF WORD OF GOD FORM LINKS
-->

<div class="wrapper col4" style="background: url(images/uweLogo4.jpg) ; background-size: cover;">
  <div id="container">
    <div id="hpage">
      <ul>
        <li>
            <a href="<?php 
          echo "updates.php?a=2"; 
          ?>"><h2>POST NEWS <br/></h2>
          <div class="imgholder"><img src="images/flame.jpg" alt="" /></div></a>
          <p></p>
        <p class="readmore"><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Change Password</button></p>
          
        </li>
        <li>  
        <a href="<?php 
           echo "updates.php?a=1"; 
          ?>"><h2>POST CHURCH COMMENTARY&raquo;</h2>
        
          <div class="imgholder"><img src="images/flame.jpg" alt="" /></div></a>
          <p></p>
        </li>
        
        <li>
          <a href="<?php 
          echo "updates.php?a=4"; 
          ?>"><h2>POST LIVE OF SAINTS &raquo;<br/></h2>
          <div class="imgholder"><img src="images/flame.jpg" alt="" /></div></a>
          <p></p>
          <p class="readmore"><a href="<?php 
           echo "updates.php?a=3"; 
          ?>">POST CATHOLIC MASS READING &raquo;&raquo;</a></p>
        </li>
        
        <li class="last">
          <a href="<?php 
           echo "updates.php?a=5"; 
          ?>"><h2>POST CHRISTIAN DEVOTIONALS &raquo;</h2>
          <div class="imgholder"><img src="images/flame.jpg" alt="" /></a></div>
          <p></p>
          <!--<p class="readmore"><a href="JESUS_CHRIST_upld_pdf.php"
          >Upload PDF Article</a></p> -->
        </li>
      </ul>
      <br class="clear" />
    </div>
  </div>
</div>
<!-- CHANGE PASSWORD FORM -->
<div id="id01" class="modal">
  
  <form class="modal-content animate"  action="sendmailer.php" method="get" id="form3" enctype="multipart/form-data" onsubmit="myfunc3();">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <center><img src="images/leologo.jpg" alt="Leoportals" class="avatar"></center>
    </div>
    <div class="container" id="changepass">
    <span class="error" id="loginerror"><?php //if(!empty($message))echo $message; ?></span><br>
    <table id="pass"><tr><td>
      <label >Username</label></td><td><span><?php echo $session->username; ?></span>
      </td></tr>
        <tr><td>
      <label>Old Password</label></td><td>
      <input type="password" placeholder="Enter Old Password" name="oldp" id="oldp" required></td></tr>
        <tr><td>
      <label>New Password</label></td><td>
      <input type="password" placeholder="Enter New Password" name="psw" onkeyup="validatepass1(this.value)" id="psw" required>
        <span class="error" id="pass1span"></span></td></tr><tr><td>
      <label>Repeat New Password</label></td><td>
      <input type="password" placeholder="Enter New Password Again" name="pswrep" onkeyup="validatepass2(this.value)" id="pswrep" required>
        <span class="error" id="pass2span"></span></td></tr></table>
       <p>
       <input class="button" name="submit" type="submit" value="Submit"><br>
        <center><div id="preview3"></div></center>
        <center><span id="succeed3" style="color: blue"></span></center>
        </p><br>
      <!--<input type="checkbox" checked="checked"> Remember me-->
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
    </div>
  </form>
</div>

<script>
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

function myfunc3(){
   
	// var modal = document.getElementById('pindiv');
	// var modal2 = document.getElementById('maildiv');
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			  document.getElementById("succeed3").innerHTML = xmlhttp.responseText;
			  
		      }
		  };
		  var commentr = document.getElementById("oldp").value;
		  var com = document.getElementById("psw").value;
		  var com2 = document.getElementById("pswrep").value;
		  
		  xmlhttp.open("GET", "sendmailer.php?oldp=" + commentr + "&pass=" + com + "&pass2=" + com2, true);
		  xmlhttp.send();
		  //document.getElementById("show").innerHTML = commentr;
		  $("#psw").val('');
		  $("#pswrep").val('');
	        return false;
    
 }
 var form3 = document.getElementById("form3");
function handleForm3(event) { event.preventDefault(); } 
form3.addEventListener('submit', handleForm3);
</script>
<!-- ###########################################################################
############################ 
REPLACE
1: NEWS with CATHOLIC CHURCH MASS READINGS
2: ..............CHARITY
3: JOB with CHURCH COMMENTARY
4: CAMPUS with LIVE OF SAINTS
5: Devotional
-->
<?php echo footer(); ?>