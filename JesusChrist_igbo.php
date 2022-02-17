<?php

require_once("./includes/initialize.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd" >


<?php
	
 echo add_header($session->username, $session->type);
 
header('Content-type: text/html; charset=UTF-8') ;
mysqli_query("SET NAMES UTF8");
 ?>

<meta http-equiv="Content-type" value="text/html; charset=UTF-8" />
<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
 <link rel="stylesheet" href="styles/chat_design.css" type="text/css" /> 
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<?php 
			
			
			$page = !empty($_POST['page']) ? (int)$_POST['page'] : 1;
			$per_page = 100;
			$total_count= 5000;
			//$pagination = new Pagination($page, $per_page, $total_count);
			$lower_limit = $page-1;
			
			$bible_pages = array(); $book_index = array();
			$bible_pages[0] = '--'; $book_index[0] = 0;
			$bible_pages[1] = "MAT&nbsp;-&nbsp;LUK"; $book_index[1] = 3;
			$bible_pages[2] = 'JOHN&nbsp;-&nbsp;ROM'; $book_index[2] = 6;
			$bible_pages[3] = '1COR&nbsp;-&nbsp;GAL'; $book_index[3] = 9;
			$bible_pages[4] = 'EPH&nbsp;-&nbsp;COL'; $book_index[4] = 12;
			$bible_pages[5] = '1THESS&nbsp;-&nbsp;1TIM'; $book_index[5] = 15;
			$bible_pages[6] = '2TIM&nbsp;-&nbsp;PHILEM'; $book_index[6] = 18;
			$bible_pages[7] = 'HEB&nbsp;-&nbsp;1PET'; $book_index[7] = 21;
			$bible_pages[8] = '2PET&nbsp;-&nbsp;2JOHN'; $book_index[8] = 24;
			$bible_pages[9] = '3JOHN&nbsp;-&nbsp;REV'; $book_index[9] = 27;
			$bible_pages[10] = 'GEN&nbsp;-&nbsp;LEV'; $book_index[10] = 31;
			$bible_pages[11] = 'NUM&nbsp;-&nbsp;JOSH'; $book_index[11] = 34;
			$bible_pages[12] = 'JUDG&nbsp;-&nbsp;1SAM'; $book_index[12] = 37;
			$bible_pages[13] = '2SAM&nbsp;-&nbsp;2KING'; $book_index[13] = 40;
			$bible_pages[14] = '1CHR&nbsp;-&nbsp;EZRA'; $book_index[14] = 43;
			$bible_pages[15] = 'NEH&nbsp;-&nbsp;JOB'; $book_index[15] = 46;
			$bible_pages[16] = 'PSM&nbsp;-&nbsp;ECCL'; $book_index[16] = 49;
			$bible_pages[17] = 'SONG&nbsp;-&nbsp;JER'; $book_index[17] = 52;
			$bible_pages[18] = 'LAM&nbsp;-&nbsp;DAN'; $book_index[18] = 55;
			$bible_pages[19] = 'HOS&nbsp;-&nbsp;AMOS'; $book_index[19] = 58;
			$bible_pages[20] = 'OBAD&nbsp;-&nbsp;MIC'; $book_index[20] = 61;
			$bible_pages[21] = 'NAH&nbsp;-&nbsp;ZEPH'; $book_index[21] = 64;
			$bible_pages[22] = 'HAG&nbsp;-&nbsp;MAL'; $book_index[22] = 67;
			$bible_pages[23] = '--'; $book_index[23] = 100;
			
?></center>

<!--<div id="main_container"  style=" height: 100%; width:100%; background-color: #4ab950; clear: both; color: #c6c2bb; overflow: scroll; "> -->

<script type="text/javascript">
    function JesusChrist_ig() {
    
       var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("bookspan").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "JesusChrist_igboBible.php" , true);
        xmlhttp.send();
    
}
</script>

<div id="mySidenav" class="sidenav2">
	 <a  id="about" href="index.php">Home</a>
	  <a id="blog" ><span style="font-size:20px;cursor:pointer" onclick="openNav()">Baịbul&nbsp;Nsọ</span></a>
	 <a  id="projects" >
	     <form action="JesusChrist_igbo.php" method="POST" enctype="multipart/form-data">
	         <input type="hidden" name="id" value="3" />
	         <button type="submit" name="search" class="button" style="width:auto;">Concordance</button></form>
	     </a>
<!--	 <a id="contact" href="view_updates.php?leo=5">Devotionals</a> -->
	 </div>
<div style="margin-left:80px;" id="main">
<div id="mySidenav2" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#" onclick="JesusChrist_ig()">Click here</a>
  <span id="bookspan"></span>
  <!--<a href="#">Services</a>-->
  <!--<a href="#">Clients</a>-->
  <!--<a href="#">Contact</a>-->
</div>


<center><table style="height: 100%; width: 75%" >
<?php

			function book_append($bid, $bname){
    if($bid<5){
     return "<h3>THE GOSPEL ACCORDING TO  </h3><h2>SAINT ".$bname."</h2>";
    }
    elseif($bid==5) return "<h2>THE ACTS OF THE APOSTLES</h2>";
    elseif($bid==6 || ($bid>8 && $bid<13))
     return "<h3>THE LETTER OF SAINT PAUL TO THE </h3><h2>".$bname."</h2>";
    elseif($bid==7 || $bid==13 || $bid==15){
     $x = explode("1", $bname); 
     return "<h3>THE FIRST LETTER OF SAINT PAUL TO THE </h3><h2>".$x[1]."</h2>";
    }
    elseif($bid==8 || $bid==14 || $bid==16){
     $x = explode("2", $bname); 
     return "<h3>THE SECOND LETTER OF SAINT PAUL TO THE </h3><h2>".$x[1]."</h2>";
    }
    elseif($bid==17 || $bid==18)
     return "<h3>THE LETTER OF SAINT PAUL TO </h3><h2>".$bname."</h2>";
    elseif($bid==19)
     return "<h3>THE LETTER TO THE</h3><h2>".$bname."</h2>";
    elseif($bid==20 || $bid==26)
     return "<h3>THE LETTER FROM</h3><h2> SAINT ".$bname."</h2>";
    elseif($bid==21){
     $x = explode("1", $bname); 
     return "<h3>THE FIRST LETTER FROM </h3><h2> SAINT ".$x[1]."</h2>";
    }
    elseif($bid==22){
     $x = explode("2", $bname); 
     return "<h3>THE SECOND LETTER FROM </h3><h2> SAINT ".$x[1]."</h2>";
    }
    elseif($bid==23){
     $x = explode("1", $bname); 
     return "<h3>THE FIRST LETTER OF </h3><h2> SAINT ".$x[1]."</h2>";
    }
    elseif($bid==24){
     $x = explode("2", $bname); 
     return "<h3>THE SECOND LETTER OF </h3><h2> SAINT ".$x[1]."</h2>";
    }
    elseif($bid==25){
     $x = explode("3", $bname); 
     return "<h3>THE THIRD LETTER OF </h3><h2> SAINT ".$x[1]."</h2>";
    }
    elseif($bid==27) return "<h2>THE ".$bname."</h2><h3> TO SAINT JOHN</h3>";
    elseif(($bid>=28 && $bid<=36) || ($bid>=43 && $bid<=46) || $bid==48 || $bid==51 || $bid==52 || $bid>53)
    return "<h3>THE BOOK OF </h3><h2>".strtoupper($bname)."</h2>";
    elseif($bid==37 || $bid==39 || $bid==41){
     $x = explode("1", $bname); 
     return "<h3>THE FIRST BOOK OF </h3><h2> ".strtoupper($x[1])."</h2>";
    }
    elseif($bid==38 || $bid==40 || $bid==42){
     $x = explode("2", $bname); 
     return "<h3>THE SECOND BOOK OF </h3><h2> ".strtoupper($x[1])."</h2>";
    }
    elseif($bid==47 || $bid==50) return "<h2>THE ".strtoupper($x[1])."</h2>";
    elseif($bid==49 || $bid==53) return "<h2>".strtoupper($x[1])."</h2>";
   }
echo '<div id="id03" class="modal">';
echo '<span onclick="viewbook" class="close" title="Close Modal">&times;</span>';
				  
 if(!empty($_POST['book']) && !empty($_POST['name']) ){
	
	echo '<tr class="stripeOdd" ><td colspan=3><h2><center>'.book_append($_POST['book'],$_POST['name']).'</center></h2></tr></td><tr class="stripeEven"><td colspan=3><h3 style="color:red"><center>HAVE YOU READ A CHAPTER OF THE BIBLE TODAY</center></h3></td></tr>';
	$chapterz = Chapters::find_by_book($_POST['book']);
	
	$n=1;
	
	if(empty($chapterz))echo "nothing found!!!";

	echo '<tr class="stripeEven"><th>CHAPTER</th><th>NUMBER OF VERSES</th><th></th></tr>';
	
	foreach($chapterz as $chapt)
	{
	    $stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
		echo '<tr class="'.$stripe.'"><td>Chapter '.$chapt->chapter.'</td>';
			echo '<td>'.$chapt->verses.'</td>';
			echo '<td><form action="JesusChrist_igbo.php" method="POST" enctype="multipart/form-data"><input type="hidden" value="'.$chapt->chapter.'" name="chapter" />';
			echo '<input type="hidden" value="'.$_POST['book'].'" name="book_id" />';
			echo '<input type="hidden" name="name" value="'.$_POST['name'].'" />';
			echo '<button type="submit" name="submit" />READ</button></form></td></tr>';
		$n++;
	}
	
 }
 echo '</div>';
 	$declare_chapter_id = 0;
 if(!empty($_POST['chapter']) && !empty($_POST['name'])){
	
	$date_time = time();
	$book_id = $_POST['book_id'];
	$chapter = $_POST['chapter'];
	$name = $_POST['name'];
	$getmax=0;
	$maxmin = Books::find_by_id($book_id);
	 $getmax = $maxmin->chapters;

	if(isset($_POST['prev_button'])){
		if($chapter>1) $chapter--;
		
	}
	if(isset($_POST['next_button'])){
		if($chapter<$getmax) $chapter++;
	}

	if($chapter!=0) echo '<tr class="stripeOdd" ><td colspan=2><h2><center>'.book_append($book_id,$name).' <h5>CHAPTER '.$chapter.'</center></h5></td></tr>';
	
	$verz = JESUS_CHRIST_Igbo::find_chaps($book_id, $chapter);
	
	$n=1;
	
	echo '<tr class="stripeEven"><th>VERSE</th><th><center>CONTENT</center></th></tr>';
	
	if(empty($verz)) echo '<tr><td colspan=2><h3>NOT FOUND!!!</h3></td></tr>';
	
	foreach($verz as $verse)
	{
	    
		$stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
		
		echo '<tr class="'.$stripe.'"><td><b style="color:blue">'.$chapter.'&nbsp;:&nbsp;'.$verse->JESUS_CHRIST_verse.'</b></td>';
		echo '<td>'.$verse->JESUS_CHRIST_text.'</td></tr>';
		$n++;
	}

	//$sql = "select * from chapters where (chapters.book_id = ".$book_id." AND chapters.chapter = ".$chapter.") order by verses ASC";
	//$query = mysql_query($sql);
	//while($verse = mysql_fetch_array($query)){
	//	$declare_chapter_id = $verse['id'];
	//}
	$smites = Chapters::find_chapter($book_id, $chapter);
	foreach($smites as $smite){
	 	$declare_chapter_id = $smite->id;
	}
	
	
	echo '<form action="JesusChrist_igbo.php" method="POST" id="form1" enctype="multipart/form-data" >';
	echo '<input type="hidden" name="chapter" value="'.$chapter.'" />';
	echo '<input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>';
	echo '<input type="hidden" id="topic_id" name="topic_id" value="'.$declare_chapter_id.'" />';
	
	echo '<input type="hidden" name="name" value="'.$name.'" />';
	echo '<input type="hidden" name="book_id" value="'.$book_id.'" />'; 
	 
	//echo '<span  id="commenter"/>SUBMIT</span>';
//	echo '<br><center><span id="success"></span></center>';
	echo '<tr class="stripeEven"><td colspan=2><center><div class="btn-group"><button type="submit" name="prev_button" id="prev"/>PREVIOUS CHAPTER</button>';
	echo '<button type="submit" name="next_button" id="next"/>NEXT CHAPTER</button>';
	echo '<span id="view" style="font-size:13px;cursor:pointer; background-color: #4CAF50;
    color: white;" onclick="openNav1()">&#9776; VIEW COMMENTARIES</span></div></center></td></tr></form>';
//	echo '</td></tr>';
	?>
	
        
	<?php
	
	
 }
  
 if(!empty($_POST['id']) && $_POST['id']==3){
	$id = $_POST['id'];
	$track = empty($_POST['search']) ? '' : $_POST['search'];
	$code = empty($_POST['search_field']) ? '' : trim($_POST['search_field']);
	$a_session = empty($_POST['option']) ? '' : $_POST['option'];
	
	 $searchItem = empty($_POST['search_field']) ? 'Please Enter the Search Word of the KJV Bible' : $_POST['search_field'];
	 echo '<tr><td colspan=3><span style="width: 80%; height: 10px;"><center>SEARCH ITEM: &nbsp;<b style="color:red">'.$searchItem.'</b></center></span></td></tr>';
	
	
	if(!empty($_POST['search_field']) && isset($_POST['search']) && !empty($_POST['option']) && $_POST['option']==1){
		$searchText = trim($_POST['search_field']);
		if(empty($_POST['search_field'])) $searchText = 'fasting';
		
		$range = Verses::find_range($book_index[$lower_limit], $book_index[$page]);
	
		$n=1; $found=0;
		
		foreach($range as $vers){
			$Dword= explode(" ", $vers->text);
			for($i=0; $i<count($Dword); $i++){
				$bitWord1 = explode(',', $Dword[$i]);
				for($j=0; $j<count($bitWord1); $j++){
					$bitWord2 = explode(';', $bitWord1[$j]);
					for($k=0; $k<count($bitWord2); $k++){
						$bitWord3 = explode('.', $bitWord2[$k]);
						for($z=0; $z<count($bitWord3); $z++){
							$bitWord4 = explode(':', $bitWord3[$z]);
							for($m=0; $m<count($bitWord4); $m++){
								$bitWord5 = explode('?', $bitWord4[$m]);
								for($t=0; $t<count($bitWord5); $t++){
									$bitWord6 = explode('!', $bitWord5[$t]);
									for($r=0; $r<count($bitWord6); $r++){
										$bitWord7 = explode(']', $bitWord6[$r]);
										for($v=0; $v<count($bitWord7); $v++){
											$bitWord8 = explode('[', $bitWord7[$v]);
											for($s=0; $s<count($bitWord8); $s++){
												if(strtolower($searchText)==strtolower($bitWord8[$s]))
													$found=1;
											}
										}
									}
								}
							}
						}
					}
				}
			}
			if($found)	{
				
				$bid = Books::find_by_id($vers->book_id);
				
				$str_quote = $bid->abbrv.'.'.$vers->chapter.':'.$vers->verse; 
				$stripe = ($n%2==1) ? 'stripeOdd' : 'stripeEven';
				echo '<tr class="'.$stripe.'"><td>'.$n.'</td><td>'.$verse['text'].'</td><td>';
				    echo '<form action="bible.php" method="POST" enctype="multipart/form-data">'; 
        		echo '<input type="hidden" name="name" value="'.$bookname['book'].'" />';
            	echo '<input type="hidden" name="book_id" value="'.$verse['book_id'].'" />';
            	echo '<input type="hidden" name="chapter" value="'.$verse['chapter'].'" />';
            	echo '<button type="submit" class="button" style="width:auto;">'.$str_quote.'</button>';
            	echo '</form></td></tr>';
				$n++;
			}
			$found=0;					
		}
		if($n==1) echo '<tr class="stripeOdd"><td colspan=3><h3 style="color:red">NOT FOUND</h3></td></tr>';
		else echo '<tr class="stripeOdd"><td colspan=3><h3 style="color:red">"'.$searchText.'" APPEARED IN '.($n-1).' VERSES </h3></td></tr>';
		echo '<tr class="stripeOdd"></tr>';
	}
	
	if(!empty($_POST['search_field'])  && isset($_POST['search']) && !empty($_POST['option']) && $_POST['option']==2 ){
		
		$searchText = trim($_POST['search_field']);
		if(empty($_POST['search_field'])) $searchText = 'fasting';
		$book_id = empty($_POST['book_id']) ? 0 : $_POST['book_id'];
		
		$verzez = JESUS_CHRIST_Igbo::find_range($book_index[$lower_limit], $book_index[$page]);
		if(!empty($_POST['bookSearch']) && $_POST['bookSearch']==2) 
		
		$verzez = JESUS_CHRIST_Igbo::find_active($book_id);
		
		$n=1; $found=0;
		if(empty($verzez)) echo 'empty query returned!!!';
		
		foreach($verzez as $verse)
		{
			$verseArray = str_split($verse->text, 1); // array of verse body
			$searchArray = str_split($searchText, 1); // array of search text
			$foundMatches = array(); $matchCount=0;
			for($i=0; $i<count($verseArray); $i++){
				$match = 0; $cut=0;
				if(strtolower($searchArray[0])==strtolower($verseArray[$i])){
					$match=1;
					if((count($searchArray)+$i)>count($verseArray)){
						$match =0;
					}
					for($z=1; $z<count($searchArray); $z++){
						if(strtolower($searchArray[$z]) == strtolower($verseArray[$z+$i])) $match = 1;
						else { $match =0;
							$cut=1;
							break;
						}
					}
					
				}
				
				if($match==1 && $cut==0){
						$matchCount++;
						$foundMatches[$matchCount] = $i;
				}
			}
			if(!empty($foundMatches)){ //if match found
				$verseString=''; 
				for($ten=0; $ten<count($verseArray); $ten++){
					$char=''; $matchString=''; $gfont=1;
					if(strtolower($verseArray[$ten])==strtolower($searchArray[0])){ //if match start_index found
						
						
						for($h=0; $h<count($searchArray); $h++){ //select match
							//$char = '<b style="color:red">'.$verseArray[$t].'</b>';
							if(strtolower($verseArray[$ten])!=strtolower($searchArray[$h])) $gfont=0;
							$matchString .= $verseArray[$ten++]; 
							
						}
						$matchCount++; //number of total word matches
						if ($gfont==1) $matchString = '<b style="color: green;">'.$matchString.'</b>';// set match font color to red
						$verseString .= $matchString; $ten--;// merge match to verse string
					}
					else 
					$verseString .= $verseArray[$ten]; //attach split array value to string of verse
				}
				
				$bid = Books::find_by_id($verse->book_id);
				//$query2 = mysql_query($sql2);
			//	$bookname = mysql_fetch_array($query2);
				$str_quote = $bid->abbrv.'.'.$verse->chapter.':'.$verse->verse; 
				
				$stripe = ($n%2==0) ? 'stripeOdd' : 'stripeEven';
				echo '<tr class="'.$stripe.'"><td>'.$n.'</td><td>'.$verseString.'</td><td>';
				    echo '<form action="bible.php" method="POST" enctype="multipart/form-data">'; 
        		echo '<input type="hidden" name="name" value="'.$bid->book.'" />';
            	echo '<input type="hidden" name="book_id" value="'.$verse->book_id.'" />';
            	echo '<input type="hidden" name="chapter" value="'.$verse->chapter.'" />';
            	echo '<button type="submit" class="button" style="width:auto;">'.$str_quote.'</button>';
            	echo '</form></td></tr>';
				$n++;
			}
		}
		if($n==1) echo '<tr class="stripeOdd"><td colspan=3><h3 style="color:red"><center>NOT FOUND IN '.$bible_pages[$page].'</center></h3></td></tr>';
		else echo '<tr class="stripeOdd"><td colspan=3><h3 style="color:red"><center>"'.$searchText.'" APPEARED IN '.($n-1).' VERSE(S) FROM '.$bible_pages[$page].'</center></h3></td></tr>';
		
	}
	$current_page = $page;
	$previous_page = $current_page-1;
	$next_page = $current_page+1;
	$encounter=1;
	if(count($bible_pages) > 1 && empty($_POST['bookSearch'])) {
		
		if($current_page>1) { 
		echo "<tr style=\" height:3em\" class=\"stripeEven\"><td colspan=3>";
		echo "<table style='width:100%;'><tr><td>";
		echo '<form action="JesusChrist_igbo.php" method="POST" enctype="multipart/form-data">'; 
		echo '<input type="hidden" name="search" value="'.$track.'" />';
    	echo '<input type="hidden" name="search_field" value="'.$code.'" />';
    	echo '<input type="hidden" name="book_page" value="'.$book_index[$page].'" />';
    	echo '<input type="hidden" name="option" value="'.$a_session.'" />';
    	echo '<input type="hidden" name="id" value="'.$id.'" />';
    	echo '<input type="hidden" name="page" value="'.$previous_page.'" />';
    	echo '<button type="submit" class="button" style="width:auto;">&laquo;&nbsp;Previous</button>';
    	echo '</form></td>';
    
    }
    else echo "<tr style=\" height:3em\" class=\"stripeEven\"><td colspan=3><table style='width:100%;'><tr><td>";

		for($i=1; $i <= (count($bible_pages)-2); $i++) {
			if($encounter==1) echo '<td>';
			
			if($encounter%8==0) echo "</tr></table></tr><tr style=\" height:3em\" class=\"stripeOdd\"><td colspan=3><table style='width:100%;'><tr><td>";
			else echo "<td>";
		
			if($i == $page) {
				echo " <span class=\"selected\">{$bible_pages[$i]}</span></td>";
			} else {
			  echo '<form action="JesusChrist_igbo.php" method="POST" enctype="multipart/form-data">'; 
			  echo '<input type="hidden" name="search" value="'.$track.'" />';
			  echo '<input type="hidden" name="search_field" value="'.$code.'" />';
			  echo '<input type="hidden" name="book_page" value="'.$book_index[$page].'" />';
			  echo '<input type="hidden" name="option" value="'.$a_session.'" />';
			  echo '<input type="hidden" name="id" value="'.$id.'" />';
			  echo '<input type="hidden" name="page" value="'.$i.'" />';
			  echo '<button type="submit" class="button" style="width:auto;">'.$bible_pages[$i].'</button>';
              echo '</form></td>';
			
			}
			$encounter++;
		}
        if($current_page>=22) echo '</tr></table></td></tr>';
		elseif($current_page<22) { 
		    echo '<td><form action="JesusChrist_igbo.php" method="POST" enctype="multipart/form-data">'; 
		    echo '<input type="hidden" name="search" value="'.$track.'" />';
		    echo '<input type="hidden" name="search_field" value="'.$code.'" />';
		    echo '<input type="hidden" name="book_page" value="'.$book_index[$page].'" />';
		     echo '<input type="hidden" name="option" value="'.$a_session.'" />';
		     echo '<input type="hidden" name="id" value="'.$id.'" />';
		     echo '<input type="hidden" name="page" value="'.$next_page.'" />';
		     echo '<button type="submit" class="button" style="width:auto;">Next&nbsp;&raquo;</button>';
		     echo '</form></td></tr></table></td></tr>';
	
    }
     
		
	}

 }

 // onsubmit="myfunc();"
  if(!empty($_POST['chapter']) && !empty($_POST['name'])){
?>
<form  method="post"  enctype="multipart/form-data" id="form2" onsubmit="myfunc();">
    <input type="hidden" id="logged" name="logged" value="<?php echo $session->is_logged_in(); ?>" />

	<input type="hidden" id="topic_id" name="topic_id" value="<?php echo $declare_chapter_id; ?>" />
	 <input type="hidden" id="identity" name="identity" value="
	  <?php if($session->is_logged_in()) echo $session->user_id; ?>
	  " />
	<tr class="stripeOdd"><td colspan=2><center> <div id="preview"></div> </center>
	<input type="text" id="comment" name="comment" placeholder="Please write your Bible commentary here if you have logged in..."  style="width: 80%" required />
	<input class="button" type="submit" value="Send">
       
        <center><span id="succeed" style="color: blue;"></span></center></td></tr></form>
        <?php  } ?>
</table></center>

<div id="myNav" class="overlay" >
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav1()">&times;</a>
  
  <div class="overlay-content">
 
  <a href="#">POSTED COMMENTARY
    <!--  <button onclick="loadcommentary()" style="width:auto;">LOAD COMMENTARY</button> -->
      </a> 
    <span id="commentaryspan"> </span><br>
  
 
  </div>
</div>
<div id="myModal1" class="modal1">

  <!-- Modal content -->
  <div class="modal-content1">
    <div class="modal-header1">
      <span class="close1">&times;</span>
      <h2><center>COUNSEL</center></h2>
    </div>
    <div class="modal-body1">
      <p><center>Please, you are kindly advised to log in before making any attempt to add a commentary.</center></p>
      <p><center>You can click on Home and Sign up to create an account. Thank you!</center></p>
    </div>
    <div class="modal-footer1">
      <h3><center>Leoportals -- the network of faith...</center></h3>
    </div>
  </div>

</div>
<!--
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/chat.js"></script> -->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
function toggler() {
    var x = document.getElementById('myDIV');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
    
   // loadingform();
}
function openNav() {
    document.getElementById("mySidenav2").style.width = "250px";
    document.getElementById("mySidenav2").style.display = 'block';
}

function closeNav() {
    document.getElementById("mySidenav2").style.width = "0";
    document.getElementById("mySidenav2").style.display = 'none';
    
}
function openNav1() {
    document.getElementById("myNav").style.height = "100%";
    document.getElementById("myNav").style.display = 'block';
    var x = document.getElementById('myDIV');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    }
}

function closeNav1() {
    document.getElementById("myNav").style.height = "0%";
    document.getElementById("myNav").style.display = 'none';
}

// Get the modal
var modal = document.getElementById('myModal1');

// Get the button that opens the modal
//var btn = document.getElementById("commenter");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close1")[0];

// When the user clicks the button, open the modal 


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


    

//$(document).ready(function (e) {
// $("#form").on('submit',(function(e) {
function myfunc(){
   var logstate = document.getElementById("logged").value;
    if(logstate==false){
        modal.style.display = "block";
    }else{
	 
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
		      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			  document.getElementById("succeed").innerHTML = xmlhttp.responseText;
		      }
		  };
		  var commentr = document.getElementById("comment").value;
		  var users = document.getElementById("identity").value;
		  var chapter_id = document.getElementById("topic_id").value;
		  xmlhttp.open("GET", "insertcommentary.php?comment=" + commentr + "&identity=" + users + "&topic_id=" + chapter_id, true);
		  xmlhttp.send();
		  $("#comment").val('');
	        return false;
    }
 }
 var form = document.getElementById("form2");
function handleForm(event) { event.preventDefault(); } 
form.addEventListener('submit', handleForm);
//));
//});
$(document).ready(function (e) {
 $("#form3").on('submit',(function(e) {
  e.preventDefault();
  
  $.ajax({
         url: "insertcommentary.php",
   	   /*  xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                         $(".progress-bar").html(percentComplete + '%');
                        $(".message").html('<b style="color:red">Please wait a few seconds while the image successfully uploads</b>');
                    }
                }, false);
                return xhr;
            }, */
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   beforeSend : function()
   {
    //$("#preview").fadeOut();
    $("#succeed").fadeOut();
     //$(".progress-bar").width('0%');
              //  $('#uploadStatus').html('<img src="images/loading.gif"/>');
   },
   success: function(data)
      {
    if(data=='invalid')
    {
     // invalid file format.
     $("#succeed").html("Invalid Entry !").fadeIn();
    }
    else
    {
     // view uploaded file.
     $("#respondspan").html(data).fadeIn();
     $('input[type="text"],textarea').val('');
    }
      },
     error: function(e) 
      {
    $("#succeed").html(e).fadeIn();
      }          
    });
    
 }));
});

// Update the time every 1 second
var f = setInterval(function() {
   loadcommentary(); 
}, 1000);
</script>
				<center>	
				
				<div class="footer" >
				    <h3>Please click Baịbul Nsọ by the left edge of the screen</h3>
				<h2>ALL REFERENCES FROM THE BAỊBUL NSỌ IGBO BIBLE SOCIETY OF NIGERIA (BSN)</h2> 
			</div>
				</center>
				



<?php echo footer(); ?>