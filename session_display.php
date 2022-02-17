<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
	 if(isset($_POST['delete_session'])){
		$id = (int) $_POST['session_id'];
		academic_session::delete($id);
		$session->message("Deleted successfully");
	 }
	 
?>
<?php
echo add_header($session->username, $session->type);
?>
<!-- ####################################################################################################### -->
<?php

	$sessions = academic_session::find_all();
	echo $session->message;
?>
<table style="border:blue 5px solid;" >
	<tr style="border:blue 5px solid;">
    	<th>S/NO</th>
        <th>SESSION</th>
		</tr>
	
	<?php
	    $count = 1;
    foreach($sessions as $sessn): 
	echo "<tr style='border:blue 5px solid;'>";
		echo "<th>$count</th>";
        echo "<td>$sessn->name</td>";

	echo '<td><form  method="post" action="'.$_SERVER['PHP_SELF'].'">';
		echo '<input type="hidden" name="session_id" value="'. $sessn->id.'"</input>';
		echo '<input type="submit" name="delete_session" value="DELETE"></input>';
	echo '</form></td>';
	echo '<td><form  method="post" action="edit_session.php">';
		echo '<input type="hidden" name="session_id" value="'. $sessn->id.'"</input>';
		echo '<input type="submit" name="edit_session" value="EDIT"></input>';
	echo '</form></td>';
	
    echo "</tr>";
      $count++;	
   endforeach;
		
echo "</table>";
?>
<a href="http://localhost/unical_rps/create_session.php">>>>Create New Session</a>
<!-- ####################################################################################################### -->
<?php echo footer(); ?>
