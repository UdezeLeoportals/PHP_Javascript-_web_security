<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<?php
	 if(isset($_POST['delete_student'])){
		$id = (int) $_POST['student_id'];
		Student::delete($id);
		$session->message("Deleted successfully");
	 }
?>
<?php
echo add_header($session->username, $session->type);
?>
<!-- ####################################################################################################### -->
<?php

?>
 <table style="border:blue 5px solid;" border=1 >
	<tr style="border:blue 5px solid;">
    	<th>S/NO</th>
        <th>MATRIC NO.</th>
        <th>FIRST NAME</th>
        <th>MIDDLE NAME</th>
	<th>LAST NAME</th>
	<th>MODE OF ENTRY</th>
	<th>UNIT</th>
	<th>LEVEL</th>
	<th>HALL/ADDRESS</th>
	<th>DATE OF BIRTH</th>
	<th>STATE OF ORIGIN</th>
	<th>SEX</th>
	<th>LGA</th>
	<th>PHONE NO.</th>
	<th>E-MAIL</th>
	<th>RELIGION</th>
	<th>MARITAL STATUS</th>
    </tr>
<?php
     $count = 1;
    foreach($students as $student): 
	echo "<tr style='border:blue 5px solid;'>";
		echo "<th>$count</th>";
        echo "<td>$student->matric_no</td>";
        echo "<td>$student->first_name</td>";
        echo "<td>$student->middle_name</td>";
	echo "<td>$student->last_name</td>";
	echo "<td>$student->mode_of_entry</td>";
	echo "<td>$student->unit</td>";
	echo "<td>$student->level</td>";
	echo "<td>$student->address</td>";
	echo "<td>$student->date_of_birth</td>";
	echo "<td>$student->state_of_origin</td>";
	echo "<td>$student->sex</td>";
	echo "<td>$student->lga</td>";
	echo "<td>$student->phone_no</td>";
	echo "<td>$student->e_mail</td>";
	echo "<td>$student->religion</td>";
	echo "<td>$student->marital_status</td>";
	echo '<td><form  method="post" action="'.$_SERVER['PHP_SELF'].'">';
		echo '<input type="hidden" name="student_id" value="'. $student->id.'"</input>';
		echo '<input type="submit" name="delete_student" value="DELETE"></input>';
	echo '</form></td>';
	echo '<td><form  method="post" action="edit_student.php">';
		echo '<input type="hidden" name="student_id" value="'. $student->id.'"</input>';
		echo '<input type="submit" name="edit_student" value="EDIT"></input>';
	echo '</form></td>';
	
    echo "</tr>";
      $count++;	
   endforeach;
		
echo "</table>";
?>
<form action="view_by_image.php" method="POST">
    UNIT: <select name="unit"><option value="computer science">computer science</option>
    <option value="maths/statistics">maths/statistics</option>
    <option value="statistics">statistics</option></select><br>
    LEVEL: <select name="level"><option value="100">100</option>
    <option value="200">200</option>
    <option value="300">300</option>
    <option value="400">400</option></select>
</form>

<!--<a href="./biodata.php>">>>>Create New Student</a>-->
<!-- ####################################################################################################### -->
<?php echo footer(); ?>
