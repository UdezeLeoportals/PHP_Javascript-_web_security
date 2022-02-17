<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<!-- ####################################################################################################### -->
<?php 
	if(isset($_POST['submit'])){
		$new_student = new User();
		
		$new_student->username  = trim($_POST['matric_no']);
	    $new_student->password  = md5(trim($_POST['first_name']));
	    $new_student->type      = 'student';
	    $new_student->status    = 1;
		
		if($new_student->create())
		{
			$student = new Student();
			$student->user_id = $new_student->id;
			$student->matric_no = $_POST['matric_no'];
			$student->first_name = $_POST['first_name'];
			$student->middle_name = $_POST['middle_name'];
			$student->last_name = $_POST['last_name'];
			$student->mode_of_entry = $_POST['mode_of_entry'];
			$student->unit = $_POST['unit'];
			$student->level = $_POST['level'];
			$student->address = $_POST['address'];
			$student->date_of_birth = $_POST['DOB'];
			$student->state_of_origin = $_POST['state_of_origin'];
			$student->sex = $_POST['sex'];
			$student->lga = $_POST['lga'];
			$student->year_of_entry = $_POST['year_of_entry'];
			$student->year_of_graduation = $_POST['year_of_grad'];
			$student->phone_no = $_POST['phone_no'];
			$student->e_mail = $_POST['email'];
			$student->religion = $_POST['religion'];
			$student->faculty = $_POST['faculty'];
			$student->perm_address = $_POST['perm_address'];
			$student->home_town = $_POST['home_town'];
			$student->marital_status = $_POST['status'];
			$student->sponsor = $_POST['sponsor'];
			$student->academic_adviser = $_POST['academic_adviser'];
			$student->withdrawal_status = $_POST['enrolled'];
			$student->previous_matric_no = $_POST['prev_matric_no'];
			$student->withdrawal_reasons = $_POST['withdrawal_reasons'];
			$student->last_college = $_POST['last_school'];
			$student->date_of_leaving = $_POST['date_of_leaving'];
			$student->reason_for_leaving = $_POST['reason_for_leaving'];
			$student->extra_curricula = $_POST['extra_curricula'];
			$student->next_of_kin = $_POST['next_of_kin'];
			$student->address_of_next_of_kin = $_POST['address_of_next'];
			$student->date_of_last_edit = $_POST['date_of_edit'];
			if($_POST['student_type']==1){
				$student->no_of_years=1;
				$student->actual_years_spent=1;
			}
			
			$student->create();
			$session->message("Successfully Created");
			$max_file_size=1048576;
		  
		   
			   $photo = new Photographs(); 
			   $photo->student_id = $student->id;
			   $photo->attach_file($_FILES['passport']);
			   if($photo->save()){
			    $message = "Passport uploaded successfully";
			   }
			   else{
			    $message = join("<br>", $photo->errors);
			   }
		  
			   $signature = new Signature(); 
			   $signature->student_id = $student->id;
			   $signature->attach_file($_FILES['signature']);
			   if($signature->save()){
			    $message = "Signature uploaded successfully";
			   }
			   else{
			    $message = join("<br>", $signature->errors);
			   }
		   
		   $session->message($message);
		}else{
			$session->message("Could not Create the user");
		}	
	}
?>

            
      <form name="form1" method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
     <div id="biodata" align="center">  <h2>STUDENTS PERSONAL DATA FORM</h2>

      <table width: 800px;  height="0" border="0" width="902" class="takon">
		<tr>
			<td width="204" height="49" valign="top">Upload Passport:</td>
			<td colspan="3" width="325" height="49">
			<img border="0" src="images/dummy.jpg" width="120" height="120" align="left"><br>
			<br>
			<input type="hidden" name="MAX_FILE_SIZE" value="<? echo $max_file_size;?>"/>
			<input type="file" name="passport" size="12" style="float: left"></td>
			<td width="82" height="49">&nbsp;</td>
			<td width="9" height="49">&nbsp;</td>
			<td width="37" height="49">&nbsp;</td>
			<td width="54" height="49">&nbsp;</td>
			<td width="195" height="49">&nbsp;</td>
			<td width="229" height="49" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="150" height="33" valign="top">First Name:</td>
			<td colspan="2" width="168" height="33"><input name="first_name" type="text" size="35" /></td>
			<td width="150" height="33" valign="top" colspan="2">Middle Name:</td>
			<td width="166" height="33" colspan="2"><input name="middle_name" type="text" size="35" /></td>
			<td width="150" height="33" valign="top">Last Name:</td>
			<td colspan="3" width="175" height="33"><input name="last_name" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204" height="33">Matric No:</td>
			<td colspan="3" width="325" height="33"><input name="matric_no" type="text" size="35" /></td>
			<td width="194" height="33" colspan="4">Level:</td>
			<td width="229" height="33" colspan="3"><select name="level"><option value=100>100</option><option value=100>200</option><option value=300>300</option><option value=400>400</option></select></td>
		</tr>
		<tr>
			<td width="204" height="28">Sex:</td>
			<td colspan="3" width="325" height="28"><select name="sex"><option value="male">Male</option><option value="female">Female</option></select></td>
			<td width="194" height="28" colspan="4">Faculty:</td>
			<td width="229" height="28" colspan="3"><input name="faculty" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204" height="38">Unit:</td>
			<td colspan="3" width="325" height="38"><select name="unit"><option value="Mathematics">Mathematics</option><option value="Statistics">Statistics</option><option value="Computer Science">Computer science</option></select></td>
			<td width="194" height="38" colspan="4">Year of entry:</td>
			<td width="229" height="38" colspan="3"><input name="year_of_entry" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204" height="33">Year of graduation:</td>
			<td colspan="3" width="325" height="33"><input name="year_of_grad" type="text" size="35" /></td>
			<td width="194" height="33" colspan="4">&nbsp;</td>
			<td width="229" height="33" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="204">Mode Of Entry:</td>
			<td colspan="3" width="325"><select name="mode_of_entry"><option value="UME">UME</option><option value="Remedial">Remedial</option><option value="Direct Entry">Direct Entry</option></select></td>
			<td width="194" colspan="4">&nbsp;</td>
			<td width="229" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="204" height="31">&nbsp;</td>
			<td colspan="3" width="325" height="31">&nbsp;</td>
			<td width="194" height="31" colspan="4">&nbsp;</td>
			<td width="229" colspan="3" height="31">&nbsp;</td>
		</tr>
		<tr>
			<td width="204" height="38">Date of birth:</td>
			<td width="92" height="38"><input type="text" name="DOB" class="datepicker, Date"></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
			<td width="71" height="38">&nbsp;</td>
			<td colspan="5" width="280" height="38">&nbsp;</td>
			<td width="229" colspan="3" height="38">&nbsp;</td>
			<td width="6" height="38">&nbsp;</td>
		</tr>
		<tr>
			<td width="204" height="20">&nbsp;</td>
			<td width="92" height="20" valign="top">&nbsp;&nbsp;&nbsp; </td>
			<td width="71" height="20" valign="top">&nbsp; </td>
			<td width="111" height="20" valign="top">&nbsp;</td>
			<td width="194" height="20" colspan="4">&nbsp;</td>
			<td width="229" height="20" colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td width="204" height="32">State of Origin:</td>
			<td width="325" colspan="3" height="32"><input name="state_of_origin"   type="text" size="35" /></td>
			<td width="194" height="32" colspan="4">L.G.A</td>
			<td width="229" height="32" colspan="3"><input name="lga" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204" height="38">Hall/residential address:</td>
			<td width="325" colspan="3" height="38"><input name="address" type="text" size="35" /></td>
			<td width="194" height="38" colspan="4">Phone no:</td>
			<td width="229" height="38" colspan="3"><input name="phone_no" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204" height="43">Permanent home address:</td>
			<td colspan="3" width="325" height="43"><input name="perm_address" type="text" size="35" /></td>
			<td width="194" height="43" colspan="4">Email:</td>
			<td width="229" colspan="3" height="43"><input name="email" type="text" size="35" /></td>
		</tr>
		<tr>
		  <td height="28">Home town:</td>
		  <td colspan="3" width="310" height="28"><input name="home_town" type="text" size="35" /></td>
		  <td colspan="4" width="194" height="28">Religion/Denomination:</td>
		  <td colspan="3" width="229" height="28"><input name="religion" type="text" size="35" /></td>
	    </tr>
		<tr>
			<td width="204" height="33">Marital Status:</td>
			<td width="92" height="33">married
			  <input name="status" type="radio" value="married" checked /></td>
			<td colspan="2" width="201" height="33">Single
			  <input name="status" type="radio" value="single" /></td>
			<td colspan="4" width="194" height="33">&nbsp;</td>
			<td colspan="3" width="229" height="33">&nbsp;</td>
		</tr>
		<tr>
			<td width="204">&nbsp;</td>
			<td colspan="3" width="310">&nbsp;</td>
			<td colspan="4" width="194">&nbsp;</td>
			<td colspan="3" width="229">&nbsp;</td>
		</tr>
		<tr>
			<td width="204">Name and Address of Sponsor:</td>
			<td colspan="3" width="257"><input name="sponsor" type="text" size="35" /></td>
			<td colspan="4" width="194">Name of Academic Adviser:</td>
			<td colspan="3" width="229"><input name="academic_adviser" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204" height="62">Have you previously enrolled at the 
			university of 
			calabar:</td>
			<td colspan="3" width="257" height="62"><select name="enrolled"><option value="No">No</option><option value="Yes">YES</option></select></td>
			<td colspan="4" width="194" height="62">If yes:</td>
			<td colspan="3" width="229" height="62">what was your matric no<input name="prev_matric_no" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204">Reasons for withdrawing</td>
			<td colspan="3" width="257"><input name="withdrawal_reasons" type="text" size="35" /></td>
			<td colspan="4" width="194">&nbsp;</td>
			<td colspan="3" width="229">&nbsp;</td>
		</tr>
		<tr>
			<td width="204">&nbsp;</td>
			<td colspan="3" width="257">&nbsp;</td>
			<td colspan="4" width="194">&nbsp;</td>
			<td colspan="3" width="229">&nbsp;</td>
		</tr>
		<tr>
			<td width="204" height="63">Last school/college/university attended</td>
			<td colspan="3" width="257" height="63"><input name="last_school" type="text" size="35" /></td>
			<td colspan="4" width="194" height="63">Date of leaving :</td>
			<td colspan="3" width="229" height="63"><input name="date_of_leaving" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204">Reason for leaving:</td>
			<td colspan="3" width="257"><input name="reason_for_leaving" type="text" size="35" /></td>
			<td colspan="4" width="194">Extra-curricula activities and interests:</td>
			<td colspan="3" width="229"><input name="extra_curricula" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204">&nbsp;</td>
			<td colspan="3" width="257">&nbsp;</td>
			<td colspan="4" width="194">&nbsp;</td>
			<td colspan="3" width="229">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="8" width="654">
			<p align="center">person to be contacted in case of emergency</td>
			<td colspan="3" width="229">&nbsp;
			</td>
		</tr>
		<tr>
			<td width="204" height="28">Full name:</td>
			<td colspan="3" width="257" height="28"><input name="next_of_kin" type="text" size="35" /></td>
			<td colspan="4" width="194" height="28">Address:</td>
			<td colspan="3" width="229" height="28"><input name="address_of_next" type="text" size="35" /></td>
		</tr>
		<tr>
			<td width="204" height="34">Student's signature:</td>
			<td colspan="3" width="257" height="34"><input type="file" name="signature" id="" /></td>
			<td colspan="4" width="194" height="34">Date:</td>
			<td width="62" height="34"><input type="text" name="date_of_edit" class="datepicker, Date"></td>
			<td width="76" height="34"></td>
			<td width="91" height="34"></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td colspan="3" width="257">TYPE OF STUDENT</td>
		  <td colspan="4" width="194"><select name="student_type"><option value="1">new student</option><option value="2">returning student</option></select></td>
		  <td width="62">&nbsp;</td>
		  <td width="76">&nbsp;</td>
		  <td width="91">&nbsp;</td>
	    </tr>
		<tr>
			<td width="204" height="21">&nbsp;</td>
			<td colspan="3" width="257" height="21">
		     <input name="submit" type="submit"  id="submit" value="SUBMIT"/></td>
			<td colspan="4" width="194" height="21">
	        <input name="reset" type="reset" id="reset" value="RESET" /></td>
			<td colspan="3" width="229" height="21">&nbsp;</td>
		</tr>
		</table>
      	<p>&nbsp;</div>
</form>
     
 

<!-- ####################################################################################################### -->
<?php echo footer(); ?>