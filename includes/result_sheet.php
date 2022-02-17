<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');
class Result_sheet  {

	protected static $table_name="result_sheet";
	protected static $db_fields = array('id', 'student_id', 'course_id', 'semester_id', 'assessment', 'exam_score', 'status');
	
	public $id;
	public $student_id;
	public $course_id;
	public $semester_id;
	public $assessment;
	public $exam_score;
	public $status;



	// Common Database Methods
	 public static function count_all($c, $s, $t) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE ((semester_id={$s} OR semester_id={$t}) AND course_id={$c})";
          $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by matric_no");
  }
  public static function find_by_code($course_id=0, $semester_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND semester_id= {$semester_id} ");
    }
     public static function find_codept($course_id=0, $semester_id=0, $dept) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND semester_id= {$semester_id} AND student_id IN ( SELECT id FROM student WHERE unit IN (SELECT unit FROM departments WHERE dept='{$dept}'))");
    }
    
    public static function find____($course_id=0, $semester_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND semester_id= {$semester_id} AND NOT status=1");
    }
    public static function find_distinct($sem1=0, $sem2=0) {
		return self::find_by_sql("SELECT DISTINCT course_id FROM ".self::$table_name." WHERE semester_id={$sem1} OR semester_id={$sem2}");
  }
   public static function find_register($sem1=0) {
		return self::find_by_sql("SELECT DISTINCT student_id FROM ".self::$table_name." WHERE semester_id={$sem1}");
  }
   public static function find_prodistinct($sem1=0, $sem2=0, $unit='', $entry='', $entry2='') {
		return self::find_by_sql("SELECT DISTINCT course_id FROM ".self::$table_name." WHERE (semester_id={$sem1} OR semester_id={$sem2}) AND student_id IN (SELECT id FROM student WHERE unit='{$unit}' AND ((session_of_entry='{$entry}' AND mode_of_entry='UME') OR (session_of_entry='{$entry2}' AND mode_of_entry='direct entry')))");
  }
    public static function find_record($student_id=0, $course_id=0, $semester_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND semester_id= {$semester_id} AND student_id={$student_id}");
    }
    public static function find_summer_record($student_id=0, $course_id=0, $semester_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND semester_id= {$semester_id} AND student_id={$student_id} ");
    }
    public static function find_nums($student_id=0, $course_id=0, $not=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND student_id={$student_id} AND semester_id<{$not}");
    }
     public static function find_nums2($student_id=0, $course_id=0, $not=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND student_id={$student_id} AND semester_id<={$not}");
    }
 public static function find_num($student_id=0, $course_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE course_id = {$course_id} AND student_id={$student_id}");
    }
    public static function find_car($student_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$student_id}");
    }
    public static function find_reps($student_id=0, $semester_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE semester_id = {$semester_id} AND student_id={$student_id}");
    }
   public static function find_by_course($sem1=0, $sem2=0) {
    return self::find_by_sql("SELECT DISTINCT course_id FROM ".self::$table_name." WHERE (semester_id={$sem2} OR semester_id={$sem1})  ");  
  }
  
	public static function find_active($std=0, $sem=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id = {$std} AND semester_id={$sem} ");
    }
	
	public static function find_inactive($per_page=10, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE active = 0   ORDER BY surname, first_name, username, a_level   LIMIT  ".$per_page. " OFFSET ".$offset." ");
    }
	
   public static function change_status($id, $new_status){
	global $database;
	$new_status = $database->escape_value($new_status);
      	self::find_by_sql( " UPDATE ".self::$table_name." SET type = '".$new_status."' where id = ".$id);
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
	public static function delete($id){
		$result_array=self::find_by_sql("DELETE FROM ".self::$table_name." WHERE id = {$id} ");
		return !empty($result_array) ? array_shift($result_array) : false;
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
	public static function find_by_sem($sem1=0, $sem2=0, $stud) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE(( semester_id = {$sem1} OR semester_id={$sem2}) AND student_id={$stud} )");
    }
    public static function find_summer($sem1=0, $sem2=0, $stud) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE(( semester_id = {$sem1} OR semester_id={$sem2}) AND student_id={$stud} AND status=3)");
    }
   public static function change_password($id, $new_password){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET password = '".$new_password."' where id = ".$id);
   }
   
	public static function change_role($id, $a=0, $e=0, $s){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET assessment = ".$a.", exam_score = ".$e.", status = ".$s." where id = ".$id);
    }
   	public static function change_state($id, $s=0){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET status=".$s." where id = ".$id);
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
    return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
	
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
