<?php require_once("./includes/initialize.php");
require_once(LIB_PATH.DS.'database.php');
?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<head><title>Result System - Promote class</title>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">

tr { 
 margin: 30px auto;
 border-collapse: collapse;

}
.low{
        height: 6em;
	}
	
</style>
</head>
<body topmargin="0" style="background-color: #F8F7DF">

<center>
<?php
$drop=0;
 if(isset($_POST['promote'])){
    
    $unit=$_POST['unit'];
    $a_session=$_POST['from'];
    $SOE = $_POST['session'];
    $sem1=0; $sem2=0;
    
    $qaw = Semester::find($a_session, 'first');
    foreach($qaw as $qw){
	$sem1 = $qw->id;
    }
    $qew = Semester::find($a_session, 'second');
    foreach($qew as $qw){
	$sem2 = $qw->id;
    }
    
    $complete = 1;
    $all_courses = Result_sheet::find_prodistinct($sem1, $sem2, $unit, $SOE, next_session($SOE));
	foreach($all_courses as $courses){
		$sem=0;
		$cos = Course::find_by_id($courses->course_id);
		foreach($cos as $s){
			$sem=$s->semester;
		}
		$sm = ($sem=='first') ? $sem1 : $sem2;
		$result = Result::find_by_code($courses->course_id, $sm);
		if(empty($result)){ echo $courses->course_id.'<br>'; $complete=0;}
	
	}//verify that the result for all registered courses has been uploaded
$session_id=0;
			$sess=Academic_session::find_session($a_session);
			foreach($sess as $ses){
				$session_id = $ses->id;
			}
    
    if($complete==1){
	echo '<center>All Results Successfully uploaded!!!</center>';
    $sessions=Academic_session::find_session(next_session($_POST['from']));
    if(!empty($a_session) && !empty($sessions)){
    $students = Student::find_by_session($_POST['session'], $_POST['unit']);
    foreach($students as $student){
	$students_state = Student_status::find_by_stdnt($student->id, $session_id);
		foreach($students_state as $stable){
		    if($stable->status!='graduated' && $stable->status!='withdrawn' && $stable->case_status!='TR' && $stable->case_status!='EX')
			promote($student->id, $_POST['from'], next_session($_POST['from']));
		}
    }
    $stude = Student::find_direct_entry(next_session($_POST['session']), $_POST['unit']);
    foreach($stude as $student){
	
	$students_state = Student_status::find_by_stdnt($student->id, $session_id);
		foreach($students_state as $stable){
		    if($stable->status!='graduated' && $stable->status!='withdrawn' && $stable->case_status!='TR' && $stable->case_status!='EX')
		    promote($student->id, $_POST['from'], next_session($_POST['from']));
		}
    }
    echo "<h4>".$_POST['unit']." ".$_POST['session']." CLASS SUCCESSFULLY PROMOTED!</h4>";
    $drop=1;
    }else{
	echo '<center>Promotion failed: Invalid Session</center>';
	
    }
    }else{
	echo '<center>Promotion failed: Incomplete Results</center> ';
    }
 }
  
 if($drop==0){
?>
<form action="promo.php" method="post" >
<h3>PROMOTE A CLASS OF STUDENTS</h3>
<div class="low"></div>
   <table class="tableDesignStat" style="width: 45%;">
   <?php  echo '<tr class="bold"><td><label>SESSION OF ENTRY (UME):</label></td><td><select name="session" class="field"><option></option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		endforeach;
		echo '</select></td></tr>';
	    ?>
             <?php  echo '<tr class="bold"><td><label>PROMOTE FROM:</label></td><td><select name="from" class="field"><option></option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		endforeach;
		echo '</select></td></tr>';
	    ?>
	   
            <tr><td><b><label>UNIT</label></b></td><td><select name="unit" class="field"><option></option>
	    <?php
		$depts = Departments::find_all();
		foreach($depts as $dept){
		    echo '<option value="'.$dept->unit.'">'.$dept->unit.'</option>';
		}
	    ?>
	    </select></td></tr>
   <tr><td colspan=2> <input class="button" type="submit" name="promote" value="SUBMIT" /></td></tr></table>
</form></center>
<div class="low"></div>
<?php }echo footer(); ?>
</body>