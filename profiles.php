<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {
    die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/login.php';
</script>");

} ?>
<?php
echo add_header($session->username, $session->type);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- added 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- added end -->

<style>

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 40, 40, 0.2);
  max-width: 700px;
  margin: auto;
  text-align: center;
  font-family: arial;
  background-color: white;
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

.filer, button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #30f849;
  text-align: center;
  cursor: pointer;
  width: auto;
  font-size: 18px;
}

.fa a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

.card p{
    font-size: 20px;
}
</style>
<!--
    Add profiles to header function to link page
    Add favorite_vs to biodata table and class
    Add find_by_abbrv() to books class
    Add find_a_verse() to verses class
-->
<!--<link rel="stylesheet" href="styles/login.css" type="text/css" />-->
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<script type="text/javascript" src="scripts/validates.js"></script>
<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
<!-- ####################################################################################################### -->
 <?php
 //code was moved up for sequence
 /*$users = Biodata::find_by_user_id($session->user_id);
 $maile =''; 
 foreach($users as $use){
    $maile = $use->email;  
 }
 
 
 if(isset($_POST['update'])){
      
        $use = new Biodata();
        $use->id = $_POST['ids'];
        $use->user_id = $_POST['userid'];
        $use->sign_up_date = $_POST['signupdate'];
        $use->surname = test_input($_POST['surname']);
        $use->first_name = test_input($_POST['first_name']);
        $use->DOB_day = test_input($_POST['DOB_day']);
        $use->DOB_month = test_input($_POST['DOB_month']);
        $use->DOB_year = test_input($_POST['DOB_year']);
        $use->phone_no = test_input($_POST['phone_no']);
        $use->email = test_input($_POST['email']);
        $use->sex = test_input($_POST['sex']);
        if(!empty($_POST['booke']) && !empty($_POST['chapterz']) && !empty($_POST['versetext'])){
            $bfs = Books::find_by_id(test_input($_POST['booke']));
            $use->favorite_vs = $bfs->abbrv.' '.test_input($_POST['chapterz']).':'.test_input($_POST['versetext']);
        }else $use->favorite_vs = test_input($_POST['favs']);
        $use->filename = test_input($_POST['oldfile']);
        $use->update();
        
        //added code 
            User::change_username($_POST['userid'], test_input($_POST['email']));
            Verifymail::change_valid($_POST['userid'], 0);
            if(test_input($_POST['email']) != $maile){
              //code to send verification mail
               $to = test_input($_POST['email']);
        
                //send a link
                $snt = "Leoportals Network";
                $from = "udezechinedu@leoportals.com";
                
                $message = "<center><table  style ='width: 65%;  background-color: #6def8e;'><tr><td>EMAIL CONFIRMATION</td></tr>";
        	    $message .= "<tr><td><center><img src='http://leoportals.com/images/leologo.jpg' height=150 width=450/> </center></td></tr>" ;
        	    $message .= "<tr><td>Please click on the link below to confirm your email address.</td></tr>";
        	    $message .= "<tr><td><a href='http://leoportals.com/confirmmail.php?a=".$_POST['userid']."' style ='color: red'>Click here</a></td></tr>";
        	    $message .= "<tr><td>Thank you for using this network.<br>Courtesy: Leoportals Suport Team.</td></tr></table></center>";
        	    
                //$message = wordwrap($message, 70);
                $subject = "Email Confirmation for Leoportals Account";
                
                $headers  = 'MIME-Version: 1.0' . "\r\n";
	            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $headers .= 'From: '.$snt.'<'.$from.'>' . "\r\n";
	  
                //send mail and get response.
                $result = mail($to, $subject, $message, $headers);
                echo $result ? '<span>You will receive a mail shortly. Click on the link to confirm you email address.</span>' : '<span>Confirmation email could not be sent. Please bear with us!</span>';
               
            
            }
 } */
 
 
 // ##########################
 
 $users = Biodata::find_by_user_id($session->user_id);
 $name=''; $files='images/profiles/dummy.jpg';
 $mail =''; $DOB=''; $phone_no='';
 $favorite_vs ='none'; $fav_text='';
 $surn =''; $first=''; $DOB_D=0; $DOB_M=0; $DOB_Y=0;
 $sex=''; $max_file_size=1048576;
 $bioid =0; $ids=0; $user_ids=0; $sign_up_date='';
 $old_file=''; $favs='';
 foreach($users as $use){
    $name=$use->surname.' '.$use->first_name;
    $files = empty($use->filename) ? $files : 'images/profiles/'.$use->filename;
    $mail = $use->email;
    $DOB = $use->DOB_month.' '.$use->DOB_day;
    $phone_no = $use->phone_no;
    $favorite_vs = empty($use->favorite_vs) ? $favorite_vs : $use->favorite_vs;
    $surn = $use->surname; $first = $use->first_name;
    $DOB_D = $use->DOB_day; $DOB_M = $use->DOB_month; $DOB_Y = $use->DOB_year;
    $sex=$use->sex; $bioid = $use->id;
    $ids=$use->id; $user_ids = $use->user_id;
    $sign_up_date = $use->sign_up_date;
    $old_file = $use->filename; $favs = $use->favorite_vs;
 }
 ?>

<h2 style="text-align:center">SUCCINT PROFILE</h2>

<div class="card">
   
  <center><img src="<?php echo $files; ?>" alt="John" style="width:370px; height: auto;" />
  <span id="commenter">CHANGE PICTURE</span> 
  
  <div class="container">
    <h1><?php echo strtoupper($name); ?></h1>
    <p class="title"><?php
   /* if($favorite_vs != "none"){
        $f_verse= explode(' ', $favorite_vs);
        $l_verse= explode(':', $f_verse[1]);
        $fav_bk = '';
       $getV = Books::find_by_abbrv($f_verse[0]);
        foreach($getV as $getv1){
            $fav_bk = $getv1->id;
            $get_verses = Verses::find_a_verse($getv1->id, $l_verse[0], $l_verse[1]);
            foreach($get_verses as $get_verse){
                $fav_text = $get_verse->text;
           }
        }
    }
    echo 'FAVORITE VERSE:  ('.$favorite_vs.')'; */
    ?></p>
    <p ><?php echo $mail; ?></p>
    <p><?php echo 'Birthday: '.$DOB; ?></p>
    <p><?php echo 'Phone Number: '.$phone_no; ?></p>
    <div style="margin: 24px 0;">
   <!--  <h2> <a href="#"><i class="fa fa-dribbble"></i></a> 
      <a href="#"><i class="fa fa-twitter"></i></a>  
      <a href="#"><i class="fa fa-linkedin"></i></a>  
      <a href="#"><i class="fa fa-facebook"></i></a> </h2>
   </div>
   <p><button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Update</button></p>
  </div></center>
</div>
<div id="id02" class="modal">
				  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
				  <form class="modal-content animate" action="profiles.php" method="post" onsubmit="return validform();">
				    <div class="container">
				    <center><img src="images/leologo.jpg" alt="Leoportals" class="avatar" ></center><br>
                                
                                    <input type="hidden" id="bio" value="<?php /* echo $bioid; ?>" />
                                    <input type="hidden" id="bok" value="<?php echo $fav_bk; ?>" />
                                    <input type="hidden" name="favs" value="<?php echo $favs; ?>" />
                                    <input type="hidden" name="oldfile" value="<?php echo $old_file; ?>" />
                                    <input type="hidden" id="chap" value="<?php echo $l_verse[0]; ?>" />
                                    <input type="hidden" id="ves" value="<?php echo $l_verse[1]; ?>" />
                                    <input type="hidden" name="ids" value="<?php echo $ids; ?>" />
                                    <input type="hidden" name="userid" value="<?php echo $user_ids; ?>" />
                                    <input type="hidden" name="signupdate" value="<?php echo $sign_up_date; ?>" />
                                    
                                    <center><span id="dpspan"><img src="<?php echo $files; ?>" alt="Profile Pic" id="dp" height=60 width=54></span>
                                    </center><br>
				   
                                    <label ><b>SURNAME:<span class="error" >*</span></b></label>
				    <input type="text"  id="surname" name="surname" value="<?php echo $surn; ?>" placeholder="Enter Surname" onkeyup="validsurname(this.value)" required/><br>
				    <span class="error" id="surnamespan"></span>
				    <label ><b>FIRSTNAME:</b></label>
				    <input type="text"   id="first_name" name="first_name" value="<?php echo $first; ?>" placeholder="Enter First name" onkeyup="validname(this.value)" required/><br>
				    <span class="error" id="namespan"></span>
				    <label >&nbsp;</label>
				    <select name="DOB_day" id="DOB_d" required><option>--Choose day--</option>
						<?php
						for($i=1; $i<32; $i++){
							echo '<option value="'.$i.'" ';
                                                        if($i==$DOB_D) echo 'selected';
                                                        echo '>'.$i.'</option>';
						}
						?>
				    </select><br><label><b>DATE OF BIRTH: </b></label>
				    <select name="DOB_month" id="DOB_m" required><option>-- Choose month--</option>
										<option value="january" <?php if($DOB_M=="january") echo "selected"; else  echo ""; ?> >january</option>
										<option value="february" <?php if($DOB_M=="february")  echo 'selected';  echo '';?> >february</option>
										<option value="march" <?php if($DOB_M=="march")  echo 'selected';  echo '';?> >march</option>
										<option value="april" <?php if($DOB_M=="april")  echo 'selected';  echo '';?> >april</option>
										<option value="may" <?php if($DOB_M=="may")  echo 'selected';  echo '';?> >may</option>
										<option value="june" <?php if($DOB_M=="june")  echo 'selected';  echo '';?> >june</option>
										<option value="july" <?php if($DOB_M=="july")  echo 'selected';  echo '';?> >july</option>
										<option value="august" <?php if($DOB_M=="august")  echo 'selected';  echo '';?> >august</option>
										<option value="september" <?php if($DOB_M=="september")  echo 'selected';  echo '';?> >september</option>
										<option value="october" <?php if($DOB_M=="october")  echo 'selected';  echo '';?> >october</option>
										<option value="november" <?php if($DOB_M=="november")  echo 'selected';  echo '';?> >november</option>
										<option value="december" <?php if($DOB_M=="december")  echo 'selected';  echo '';?> >december</option>
				    </select><br><label>&nbsp;</label>
				    <select name="DOB_year" id="DOB_y"><option>--Choose year--</option>
						<?php
						for($i=1940; $i<2011; $i++){
							echo '<option value="'.$i.'" ';
                                                        if($i==$DOB_Y) echo 'selected';
                                                        echo'>'.$i.'</option>';
						}
						?>
				    </select><br>
				    <label ><b>PHONE NUMBER</b></label><input type="text" id="phone" value="<?php echo $phone_no; ?>" onkeyup="validatePhone(this.value)" name="phone_no"  placeholder="Enter Phone number" required/><br>
				     <span class="error" id="phonespan"></span>
                                      <label><b>EMAIL:<span class="error" >*</span></b></label>
				      <input type="text" placeholder="Enter Email" id="email" value="<?php echo $mail; ?>" id="email" name="email" onkeyup="validateEmail(this.value)" required><br>
				      <span class="error" id="mailspan"></span>
				      <label ><b>GENDER:</b></label>
					<select  name="sex" id="sex" required><option>-Choose gender-</option>
										<option value="male" <?php if($sex=="male")  echo 'selected';  echo '';?> >male</option>
										<option value="female" <?php if($sex=="female")  echo 'selected';  echo ''; */?> >female</option>
					</select>
				<br>
				      <label ><b>CHANGE FAVORITE SCRIPTURE:</b></label>
                                      <select id="test" name="test" onchange="dropbooks()"><option>--</option>
                                        <option value="1">Old Testament</option>
                                        <option value="2">New Testament</option>
                                      </select><br>
                                      <label ><b>&nbsp;</b></label>
                                      <select id="booke" name="booke" onchange="dropchapters()">
                                      </select><br><label ><b>&nbsp;</b></label>
                                      <select id="chapterz" name="chapterz" onchange="dropverses()"></select><br>
                                      <label ><b>&nbsp;</b></label><select id="versetext" name="versetext"></select>
				      <div class="clearfix">
					<button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn2">Cancel</button>
					<button type="submit" class="signupbtn" name="update">UPDATE</button>
				      </div>
				    </div>
				  </form>
				</div>
               -->                 
    <div id="myModal1" class="modal1">

  <!-- Modal content -->
  <div class="modal-content1">
    <div class="modal-header1">
      <span class="close1">&times;</span>
      <h2><center>CHANGE PROFILE PICTURE (1M.B. max.)</center></h2>
    </div>
    <div class="modal-body1">
      <p><center>This image may replace the initial Profile Picture</center></p>
     <center><table style="width: 70%"> <form action="insertfile.php" method="post" enctype="multipart/form-data" id="form">
        <input type="hidden" id=="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="<? echo $max_file_size;?>"/>
        <input type="hidden" id="ids" name="ids" value="<?php echo $ids; ?>" />
        <input type="hidden" id="type" name="type" value=1 />
        <tr><td colspan=2><div id="preview"><center><img src="images/profiles/dummy.jpg" style="width:70px; height: auto;"/></center></div><br></td></tr>
       <tr> <td><input type="file" class="filer" id="uploadImage" name="image" size="12" style="float: left" accept="images/*"></td>
        <td>
        <input class="button" type="submit" value="Upload">
        
        <center><span id="succeed"></span></center>
        </td></tr>
        
            
         
      </form>
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
      <h3><center>Leoportals -- the network of faith...</center></h3>
    </div>
  </div>

</div> 
<script>

// Get the modal for signup
var modal2 = document.getElementById('id02');



// Get the modal
var modal = document.getElementById('myModal1');

// Get the button that opens the modal
var btn = document.getElementById("commenter");
//var btn1 = document.getElementById("commenting");

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
              //  $('#uploadStatus').html('<img src="images/loading.gif"/>');
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

<!-- ####################################################################################################### -->
<?php echo footer(); ?>