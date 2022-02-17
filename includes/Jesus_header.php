<?php 
//Page headers
function add_header($username, $type){
    	
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\' https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js \'unsafe-inline\'; style-src \'self\' https://www.w3schools.com/w3css/4/w3.css https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css \'unsafe-inline\' ;connect-src \'self\'; img-src \'self\' \'unsafe-inline\' data:;  font-src \'self\' ; frame-src \'self\' ; frame-ancestors \'self\'; report-uri /csp_report.php');
header("Expect-CT: enforce; max-age=30; report-uri='https://www.adonaibaibul.com.report-uri.io/r/default/ct/enforce'");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr"  xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head profile="http://www.w3.org/2005/10/profile">
<title>Thesis Domain UWE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="imagetoolbar" content="no" />
<meta property="og:image" content="http://adonaibaibul.com/images/leologo.jpg">
<meta property="og:image:type" content="image/jpg">
<meta property="og:type" content="business">
 <meta property="og:url" content="http://ladonaibaibul.com/">
  <meta property="og:site_name" content="Leoportals Network">
   <meta property="og:title" content="UWE Cybersecurity project domain">
    <meta property="og:description" content="A vulnerability testing artefact...">
<meta property="og:image:width" content="315">
<meta property="og:image:height" content="110">
<link rel="icon" 
      type="image/png" 
      href="http://adonaibaibul.com/favicon.ico">
      <link rel="shortcut icon" href="http://adonaibaibul.com/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="styles/layout.css" type="text/css" />

<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" media="all"/> 

<style type="text/css">
.span1 {
  text-align: center;
  font-size: 12px;
  color: black;
}
  html, body, #bg, #bg table, #bg td{
     height: auto;
     width: auto;
     overflow: auto;
    }
    html, body{
     overflow: auto;
     background: url(images/uweLogo3.jpg) ;
      background-size: cover;
    }
       body,html {
    width: 100vw;
    height: 100vh;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
// Update the time every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date();
   // var t = now.split('(');
    // Output the result in an element with id="demo"
    document.getElementById("demol").innerHTML = now.toLocaleString();
   
}, 1000);
</script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.slidepanel.setup.js"></script>
<script type="text/javascript" src="scripts/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="scripts/jquery.tabs.setup.js"></script>
<script type="text/javascript" src="scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="scripts/script.js"></script>
<script type="text/javascript" src="scripts/js/chat.js"></script>
<script type="text/javascript" src="scripts/js/jquery.js"></script>
</head>
<body style=" overflow: scroll;  
          overflow: auto;
           background: url(images/uweLogo3.jpg) ;
            background-size: cover;
          clear: both;">

<div class="wrapper col2" >
  <div id="topnav" style="height: auto;">
    <ul><center>
      <li class=""><a href="index.php">Home</a>
        <ul>
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
          <li class="last"><a href="#"></a></li>
        </ul>
      </li>
	  <?php 
	  if($type=="blogger"||$type=="admin"){
	  ?>
	  <li class="last"><a href="profiles.php">Profiles</a></li>
	  <li class="last">&nbsp;<a class="tablinks" onclick="openCity(event, 'Paris')">&#9776; menu</a></li>
	   <?php
	  }
	  if($type=="admin") {
	      echo '<li class="last"><a href="administration.php">Admin Page</a></li>';
	      echo '<li class="last"><a href="cryptocards.php">Credit cards</a></li>';
	      echo '<li class="last"><a href="logging.php">LOG DETAILS</a></li>';
	  }
	     $surname = explode("@", $username);
	      if(!empty($username)){
	  ?>
	  <li class="last"><a href="./logout.php">Logout <?php echo " &nbsp; ".$surname[0]; ?></a></li>
	  <?php } ?>
	  <li class="last"><b id="demol" class="span1"></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
	  <li class="last">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
	  <li class="last"></a></li></center>
	<table style="background-color: #00AEFF;  " width=100% align="right" ><tr><form action="bible.php" method="POST" enctype="multipart/form-data"  onsubmit="return validsearch(this);">
		<input type="hidden" name="option" value="2" />
		<input type="hidden" name="id" value="3" />
		<td width=80%><input  type="text"  name="search_field" id="search_field" class="field2" placeholder="Search the KJV Bible..."/>
		</td><td><button type="submit" name="search" style="width:auto;" onclick="return validsearch();" value="Search">Search</button>
		</td></tr></form></table> 
    </ul>
  </div>
</div>
<div id="Paris" class="tabcontent" style="background-color: #345678;">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
<!--  <h3>Paris</h3>
  <p>Paris is the capital of France.</p>-->
  <center><table>
    <tr>
      <th><a href="view_updates.php?leo=3">Catholic Mass Readings</a></th>
      <th><a href="view_updates.php?leo=2">Charity & Scholarships</a></th>
      <th><a href="view_updates.php?leo=1">Church Commentary</a></th>
      <th><a href="view_updates.php?leo=4">Live of Saints</a></th>
      <th><a href="view_updates.php?leo=5">Christian Devotionals</a></th>
    </tr>
    <tr>
      <!--  <td><a href="synopsis.php">Documentation: The Network of Faith</a></td> -->
     <?php //if(!empty($type)){ ?>   <!--<td><a href="JESUS_CHRIST_upld_pdf.php">Upload Word of God</a></td> --><?php // } ?>
        <td><a href="JESUS_CHRIST_Divina.php">View Word of God</a></td>
    </tr>
  </table></center>

</div>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
var modal3 = document.getElementById('Paris');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
}
function validsearch(){
    var searchformat = /^[\w,;'"\s\.?!-]+$/;
    var field = document.getElementById('search_field');
    if(field.value.match(searchformat)) return true; 
    else return false;
}
</script>
<div id="main_container"  style=" height: 100%; width:100%;  clear: both; color: #c6c2bb; overflow: auto; 
          overflow: auto;
           background: url(images/uweLogo4.jpg)  ;  background-size: cover;">
<?php } 

function vuln_header($username, $type){
    	
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header('Content-Security-Policy: default-src \'self\'; script-src \'self\' https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js \'unsafe-inline\'; style-src \'self\' https://www.w3schools.com/w3css/4/w3.css https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css \'unsafe-inline\' ;connect-src \'self\'; img-src \'self\' \'unsafe-inline\' data:;  font-src \'self\' ; frame-src \'self\' ; frame-ancestors \'self\'; report-uri /csp_report.php');
header("Expect-CT: enforce; max-age=30; report-uri='https://www.adonaibaibul.com.report-uri.io/r/default/ct/enforce'");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr"  xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head profile="http://www.w3.org/2005/10/profile">
<title>Thesis Domain UWE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="imagetoolbar" content="no" />
<meta property="og:image" content="http://adonaibaibul.com/images/leologo.jpg">
<meta property="og:image:type" content="image/jpg">
<meta property="og:type" content="business">
 <meta property="og:url" content="http://ladonaibaibul.com/">
  <meta property="og:site_name" content="Leoportals Network">
   <meta property="og:title" content="UWE Cybersecurity project domain">
    <meta property="og:description" content="A vulnerability testing artefact...">
<meta property="og:image:width" content="315">
<meta property="og:image:height" content="110">
<link rel="icon" 
      type="image/png" 
      href="http://adonaibaibul.com/favicon.ico">
      <link rel="shortcut icon" href="http://adonaibaibul.com/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="styles/layout.css" type="text/css" />

<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" media="all"/> 

<style type="text/css">
.span1 {
  text-align: center;
  font-size: 12px;
  color: black;
}
  html, body, #bg, #bg table, #bg td{
     height: auto;
     width: auto;
     overflow: auto;
    }
    html, body{
     overflow: auto;
     background: url(images/uweLogo3.jpg) ;
      background-size: cover;
    }
       body,html {
    width: 100vw;
    height: 100vh;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
// Update the time every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date();
   // var t = now.split('(');
    // Output the result in an element with id="demo"
    document.getElementById("demol").innerHTML = now.toLocaleString();
   
}, 1000);
</script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.slidepanel.setup.js"></script>
<script type="text/javascript" src="scripts/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="scripts/jquery.tabs.setup.js"></script>
<script type="text/javascript" src="scripts/jquery.simplemodal.js"></script>
<script type="text/javascript" src="scripts/script.js"></script>
<script type="text/javascript" src="scripts/js/chat.js"></script>
<script type="text/javascript" src="scripts/js/jquery.js"></script>
</head>
<body style=" overflow: scroll;  
          overflow: auto;
           background: url(images/uweLogo3.jpg) ;
            background-size: cover;
          clear: both;">

<div class="wrapper col2" >
  <div id="topnav" style="height: auto;">
    <ul><center>
      <li class=""><a href="indexv.php">Home</a>
        <ul>
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
          <li><a href="#"></a></li>
          <li class="last"><a href="#"></a></li>
        </ul>
      </li>
	  <?php 
	  if($type=="blogger"||$type=="admin"){
	  ?>
	  <li class="last"><a href="profilesv.php">Profiles</a></li>
	  <li class="last">&nbsp;<a class="tablinks" onclick="openCity(event, 'Paris')">&#9776; menu</a></li>
	   <?php
	  }
	  if($type=="admin") {
	      //echo '<li class="last"><a href="administration.php">Admin Page</a></li>';
	      echo '<li class="last"><a href="cryptocards.php">Credit cards</a></li>';
	     // echo '<li class="last"><a href="logging.php">LOG DETAILS</a></li>';
	  }
	     $surname = explode("@", $username);
	      if(!empty($username)){
	  ?>
	  <li class="last"><a href="./logout.php">Logout <?php echo " &nbsp; ".$surname[0]; ?></a></li>
	  <?php } ?>
	  <li class="last"><b id="demol" class="span1"></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
	  <li class="last">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
	  <li class="last"></a></li></center>
	<table style="background-color: #00AEFF;  " width=100% align="right" ><tr><form action="biblev.php" method="POST" enctype="multipart/form-data"  onsubmit="return validsearch(this);">
		<input type="hidden" name="option" value="2" />
		<input type="hidden" name="id" value="3" />
		<td width=80%><input  type="text"  name="search_field" id="search_field" class="field2" placeholder="Search the KJV Bible..."/>
		</td><td><button type="submit" name="search" style="width:auto;"  value="Search">Search</button>
		</td></tr></form></table> 
    </ul>
  </div>
</div>
<div id="Paris" class="tabcontent" style="background-color: #345678;">
  <span onclick="this.parentElement.style.display='none'" class="topright">x</span>
<!--  <h3>Paris</h3>
  <p>Paris is the capital of France.</p>-->
  <center><table>
    <tr>
      <th><a href="view_updates.php?leo=3">Catholic Mass Readings</a></th>
      <th><a href="view_updates.php?leo=2">Charity & Scholarships</a></th>
      <th><a href="view_updates.php?leo=1">Church Commentary</a></th>
      <th><a href="view_updates.php?leo=4">Live of Saints</a></th>
      <th><a href="view_updates.php?leo=5">Christian Devotionals</a></th>
    </tr>
    <tr>
      <!--  <td><a href="synopsis.php">Documentation: The Network of Faith</a></td> -->
     <?php //if(!empty($type)){ ?>   <!--<td><a href="JESUS_CHRIST_upld_pdf.php">Upload Word of God</a></td> --><?php // } ?>
        <td><a href="JESUS_CHRIST_Divina.php">View Word of God</a></td>
    </tr>
  </table></center>

</div>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
var modal3 = document.getElementById('Paris');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
}

</script>
<div id="main_container"  style=" height: 100%; width:100%;  clear: both; color: #c6c2bb; overflow: auto; 
          overflow: auto;
           background: url(images/uweLogo4.jpg)  ;  background-size: cover;">

<?php  } ?>