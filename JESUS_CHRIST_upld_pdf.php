<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {
    die("<script type=\"text/javascript\">
window.location.href = 'http://www.leoportals.com/login.php';
</script>");

 }
 
?>
<?php
echo add_header($session->username, $session->type);
?>
<!--

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

	if(isset($_POST['JESUS_CHRIST_submit'])){
	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
$path = "files/Pdf_files/JESUS_CHRIST_files/"; // upload directory
if(!empty($_FILES['image']))
{
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$errorimg = $_FILES["image"]["error"];
// get uploaded file's extension
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// can upload same image using rand function
$final_image = rand(1000,1000000).$img;
// check's valid format 
echo $ext;
if(strcmp($ext, "pdf")) 
{ 
$path = $path; 
if(move_uploaded_file($tmp,$path)) {
    $latest = Photos::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
        echo '<h3>TEACH ME O LORD JESUS CHRIST TO BE LIKE YOU</h3>';
        
//$date_time = date(DateTime::RFC1123, gettime());

$photo = new Photos(); 
        $photo->id = $lid;
        $photo->biodata_id = $_POST['bioid'];
        
        $photo->filename = $final_image;
        $photo->date_time = date(DateTime::RFC1123, gettime());
        $photo->paper_title = test_input(trim($_POST['doc_title']));
        $photo->fieldOS = test_input(trim($_POST['JESUS_CHRIST_wk']));
        $photo->journal = '';//test_input(trim($_POST['journal']));
        $photo->year = $_POST['year'];
        $photo->file_type = "JESUS_CHRIST_Divina";
        if($photo->create()){
        
    echo "<center><h4 style='color:red'>File was successfully uploaded<br>You can upload another</h4></center>";
        }
         echo '<center><h3 style="color:red">TEACH ME O LORD JESUS CHRIST! TO BE LIKE YOU</h3></center>';
}
else 
{
echo '<center><h4>invalid file format</h4></center>';
}
}
    
}	
}
?>
<!-- ####################################################################################################### -->
<?php //echo '<div class="high"></div><div class="low">'; ?>
<div class="container" style="overflow: scroll;"><center>
<form action="JESUS_CHRIST_upld_pdf.php" method="post" enctype="multipart/form-data" id="form">
 
		<table  style="width: 40%; height: 10em;" class="takon">
		<input type="hidden" name="MAX_FILE_SIZE" value="40000000" />
		<tr class="bold"><td colspan=2><div id="preview"></div></td></tr>
		<tr class="bold"><td ><label for="fname">Upload WORD OF GOD (IN .pdf format)</label></td><td><input type="file" class="filer" id="uploadImage" name="image" size="12" style="float: left" accept="files/*" /></td></tr>
		<input type="hidden" id="type" name="type" value=3 />
		<input type="hidden" id="bioid" name="bioid" value=<?php echo $bio_id; ?> />
  <tr class="bold"><td ><label for="fname">GOSPEL Topic of Study</label></td><td><input type="text" name="doc_title" class="field"  placeholder="Enter the GOSPEL topic of the Study"/></td></tr>
  <tr class="bold"><td ><label for="fname">Week in Church Calendar</label></td><td><input type="text" name="JESUS_CHRIST_wk" class="field" width=100%  placeholder="Enter week in Church Calendar"/></td></tr>
  
  <tr class="bold"><td ><label for="fname">Year</label></td><td>
      <?php  ?>
  <select name="year" class="field" style="font-size:17px; height:4em"><option>--</option>
  <?php for($years=2013; $years<2028; $years++){ ?>
      <option value="<?php echo $years; ?>"><?php echo $years; ?></option>
      <?php  } ?>
  </select> 
  </td></tr>
  
		<tr class="bold"><td colspan=2><center><input class="button" type="submit" value="Upload" name="JESUS_CHRIST_submit">
        
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


<!-- ####################################################################################################### -->
<?php echo footer(); ?>
</body>