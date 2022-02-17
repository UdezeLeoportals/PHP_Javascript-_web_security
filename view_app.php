<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<?php  
	
?>
<style type="text/css">

tr { 
 margin: 30px auto;
 border-collapse: collapse;
 
}
table{
border:#400000 5px solid;
width: 99%;
}
.high{
        height: 20em;
    }
    .low{
        height:5em;
    }
th, td {
 height:   50px;

}

.normal{ 
 height: 80px; 
}
.button{
        color: white;
        background: #400000;
    }

</style><center>
<?php
    if(isset($_POST['approve']) || isset($_POST['app'])){
	$file="";
	$course_id=0;
	$uploader=0;
	$semester_id=0;
	$bypass=0;
	
	if(isset($_POST['app'])) $bypass=1;
	$fim = Result::find_by_id($_POST['id']);
	$summ =0;
	foreach($fim as $rec){
		$file = $rec->filename;
		$course_id=$rec->course_id;
		$semester_id=$rec->semester_id;
		$summ = $rec->summer;
	}

        $path = "files".DS."results".DS;
   $filename = $path.$file;
   
   //die("the name is ".$filename);
  $objPHPExcel = new PHPExcel();


   $objReader = PHPExcel_IOFactory::createReader('Excel5');
   $objReader->setReadDataonly(true);
   $matrics = array();
   $mat=0;
   $matric=array();
   $objPHPExcel = $objReader->load($filename);
   $objWorksheet = $objPHPExcel->getActiveSheet();
    $outer = 1;
    foreach ($objWorksheet->getRowIterator() as $row){
    
	  
	  $cellIterator = $row->getCellIterator();
	  $cellIterator->setIterateOnlyExistingCells(false);
	  $data = array("Error");
	  
	  foreach ($cellIterator as $cell) {
	    $data[] = $cell->getValue();
	     
	  }
        if ($outer > 2 ){
	$id=0;
	$matric[$mat]=trim($data[2]);
	$mat++;
       $studs=Student::find_by_matric(trim($data[2]));
       foreach($studs as $stud){
		$id=$stud->id;
       }
       if($bypass==1){
	$res=new Result_sheet();
	$res->student_id=$id;
	$res->course_id=$course_id;
	$res->semester_id=$semester_id;
	$res->assessment=$data[3];
	$res->exam_score=$data[4];
	if($summ==1) $res->status=3; //status is 3 for summer results
	else $res->status=1;
	$res->create();
       }else{
        $rows=Result_sheet::find_record($id, $course_id, $semester_id);
	foreach($rows as $row){
	 if(empty($data[3]) && empty($data[4])){}
	 else{
	  if(empty($data[3])) $data[3] = 0;
	  if(empty($data[4])) $data[4] = 0;
		Result_sheet::change_role($row->id, $data[3], $data[4], 1);
	}
	//wake
	}
	 }
	
       }
	//wake
	  $outer++ ;
          }
	  //registered but missing results : change status to -1
	$regs = Result_sheet::find_by_code($course_id, $semester_id);
	 foreach($regs as $reg){
		$found=0;
		for($intro=0; $intro<$mat; $intro++){
			$student=Student::find_by_matric($matric[$intro]);
			foreach($student as $stud){
				if($stud->id==$reg->student_id) $found=1;
			}
		}
		if($found==0){	
			if($reg->status!=1) Result_sheet::change_state($reg->id, -1);	
		}
	 }
	 
	$code="";
	$courses = Course::find_by_id($course_id);
	foreach($courses as $course){
		$code=$course->new_course_code;
	}
	Result::update_app("approved", $_POST['id']);
	$message = "<center>$code Result Approved</center>";
        $staffer = Staff::find_by_user_id($uploader);
        foreach($staffer as $staff){
            if($staff->a_level!="HOD"){
		$response = $staff->message."<br> ".$code." was approved by the HOD";
                Staff::change_message($staff->id, $response);
            }
        }
	$alloc=Course_allocation::find_by_code($semester_id, $course_id);
	$staff_id=0;
	foreach($alloc as $allocate){
		$staff_id=$allocate->staff_id;
	}
	if($staff_id!=$uploader){
		$staffer = Staff::find_by_id($staff_id);
		foreach($staffer as $staff){
		if($staff->staff_level!="HOD"){
		$response = $staff->message."<br> ".$code." was approved by the HOD";
                Staff::change_message($staff->id, $response);
            }
        }
	}
         echo $message;
	 //AUDIT TRAIL
	$staffm = Staff::find_by_user_id($session->user_id);
		foreach($staffm as $staff){
			//$name = $staff->get_fullname;
			$unit = $staff->unit;
		}
		$a_session='';
		$sems = Semester::find_by_id($semester_id);
		foreach($sems as $sem){
		    $a_session = $sem->a_session;
		}
	$message2 = 'BY '.$session->username.' '.$unit.' '.$session->type;
	$message2 .= '<br><b> Filename: '.$file.' for '.$code.' '.$a_session.' containing '.($outer-1).' names</b>';
	audit_action("RESULT APPROVAL", $message2);
    }
    $code="";
    if(isset($_POST['reject'])){
        $id = $_POST['id'];
	$uploader=0;
	$course_id=0;
	$fim = Result::find_by_id($_POST['id']);
	foreach($fim as $rec){
		$uploader=$rec->uploader_id;
		$course_id=$rec->course_id;
		$file = $rec->filename;
	}
	
	$courses = Course::find_by_id($course_id);
	foreach($courses as $course){
		$code=$course->new_course_code;
	}
        
	echo '<div class="low"></div>';	
	echo '<table class="takon" style="width: 35%"><tr><td><h3>Further Reasons!!!</h3></td></tr>';
	echo '<form action="view_app.php" method="post">';
	echo '<tr><td><textarea cols="60" rows="5" name="expl"></textarea></td></tr>';
	echo '<input type="hidden" value="'.$code.'" name="code"/>';
	echo '<input type="hidden" value="'.$id.'" name="id"/>';
	echo '<input type="hidden" value="'.$uploader.'" name="staff_id"/>';
	echo '<tr><td><input class="button" type="submit" value="SUBMIT" name="reasons"/></td></tr></form></table>';
	echo '<div class="low"></div>';
    }
    if(isset($_POST['reasons'])){
        $staffer = Staff::find_by_id($_POST['staff_id']);
        foreach($staffer as $staff){
            if($staff->staff_level!="HOD"){
		$response = $staff->message."\n ".$_POST['code']." was rejected by the HOD \n REASONS: \n";
		$response .= $_POST['expl'];
                Staff::change_message($staff->id, $response);
            }
        }
	$id=$_POST['id'];
	$results = Result::find_by_id($id);
	$course_id=0;
	$semester_id=0;
	foreach($results as $result){
		$course_id=$result->course_id;
		$semester_id=$result->semester_id;
	}
	$alloc=Course_allocation::find_by_code($semester_id, $course_id);
	$staff_id=0;
	foreach($alloc as $allocate){
		$staff_id=$allocate->staff_id;
	}
	if($staff_id!=$_POST['staff_id']){
		$staffer = Staff::find_by_id($staff_id);
		foreach($staffer as $staff){
		if($staff->staff_level!="HOD"){
		$response = $staff->message."\n ".$_POST['code']." was rejected by the HOD \n REASONS: \n";
		$response .= $_POST['expl'];
                Staff::change_message($staff->id, $response);
            }
        }
	}
	
	$old_result = Result::find_by_id($id);
        foreach($old_result as $result){
            $result->destroy();
        }
	$message = "<h4>Result Rejected!!!</h4>";
	//AUDIT TRAIL
	$staffm = Staff::find_by_user_id($session->user_id);
		foreach($staffm as $staff){
			//$name = $staff->get_fullname;
			$unit = $staff->unit;
		}
		$a_session='';
		$sems = Semester::find_by_id($semester_id);
		foreach($sems as $sem){
		    $a_session = $sem->a_session;
		}
	$message2 = 'BY '.$session->username.' '.$unit.' '.$session->type;
	$message2 .= '<br><b> For '.$_POST['code'].' '.$a_session.' </b>';
	audit_action("RESULT REJECTION", $message2);
         echo $message;
    }
    $stafs=Staff::find_by_user_id($session->user_id);
    $unit="";
    foreach($stafs as $stf){
     $unit=$stf->unit;
     $deptid = $stf->dept_id;
    }
    $det=Departments::find_unit($unit);
    $dept="";
    foreach($det as $dt){
       $dept=$dt->dept;
    }
     $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $per_page=20;
    $total_count=Result::count_new($deptid);
    $pagination = new Pagination($page, $per_page, $total_count);
    $results = Result::find_new($deptid, $per_page, $pagination->offset());
    if(!empty($results)){
    $count=1;
    echo '<div class="low"></div></center>';
    echo '<table class="takon">';
    echo '<tr><th>S/NO</th><th>COURSE CODE</th><th>COURSE TITLE</th><th>ACADEMIC SESSION</th><th>DATE/TIME OF UPLOAD</th><th>UPLOADED BY</th><th>CO-ORDINATOR</th></tr>';
    foreach($results as $result){
	$code="";
	$title="";
	$courses = Course::find_by_id($result->course_id);
	foreach($courses as $course){
		$code=$course->new_course_code;
		$title= $course->course_title;
	}
	$sess="";
	$sessions = Semester::find_by_id($result->semester_id);
	foreach($sessions as $sessn){
		$sess=$sessn->a_session;
	}
	$names="";
	$stafs = Staff::find_by_id($result->uploader_id);
	foreach($stafs as $staf){
		$names=$staf->title.' '.$staf->surname.' '.$staf->first_name.' '.$staf->middle_name;
	}
	$name="";
	$alloc = Course_allocation::find_by_code($result->semester_id, $result->course_id);
	foreach($alloc as $allocs){
		$staff = Staff::find_by_id($allocs->staff_id);
		foreach($staff as $staf){
			$name=$staf->title.' '.$staf->surname.' '.$staf->first_name.' '.$staf->middle_name;	
		}
	}
        echo "<tr><td>$count</td><td>$code</td><td>$title";
	if(!empty($result->summer) && $result->summer==1) echo "<br>(SUMMER RESULT)";
	echo "</td>";
        echo "<td>$sess</td><td>$result->date_time</td><td>$names</td><td>$name</td>";
        echo '<form action="view_app.php" method="post">';
         echo '<input  name="id" type="hidden" value="'.$result->id.'" />';
        echo '<td><a href="open_file.php?filename='.$result->filename.'">View Content</a></td>';
	 echo '<td><input class="button" name="app" type="submit" value="DUMP RESULT" /></td>';
        echo '<td><input class="button" name="approve" type="submit" value="APPROVE" /></td>';
        echo '<td><input class="button" name="reject" type="submit" value="REJECT" /></td></form></tr>';
        $count++;
    }
    echo '</table>';
    echo '<div class="low"></div></center>';
    }else{$message="NO NEW RESULTS UPLOADED!!!";
	echo '<div class="low"></div>';
	 echo '<table class="takon" style="width: 35%"><tr><td><h3>'.$message.'</h3></td></tr>';
	echo '<tr><td><form action="HOD_functions.php" method="post">';
	echo '<input class="button" type="submit" value="GO BACK" /></form></td></tr></table>';
	echo '<div class="low"></div>';
    }
?>
<?php echo footer(); ?>