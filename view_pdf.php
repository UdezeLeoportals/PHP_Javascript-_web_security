<?php 
  
require_once("./includes/initialize.php");  
// Store the file name into variable
$type = empty($_GET['pub']) ? 1: $_GET['pub'];


if ($type == 1 && $_GET['a'] == 3)  
$file = 'files/Pdf_files/WHO-COVID-19-laboratory-2020.4-eng.pdf';
elseif ($type == 2){
    $file = 'files/Pdf_files/'.test_input($_GET['doc']);
}  
$file = 'files/Pdf_files/JESUS_CHRIST_files/JESUS_CHRIST_GODLY_Lent5.pdf';
$file = empty($_POST['JESUS_CHRIST_file']) ? $file: 'files/Pdf_files/JESUS_CHRIST_files/'.$_POST['JESUS_CHRIST_file'];
//echo "<h2>LORD JESUS CHRIST, HAVE MERCY ON ME A SINNER BY THE GRACE OF THE ALMIGHTY GOD!</h2>";
//echo $file;
 
// Header content type 
header('Content-type: application/pdf'); 
  
header('Content-Disposition: inline; filename="' . $file . '"'); 
  
header('Content-Transfer-Encoding: binary'); 
  
header('Accept-Ranges: bytes'); 
  
// Read the file 
@readfile($file); 
  
?> 