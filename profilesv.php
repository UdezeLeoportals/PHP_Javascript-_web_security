<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {
    die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/login.php';
</script>");

} ?>
<?php
echo vuln_header($session->username, $session->type);
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
 /**/
 
 
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
   /*  */
    ?></p>
    <p ><?php echo $mail; ?></p>
    <p><?php echo 'Birthday: '.$DOB; ?></p>
    <p><?php echo 'Phone Number: '.$phone_no; ?></p>
    <div style="margin: 24px 0;">
   <!-- 
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
        <input type="hidden" id="type" name="type" value=2 />
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