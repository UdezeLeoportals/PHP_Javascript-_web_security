<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
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
html, body {
    width: 100vw;
    height: 100vh;
}
</style>
<?php 
//session_start();
require_once("./includes/initialize.php"); ?>
</head>
<body style="background-color: #00dc00; 
          
          overflow: auto;
           background: lightblue url(/images/uweLogo3.jpg);
          clear: both;
      ">

<?php
$gr8=0;
if(!empty($_GET['a'])){
    $existence = Verifymail::find_by_user_id(test_input($_GET['a']));
    if(!empty($existence)){
        //Verifymail::change_valid(test_input($_GET['a']), 1);
    
    foreach($existence as $ex){    
    $new_id = test_input($_GET['a']);
    
    $validity = new Verifymail();
    $validity->id =  $ex->id;
    $validity->user_id = $ex->user_id;
    $validity->valid = 1;
    $validity->twofa = $ex->twofa;
    if($validity->update()) {
        $gr8=1;
        
         $user = User::find_otpid($new_id);
         $found_user = User::find_email($user->username);
         $session->login($found_user);
			$session->instantiate();
		$message ="Please log into your account";
                       die("<script type=\"text/javascript\">
window.location.href = 'login.php?message=".$message."';
</script>");
    }
    }
    }
}
?>
<h2 style="text-align:center">Email Verification</h2>

<div class="card">
  <img src="/images/leologo.jpg" alt="Leoportals" style="width:50%">
  <div class="container">
    <h1>Leoportals Network</h1>
    <p class="title"><?php
    if($gr8==1) echo "Please try not to create another account with the same email address.";
    else echo "Email could not be verified in our database!"
    
    ?></p>
    <form action="https://www.adonaibaibul.com" method="post">
    <div style="margin: 24px 0;">
   <?php  if($gr8==1) echo'<p>Your email address has been successfully confirmed. You can now log in</p>'; ?>
   </div>
   <p><button type ="submit" >WELCOME</button></p>
    </form>
  </div>
</div>


</body>
</html>