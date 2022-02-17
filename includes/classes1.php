<?php

require_once(LIB_PATH.DS.'database.php');
class Classe {

	protected static $table_name="classe";
	protected static $db_fields = array('id', 'adviser_id', 'session_of_entry', 'unit', 'max_credit', 'level', 'min_credit','semester_id', 'session_max', 'session_min');

	public $id;
	public $adviser_id;
	public $session_of_entry;
	public $unit;
	public $max_credit;
	public $level;
	public $min_credit;
	public $semester_id;
	public $session_max;
	public $session_min;
	
	public static function count_all($field) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE unit = '".$field."' ";
          $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	} 
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by session_of_entry");
  }
     public static function find_by_type($type="", $unit="", $semester="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type=\"{$type}\" AND unit=\"{$unit}\" AND semester=\"{$semester}\" AND state=\"{under_graduate}\"");
  }
  public static function find_by_dept($dept="", $pp, $off) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE unit IN (SELECT unit FROM departments WHERE dept='{$dept}') order by semester_id, level, session_of_entry LIMIT {$pp} OFFSET {$off} ");
  }
 
 public static function update_level($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET level = ".$new_level." where id = ".$id);
    }
	public static function update_state($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET state = '".$new_level."' where id = ".$id);
    }
   
 public static function find_by_adviser( $adviser=0, $sem=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE adviser_id={$adviser} AND semester_id={$sem} LIMIT 1");
  }
  public static function find_credit($level=0, $sem=0, $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE level={$level} AND semester_id={$sem}  AND unit='{$unit}' LIMIT 1");
  }

   public static function find_cur($sem=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE  semester_id={$sem} LIMIT 1");
  }
  public static function find_active() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status = 1  ");
    }
      public static function find_by_id($id=0) {
    return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		
  }
  
  public static function find_electives($session="", $semester="", $unit="", $level=0, $type="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE(  level={$level} AND session=\"{$session}\" AND semester=\"{$semester}\" AND unit=\"{$unit}\" AND type=\"{$type}\" )");
  }
  public static function delete($id){
		$result_array=self::find_by_sql("DELETE FROM ".self::$table_name." WHERE id = {$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function find_by_sql($sql="") {
	
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
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
