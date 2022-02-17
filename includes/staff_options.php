<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php echo add_header(); ?>
<!-- ####################################################################################################### -->
	<ul>
		<li><a href="view_my_courses.php">View My Courses</a></li>
          <li><a href="upload_result.php">Upload Results</a></li>
         
		  </ul>
<!-- ####################################################################################################### -->
<?php echo footer(); ?>