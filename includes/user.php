<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class User  {

	protected static $table_name="user";
	protected static $db_fields = array('id', 'username', 'argonpassword','type', 'status', 'online');
	
	public $id;
	public $username;
	public $type;
	public $argonpassword;
	public $status;
	public $online;
	
  
  public static function count_all($unit, $a_session) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name;
          $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}	
	public static function find_last() {
		return self::find_by_sql3("SELECT id FROM ".self::$table_name." ORDER BY id DESC LIMIT 1");
  } 
  public static function find_() {
		return self::find_by_sql3("SELECT * FROM ".self::$table_name." WHERE id>720");
  } 
  //for vulnerable.php
  	public static function find_mail($email) {
		$result_array =  self::find_by_sqlv("SELECT * FROM ".self::$table_name." WHERE username = '{$email}' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  } 
  //for login.php
   public static function find_email($id=""){
      $result_array = self::find_by_sql2("SELECT * FROM ".self::$table_name." WHERE username=? LIMIT 1", $id);  
      return !empty($result_array) ? array_shift($result_array) : false;
  }
  //for login.php
   public static function find_otpid($id=""){
      $result_array = self::find_by_sql4("SELECT * FROM ".self::$table_name." WHERE id=? LIMIT 1", $id);  
      return !empty($result_array) ? array_shift($result_array) : false;
  }
    //new function for password retrieval 
   public static function find_by_mail($id=""){
      return self::find_by_sql2("SELECT * FROM ".self::$table_name." WHERE username=? LIMIT 1", $id);  
  }
    public static function authenticate($username="", $password="") {
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

    //$sql  = "SELECT * FROM  ".self::$table_name."  ";
    //$sql .= "WHERE username = '{$username}' ";
    //$sql .= "AND password = '{$password}' ";
    //$sql .= "AND status = 1 ";
    //$sql .= "LIMIT 1";
	$sql  = "SELECT * FROM  ".self::$table_name."  ";
	$sql .= "WHERE username = ? ";
	$sql .= "AND password = ? ";
	$sql .= "AND status = 1 ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql, $username, $password);
	
       	return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function authenticatev($username="", $password="", $argonpassword="") {
    global $database;

    $pass = password_verify($password, $argonpassword) ? 1:0;
    $sql  = "SELECT * FROM  ".self::$table_name."  ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND ".$pass;
    $sql .= "=1 LIMIT 1";
	
    $result_array = self::find_by_sqlv($sql);
	
       	return !empty($result_array) ? array_shift($result_array) : false;
	}

	// Common Database Methods
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by username");
  }
   
    

 
  //function to change username
  public static function change_username($id=0, $a_level){
      return self::find_by_sql("UPDATE ".self::$table_name." SET username='{$a_level}' WHERE id=".$id."");  
  } 
    
  public static function find_by_id($id=0) {
    return self::find_by_sqlv("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
  }
  
  public static function delete($id=0) {
    $result_array = self::find_by_sql("DELETE  FROM ".self::$table_name." WHERE id={$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
    
  public static function find_by_sql($sql="", $username, $password) {
	
    global $database;
    $result_set = $database->query($sql, $username, $password, 1);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
  public static function find_by_sqlv($sql="") {
	
    global $database;
    $result_set = $database->queryv($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
public static function find_by_sql2($sql="", $username) {
	
    global $database;
    $result_set = $database->query5($sql, $username);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }//
public static function find_by_sql3($sql="") {
	
    global $database;
    $result_set = $database->query3($sql);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
  public static function find_by_sql4($sql="", $id) {
	
    global $database;
    $result_set = $database->query2($sql, $id);
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
	  if($database->query4($sql, array_values($attributes), 3)) {
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
