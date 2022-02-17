<?php
require_once("./includes/initialize.php");
$p = $_REQUEST["p"];
$q = $_REQUEST["q"];
//html_entity_decode() helps to decode html tags from database
$data="";
if($q==1){
    $talks = News::find_by_id($p);
    $data .= '<table style="width: 100%; border: 0;">'; 
    
        $commentmen = Biodata::find_by_id($talks->bio_id);
        $fullname =""; $files="images/profiles/"; $emaile="";
    $data .= '<tr class="stripeOdd"><td style="width: 10%"></td><td><h3>'.html_entity_decode(strtoupper($talks->topic)).'</h3></td></tr>';
    $filename = empty($talks->filename) ? "" : "images/news/".$talks->filename;
 
    $data .= '<tr class="stripeOdd"><td style="width: 10%"></td><td style="white-space: pre-wrap; float: left;"><div style="float: left">'.html_entity_decode($talks->details).'</div></td></tr>';
    $trimdate = explode("+", $talks->datetime);
    foreach($commentmen as $commentman){
            $fullname = $commentman->get_fullname($commentman->id);
            $files .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
            $emaile = $commentman->email; 
            $phone = $commentman->phone_no;
        }
  
    $data .= '</table>';
        
       
       
}
elseif($q==2){
    $talks = Scholars::find_by_id($p);
    $data .= '<center><table style="width: 80%">'; 
    
        $commentmen = Biodata::find_by_id($talks->bio_id);
        $fullname =""; $files="images/profiles/"; $emaile="";
    $data .= '<tr class="stripeOdd"><td><h3>'.strtoupper($talks->topic).'</h3></td></tr>';
    $filename = empty($talks->filename) ? "" : "images/news/".$talks->filename;
  
   
    $data .= '<tr class="stripeOdd"><td style="white-space: pre-wrap; float: left;">'.htmlspecialchars_decode(html_entity_decode($talks->details)).'</td></tr>';
    $trimdate = explode("+", $talks->datetime);
    foreach($commentmen as $commentman){
            $fullname = $commentman->get_fullname($commentman->id);
            $files .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
            $emaile = $commentman->email;
            $phone = $commentman->phone_no;
        }
 
    $data .= '</table></center>';
        
}elseif($q==3){
    $talks = Jobs::find_by_id($p);
    $data .= '<center><table style="width: 80%">'; 
    
        $commentmen = Biodata::find_by_id($talks->bio_id);
        $fullname =""; $files="images/profiles/"; $emaile="";
    $data .= '<tr class="stripeOdd"><td><h3>'.strtoupper($talks->topic).'</h3></td></tr>';
    $filename = empty($talks->filename) ? "" : "images/news/".$talks->filename;
  
   
    $data .= '<tr class="stripeOdd"><td style="white-space: pre-wrap; float: left;">'.htmlspecialchars_decode(html_entity_decode($talks->details)).'</td></tr>';
    $data .= '<tr class="stripeEven"><td>LITURGICAL COLOR: '.$talks->employer.'</td></tr>';
    $data .= '<tr class="stripeOdd"><td>SAINT/FEAST: '.$talks->location.'</td></tr>';
    $data .= '<tr class="stripeEven"><td>CALENDAR DAY: '.$talks->deadline.'</td></tr>';
    $data .= '<tr class="stripeEven"><td>SCRIPTURE REFERENCE: '.$talks->linker.'</td></tr>';
    $trimdate = explode("+", $talks->datetime);
    foreach($commentmen as $commentman){
            $fullname = $commentman->get_fullname($commentman->id);
            $files .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
            $emaile = $commentman->email;
            $phone = $commentman->phone_no;
        }
 
    $data .= '</table></center>';
        
}
elseif($q==4){
    $talks = Campus::find_by_id($p);
    $data .= '<center><table style="width: 80%">'; 
    
        $commentmen = Biodata::find_by_id($talks->bio_id);
        $fullname =""; $files="images/profiles/"; $emaile="";
    $data .= '<tr class="stripeOdd"><td><h3>'.strtoupper($talks->topic).'</h3></td></tr>';
    $filename = empty($talks->filename) ? "" : "images/news/".$talks->filename;
  
    $data .= '<tr class="stripeOdd"><td style="white-space: pre-wrap; float: left;">'.html_entity_decode($talks->details).'</td></tr>';
    $trimdate = explode("+", $talks->datetime);
    foreach($commentmen as $commentman){
            $fullname = $commentman->get_fullname($commentman->id);
            $files .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
            $emaile = $commentman->email;
            $phone = $commentman->phone_no;
        }

    $data .= '</table></center>';
}elseif($q==5){
    $talks = Devotionals::find_by_id($p);
    $data .= '<center><table style="width: 80%">'; 
    
        $commentmen = Biodata::find_by_id($talks->bio_id);
        $fullname =""; $files="images/profiles/"; $emaile="";
    $data .= '<tr class="stripeOdd"><td><h3>'.strtoupper($talks->topic).'</h3></td></tr>';
    $filename = empty($talks->filename) ? "" : "images/news/".$talks->filename;
 
    $data .= '<tr class="stripeOdd"><td style="white-space: pre-wrap; float: left;">'.html_entity_decode($talks->details).'</td></tr>';
    $trimdate = explode("+", $talks->datetime);
    foreach($commentmen as $commentman){
            $fullname = $commentman->get_fullname($commentman->id);
            $files .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
            $emaile = $commentman->email;
            $phone = $commentman->phone_no;
        }
    $data .= '<tr class="stripeEven"><td>'.$talks->linker.'</td></tr>';

    $data .= '</table></center>';
}
echo $data;
?>