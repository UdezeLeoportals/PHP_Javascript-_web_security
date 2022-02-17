<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
	 if(isset($_POST['delete_user'])){
		$id = (int) $_POST['user_id'];
		User::delete($id);
		$session->message("Deleted successfully");
	 }
	 
	 $user = User::find_all();
?>

<?php
echo add_header($session->username, $session->type);
?>
<!-- ####################################################################################################### -->
        
<!-- ####################################################################################################### -->
<?php
	echo $message;
?>
<table style="border:blue 5px solid;" >
	<tr style="border:blue 5px solid;">
    	<th>S/NO</th>
        <th>USERNAME</th>
        <th>PASSWORD</th>
        <th>TYPE</th>
        <th>STATUS</th>
    </tr>


<?php
     $count = 1;
    foreach($user as $new_user): 
	echo "<tr style='border:blue 5px solid;'>";
		echo "<th>$count</th>";
        echo "<td>$new_user->username</td>";
        echo "<td>$new_user->password</td>";
        echo "<td>$new_user->type</td>";
	echo "<td>$new_user->status</td>";
	echo '<td><form  method="post" action="'.$_SERVER['PHP_SELF'].'">';
		echo '<input type="hidden" name="user_id" value="'. $new_user->id.'"</input>';
		echo '<input type="submit" name="delete_user" value="DELETE"></input>';
	echo '</form></td>';
	echo '<td><form  method="post" action="edit_user.php">';
		echo '<input type="hidden" name="user_id" value="'. $new_user->id.'"</input>';
		echo '<input type="submit" name="edit" value="EDIT"></input>';
	echo '</form></td>';
	
    echo "</tr>";
      $count++;	
   endforeach;
		
echo "</table>";



?>
<a href="new_user.php">>>>create a new User</a>

<!-- ####################################################################################################### -->
<?php echo footer(); ?>