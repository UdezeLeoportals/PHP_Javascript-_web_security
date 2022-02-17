<?php

require_once("./includes/initialize.php");

 echo add_header($session->username, $session->type);
 
?>
<?php
   $a = empty($_GET['leo'])? 0 : $_GET['leo'];
$a = empty($_POST['leo'])? $a : $_POST['leo'];
?>
<script type="text/javascript" src="scripts/updater.js"></script>

<script type="text/javascript" src="scripts/validates.js"></script>
<script type="text/javascript" src="scripts/biblical.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
<link rel="stylesheet" href="styles/update_styles.css" type="text/css" /> 


<div id="mySidenav" class="sidenav2">
  <a href="view_updates.php?leo=3" id="news">Catholic Mass Readings</a><br>
  <a href="view_updates.php?leo=2" id="scholars">Charity & Scholarships</a>
  <a href="view_updates.php?leo=1" id="jobs">Church Commentary</a>
  <a href="view_updates.php?leo=4" id="campus">Live of Saints</a>
  <a href="view_updates.php?leo=5" id="devotion">Christian Devotionals</a>
</div>

<div style="margin-left:80px; min-height: 750px; overflow: auto; " >
    <table style="width: 92%; float: right;">
<!--  <tr><td><h2>Hoverable Sidenav Buttons</h2></td></tr>
  <tr><td><p>Hover over the buttons in the left side navigation to open them.</p></td></tr>-->
  <?php
        if($a==1){
            $newsPosts = News::find_public();
            if(empty($newsPosts)){
                echo '<tr><td><h2>NO UPDATES YET</h2></td></tr>';
            }else{
               $n=1;
               echo '<tr class="stripeEven"><td ><h2>COMMENTARIES OF THE CHURCH </h2></td>';
               echo '<td><span id="view" style="font-size:25px;cursor:pointer; background-color: #4CAF50;
                            color: white;" onclick="openNav1()">&#9776; CLICK HERE TO VIEW DETAILS</span></td></tr>';
                foreach($newsPosts as $newsPost){
                    $commentmen = Biodata::find_by_id($newsPost->bio_id);
                    $fullname =""; $filese="images/profiles/"; $emaile=""; $phone ='';
                    foreach($commentmen as $commentman){
                        $fullname = $commentman->get_fullname($commentman->id);
                        $filese .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
                        $emaile = $commentman->email; 
                        $phone = $commentman->phone_no;
                    }
                    $files="";
                    $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
                    if($newsPost->filename!="null") $files = $newsPost->filename;
                    echo '<tr class="'.$cssdesign.'"><form>';
                    $timer = explode('+', $newsPost->datetime);
                   
                    echo '<td colspan=2>'.html_entity_decode(strtoupper($newsPost->topic));
                    
                  
                    
                   
                   
                    echo '</td>';
                    echo '<td><input type="hidden" id="postid" value='.$newsPost->id.' />';
                    echo '</td>';
                    echo "</form></tr>";
                    $n++;
                }
            }
        }elseif($a==2){
            $newsPosts = Scholars::find_public();
            if(empty($newsPosts)){
                echo '<tr><td><h2>NO NEW UPDATES YET</h2></td></tr>';
            }else{
               $n=1;
               echo '<tr class="stripeEven"><td ><h2>CHARITY AND SCHOLARSHIPS</h2></td>';
               echo '<td><span id="view" style="font-size:25px;cursor:pointer; background-color: #4CAF50;
                            color: white;" onclick="openNav1()">&#9776;  CLICK HERE TO VIEW DETAILS</span></td></tr>';
                foreach($newsPosts as $newsPost){
                     $commentmen = Biodata::find_by_id($newsPost->bio_id);
                    $fullname =""; $filese="images/profiles/"; $emaile=""; $phone ='';
                    foreach($commentmen as $commentman){
                        $fullname = $commentman->get_fullname($commentman->id);
                        $filese .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
                        $emaile = $commentman->email; 
                        $phone = $commentman->phone_no;
                    }
                    $files="";
                    $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
                    if($newsPost->filename!="null") $files = $newsPost->filename;
                    echo '<tr class="'.$cssdesign.'"><form>';
                    $timer = explode('+', $newsPost->datetime);
                    
                    echo '<td colspan=2>'.strtoupper($newsPost->topic);
                    echo '<br>';
                    echo '<b>';
                    
                  
                    echo '</td>';
                    echo '<td><input type="hidden" id="postid" value='.$newsPost->id.' />';
                    echo '</td>';
                    echo "</form></tr>";
                    $n++;
                }
            }
        }elseif($a==3){
            $newsPosts = Jobs::find_public();
            if(empty($newsPosts)){
                echo '<tr><td><h2>NO NEW UPDATES YET</h2></td></tr>';
            }else{
               $n=1;
               echo '<tr class="stripeEven"><td ><h2>CATHOLIC MASS READINGS</h2></td>';
               echo '<td><span id="view" style="font-size:25px;cursor:pointer; background-color: #4CAF50;
                            color: white;" onclick="openNav1()">&#9776;  CLICK HERE TO VIEW DETAILS</span></td></tr>';
                foreach($newsPosts as $newsPost){
                    $commentmen = Biodata::find_by_id($newsPost->bio_id);
                    $fullname =""; $filese="images/profiles/"; $emaile=""; $phone =''; $JESUS_CHRIST_DAY='';
                    foreach($commentmen as $commentman){
                        $fullname = $commentman->get_fullname($commentman->id);
                        $filese .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
                        $emaile = $commentman->email; 
                        $phone = $commentman->phone_no;
                        
                    }
                    $files="";
                    $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
                    if($newsPost->filename!="null") $files = $newsPost->filename;
                    echo '<tr class="'.$cssdesign.'"><form>';
                    $timer = explode('+', $newsPost->datetime);
                   
                    echo '<td colspan=2><b>'.strtoupper($newsPost->topic);
           
                    echo '</b><br>Daily Holy Mass Bible Reading for '.$newsPost->deadline.'<br>';
                  
                    echo '</td>';
                    echo '<td><input type="hidden" id="postid" value='.$newsPost->id.' />';
                    echo '</td>';
                    echo "</form></tr>";
                    $n++;
                }
            }
        }elseif($a==4){
            $newsPosts = Campus::find_public();
            if(empty($newsPosts)){
                echo '<tr><td><h2>NO NEW UPDATES YET</h2></td></tr>';
            }else{
               $n=1;
               echo '<tr class="stripeEven"><td ><h2>LIVE OF THE SAINTS</h2></td>';
               echo '<td><span id="view" style="font-size:25px;cursor:pointer; background-color: #4CAF50;
                            color: white;" onclick="openNav1()">&#9776; CLICK HERE TO VIEW DETAILS</span></td></tr>';
                foreach($newsPosts as $newsPost){
                    $commentmen = Biodata::find_by_id($newsPost->bio_id);
                    $fullname =""; $filese="images/profiles/"; $emaile=""; $phone ='';
                    foreach($commentmen as $commentman){
                        $fullname = $commentman->get_fullname($commentman->id);
                        $filese .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
                        $emaile = $commentman->email; 
                        $phone = $commentman->phone_no;
                    }
                    $files="";
                    $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
                    if($newsPost->filename!="null") $files = $newsPost->filename;
                    echo '<tr class="'.$cssdesign.'"><form>';
                    $timer = explode('+', $newsPost->datetime);
                  
                    echo '<td colspan=2>'.strtoupper($newsPost->topic);
               
                   
                    echo '</td>';
                    echo '<td><input type="hidden" id="postid" value='.$newsPost->id.' />';
                    echo '</td>';
                    echo "</form></tr>";
                    $n++;
                }
            }
        }elseif($a==5){
            $newsPosts = Devotionals::find_public();
            if(empty($newsPosts)){
                echo '<tr><td><h2>NO NEW UPDATES YET</h2></td></tr>';
            }else{
               $n=1;
               echo '<tr class="stripeEven"><td ><h2>CHRISTIAN DEVOTIONALS</h2></td>';
               echo '<td><span id="view" style="font-size:25px;cursor:pointer; background-color: #4CAF50;
                            color: white;" onclick="openNav1()">&#9776; CLICK HERE TO VIEW DETAILS</span></td></tr>';
                foreach($newsPosts as $newsPost){
                    $commentmen = Biodata::find_by_id($newsPost->bio_id);
                    $fullname =""; $filese="images/profiles/"; $emaile=""; $phone ='';
                    foreach($commentmen as $commentman){
                        $fullname = $commentman->get_fullname($commentman->id);
                        $filese .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
                        $emaile = $commentman->email; 
                        $phone = $commentman->phone_no;
                    }
                    $files="";
                    $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
                    if($newsPost->filename!="null") $files = $newsPost->filename;
                    echo '<tr class="'.$cssdesign.'"><form>';
                    $timer = explode('+', $newsPost->datetime);
                   
                    echo '<td colspan=2>'.strtoupper($newsPost->topic);
                 
                
                
                    echo '</td>';
                    echo '<td><input type="hidden" id="postid" value='.$newsPost->id.' />';
                    echo '</td>';
                    echo "</form></tr>";
                    $n++;
                }
            }
        }
  ?>
    </table>
</div>
<!-- REPLACE
1: NEWS with CATHOLIC CHURCH MASS READINGS

3: JOB with CHURCH COMMENTARY
4: CAMPUS with LIVE OF SAINTS
-->
<div id="myNav" class="overlay" >
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav1()">&times;</a>
  
  <div class="overlay-content">
   <form id="form" enctype="multipart/form-data" action="newsresponse.php" method="post">
   <input type="hidden" id="a" name="a" value="<?php echo $a; ?>" />
   <input type="hidden" id="r" name="r" value="2" />
   <select id="topics" name="topics" onchange="loadNewsDetails()"><option value="" >--Choose Topic--</option><?php
      if($a==1){
         $newsPosts = News::find_public();
         foreach($newsPosts as $newse){
            echo '<option value="'.$newse->id.'">'.html_entity_decode(strtoupper($newse->topic)).'</option>';
         }
      }elseif($a==2){
         $newsPosts = Scholars::find_public();
         foreach($newsPosts as $newse){
            echo '<option value="'.$newse->id.'">'.html_entity_decode(strtoupper($newse->topic)).'</option>';
         }
      }elseif($a==3){
         $newsPosts = Jobs::find_public();
         foreach($newsPosts as $newse){
            echo '<option value="'.$newse->id.'">'.html_entity_decode(strtoupper($newse->topic)).'</option>';
         }                 
      }elseif($a==4){
         $newsPosts = Campus::find_public();
         foreach($newsPosts as $newse){
            echo '<option value="'.$newse->id.'">'.html_entity_decode(strtoupper($newse->topic)).'</option>';
         }    
      }elseif($a==5){
         $newsPosts = Devotionals::find_public();
         foreach($newsPosts as $newse){
            echo '<option value="'.$newse->id.'">'.html_entity_decode(strtoupper($newse->topic)).'</option>';
         }    
      }
      ?>
   </select>
    <!--<a href="#"><button onclick="" style="width:auto;">LOAD DETAILS</button></a>-->
    <span id="commentaryspan" style="white-space: pre-wrap;"> </span>
    <!--<a href="#">Services</a>-->
    <!--<a href="#">Clients</a>-->
    <!--<a href="#">Contact</a>-->
    <div id="myDIV" style="white-space: pre-wrap;">
   

   <div id="formdiv" style="white-space: pre-wrap;">
     
         <span id="respondspan" style="white-space: pre-wrap;"></span>
         <input type="hidden" id="userid" name="userid" value="<?php echo $session->user_id; ?>" />
         <input type="text" placeholder="write a response" id="comment" name="comment"/>
         <input class="button" type="submit" value="Submit"><br>
        
        <center><span id="succeed"></span></center>
         
      </form>
   </div>
   </div>
   
  <!-- <center><button onclick="toggler()" style="display: none;" id="resp">VIEW RESPONSES</button></center> -->
  </div>
</div>
<script>
// Update the time every 1 second
var f = setInterval(function() {
   loadingcomments(); 
}, 1000);
</script>
<script>

function toggler() {
    var x = document.getElementById('myDIV');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
    loadingcomments();
   // loadingform();
}
function openNav1() {
    document.getElementById("myNav").style.height = "100%";
    document.getElementById("myNav").style.display = 'block';
}

function closeNav1() {
    document.getElementById("myNav").style.height = "0%";
    document.getElementById("myNav").style.display = 'none';
}

// Get the modal
var modal = document.getElementById('myModal1');

// Get the button that opens the modal
//var btn = document.getElementById("commenter");
//
//// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close1")[0];
//
//// When the user clicks the button, open the modal 
//btn.onclick = function() {
//    var logstate = document.getElementById("logged").value;
//    if(logstate==false){
//        modal.style.display = "block";
//    }else{
//	 var nostring = document.getElementById("comment").value;
//	 if(nostring.length == 0){
//		document.getElementById("success").innerHTML = "Field is empty!";
//		return;
//	 }else{
//		  var xmlhttp = new XMLHttpRequest();
//		  xmlhttp.onreadystatechange = function() {
//		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//			  document.getElementById("success").innerHTML = xmlhttp.responseText;
//		      }
//		  };
//		  var commentr = document.getElementById("comment").value;
//		  var users = document.getElementById("identity").value;
//		  var chapter_id = document.getElementById("topic_id").value;
//		  xmlhttp.open("GET", "insertcommentary.php?p=" + commentr + "&q=" + users + "&r=" + chapter_id, true);
//		  xmlhttp.send();
//		  document.getElementById("comment").innerHTML = '';
//	 }
//    }
//}
$(document).ready(function (e) {
 $("#form").on('submit',(function(e) {
  e.preventDefault();
  
  $.ajax({
         url: "newsresponse.php",
   	   /*  xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                         $(".progress-bar").html(percentComplete + '%');
                        $(".message").html('<b style="color:red">Please wait a few seconds while the image successfully uploads</b>');
                    }
                }, false);
                return xhr;
            }, */
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   beforeSend : function()
   {
    //$("#preview").fadeOut();
    $("#succeed").fadeOut();
     //$(".progress-bar").width('0%');
              //  $('#uploadStatus').html('<img src="images/loading.gif"/>');
   },
   success: function(data)
      {
    if(data=='invalid')
    {
     // invalid file format.
     $("#succeed").html("Invalid Entry !").fadeIn();
    }
    else
    {
     // view uploaded file.
     $("#respondspan").html(data).fadeIn();
     $('input[type="text"],textarea').val('');
    }
      },
     error: function(e) 
      {
    $("#succeed").html(e).fadeIn();
      }          
    });
    
 }));
});

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<?php echo footer(); ?>
