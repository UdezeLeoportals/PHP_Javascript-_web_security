<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<?php
$stat=0;
	
	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

	// 2. records per page ($per_page)
	$per_page = 30;

	// 3. total record count ($total_count)
	$total_count = User::count_all();
	

	
	$pagination = new Pagination($page, $per_page, $total_count);
	
	// Instead of finding all records, just find the records 
	// for this page
	$sql = "SELECT * FROM user ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()}";
	$user = User::find_by_sql($sql);
	
	// Need to add ?page=$page to all links we want to 
	// maintain the current page (or store $page in $session)
	
?>
<?php
  
   if(isset($_GET['activate'])){
      $id = (int) $_GET['user_id'];
      $users = User::find_by_id($id);
	foreach($users as $userD){
      		User::change_status($userD->id, 1);
        $message = "<h3>STATUS ACTIVATED<h3>";     
       }

       echo '<div class="high"></div>';
		echo '<div class="low"><center> <table class="takon" style="width: 25%">';
		echo '<tr><td><h3>'.$message.'!!!</h3></td></tr></table></center></div>';;
   }
   if(isset($_GET['deactivate'])){
      $id = (int)$_GET['user_id'];
      $users = User::find_by_id($id);
	foreach($users as $userD){
      		User::change_status($userD->id, 0);     
        $message = "<h3>STATUS DE-ACTIVATED<h3>";
       }
       echo '<div class="high"></div>';
		echo '<div class="low"><center> <table class="takon" style="width: 25%">';
		echo '<tr><td><h3>'.$message.'!!!</h3></td></tr></table></center></div>';;
   }
     if(isset($_GET['change'])){
      $stat=1;
      $id = (int)$_GET['user_id'];
      $user = User::find_by_id($id);
      $user->id = $id;
      echo '<div class="high"></div><center>';
      echo '<form action="deactivate.php" method="GET">';
      echo '<table class= "takon" style="width: 25%"><tr>';
      echo '<td>ENTER NEW PASSWORD:</td>';
      echo '<td><input type="password" name="pass" /><input type="hidden" name="id" value="'.$id.'"/></td></tr>';
      echo '<tr><td colspan=2><input class="button" type="submit" name="passer" value="submit" /></td></tr></table></form>';
      echo '</center><div class="high"></div>';
      
   }
   if(isset($_GET['passer'])){
      
      $id = (int)$_GET['id'];
      $user = User::find_by_id($id);
      User::change_password($id, md5($_GET['pass']));
        $message = "<h3>PASSWORD SUCCESSFULLY CHANGED<h3>";
      
      echo '<div class="high"></div>';
		echo '<div class="low"><center> <table class="takon" style="width: 25%">';
		echo '<tr><td><h3>'.$message.'!!!</h3></td></tr></table></center></div>';;
   }
?>

<style type="text/css">
table { 
 margin: 30px auto;
 border-collapse: collapse;
 width: 50%;
 border:#400000 5px solid
}

th, td {
 height:   35px;
}
.high{
   height: 5em;
}
.low{
   height: 10em;
}
.button{
        color: white;
        background: #400000;
    }

</style>
<center>
<?php if($stat==0) {?>
<table border="1" class="takon">
	<tr>
    	<th>S/NO</th>
        <th>USERNAME</th>
        <th>TYPE</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
    </tr>


<?php
$count=0;
     
     if(!empty($_GET['count'])) $count = $_GET['count'];
     else $count = 1;
    foreach($user as $new_user): 
	echo "<tr>";
	echo "<th>$count</th>";
        echo "<td>$new_user->username</td>";
        echo "<td>$new_user->type</td>";
	echo '<form  method="get" action="'.$_SERVER['PHP_SELF'].'">';
	echo '<input type="hidden" name="user_id" value="'. $new_user->id.'"</input>';
        //echo '<input type="text" name="user_id" value="'. $new_user->status.'"</input>';
	echo '<td><input class="button" type="submit" name="activate" value="ACTIVATE"></input></td>';
        echo '<td><input class="button" type="submit" name="deactivate" value="DEACTIVATE"></input>';
	echo '<td><input class="button" type="submit" name="change" value="CHANGE PASSWORD"></td>';
	echo '</form></td>';
	
	
	
    echo "</tr>";
      $count++;	
   endforeach;
		
echo "</table>";

?>
</center>
<?php
	if($pagination->total_pages() > 1) {
		
		if($pagination->has_previous_page()) { 
    	echo "<a href=\"deactivate.php?count={$count}&page=";
      echo $pagination->previous_page();
      echo "\">&laquo; Previous</a> "; 
    }

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo " <span class=\"selected\">{$i}</span> ";
			} else {
				echo " <a href=\"deactivate.php?count={$count}&page={$i}\">{$i}</a> "; 
			}
		}

		if($pagination->has_next_page()) { 
			echo " <a href=\"deactivate.php?count={$count}&page=";
			echo $pagination->next_page();
			echo "\">Next &raquo;</a> "; 
    }
		
	}
}
?>

<?php echo footer(); ?>
