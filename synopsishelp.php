<?php
require_once("./includes/initialize.php");
$p = $_REQUEST["p"];

if($p==1){
    $forwards = Networkoffaith::find_field('forward');
    $data = '<table >';
    foreach($forwards as $forward){
        $data .= '<tr class="stripeEven"><td><b>'.$forward->content.'</b></td></tr>';
    }
    $data .= '</table>';
    echo $data;
}
else if($p==2){
    $forwards = Networkoffaith::find_field('dedication');
    $data = '<table >';
    foreach($forwards as $forward){
        $data .= '<tr class="stripeEven"><td><b>'.$forward->content.'</b></td></tr>';
    }
    $data .= '</table>';
    echo $data;
}
else if($p==3){
    $forwards = Networkoffaith::find_field('preface');
    $data = '<table >';
    foreach($forwards as $forward){
        $data .= '<tr class="stripeEven"><td><b>'.$forward->content.'</b></td></tr>';
    }
    $data .= '</table>';
    echo $data;
}
else if($p==4){
    $forwards = Networkoffaith::find_field('tabloid');
    $data = '<center><table >';
    foreach($forwards as $forward){
        $data .= '<tr class="stripeEven"><td><b>'.$forward->content.'</b></td></tr>';
    }
    $data .= '</table></center>';
    echo $data;
}
else if($p==5){
    $data = "<option value=0 >-- Choose Chapter -- </option>";
    $data .= "<option value=7 >CHAPTER ONE </option>";
    $data .= "<option value=8 >CHAPTER TWO </option>";
    $data .= "<option value=9 >CHAPTER THREE </option>";
    $data .= "<option value=10 >CHAPTER FOUR </option>";
    $data .= "<option value=11 >CHAPTER FIVE </option>";
    echo $data;
}
else if($p==6){
    $forwards = Networkoffaith::find_field('about');
    $data = '<center><table >';
    foreach($forwards as $forward){
        $data .= '<tr class="stripeEven"><td><b>'.$forward->content.'</b></td></tr>';
    }
    $data .= '</table></center>';
    echo $data;
}
else if($p>=7){
    $forwards = array();
    if($p==7)$forwards = Networkoffaith::find_field('chap1');
    else if($p==8)$forwards = Networkoffaith::find_field('chap2');
    else if($p==9)$forwards = Networkoffaith::find_field('chap3');
    else if($p==10)$forwards = Networkoffaith::find_field('chap4');
    else if($p==11)$forwards = Networkoffaith::find_field('chap5');
    $data = '<center><table >';
    foreach($forwards as $forward){
        $data .= '<tr class="stripeEven"><td><b>'.$forward->content.'</b></td></tr>';
    }
    $data .= '</table></center>';
    echo $data;
}
?>