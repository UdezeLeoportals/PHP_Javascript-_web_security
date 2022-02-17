<?php

require_once("./includes/initialize.php");


 echo add_header($session->username, $session->type);
?>
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<script type="text/javascript" src="scripts/validates.js"></script>
<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
<link rel="stylesheet" href="styles/update_styles.css" type="text/css" /> 

<style>
    .stripeEven a:visited {
            color:red;
        }
        .stripeEven a:active {
            color:blue;
        }
        #syn {
    top: 360px;
    background-color: #f44336;
}
</style>
<?php
 $a = empty($_GET['leo']) ? 1: $_GET['leo'];
?>

<div id="mySidenav" class="sidenav2">
	 <a  id="scholars" href="synopsis.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Back</a>
	  <a id="syn" ><span style="font-size:20px;cursor:pointer" onclick="openNav()">&nbsp;&nbsp; Book&nbsp;Synopsis</span></a>
</div>
<div style="margin-left:80px; min-height: 750px; overflow: auto; " id="main">
<table style="float: left; width:10%;"></table>
<table style="float: left; width:85%;">
    <?php
        if($a==2){
            // 1. the current page number ($current_page)
            $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
            // 2. records per page ($per_page)
            $per_page = 1;
            $total_count = 21;
            $pagination = new Pagination($page, $per_page, $total_count);
            echo "<h3>CONCLUSION: <b>THE COMPUTER NETWORK AND FAITH</b> - Page ".$page."</h3>";
            $concludes = Networkoffaith::find_conclude($per_page, $pagination->offset());
            foreach($concludes as $conclude){
                echo '<tr class="stripeOdd"><td>'.$conclude->content.'</td></tr>';
            }
        echo '<tr class="stripeEven" ><td>';
        if($pagination->total_pages() > 1) {
		//echo '<b><a href="class_view.php" title="back"><img src="images/back.png" width=30 height=30 /></a><center>';
		if($pagination->has_previous_page()) { 
    	echo "<a href=\"synopsis.php?leo=2&page=";
      echo $pagination->previous_page();
      echo "\">&laquo; Previous</a> "; 
    }

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo " <span class=\"selected\">{$i}</span> ";
			} else {
				echo " <a href=\"synopsis.php?leo=2&page={$i}\">{$i}</a> "; 
			}
		}

		if($pagination->has_next_page()) { 
			echo " <a href=\"synopsis.php?leo=2&page=";
			echo $pagination->next_page();
			echo "\">Next &raquo;</a></b></center> "; 
    }
		
	}
        echo '</td></tr>';
    }
    
    if($a==1){
    ?>
    <center><h2>THE NETWORK OF FAITH - <i>Perspectives on achieving change in the negritude of Africa</i></h2>
    <br> <h2>by UDEZE LEO CHINEDU</h2></center>
    
<!--<p>Change image every 2 seconds:</p>
-->
<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="images/NOF_front.jpg" style="width:100%">
  <div class="text">Front Cover</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="images/profiles/204083COVID_Backgd2.jpg" style="width:100%">
  <div class="text">STOP COVID-19</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="images/profiles/262874NCDC_today.jpg" style="width:100%">
  <div class="text">COVID-19 Nigeria</div>
</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>
    <?php } ?>
</table>
<table style="float: right; width:5%;"></table>
<div id="mySidenav2" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <span id="view" style="font-size:23px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">FORWARD</span><a></a>
  <span id="view" style="font-size:18px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">ACKNOWLEDGEMENTS</span><a></a>
  <span id="view" style="font-size:23px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">PREFACE</span><a></a>
  <span id="view" style="font-size:18px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">TABLE OF CONTENTS</span><a></a>
  <span id="view" style="font-size:23px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">PREAMBLES</span><a></a>
  <span id="view" style="font-size:23px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">ABOUT</span><a></a>
 <!-- <span id="view" style="font-size:23px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">COMMENTS</span><a></a>-->
    <span id="view" style="font-size:23px;cursor:pointer; background-color: #4CAF50;
    color: white;" ><a href="synopsis.php?leo=2">CONCLUSION</a></span><a></a>
  <span id="bookspan"></span>
  <!--<a href="#">Services</a>-->
  <!--<a href="#">Clients</a>-->
  <!--<a href="#">Contact</a>-->
</div>

</div>
<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav1()">&times;</a>
  
  <div class="overlay-content">
 
    <form>
   <input type="hidden" id="a" value="<?php echo $a; ?>" />
   <select id="topics" onchange="loadforward()"><option value="">--Choose Section--</option>
    <option value="1">FORWARD</option>
    <option value="2">ACKNOWLEDGEMENTS</option>
    <option value="3">PREFACE</option>
    <option value="4">TABLE OF CONTENTS</option>
    <option value="5">PREAMBLES</option>
    <option value="6">ABOUT</option>
   </select>
   <select id="chaps" onchange="loadforward()"><option value=""></option>
    
   </select>
    </form>
    <span id="commentaryspan"> </span>
    <!--<a href="#">Services</a>-->
    <!--<a href="#">Clients</a>-->
    <!--<a href="#">Contact</a>-->
   
  </div>
</div>
<?php
   // if($a==1) echo '<script> var slideIndex = 0; showSlides();</script>';
?>
<script>
function openNav() {
    document.getElementById("mySidenav2").style.width = "250px";
    document.getElementById("mySidenav2").style.display = 'block';
    
}

function closeNav() {
    document.getElementById("mySidenav2").style.width = "0";
    document.getElementById("mySidenav2").style.display = 'none';
}
function openNav1() {
    document.getElementById("myNav").style.height = "100%";
    document.getElementById("myNav").style.display = 'block';
}

function closeNav1() {
    document.getElementById("myNav").style.height = "0%";
    document.getElementById("myNav").style.display = 'none';
}
/*var slideIndex = 0; */

var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex> slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 7000); // Change image every 2 seconds
}
</script>
<?php echo footer(); ?>
