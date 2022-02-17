<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<?php
	 $stat=0;
	 if(isset($_GET['delete_student'])){
		$id = (int) $_GET['student_id'];
		Student::delete($id);
		echo "Deleted successfully";
		$stat=1;
	 }
?>

<style type="text/css">

table { 
 margin: 30px auto;
 border-collapse: collapse;
 width: 35%;
 border:#400000 5px solid
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

.normal{ 
 height: 80px; 
}
.button{
        color: white;
        background: #400000;
    }
</style>
<?php
if(isset($_POST['send'])){
    $matric_no = $_POST['matric_no'];
    $students =  Student::find_by_matric($matric_no);
    foreach($students as $student){
        $old_message = $student->message;
        $message = $old_message."<br>".$_POST['message'];
        Student::update_message($message, $student->id);
    }
    echo '<div style="height: 5em;"></div>';
    echo '<center style="color:red;">message sent..........</center>';
     echo '<div style="height: 5em;"></div>';
}
if(isset($_POST['message'])){
?>    
<table class="takon">
<form action="send_message.php" method="post">
    <tr><td ><h2>CREATE MESSAGE</h2></td></tr>
    <tr><td><textarea cols="60" rows="17" name="message"></textarea></td></tr>
    <input type="hidden" name="matric_no" value="<?php echo $_POST['matric_no'];?>" />
    <tr><td><input class="button" name="send" value="SEND" type="submit" /></form></td></tr>
</table>
<?php
}


?>
<?php echo footer(); ?>