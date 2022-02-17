<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">
	.bold{
		margin: 30px auto;
		border-collapse: collapse;
		height:   40px;
	}
	table {
		width: 35%;
 margin: 30px auto;
 border-collapse: collapse;
 border:#400000 5px solid
}

th, td {
 height:   35px;
 border: 1px solid black;
}
	.high{
        height: 15em;
	 }
	.low{
        height: 30em;
	}
	.button{
        color: white;
	 background: #400000;
    }
</style>
<?php
	$a_session = "";
	$sem_id=0;
	$semesters = Semester::find_active();
	foreach($semesters as $semester):
		$a_session = $semester->a_session;
		$sem_id=$semester->id;
		$semester = $semester->name;
	endforeach;
	$advisers = Classes::find_by_id($_POST['id']);
	$session_of_entry="";
	$unit="";
		foreach($advisers as $adviser):
			$session_of_entry = $adviser->session_of_entry;
			$unit = $adviser->unit;
		endforeach;
		$current_session = $session_of_entry;
		$current_level = 100;
		echo '<div class="high"></div><table class="takon">';
		while($current_session != next_session($a_session) && $current_level<=600){
			echo '<tr><td><b>'.$current_session.'</b></td>';
			echo '<form action="adviser_page.php" method="POST">';
			echo '<input type="hidden" name="session" value="'.$current_session.'" />';
			echo '<input type="hidden" name="unit" value="'.$unit.'" />';
			echo '<input type="hidden" name="level" value="'.$current_level.'" />';
			echo '<td><input class="button" type="submit" name="submit" value="VIEW RESULTS" /></form></td></tr>';
			$current_session = next_session($current_session);
			$current_level = $current_level +100;
		}
		echo '</table><div class="high"></div>';
	?>
<?php echo footer(); ?>