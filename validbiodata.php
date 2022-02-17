<?php
//require_once("./includes/initialize.php"); 
// get the q parameter from URL
$q = $_REQUEST["q"];
$email = test_input($q);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "Invalid email format";
    }
/*else{
      $checks = User::find_by_mail($email);
      if(!empty($checks)){
            echo "Email address already exists!";
      }
}*/
    function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>