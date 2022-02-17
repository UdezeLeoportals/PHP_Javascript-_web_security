<?php require_once("./includes/initialize.php");
require_once(LIB_PATH.DS.'database.php');
?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<head><title>Result System - Change Password</title>
<?php
echo add_header($session->username, $session->type);
?>
<style type="text/css">
    
    table { 

 width: 40%;

}
.high{
        height: 10em;
	}
        .low{
        height: 20em;
	}
	
</style>
</head>
<body topmargin="0" style="background-color: #F8F7DF">

<?php
$drop =0;
if(isset($_POST['submit'])){
$users =User::find_by_id($session->user_id);
foreach($users as $user){
    if($user->username==$_POST['user'] && $user->password==md5($_POST['old'])){
        if($_POST['new1']==$_POST['new2']){
            User::change_password($user->id, md5($_POST['new1']));
            echo 'Password changed successfully!!!';
            redirect_to("login.php");
        }else echo 'new passwords do not match!!!';
    }else echo 'Incorrect old password or username!!!';
}
}
?>

<center><form action="change_pass.php" method="POST">
    <h3>CHANGE PASSWORD</h3><br>
   <table class="tableDesignStat"><tr><td><label>USERNAME: </label></td><td><input type="text" name="user" class="field"/></td></tr>
<tr><td><label>OLD PASSWORD</label></td><td><input type="password" name="old" class="field"/></td></tr>
   <tr><td><label>NEW PASSWORD</label></td><td><input type="password" name="new1" class="field"/></td></tr>
   <tr><td><label>COMFIRM PASSWORD</label></td><td><input type="password" name="new2" class="field"/></td></tr>
    <tr><td colspan=2><input type="submit" value="CHANGE" name="submit" class="button"></td></tr></table></center>
</form><br><br><br>
<?php echo footer(); ?>
</body>