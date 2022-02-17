<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {
    die("<script type=\"text/javascript\">
window.location.href = 'http://www.leoportals.com/login.php';
</script>");

 }
 
//if($session->type!="HOD" && $session->type!="admin") { die("<script type=\"text/javascript\">
//window.location.href = 'http://www.leoportals.com/index.php';
//</script>");}
?>
<?php
echo add_header($session->username, $session->type);
?>
<!--<head><title>Result System - Excel Result Upload</title>


<style type="text/css">


.high{
        height: 10em;
    }
    .low{
        height: 30em;
    }

.bold{
		margin: 30px auto;
		border-collapse: collapse;
		
		height:   40px;
	}
.normal{ 
 height: 80px; 
}

    .col{
	color: red; #009FFF;
    }
th, td {
 height:   30px;


font-style: italic;
font: serif;
font-size: 12px;
}
</style></head>
<body topmargin="0" style="background-color: #F8F7DF">

-->
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<script type="text/javascript" src="scripts/validates.js"></script>
<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
<link rel="stylesheet" href="styles/update_styles.css" type="text/css" /> 
<?php

$users = Biodata::find_by_user_id($session->user_id);
 $bio_id =''; 
 foreach($users as $use){
    $bio_id = $use->id;  
 }
$exect=0;

	
	
	
?>
<!-- ####################################################################################################### -->
<?php //echo '<div class="high"></div><div class="low">'; ?>
<div class="container" style="overflow: scroll;"><center>
<form action="insertfile.php" method="post" enctype="multipart/form-data" id="form">
 
		<table  style="width: 40%; height: 10em;" class="takon">
		<input type="hidden" name="MAX_FILE_SIZE" value="40000000" />
		<tr class="bold"><td colspan=2><div id="preview"></div></td></tr>
		<tr class="bold"><td ><label for="fname">Upload Publication (IN .pdf format)</label></td><td><input type="file" class="filer" id="uploadImage" name="image" size="12" style="float: left" accept="files/*" /></td></tr>
		<input type="hidden" id="type" name="type" value=3 />
		<input type="hidden" id="bioid" name="bioid" value=<?php echo $bio_id; ?> />
  <tr class="bold"><td ><label for="fname">Title of Document</label></td><td><input type="text" name="doc_title" class="field"  placeholder="Enter the title of the article"/></td></tr>
  <tr class="bold"><td ><label for="fname">Field of study</label></td><td><input type="text" name="fieldOS" class="field" width=100%  placeholder="Enter field of study ?"/></td></tr>
  <tr class="bold"><td ><label for="fname">Journal</label></td><td><input type="text" name="journal" class="field"  placeholder="Enter Name of Journal..."/></td></tr>
  <tr class="bold"><td ><label for="fname">Year</label></td><td>
      <?php  ?>
  <select name="year" class="field" style="font-size:17px; height:4em"><option>--</option>
  <?php for($years=1960; $years<2021; $years++){ ?>
      <option value="<?php echo $years; ?>"><?php echo $years; ?></option>
      <?php  } ?>
  </select> 
  </td></tr>
  
		<tr class="bold"><td colspan=2><center><input class="button" type="submit" value="Upload">
        
        <span id="succeed"></span></center></td></tr>
        <tr><td colspan=2 >
      <div class="progress">
    <div class="progress-bar" style="color:red" ></div>
</div></td></tr>
<tr><td colspan=2 >
      <div class="">
    <div class="message"></div>
</div></td></tr>
	</table>
	<div style="height: 4em"></div>
</form>

</center></div>

<script>
    
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
                        $(".message").html('<b style="color:red">Please wait a until you receive a successful upload message</b>');
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
    $("#preview").html("").
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
</body>