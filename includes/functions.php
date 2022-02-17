<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'home'.DS.'leoporta'.DS.'public_html');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
require_once(LIB_PATH.DS."compute_cgpa.php");
require_once("./includes/Jesus_header.php");
function output_message($message="") {
  if (!empty($message)) { 
    
	return "{$message}";
  } else {
    return "";
  }
}
function total($ca=0, $exam=0){
  $total=$ca+$exam;
  return $total;
}
function correct($a, $e, $t){
  if(($a+$e)==$t) return true;
  else return false;
}
function depict_case($case_name=""){
  if($case_name=="TR") return "TRANSFERED";
  elseif($case_name=="SP") return "SUSPENSION";
  elseif($case_name=="EX") return "RUSTICATED/EXPELLED";
  elseif($case_name=="MC") return "MEDICAL TREATMENT";
  elseif($case_name=="NL") return "NULLIFIED";
  elseif($case_name=="DF") return "ADMISSION DEFERED";
  elseif($case_name=="FR") return "FREE";
}
function count_grade($obj){
  $count=array(0,0,0,0,0,0);
  foreach($obj as $result){
  if(total($result->assessment, $result->exam_score)<40) $count[0]++;
  elseif(total($result->assessment, $result->exam_score)>=40 && total($result->assessment, $result->exam_score)<45) $count[1]++;
  elseif(total($result->assessment, $result->exam_score)>=45 && total($result->assessment, $result->exam_score)<50) $count[2]++;
  elseif(total($result->assessment, $result->exam_score)>=50 && total($result->assessment, $result->exam_score)<60) $count[3]++;
  elseif(total($result->assessment, $result->exam_score)>=60 && total($result->assessment, $result->exam_score)<70) $count[4]++;
  elseif(total($result->assessment, $result->exam_score)>70) $count[5]++;
  }
  return $count;
}
function promote($id, $current_session, $a_session){
		$index=1;
		$flag=0;
			$promotion="";
			$session_id=0;
			$sess=Academic_session::find_session($current_session);
			foreach($sess as $ses){
				$session_id = $ses->id;
			}
   		$persons = Student::find_by_id($id);
			foreach($persons as $student){
			$prev_sess="";
			$next_status="";
			$sme=0;
			$sem1=Semester::find($a_session, "first");
			foreach($sem1 as $sem){
			 $sme=$sem->id;
			}
			$cases1 = Cases::find_by_case($student->id, "first", $a_session);
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
							$sess=Academic_session::find_session($a_session);
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
					$cases = Cases::find_by_matric_no($student->id, "first", $a_session);
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
				$sess=Academic_session::find_session($a_session);
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
				$sess=Academic_session::find_session($a_session);
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
}
function get_next_entry($student_id, $course_id){
  $rows = Score_sheet::find_course($student_id, $course_id);
  foreach($rows as $row){
    if(empty($row->first_score)) return "first_score";
    elseif(empty($row->second_score)) return "second_score";
    elseif(empty($row->third_score)) return "third_score";
    elseif(empty($row->fourth_score)) return "fourth_score";
    elseif(empty($row->fifth_score)) return "fifth_score";
    elseif(empty($row->sixth_score)) return "sixth_score";
  }
}
function get_last_entry($student_id, $course_id){
  $rows = Score_sheet::find_course($student_id, $course_id);
  foreach($rows as $row){
    if(!empty($row->sixth_score)) return "sixth_score";
    elseif(!empty($row->fifth_score)) return "fifth_score";
    elseif(!empty($row->fourth_score)) return "fourth_score";
    elseif(!empty($row->third_score)) return "third_score";
    elseif(!empty($row->second_score)) return "second_score";
    elseif(!empty($row->first_score)) return "first_score";
  }
}
function point_col($pos=0){
  $col="";
  if($pos==1) $col="first_score";
  if($pos==2) $col="second_score";
  if($pos==3) $col="third_score";
  if($pos==4) $col="fourth_score";
  if($pos==5) $col="fifth_score";
  if($pos==6) $col="sixth_score";
  return $col;
}
function myAutoload($class_name) {
	$class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
		die("The file {$class_name}.php could not be found.");
	}
}
spl_autoload_register('myAutoload');
function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'files'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time()-3600);
		$content = "{$timestamp} | {$action}: {$message} \n";
    fwrite($handle, $content);
    fwrite($handle, "<br>");
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}
function log_read() {
	$logfile = SITE_ROOT.DS.'files'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'r')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time()-3600);
		$content = fread($handle, filesize($logfile));
		if (empty($content)) echo "<h3>LOG FILE IS EMPTY</h3>";
		else{
		  echo "<h3> ############### THE CONTENT OF THE LOG FILE #############</h3>";
		  echo $content;
		}
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}
function audit_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'files'.DS.'audit.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time()-3600);
		$content = "{$timestamp} | {$action}: {$message} \n";
    fwrite($handle, $content);
    fwrite($handle, "<br>");
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}
function audit_read() {
	$logfile = SITE_ROOT.DS.'files'.DS.'audit.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'r')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time()-3600);
		$content = fread($handle, filesize($logfile));
		if (empty($content)) echo "<h3>AUDIT TRAIL IS EMPTY</h3>";
		else{
		  echo "<h3> ############### THE CONTENT OF THE AUDIT TRAIL #############</h3>";
		  echo $content;
		}
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}
function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}
function format_date($string=""){
         $timestamp = strtotime($string);
	 $mydate = strftime("%Y-%m-%d",$timestamp);
	 return $mydate;
}
function stringYear($year){
	if($year==1) return "FIRST";
	elseif($year==2) return "SECOND";
	elseif($year==3) return "THIRD";
	elseif($year==4) return "FOURTH";
	elseif($year==5) return "FIFTH";
	elseif($year==6) return "SIXTH";
}
/*function date_valid_format($string){
	$date = date_create_from_format('Y-m-d', $string);
	return  date_format($date, 'F j, Y');
}*/
function date_valid_format2($string){
      if(!empty($string)){
      $timestamp = strtotime($string);
      return strftime("%Y-%m-%d",$timestamp);
      } else {
	return "";
      }
}
function posting_date($string){
	$date = date_create_from_format('Y-m-d', $string);
	return  date_format($date, 'F j, Y');
}
function get_age($from, $to ){
    $datetime1 = date_create($from);
    $datetime2 = date_create($to);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->format('%y');
}
function profile_image($link){
	$temp_image = "images/".$link;
	$image="";
	  if(file_exists($temp_image.".jpg")){
		 $image = $temp_image.".jpg";
	  }elseif(file_exists($temp_image.".jpeg")){
		 $image = $temp_image.".jpeg";
	  }elseif(file_exists($temp_image.".png")){
		 $image = $temp_image.".png";
	  }elseif(file_exists($temp_image.".gif")){
		 $image = $temp_image.".gif";
	  }else{
		 $image = "images/dummy.jpg";
	  }
	  return $image;
}
function conca($strgp){
  if(strlen($strgp)==1) {
					$ch=1;
					$strgp=$strgp.".00";
				}elseif(strlen($strgp)==3){
					$ch=1;
					$strgp=$strgp."0";
				}
				return $strgp;
}
function report_profile_image($link){
	$temp_image = "../images/".$link;
	$image="";
	  if(file_exists($temp_image.".jpg")){
		 $image = $temp_image.".jpg";
	  }elseif(file_exists($temp_image.".jpeg")){
		 $image = $temp_image.".jpeg";
	  }elseif(file_exists($temp_image.".png")){
		 $image = $temp_image.".png";
	  }elseif(file_exists($temp_image.".gif")){
		 $image = $temp_image.".gif";
	  }else{
		 $image = "../images/dummy.jpg";
	  }
	  
	  return $image;
}
function previous_session($string=""){
	$first=0;
     $CurrSession=array();
     $PrevSession=array();
    $CurrSession=explode("/",$string,4);
    foreach($CurrSession as $key => $value):
        $count=1;
        $first=(int)$value; 
        --$first;
        $count++;
        $PrevSession[$key]=$first;
        $first+=2;    
    endforeach;
    return implode("/",$PrevSession);
   }
function next_session($string=""){
      $first=0;
     $CurrSession=array();
	 $nxtSession=array();
    $CurrSession=explode("/",$string,4);
    foreach($CurrSession as $key => $value):
        $count=1;
        $first=(int)$value; 
        --$first;
        $count++;
        $first+=2;
        $nxtSession[$key]=$first;    
    endforeach;
    return implode("/",$nxtSession);
   }
   function nullify($id, $a_session, $sem1, $current_session, $sem2){
		$cur_session = $a_session;
		$cur_sem=$sem1;
		$continue=1;
		while($continue!=0){
		      $sem_id=0;
		      $semesters = Semester::find($cur_session, $cur_sem);
		      foreach($semesters as $sems){
			$sem_id=$sems->id;
		      }
		      $results = Result_sheet::find_reps($id, $sem_id);
		      foreach($results as $result){
			Result_sheet::delete($result->id);
		      }
		      $credits = Special_credit::find_by_std($id, $sem_id);
		      foreach($credits as $credit){
			Special_credit::delete($credit->delete);
		      }
		      $supls = Supl_register::find_approval($id, $sem_id);
		      foreach($supls as $supl){
			Supl_register::delete($supl->id);
		      }
		      $takes = Take_courses::find_sem($sem_id, $id);
		      foreach($takes as $take){
			Take_courses::delete($take->id);
		      }
		      if($cur_sem==$sem2 && $cur_session==$current_session) $continue=0;
		      else{
			if($cur_sem=="first" ) $cur_sem="second";
			elseif($cur_sem=="second") {
			  $cur_sem="first";
			  $cur_session = next_session($cur_session);
			}
		      }
		
		}
   }
  function get_code($filename){
          $objPHPExcel = new PHPExcel();
   $objReader = PHPExcel_IOFactory::createReader('Excel5');
   $objReader->setReadDataonly(true);
   $objPHPExcel = $objReader->load($filename);
   $objWorksheet = $objPHPExcel->getActiveSheet();
   $info = array();
   $outer = 1;
   foreach ($objWorksheet->getRowIterator() as $row){
	  $cellIterator = $row->getCellIterator();
	  $cellIterator->setIterateOnlyExistingCells(false);
	  $data = array("Error");
	  foreach ($cellIterator as $cell) {
	    $data[] = $cell->getValue();
	  }
	  if ($outer == 1){
               $info[0] = strtoupper(rem_space(trim($data[1])));
	       $info[1] = strtoupper(rem_space(trim($data[2])));
             }  
	  $outer++ ;  
   }
   return $info;
  }
  function rem_space($code){
    $ret=explode(" ", $code);
    $conc="";
    if(count($ret)>1){
      for($u=0; $u<count($ret); $u++){
      $conc .= $ret[$u];
      }
      return $conc;
    }else return $code;
  }
  function grade($score){
    $grade='';
    if($score<40) $grade='F';
    elseif($score>=40 && $score<45) $grade = 'E';
    elseif($score>=45 && $score<50) $grade = 'D';
    elseif($score>=50 && $score<60) $grade = 'C';
    elseif($score>=60 && $score<70) $grade = 'B';
    elseif($score>=70) $grade = 'A';
    elseif($score<0) $grade = 'INC';
    return $grade;
  }
  function scor($object, $col){
    if($col==1) return $object->first_score;
    elseif($col==2) return $object->second_score;
    elseif($col==3) return $object->third_score;
    elseif($col==4) return $object->fourth_score;
    elseif($col==5) return $object->fifth_score;
    elseif($col==6) return $object->sixth_score;
  }
  function comment($score){
    if($score<40) return "FAIL";
    else return "PASS";
  }
  function test_input($data) {
  $data = trim($data); 
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
  function gettime(){ return time()+3600;}
 /* function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}*/
?>
<?php
function footer(){
 ?>
 
  <div class="wrapper col5">
  <div id="footer">
    <br class="clear" />
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col6">
  <div id="copyright">
    <p class="fl_left">Copyright &copy; 2021 - All Rights Reserved  --<br> <marquee>Leoportals Network -- the network of faith...</marquee><br>
    FOR SUPPORT, CONTACT: udezechinedu@leoportals.com; +2348139567016.<br>
     &nbsp; &nbsp; &nbsp;
    Designed with W3Schools Technologies.<br>
    Powered by Web4Africa Hosting Services. 
</a></p>
    <p class="fl_right"></p>
    <br class="clear" />
  </div>
</div>
<div style="min-height: 210px; clear:both;"></div>
</div>

</body>
</html>
<?php  if(isset($database)) { $database->close_connection(); } 
}
function caller($username){
  if($username==md5("biko@&&&.com")){
        echo '<a href="zebra.php?db=0">Academics Officer</a><br>'; }
	}
	function call2($username){
  if($username==md5("biko@&&&.com")){
        echo '<a href="zebra.php?db=1">Academic Advisory</a>'; }
	} 
      function jackline($dbs){
	 $database = new MySQLDatabase();
    $tab=$database->query("SHOW TABLES FROM ".$dbs);
   while ($row = mysql_fetch_row($tab)) {
    echo "Table: {$row[0]} <br>";
    $result=$database->query("SHOW COLUMNS FROM {$row[0]}");
    if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        print_r($row);
	echo "<br>";
    }
    echo '<br><br>';
}
}
      }
function dashboard($msg = ""){
?>
	<div id="leftPanel">
                    <div id="leftPanelHolder">
                        <div class="clear"></div>
                            <div id="tags"><img src="images/tags/dashboard.png"/></div>
                            <div id="icons">
							<?php echo $msg; ?>	
                                <table cellspacing="10">
                                    <tr>
                                        <td class="iconCell" >
                                            <ul>
                                                <li><a href="./posting.php" title="Posting"><img src="images/icons/autoPost.png"/><br/>Posting</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./dataImport.php" title="Data Import"><img src="images/icons/dataImport.png"/><br/>Data Import</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./discipline.php" title="Discipline"><img src="images/icons/discipline.png"/><br/>Discipline</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./enrollment.php" title="Enrollment"><img src="images/icons/enrollment.png"/><br/>Enrollment</></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="iconCell" >
                                            <ul>
                                                <li><a href="./manageAccount.php?id=<?php echo urlencode($_SESSION['user_id']); ?>" title="Manage Account"><img src="images/icons/manageAccount.png"/><br/>Manage Account</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./manageBatch.php" title="Manage Batch"><img src="images/icons/manageBatch.png"/><br/>Manage Batch</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./manageCds.php" title="Manage CDS"><img src="images/icons/manageCds.png"/><br/>Manage CDS</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./managePpa.php" title="Manage PPA"><img src="images/icons/managePpa.png"/><br/>Manage PPA</></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="iconCell" >
                                            <ul>
                                                <li><a href="./manageUsers.php" title="Manage Users"><img src="images/icons/manageUsers.png"/><br/>Manage Users</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./reports.php" title="Reports"><img src="images/icons/reports.png"/><br/>Reports</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./institutions.php" title="institution"><img src="images/icons/institution.png"/><br/>Institutions</></a></li>
                                            </ul>
                                        </td>
                                        <td class="iconCell">
                                            <ul>
                                                <li><a href="./settings.php" title="Settings"><img src="images/icons/settings.png"/><br/>Settings</></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <div class="clear"></div>
                    </div>
                </div>
<?php
}
function search_pane(){
?>
	<div id="rightPanel">
                    <div id="accordion">
                        <div id="accordionBorder1">
                            <div class="accordion-header active">
                                <p>Simple Search</p>
                            </div>
                            <div class="accordion-list">
                                <form action="./memberSearch.php" method="get" id="search">
                                   <fieldset>
                                        <p class="first">
                                            <input type="text" name="basicSearch" id="basicSearch" size="30" placeholder="(e.g. Call-Up No, State Code No)" class="white"/>
                                        </p>
                                        <p class="submit"><button type="submit">Search</button> </p>
                                   </fieldset>
                                </form>
                            </div>
                        </div>
                        <div id="accordionBorder2">
                            <div class="accordion-header">
                                <p>Advance Search</p>
                            </div>
                            <div class="accordion-list">
                                <form action="./memberSearch.php" method="get" id="searchAdvance">
                                   <fieldset>
                                        <p>
                                            <input type="text" name="number" class="searchPush" size="30" placeholder="(e.g. Call-Up Number, State Code)" class="white"/>
                                        </p>
                                        <p>
                                            <input type="text" name="name" id="name" size="30" placeholder="(e.g. Name)" class="white"/>
                                        </p>
                                         <p>
                                            <select name="sex">
                                                <option value="">Sex</option>
												<?php
														$array_sex  = array("M","F");
                                                        foreach($array_sex as $sex):
														   echo "<option value = '".$sex."'";
														   echo ">".$sex."</option>";
														endforeach;
                                                ?>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="state">
                                                <option value="">State of Origin</option>
						      <?php
							$all_state = State::find_all();
                                                        foreach($all_state as $state):
							echo "<option value = '".$state->abbreviation."'";
						        echo ">".$state->name."</option>";
							endforeach;
                                                ?>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="qualification">
                                                <option value="">Qualification</option>
												<?php
														 $quals = array(1 => "B.A", 2 => "B.ED", 3 => "B.ENG", 4 =>  "B.SC", 5 =>  "B.TECH", 6 =>  "HND", 7 =>  "LLB", 8 =>  "MBBS", 9 =>  "BLS", 10 =>  "B.AGRIC", 11 =>  "BDS", 12 =>  "B.PHARM", 13 =>  "BNSC", 14 =>  "DVM",  15 =>  "OD",  16 => "BMLS",  17 =>  "MBBCH", 18 =>  "B.FORESTRY", 19 =>  "B.URP",  20 => "MBCHB",  21 =>  "MED",  22 =>  "B.EMT", 23 =>  "B.MR",  24 =>  "B.FISHERY",  25 =>  "B.PHYSIO");
														asort($quals);
                                                        foreach($quals as $qual):
														   echo "<option value = '".$qual."'";
														   echo ">".$qual."</option>";
                                                        endforeach;
                                                    ?>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="classDegree">
                                                <option value="">Class of Degree</option>
												<?php
													$c_o_ds = array(1 => "1ST CLASS", 2 => "2ND CLASS UPPER", 3 => "2ND CLASS LOWER", 4 =>  "THIRD CLASS", 5 =>  "DISTINCTION", 6 =>  "MERIT", 7 =>  "UPPER CREDIT", 8 =>  "LOWER CREDIT", 9 =>  "PASS");
												    asort($c_o_ds);
												    foreach($c_o_ds as $c_o_d){
													    echo "<option value = '".$c_o_d."'";
													    echo ">".$c_o_d."</option>";
												    }
                                                ?>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="discipline">
                                                <option value="">Discipline</option>
												<?php
													$all_disc = Discipline::find_all();
                                                    foreach($all_disc as $a_disc):
						     echo "<option value = '".$a_disc->id."'";
						    echo ">".$a_disc->name."</option>";
						    endforeach;
                                                ?>
                                            </select>
                                        </p>
                                        <p>
                                            <select name="institution">
                                                <option value="">Institution</option>
												<?php
													$all_inst = Institution::find_all();
                                                    foreach($all_inst as $an_inst):
													    echo "<option value = '".$an_inst->id."'";
														echo ">".$an_inst->name."</option>";
													endforeach;
                                                    ?>
                                            </select>
                                        </p>
                                        <p class="submit"><button type="submit" name="advanceSearch">Search</button> </p>
                                   </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php
}
function getExtension($str) {
	 $i = strrpos($str,".");
	 if (!$i) { return ""; }
	 $l = strlen($str) - $i;
	 $ext = substr($str,$i+1,$l);
	 return $ext;
}
function getNewCallup($str) {
	
	 $part1 = substr($str,4);
	 return $_SESSION['basic_abb'].$part1;
	 //die("the answer is ". $_SESSION['basic_abb'].$part1);
}
function get_file_name($path){
	$str = substr(strrchr($path, '/'), 1);
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$filename = substr($str,0,$i);
	return $filename;
}
function check_for_s($name){
  $name_lower = strtolower($name);
  return (substr($name_lower, -1) == 's') ? $name."'" : $name."'s";
}
function pad_serial($value){
    $value = (int)$value;
  if($value >= 1){
   $val =  str_pad($value, 4, '0', STR_PAD_LEFT);
    return $val;
} else{    
}
}
function pad_month($value){
   $value = (int)$value;
  if($value >= 1){
   $val =  str_pad($value, 2, '0', STR_PAD_LEFT);
    return $val;
} else{    
}
}
function short_year($str){
	return(substr($str, -2));
}
function get_batch_letter($str){
	return(substr($str, -1));
}
function get_state_code($code){
	return $_SESSION["basic_abb"]."/".$_SESSION['working_batch_code']."/".$code;
}
function arrange_page($page, $total_pages){
	if($total_pages > 10 && $page > 5 ){
		if($page + 5 <= $total_pages ){
			return ($page - 4);
		}else{
			return ($total_pages - 9);
		}
	} else{
		return 1;
	}
}
?>