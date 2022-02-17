<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); };
if($session->type!="admin") {redirect_to("./index.php");}
?>
<head><title>Result System - Close the Session</title>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">
	tr{
		margin: 30px auto;
		border-collapse: collapse;
		height:   40px;
	}
	table {
		width: 35%;
 margin: 30px auto;
 border-collapse: collapse;

}

th, td {
 height:   35px;

}
	.high{
        height: 45em;
	 }
	.low{
        height: 10em;
	}
	
</style>
</head>
<body topmargin="0" style="background-color: #F8F7DF">

<?php
if(isset($_POST['no'])) redirect_to("manage_session.php");
$permit=0;
$sess="";
		
		
if(isset($_POST['end'])){
	
	$current_session=$_POST['session'];
	$sm1_id=0; $sm2_id=0;
	$sem1=Semester::find($current_session, "first");
	foreach($sem1 as $sem){
	 $sm1_id=$sem->id;
	}
	$sem2=Semester::find($current_session, "second");
	foreach($sem2 as $sem){
	 $sm2_id=$sem->id;
	}//semester id for 1st and 2nd semester 
	$exists = academic_session::find_session(next_session($_POST['session']));
		if(empty($exists)){
		  $new_session = new academic_session();
		$new_session->name = next_session($_POST['session']);
		$new_session->create();
		}
	//if next session does not exist, create new
	$complete=1;

	$all_courses = Result_sheet::find_distinct($sm1_id, $sm2_id);
	foreach($all_courses as $courses){
		$sem=0;
		$cos = Course::find_by_id($courses->course_id);
		foreach($cos as $s){
			$sem=$s->semester;
		}
		$sm=0;
		$sem1=Semester::find($current_session, $sem);
		foreach($sem1 as $sem){
		 $sm=$sem->id;
		}
		$result = Result::find_by_code($courses->course_id, $sm);
		if(empty($result)){ echo $courses->course_id.'<br>'; $complete=0;}
	
	}//verify that the result for all registered courses has been uploaded

	if($complete==1){
		echo '<center>All Results Have Been Successfully Uploaded!!!</center>';
	
	$permit=1;
	$index=1;
	$flag=0;
			$promotion="";
			$session_id=0;
			$sess=Academic_session::find_session($current_session);
			foreach($sess as $ses){
				$session_id = $ses->id;
			}
			
			$students = Student_status::find_viable($session_id);
			foreach($students as $student):
			$persons = Student::find_by_id($student->student_id);
			foreach($persons as $student){
			$prev_sess="";
			$next_status="";
			$sme=0;
			$sem1=Semester::find(next_session($current_session), "first");
			foreach($sem1 as $sem){
			 $sme=$sem->id;
			}
			$cases1 = Cases::find_by_case($student->id, "first", next_session($current_session));
				if(!empty($cases1)){
					foreach($cases1 as $case1){
						if($case1->implication=="rustication/expulsion") $next_status="EX";
						elseif($case1->implication=="suspension") $next_status="SP";
						elseif($case1->implication=="nullification of academic session") $next_status="NL";
						elseif($case1->implication=="medical leave") $next_status="MC";
						elseif($case1->implication=="deferment") $next_status="DF";
						elseif($case1->semester_of_rein=="-1"){
							$case_unit = Departments::find_unit($case1->implication);
							if(!empty($case_unit)){
							$new_unit = $case1->implication;
							Student::update_unit($new_unit, $student->user_id);
							$prev_sess = $case1->previous_session;
							$next_status="FR";
							User::change_status($student->user_id, 1);
							$flag=1;//COP
							}else $next_status="TR";
							
						}//change of programme/tranfer
						if($case1->semester_of_rein!="-1" || $next_status=="TR"){
							$prev_sess = $case1->previous_session;
							User::change_status($student->user_id, 0);
							
							$session_id=0;
							$sess=Academic_session::find_session(next_session($current_session));
							foreach($sess as $ses){
								$session_id = $ses->id;
							}
							
							$new_status = new Student_status();
							$new_status->student_id = $student->id;
							$new_status->session_id = $session_id;
							$studentss=Student::find_by_id($student->id);
							foreach($studentss as $studen){
							$new_status->unit = $studen->unit;
							$new_status->level = $studen->level;}
							$new_status->status = "pending";
							$new_status->case_status = $next_status;
							$sess=Academic_session::find_session($prev_sess);
							foreach($sess as $ses){
								$session_id = $ses->id;
							}
							$student_state = Student_status::find_by_stdnt($student->id, $session_id);
							foreach($student_state as $std){
							$new_status->no_of_years = -1; }
							$new_status->previous_session = $prev_sess;
							$new_status->create(); //create student status for new cases save COP
							$flag=2; //new cases including transfer
						}
					}
					//resumption of cases
				}
				else{
					$cases = Cases::find_by_matric_no($student->id, "first", next_session($current_session));
						if(!empty($cases)){
							$next_status="FR";
							foreach($cases as $case){
								$prev_sess = $case->previous_session;
								 User::change_status($student->user_id, 1);
							}
							$flag=3;
						}//end of cases
					
						else{
							$prev_sess = $current_session;
							$session_id=0;
							$sess=Academic_session::find_session($prev_sess);
							foreach($sess as $ses){
								$session_id = $ses->id;
							}
							$students_state = Student_status::find_by_stdnt($student->id, $session_id);
							$next_status="";
							foreach($students_state as $state):
								$next_status = $state->case_status;
							endforeach;
							$flag=4;//resuming from a previous status
						}//no case to mark
				}
				if($next_status=="FR" && $flag!=2){
				compute_cgpa($student->id, $prev_sess);
				$session_id=0;
							$sess=Academic_session::find_session($prev_sess);
							foreach($sess as $ses){
								$session_id = $ses->id;
							}
							$students_state = Student_status::find_by_stdnt($student->id, $session_id);
				$case_status="";
				$no_of_years=0;
				$level="";
				foreach($students_state as $state):
					$promotion = $state->status;
					$case_status = $state->case_status;
					$no_of_years= $state->no_of_years;
					$level = $state->level;
				endforeach;
				$new_no_of_years=0;
				
				$new_level="";
				if($promotion!="graduated" && $promotion!="withdrawn" && $case_status!="EX" && $case_status!="TR"){
					
					if($promotion=="promoted") {
						$new_no_of_years = $no_of_years +1;
						$duration=0;
						$deptss = Departments::find_unit($student->unit);
						foreach($deptss as $dp){
							$duration = $dp->duration * 100;
						}
						if($level<$duration) {
							$new_level = $level + 100;
						}
					}
					elseif($promotion=="probation") {
						$new_no_of_years = $no_of_years+1;
						$new_level = $level;
					}
					
					Student::update_level($new_level, $student->user_id);
					
					
				$session_id=0;
				$sess=Academic_session::find_session(next_session($current_session));
				foreach($sess as $ses){
					$session_id = $ses->id;
				}
				if($prev_sess==previous_session($student->session_of_entry)){
					if($student->mode_of_entry=="UME")$new_level=100;
					else $new_level=200;
					Student::update_level($new_level, $student->user_id);
					$new_no_of_years=1;
					
				}// if a student is readmitted in the new session
				
				$new_status = new Student_status();
				$new_status->student_id = $student->id;
				$new_status->session_id = $session_id;
				$students=Student::find_by_id($student->id);
				foreach($students as $student){
				$new_status->unit = $student->unit;}
				$new_status->level = $new_level;
				$new_status->status = "pending";
				$new_status->case_status = $next_status;
				$new_status->no_of_years = $new_no_of_years;
				$new_status->previous_session = $prev_sess;
				$new_status->create();
				}
			}elseif($flag!=2 && $next_status!="FR"){
				$session_id=0;
							$sess=Academic_session::find_session($prev_sess);
							foreach($sess as $ses){
								$session_id = $ses->id;
							}
							$students_state = Student_status::find_by_stdnt($student->id, $session_id);
				$case_status="";
				$no_of_years=0;
				$level="";
				foreach($students_state as $state):
					$promotion = $state->status;
					$case_status = $state->case_status;
					$no_of_years= $state->no_of_years;
					$level = $state->level;
				endforeach;
				
				$session_id=0;
				$sess=Academic_session::find_session(next_session($current_session));
				foreach($sess as $ses){
					$session_id = $ses->id;
				}
				
				$new_status = new Student_status();
				$new_status->student_id = $student->id;
				$new_status->session_id = $session_id;
				$students=Student::find_by_id($student->id);
				foreach($students as $student){
				$new_status->unit = $student->unit;}
				$new_status->level = $level;
				$new_status->status = "pending";
				$new_status->case_status = $next_status;
				$new_status->no_of_years = $no_of_years;
				$new_status->previous_session = $prev_sess;
				$new_status->create();
			}//retained from a previous case
}
			endforeach;
			$ssession = next_session($_POST['session']);
			
			$semest = Semester::find($ssession, "first");
			if(!empty($semest)){
				foreach($semest as $semester){
					Semester::update_stat(0, $semester->id);
				}
			}else{
			$new_semester = new Semester();
			$new_semester->a_session = $ssession;
			$new_semester->name = "first";
			$new_semester->status = 0;
			$new_semester->closed = 0;
			$new_semester->save();
			}
			
                  echo '<div class="low"></div>';
                  echo '<center><table class="takon"><tr><td><h3 style="color: #777777">';
                  echo ' ACADEMIC SESSION SUCCESSFULLY ENDED</h3></td></tr></table>';
                   echo '</center><div class="low"></div>';
}else{$permit=1; //if all results have not been uploaded, display.
$message="<h3 style='color: #777777'>SESSION CANNOT CLOSE DUE TO AWAITING RESULTS!!!</h3>";
	echo '<div class="low"></div>';
	 echo '<table class="takon" style="width: 35%"><tr><td>'.$message.'</td></tr>';
	echo '<tr><td><form action="manage_session.php" method="post">';
	echo '<input class="button" type="submit" value="GO BACK" /></form></td></tr></table>';
	echo '<div class="low"></div>';
}
}
if($permit==0){//onload
?>

<div class="low"></div>
<center><form action="end_session.php" method="post">
    <table class="takon">
        <tr><td colspan=2><h3 style="color: red;">WHICH SESSION DO YOU WISH TO CLOSE?</h3></td></tr>
    <?php echo '<tr class="bold"><td><label>SESSION:</label></td><td><select name="session" class="field"><option>select session</option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		endforeach;
		echo '</select></td></tr>';
		?>
       <td ><input type="submit" name="end" value="submit" class="button" /> </td>
       <td><input type="submit" name="no" value="cancel" class="button" /></td></tr>
    </table>
</form></center>
<div class="low"></div>
<?php } echo footer(); ?>
</body>