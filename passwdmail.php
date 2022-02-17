
<?php require_once("./includes/initialize.php"); 
require_once "./Mailing/Mail.php";
  	
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\' https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js \'unsafe-inline\'; style-src \'self\' https://www.w3schools.com/w3css/4/w3.css https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css \'unsafe-inline\' ;connect-src \'self\'; img-src \'self\' \'unsafe-inline\' data:;  font-src \'self\' ; frame-src \'self\' ; frame-ancestors \'self\'; report-uri /csp_report.php');
header("Expect-CT: enforce; max-age=30; report-uri='https://www.adonaibaibul.com.report-uri.io/r/default/ct/enforce'");
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

<?php
$submit_message='';
if(isset($_POST['submit'])){
    //RESET OLD PASSWORD
$mailin = !empty(test_input($_POST['mail3'])) ? test_input($_POST['mail3']) : '';
if($mailin!=''){
    $psw = test_input($_POST['psw']);
    $psw2 = test_input($_POST['pswrep']);
    $pin2 = test_input($_POST['pin3']);
    $good = Mailpin::check_pin($mailin, $pin2);
    if(!empty($good)){
    $users =User::find_by_mail($mailin);
    if(!empty($users)){
    foreach($users as $userz){
        
            if($psw==$psw2){
                
                $newse = new User();
                $newse->id = $userz->id;
                $newse->username = $userz->username;
                $newse->argonpassword = password_hash(md5($psw), PASSWORD_ARGON2ID, ['memory_cost' => '65536','time_cost'=>4, 'threads'=>2]);
                $newse->type = $userz->type;
                $newse->status = $userz->status;
                $newse->online = 0;
                if($newse->update()){
                $submit_message= 'Password changed successfully!!!<br> Go back to the Login  page and log in';
                foreach($good as $p){
                $newr = new Mailpin();
            $newr->id = $p->id;
            $newr->used = 2;
            $newr->email = $p->email;
            $newr->pin = $p->pin;
            $newr->update();
            }
            $fails = Failed_log::find_fail($userz->username);
            foreach($fails as $failed){
                $newf = new Failed_log();
                $newf->id = $failed->id;
                $newf->username = $failed->username;
                $newf->attempt = 2;
                $newf->update();
            }
                }  
            }else $submit_message='New passwords do not match!!!';
       
    }
    }else $submit_message=  'Account could not be found';
    } else $submit_message= 'This pin does not exist, Please check your mail again ';
}

}
   
	   
       
    

?>
<h2 style="text-align:center">Password Retrieval</h2>

<div class="card">
  <img src="/images/leologo.jpg" alt="Leoportals" style="width:50%">
  <div class="container">
    <h1>Leoportals Network</h1>
    <p class="title">Please note that we will have to reset your password</p>
    <p>You will get a mail with a 15-digit PIN. Enter it to change your password.</p>
    <?php if(!empty($submit_message)) echo '<h2>'.$submit_message.'</h2>'; ?>
     <div style="margin: 24px 0;" id="maildiv">
    <form action="sendmailer.php" method="get" id="form" enctype="multipart/form-data" onsubmit="myfunc();">
   
        <label>Username( Email ):</label>
        <input type="text"  name="email" id="email" placeholder="Enter the email you use as a username" required/>
  
   <p>
       <input class="button" type="submit" value="Submit"><br>
        <center><div id="preview"></div></center>
        <center><span id="succeed" style="color: blue"></span></center></p>
    </form> </div>
    <div style="margin: 24px 0; display: none;" id="pindiv">
    <form action="passwdmail.php" method="get" id="form2" enctype="multipart/form-data" onsubmit="myfunc2();">
   <input type="hidden" value="" name="mail2" id="mail2" />
   <label>PIN:</label>
        <input type="text"  name="pin" id="pin" placeholder="Enter the 15-digit pin that was sent to your email address" required/>
   <label>EMAIL:</label><div id="view"></div>
        
  
   <p>
       <input class="button" name="submit" type="submit" value="Submit"><br>
        <center><div id="preview2"></div></center>
        <center><span id="succeed2" style="color: blue"></span></center></p>
    </form> </div>
  </div>
</div>

<div id="id01" class="modal">
  
  <form class="modal-content animate"  action="passwdmail.php" method="post" id="form3" enctype="multipart/form-data" onsubmit="return valids();">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <center><img src="images/leologo.jpg" alt="Leoportals" class="avatar"></center>
    </div>
    <div class="container" id="changepass">
    <span class="error" id="loginerror"><?php //if(!empty($message))echo $message; ?></span><br>
    <table id="pass"><tr><td>
      <label >Username:</label></td><td>
      <div id="show"></div></td></tr>
        <tr><td>
      <input type="hidden" value="" name="mail3" id="mail3" />
      <input type="hidden" value="" name="pin3" id="pin3" />
      <label>New Password</label></td><td>
      <input type="password" placeholder="Enter New Password" name="psw" onkeyup="validatepass1(this.value)" id="psw" required>
        <span class="error" id="pass1span"></span></td></tr><tr><td>
      <label>Confirm New Password</label></td><td>
      <input type="password" placeholder="Enter New Password Again" name="pswrep" onkeyup="validatepass2(this.value)" id="pswrep" required>
        <span class="error" id="pass2span"></span></td></tr>
      <tr><td>
          <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
    </div>
      </td>

    <td>
    <p>
       <input class="button" name="submit" type="submit" value="Submit"><br>
        <center><div id="preview3"></div></center>
        </p></td></tr>
    <tr><td colspan=2><center><span id="succeed3" style="color: blue"></span></center></td></tr></table>
  </form>
</div>

</body>
<script>
function myfunc(){
   
	 var modal1 = document.getElementById('pindiv');
	 //var modal2 = document.getElementById('maildiv');
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			  document.getElementById("succeed").innerHTML = xmlhttp.responseText;
			   modal1.style.display = "block";
		      }
		  };
		  var commentr = document.getElementById("email").value;
		  
		  xmlhttp.open("GET", "sendmailer.php?email=" + commentr, true);
		  xmlhttp.send();
		  document.getElementById("view").innerHTML = commentr;
		  $("#mail2").val(commentr);
		  $("#email").val('');
	        return false;
    
 }
 var form = document.getElementById("form");
function handleForm(event) { event.preventDefault(); } 
form.addEventListener('submit', handleForm);

function myfunc2(){
   
	// var modal = document.getElementById('pindiv');
	// var modal2 = document.getElementById('maildiv');
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			  document.getElementById("succeed2").innerHTML = xmlhttp.responseText;
			  
			      document.getElementById('id01').style.display='block';
			    
		      }
		  };
		  var commentr = document.getElementById("mail2").value;
		  var com = document.getElementById("pin").value;
		  xmlhttp.open("GET", "sendmailer.php?maill=" + commentr + "&pin=" + com, true);
		  xmlhttp.send();
		  document.getElementById("show").innerHTML = commentr;
		  $("#pin").val('');
		  $("#pin3").val(com);
		  $("#mail3").val(commentr);
	        return false;
    
 }
 var form2 = document.getElementById("form2");
function handleForm2(event) { event.preventDefault(); } 
form2.addEventListener('submit', handleForm2);

function myfunc3(){
   
	// var modal = document.getElementById('pindiv');
	// var modal2 = document.getElementById('maildiv');
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			  document.getElementById("succeed3").innerHTML = xmlhttp.responseText;
			  
		      }
		  };
		  var commentr = document.getElementById("mail3").value;
		  var com = document.getElementById("psw").value;
		  var com2 = document.getElementById("pswrep").value;
		   var com3 = document.getElementById("pin3").value;
		  xmlhttp.open("GET", "sendmailer.php?mailn=" + commentr + "&pass=" + com + "&pass2=" + com2+ "&pinn=" + com3, true);
		  xmlhttp.send();
		  document.getElementById("show").innerHTML = commentr;
		  $("#psw").val('');
		  $("#pswrep").val('');
	        return false;
    
 }
 //var form3 = document.getElementById("form3");
//function handleForm3(event) { event.preventDefault(); } 
//form3.addEventListener('submit', handleForm3);
</script>
</html>