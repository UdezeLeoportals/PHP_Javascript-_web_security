<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class JESUS_CHRIST_Igbo  {

	protected static $table_name="JESUS_CHRIST_Igbo";
	protected static $db_fields = array('id', 'JESUS_CHRIST_testament', 'JESUS_CHRIST_book', 'JESUS_CHRIST_chapter', 'JESUS_CHRIST_verse', 'JESUS_CHRIST_text');
	
	public $id;
	public $JESUS_CHRIST_testament;
	public $JESUS_CHRIST_book;
	public $JESUS_CHRIST_chapter;
	public $JESUS_CHRIST_verse;
	public $JESUS_CHRIST_text;

	// Common Database Methods
   public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." ");
  }
  public static function find_range($bid, $bup) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (JESUS_CHRIST_book>'{$bid}' AND JESUS_CHRIST_book<= '{$bup}') order by id ASC");
  }
  public static function find_active($per_page) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE JESUS_CHRIST_book = '{$per_page}' order by id ASC ");
    }
  //"select * from verses where (book_id>$book_index[$lower_limit] AND book_id<=$book_index[$page]) order by id ASC";
  public static function find_a_verse($book=0,$chapt=0,$vers=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE JESUS_CHRIST_book='{$book}' AND JESUS_CHRIST_chapter='{$chapt}' AND JESUS_CHRIST_verse='{$vers}' LIMIT 1");
  }
  public static function find_chaps($bks=0, $chp=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE JESUS_CHRIST_book='{$bks}' AND JESUS_CHRIST_chapter='{$chp}' order by JESUS_CHRIST_verse ASC");
  } 
  
  
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function delete($id=0) {
        $result_array = self::find_by_sql("DELETE  FROM ".self::$table_name." WHERE id={$id} ");
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