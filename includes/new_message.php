<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);
?>
<!-- ####################################################################################################### -->

<!-- ####################################################################################################### -->
<div class="wrapper col3">
  <div id="featured_slide">
    <div id="featured_wrap">
      <ul id="featured_tabs">
        <li><a href="#fc1"><br />
          <span></span></a></li>
        <li><a href="#fc2"><br />
          <span></span></a></li>
        <li><a href="#fc3"><br />
          <span></span></a></li>
        <li class="last"><a href="#fc4"><br />
          <span></span></a></li>
      </ul>
      <div id="featured_content">
        <div class="featured_box" id="fc1"><img src="images/demo/1.png" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc2"><img src="images/demo/2.png" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc3"><img src="images/demo/3.gif" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
        <div class="featured_box" id="fc4"><img src="images/demo/4.gif" alt="" />
          <div class="floater"><a href="#">Continue Reading &raquo;</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$students = Student::find_by_user_id($session->user_id);
 
 foreach($students as $student){
    if(!empty($student->message)){
    echo '<div class="floater">MESSAGE:</div>';
    echo '<div class="floater">'.$student->message.'</div>';
    }else echo '<div class="floater">NO NEW MESSAGE!!</div>';
 }
?>
<!-- ####################################################################################################### -->
<?php echo footer(); ?>