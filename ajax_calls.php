<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
    if(isset($_POST['loadStateLga'])){
			
	$state = $_POST['state'];
	$id = States::get_id_from_code($state);
	
						
	$all_lga = Lga::get_lga_in_state($id);
			
	$data = "<option>L.G.A</option>";
	foreach($all_lga as $lga):
	   $data .= "<option value = '".$lga->id."'";
	   $data .= ">".$lga->name."</option>";
	endforeach;
        echo $data;
    }
?>
