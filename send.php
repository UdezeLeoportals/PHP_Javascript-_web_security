<?php require_once("./includes/initialize.php"); ?>
<?php //if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
//echo add_header($session->username, $session->type);
?>
<style type="text/css">
	.bold{
		margin: 30px auto;
		border-collapse: collapse;
		border:#400000 5px solid;
		height:   40px;
	}
	.high{
        height: 10em;
	 }
	.low{
        height: 30em;
	}
	
</style>
<?php

$date=date(DateTime::RFC1123, time());
$bulk = 1;
//if(isset($_POST['send'])){
   
   // }
  
    if(isset($_POST['send'])){
        $snt = "Leoportals Network";
        $from = "udezechinedu@leoportals.com";
	    $to = "udezeleonard@gmail.com";
	   // if($sms_id==1 || $sms_id==2) $phone = $staf->phone_no;
	    if(!empty($to)){
	    $headers  = 'MIME-Version: 1.0' . "\r\n";
	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
	    //$headers .= 'To: '.$name.'<'.$to.'>' . "\r\n";
            $headers .= 'From: '.$snt.'<'.$from.'>' . "\r\n";
	   // $headers .= 'Cc: dezleon20@gmail.com' . "\r\n";
           // $headers .= 'Bcc: dezleon20@gmail.com' . "\r\n";
	 
	    $subject = "test mail";
	    
	     //$subject = $_POST['subject_field'];
	    
	    //$message = "<html>";
	   // $message .= "<head><title>A GOD SENT TIMELY MESSAGE<title/></head>";
	   // $message .= "<body>";
	    $message = "<center><table class='takon' style ='width: 45%'><tr><td>HELP US WE PRAY THEE!!!</td></tr>";
	    $message .= "<tr><td><img src='../images/dummy.jpg' height=10 width=10/> </td>" ;
	    $message .= "<td>A message on: <td>".$subject."</td><td><img src='../images/dummy.jpg' height=10 width=10/>";
	    $message .= "</td></tr><tr><td><p align='center'>".$_POST['message_text']."$date</p></td></tr>";
	    $message .= "<tr><td><input type='submit' class='button' name='anointing' /></td></tr></table></center>";
	    //$message .= "</html>";
	    
	    $result = mail($to, $subject, $message, $headers);
	    echo $result ? 'sent' : 'error';
	    }
	   
       
    }

?>
<center>
<div style="height: 4em; background-color: #133445">
	<center><h2 style="color: red;" onmouseover="">YOUR FATHER'S WORD FOR TODAY</h2></center>
</div>
<?php  if($bulk==1){?>
<form action="send.php" method="post">
    <table class="takon">
        
        <tr><td><i style="color: blue;">Send to:</i></td>
        <td><select name="rec" class="field"><option></option>
        <?php
          /*  foreach($staff as $staf){
                $name=$staf->title.' '.$staf->surname.' '.$staf->first_name.' '.$staf->middle_name;
                echo '<option value="'.$staf->id.'">'.$name.'</option>';
            }*/
        ?>
        </select></td></tr>
	<tr><td>SUBJECT:</td>
	<TD><input type="text" class="field" name="subject_field"/></TD>
	</tr>
        <tr><td colspan=2><b style="color: red;">TYPE MESSAGE</b></td></tr>
        <tr><td colspan=2><textarea cols=68 rows=17 name="message_text"></textarea></td></tr>
        <?php
           /* if($session->type=="admin"||$session->type=="HOD"){
                
		echo '<tr><td ><input type="radio" name="sms" value="1"/> SMS Only</td>';
		echo '<td ><input type="radio" name="sms" value="2"/>Email and SMS';
		echo '<input type="radio" name="sms" value="3"/>Email Only</td></tr>';
		echo '<tr><td colspan=2><CENTER><input type="checkbox" name="all" value="1"/> Send to all staff</CENTER></td></TR>';
                //echo '<tr><td colspan=2><input type="checkbox" name="note" value="1"/> Make public notice</td></tr>';
            }*/
        ?>
        <tr><td ><CENTER><input type="submit" name="send" value="SEND" class="button"/></CENTER></td>
	<TD><center><input type="reset" name="reset" value="RESET" class="button"/></center></TD>
	</tr>
    </table>
</form>
<?php  }?>
</center>
<?php //echo footer(); ?>