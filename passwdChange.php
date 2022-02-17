<?php
require_once("./includes/initialize.php"); 

$email = !empty(test_input($_REQUEST['email'])) ? test_input($_REQUEST['email']) : '';
if($email!=''){
    $quest = $_REQUEST['question'];
    $ans = $_REQUEST['answer'];
    $users = Userv::find_question($email, $quest, $ans);
    if(empty($users)) {
        echo "Wrong answer, Please try again";
        return false;
    }
    else return true;
}


$psw = !empty(test_input($_REQUEST['pass'])) ? test_input($_REQUEST['pass']) : '';

if($psw!=''){
   // $psw = test_input($_REQUEST['pass']);
    $psw2 = test_input($_REQUEST['pass2']);
   
    $users = User::find_by_id($session->user_id);
        foreach($users as $userz){
           // if( password_verify($password, $userz->argonpassword)){
                if($psw==$psw2){
                    //User::change_password($userz->id, md5($_POST['psw']));
                     $newse = new User();
                        $newse->id = $userz->id;
                        $newse->username = $userz->username;
                        $newse->argonpassword = password_hash(md5($psw), PASSWORD_ARGON2ID, ['memory_cost' => '65536','time_cost'=>4, 'threads'=>2]);
                        $newse->type = $userz->type;
                        $newse->status = $userz->status;
                        $newse->online = 1;
                        if($newse->update())
                        echo 'Password changed successfully!!!';
                    //echo 'Password changed successfully!!!';
                    //redirect_to("login.php");
                }else echo 'New passwords do not match!!!';
           // }else echo 'Old password is incorrect!!!';
        }
} 
?>