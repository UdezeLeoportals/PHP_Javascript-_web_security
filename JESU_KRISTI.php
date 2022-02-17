<?php

require_once("./includes/initialize.php");

$matius = JESUS_CHRIST_Igbo::find_active(1);
foreach($matius as $matiu){
        if($matiu->JESUS_CHRIST_chapter==1){
            $verseArray = str_split($matiu->JESUS_CHRIST_text, 1); // array of verse body
            $Jesu_ikpeazu="";
			$searchArray = "Abraham"; // array of search text
			for($i=0; $i<count($verseArray); $i++){
				if($searchArray==$verseArray[$i]){
				    echo 1;
				    str_replace("Abraham", "Jesu", $verseArray);
				    for($Kristi=0; $Kristi<count($verseArray); $Kristi++)
				        $Jesu_ikpeazu .= $verseArray[$Kristi]." ";
				    break;
				}
			}
			for($Kristi=0; $Kristi<count($verseArray); $Kristi++)
				        echo $verseArray[$Kristi]." ";
			echo $Jesu_ikpeazu;
        }
}

?>
