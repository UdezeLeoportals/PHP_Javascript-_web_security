<?php
require_once(LIB_PATH.DS.'database.php');
class Session {
	private $logged_in = false;
	public $user_id;
	public $username;
	public $status;
	public $type;
	public $password;
	public $comm_pass;
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
	}
  public function is_logged_in() {
    return $this->logged_in;
  }
  public function is_admin(){
    return ($this->a_level == "admin") ? true : false;
  }
  public function is_user(){
    return ($this->a_level == "user") ? true : false;
  }
  public function get_full_name() {
    if(isset($this->first_name) && isset($this->surname)) {
      return $this->surname . " " . $this->first_name;
    } else {
      return " ";
    }
  }
  public static function working_batch($batch) {
	$_SESSION["working_batch"] = $batch;
  } 
  public static function working_year($year) {
	$_SESSION["working_year"] = $year;
  } 
    public function login($user) {
    if($user){
      $this->user_id = $_SESSION['user_id'] = $user->id;
       $_SESSION['li_username'] = $user->username;
       $_SESSION['li_type'] = $user->type;
       $_SESSION['li_status'] = $user->status;
       $_SESSION['li_password']=$user->password;
       $_SESSION['li_comm_pass']=$user->comm_pass;
       $_SESSION['username'] = $user->username;
       $_SESSION['DB'] = null;
       $_SESSION['start'] = time();
       $_SESSION['over'] = $_SESSION['start'] + (60);
      $this->logged_in = true;
    }
  }
  public function basic_info($info) {
    if($info){
      //$this->user_id = $_SESSION['user_id'] = $user->id;
       $_SESSION['basic_state'] = $info->state;
	   $_SESSION['basic_state_id'] = $info->state_id;
	   $_SESSION['basic_abb'] = $info->abbreviation;
	   $_SESSION['basic_batch'] = $_SESSION['working_batch'] =  $info->batch;
	   $_SESSION['basic_service_batch'] = $_SESSION['working_service_batch'] =  $info->service_batch;
	   $_SESSION['basic_year'] = $_SESSION['working_year'] = $info->year;
	   $_SESSION['page_limit'] = $info->page_limit;
    }
  }
  public function not_active(){
        if(($this->active != 1)) {
		return true;
		} else { return false;} 
  }
  public function instantiate(){
	if(isset($_SESSION['user_id'])){
		$this->username = $_SESSION['li_username'] ;
        $this->type = $_SESSION['li_type'] ;
        $this->status = $_SESSION['li_status'] ;       
        $this->password=$_SESSION['li_password'];
	$this->comm_pass = $_SESSION['li_comm_pass'];
	} else {
	  	//die("the user ID was not set");
		
	}
  }
  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->logged_in = false;
  }
    public function message($msg="",$type="successText") {
	  if(!empty($msg)) {
	    // then this is "set message"
	    // make sure you understand why $this->message=$msg wouldn't work
	    $_SESSION['message'] = "<span class='{$type}'>  ".$msg." </span>";
	  } else {
	    // then this is "get message"
			return $this->message;
	  }
	}
    private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }
    private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {
      $this->message = "";
    }
	}
	
}
$session = new Session();
$message = $session->message();
$init = $session->instantiate();
//session.save_path = "/var/cpanel/php/sessions/ea-php56"
?>