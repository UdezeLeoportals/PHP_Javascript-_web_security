<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); };
if($session->type!="HOD" && $session->type!="admin"  && $session->type!="reg") {redirect_to("./index.php");} ?>
<head><title>Result System - Cancel a Result</title>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">
	.bold{
		margin: 30px auto;
		border-collapse: collapse;
		
		height:   40px;
	}
	.high{
        height: 30em;
	 }
	.low{
        height: 10em;
	}
	
    th, td {
 height:   40px;

font-size: 12px;
}

.normal{ 
 height: 80px; 
}

</style></head>
<body topmargin="0" style="background-color: #F8F7DF">
<?php
if($session->type=="HOD" || $session->type=='reg'){
	$state=0;
	if(isset($_POST['submit'])){
		if(!empty($_POST['code']) && !empty($_POST['session']) && ($session->type=='HOD' || ($session->type=='reg' && !empty($_POST['dept'])))  ){
	$state=1;
	$code =$_POST['code'];
	$a_session=$_POST['session'];
	$dept = (!empty($_POST['dept'])) ? $_POST['dept'] : 0;
	$all = $dept==1 ? 'ALL DEPARTMENTS' : strtoupper($dept);
	
	$courses=Course::find_by_id($code);
	$course_code=""; $title="";
	foreach($courses as $course){
		$course_code=$course->new_course_code;
		$title=$course->course_title;
	}
		echo '<div class="low"></div>';
		 echo '<center><table class="tableDesignStat" style="width: 35%"><tr><td colspan=2><h3>ARE YOU SURE YOU WANT TO CANCEL '.$course_code.': '.$title.' '.$a_session.' RESULTS';
		 if($session->type=='reg') echo 'FOR '.$all;
		 echo'?</h3></td></tr>';
		echo '<form action="cancel.php" method="post"><tr><td><input class="button" name="continue" type="submit" value="CONTINUE>>" /></td>';
		echo '<td><input class="button" type="submit" name="no" value="<<GO BACK" /></td></tr></table>';
		echo '<input type="hidden" name="code" value="'.$code.'" />';
		if($session->type=='reg') echo '<input type="hidden" name="dept" value="'.$dept.'" />';
		echo '<input type="hidden" name="session" value="'.$a_session.'" />';
		echo '</form>';
		echo '<div class="low"></div>';
		}else{
			echo '<center><i style="color:red">invalid selection!!!</i></center>';
			$state=0;
		}
	}
	if(isset($_POST['continue'])){
	echo '<div class="low"></div>';
	$state=1;
	$code =$_POST['code'];
	$a_session=$_POST['session'];
	$dept=!empty($_POST['dept']) ? $_POST['dept'] : 0;
	$all = $dept==1 ? 'ALL DEPARTMENTS' : strtoupper($dept);
	$dept_id=0;
	if(!empty($dept) && $dept!=1 && $session->type=='reg'){
		$depts = Depts::find_dept($dept);
		foreach($depts as $dp){
			$dept_id = $dp->id;
		}
	}
	
	$courses=Course::find_by_id($code);
	$sem=""; $cos='';
	foreach($courses as $course){
		$sem=$course->semester;
		$cos= $course->old_course_code;
	}
	$sem_id=0;
	$sems=Semester::find($a_session, $sem);
	foreach($sems as $semest){
		$sem_id=$semest->id;	
	}
	if($session->type=="HOD"){
		$staff=Staff::find_by_user_id($session->user_id);
		foreach($staff as $staf){
			$dept_id=$staf->dept_id;
		}
	}
	$old_result=array();
	
	if($dept==1 && $session->type=="reg"){
	  $old_result=Result::find_by_code($code, $sem_id); 	
	}
	$dep='';
		if($session->type=='HOD' || ($session->type=='reg' && !empty($dept_id))) $old_result = Result::find_code_dept( $code, $sem_id, $dept_id);
		if(!empty($old_result)){
		foreach($old_result as $result):
		
		$depg  = Depts::find_by_id($result->dept_id);
		foreach($depg as $de){
			$dep = $de->dept;
		}
		$records = Result_sheet::find_codept($code, $sem_id, $dep);
		foreach($records as $record):
			Result_sheet::change_role($record->id, 0,0,0);
		endforeach;
		
		$result->destroy();
		endforeach;
		
	$alloc=Course_allocation::find_by_code($sem_id, $code);
	$staff_id=0;
	foreach($alloc as $allocate){
		$staff_id=$allocate->staff_id;
	}
	$date=date(DateTime::RFC1123, time());
	if(!empty($alloc)){
	$title="CANCELLING OF RESULT BY THE HOD : ".strtoupper($cos);
	$snt="HOD ".strtoupper($dep)." DEPARTMENT";
	//send alert to the co-ordinator
	
 }
		$courses=Course::find_by_id($code);
	$course_code=""; $title="";
	foreach($courses as $course){
		$course_code=$course->new_course_code;
		$title=$course->course_title;
	}
		$message = '<center><h4>Results have been succesfully removed from the database</h4></center> ';
			
		
		 echo '<center><table class="tableDesignStat" style=" width: 35%"><tr><td colspan=2><h3>'.$course_code.': '.$title.' '.$a_session.' RESULTS';
		 if($session->type=='reg') echo ' FOR '.$all;
		 echo ' SUCCESSFULLY CANCELLED!!!</h3></td></tr>';
		

		echo '<tr class="bold>"><td colspan=2><center><h2>DO YOU WISH TO RE-UPLOAD THIS RESULT</h2></center></td></tr>';
		echo '<form action="upload_result.php" method="POST">';
		echo '<tr class="bold"><td><input  class="button" type="submit" name="now" value="NOW"></td>';
		echo '</form>';
		echo '<form action="cancel.php" method="POST">';
		echo '<td><input class="button" type="submit" name="later" value="LATER"></td></tr>';
		echo '</form></table></center>';
		}
		else $message="<center><i style=\"color: red\">result not in database!!!</i></center>";
		echo $message;
		
		echo '<div class="low"></div>';
	}
?>
<?php
		if($state==0||isset($_POST['no'])){
		echo '<center>';
		echo '<div style="height: 4em"></div>';
		echo '<form action="cancel.php" method="POST">';
		echo '<table class="tableDesignStat" style=" width: 35%">';
		if($session->type=="HOD"){
		$staff=Staff::find_by_user_id($session->user_id);
		$dept="";
		foreach($staff as $staf){
			$unit=$staf->unit;
			$depts = Departments::find_unit($unit);
			foreach($depts as $dety){
				$dept=$dety->dept;
			}
		}
		$courses = Prescribed_course::find_by_dept($dept);
		
		echo '<tr class="bold"><td><label>COURSE CODE:</label></td><td><select name="code" class="field"><option></option>';
		foreach($courses as $courser):
		$courd=Course::find_by_code($courser->course_code);
		foreach($courd as $course){
		 echo '<option value="'.$course->id.'">'.$course->old_course_code.'</option>';
		}
		endforeach;
		echo '</select></td></tr>';
		}
		
		if($session->type=="reg") {
			echo '<tr class="bold"><td><label>COURSE CODE:</label></td><td><select name="code" class="field"><option></option>';
			$courses = Prescribed_course::find_distinct_all();
			foreach($courses as $courser){
				$courd=Course::find_by_code($courser->course_code);
				foreach($courd as $course){
				 echo '<option value="'.$course->id.'">'.$course->old_course_code.'</option>';
				}
			}
			echo '</select></td></tr>';
			echo '<tr class="bold"><td><label>DEPARTMENT:</label></td><td><select name="dept" class="field"><option value="1">ALL DEPARTMENTS</option>';
			$dp=Depts::find_all();
			foreach($dp as $di){
				echo '<option value="'.$di->dept.'">'.$di->dept.'</option>';
			}
			echo '</select></td></tr>';
		}
		
		echo '<tr class="bold"><td><label>SESSION:</label></td><td><select name="session" class="field"><option></option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		endforeach;
		echo '</select></td></tr>';
		
		echo '<tr class="bold"><td colspan=2><input class="button" type="submit" name="submit" value="CANCEL THIS RESULT"/></td></tr></table></form></center>';
		echo '<div class="low"></div></center>';
		}
}
 ?>
<?php echo footer(); ?>
</body>