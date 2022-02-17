<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {
    die("<script type=\"text/javascript\">
window.location.href = 'http://www.leoportals.com/login.php';
</script>");

 }
if($session->type!="HOD" && $session->type!="admin") { die("<script type=\"text/javascript\">
window.location.href = 'http://www.leoportals.com/index.php';
</script>");}
?>
<head><title>Result System - Edit Result</title>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">
	table{
		margin: 30px auto;
		border-collapse: collapse;
		
		width:   55%;
	}
	

</style></head>
<body topmargin="0" style="background-color: #F8F7DF">
<div style="height: 4em;"></div>
	<table class="tableDesignStat"><tr>
		<td><a href="corrections.php?opr=1" title="Edit Raw Score"><img src="images/R4.png" width=70 height=70 /> Edit Raw Score  </a></td>
		<td><a href="corrections.php?opr=2" title="Insert Raw Score"><img src="images/R6.png" width=70 height=70 /> Insert Raw Score  </a></td>
		<td><a href="corrections.php?opr=3" title="Delete Raw Score"><img src="images/R7.png" width=70 height=70 />Delete Raw Score</a></td>
		<td><a href="corrections.php?opr=4" title="Drop a Course as Take"><img src="images/R8.png" width=70 height=70 />Drop Course as Take  </a></td></tr>
		<tr><td><a href="corrections.php?opr=5" title="Remove Course from Take Courses"><img src="images/RA.png" width=70 height=70 />Delete Take Course</a></td>
		<td><a href="view_files.php?log=1" title="View Log File"><img src="images/R2.png" width=70 height=70 /> View Log File</a></td>
		<td><a href="view_files.php?log=2" title="View Audit File"><img src="images/R3.png" width=70 height=70 /> View Audit Trail</a></td>
		</tr></table>
<div style="height: 5em;"></div>
<?php  echo footer(); ?>
</body>