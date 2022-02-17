<?php

// get the q parameter from URL
$q = $_REQUEST["q"];
$p = $_REQUEST["p"];
 if($p!=$q)
      echo "Passwords do not match!";
 if(!preg_match("/^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){2,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{12,}$/",$q))
  echo "Password must contain at least 12 characters with at least 2 upper cases, 3 lower cases, 2 numbers and 1 special character";
 
?>