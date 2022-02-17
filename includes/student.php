<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');
class Student  {

	protected static $table_name="student";
	protected static $db_fields = array('id', 'user_id', 'matric_no', 'pume_reg', 'surname', 'first_name', 'middle_name',
										'mode_of_entry', 'unit', 'level', 'address', 'date_of_birth', 'sex', 'state_of_origin',
										'lga', 'session_of_entry', 'year_of_graduation', 'phone_no', 'e_mail', 'religion', 'faculty',
										'perm_address', 'home_town', 'marital_status', 'sponsor', 'academic_adviser',
										'withdrawal_status', 'previous_matric_no', 'withdrawal reasons', 'last_college', 'date_of_leaving',
										'reason_for_leaving', 'extra_curricula', 'next_of_kin', 'address_of_next_of_kin');
	
	public $id;
	public $user_id;
	public $matric_no;
	public $pume_reg;
	public $surname;
	public $first_name;
	public $middle_name;
	public $mode_of_entry;
	public $unit;
	public $level;
	public $address;
	public $date_of_birth;
	public $state_of_origin;
	public $sex;
	public $lga;
	public $session_of_entry;
	public $year_of_graduation;
	public $phone_no;
	public $e_mail;
	public $religion;
	public $faculty;
	public $perm_address;
	public $home_town;
	public $marital_status;
	public $sponsor;
	public $academic_adviser;
	public $withdrawal_status;
	public $previous_matric_no;
	public $withdrawal_reasons;
	public $last_college;
	public $date_of_leaving;
	public $reason_for_leaving;
	public $extra_curricula;
	public $next_of_kin;
	public $address_of_next_of_kin;	

	
 public static function count_all($unit, $level, $SOE, $SOE2) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM student ";
	$sql .= "WHERE unit = '{$unit}' ";
	$sql .= "AND level = '{$level}' ";
	$sql .= "AND ((session_of_entry = '{$SOE}' AND mode_of_entry='UME') OR (session_of_entry='{$SOE2}' AND mode_of_entry='direct entry')) ";
	$result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}
	public static function counter($field, $value) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE ".$field."='{$value}' ";
          $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	} 
	public static function count($session, $a_session, $unit) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name." WHERE ( unit='{$unit}' AND ((session_of_entry='{$session}' AND mode_of_entry='UME') OR (session_of_entry='{$a_session}' AND mode_of_entry='direct entry')) ) order by matric_no ";        $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
          return array_shift($row);
	}
	// Common Database Methods
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by level, unit, matric_no");
  }
  public static function find_by_entry($session, $a_session, $unit, $per_page, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE ( unit='{$unit}' AND ((session_of_entry='{$session}' AND mode_of_entry='UME') OR (session_of_entry='{$a_session}' AND mode_of_entry='direct entry')) ) order by matric_no LIMIT {$per_page} OFFSET {$offset}");
  }
  public static function update_years($new_level, $user_id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET no_of_years = '".$new_level."' where user_id = ".$user_id);
    }
public static function update_message($new_level, $user_id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET message = '".$new_level."' where id = ".$user_id);
    }

   public static function update_level($new_level, $user_id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET level = '".$new_level."' where user_id = ".$user_id);
    }
    public static function update_unit($new_level, $user_id){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET unit = '".$new_level."' where user_id = ".$user_id);
    }
   public static function update_years_spent($no_of_years, $actual_years, $matric_no){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET no_of_years = ".$no_of_years.", actual_years_spent = ".$actual_years." where matric_no = \"".$matric_no."\"");
    }
   public static function find_by_user_id($user_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE user_id={$user_id}");
  }
  
  public static function find_by_matric($matric_no="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE matric_no=\"{$matric_no}\" LIMIT 1");
		//$Query = Database::Prepare("SELECT * FROM ".self::$table_name." WHERE matric_no= ? "); 
		//return $Query->Execute(array($matric_no));
  }
  public static function find_student($matric_no="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE matric_no=\"{$matric_no}\"");
  }
  public static function find_by_class($unit="", $level="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE unit=\"{$unit}\" AND level=\"{$level}\"");
  }
  public static function find_by_session($session="", $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE session_of_entry=\"{$session}\" AND unit=\"{$unit}\" AND mode_of_entry=\"UME\" ");
  }
  public static function find_direct_entry($session="", $unit="") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE session_of_entry=\"{$session}\" AND mode_of_entry=\"direct entry\" AND unit=\"{$unit}\"");
  }
  
    public static function find_active($per_page=10, $offset) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE active = 1  ORDER BY surname, first_name, username, a_level   LIMIT  ".$per_page. " OFFSET ".$offset." ");
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
	$result = $database->query(" SELECT   surname, first_name, middle_name FROM ".self::$table_name."   WHERE  id = '".$id."'  LIMIT 1");
	$user = $database->fetch_array($result);
	return $user['surname']."  ".$user['first_name']."  ".$user['middle_name'];
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