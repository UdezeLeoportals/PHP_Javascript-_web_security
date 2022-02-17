<?php

require_once(LIB_PATH.DS.'database.php');
class Admission_lists {

	protected static $table_name="admission_list";
	protected static $db_fields = array('id', 'a_session', 'surname', 'first_name', 'middle_name','state', 'lga', 'pume_reg', 'age', 'unit', 'utme_score', 'post_ume_score', 'status' );

	public $id;
	public $a_session;
	public $surname;
	public $first_name;
	public $middle_name;
	public $state;
	public $lga;    
	public $pume_reg;
	public $age;
        public $unit;
        public $utme_score;
        public $post_ume_score;
        public $status;
	
	public static function count_all($a_session, $level, $unit) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE  unit='{$unit}' AND session='{$a_session}' AND level='{$level}'";
	  $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}
	
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by session");
  }
  
   public static function find_reg_no($reg_no="", $session) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE pume_reg='{$reg_no}' AND a_session='{$session}' ");
  }
  public static function find_per_class($a_session, $level, $unit, $per_page, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE  unit='{$unit}' AND session='{$a_session}' AND level='{$level}' order by matric_no LIMIT {$per_page} OFFSET {$offset}");
  }
     public static function find_by_type($type="", $unit="", $semester="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type=\"{$type}\" AND unit=\"{$unit}\" AND semester=\"{$semester}\" AND state=\"{undergraduate}\"");
  }
  
     public static function find_by_matric_no($matric_no="",  $session="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE matric_no=\"{$matric_no}\" AND session=\"{$session}\" LIMIT 1 ");
  }
  public static function find_matric_no($matric_no="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE matric_no=\"{$matric_no}\"  ");
  }
  public static function find_by_status($status="",  $session="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=\"{$status}\" AND session=\"{$session}\" ");
  }
 public static function update_status($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET status = '".$new_level."' where id = ".$id);
    }
    
    public static function update_case($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET case_status = '".$new_level."' where id = ".$id);
    }
    public static function update_prev($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET previous_session = '".$new_level."' where id = ".$id);
    }
	public static function update_state($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET state = '".$new_level."' where id = ".$id);
    }
   public static function find_by_class( $unit="", $level="", $session="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE unit=\"{$unit}\" AND level=\"{$level}\" AND SESSION=\"{$session}\" ");
  }
 public static function find_by_adviser( $adviser="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE adviser_id=\"{$adviser}\"  LIMIT 1");
  }
    public static function find_by_code($code="", $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE code=\"{$code}\" AND unit=\"{$unit}\" LIMIT 1");
  }
	 public static function find_course($code="", $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE code=\"{$code}\"  LIMIT 1");
  }
  public static function find_active() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status = 1  ");
    }
      public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
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