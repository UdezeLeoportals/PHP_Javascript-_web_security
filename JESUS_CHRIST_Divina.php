<?php

require_once("./includes/initialize.php");


 echo add_header($session->username, $session->type);
?>
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<script type="text/javascript" src="scripts/validates.js"></script>
<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
<link rel="stylesheet" href="styles/update_styles.css" type="text/css" /> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<style>
    .stripeEven a:visited {
            color:red;
        }
        .stripeEven a:active {
            color:blue;
        }
        #syn {
    top: 360px;
    background-color: #f44336;
        }

.blinking{
    animation:blinkingText 1.3s infinite;
    color: blue;
}
@keyframes blinkingText{
    0%{     color: #000;    }
    49%{    color: #000; }
    60%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: #000;    }
}

</style>


    <center><h2 >LOV VERBUM DEI PAGE</h2>
    
    <h2>LECTIO DIVINA PRAYER LEAFLETS</h2>
   <h4 style="color: purple;"> ALMIGHTY GOD, SAVE US FROM DAMNATION.<BR> IN THE MIGHTY NAME OF OUR LORD AND SAVIOUR JESUS CHRIST. AMEN! <h4></center>
   <center> <table>
        <tr><th>S. NO</th><th>TITLE</th><th>WEEK</th><td>OPEN</td></tr>
        <?php 
       $JESUS_CHRIST_c=0;
        $JESUS_CHRIST_pdfs = Photos::find_by_type();
        foreach($JESUS_CHRIST_pdfs as $JESUS_CHRIST_pdf){
            
            $JESUS_CHRIST_c++;
            ?>
            <tr><td><?php echo  $JESUS_CHRIST_c; ?></td><td><?php echo   $JESUS_CHRIST_pdf->paper_title; ?></td><td><?php echo  $JESUS_CHRIST_pdf->fieldOS; ?></td><td>
                <form method="post" action="view_pdf.php" enc_type="multipart/form-data">
                    <input type="hidden" value="<?php echo $JESUS_CHRIST_pdf->filename; ?>" name="JESUS_CHRIST_file" />
                    <input class="button" type="submit" value="View" name="JESUS_CHRIST_submit">
                </form>
            </td></tr><?php //echo $JESUS_CHRIST_pdf->filename; ?>
            <?php
        }
        ?>
    </table></center>
    
    
    

    <?php 

?>
<script>

</script>

<?php 


echo footer(); ?>
