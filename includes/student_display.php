<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<!-- ####################################################################################################### -->
 <table style="border:blue 5px solid;" >
	<tr style="border:blue 5px solid;">
    	<th>S/NO</th>
        <th>STAFF NO.</th>
        <th>TITLE</th>
        <th>FIRST NAME</th>
        <th>MIDDLE_NAME</th>
	<th>LAST_NAME</th>
	<th>SEX</th>
    </tr>
<!-- ####################################################################################################### -->
<?php echo footer(); ?>