<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">

table { 
 margin: 30px auto;
 border-collapse: collapse;
 
 border:#400000 5px solid;
 
}
.high{
        height: 15em;
    }
    .low{
        height: 30em;
    }
th, td {
 height:   50px;
	border:  1px solid black;
}

.normal{ 
 height: 80px; 
}
.button{
        color: white;
        background: #400000;
    }

</style>
<?php
        if(isset($_POST['submit'])){
                $check_session = Academic_session::find_session($_POST['session']);
                if(empty($check_session)){
                $new_session = new academic_session();
		$new_session->name = trim($_POST['session']);
		$new_session->create();
                }
		$find_sem=Semester::find($_POST['session'], "first");
		if(empty($find_sem)){
		$new_semester = new Semester();
		$new_semester->a_session = $_POST['session'];
		$new_semester->name = "first";
		$new_semester->status = 0;
		$new_semester->closed = 0;
		$new_semester->create(); 
		}
		$find_sem=Semester::find($_POST['session'], "second");
		if(empty($find_sem)){
		$new_semester = new Semester();
		$new_semester->a_session = $_POST['session'];
		$new_semester->name = "second";
		$new_semester->status = 0;
		$new_semester->closed = 0;
		$new_semester->create(); 
		}
              
               echo '<h4>'.$_POST['session'].' session Successfully created!!!</h4>';
        }else{
 ?>
 <div class="high"></div><div class="low"><center>
 <h3>Create Past Session</h3>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
	<table border=1 class="takon">
		<tr><td>Session:</td><td><input type="text" name="session"></input></td></tr>
		<tr><td><input class="button" type="submit" name="submit" value="SUBMIT"></input></td>
		<td><input class="button" type="reset" value="CLEAR"></input></td></tr>
	</table>
</form>
</center></div>
<?php } ?>
<?php echo footer(); ?>
                