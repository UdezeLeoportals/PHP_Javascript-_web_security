<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); };
if($session->type!="HOD" && $session->type!="admin") {redirect_to("./index.php");} ?>
<head><title>Result System - Approve Results</title>
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


</style></head>
<body topmargin="0" style="background-color: #F8F7DF"><center>
<?php
    if(isset($_POST['approve']) || isset($_POST['app'])){
	Result::update_app("seen", $_POST['id']);
	$rests=Result::find_by_id($_POST['id']);
	$semester_id=0; $course_id=0; $dpt_id = 0;
	foreach($rests as $rest){
	    $semester_id=$rest->semester_id;
	    $course_id=$rest->course_id;
	    $uploader = $rest->uploader_id;
	    $dpt_id = $rest->dept_id;
	}
	$dpt="";
	$dps=Depts::find_by_id($dpt_id);
	foreach($dps as $do){$dpt=$do->dept;}
	$code='';
	$codes = Course::find_by_id($course_id);
	foreach($codes as $cod){
	 $code = $cod->old_course_code;
	}
	$alloc=Course_allocation::find_by_code($semester_id, $course_id);
	$staff_id=0;
	foreach($alloc as $allocate){
		$staff_id=$allocate->staff_id;
	}
	$date=date(DateTime::RFC1123, time());
	if(!empty($alloc)){
	$title="RESULT APPROVAL FROM THE HOD FOR ".strtoupper($code);
	$snt="HOD ".strtoupper($dpt)." DEPARTMENT";
	//send alert to the co-ordinator
	
    }
	$message = "<center>$code Result Approved</center>";
        echo $message;
    }
    //if a result is rejected  by the HOD 
    if(isset($_POST['reject'])){
        $id = $_POST['id'];
	$uploader=0;
	$course_id=0;
	$dpt_id=0;
	$fim = Result::find_by_id($_POST['id']);
	foreach($fim as $rec){
		$uploader=$rec->uploader_id;
		$course_id=$rec->course_id;
		$dpt_id = $rec->dept_id;
	}
	$code="";
	$dpt="";
	$dps=Depts::find_by_id($dpt_id);
	foreach($dps as $do){$dpt=$do->dept;}
	$courses = Course::find_by_id($course_id);
	foreach($courses as $course){
		$code=$course->new_course_code;
	}
        $date = date(DateTime::RFC1123, time());
	$staffer = Staff::find_by_id($uploader);
	$title = strtoupper($code)." RESULT REJECTED!!!"; $sid=0;
	$stf = Staff::find_by_user_id($session->user_id);
	$date=date(DateTime::RFC1123, time());
	$sid=0;
	//send alert to the uploader
	
    
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
	if(!empty($alloc)){
	//send alert to the co-ordinator
	
    }
	//delete file from db
	$old_result = Result::find_by_id($id);
        foreach($old_result as $result){
            $result->destroy();
        }
	$message = "<h4>Result Rejected!!!</h4>";
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
    $count = ($per_page*$page)- $per_page+1;
    echo '<div class="low"></div></center>';
    echo '<table class="takon">';
    echo '<tr><th>S/NO</th><th>COURSE CODE</th><th>COURSE TITLE</th><th>ACADEMIC SESSION</th><th>DATE/TIME OF UPLOAD</th><th>UPLOADED BY</th><th>CO-ORDINATOR</th><th></th><th>COMMENT</th><th></th><th></th></tr>';
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
        echo "<tr><td>$count</td><td>$code</td><td>$title</td>";
        echo "<td>$sess</td><td>$result->date_time</td><td>$names</td><td>$name</td>";
        echo '<form action="view_app.php" method="post">';
         echo '<input  name="id" type="hidden" value="'.$result->id.'" />';
        echo '<td><a href="open_file.php?filename='.$result->filename.'">View Content</a></td>';
	 echo '<td><input name="comment" type="text" class="field" /></td>';
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
    echo '<center>';
	if($pagination->total_pages() > 1) {
		
		if($pagination->has_previous_page()) { 
    	echo "<a href=\"view_app.php?page=";
      echo $pagination->previous_page();
      echo "\">&laquo; Previous</a> "; 
    }

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo " <span class=\"selected\">{$i}</span> ";
			} else {
				echo "<a href=\"view_app.php?page={$i}\">{$i}</a> "; 
			}
		}

		if($pagination->has_next_page()) { 
			echo " <a href=\"view_app.php?page=";
			echo $pagination->next_page();
			echo "\">Next &raquo;</a>"; 
    }
		
	}
     
echo '</center>';
?>
<?php echo footer(); ?>
</body>