<?php
require_once(LIB_PATH.DS.'database.php');


class Staff_list  {

	protected static $table_name="staff_list";
	protected static $db_fields = array('id','filename', 'type','size');
	
	public $id;
	public $filename;
	public $type;
    public $size;
        private $temp_path;
        protected $upload_dir="staff_lists";
        public $errors= array();
        
        private $upload_errors = array(
                "No errors.",
               "Larger than upload_max_filesize.",
                "Larger than form MAX_FILE_SIZE.",
                "Partial upload.",
                "No file.",
                    "",
                 "No temporary directory.",
                 "Can't write to disk.",
                "File upload stopped by extension."
       );
        
        public function attach_file($file){
            if(!$file|| empty($file) || !is_array($file)){
               $this->errors[]="No file was uploaded";
               return false;
            }
            elseif($file['error'] != 0)
            {
                $this->errors[]= $this->upload_errors[$file['error']];
                return false;
            }
            else{
                $this->temp_path=$file['tmp_name'];
                $this->filename=basename($file['name']);
                $this->type=$file['type'];
                $this->size=$file['size'];
                return true;
            }
        }
        
        public function image_path(){
            return $this->upload_dir.DS.$this->filename;
        }
        public function save() {
		
		// A new record won't have an id yet.
		if(isset($this->id)) {
			// Really just to update the caption
			$this->update();
		} else {
                    
                    if(!empty($this->errors)){return false;}
                    
                    if(empty($this->filename) || empty($this->temp_path)){
                       $this->errors[]= "The file location was not available";
                       return false;
                    }
                    
                    $target_path = SITE_ROOT.DS."files".DS.$this->upload_dir.DS.$this->filename;
                    if(file_exists($target_path)){
                        $this->errors[]= "The file {$this->filename} already exists";
                        return false;
                    }
                     
                     if(move_uploaded_file($this->temp_path, $target_path)){
                        
                        if($this->create()){
                            unset($this->temp_path);
                            return true;
                        }
                        else{
                             $this->errors[]= " The file upload failed, possibly due to incorrect permissions on the upload folder";
                            return false;                        
                        }
                     }
		}
	}
        
    public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by id");
  }
   public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id}  LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public function destroy()
  {
	$target_path = SITE_ROOT.DS."files".DS.$this->upload_dir.DS.$this->filename;
	if(unlink($target_path))
	{
		return ($this->delete($this->id)) ? true: false;
	}
	else { return false;}
  }
  public static function find_by_student_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$id}  ");
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