
<?php

require_once(LIB_PATH.DS.'database.php');
class Student_status {

	protected static $table_name="student_status";
	protected static $db_fields = array('id', 'student_id', 'session_id', 'unit', 'level', 'status','case_status', 'no_of_years', 'previous_session', 'cgpa');

	public $id;
	public $student_id;
	public $session_id;
	public $unit;
	public $level;
	public $status;
	public $case_status;
	public $previous_session;
	public $no_of_years;
	public $cgpa;
	
	public static function count_all($entry, $a_session, $level, $unit) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE  unit='{$unit}' AND session_id={$a_session} AND level='{$level}' AND NOT (student_id IN (SELECT id FROM student WHERE mode_of_entry='direct entry' AND session_of_entry='{$entry}' ))";
	  $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}
	public static function count($a_session, $level, $unit) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE  unit='{$unit}' AND session_id={$a_session} AND level='{$level}' AND status='probation'";
	  $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}
	public static function count_DE($entry, $a_session, $level, $unit) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE  unit='{$unit}' AND session_id={$a_session} AND level='{$level}' AND student_id IN(SELECT id FROM student WHERE mode_of_entry='direct entry' AND session_of_entry='{$entry}')";
	  $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by session");
  }
public static function find_grad($sess) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE session_id={$sess} AND status=\"graduated\" order by cgpa");
  }
  public static function find_per_class($entry, $a_session, $level, $unit, $per_page, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE  unit='{$unit}' AND session_id={$a_session} AND level={$level} AND NOT (student_id IN (SELECT id FROM student WHERE mode_of_entry='direct entry' AND session_of_entry='{$entry}')) LIMIT {$per_page} OFFSET {$offset}");
  }
  public static function find_DE($entry, $a_session, $level, $unit, $per_page, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE  unit='{$unit}' AND session_id={$a_session} AND level={$level} AND student_id IN (SELECT id FROM student WHERE mode_of_entry='direct entry' AND session_of_entry='{$entry}') LIMIT {$per_page} OFFSET {$offset}");
  }
  public static function find_probers($a_session, $level, $unit, $per_page, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE  unit='{$unit}' AND session_id={$a_session} AND no_of_years={$level} AND status='probation' LIMIT {$per_page} OFFSET {$offset}");
  }
     public static function find_by_type($type="", $unit="", $semester="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE type=\"{$type}\" AND unit=\"{$unit}\" AND semester=\"{$semester}\" AND state=\"{undergraduate}\"");
  }
  
     public static function find_by_matric_no($matric_no="",  $session="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE matric_no=\"{$matric_no}\" AND session=\"{$session}\" LIMIT 1 ");
  }
  public static function find_by_std_id($stdd_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$stdd_id} ");
  }
  public static function find_by_stdnt($std_id=0, $sess) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$std_id} AND session_id={$sess}");
  }
   public static function find_by_year1($std_id=0, $year=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$std_id} AND no_of_years={$year}");
  }
  public static function find_class($std_id=0, $sess,$unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE level={$std_id} AND session_id={$sess} AND unit='{$unit}'");
  }
  public static function find_sess($session=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE session_id={$session}  ");
  }
   public static function find_viable($session=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE session_id={$session}  AND NOT (status='withdrawn' OR status='graduated' OR case_status='EX' OR case_status='TR') ");
  }
  public static function find_by_status($status="",  $session="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=\"{$status}\" AND session=\"{$session}\" ");
  }
  public static function find_by_year($st=0,  $year=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$st} AND no_of_years={$year} ");
  }
   public static function find_by_level($st=0,  $year=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$st} AND level={$year} LIMIT 1");
  }
 public static function update_status($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET status = '".$new_level."' where id = ".$id);
    }
     public static function update_gp($cgp, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET cgpa = '".$cgp."' where id = ".$id);
    }
    public static function update_reg($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET no_of_years = ".$new_level." where id = ".$id);
    }
    public static function update_case($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET case_status = '".$new_level."' where id = ".$id);
    }
    public static function update_prev($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET previous_session = '".$new_level."' where id = ".$id);
    }
	public static function update_state($new_level, $id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET level = ".$new_level." where id = ".$id);
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
