<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>          
			<h2>Create New User</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
            <?php
			    $user = new User();
				$new_user = $user->create();
				if($new_user){
					echo "insert succeeds";
				} else{
					echo "errors occurred";
				}
			?>
			<form action="new_user.php" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="30" value="<?php //echo htmlentities($username); ?>" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" maxlength="30" value="<?php //echo htmlentities($password); ?>" /></td>
				</tr>
                <tr>
                   <td>type:</td>
                   <td>
                   <select name="type">
                      <option value="student">student</option>
                      <option value="staff">staff</option>
                   </select>
                   </td>
                </tr>
                 <tr>
                   <td>status:</td>
                   <td>
                     <input type="radio" name="visible" value="0" /> off
					&nbsp;
					<input type="radio" name="visible" value="1" /> on
                   </td>
                </tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Create user" /></td>
				</tr>
                
			</table>
			</form>
            
            
		
<?php echo footer(); ?>