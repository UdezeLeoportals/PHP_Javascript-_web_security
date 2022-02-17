<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<?php
    if(isset($_POST['submit'])){
        $status = new Student_status();
        $status->matric_no = $_POST['matric_no'];
        $status->session = $_POST['session'];
        $status->unit = $_POST['unit'];
        $status->level = $_POST['level'];
        $status->status = $_POST['status'];
        $status->create();
        Student::update_years_spent($_POST['no_of_years'], $_POST['actual_years'], $_POST['matric_no']);
        echo "SUCCESSFULLY ENTERED";
    }
?>
<form action="enter_status.php" method="POST">
MATRIC NO: <input type="text" name="matric_no"/><br>
SESSION: <input type="text" name="session" /><br>
NO OF YEARS SPENT: <input type="text" name="actual_years" /><br>
NO OF YEARS COUNTED: <input type="text" name="no_of_years" /><br>
CURRENT LEVEL: <input type="text" name="level" /><br>
UNIT: <select name="unit" ><option value="computer science">computer science</option>
    <option value="maths/statistics">maths/statistics</option><option value="statistics">statistics</option></select><br>
CURRENT STATUS: <select name="status"><option value="promoted">promoted</option>
                <option value="probation">probation</option><option value="withdrawn">
                withdrawn</option><option value="pending">pending</option>
                <option value="graduated">graduated</option></select><br>
<input type="submit" name="submit" value="submit" /></form>
<!-- ####################################################################################################### -->
<?php echo footer(); ?>