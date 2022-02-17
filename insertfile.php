<?php

require_once("./includes/initialize.php");
$type= $_POST['type'];
if($type==1){
$valid_extensions = array('jpeg', 'jpe', 'jpg', 'png', 'gif', 'bmp'); //valid extensions
$valid_mime = array('image/jpeg', 'image/png', 'image/gif', 'image/bmp');
           
$path = "images/profiles/"; //upload directory
if($_FILES['image'])
{
$img = '';//$_FILES['image']['name'];
$tmp = '';//$_FILES['image']['tmp_name'];
$errorimg = $_FILES["image"]["error"];
$errors= '';
$upload_errors = array(
                "No errors.",
               "Larger than upload_max_filesize.",
                "Larger than form MAX_FILE_SIZE.",
                "Partial upload.",
                "No file.",
                    "",
                 "No temporary directory.",
                 "Can't write to disk.",
                "File upload stopped by extension."
       );
       if($_FILES['image']['error'] != 0)
            {
                $errors= $upload_errors[$_FILES['image']['error']];
           }
           else{
               $img = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
           }
           if(empty($img) || empty($tmp)){
                $errors= "The file location was not available";
            }
//get uploaded file's extension
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// can upload same image using rand function
$final_image = rand(1000,1000000).$img;
$path = $path.$final_image; 
$mimetype = $_FILES['image']['type'];

if(!(in_array($ext, $valid_extensions) && in_array($mimetype, $valid_mime))){
    $errors= "Invalid file format. Cannot accept a .".$ext." file!";
}
//checks valid format
if(in_array($ext, $valid_extensions) && in_array($mimetype, $valid_mime) && empty($errors)) 
{ 

if(move_uploaded_file($tmp,$path)) 
{

$latest = Photos::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;

$ids = $_POST['ids'];
//$date_time = date(DateTime::RFC1123, gettime());

$photo = new Photos(); 
        $photo->id = $lid;
        $photo->biodata_id = $ids;
        
        $photo->filename = $final_image;
        $photo->date_time = date(DateTime::RFC1123, gettime());
        $photo->paper_title = "null";
        $photo->fieldOS = "null";
        $photo->journal = "null";
        $photo->year = "0001";
        $photo->file_type = "image";
        if($photo->createv()){} 
Biodata::change_filename($ids, $final_image);
echo "<center><img src='$path' style='width:70px; height: auto;'/></center>";
//echo $insert?'ok':'err';
}
} 
else 
{
echo $errors;
}
}
}
if($type==2){

$path = "images/profiles/"; //upload directory
if($_FILES['image'])
{
$img = '';//$_FILES['image']['name'];
$tmp = '';//$_FILES['image']['tmp_name'];
$errorimg = $_FILES["image"]["error"];
$errors= '';
$upload_errors = array(
                "No errors.",
               "Larger than upload_max_filesize.",
                "Larger than form MAX_FILE_SIZE.",
                "Partial upload.",
                "No file.",
                    "",
                 "No temporary directory.",
                 "Can't write to disk.",
                "File upload stopped by extension."
       );
       if($_FILES['image']['error'] != 0)
            {
                $errors= $upload_errors[$_FILES['image']['error']];
           }
           else{
               $img = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
           }
           if(empty($img) || empty($tmp)){
                $errors= "The file location was not available";
            }

// can upload same image using rand function
$final_image = rand(1000,1000000).$img;
$path = $path.$final_image; 

//checks valid format
if(empty($errors)) 
{ 

if(move_uploaded_file($tmp,$path)) 
{

$latest = Photos::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;

$ids = $_POST['ids'];
//$date_time = date(DateTime::RFC1123, gettime());

$photo = new Photos(); 
        $photo->id = $lid;
        $photo->biodata_id = $ids;
        
        $photo->filename = $final_image;
        $photo->date_time = date(DateTime::RFC1123, gettime());
        $photo->paper_title = "null";
        $photo->fieldOS = "null";
        $photo->journal = "null";
        $photo->year = "0001";
        $photo->file_type = "image";
        if($photo->createv()){} 
Biodata::change_filename($ids, $final_image);
echo "<center><img src='$path' style='width:70px; height: auto;'/></center>";
echo "File successfully uploaded!";
//echo $insert?'ok':'err';
}
} 
else 
{
echo $errors;
}
}
}
/*else if($type==2){//UPLOAD News image
    
    
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
$path = "images/news/"; // upload directory
if($_FILES['image'])
{
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$errorimg = $_FILES["image"]["error"];
// get uploaded file's extension
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// can upload same image using rand function
$final_image = rand(1000,1000000).$img;
// check's valid format
if(in_array($ext, $valid_extensions)) 
{ 
$path = $path.$final_image; 
if(move_uploaded_file($tmp,$path)) 
{


$a = $_POST['as'];
//$date_time = date(DateTime::RFC1123, gettime());
$latest = News_images::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
        $photo = new News_images(); 
        $photo->id = $lid;
        $photo->news_id = $_POST['newsid'];
        $photo->filename = $final_image;
	$photo->date_time = date(DateTime::RFC1123, gettime());
	if($a==1) $photo->category = "news";
	if($a==2) $photo->category = "scholars";
	if($a==3) $photo->category = "jobs";
	if($a==4) $photo->category = "campus";
	if($a==5) $photo->category = "devotion";
        if($photo->create()){
          // $message = "Image uploaded successfully";
        }
        else{
        // $message = join("<br>", $photo->errors);
        }
    if($a==1) News::change_filename($_POST['newsid'], $photo->filename);
    if($a==2) Scholars::change_filename($_POST['newsid'], $photo->filename);
    if($a==3) Jobs::change_filename($_POST['newsid'], $photo->filename);
    if($a==4) Campus::change_filename($_POST['newsid'], $photo->filename);
    if($a==5) Devotionals::change_filename($_POST['newsid'], $photo->filename);
    //if(!(empty($message))) 
     //   echo '<span>'.$message.'</span>';
echo "<center><img src='$path' style='width:100px; height: auto;'/></center>";
//echo $insert?'ok':'err';
}
} 
else 
{
echo 'invalid';
}
}

    
}
else if($type==3){ //UPLOAD LECTIO DIVINA JESUS CHRIST PDF
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
$path = "files/Pdf_files/"; // upload directory
if($_FILES['image'])
{
$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$errorimg = $_FILES["image"]["error"];
// get uploaded file's extension
$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
// can upload same image using rand function
$final_image = rand(1000,1000000).$img;
// check's valid format
if(in_array($ext, $valid_extensions)) 
{ 
$path = $path.$final_image; 
if(move_uploaded_file($tmp,$path)) {
    $latest = Pdf_files::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
        
        $ids = $_POST['bioid'];
//$date_time = date(DateTime::RFC1123, gettime());

$photo = new Pdf_files(); 
        $photo->id = $lid;
        $photo->user_id = $ids;
        $photo->filename = $final_image;
        $photo->date_time = date(DateTime::RFC1123, gettime());
        $photo->title = test_input(trim($_POST['doc_title']));
        $photo->JESUS_CHRIST_wk = test_input(trim($_POST['JESUS_CHRIST_wk']));
        $photo->year = $_POST['year'];
        $photo->type = "JESUS_CHRIST_divina";
        if($photo->create()){} 
    echo "<center><h4 style='color:red'>File was successfully uploaded<br>You can upload another</h4></center>";
}
}
else 
{
echo '<center><h4>invalid file format</h4></center>';
}
}
}*/
?>
