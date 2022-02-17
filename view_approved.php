<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">
	tr{
		margin: 30px auto;
		border-collapse: collapse;
               
		height:   40px;
	}
	a{
				color: white;
		}
	table {
		width: 65%;
 margin: 30px auto;
 border-collapse: collapse;
 border:#400000 5px solid
}

th, td {
 height:   35px;
  border: 1px solid black;
}
	.high{
        height: 45em;
	 }
	.low{
        height: 20em;
	}
	.button{
        color: white;
	 background: #400000;
    }
</style>

<?php
$state=0;
    if(isset($_POST['submit']) && !empty($_POST['session']) && !empty($_POST['semester'])){
        $session = $_POST['session'];
        $semester = $_POST['semester'];
        $approvals = Al_courses::find_current($session, $semester);
        echo '<table class="takon"><tr><th> S/NO</th><th>COURSE CODE</th>';
        echo '<th>COURSE TITLE</th>';
        echo '<th>CO-ORDINATOR</th>';
        echo '<th>TYPE</th>';
        echo '<th>APPROVAL</th>';
        $count=1;
        foreach($approvals as $approval){
           $type="";
           $type2 = Prescribed_course::find($approval->course_code);
           foreach($type2 as $type1){
            $type= $type1->type;
           }
           if($type!="departmental" || ($type=="departmental" && $approval->status=="CO-ORDINATOR")){
           if($approval->approval_summer!="not approved"){
           echo "<tr><td>$count</td>";
           echo "<td>$approval->course_code</td>";
           echo "<td>$approval->course_title</td>";
           if($type=="departmental" && $approval->status=="CO-ORDINATOR") {
                $staffer = Staff::find_by_staff_no($approval->staff_no);
                foreach($staffer as $staff){
                    $name=$staff->title.' '.$staff->first_name.' '.$staff->middle_name.' '.$staff->last_name;
                    echo "<td>$name</td>";
                }
            }else{
                echo "<td>&nbsp;</td>";    
            } 
            echo "<td>SUMMER</td>";
            echo "<td>$approval->approval_summer</td></tr>";
            $count++;
           }else{
             echo "<tr><td>$count</td>";
           echo "<td>$approval->course_code</td>";
           echo "<td>$approval->course_title</td>";
           if($type=="departmental" && $approval->status=="CO-ORDINATOR") {
                $staffer = Staff::find_by_staff_no($approval->staff_no);
                foreach($staffer as $staff){
                    $name=$staff->title.' '.$staff->first_name.' '.$staff->middle_name.' '.$staff->last_name;
                    echo "<td>$name</td>";
                }
            }else{
                echo "<td>&nbsp;</td>";    
            } 
             echo "<td>REGULAR</td>";
            echo "<td>$approval->approval_regular</td></tr>";
            $count++;
           }
           }
        }
        echo '</table>';
        $state=1;
    }
if($state==0){
?>
<center><form action="view_approved.php" method="post">
    <h3>SELECT SESSION</h3>
    <table class="takon" style="width: 30%">
       
       <?php echo '<tr ><td>Session:</td><td><select name="session" ><option>select session</option>';
		$sessions = Academic_session::find_all();
		foreach($sessions as $session):
		echo '<option value="'.$session->name.'">'.$session->name.'</option>';
		endforeach;
		echo '</select></td></tr>';
		?>
        </tr>
        <tr>
            <td>SEMESTER</td><td><select name="semester"><option>select semester</option><option value="first">first</option>
            <option value="second">second</option></select></td>
        </tr>
        <tr><td colspan=2><input type="submit" class="button" name="submit" value="submit" /></td></tr>
    </table>
</form></center><div class="low"></div>
<?php }echo footer(); ?>