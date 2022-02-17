<?php
require_once(LIB_PATH.DS.'database.php');


class Scholars  {

	protected static $table_name="scholars";
	protected static $db_fields = array('id', 'bio_id', 'topic', 'details', 'filename',  'linker', 'datetime', 'status');
	
	public $id;
	public $bio_id;
	public $topic;
        public $details;
	public $filename;
	public $linker;
	public $datetime;
	public $status;
        protected $upload_dir="images/news";
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
          public static function find_last() {
		return self::find_by_sql("SELECT id FROM ".self::$table_name." ORDER BY id DESC LIMIT 1");
  } 
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
                    
                    $target_path = SITE_ROOT.DS.$this->upload_dir.DS.$this->filename;
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
		return self::find_by_sql("SELECT * FROM ".self::$table_name." order by staff_no");
  }
  public static function change_filename($id, $new_password){
      	self::find_by_sql( " UPDATE ".self::$table_name." SET filename = '".$new_password."' where id = ".$id);
   }
   public static function change_status($id, $new_password){
      return	self::find_by_sql2( " UPDATE ".self::$table_name." SET status = ? where id =? ", $new_password, $id);
   }
  public static function find_pending($who) {
		return self::find_by_sql3("SELECT * FROM ".self::$table_name." WHERE bio_id=? AND status='pending' order by datetime", $who);
  }
  public static function find_posted($who) {
		return self::find_by_sql3("SELECT * FROM ".self::$table_name." WHERE bio_id=? AND status='posted' order by datetime", $who);
  }
   public static function find_public() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status='posted' order by datetime");
  }
   public static function find_by_id($id=0) {
    $result_array = self::find_by_sql3("SELECT * FROM ".self::$table_name." WHERE id=?  LIMIT 1", $id);
    return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public function destroy($idz, $fil)
  {
	$target_path = SITE_ROOT.DS."images/news".DS.$fil;
	if($fil=="null") return (Scholars::delete($idz)) ? true: false;
	elseif(unlink($target_path))
	{
		return (Scholars::delete($idz)) ? true: false;
	}
	else { return false;}
	 
  }
  public static function find_by_student_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE student_id={$id} LIMIT 1 ");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function find_by_chat_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE chat_id={$id} LIMIT 1 ");
    return !empty($result_array) ? array_shift($result_array) : false;
  }
 public static function delete($id=0) {
        return self::find_by_sql4("DELETE  FROM ".self::$table_name." WHERE id=? ", $id);
	//return !empty($result_array) ? array_shift($result_array) : false;
  }  
    
  public static function find_by_sql($sql="") {
	
      global $database;
    $result_set = $database->query3($sql);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
 
public static function find_by_sql2($sql="", $two, $three) {
	
      global $database;
    $result_set = $database->query7($sql, $two, $three, 1);
    
    return $result_set;
  }
  public static function find_by_sql3($sql="", $one) {
	
      global $database;
    $result_set = $database->query2($sql, $one);
    $object_array = array();
    while ($row = $result_set->fetch_assoc()) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
  public static function find_by_sql4($sql="", $one) {
	
      global $database;
    $result_set = $database->query8($sql, $one, 1);
    
    return $true;
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
		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES (";
		$sql .= str_repeat('?,', count($attributes) - 1) . '?';
		$sql .= ")";
	  if($database->query4($sql, array_values($attributes), 6)) {
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