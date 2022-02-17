<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php echo add_header($session->username, $session->type); ?>

<?php
  if(isset($_POST['create_user'])){
    $new_user  = new User();
    
    $new_user->username  = trim($_POST['username']);
    $new_user->password  = md5(trim($_POST['password']));
    $new_user->type      = trim($_POST['type']);
    $new_user->status    = 1;
    
    if($new_user->create()){
      if($new_user->type == 'staff'){
        $new_staff = new Staff();
        $new_staff->staff_no = trim($_POST['type_no']);
        $new_staff->user_id = $new_user->id;
        $new_staff->create();
        
      }else{
        $new_student = new Student();
        $new_student->matric_no = trim($_POST['type_no']);
        $new_student->user_id = $new_user->id;
        $new_student->create();
      }
      
      $session->message("new  ".$new_user->type."  created successfully.");
    }else{
      $session->message("Just, OOOPPPPPSSSSSSSSS, try again");
    }
    
    redirect_to($_SERVER['PHP_SELF']);
    
    
    
    
  }
?>
<!-- ####################################################################################################### -->
<form id="" name="createUserForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
     <div id="biodata" align="center">  <h2>STUDENTS PERSONAL DATA FORM</h2>

      <table width: 800px;  height="0" border="0" width="902">
          <tr>
			<td width="204" height="33" valign="top">
                <p><?php echo $session->message; ?></p>
            </td>
            <td width="194" height="33" colspan="4">&nbsp;</td>
		<tr>
			<td width="204" height="33" valign="top">Username:</td>
			<td colspan="3" width="325" height="33"><input name="username" type="text" size="35" /></td>
			<td width="194" height="33" valign="top" colspan="4">Type:</td>
			<td width="229" height="33" colspan="3"><select name="type">
              <option>Type</option>
              <?php
              $nr = array('student', 'staff');
                foreach($nr as $n):
                  echo"<option>".$n."</option>";
                endforeach;
              ?>
            </select></td>
		</tr>
		<tr>
			<td width="204" height="33">Password:</td>
			<td colspan="3" width="325" height="33"><input name="password" type="password"  size="35" /></td>
			<td width="194" height="33" colspan="4">Matric/Staff Num.:</td>
			<td colspan="3" width="325" height="33"><input name="type_no" type="text" size="35" /></td>
		</tr>
        <tr>
			<td width="204" height="33">Verify Password:</td>
			<td colspan="3" width="325" height="33"><input name="v_password" type="password" size="35" /></td>
			<td width="194" height="33" colspan="4">&nbsp;</td>
			<td width="194" height="33" colspan="4">&nbsp;</td>
		</tr>
        <tr>
			<td width="204" height="21">&nbsp;</td>
			<td colspan="3" width="257" height="21">
		     <input name="reset" type="reset"  id="reset" value="RESET"/></td>
			<td colspan="4" width="194" height="21">
	        <input name="create_user" type="submit" id="submit" value="SUBMIT" /></td>
			<td colspan="3" width="229" height="21">&nbsp;</td>
		</tr>
      </table>
     </div>
</form>

<!-- ####################################################################################################### -->
<?php echo footer(); ?>