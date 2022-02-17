<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<head><title>Result System - manage session</title>
<?php
echo add_header($session->username, $session->type);//#782645
?>

<style>
	
    .header{
	background:#591434 ;
    }
    td{
	min-width: 10em
    }
</style>
</head>
<body topmargin="0" style="background-color: #F8F7DF">
    <div style=" height: 25em; " >
	<center>
	<div style="height: 7em;"></div>
	<H2>YOU NEED A COMMUNICATION ACCOUNT TO CONNECT</H2>
	<form action="commune.php" method="post" >
	    <table class="takon" style="width: 45%">
		<tr><td>USERNAME</td><td><input type="text" name="username" class="field" /></td></tr>
		<tr><td>PASSWORD</td><td><input type="password" name="password" class="field" /></td></tr>
		<tr><td><input type="submit" name="submit" class="button" value="Log in"/></td>
		<td><input type="submit" class="button" name="register" value="Register new Account"/></td></tr>
	    </table>
	    </form>
	</center>
    </div>
</body>

<!-- ####################################################################################################### -->
<?php echo footer(); ?>
