<?php

// get the q parameter from URL

$q = empty($_REQUEST["q"]) ? "" : $_REQUEST["q"];
$p = empty($_REQUEST["p"]) ? "" : $_REQUEST["p"];
$r = empty($_REQUEST["r"]) ? "" : $_REQUEST["r"];
$ph = empty($_REQUEST["ph"]) ? "" : $_REQUEST["ph"];

if(!empty($q)){
$surname = test_input($q);
// check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$surname)) {
      echo "Only letters and white space allowed";
    }
}
if(!empty($p)){
$name = test_input($p);
// check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      echo "Only letters and white space allowed";
    }
}

if(!empty($r)){
$phone = test_input($r);
// check if phone no only contains letters and whitespace
    if (!preg_match("/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/",$phone)) {
      echo "Incorrect phone number format";
    }
}

if(!empty($ph)){
$phone = test_input($ph);
// check if phone no only contains letters and whitespace
    if (preg_match("/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/",$phone)) {
      echo 1;
    }
}

    function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>