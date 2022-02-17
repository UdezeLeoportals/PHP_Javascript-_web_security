<?php

require_once(LIB_PATH.DS.'database.php');
class Prescribed_course {

	protected static $table_name="prescribed_course";
	protected static $db_fields = array('id', 'course_id','semester_id', 'unit', 'level', 'type', 'course_code');

	public $id;
	public $course_id;
	public $semester_id;
	public $unit;
	public $level;
	public $type;
	public $course_code;

      public static function count_all($unit, $a_session) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE unit='{$unit}' AND session='{$a_session}' ";
          $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}	
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by id");
  }
  public static function find_distinct_all() {
		return self::find_by_sql("SELECT DISTINCT course_code FROM ".self::$table_name." order by id");
  }
   public static function find_by_clas($sem2=0, $semester=0, $unit="", $level=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE(  level={$level} AND (semester_id={$semester} OR semester_id={$sem2}) AND unit=\"{$unit}\" )");
  }
     public static function find_by_seme($type=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE semester_id={$type}");
  }
    public static function find_by_dept($type=0) {
		return self::find_by_sql("SELECT DISTINCT course_code FROM ".self::$table_name." WHERE unit IN (SELECT unit from departments WHERE dept = '{$type}' ) order by course_code");
  }
   public static function gss_find_all($unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type=\"GSS\" AND unit=\"{$unit}\" AND level=100");
  }
    public static function find_GSS($type="", $unit="", $semester="", $level="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type=\"{$type}\" AND unit=\"{$unit}\" AND semester=\"{$semester}\" AND level=\"{$level}\"");
  }
    public static function find_by_code($code=0, $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id={$code} AND unit=\"{$unit}\" LIMIT 1");
  }
  public static function find_distinct($sem1=0, $sem2=0) {
		return self::find_by_sql("SELECT DISTINCT course_id FROM ".self::$table_name." WHERE semester_id={$sem1} OR semester_id={$sem2}");
  }
   public static function find_details($code="", $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE code=\"{$code}\" AND unit=\"{$unit}\" LIMIT 1");
  }
   public static function find($code=0, $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id={$code} AND unit=\"{$unit}\" LIMIT 1");
  }
    
  public static function find__($code=0, $unit="", $sem) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id={$code} AND unit=\"{$unit}\" AND semester_id={$sem} LIMIT 1");
  }
public static function find_lev($level=0, $unit="", $code=0,$sem=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE level={$level} AND unit='{$unit}' AND course_id={$code} AND semester_id={$sem} LIMIT 1");
  }
  	 public static function find_by_course($code="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE code=\"{$code}\"");
  }
  public static function update_session($new_session, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET session= '".$new_session."' where id = ".$id);
    }
  public static function update_code($new_session, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET course_code= '".$new_session."' where id = ".$id);
    }

  public static function find_active() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status = 1  ");
    }
      public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function find_by_class( $sem_id=0, $sem_id2=0, $unit="", $level=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE(  level={$level} AND unit=\"{$unit}\" AND (semester_id=$sem_id OR semester_id=$sem_id2))");
  }
  public static function find_class($semester_id=0, $unit="", $level=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE( level={$level} AND semester_id={$semester_id} AND unit=\"{$unit}\" ) order by course_code");
  }
  public static function find_electives( $semester_id=0, $unit="", $level=0, $type="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE(  level={$level} AND semester_id={$semester} AND unit=\"{$unit}\" AND type=\"{$type}\" )");
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
