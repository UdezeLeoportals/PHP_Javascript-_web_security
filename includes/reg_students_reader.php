<?php require_once("./includes/initialize.php");
require_once(LIB_PATH.DS.'database.php');
?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<?php
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
    if(isset($_POST['upload'])){
        $path = basename($_FILES['code']['name']);
        $tmp_file = $_FILES['code']['tmp_name'];
	$target_file = basename($_FILES['code']['name']);
	$upload_dir = 'files'.DS.'Registered_students_lists';
  
	if(move_uploaded_file($tmp_file, $upload_dir.DS.$target_file)) {
		$message = "File uploaded successfully.";
	} else {
		$error = $_FILES['code']['error'];
		$message = $upload_errors[$error];
	}
        if(!empty($message)) { echo "<p>{$message}</p>"; } 
        
         $objPHPExcel = new PHPExcel();

    $filename= "files".DS."Registered_students_reader".DS.$path;
   $objReader = PHPExcel_IOFactory::createReader('Excel5');
   $objReader->setReadDataonly(true);
   
   $objPHPExcel = $objReader->load($filename);
   $objWorksheet = $objPHPExcel->getActiveSheet();
   
   echo '<table class="tableDesign">'."\n";
   $outer = 1;
   foreach ($objWorksheet->getRowIterator() as $row){
      echo '<tr>'."\n";
	  
	  $cellIterator = $row->getCellIterator();
	  $cellIterator->setIterateOnlyExistingCells(false);
	  $data = array("Error");
	  
	  foreach ($cellIterator as $cell) {
	    $data[] = $cell->getValue();
	     echo '<td>'. $cell->getValue() . '</td>' . "\n";
	  }
	     
	  echo '</tr>' . "\n";
	  if ($outer > 2){
                    $code_num = new Code_numbers();
                    $code_num->matric_no = trim($data[2]);
                    $code_num->number = trim($data[3]);
                    $code_num->used = 0;
                    $code_num->create();
             }  
	  $outer++ ;  
   }
   echo '</table>' . "\n";
    }
?>
<H4>ENSURE YOU DON'T UPLOAD THIS FILE TWICE (use .xls format)</H4>
<form action="code_number_reader.php" method="post" enctype="multipart/form-data">
   <table class="takon"><input type="hidden" name="MAX_FILE_SIZE" value="3000000"/>
   <tr><td>CHOOSE FILE</td> <td><input type="file" name="code" /></td>
   <tr><td colspan=2> <input type="submit" name="upload" value="UPLOAD" /></td></tr></table>
</form>
<?php echo footer(); ?>