<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>

<style type="text/css">


.high{
        height: 10em;
    }
    .low{
        height: 25em;
    }
th, td {
 height:   50px;

}
.bold{
		margin: 30px auto;
		border-collapse: collapse;
		
		height:   40px;
	}
.normal{ 
 height: 80px; 
}


</style>
<?php
    $drop=0;
    $current_session="";
		$semesters = Semester::find_active();
		foreach($semesters as $semester):
		$current_session = $semester->a_session; 
		endforeach;
    if(isset($_POST['report'])){
    $valid=0;
     $drop=1;
    if(!empty($_POST['matric_no']) && !empty($_POST['code']) && !empty($_POST['valid_session']) &&!empty($_POST['change'])){
        $valid=1;
        if(!empty($_POST['change']) && $_POST['change']=="unit" && (empty($_POST['UNIT']) || empty($_POST['session']))){$drop=0; $valid=0;}
    }
    if($drop==1 && $valid==1){
       
	    //search if code number exists and is unused
	    $codes = Code_numbers::find_code($_POST['code']);
	    $correct = 0;
	    if(!empty($codes)){
		foreach($codes as $code){
		    $students = Student::find_by_matric($_POST['matric_no']);
		    foreach($students as $student){
		    if($code->student_id == $student->id && $code->used==0) $correct =1;
		    else{
			$drop = 0;
			echo '<b style="color: red;">This code number is either used or the case is unapproved</b>';
		    }
		}
		}
	    }else{
		$drop==0;
		echo '<b style="color: red;">Invalid code number</b>';
	    }
            if($drop==1 && $correct==1){
		$id = 0;
		$user_id=0;
		$students = Student::find_by_matric($_POST['matric_no']);
		foreach($students as $student){
		    $id = $student->id;
		    $user_id = $student->user_id;
		}
		$new_photo = new Documents(); 
			  $new_photo->student_id = $id;
			  $new_photo->name = "CHANGE OF PROGRAMME MEMO";
			    $new_photo->code_number = $_POST['code'];
			  $new_photo->attach_file($_FILES['memo']);
			  if($new_photo->save()){
			    //if memo is successfully saved 
			    if(empty($new_photo->errors)){
				// update number as used and id of document
				Code_numbers::update_used($_POST['code']);
				 Code_numbers::update_doc($new_photo->id, $_POST['code']);
				 //create report 
				 $case = new Cases();
				 $case->student_id = $id;
				 $case->description = 'CHANGE OF PROGRAMME: '.$_POST['reason'];
				 $case->date_of_creation = date(DateTime::RFC1123, time());
				 $case->memo_code_number = $_POST['code'];
				 $case->session_of_comm = $_POST['session']; 
				 $case->semester_of_comm ="first";
				$case->semester_of_rein="-1";
				$case->implication = $_POST['UNIT'];
				$case->previous_session = $_POST['valid_session']; 
				$case->create();
				
				$semester=Academic_session::find_session($_POST['session']);
				$session_id=0;
				foreach($semester as $sems){
				    $session_id=$sems->id;
				}
				$state = Student_status::find_by_stdnt($id, $session_id);
				if(!empty($state)){
				foreach($state as $state2){
				   $new_unit = $_POST['UNIT'];
				   Student::update_unit($new_unit, $user_id);
				   $prev_sess =$_POST['valid_session'];
				   $next_status="FR";
				   User::change_status($user_id, 1);
				   promote($id, $prev_sess, $_POST['session']);
				}
				}
                               if(!empty($_POST['session1']) && !empty($_POST['session2'])&&!empty($_POST['semester1']) && !empty($_POST['semester2'])){
				   nullify($id, $_POST['session1'], $_POST['semester1'], $_POST['session2'], $_POST['semester2']);
				   }elseif(!empty($_POST['session1'])) echo "INSUFFICIENT INFORMATION FOR NULLIFICATION";
					
				echo '<center><h3>CASE SUCCESSFULLY CREATED</h3></center>';    
                            }
                          }elseif(!empty($new_photo->errors)){
			    $drop=0;
			    echo  '<b style="color: red;">Could not upload memo</b><br>';
			    $message = join("<br>", $new_photo->errors);
			    echo $message;
			  }
            }
    }else {
                    $drop = 0;
                    echo '<center><b style="color: red;" >Fill all relevant fields</b></center>';
                }
    
    }
if($drop==0){
?>
<center>
    <form action="change_prog.php" method="post" enctype="multipart/form-data">
        <h3>CREATE A REPORT</h3><b><table style="width: 50%" class="takon">
            <tr><td>MATRIC NO:</td><td><input type="text" name="matric_no" class="field" /></td></tr>
            <tr><td>UPLOAD MEMO</td><input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
            <td><input type="file" name="memo" class="field" /></td></tr>
	    <tr><td>CODE NUMBER OF MEMO:</td><td><input type="text" name="code" class="field" /></td></tr>
            
            <?php  echo '<tr class="bold"><td>LAST VALID SESSION:</td><td><select name="valid_session" class="field" ><option></option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		$c_session = $session->name;
		endforeach;
		for($count=1; $count<=3; $count++){
		    $c_session = next_session($c_session);
		 echo '<option value="'.$c_session.'">'.$c_session.'</option>';
		}
		echo '</select></td></tr>';
	    ?>
            <tr><td>TYPE OF CHANGE</td><td><select name="change" class="field"  ><option></option>
            <option value="unit">Change of unit</option>
            <option value="dept">Change of Department</option>
	    <option value="uni">Change of Institution</option></select></td></tr>
            <tr><td colspan=2></td></tr>
            <tr><td colspan=2>IF CHANGE OF UNIT</td></tr>
            <tr><td>NEW UNIT</td><td><select name="UNIT" class="field" ><option></option>
            <option value="computer science">Computer Science</option>
            <option value="maths/statistics">Maths/Statistics</option>
            <option value="statistics">Statistics</option></select></td></tr>
            <?php  echo '<tr class="bold"><td>SESSION OF COMMENCEMENT:</td><td><select name="session" class="field" ><option></option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		$c_session = $session->name;
		endforeach;
		for($count=1; $count<=3; $count++){
		    $c_session = next_session($c_session);
		 echo '<option value="'.$c_session.'">'.$c_session.'</option>';
		}
		echo '</select></td></tr>';
	    ?>
           <tr><td>REASONS:</td><td><textarea rows="6" cols="40" name="reason"></textarea></td></tr>
	    <tr><td colspan=2></td></tr>
	      <tr><td colspan=2>IF THERE ARE SESSIONS TO BE NULLIFIED</td></tr>
	    <?php  echo '<tr class="bold"><td>NULLIFY FROM:</td><td>SESSION: <select name="session1" class="field" ><option></option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		
		endforeach;
		echo '</select>SEMESTER: <select name="semester1"class="field" ><option></option>
            <option value="first">first</option><option value="second">second</option></select></td></tr>';
	    ?>
	    <?php  echo '<tr class="bold"><td>STOP AT:</td><td>SESSION: <select name="session2" class="field" ><option></option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		$c_session = $session->name;
		endforeach;
		for($count=1; $count<=3; $count++){
		    $c_session = next_session($c_session);
		 echo '<option value="'.$c_session.'">'.$c_session.'</option>';
		}
		echo '</select>SEMESTER: <select name="semester2"class="field"><option></option>
            <option value="first">first</option><option value="second">second</option></select></td></tr>';
	    ?>
             <tr><td colspan=2><input type="submit" class="button" name="report" value="SUBMIT" /></td></tr>
        </table></b>
    </form><br><br><br><br>
</center>
<?php }echo footer(); ?>