
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

if(isset($_POST['submit'])){
    
}
   
	   
       
    

?>
<h2 style="text-align:center">Password Retrieval</h2>

<div class="card">
  <img src="/images/leologo.jpg" alt="Leoportals" style="width:50%">
  <div class="container">
    <h1>Leoportals Network</h1>
    <p class="title">Please note that we will have to reset your password</p>
    <p>You will have to answer your security question correctly to change the password.</p>
    <?php
        $quest=""; $message="";
        $match=0; $email=0;
        if(isset($_POST['submit_quest'])){
            $email = $_POST['email']; $question = $_POST['question'];
            $answer = $_POST['answer'];
            $quest = Userv::find_question($email, $question, $answer);
            if(empty($quest)) $message = "Wrong security answer, Please try again";
            else $match =1;
        }
        if($match==1 || isset($_POST['submit_pass'])){
          
        if(!empty($_POST['submit_pass']) && isset($_POST['submit_pass'])){
             $users =User::find_by_mail($_POST['mail']);
            if(!empty($users)){
                foreach($users as $userz){
                    
                        if($_POST['psw']==$_POST['pswrepeat']){
                            
                            $newse = new User();
                            $newse->id = $userz->id;
                            $newse->username = $userz->username;
                            $newse->argonpassword = password_hash(md5($_POST['psw']), PASSWORD_ARGON2ID, ['memory_cost' => '65536','time_cost'=>4, 'threads'=>2]);
                            $newse->type = $userz->type;
                            $newse->status = $userz->status;
                            $newse->online = 0;
                            if($newse->update())
                            echo '<b style="color:red">Password changed successfully!!!<br> Go back to the Login  page and log in</b>';
                            
                        }else echo '<b style="color:red">New passwords do not match!!!</b>';
                   
                }
            }else echo  '<b style="color:red">Account could not be found</b>';
        }
     ?>
   <div style="margin: 24px 0;" id="maildiv">
   <form action="questionreset.php" method="post"  enctype="multipart/form-data" >
   <input type="hidden" name="mail" id="mail" value="<?php echo $email; ?>"/>
   <label>CHOOSE NEW PASSWORD:</label>
   <input type="password"  name="psw" id="psw" placeholder="Enter your new password" required/><br>
   <label>REPEAT NEW PASSWORD:</label>
   <input type="password"  name="pswrepeat" id="pswrepeat" placeholder="Enter your new password again" required/><p>
       <input class="button" name="submit_pass" type="submit" value="Submit"><br>
        <center><div id="preview2"></div></center>
        <center><span id="succeed2" style="color: blue"></span></center></p></form></div>
   <?php
        }
        if(!empty($message)) echo "<h3>".$message."</h3>";
        if(empty($quest)){
    ?>
     <div style="margin: 24px 0;" id="maildiv">
    <form action="questionreset.php" method="post" id="form" enctype="multipart/form-data">
   
        <label>Username( Email ):</label>
        <input type="text"  name="email" id="email" placeholder="Enter the email you use as a username" required/><br>
        <label>Security Question:</label>
        <select  name="question" id="question" required><option>-Choose a security question</option>
			<option value="pet">What is the name of your favorite pet</option>
			<option value="brother">What is your brother's middle name</option>
			<option value="mother">What is your mother's maiden name</option>
					</select>
				<br>
		<label>Security Answer: </label>
        <input type="text"  name="answer" id="answer" placeholder="Enter the the answer to your security question" required/><br>
   <p>
       <input class="button" type="submit" value="Submit" name="submit_quest"><br>
        <center><div id="preview"></div></center>
        <center><span id="succeed" style="color: blue"></span></center></p>
    </form> </div>
    <?php } ?>
  </div>
</div>

<div id="id01" class="modal">
  
  <form class="modal-content animate"  action="sendmailer.php" method="get" id="form3" enctype="multipart/form-data" onsubmit="myfunc3();">
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

</html>