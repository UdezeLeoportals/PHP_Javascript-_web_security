<?php

require_once("./includes/initialize.php");


if (!($session->is_logged_in() && $session->type=="admin")) {
    
header("Location: http://www.adonaibaibul.com/index.php", true, 301);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd" >


<?php
	
 echo add_header($session->username, $session->type);
 ?>

<script type="text/javascript" src="scripts/biblical.js"></script>

 <link rel="stylesheet" href="styles/css/biblecss.css" type="text/css" />
 <link rel="stylesheet" href="styles/chat_design.css" type="text/css" /> 
<link rel="stylesheet" href="styles/css/modallogin.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="styles/update_styles.css" type="text/css" /> 

<script type="text/javascript" src="scripts/validates.js"></script>
<style>
    th, label, td{
        color: black;
    }
</style>
<center>
    <?php 
  

/**
* Encrypts given data with given key, iv and aad, returns a base64 encoded string.
*
* @param string $plaintext - Text to encode.
* @param string $key - The secret key, 32 bytes string.
* @param string $iv - The initialization vector, 16 bytes string.
* @param string $aad - The additional authenticated data, maybe empty string.
*
* @return string - The base64-encoded ciphertext.
*/
function encrypt(string $plaintext, string $key, string $iv = '', string $aad = ''): string
{
    $ciphertext = openssl_encrypt($plaintext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag, $aad, 16);

    if (false === $ciphertext) {
        throw new UnexpectedValueException('Encrypting the input $plaintext failed, please checking your $key and $iv whether or nor correct.');
    }

    return base64_encode($ciphertext . $tag);
}

/**
* Takes a base64 encoded string and decrypts it using a given key, iv and aad.
*
* @param string $ciphertext - The base64-encoded ciphertext.
* @param string $key - The secret key, 32 bytes string.
* @param string $iv - The initialization vector, 16 bytes string.
* @param string $aad - The additional authenticated data, maybe empty string.
*
* @return string - The utf-8 plaintext.
*/
function decrypt(string $ciphertext, string $key, string $iv = '', string $aad = ''): string
{
    $ciphertext = base64_decode($ciphertext);
    $authTag = substr($ciphertext, -16);
    $tagLength = strlen($authTag);

    /* Manually checking the length of the tag, because the `openssl_decrypt` was mentioned there, it's the caller's responsibility. */
    if ($tagLength > 16 || ($tagLength < 12 && $tagLength !== 8 && $tagLength !== 4)) {
        throw new RuntimeException('The inputs `$ciphertext` incomplete, the bytes length must be one of 16, 15, 14, 13, 12, 8 or 4.');
    }

    $plaintext = openssl_decrypt(substr($ciphertext, 0, -16), 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $authTag, $aad);

    if (false === $plaintext) {
        throw new UnexpectedValueException('Decrypting the input $ciphertext failed, please checking your $key and $iv whether or nor correct.');
    }

    return $plaintext;
}

// usage samples
$aesKey = random_bytes(32);
$aesIv = random_bytes(16);
//$ciphertext = encrypt('thing', $aesKey, $aesIv);
//$plaintext = decrypt($ciphertext, $aesKey, $aesIv);

//var_dump($ciphertext);
//var_dump($plaintext);
    if(isset($_POST['submit'])){
        $name= test_input($_POST['name']);
        $number = test_input($_POST['num']);
        $date = test_input($_POST['date']);
        $cvc = test_input($_POST['cvc']);
         
        $number_cipher = encrypt($number, $aesKey, $aesIv);
        $date_cipher = encrypt($date, $aesKey, $aesIv);
        $cvc_cipher = encrypt($cvc, $aesKey, $aesIv);
        $name_cipher = encrypt($name, $aesKey, $aesIv);
        //echo $cipher;
        
        $latest = Creditcard::find_last();
        $lid=0;
        foreach($latest as $l){
            $lid = $l->id;
        }
        $lid++;
        
        $newCard = new Creditcard();
        $newCard->id = $lid;
	    $newCard->cardnum = $number_cipher;
	    $newCard->expiry = $date_cipher;
	    $newCard->name = $name_cipher;
	    $newCard->cvc = $cvc_cipher;
	    $newCard->aes_key = base64_encode($aesKey);
	    $newCard->iv = base64_encode($aesIv);
	    $newCard->create();
        
        echo '<h3>Card successfully added to the database!</h3>';
       // echo decrypt($cipher, $aesKey, $aesIv);
    }
    ?>
    <h2>CREDIT CARD MANAGEMENT</h2>
    <table style="height: 100%; width: 75%; opacity: 0.8; font-size: 16px;" >
    <tr class="stripeOdd"><th></th><th>
        <form action="cryptocards.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="option" value="1" />
        <button type="submit" name="insert" style="width:auto;">Insert credit card</button></form>
    </th><th>
        <form action="cryptocards.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="option" value="2" />
        <button type="submit" name="viewenc" style="width:auto;">View Encrypted cards</button></form>
        </th><th>
            <form action="cryptocards.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="option" value="3" />
            <button type="submit" name="viewdec" style="width:auto;">View decrypted cards</button></form>
        </th></tr>
        <?php
            if(isset($_POST['viewenc'])){
             echo '<tr class="stripeEven"><th colspan=4><center>DETAILS OF ENCRYPTED CARDS</center></td></tr>'; 
             echo '<tr class="stripeOdd"><th>CARD NAME</th><th>CARD NUMBER</th><th>EXPIRY DATE</th><th>CVC</th></tr>';
             $allcards = Creditcard::find_all();
             $n=0;
             foreach($allcards as $card){
                 $n++;
                 $class = ($n%2==0) ? 'stripeOdd' : 'stripeEven';
                 echo '<tr class="'.$class.'"><td>'.$card->name.'</td><td>'.$card->cardnum.'</td><td>'.$card->expiry.'</td><td>'.$card->cvc.'</td></tr>';
             }
            }
            if(isset($_POST['viewdec'])){
             echo '<tr class="stripeEven"><th colspan=4><center>DETAILS OF DECRYPTED CARDS</center></td></tr>'; 
             echo '<tr class="stripeOdd"><th>CARD NAME</th><th>CARD NUMBER</th><th>EXPIRY DATE</th><th>CVC</th></tr>'; $n=0;
             $allcards = Creditcard::find_all();
             foreach($allcards as $card){
                 $dec_key = base64_decode($card->aes_key);
                 $dec_iv = base64_decode($card->iv);
                 $n++;
                 $class = ($n%2==0) ? 'stripeOdd' : 'stripeEven';
                 echo '<tr class="'.$class.'"><td>'.decrypt($card->name, $dec_key, $dec_iv).'</td><td>'.decrypt($card->cardnum, $dec_key, $dec_iv).'</td><td>'.decrypt($card->expiry, $dec_key, $dec_iv).'</td><td>'.decrypt($card->cvc, $dec_key, $dec_iv).'</td></tr>';
             }
            }
        ?>
    </table>
    <?php 
     if(isset($_POST['insert'])){
    ?>
    <div style="margin: 24px 0; width: 45vw;" >
    <form action="cryptocards.php" method="post" id="form2" enctype="multipart/form-data" onsubmit="">
   <label>NAME ON CARD:</label>
        <input type="text"  name="name" id="name" placeholder="Enter the name on the card" required/>
   <label>CARD NUMBER:</label>
        <input type="text"  name="num" id="num" placeholder="Enter the 16-digit number on the card" required/>
    <label>EXPIRY DATE:</label>
        <input type="text"  name="date" id="date" placeholder="e.g. 12/2021" required/>    
    <label>CVC:</label>
        <input type="text"  name="cvc" id="cvc" placeholder="Enter the 3-digit number at the back of the card" required/>
   <p>
       <input class="button" name="submit" type="submit" value="Submit"><br>
        <center><div id="preview2"></div></center>
        <center><span id="succeed2" style="color: blue"></span></center></p>
    </form> </div>
    <?php } ?>
    </center>
<?php echo footer(); ?>