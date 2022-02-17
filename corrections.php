<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<head><title>Result System - Edit Result</title>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">
	table{
		margin: 30px auto;
		border-collapse: collapse;
		
		width:   40%;
	}
	.td{
        border:  1px solid black;
	 }
	 .high{
        height: 8em;
    }
	.low{
        height: 33em;
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
$drop=0;
$opr=empty($_GET['opr'])? 0 : $_GET['opr'];
$opr=empty($_POST['opr']) ? $opr : $_POST['opr'];
if(isset($_POST['edit'])){
	if(!empty($_POST['assess']) && !empty($_POST['exam'])){
		if($_POST['type']=="edt"){
	if(!empty($_POST['id'])) $results = Result_sheet::find_by_id($_POST['id']);
	foreach($results as $res){
		$init_exam = $res->exam_score; $init_assess = $res->assessment;
		Result_sheet::change_role($res->id, $_POST['assess'], $_POST['exam'], $res->status);
		$code=0;
		$coure=Course::find_by_id($res->course_id);
		foreach($coure as $cous){
			$code=$cous->new_course_code;
		}
		$students =Student::find_by_id($res->student_id);
		$matric_no=""; $std_name = '';
		foreach($students as $student){
			$matric_no=$student->matric_no;
			//$std_name = $student->get_fullname; 
		}
		$alloc = Course_allocation::find_by_code($res->semester_id, $res->course_id);
		foreach($alloc as $allo){
			
			$stff=Staff::find_by_id($allo->staff_id);
			foreach($stff as $staf){
				$message=$staf->message.'<br> '.$code.' Successfully editted to a total of '.total($_POST['assess'], $_POST['exam']).' for '.$matric_no;
				Staff::change_message($staf->id, $message);
			}
		}
		$drop=1;
		//AUDIT TRAIL
	$staffm = Staff::find_by_user_id($session->user_id);
		foreach($staffm as $staff){
			//$name = $staff->get_fullname;
			$unit = $staff->unit;
		}
		$a_session='';
		$sems = Semester::find_by_id($res->semester_id);
		foreach($sems as $sem){
		    $a_session = $sem->a_session;
		}
	$message2 = 'BY '.$session->username.' '.$unit.' '.$session->type;
	$message2 .= '<br><b> FOR '.$matric_no.' '.$code.' '.$a_session.' </b>';
	$message2 .= '<br> Initial scores: Assessment - '.$init_assess.' Exam - '.$init_exam;
	$message2 .= '  Updated scores: Assessment - '.$_POST['assess'].' Exam - '.$_POST['exam'];
	audit_action("<b>CORRECTION OF RESULTS (EDIT)</b>", $message2);
	
		$message= "UPDATE SUCCESSFUL!!!";
		echo '<div class="high"></div><div class="low">';
		 echo '<table class="takon" style="width: 35%"><tr><td><h3>'.$message.'</h3></td></tr>';
	echo '<tr><td><form action="edit.php" method="post">';
	echo '<input class="button" type="submit" value="GO BACK" /></form></td></tr></table></div>';
	}
	}
		if($_POST['type']=="ins"){//insert scores
			$matric_no=$_POST['matric_no'];
			$stds=Student::find_by_matric($matric_no);
			$std_id=0;  $std_name='';
			foreach($stds as $std){
				$std_id=$std->id;
				//$std_name = $std->get_fullname;
			}
			$cos_id=0; $seme="";
			$coss=Course::find_by_code($_POST['code']);
			foreach($coss as $cos){
				$cos_id=$cos->id;
				$seme=$cos->semester;
			}
			$sems=Semester::find($_POST['session'], $seme);
			$s3em=0;
			foreach($sems as $sem){
				$s3em=$sem->id;
			}
			$code=$_POST['code'];
			$new=new Result_sheet();
			$new->student_id=$std_id;
			$new->course_id=$cos_id;
			$new->semester_id=$s3em;
			$new->status=1;
			$new->assessment=$_POST['assess'];
			$new->exam_score=$_POST['exam'];
			$new->create();
			echo ' Successfully inserted a total of '.total($_POST['assess'], $_POST['exam']).' for '.$matric_no;
			
			
			//AUDIT TRAIL
			$staffm = Staff::find_by_user_id($session->user_id);
		foreach($staffm as $staff){
			//$name = $staff->get_fullname;
			$unit = $staff->unit;
		}
		$a_session='';
		$sems = Semester::find_by_id($s3em);
		foreach($sems as $sem){
		    $a_session = $sem->a_session;
		}
	$message2 = 'BY '.$session->username.' '.$unit.' '.$session->type;
	$message2 .= '<br><b> FOR '.$matric_no.' '.$_POST['code'].' '.$a_session.' </b>';
	$message2 .= ' <br> New scores: Assessment - '.$_POST['assess'].' Exam - '.$_POST['exam'];
	audit_action("<b>INSERTION OF RAW SCORES </b>", $message2);
		
		$alloc = Course_allocation::find_by_code($new->semester_id, $new->course_id);	
		foreach($alloc as $allo){
			$stff=Staff::find_by_id($allo->staff_id);
			foreach($stff as $staf){
				$message=$staf->message.'<br> '.$code.' Successfully editted to a total of '.total($_POST['assess'], $_POST['exam']).' for '.$matric_no;
				Staff::change_message($staf->id, $message);
			}
		}
		}
	}else echo '<h3><center><i style="color:red">ERROR!!! INVALID SCORES!!!</i></center></h3>';
}
if(isset($_POST['ya'])){
	$std_id=(int) $_POST['std'];
	$couse=(int) $_POST['cos'];
	$sem_id=(int) $_POST['sem'];
	if($_POST['type']=="score"){
	$results = Result_sheet::find_record($std_id, $couse, $sem_id);
			if(!empty($results)){
				$init_assess = 0; $init_exam=0;
				foreach($results as $result){
					$init_assess = $result->assessment; $init_exam = $result->exam_score;
					Result_sheet::delete($result->id);
					echo '<center><i style="color: red;">Result successfully deleted!!!</i></center>'; $opr=0;
				}
				
				//AUDIT TRAIL
				$staffm = Staff::find_by_user_id($session->user_id);
				foreach($staffm as $staff){
					//$name = $staff->get_fullname;
					$unit = $staff->unit;
				}
				$a_session='';
				$sems = Semester::find_by_id($sem_id);
				foreach($sems as $sem){
				    $a_session = $sem->a_session;
				}
				$students =Student::find_by_id($std_id);
				$matric_no=""; $std_name = '';
				foreach($students as $student){
					$matric_no=$student->matric_no;
					//$std_name = $student->get_fullname; 
				}
				$code=0;
				$coure=Course::find_by_id($couse);
				foreach($coure as $cous){
					$code=$cous->new_course_code;
				}
				$message2 = 'BY '.$session->username.' '.$unit.' '.$session->type;
				$message2 .= '<br><b> FOR '.$matric_no.' '.$code.' '.$a_session.' </b>';
				$message2 .= ' <br> Previous scores: Assessment - '.$init_assess.' Exam - '.$init_exam;
				audit_action("<b>DELETION OF RECORD</b>", $message2);
				
			}else{
				echo '<center><i style="color: red;">Result does not exist!!!</i></center>'; $opr=0;
			}
	}
	if($_POST['type']=="drop"){
			$takes=Take_courses::find_by_sem($sem_id, $std_id, $couse);
			if(!empty($takes)){
				foreach($takes as $take){
					Take_courses::delete($take->id);
					echo '<center><i style="color: red;">Take course successfully deleted!!!</i></center>'; $opr=0;
				}
				
			//AUDIT TRAIL
				$staffm = Staff::find_by_user_id($session->user_id);
				foreach($staffm as $staff){
					//$name = $staff->get_fullname;
					$unit = $staff->unit;
				}
				$a_session='';
				$sems = Semester::find_by_id($sem_id);
				foreach($sems as $sem){
				    $a_session = $sem->a_session;
				}
				$students =Student::find_by_id($std_id);
				$matric_no=""; $std_name = '';
				foreach($students as $student){
					$matric_no=$student->matric_no;
					//$std_name = $student->get_fullname; 
				}
				$code=0;
				$coure=Course::find_by_id($couse);
				foreach($coure as $cous){
					$code=$cous->new_course_code;
				}
				$message2 = 'BY '.$session->username.' '.$unit.' '.$session->type;
				$message2 .= '<br><b> FOR '.$matric_no.' '.$code.' '.$a_session.' </b>';
				audit_action("<b>DELETION OF TAKE COURSE</b>", $message2);	
				
			}else{
				echo '<center><i style="color: red;">Take course does not exist!!!</i></center>'; $opr=0;
			}
	}
}
	if(isset($_POST['correct'])){
		
            $matric_no = $_POST['matric'];
	    $std_id=0; $unit=""; $unit_id=0;
	    $students=Student::find_by_matric($_POST['matric']);
	    if(!empty($students)){
	    foreach($students as $student){
		$std_id=$student->id;$unit=$student->unit;
	    }
            $dpts = Departments::find_unit($unit);
            foreach($dpts as $dpt){
                $unit_id = $dpt->id;
            }
	    $couse=0;
	    $semes="";
	    $sem_id=0;
	    $type="";
	    $courses = Course::find_by_code($_POST['code']);
	    foreach($courses as $course){
		$couse=$course->id;
		$semes=$course->semester;
	}
            $current_sem=0;
            $incumb = Semester::find_active();
            foreach($incumb as $inc){
                $current_sem = $inc->id;
            }
            $hea = Officers::find_office($unit_id, 'department', $current_sem, 'head');
            $head_id=0;
            foreach($hea as $he){
                $head_ = Staff::find_by_id($he->staff_id);
                foreach($head_ as $hed){
                    $head_id = $hed->user_id;
                }
            }
	    //echo $unit_id;
	    //echo $current_sem;
            $xamo = Officers::find_office($unit_id, 'department', $current_sem, 'exam_officer');
            $xamo_id=0;
            foreach($xamo as $xams){
                $xamo_ = Staff::find_by_id($xams->staff_id);
                foreach($xamo_ as $xam){
                    $xamo_id = $xam->user_id;
                }
            }
            
            $a_session = Semester::find($_POST['session'], $semes);
	    foreach($a_session as $ses){
		$sem_id=$ses->id;
	    }
	    $pred=Prescribed_course::find($couse, $unit, $sem_id);
	    foreach($pred as $pres){
		$type=$pres->type;
	    }
		$hod=User::find_by_id($head_id);
		$hod_correct=0;
		foreach($hod as $bin){
			if(md5($_POST['HOD'])==$bin->password)	$hod_correct=1;
		}
		$eo=User::find_by_id($xamo_id);
		$ceo=0;
		foreach($eo as $ex){
			if(md5($_POST['exam_officer'])==$ex->password) $ceo=1;
		}
		$coord=Course_allocation::find_by_code($sem_id, $couse);
		if(empty($coord)){
			$coord=Course_allocation::find($couse, $sem_id);
		}
		$lect=0;
		foreach($coord as $cod){
			$stafff=Staff::find_by_id($cod->staff_id);
			foreach($stafff as $staf){
				$users=User::find_by_id($staf->user_id);
				foreach($users as $user){
					if($user->password==md5($_POST['co-ordinator'])) $lect=1;
				}
			}
		}
		if($hod_correct==1 && $ceo==1 && (($lect==1 &&($type=="departmental" || $type=="elective"))|| $type!="departmental")){
			if($opr==1){//edit score
			$results = Result_sheet::find_record($std_id, $couse, $sem_id);
			if(!empty($results)){
				foreach($results as $result){
					echo '<center><form action="corrections.php?opr=1" method="post">';
					echo '<table class="tableDesignStat" style="width: 35%">';
					$students=Student::find_by_matric($_POST['matric']);
					$name_of_std ='';
					foreach($students as $student){
						$name_of_std = $student->surname." ".$student->first_name." ".$student->middle_name;
					}
					echo '<tr><td colspan=2><center>STUDENT NAME</center></td><td colspan=2><center>'.$name_of_std.'</center></td></tr>';
					echo '<tr><td colspan=2><center>MATRIC NO</center></td><td colspan=2><center>'.$_POST['matric'].'</center></td></tr>';
					echo '<tr><td colspan=2><center>COURSE CODE</center></td><td colspan=2><center>'.$_POST['code'].'</center></td></tr>';
					echo '<tr><td colspan=4><center>OLD SCORES</center></td></tr><tr><td>ASSESSMENT</td><td><input type="text" name="assess1" value="'.$result->assessment.'" class="field"/></td>';
					echo '<td>EXAM SCORE</td><td><input type="text" name="exam2" value="'.$result->exam_score.'" class="field"/></td></tr><input type="hidden" name="type" value="edt" />';
					echo '<input type="hidden" name="id" value="'.$result->id.'" /><tr ></tr><tr><td colspan=4><center>CORRECT SCORES</center></td></tr>';
					echo '<tr><td>ASSESSMENT</td><td><input type="text" name="assess" class="field" /></td>';
					echo '<td>EXAM SCORE</td><td><input type="text" name="exam"  class="field"/></td></tr>';
					echo '<tr><td colspan=4><input type="submit" name="edit" value="EDIT" class="button"/></td></tr></table></center>';				
					$opr=0;
				}
			}else{ echo "!!!";
			$opr=0;
			}
		}elseif($opr==2){//insert score
			$results = Result_sheet::find_record($std_id, $couse, $sem_id);
			if(empty($results)){
				echo '<center><form action="corrections.php?opr=2" method="post">';
					echo '<table class="tableDesignStat" style="width: 35%">';
					echo '<tr><td colspan=2><center>MATRIC NO</center></td><td colspan=2><center>'.$_POST['matric'].'</center></td></tr>';
					echo '<tr><td colspan=4><center>NEW SCORES</center></td></tr><input type="hidden" name="type" value="ins" />';
					echo '<tr><td>ASSESSMENT</td><td><input type="text" name="assess" class="field" /></td><input type="hidden" name="matric_no" value="'.$_POST['matric'].'" />';
					echo '<td>EXAM SCORE</td><td><input type="text" name="exam"  class="field"/></td></tr><input type="hidden" name="code" value="'.$_POST['code'].'" /><input type="hidden" name="session" value="'.$_POST['session'].'" />';
					echo '<tr><td colspan=4><input type="submit" name="edit" value="EDIT" class="button"/></td></tr></table></center>';				
					$opr=0;
			}else{
				echo '<center><i style="color: red;">Result already exists!!!</i></center>'; $opr=0;
			}
		}elseif($opr==3){//delete score
			$results = Result_sheet::find_record($std_id, $couse, $sem_id);
			if(!empty($results)){
			echo '<div class="high"></div><div class="low">';
			$message="ARE YOU SURE YOU WISH TO DELETE THIS RECORD?";
			echo '<table class="tableDesognStat" style="width: 35%"><tr><td><h3>'.$message.'</h3></td></tr>';
			echo '<tr><td><form action="corrections.php" method="post">';
			echo '<input type="hidden" name="std" value="'.$std_id.'" />';
			echo '<input type="hidden" name="cos" value="'.$couse.'" />';
			echo '<input type="hidden" name="type" value="score" />';
			echo '<input type="hidden" name="sem" value="'.$sem_id.'" />';
			echo '<input class="button" type="submit" value="DELETE" name="ya" />&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="button" type="submit" value="NO" name="no" /></form></td></tr></table>';
			echo '</div>';$opr=0;
			}else{
				echo '<center><i style="color: red;">Result does not exist!!!</i></center>'; $opr=0;
			}
		}elseif($opr==4){//drop course
			$takes=Take_courses::find_by_sem($sem_id, $std_id, $couse);
			if(empty($takes)){
				$tk= new Take_courses();
				$tk->student_id = $std_id;
				$tk->semester_id = $sem_id;
				$tk->course_id = $couse;
				$tk->create();
				echo '<center><i style="color: red;">Course successfully dropped!!!</i></center>';
				
				//AUDIT TRAIL
				$staffm = Staff::find_by_user_id($session->user_id);
				foreach($staffm as $staff){
					//$name = $staff->get_fullname;
					$unit = $staff->unit;
				}
				$a_session='';
				$sems = Semester::find_by_id($sem_id);
				foreach($sems as $sem){
				    $a_session = $sem->a_session;
				}
				$students =Student::find_by_id($std_id);
				$matric_no=""; $std_name = '';
				foreach($students as $student){
					$matric_no=$student->matric_no;
					//$std_name = $student->get_fullname; 
				}
				$code=0;
				$coure=Course::find_by_id($couse);
				foreach($coure as $cous){
					$code=$cous->new_course_code;
				}
				$message2 = 'BY '.$session->username.' '.$unit.' '.$session->type;
				$message2 .= '<br><b> FOR '.$matric_no.' '.$code.' '.$a_session.' </b>';
				audit_action("<b>DROPPING OF TAKE COURSE</b>", $message2);
				
			}else{
				echo '<center><i style="color: red;">Course already dropped!!!</i></center>'; $opr=0;
			}
		}elseif($opr==5){//delete dropped course
			$takes=Take_courses::find_by_sem($sem_id, $std_id, $couse);
			if(!empty($takes)){
			echo '<div class="high"></div><div class="low">';
			$message="ARE YOU SURE YOU WISH TO DELETE THIS RECORD?";
			echo '<table class="tableDesignStat" style="width: 35%"><tr><td><h3>'.$message.'</h3></td></tr>';
			echo '<tr><td><form action="corrections.php" method="post">';
			echo '<input type="hidden" name="std" value="'.$std_id.'" />';
			echo '<input type="hidden" name="cos" value="'.$couse.'" />';
			echo '<input type="hidden" name="type" value="drop" />';
			echo '<input type="hidden" name="sem" value="'.$sem_id.'" />';
			echo '<input class="button" type="submit" value="DELETE" name="ya" />&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="button" type="submit" value="NO" name="no" /></form></td></tr></table>';
			echo '</div>'; $opr=0;
			}else{
				echo '<center><i style="color: red;">Take course does not exist!!!</i></center>'; $opr=0;
			}
		}
		//echo '<center><i style="color: blue;"><h4>Operation was successful!!!</h4></i></center>';
		}else {	$off=""; 
			if($hod_correct!=1) $off="HOD";
			elseif($ceo!=1 ) $off="EXAM OFFICER";
			elseif($lect!=1) $off="CO-Ordinator";
			echo '<center><i style="color: red;"> '.$off.' password incorrect!!!</i></center>';
		}
        }else{echo '<center><i style="color: red;">Invalid matric no!!!</i></center>';
	$opr=0;
	}
	}
      if($opr!=0){  
?>
<center><form action="corrections.php" method="POST">

   <table class="tableDesignStat"><tr><td><label> MATRIC NO: </label></td><td><input type="text" name="matric" class="field"/></td></tr>
	<?php $courses = Course::find_all();
   echo '<tr><td><label>COURSE CODE:</label></td><td><select name="code" class="field"><option>Select course</option>';
		foreach($courses as $course):
		 echo '<option value="'.$course->old_course_code.'">'.$course->old_course_code.'</option>';
		endforeach;
		echo '</select></td></tr>';
		echo '<tr><td><label>SESSION:</label></td><td><select name="session" class="field"><option>Select session</option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		endforeach;
		echo '</select></td></tr>';
		
?><tr><td><label>HOD'S PASSWORD</label></td><td><input type="password" name="HOD" class="field"/></td></tr>
<input type="hidden" name="opr" value="<?php echo $opr; ?>" />
   <tr><td><label>EXAM OFFICER'S PASSWORD</label></td><td><input type="password" name="exam_officer" class="field"/></td></tr>
   <tr><td><label>CO-ORDINATOR'S PASSWORD</label></td><td><input type="password" name="co-ordinator" class="field"/></td></tr>
    <tr><td colspan=2><input type="submit" name="correct" value="submit" class="button"></td></tr></table></center>
</form>

<?php }?>
<?php echo footer(); ?>
</body>