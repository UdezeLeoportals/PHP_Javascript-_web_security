<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');
require_once("./includes/initialize.php"); 
 set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());

require_once "./Mailing/Mail.php";
//require_once "./Mailing/Mail_Mime/Mail/mime.php";
class Failed_log  {

	protected static $table_name="failed_log";
	protected static $db_fields = array('id', 'username', 'attempt', 'timestamp');
	
	public $id;
	public $username;
	public $attempt;
	public $timestamp;
	
	
	// Common Database Methods
   public static function find_all() {
		return self::find_by_sql2("SELECT * FROM ".self::$table_name." order by id");
  }
   public static function find_last() {
		return self::find_by_sql2("SELECT id FROM ".self::$table_name." ORDER BY id DESC LIMIT 1");
  } 
   public static function find_fail($dept_id="") {
		return self::find_by_sql2("SELECT * FROM ".self::$table_name." WHERE username='{$dept_id}' AND attempt=1 ");
   }
   public static function find_by_user_id($user_id="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE user_id=? LIMIT 1",$user_id);
  }
     public static function find_by_dept_id($dept_id="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE dept_id={$dept_id} ");
  }
   public static function find_by_email($user_id="") {
		return self::find_by_sql2("SELECT * FROM ".self::$table_name." WHERE email='{$user_id}' LIMIT 1");
  }
    public static function find_active($per_page=10, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE active = 1  ORDER BY surname, first_name, username, a_level   LIMIT  ".$per_page. " OFFSET ".$offset." ");
    }
	
	public static function find_inactive($per_page=10, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE active = 0   ORDER BY surname, first_name, username, a_level   LIMIT  ".$per_page. " OFFSET ".$offset." ");
    }
public static function change_message($id, $new){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET message = '".$new."' where id = ".$id);
   }	
   public static function change_status($id, $new_status){
	global $database;
	$new_status = $database->escape_value($new_status);
      	self::find_by_sql( " UPDATE ".self::$table_name." SET active = ".$new_status." where id = ".$id);
   }
   
    public static function get_password($id){
		global $database;
		$result = $database->query(" SELECT   password as numb FROM ".self::$table_name." WHERE id  = {$id} ");
		$count = $database->fetch_array($result);
		return $count['numb'];
    }
	
	public static function get_lga($id){
		
		global $database;
		$result = $database->query("SELECT  lga as numb FROM ".self::$table_name." WHERE id  = {$id} ");
		$count = $database->fetch_array($result);
		return $count['numb'];
    }
	
	
	
	public static function get_role($id){
		global $database;
		$result = $database->query("SELECT  a_level as numb FROM ".self::$table_name." WHERE id  = {$id} ");
		$count = $database->fetch_array($result);
		return $count['numb'];
    }
	
	public static function is_admin($id){
		global $database;
		$result = $database->query(" SELECT   1 as numb  FROM ".self::$table_name." WHERE id  = {$id} AND a_level = 'admin' AND active =  1");
		$count = $database->fetch_array($result);
		return ($count['numb'] == 1) ? true : false;
    }
	
	public static function is_mob($id){
		global $database;
		$result = $database->query(" SELECT   1 as numb FROM ".self::$table_name." WHERE id  = {$id}  AND active = 1 AND ( a_level IN ('mob',  'admin'))");
		$count = $database->fetch_array($result);
		return ($count['numb'] == 1) ? true : false;
    }
	
	public static function is_staff($id){
		global $database;
		$result = $database->query(" SELECT   1 as numb  FROM ".self::$table_name." WHERE id  = {$id}  AND active = 1 ");
		$count = $database->fetch_array($result);
		return ($count['numb'] ==  1) ? true : false;
    }
	
   public static function change_filename($id, $new_password){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET filename = '".$new_password."' where id = ".$id);
   }
   
	public static function change_role($id, $new_role, $new_lga = 0){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET a_level = '".$new_role."', lga = {$new_lga} where id = ".$id);
    }
   
   public static function edit_profile($id, $surname, $first_name, $sex){
	global $database;
	$surname = $database->escape_value($surname);
	$first_name = $database->escape_value($first_name);
	$sex = $database->escape_value($sex);
	self::find_by_sql(" UPDATE ".self::$table_name." SET surname = '{$surname}', first_name = '{$first_name}', sex = '{$sex}' WHERE id = ".$id);
   }
   
   public static function get_fullname(){
	/*global $database;
	$result = $database->query3(" SELECT  surname, first_name FROM ".self::$table_name."   WHERE  id = '".$id."'  LIMIT 1");
	$object_array = array();
    while ($row = $result->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }*/
    //return $object_array;
	//return $this->surname."  ".$this->first_name;
   }
   
   
   public static function get_count(){
	global $database;
	$result = $database->query(" SELECT   count(id) as numb FROM ".self::$table_name."   WHERE  active = 1");
	$count = $database->fetch_array($result);
	return $count['numb'];
   }
   
   	
	public static function count_active(){
		global $database;
		$result = $database->query(" SELECT   count(id) as numb FROM ".self::$table_name." WHERE active  = 1");
		$count = $database->fetch_array($result);
		return $count['numb'];
    }
	
	public static function count_inactive(){
		global $database;
		$result = $database->query(" SELECT   count(id) as numb FROM ".self::$table_name." WHERE active  = 0 ");
		$count = $database->fetch_array($result);
		return $count['numb'];
    }
  
  
  public static function find_by_id($id=0) {
	
      return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id=? LIMIT 1", $id);
	  
  }
   
  public static function find_by_sql($sql="", $bid) {
	
      global $database;
    $result_set = $database->query2($sql, $bid);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
public static function find_by_sql2($sql="") {
	
      global $database;
    $result_set = $database->query3($sql);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	protected function unsanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $value;
	  }
	  return $clean_attributes;
	}
	
	
	public function save() {
		// A new record won't have an id yet.
		if(isset($this->id)) {
			// Really just to update the caption
			$this->update();
		} else {
			$this->create();
		}
	}
	
	
	public static function delete($id=0) {
               $result_array = self::find_by_sql("DELETE  FROM ".self::$table_name." WHERE id={$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
        }
  
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	 $sql .= ") VALUES (";
		$sql .= str_repeat('?,', count($attributes) - 1) . '?';
		$sql .= ")";
	  if($database->query4($sql, array_values($attributes), 4)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}
public function createv() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->unsanitized_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->queryv($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	  
	}
	public function mailadmin($email){
	    $to = "udezeleonard@gmail.com";
	    $from = "support@adonaibaibul.com";
           //$to = "Ramona Recipient <recipient@example.com>";
            $subject = "Brute-force Alert";
          // $body = "Hi,\n\nHow are you?";
            
            	    $body = "\nIt appears an intruder is making attempts to bypass authentication by making several log in attempts\n";
            	    $body .= "\nThere is a suspected brute-force or dictionary attack or credential stuffing with the username:  {$email}\n";
            	    $body .= "\nThe fifth failed login attempt took place on ".date(DateTime::RFC1123, gettime());
            	    //$body .= "\nPlease respond on time to save the clients.\n";
            	    
            $host = "mail.adonaibaibul.com";
            $port = "587";
            $username = "leo";
            $password = "oasj";
            
            $headers = array ('From' => $from,
              'To' => $to,
              'Subject' => $subject);
            $smtp = Mail::factory('smtp',
              array ('host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password));
            
            $mail = $smtp->send($to, $headers, $body);
            
            if (PEAR::isError($mail)) {
              echo("<p>" . $mail->getMessage() . "</p>");
             } 
		    
		}
			public function mailotp($email, $userid){
			            
    $temp = md5(time());
    $temp2 = str_split($temp, 5);
    $tempPass= $temp2[0].'#&@'.strtoupper($temp2[1]);
    
   
        $latest = Mailpin::find_last();
                $lid=0;
                foreach($latest as $l){
                    $lid = $l->id;
                }
                $lid++;
                $newpin = new Mailpin();
                $newpin->id = $lid;
                $newpin->email = $email;
                $newpin->pin = $tempPass;
                $newpin->used = 0;
                $newpin->create();
    
	    $to = $email;
	    $from = "support@adonaibaibul.com";
           //$to = "Ramona Recipient <recipient@example.com>";
           //$to = "Ramona Recipient <recipient@example.com>";
            $subject = "Two-factor Authentication OTP";
          // $body = "Hi,\n\nHow are you?";
            
                	    $body .= "\nPlease Enter this 15-digit OTP to complete the authentication\n";
            	    $body .= "\nOTP:  {$tempPass}\n";
            	    $body .= "\nThank you for using this network.\nCourtesy: Leoportals Support Team.";
            	    
            	    
            $host = "mail.adonaibaibul.com";
            $port = "587";
            $username = "leo";
            $password = "";
            
            $headers = array ('From' => $from,
              'To' => $to,
              'Subject' => $subject);
            $smtp = Mail::factory('smtp',
              array ('host' => $host,
                'port' => $port,
                'auth' => true,
                'username' => $username,
                'password' => $password));
            
            $mail = $smtp->send($to, $headers, $body);
            
            if (PEAR::isError($mail)) {
              
                $message =$mail->getMessage();
                       die("<script type=\"text/javascript\">
window.location.href = 'login.php?message=".$message."';
</script>");
             } else
             {
                
              die("<script type=\"text/javascript\">
window.location.href = 'http://www.adonaibaibul.com/twofa.php?a={$userid}';
</script>");
             }
		    
		}
	public function update() {
	  global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  
	  return $database->query9($sql) ? true : false;
	}
	
       
}

?>