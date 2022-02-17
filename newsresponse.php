<?php
require_once("./includes/initialize.php");
$p = !empty($_POST["topics"])?  test_input($_POST["topics"]) : 0;
$p = !empty($_REQUEST["p"])? test_input($_REQUEST["p"]) : $p;
//$_REQUEST["p"];
$q = !empty($_POST["a"])? $_POST["a"] : $_REQUEST["q"]; //$_REQUEST["q"];
$r = !empty($_POST["r"])? $_POST["r"] : $_REQUEST["r"]; //$_REQUEST["r"];
$s = !empty($_POST["comment"])?  test_input($_POST["comment"]) : 0;
$t = !empty($_POST["userid"])? $_POST["userid"] : 0;

$talks = "";
//if($q==1)
$data = "";
$data = $p.':'.$q;
if($r==1){
    $data = '<center><table style="width: 80%">';
    $n=1;
    $responds = Responses::find_responds($q, $p);
    foreach($responds as $res){
        $fullname =""; $files="images/profiles/"; 
        $bion = Biodata::find_by_id($res->bio_id);
        foreach($bion as $commentman){
            $fullname = $commentman->get_fullname($commentman->id);
            $files .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
            $emaile = $commentman->email;
            $phone = $commentman->phone_no; $gen='';
            if($commentman->sex=="male") $gen = 'M'; else $gen='F';
        }
         $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
        $trimdate = explode("+", $res->datetime);
        $data .= '<tr class="'.$cssdesign.'"><td></td>';
        $data .= '<td>'.html_entity_decode($res->details).'</td><td></td></tr>';
        $n++;
    }
    $data .= "</table></center>";
}
if($r==2){
    $data = '<center><table style="width: 80%">'; $dateme = "";
    $basis = Biodata::find_by_user_id($t);
    foreach($basis as $base){
        $dateme = $base->id;
    }
    $jab = Responses::find_exist($q, $s);
    $latest =Responses::find_last();
    $lid=0;
    foreach($latest as $l){
        $lid = $l->id;
    }
    $lid++;
    if(empty($jab)){
    $respond = new Responses();
    $respond->id = $lid;
    $respond->bio_id = $dateme;
    $respond->topic_id = $p;
    $respond->type = $q;
    $respond->details = $s;
    $respond->datetime = date(DateTime::RFC1123, gettime());
    $respond->create();
    }
    $n=1;
    $responds = Responses::find_responds($q, $p);
    foreach($responds as $res){
        $fullname =""; $files="images/profiles/"; 
        $bion = Biodata::find_by_id($res->bio_id);
        foreach($bion as $commentman){
            $fullname = $commentman->get_fullname($commentman->id);
            $files .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
            $emaile = $commentman->email;
            $phone = $commentman->phone_no; $gen='';
            if($commentman->sex=="male") $gen = 'M'; else $gen='F';
        }
         $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
        $trimdate = explode("+", $res->datetime);
        $data .= '<tr class="'.$cssdesign.'"><td></td>';
        $data .= '<td>'.($res->details).'</td><td></td></tr>';
        $n++;
    }
    $data .= "</table></center>";
}
echo $data;
?>