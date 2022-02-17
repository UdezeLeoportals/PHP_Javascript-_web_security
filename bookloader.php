<?php
      
    require_once("./includes/initialize.php");  
      $data ="";
            //$sql = "select * from books where 1 order by testament_id, id ASC";
            $bookz = Books::find_all(); 
	    //$query = mysql_query($sql); $n=1;
	     //while ($book = mysql_fetch_array($query))
	    
	     foreach($bookz as $book){
                
                    $data .= '<form action="bible.php" method="post" enctype="multipart/form-data"><input type="hidden" name="book" value="'.$book->id.'" >';
                    $data .= '<input type="hidden" name="name" value="'.$book->book.'" >';
            
                    $data .= '<button style="font-size: 18px; width:auto;" onclick="bookpane">';
                    $data .= strtoupper($book->book).'</button></form>';
                
                $n++;
             }
        
        echo $data;
       ?>