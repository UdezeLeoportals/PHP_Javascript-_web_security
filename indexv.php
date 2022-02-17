<?php 
//ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/var/cpanel/php/sessions/ea-php73'));
session_start();
require_once("./includes/initialize.php"); 
?>
<?php 
//index.php

 if (!($session->is_logged_in()) && !(isset($_POST['signup']))) {
    die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/login.php';
</script>");
header("Location: http://www.adonaibaibul.com/login.php", true, 301);
}
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());


// SIGN UP FORM SUBMISSION
 if(isset($_POST['signup'])){
        $checks = User::find_by_mail(test_input($_POST['email']));
               if(empty($checks))
               {
                   $latest = User::find_last();
                    $lid=0;
                    foreach($latest as $l){
                        $lid = $l->id;
                    }
                    $lid++;
		$new_user = new User();
		$new_user->id = $lid;
		 $new_user->username  = $_POST['email'];
		$new_user->argonpassword  = password_hash( md5($_POST['psw']), PASSWORD_ARGON2ID, ['memory_cost' => '65536','time_cost'=>4, 'threads'=>2]);
		$new_user->type      = 'blogger';
		$new_user->status    = 1;
		$new_user->online    = 1;
		if($new_user->createv()){
		     $latest = Biodata::find_last();
                    $lid=0;
                    foreach($latest as $l){
                        $lid = $l->id;
                    }
                    $lid++;
			$new_biodata = new Biodata();
			$new_biodata->id = $lid;
			$new_biodata->user_id = $new_user->id;
			$new_biodata->surname = $_POST['surname'];
			$new_biodata->first_name = $_POST['first_name'];
			$new_biodata->DOB_day = $_POST['DOB_day'];
			$new_biodata->DOB_month = $_POST['DOB_month'];
			$new_biodata->DOB_year = $_POST['DOB_year'];
			$new_biodata->phone_no = $_POST['phone_no'];
			$new_biodata->email = $_POST['email'];
			$new_biodata->sex = $_POST['sex'];
			$new_biodata->sign_up_date = date(DateTime::RFC1123, gettime());
			$new_biodata->createv();
			$messg = $new_user->username.' '.$new_user->type;
			log_action("Log in", $messg);	
			
			$lastid = Userv::find_last(); $lid=0;
			foreach($lastid as $l){ 
			    $lid = $l->id;
			    
			} 
			$lid++; 
			
			$new_userv = new Userv();
			$new_userv->id = $lid;
			$new_userv->userid = $new_user->id;
			$new_userv->email = $_POST['email'];
			$new_userv->question = $_POST['question'];
			$new_userv->answer = $_POST['answer'];
			$new_userv->createdat = date(DateTime::RFC1123, gettime());
			$new_userv->deletedat = 'null';
			$new_userv->createv();
		}
		$found_user = User::find_mail($_POST['email']);
		$session->login($found_user);
		$session->instantiate();
		
		//Create Verifymail()
		$latest = Verifymail::find_last();
                $lid=0;
                foreach($latest as $l){
                    $lid = $l->id;
                }
                $lid++;
		$very = new Verifymail();
		$very->id = $lid;
		$very->user_id = $new_user->id;
		$very->valid = 0;
		$very->create();
		//code to send verification mail
              /* 
                */
               }
               else
               {
                        die("<script type=\"text/javascript\">
window.location.href = 'vulnerable.php';
</script>");
                }
	}
  
?>
<?php

echo vuln_header($session->username, $session->type);
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
          echo "updatesv.php?a=2"; 
          ?>"><h2>POST NEWS &raquo;&raquo;<br/></h2>
          <div class="imgholder"><img src="images/flame.jpg" alt="" /></div></a>
          <p></p>
        <p class="readmore"><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Change Password</button></p>
          
        </li>
        <li>  
        <a href="<?php 
           echo "updatesv.php?a=1"; 
          ?>"><h2>POST CHURCH COMMENTARY&raquo;</h2>
        
          <div class="imgholder"><img src="images/flame.jpg" alt="" /></div></a>
          <p></p>
        </li>
        
        <li>
          <a href="<?php 
          echo "updatesv.php?a=4"; 
          ?>"><h2>POST LIVE OF SAINTS &raquo;<br/></h2>
          <div class="imgholder"><img src="images/flame.jpg" alt="" /></div></a>
          <p></p>
          <p class="readmore"><a href="<?php 
           echo "updatesv.php?a=3"; 
          ?>">POST CHURCH READING </a></p>
        </li>
        
        <li class="last">
          <a href="<?php 
           echo "updatesv.php?a=5"; 
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
  
  <form class="modal-content animate"  action="passwdChange.php" method="get" id="form3" enctype="multipart/form-data" onsubmit="myfunc3();">
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
		  
		  xmlhttp.open("GET", "passwdChange.php?oldp=" + commentr + "&pass=" + com + "&pass2=" + com2, true);
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