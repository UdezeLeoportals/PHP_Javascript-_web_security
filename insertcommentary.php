<?php

require_once("./includes/initialize.php");
$comment3 = !empty($_REQUEST["comment"]) ? $_REQUEST["comment"] : $_POST["comment"];
$user_id = !empty($_REQUEST["identity"]) ? $_REQUEST["identity"] : $_POST["identity"];
$chapter_id = !empty($_REQUEST["topic_id"]) ? $_REQUEST["topic_id"] : $_POST["topic_id"];
//$logg = $_REQUEST["logged"];
//use the user id to get the id at the biodata table
$data = "";
//if ($logg){
        if($comment3!=""){
                $bios = Biodata::find_by_user_id($user_id);
                $bioid=0;
                foreach($bios as $bio){
                    $bioid = $bio->id;
                }
                $latest = Comments::find_last();
                $lid=0;
                foreach($latest as $l){
                    $lid = $l->id;
                }
                $lid++;
                $data='';
                $new_comment3 = new Comments();
                $new_comment3->id = $lid;
                $new_comment3->topic_id = $chapter_id;
                $new_comment3->commentary = $comment3;
                $new_comment3->commentator_id = $bioid;
                $new_comment3->date_time = gettime();
                $new_comment3->fullname = ""; 
                $new_comment3->phone = ""; 
                $new_comment3->address = ""; 
                $new_comment3->finger = ""; 
                $new_comment3->table_size = ""; 
                $new_comment3->details = ""; 
                $new_comment3->deliver = 0; 
                $new_comment3->post_type = 1; 
                $new_comment3->business = "word"; 
                if($new_comment3->create()){
                    $totalcom = Comments::countcom($chapter_id);
                    $data .= "Commentary successfully added! Total commentaries on chapter: ".$totalcom;
                }
                else {
                    $data .= "Update: not successful. Try again!";
                }
        }else $data .= "Invalid Entry, Please try again!";
//}
//else $data .= "You have not logged in!";
echo $data;

?>
