<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<head><title>Result System - start session</title>
<style type="text/css">

table { 
 margin: 30px auto;
 border-collapse: collapse;
 width: 35%;
 
}
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
</head>
<body topmargin="0" style="background-color: #F8F7DF">
<?php
$permit=0;
if(isset($_POST['no'])) redirect_to("manage_session.php");

		  $sess="";
		$semesters = Semester::find_active();
		foreach($semesters as $semester):
			$sess = $semester->a_session; 
		endforeach;
		$session = next_session($sess);
		if(isset($_POST['submit'])){
		  $permit = 1;
		
		$semesters = Semester::find_all();
		foreach($semesters as $semester):
			Semester::update_status(0,$semester->id);
		endforeach;
		$exists = academic_session::find_session($session);
		if(empty($exists)){
		$new_session = new academic_session();
		$new_session->name = $session;
		$new_session->create();
		}
		$semest = Semester::find($session, "first");
		if(!empty($semest)){
		foreach($semest as $sem){
		  Semester::update_status(1,$sem->id);
		}
		}else{
		  $new_semester = new Semester();
		$new_semester->a_session = $session;
		$new_semester->name = "first";
		$new_semester->status = 1;
		$new_semester->closed = 0;
		$new_semester->create(); 
		}
		$semeste = Semester::find($session, "second");
		if(!empty($semeste)){
		foreach($semeste as $sem){
		  Semester::update_status(0,$sem->id);
		}
		}else{
		  $new_semester = new Semester();
		$new_semester->a_session = $session;
		$new_semester->name = "second";
		$new_semester->status = 0;
		$new_semester->closed = 2;
		$new_semester->create(); 
		}
		
		$sems=Semester::find($sess, "second");
		foreach($sems as $sem){
		  $see=Semester::find($session, "first");
		  foreach($see as $s){
			   $semes=new Semester();
			   $semes->id=$s->id;
			   $semes->a_session=$s->a_session;
			   $semes->name=$s->name;
			   $semes->status=$s->status;
			   $semes->closed=$s->closed;
			   
			   $semes->save();
			   
			   $class = Classes::find_cur($sem->id);
			   foreach($class as $clas){
				    $cls=new Classes();
				    $cls->adviser_id=$clas->adviser_id;
				    $cls->session_of_entry=$clas->session_of_entry;
				    $cls->unit=$clas->unit;
				    $cls->max_credit=$clas->max_credit;
				    $cls->level = $clas->level+100;
				    $cls->session_max=$clas->session_max;
				    $cls->semester_id=$s->id;
				    $cls->create();
				    }
				    
				    $offices = Officers::find_current($sem->id);
				    foreach($offices as $off){
				     $office = new Officers();
				     $office->staff_id=$off->staff_id;
				     $office->Office=$off->Office;
				     $office->semester_id = $s->id;
				     $office->unit_type=$off->unit_type;
				     $office->unit_id=$off->unit_id;
				     $office->create();
				    }
			   
		  }
		  
		}
		
			
		echo '<div class="high"></div>';
		 echo '<center><table class="takon" style="border:#400000 5px solid; width: 50%"><tr><td colspan=2><h3>'.$session.'  ACADEMIC SESSION SUCCESSFULLY STARTED!!</h3></td></tr></table>';
		echo '<div class="high"></div>';
	}
		
if($permit==0){	 
?>
<div class="high"></div>
<center><form action="create_session.php" method="post">
    <table class="takon">
        <tr><td colspan=2><h3 style="color: red;">ARE YOU SURE YOU WANT TO START THE  <?php echo next_session($sess);?> ACADEMIC SESSION?</h3></td></tr>
        <tr><td><input type="submit" name="submit" value="YES" class="button" /></td>
       <td><input type="submit" name="no" value="NO" class="button" /> </td></tr>
    </table>
</form></center>


<!-- ####################################################################################################### -->
<div class="high"></div>


<!-- ####################################################################################################### -->
<?php }echo footer(); ?>
</body>