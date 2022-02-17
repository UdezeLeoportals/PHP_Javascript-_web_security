<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Verses  {

	protected static $table_name="verses";
	protected static $db_fields = array('id', 'book_id', 'chapter', 'verse', 'text');
	
	public $id;
	public $book_id;
	public $chapter;
	public $verse;
	public $text;

	// Common Database Methods
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by staff_no");
  }
  public static function find_range($bid, $bup) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (book_id>? AND book_id<=?) order by id ASC", $bid, $bup);
  }
  public static function find_active($per_page) {
		return self::find_by_sql2("SELECT * FROM ".self::$table_name." WHERE book_id = ? order by id ASC ", $per_page);
    }
  //"select * from verses where (book_id>$book_index[$lower_limit] AND book_id<=$book_index[$page]) order by id ASC";
  public static function find_a_verse($book=0,$chapt=0,$vers=0) {
		return self::find_by_sql3("SELECT * FROM ".self::$table_name." WHERE book_id=? AND chapter=? AND verse=? LIMIT 1", $book, $chapt, $vers);
  }
  public static function find_chaps($bks=0, $chp=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE book_id=? AND chapter=? order by verse ASC", $bks, $chp);
  } 
   public static function find_current( $session="", $semester="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE a_session=\"{$session}\" AND semester=\"{$semester}\" order by course_code");
  }
  public static function find_by_code( $semester_id=0, $course_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE semester_id={$semester_id} AND course_id={$course_id} AND status=\"CO-ORDINATOR\" LIMIT 1");
  }
   public static function find($course_id=0, $semester=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id={$course_id}  AND semester_id={$semester} AND status=\"ASSISTANT\"");
  }
  public static function find_approval($course="", $session="", $semester="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_code=\"{$course}\" AND a_session=\"{$session}\" AND semester=\"{$semester}\" ");
  } 
  
    
	
	public static function find_inactive($per_page=10, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE active = 0   ORDER BY surname, first_name, username, a_level   LIMIT  ".$per_page. " OFFSET ".$offset." ");
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
	
   public static function change_password($id, $new_password){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET password = '".$new_password."' where id = ".$id);
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
   
   public static function get_fullname($id){
	global $database;
	$result = $database->query(" SELECT   surname, first_name FROM ".self::$table_name."   WHERE  id = '".$id."'  LIMIT 1");
	$user = $database->fetch_array($result);
	return $user['surname']."  ".$user['first_name'];
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
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function delete($id=0) {
        $result_array = self::find_by_sql("DELETE  FROM ".self::$table_name." WHERE id={$id} ");
	return !empty($result_array) ? array_shift($result_array) : false;
  }  
    
  public static function find_by_sql($sql="", $bid, $bup) {
	
    global $database;
    $result_set = $database->query($sql, $bid, $bup, 2);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
public static function find_by_sql2($sql="", $bid) {
	
    global $database;
    $result_set = $database->query2($sql, $bid);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
public static function find_by_sql3($sql="", $bid, $bup, $three) {
	
    global $database;
    $result_set = $database->query6($sql, $bid, $bup, $three);
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
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
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
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
       
}

?>