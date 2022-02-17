<?php
require_once("./includes/initialize.php"); 
require_once "./Mailing/Mail.php";

error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());

//CHANGE PASSWORD
$oldpassword = !empty(test_input($_REQUEST['oldp'])) ? test_input($_REQUEST['oldp']) : '';
if($oldpassword!=''){
    $psw = test_input($_REQUEST['pass']);
    $psw2 = test_input($_REQUEST['pass2']);
   
    $users = User::find_by_id($session->user_id);
        foreach($users as $userz){
            if( password_verify(md5($oldpassword), $userz->argonpassword)){
                if($psw==$psw2){
                     $newse = new User();
                        $newse->id = $userz->id;
                        $newse->username = $userz->username;
                        $newse->argonpassword = password_hash(md5($psw), PASSWORD_ARGON2ID, ['memory_cost' => '65536','time_cost'=>4, 'threads'=>2]);
                        $newse->type = $userz->type;
                        $newse->status = $userz->status;
                        $newse->online = 1;
                        if($newse->update())
                        echo 'Password changed successfully!!!';
                }else echo 'New passwords do not match!!!';
            }else echo 'Old password is missing or incorrect!';
        }
}
//RESET OLD PASSWORD
$mailin = !empty(test_input($_REQUEST['mailn'])) ? test_input($_REQUEST['mailn']) : '';
if($mailin!=''){
    $psw = test_input($_REQUEST['pass']);
    $psw2 = test_input($_REQUEST['pass2']);
    $pin2 = test_input($_REQUEST['pinn']);
    $good = Mailpin::check_pin($mailin, $pin2);
    if(!empty($good)){
    $users =User::find_by_mail($mailin);
    if(!empty($users)){
    foreach($users as $userz){
        
            if($psw==$psw2){
                
                $newse = new User();
                $newse->id = $userz->id;
                $newse->username = $userz->username;
                $newse->password = md5($psw);
                $newse->type = $userz->type;
                $newse->status = $userz->status;
                $newse->online = 0;
                if($newse->update())
                echo 'Password changed successfully!!!<br> Go back to the Login  page and log in';
                
            }else echo 'New passwords do not match!!!';
       
    }
    }else echo  'Account could not be found';
    } else echo 'This pin does not exist, Please check your mail again ';
}

//CHECK IF PIN MATCHES EMAIL
 $pin = !empty(test_input($_REQUEST['pin'])) ? test_input($_REQUEST['pin']) : '';
if($pin!=''){
    $email = test_input($_REQUEST['maill']);
    $pins = Mailpin::find_pin($email, $pin);
    if(!empty($pins)){
        foreach($pins as $p){
            $newr = new Mailpin();
            $newr->id = $p->id;
            $newr->used = 1;
            $newr->email = $p->email;
            $newr->pin = $p->pin;
        if($newr->update())
        echo 'Pin Verified';
        }
    }else echo 'Could not find this Pin';
}

//SEND PIN TO EMAIL
 $to = !empty(test_input($_REQUEST['email'])) ? test_input($_REQUEST['email']) : '';
 
    //Create and save the 5-digit pin
    if($to!=''){
    $cases = User::find_by_mail($to); 
    $temp = md5(time());
    $temp2 = str_split($temp, 5);
    $tempPass= $temp2[0].'@!&'.strtoupper($temp2[1]);
    
    if(!empty($cases)){
        $latest = Mailpin::find_last();
                $lid=0;
                foreach($latest as $l){
                    $lid = $l->id;
                }
                $lid++;
                $newpin = new Mailpin();
                $newpin->id = $lid;
                $newpin->email = $to;
                $newpin->pin = $tempPass;
                $newpin->used = 0;
                $newpin->create();
    
    $from = "support@adonaibaibul.com";
           //$to = "Ramona Recipient <recipient@example.com>";
            $subject = "Reset and Change of Password";
          // $body = "Hi,\n\nHow are you?";
            
            	    $body .= "\nPlease Enter this 15-digit pin to authenticate this email\n";
            	    $body .= "\nPIN:  {$tempPass}\n";
            	    $body .= "\nThank you for using this network.\nCourtesy: Leoportals Support Team.";
            	    
            $host = "mail.adonaibaibul.com";
            $port = "587";
            $username = "_mainaccount@adonaibaibul.com";
            $password = "=8R7-OiL%q%Hxx*:";
            
            $headers = array ('From' => $from,
              'To' => $to,
              'Subject' => $subject);
            $smtp = Mail::factory('smtp',
              array ('host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password));
            
            $mail = $smtp->send($to, $headers, $body);
            
            if (PEAR::isError($mail)) {
              echo("<p>" . $mail->getMessage() . "</p>");
             } else {
              echo("Message successfully sent! If you cannot find it in the inbox, please check your spam mails");
             }
    }else echo "Email does not exist in the database";
    }
?>