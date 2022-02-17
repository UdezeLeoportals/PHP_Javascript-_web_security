<?php
require_once("./includes/initialize.php");
$p = $_REQUEST["p"];

$talks = Comments::find_by_topic($p);
$data = '<center><table >'; $n=0;
foreach($talks as $talk){
    $commentmen = Biodata::find_by_id($talk->commentator_id);
    $fullname =""; $filename="images/profiles/";
    foreach($commentmen as $commentman){
        $fullname = strtoupper($commentman->get_fullname($commentman->id));
        $filename .= empty($commentman->filename) ? "dummy.jpg" : $commentman->filename;
    }
    $cssdesign = ($n%2==1) ? "stripeOdd" : "stripeEven";
    $trimdate = explode("+", date(DateTime::RFC1123, $talk->date_time));
        $data .= '<tr class="'.$cssdesign.'"><td><img src="'.$filename.'" style="width:35px; height:auto;" /></td><td>'.$fullname.'</td>';
        $data .= '<td>'.$talk->commentary.'</td><td>'.$trimdate[0].'</td></tr>';
        $n++;

}
if(empty($talks)) $data = '<tr class="stripeOdd"><td colspan=4> NO COMMENTARY ON THIS CHAPTER YET! YOU CAN MAKE YOUR CONTRIBUTION.</td></tr>';

  

$data .= '</table></center>';
echo $data;
?>
