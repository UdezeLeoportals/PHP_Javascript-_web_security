<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<?php
    
    if(isset($_POST['submit'])){
        $user = new User();
        $user->id =  (int)$_POST['user_id'];
        
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        $user->type = $_POST['type'];
        $user->status = $_POST['status'];
          if($user->update()){
            $session->message("just got a message");
	    redirect_to("user_display.php");
          }else{
            $session->message("they just felt bad, OOOPPPPPSSSSSSSSS, try again");
            redirect_to("user_display.php");
          }
     
      
    }
    if(isset($_POST['edit'])){
        $id = (int)$_POST['user_id'];
        $user = User::find_by_id($id);   
    }else{
        $session->message("going the wrong way, stoppp!");
        redirect_to("user_display.php");
    }
    
    
?>
<h2>Edit User</h2>
	

		<form action="edit_user.php" method="post">
		    <table>
		        <tr>
		           <td>Username:</td>
		           <td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($user->username); ?>" /></td>
                           <td><input type="hidden" name="user_id" maxlength="30" value="<?php echo htmlentities($user->id); ?>" /></td>
		        </tr>
		         <tr>
		             <td>Password:</td>
		             <td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($user->password); ?>" /></td>
		         </tr>
                <tr>
                   <td>type:</td>
                   <td>
                   <select name="type" >
                      <option value="student"<?php 
			if ($user->type == "student") { echo " selected"; } 
			?>>student</option>
                      <option value="staff"<?php 
			if ($user->type == "staff") { echo " selected"; } 
			?>>staff</option>
                   </select>
                   </td>
                </tr>
                 <tr>
                   <td>status:</td>
                   <td>
                     <input type="radio" name="status" value="0"<?php 
			if ($user->status == 0) { echo " checked"; } 
			?> /> off
		      &nbsp;
		     <input type="radio" name="status" value="1"<?php 
			if ($user->status == 1) { echo " checked"; } 
			?> /> on
                   </td>
                </tr>
		     <tr>
		        <td colspan="2"><input type="submit" name="submit" value="Edit user" /></td>
		     </tr>
                
			</table>
			</form>
            
            
		
<?php echo footer(); ?>