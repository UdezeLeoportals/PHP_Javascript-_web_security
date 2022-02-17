<?php require_once("./includes/initialize.php"); ?>
<?php

$pic = empty($_REQUEST["p"]) ? "" : $_REQUEST["p"];
$id = empty($_REQUEST["q"]) ? "" : $_REQUEST["q"];
$r = empty($_REQUEST["r"]) ? 0 : $_REQUEST["r"];
$s = empty($_REQUEST["s"]) ? 0 : $_REQUEST["s"];

if($r==2){
    $tests = Books::find_by_test($pic);
    $message ="<option>--Choose Book--</option>";
    foreach($tests as $test){
        $message .= '<option value="'.$test->id.'" ';
        $message .= '>'.$test->book.'</option>';
    }
    echo $message;
}

if($r==3){
    $chaps = Chapters::find_by_book($pic);
    $message ='<option>--Choose Chapter--</option>';
    foreach($chaps as $chap){
        $message .= '<option value="'.$chap->chapter.'" ';
        $message .= '>'.$chap->chapter.'</option>';
    }
    echo $message;
}

if($r==4){
    $vss = Verses::find_chaps($pic, $id);
    $message ="<option>--Verses--</option>";
    foreach($vss as $vs){
     $message .= '<option value="'.$vs->verse.'"';
     $message .= '>'.$vs->verse.': '.$vs->text.'</option>';
    }
    echo $message;
}
////new snippet
//if($r==5){
//    $vss = Verses::find_a_verse($pic, $id, $s);
//    $message ="";
//    foreach($vss as $vs){
//      $message .= $vs->text;
//    }
//    echo $message;
//}
?>