<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); };
if($session->type!="HOD" && $session->type!="admin") {redirect_to("./index.php");}
?>
<?php
echo add_header($session->username, $session->type);

?>
<style type="text/css">

tr { 
 margin: 30px auto;
 border-collapse: collapse;
 
}
table{

width: 35%;
}
.high{
        height: 10em;
    }
    .low{
        height: 25em;
    }
        th, td {
 height:   40px;

font-size: 12px;
}

.normal{ 
 height: 80px; 
}

.normal{ 
 height: 80px; 
}

</style>
<?php

			
                
if(isset($_POST['submit'])){
			$id=0;
			$students = Student::find_by_matric($_POST['matric_no']);
			foreach($students as $student){
                            $id = $student->id;
                        }
			
			  $new_photo = new Documents(); 
			  $new_photo->student_id = $id;
			  $new_photo->name = $_POST['name'];
			  $new_photo->code_number="credential";
			  $new_photo->attach_file($_FILES['doc']);
			  if($new_photo->save()){
			    $message = "<center>Document uploaded successfully</center>";
			    }
			   else{
			    $message = join("<br>", $new_photo->errors);
			   }
                           echo $message;
			   
			      	
			
}

?>
<center>
<div class="high"></div>
    <form action="upload_documents.php" method="post" enctype="multipart/form-data">
        <table class="takon" >
            <tr>
                <td>TYPE OF DOCUMENT:</td>
                <td><select name="name" class="field"><option></option><option value="WAEC result">WAEC result</option>
		<option value="NECO result">NECO result</option><option value="JAMB result">JAMB result</option>
		<option value="POST_UME result">POST UME result</option>
		<option value="JAMB Admission Letter">JAMB Admission Letter</option>
		<option value="Birth Certificate">Birth Certificate</option>
		<option value="Certificate of State of origin">Certificate of State of Origin</option>
		<option value="Certificate of LGA of Origin">Certificate of LGA of Origin</option>
		<option value="Letter of recommendation">Letter of recommendation</option>
		</td>
            </tr>
	    <tr>
	      <td>MATRIC NUMBER:</td>
	      <td><input type="text" name="matric_no" class="field"></td>
	    </tr>
            <input type="hidden" name="MAX_FILE_SIZE" value="4000000" />
            <tr><td>CHOOSE FILE:</td>
            <td><input type="file" name="doc" class="field"/></td>
            </tr>
            <tr><td colspan=2><input type="submit" name="submit" value="SUBMIT" class="button" /></td></tr>
        </table>
    </form>
<div class="high"></div>
</center>
<?php echo footer(); ?>