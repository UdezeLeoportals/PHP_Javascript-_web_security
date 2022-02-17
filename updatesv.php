<?php

require_once("./includes/initialize.php");

 if (!$session->is_logged_in()) {
    die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/login.php';
</script>");

 }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd" >

<html>
<head>

<?php
 echo vuln_header($session->username, $session->type);
 ?>
<title>Leoportals Network</title>
<script type="text/javascript" src="scripts/updater.js"></script>
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<script type="text/javascript" src="scripts/validates.js"></script>
<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
<link rel="stylesheet" href="styles/update_styles.css" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<?php
$a = empty($_GET['a'])? 0 : $_GET['a'];
$a = empty($_POST['as'])? $a : $_POST['as'];
//attach image to a post

 ?>
<?php

    $biose ="";
    $namer="";
    $binge = Biodata::find_by_user_id($session->user_id);
    foreach($binge as $bing){
        $biose = $bing->id;
	$name = $bing->surname.' '.$bing->first_name;
    }
    $linker="";
    $max_file_size = 2048000;
    //SUBMIT CHURCH COMMENTARY 1 (NEWS TABLE)
if(isset($_POST['news_submit'])){
   // if(empty($_FILES['result']['name'])){
       $topic = test_input($_POST['topic']);
       if(!empty($_POST['linker'])) $linker = test_input($_POST['linker']);//SCRIPTURE REFERENCE
       $details = test_input($_POST['subject']);
       //create CHURCH COMMENTARY
       $latest = News::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
       $newser = new News();
       $newser->id = $lid;
       $newser->bio_id = $biose;
       $newser->topic = !empty($topic) ? $topic : "null";
       $newser->details = !empty($details) ? $details : "null";
       if(!empty($_POST['linker'])) $newser->linker = $linker;
       $newser->status = 'pending'; $newser->filename = "null";
       $newser->datetime = date(DateTime::RFC1123, gettime());
       if($newser->create()) echo '<center><H4>COMMENTARY SUCCESSFULLY SAVED</H4></center>';
       else echo '<center><H4>UNABLE TO SAVE COMMENTARY!!!</H4></center>';
    //}else
    /* 
   
	  */
}
//submit CHARITY MESSAGE
if(isset($_POST['submit_scholar'])){
    
       $topic = test_input($_POST['topic']);
       if(!empty($_POST['linker'])) $linker = test_input($_POST['linker']); // SOURCES
       $details = test_input($_POST['subject']);
       //create CHARITY MESSAGE
       $latest = Scholars::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
        $bio_id=0;
       $newser = new Scholars();
       $newser->id = $lid;
       $userz = Biodata::find_by_email($_POST['user_email']);
       foreach($userz as $us){
           $bio_id = $us->id;
       }
       $newser->bio_id = $bio_id;
       $newser->topic = !empty($topic) ? $topic : "null";
       $newser->details = !empty($details) ? $details : "null";
       if(!empty($_POST['linker'])) $newser->linker = $linker;
       $newser->status = 'pending';
       $newser->filename ="null";
       $newser->datetime = date(DateTime::RFC1123, gettime());
       if($newser->create()) echo '<center><H4 style="color:black">POST SUCCESSFULLY ADDED, WAITING YOUR APPROVAL FOR PUBLIC VIEW</H4></center>';
       else echo '<center><H4>UNABLE TO SAVE THE WORD OF GOD!!!</H4></center>';
    
}
//submit DAILY CATHOLIC CHURCH MASS READINGS TO JOBS TABLE
if(isset($_POST['submit_jobs'])){
      
       $topic = test_input($_POST['topic']); // GOSPEL TITLE
       if(!empty($_POST['linker'])) $linker = test_input($_POST['linker']);
       $details = test_input($_POST['subject']);
       //create mass reading
       $latest = Jobs::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
       $newser = new Jobs();
       $newser->id = $lid;
       $newser->bio_id = $biose;
       $newser->topic = !empty($topic) ? $topic : "null";
       $newser->details = !empty($details) ? $details : "null"; //BODY OF BIBLE READING
       $newser->employer = !empty(test_input($_POST['employ'])) ? test_input($_POST['employ']) : "null"; //LITURGICAL COLOR OF THE DAY
       $newser->location = !empty(test_input($_POST['address'])) ? test_input($_POST['address']) : "null"; //FEAST OR SAINT OF THE DAY
       $newser->deadline = !empty(test_input($_POST['deadl'])) ? test_input($_POST['deadl']) : "null"; //DATE OF READING
       if(!empty($_POST['linker'])) $newser->linker = $linker; //SCRIPTURE REFERENCES
       $newser->status = 'pending';
       $newser->filename = "null";
       $newser->datetime = date(DateTime::RFC1123, gettime());
    
       if($newser->create()) echo '<center><H4>WORD OF GOD SUCCESSFULLY ADDED, WAITING FOR YOUR APPROVAL FOR CHURCH VIEW</H4></center>';
       else echo '<center><h4>UNABLE TO SAVE THE WORD OF GOD!!!</h4></center>';
    
}
//submit LIFE OF SAINT TO CAMPUS TABLE
if(isset($_POST['campus_submit'])){
   
       $topic = test_input($_POST['topic']);
       if(!empty($_POST['linker'])) $linker = test_input($_POST['linker']); //DATE OF CHURCH COMMEMORATION
       $details = test_input($_POST['subject']);
       //create LIFE OF SAINT
       $latest = Campus::find_last();
            $lid=0;
            foreach($latest as $l){
                $lid = $l->id;
            }
            $lid++;
       $newser = new Campus();
       $newser->id = $lid;
       $newser->bio_id = $biose;
       $newser->topic = !empty($topic) ? $topic : "null";
       $newser->details = !empty($details) ? $details : "null";
       if(!empty($_POST['linker'])) $newser->linker = $linker;
       $newser->status = 'pending'; $newser->filename = "null";
       $newser->datetime = date(DateTime::RFC1123, gettime());
       if($newser->create()) echo '<center><H4>WORD OF GOD SUCCESSFULLY ADDED, WAITING FOR YOUR APPROVAL FOR CHURCH VIEW</H4></center>';
       else echo '<center><span>UNABLE TO SAVE THE WORD OF GOD!!!</span></center>';
    
}
//submit devotional post
if(isset($_POST['submit_devotion'])){
    
       $topic = test_input($_POST['topic']);
       if(!empty($_POST['linker'])) $linker = test_input($_POST['linker']);
       $details = test_input($_POST['subject']);
       
       $latest = Devotionals::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
       $newser = new Devotionals();
       $newser->id = $lid;
       $newser->bio_id = $biose;
       $newser->topic = !empty($topic) ? $topic : "null";
       $newser->details = !empty($details) ? $details : "null";
       $text ="";
       if(!empty($_POST['linker'])){
       $get_verses = Verses::find_a_verse($_POST['booke'], $_POST['chapterz'], $_POST['linker']);
       foreach($get_verses as $getv){
	    $text .= $getv->text;
       }
       $bkk = Books::find_by_id($_POST['booke']);
       $text .= '('.strtoupper($bkk->book).' '.$_POST['chapterz'].' : '.$_POST['linker'].')';
       $newser->linker = $text;
       }
       $newser->status = 'pending'; $newser->filename= "null";
       $newser->datetime = date(DateTime::RFC1123, gettime());
       if($newser->create()) echo '<center><H4>WORD OF GOD SUCCESSFULLY ADDED, WAITING FOR YOUR APPROVAL FOR CHURCH VIEW</H4></center>';
       else echo '<center><h4>UNABLE TO SAVE THE WORD OF GOD!!!</h4></center>';
    
}
?>
<?php
//approve and delete CHURCH COMMENTARY
if(isset($_POST['approver'])){
 News::change_status($_POST['newz'], "posted");
 echo '<H4>WORD OF GOD APPROVED FOR CHURCH ACCESS</H4>';
}
if(isset($_POST['deleter'])){
 $idx = News::find_by_id($_POST['newz']);
 if(News::destroy($_POST['newz'], $idx->filename))
  echo '<H4>WORD OF GOD REMOVED</H4>';
}
//approve and delete CHARITY MESSAGE
if(isset($_POST['approver2'])){
 Scholars::change_status($_POST['newz'], "posted");
 echo '<H4>WORD OF GOD APPROVED FOR CHURCH ACCESS</H4>';
}
if(isset($_POST['deleter2'])){
 $idx = Scholars::find_by_id($_POST['newz']);
 if(Scholars::destroy($_POST['newz'], $idx->filename))
 echo '<H4>WORD OF GOD REMOVED</H4>';
 
}
//approve and delete CHURCH MASS READING
if(isset($_POST['approver3'])){
 Jobs::change_status($_POST['newz'], "posted");
echo '<H4>WORD OF GOD APPROVED FOR CHURCH ACCESS</H4>';
}
if(isset($_POST['deleter3'])){
 $idx = Jobs::find_by_id($_POST['newz']);
 if(Jobs::destroy($_POST['newz'], $idx->filename))
  echo '<H4>WORD OF GOD REMOVED</H4>';
 
}
//approve and delete LIFE SAINT
if(isset($_POST['approver4'])){
 Campus::change_status($_POST['newz'], "posted");
 echo '<H4>WORD OF GOD APPROVED FOR CHURCH ACCESS</H4>';
}
if(isset($_POST['deleter4'])){
 $idx = Campus::find_by_id($_POST['newz']);
 if(Campus::destroy($_POST['newz'], $idx->filename))
   echo '<H4>WORD OF GOD REMOVED</H4>';
 
}
//approve and delete CHRISTIAN SCRIPTURAL devotionals
if(isset($_POST['approver5'])){
 Devotionals::change_status($_POST['newz'], "posted");
echo '<H4>WORD OF GOD APPROVED FOR CHURCH ACCESS</H4>';
}
if(isset($_POST['deleter5'])){
 $idx = Devotionals::find_by_id($_POST['newz']);
 if(Devotionals::destroy($_POST['newz'], $idx->filename))
 echo '<H4>WORD OF GOD REMOVED</H4>';
}
?>
<?php if($a==1){ ?>
<!-- FORM TO WRITE COMMENTARY  -->
<center><h3 style="color: black"> WRITE CATHOLIC CHURCH COMMENTARY</h3>
<button class="accordion" style="opacity: 0.9;width: 53vw">COMMENTARIES AWAITING APPROVAL</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
  <table style="width: 80%;">
    <?php
    $no=1;
    $pends = News::find_pending($biose);
    if(!empty($pends)){
    foreach($pends as $pend){
     echo "<form action=\"updates.php\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$pend->id."' />";
     echo "<td>".$no."<td>";
     echo "<td><b>".strtoupper($pend->topic)."</b></td>";
     echo "<td><button type='submit' name='approver' >APPROVE</button></td>";
     echo "<td><button type='submit' name='deleter' >DELETE</button></td>";
     $files="dummy.jpg";
     if($pend->filename!="null") $files = $pend->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $no++;
    }
    //echo "<tr><td></td><td colspan=4><span id='commenter' >ADD IMAGE</span></td></tr>";
    }else echo "<tr><td style=\"color: black\">NO PENDING WORD OF GOD FOR APROVAL!</td></tr>";
    ?>
    
  </table>
 
  </p>
</div>
<button class="accordion" style="opacity: 0.9;width: 53vw">SUBMITTED COMENTARIES</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
 <table style="width: 80%;">
  <?php
  $nos=1;
  $posts = News::find_posted($biose);
  if(!empty($posts)){
    foreach($posts as $post){
     echo "<form action=\"#\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$post->id."'>";
     echo "<td>".$nos."<td>";
     echo "<td><b>".strtoupper($post->topic)."</b></td>";
   
     echo "<td><button type='submit' name='deleter' >DELETE</button></td>";
     $files="";
     if($post->filename!="null") $files = $post->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $nos++;
    }
  }else echo "<tr><td style=\"color: black\">NO WORD OF GOD WRITEN BY YOU YET</td></tr>";
  ?>
 </table>
  </p>
</div>


<div class="container" style="overflow: scroll; opacity: 0.9;width: 50vw">
  <form action="updates.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
   <table style="width: 100%"> <tr><td class="four"><label for="fname" >NAME OF CHURCH FATHER OR DOCTOR <b style="color: red;">*</b></label></td>
   <td class="six"><input type="text" id="fname" name="topic" placeholder="NAME OF AUTHOR OF COMMENTARY..." ></td></tr>
<tr><td>
    <label for="lname">SCRIPTURE REFERENCES</label></td><td>
    <input type="text" id="lname" name="linker" placeholder="WHICH BIBLE PORTION WAS IT ABOUT..."></td></tr>

    <input type="hidden" name="as" value="1"/>
<tr><td>
    <label for="subject">DETAILS</label><br><span id="wordcount" style="font-size: 12px; color: blue"></span></td><td>
    <textarea id="subject" name="subject" onkeyup="countwords(this.value)" placeholder="DETAILS OF COMMENTARY..." style="height:200px" ></textarea></td>
</tr><!--<tr><td>
    <label for="subject">Upload multiple news in .xls file (Max: 3.5 M.B.)</label></td><td>
    <input type="file" name="result" /></td></tr>--><tr><td>
    <label for="lname">Submitted by:</label></td><td>
   
    <span><?php echo strtoupper($namer).' ('.$session->username.')'; ?></span></td></tr>
    <tr><td colspan=2><center>
    <input type="submit" value="Submit" name="news_submit"></center></td></tr></table>
  </form>
</div></center>
<?php }
elseif($a==2){
?>
<!-- FORM TO WRITE CHARITY AND SCHOLARSHIP  -->
<center><h3 style="color:black">Posted News</h3>
<button class="accordion" style="opacity: 0.9;width: 53vw;">Unapproved Posts</button>
<div class="panel" style="opacity: 0.9;width: 50vw;">
  <p>
  <table style="width: 80%;">
    <?php
    $no=1;
    $pends = Scholars::find_pending($biose);
    if(!empty($pends)){
    foreach($pends as $pend){
     echo "<form action=\"updates.php\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$pend->id."' />";
     echo "<td>".$no."<td>";
     echo "<td><b>".strtoupper($pend->topic)."</b></td>";
     echo "<td><button type='submit' name='approver2' >APPROVE</button></td>";
     echo "<td><button type='submit' name='deleter2' >DELETE</button></td>";
     $files="dummy.jpg";
     if($pend->filename!="null") $files = $pend->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $no++;
    }
    //echo "<tr><td></td><td colspan=4><span id='commenter' >ADD IMAGE</span></td></tr>";
    }else echo "<tr><td>No pending posts awaiting approval</td></tr>";
    ?>
    
  </table>
 
  </p>
</div>
<button class="accordion" style="opacity: 0.9;width: 53vw">Approved Posts</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
 <table style="width: 80%;">
  <?php
  $nos=1;
  $posts = Scholars::find_posted($biose);
  if(!empty($posts)){
    foreach($posts as $post){
     echo "<form action=\"#\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$post->id."'>";
     echo "<td>".$nos."<td>";
     echo "<td><b>".strtoupper($post->topic)."</b></td>";
    // echo "<td><button type='submit' name='edit2' >EDIT</button></td>";
    // echo "<td><button type='submit' name='changer2' >CHANGE IMAGE</button></td>";
     echo "<td><button type='submit' name='deleter2' >DELETE</button></td>";
     $files="";
     if($post->filename!="null") $files = $post->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $nos++;
    }
  }else echo "<tr><td>NO public posts yet</td></tr>";
  ?>
 </table>
  </p>
</div>

<div class="container" style="overflow: scroll; opacity: 0.9; width: 50vw">
  <form action="updatesv.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
   <table style="width: 100%"> <tr><td class="four"><label for="fname" >TOPIC<b style="color: red;">*</b></label></td>
   <td class="six"><input type="text" id="fname" name="topic" placeholder="Title of the message..." ></td></tr>
<tr><td>
    <label for="lname">SOURCE</label></td><td>
    <input type="text" id="lname" name="linker" placeholder="SOURCE ..."></td></tr>

    <input type="hidden" name="as" value="2"/>
    <input type="hidden" name="user_email" value="<?php echo $session->username; ?>"/>
<tr><td>
    <label for="subject">DETAILS</label><span id="wordcount" style="font-size: 12px; color: blue"></span></td><td>
    <textarea id="subject" name="subject" onkeyup="countwords(this.value)" placeholder="Write details" style="height:200px" ></textarea></td>
</tr><!--<tr><td>
    <label for="subject">Upload multiple news in .xls file (Max: 3.5 M.B.)</label></td><td>
    <input type="file" name="result" /></td></tr>--><tr><td>
    <label for="lname">Submitted by:</label></td><td>
    <span style="color:black"><?php echo strtoupper($namer).' ('.$session->username.')'; ?></span></td></tr>
    <tr><td colspan=2><center>
    <input type="submit" value="Submit" name="submit_scholar"></center></td></tr></table>
  </form>
</div></center>
<?php }
elseif($a==3){
?>

<center><h3 style="color: black"> WRITE CATHOLIC CHURCH DAILY MASS READINGS</h3><!-- FORM TO WRITE CHURCH COMMENTARY  -->
<button class="accordion" style="color: black; opacity: 0.9;width: 53vw">MASS READINGS TO BE APPROVED</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
  <table style="width: 80%; opacity: 0.9;">
    <?php
    $no=1;
    $pends = Jobs::find_pending($biose); //SAVED IN JOBS TABLE
    if(!empty($pends)){
    foreach($pends as $pend){
     echo "<form action=\"updates.php\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$pend->id."' />";
     echo "<td>".$no."<td>";
     echo "<td><b>".strtoupper($pend->topic)."</b></td>";
     echo "<td><button type='submit' name='approver3' >APPROVE</button></td>";
     echo "<td><button type='submit' name='deleter3' >DELETE</button></td>";
     $files="dummy.jpg";
     if($pend->filename!="null") $files = $pend->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $no++;
    }
    //echo "<tr><td></td><td colspan=4><span id='commenter' >ADD IMAGE</span></td></tr>";
    }else echo "<tr><td style=\"color: black\">NO MASS READING TO BE APPROVED BY YOU!</td></tr>";
    ?>
    
  </table>
 
  </p>
</div>
<button class="accordion" style="color: black; opacity: 0.8;width: 53vw">APPROVED MASS READINGS</button><!-- AREA TO VIEW CHURCH COMMENTARY  -->
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
 <table style="width: 80%; opacity: 0.9;">
  <?php
  $nos=1;
  $posts = Jobs::find_posted($biose);
  if(!empty($posts)){
    foreach($posts as $post){
     echo "<form action=\"#\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$post->id."'>";
     echo "<td>".$nos."<td>";
     echo "<td><b>".strtoupper($post->topic)."</b></td>";
     
     echo "<td><button type='submit' name='deleter3' >DELETE</button></td>";
     $files="";
     if($post->filename!="null") $files = $post->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $nos++;
    }
  }else echo "<tr><td style=\"color: black\">NO MASS READING WRITTEN YET BY YOU</td></tr>";
  ?>
 </table>
  </p>
</div>

<!-- FORM TO WRITE CATHOLIC CHURCH MASS READINGS  -->
<div class="container" style="overflow: scroll; opacity: 0.9;width: 50vw">
  <form action="updates.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
   <table style="width: 95%; opacity: 0.9;"> <tr><td class="four"><label for="fname" >GOSPEL TITLE<b style="color: red;">*</b></label></td>
   <td class="six"><input type="text" id="fname" name="topic" placeholder="TITLE OF THE GOSPEL OF THE DAY..." </td></tr>
<tr><td>
    <label for="lname">SCRIPTURAL READINGS: <b style="color: red;">*</b></label></td><td>
    <input type="text" id="lname" name="linker" placeholder="BIBLE QUOTATIONS OF ALL THE READINGS..."></td></tr>
    <tr><td>
    <label for="lname">LITURGICAL COLOR <b style="color: red;">*</b></label></td><td>
    <input type="text" id="lname" name="employ" placeholder="LITURGICAL COLOR OF THE DAY..." ></td></tr>
<tr><td>
    <label for="lname">DATE OF READING:<b style="color: red;">*</b></label></td><td>
    <input type="text" id="lname" name="deadl" placeholder="DATE ON BOTH CHURCH CALENDAR AND REGULAR ..."></td></tr>
    <tr><td>
    <label for="lname">FEAST/SAINT OF THE DAY</label></td><td>
    <input type="text" id="lname" name="address" placeholder="FEAST OR SAINT OF THE DAY..." ></td></tr>
  
    <input type="hidden" name="as" value="3"/>
<tr><td>
    <label for="subject">DETAILS: <b style="color: red;">*</b></label> <span id="wordcount" style="font-size: 12px; color: blue"></span></td><td>
    <textarea id="subject" name="subject" onkeyup="countwords(this.value)" placeholder="WRITE THE BODY OF THE ENTIRE READINGS..." style="height:200px" ></textarea></td>
</tr><!--<tr><td>
    <label for="subject">Upload multiple jobs in .xls file (Max: 3.5 M.B.)</label></td><td>
    <input type="file" name="result" /></td></tr>--><tr><td>
    <label for="lname">Submitted by:</label></td><td>
    
    <span><?php echo strtoupper($namer).' ('.$session->username.')'; ?></td></tr>
    <tr><td colspan=2><center>
    <input type="submit" value="Submit" name="submit_jobs"></center></td></tr></table>
  </form>
</div></center>

<?php }
elseif($a==4){
?>
<!-- FORM TO WRITE LIFE OF SAINT  -->
<center><h3 style="color: black"> WRITE LIFE OF SAINT</h3>
<button class="accordion" style="opacity: 0.9;width: 53vw">Pending LIFE OF SAINT</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
  <table style="width: 80%;opacity: 0.9;">
    <?php
    $no=1;
    $pends = Campus::find_pending($biose); // SAVE TO CAMPUS TABLE
    if(!empty($pends)){
    foreach($pends as $pend){
     echo "<form action=\"updates.php\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$pend->id."' />";
     echo "<td>".$no."<td>";
     echo "<td><b>".strtoupper($pend->topic)."</b></td>";
     echo "<td><button type='submit' name='approver4' >APPROVE</button></td>";
     echo "<td><button type='submit' name='deleter4' >DELETE</button></td>";
     $files="dummy.jpg";
     if($pend->filename!="null") $files = $pend->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $no++;
    }
    //echo "<tr><td></td><td colspan=4><span id='commenter' >ADD IMAGE</span></td></tr>";
    }else echo "<tr><td>NO PENDING LIFE OF SAINT!</td></tr>";
    ?>
    
  </table>
 
  </p>
</div>
<button class="accordion" style="opacity: 0.9;width: 53vw">WRITTEN LIFE OF SAINT</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
 <table style="width: 80%;">
  <?php
  $nos=1;
  $posts = Campus::find_posted($biose);
  if(!empty($posts)){
    foreach($posts as $post){
     echo "<form action=\"#\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$post->id."'>";
     echo "<td>".$nos."<td>";
     echo "<td><b>".strtoupper($post->topic)."</b></td>";
     
     echo "<td><button type='submit' name='deleter4' >DELETE</button></td>";
     $files="";
     if($post->filename!="null") $files = $post->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $nos++;
    }
  }else echo "<tr><td>NO LIFE OF SAINT WRITTEN YET BY YOU</td></tr>";
  ?>
 </table>
  </p>
</div>

<div class="container" style="overflow: scroll; opacity: 0.9;width: 50vw">
  <form action="updates.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
   <table style="width: 100%;opacity: 0.9;"> <tr><td class="four"><label for="fname" >NAME OF SAINT<b style="color: red;">*</b></label></td>
   <td class="six"><input type="text" id="fname" name="topic" placeholder="NAME OF SAINT..." ></td></tr>
<tr><td>
    <label for="lname">DATE OF CHURCH COMMEMORATION</label></td><td>
    <input type="text" id="lname" name="linker" placeholder="DATE ON CHURCH CALENDAR..."></td></tr>

    <input type="hidden" name="as" value="4"/>
<tr><td>
    <label for="subject">DETAILS</label><span id="wordcount" style="font-size: 12px; color: blue"></span></td><td>
    <textarea id="subject" name="subject" onkeyup="countwords(this.value)" placeholder="WRITE DETAILS" style="height:200px" ></textarea></td>
</tr><!--<tr><td>
    <label for="subject">Upload multiple news in .xls file (Max: 3.5 M.B.)</label></td><td>
    <input type="file" name="result" /></td></tr>--><tr><td>
    <label for="lname">Submitted by:</label></td><td>
    <span><?php echo strtoupper($namer).' ('.$session->username.')'; ?></td></tr>
    <tr><td colspan=2><center>
    <input type="submit" value="Submit" name="campus_submit"></center></td></tr></table>
  </form>
</div></center>
<?php }
elseif($a==5){
?>
<!-- FORM TO WRITE CHRISTIAN DEVOTIONAL -->
<center><h3> WRITE CHRISTIAN DEVOTIONAL</h3>
<button class="accordion" style="opacity: 0.9;width: 53vw">PENDING DEVOTIONALS</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
  <table style="width: 80%; opacity: 0.9;">
    <?php
    $no=1;
    $pends = Devotionals::find_pending($biose);
    if(!empty($pends)){
    foreach($pends as $pend){
     echo "<form action=\"updates.php\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$pend->id."' />";
     echo "<td>".$no."<td>";
     echo "<td><b>".strtoupper($pend->topic)."</b></td>";
     echo "<td><button type='submit' name='approver5' >APPROVE</button></td>";
     echo "<td><button type='submit' name='deleter5' >DELETE</button></td>";
     $files="dummy.jpg";
     if($pend->filename!="null") $files = $pend->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $no++;
    }
    //echo "<tr><td></td><td colspan=4><span id='commenter' >ADD IMAGE</span></td></tr>";
    }else echo "<tr><td>NO PENDING DEVOTIONALS!</td></tr>";
    ?>
    
  </table>
 
  </p>
</div>
<button class="accordion" style="opacity: 0.9;width: 53vw">WRITTEN DEVOTIONALS</button>
<div class="panel" style="opacity: 0.9;width: 50vw">
  <p>
 <table style="width: 80%; opacity: 0.9;">
  <?php
  $nos=1;
  $posts = Devotionals::find_posted($biose);
  if(!empty($posts)){
    foreach($posts as $post){
     echo "<form action=\"#\" method=\"post\" ><tr>";
     echo "<input type='hidden' name='as' value='{$a}' />";
     echo "<input type='hidden' name='newz' value='".$post->id."'>";
     echo "<td>".$nos."<td>";
     echo "<td><b>".strtoupper($post->topic)."</b></td>";
    
     echo "<td><button type='submit' name='deleter5' >DELETE</button></td>";
     $files="";
     if($post->filename!="null") $files = $post->filename;
     echo '<td><img src="images/news/'.$files.'" style="height: auto; width: 50px; object-fit: contain" /></td>';
     echo "</tr></form>";
     $nos++;
    }
  }else echo "<tr><td>NO DEVOTIONALS WRITTEN YET BY YOU</td></tr>";
  ?>
 </table>
  </p>
</div>

<div class="container" style="overflow: scroll;opacity: 0.9;width: 50vw">
  <form action="updates.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
   <table style="width: 100%;opacity: 0.9;"> <tr><td class="four"><label for="fname" >TOPIC<b style="color: red;">*</b></label></td>
   <td class="six"><input type="text" id="fname" name="topic" placeholder="TOPIC OF DEVOTIONAL..." required></td></tr>
<tr><td>
    <label for="lname">BIBLE VERSE</label></td><td>
 <!--   <input type="hidden" name="bok" value="0" />
    <input type="hidden" name="chap" value="0" />
    <input type="hidden" name="ves" value="0" />-->
    <select id="test" name="test" onchange="loadtest()"><option>--</option>
                                        <option value="1">Old Testament</option>
                                        <option value="2">New Testament</option>
                                      </select><br>
                                     <select id="booke" name="booke" onchange="loadchapters()">
                                      </select><br>
                                      <select id="chapterz" name="chapterz" onchange="loadverses()"></select><br>
                                      </label><select id="versetext" name="linker" onchange="loadlinker()"></select>
    <!--<input type="text" id="memverse" name="linker" placeholder="Verse of Scripture"></input>-->
    </td></tr>

  
    <input type="hidden" name="as" value="5"/>
<tr><td>
    <label for="subject">DETAILS</label><span id="wordcount" style="font-size: 12px; color: blue"></span></td><td>
    <textarea id="subject" name="subject" onkeyup="countwords(this.value)" placeholder="WRITE DEVOTIONAL WITH BIBLICAL REFRENCES" style="height:200px" required></textarea></td>
</tr><tr><td>
    <label for="lname">Submitted by:</label></td><td>
    <span><?php echo strtoupper($namer).' ('.$session->username.')'; ?></td></tr>
    <tr><td colspan=2><center>
    <input type="submit" value="Submit" name="submit_devotion"></center></td></tr></table>
  </form>
</div></center>

<?php  } ?>
<div id="myModal1" class="modal1">
  <!-- Modal content -->
  <div class="modal-content1">
    <div class="modal-header1">
      <span class="close1">&times;</span>
      <h2><center>ADD AN IMAGE TO A WRITE-UP</center></h2>
    </div>
    <div class="modal-body1">
     <center><table style="width: 70%"> <form action="insertfile.php" method="post" enctype="multipart/form-data" id="form">
        <input type="hidden" name="MAX_FILE_SIZE" value="<? echo $max_file_size;?>" />
        <input type="hidden" id="type" name="type" value=2 />
        <input type="hidden" name="as" value="<?php echo $a; ?>" />
	<tr><td><center>CHOOSE THE WRITE-UP</center></td>
	<td><select name="newsid" required><option>--</option>
	<?php
	if($a==1){
	   $pends = News::find_pending($biose); //CHURCH COMMENTARY
	   foreach($pends as $pend){
	      echo '<option value="'.$pend->id.'">'.$pend->topic.'<option>';
	   }
	   }
	elseif($a==2){
	   $pends = Scholars::find_pending($biose); //Charity
	   foreach($pends as $pend){
	      echo '<option value="'.$pend->id.'">'.$pend->topic.'<option>';
	   }
	}
	elseif($a==3){
	   $pends = Jobs::find_pending($biose); //CATHOLIC CHURCH MASS READING
	   foreach($pends as $pend){
	      echo '<option value="'.$pend->id.'">'.$pend->topic.'<option>';
	   }
	}
	elseif($a==4){
	   $pends = Campus::find_pending($biose); //life of SAINT
	   foreach($pends as $pend){
	      echo '<option value="'.$pend->id.'">'.$pend->topic.'<option>';
	   }
	}
	elseif($a==5){
	   $pends = Devotionals::find_pending($biose);
	   foreach($pends as $pend){
	      echo '<option value="'.$pend->id.'">'.$pend->topic.'<option>';
	   }
	}
	?>
	</select></td><td rowspan=2><div id="preview"><center><img src="images/profiles/dummy.jpg" style="width: 100px; height: auto;"/></center></div></td>
	</tr>
       <tr> <td><input type="file" class="filer" id="uploadImage" name="image" size="12" style="float: left" accept="images/*" ></td>
        <td>
        <input class="button" type="submit" value="Upload">
        <center><span id="succeed"></span></center></td>
      </tr></form>
      <tr><td colspan=2 >
      <div class="progress">
    <div class="progress-bar"></div>
</div></td></tr>
<tr><td colspan=2 >
      <div class="">
    <div class="message"></div>
</div></td></tr>
      </table></center>
    </div>
    <div class="modal-footer1">
      <h3><center> faith in JESUS CHRIST...</center></h3>
    </div>
  </div>
</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  }
}

// Get the modal for signup
var modal2 = document.getElementById('id02');



// Get the modal
var modal = document.getElementById('myModal1');

// Get the button that opens the modal
var btn = document.getElementById("commenter");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close1")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
        modal.style.display = "block";
    
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
}

$(document).ready(function (e) {
 $("#form").on('submit',(function(e) {
  e.preventDefault();
  // e.stopPropagation();
  $.ajax({
         url: "insertfile.php",
         xhr: function() {
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
            },
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   beforeSend : function()
   {
    //$("#preview").fadeOut();
    $("#succeed").fadeOut();
    $(".progress-bar").width('0%');
            //    $('#uploadStatus').html('<img src="images/loading.gif"/>')
   },
   success: function(data)
      {
    if(data=='invalid')
    {
     // invalid file format.
     $("#succeed").html("Invalid File !").fadeIn();
    }
    else
    {
     // view uploaded file.
     $("#preview").html(data).fadeIn();
     $("#form")[0].reset(); 
    }
      },
     error: function(e) 
      {
    $("#succeed").html(e).fadeIn();
      }          
    });
 }));
});


</script>

<?php echo footer(); ?>