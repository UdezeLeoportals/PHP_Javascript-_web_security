<?php
require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."functions.php");
class MySQLDatabase extends Session {
	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;
  function __construct() {
    $this->open_connection();
		//$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysqli_real_escape_string" );
  }
	public function open_connection() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if (!$this->connection) {
			die("Database connection failed: " . mysql_error());
		} else {
			$db_select = mysqli_select_db($this->connection, DB_NAME);
			$_SESSION['DB']= $db_select;
			if (!$db_select) {
				die("Database selection failed: " . mysqli_error($this->connection));
			}
			mysqli_set_charset($this->connection, "utf8mb4"); //Function to enable ut8 characters like the Igbo alphabet
		}
	}
	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}
	public function query($sql, $username, $password, $type) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		//$result = mysqli_query($this->connection, $sql, MYSQLI_STORE_RESULT);
		$stmt = $this->connection->prepare($sql);
		if($type==1) $stmt->bind_param('ss', $username, $password);
		else if($type==2) $stmt->bind_param('ii', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
		$this->confirm_query($result, $for, $source);
		return $result;
	}
	public function queryv($sql) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		$result = mysqli_query($this->connection, $sql, MYSQLI_STORE_RESULT);
		$this->confirm_query($result, $for, $source);
		return $result;
	}
	public function query2($sql, $username) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		//$result = mysqli_query($this->connection, $sql, MYSQLI_STORE_RESULT);
		$stmt = $this->connection->prepare($sql);
		$stmt->bind_param('i', $username);
        $stmt->execute();
        $result = $stmt->get_result();
		$this->confirm_query($result, $for, $source);
		return $result;
	}
	
	public function query3($sql) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		//$result = mysqli_query($this->connection, $sql, MYSQLI_STORE_RESULT);
		$stmt = $this->connection->prepare($sql);
		//$stmt->bind_param('i', $username);
        $stmt->execute();
        $result = $stmt->get_result();
		$this->confirm_query($result, $for, $source);
		return $result;
	}
	public function query4($sql, $attributes, $type) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		$stmt = $this->connection->prepare($sql);
		if($type==1) //comments
		$stmt->bind_param('iisisssssssiss', $attributes[0], $attributes[1], $attributes[2], $attributes[3], $attributes[4], $attributes[5], $attributes[6], $attributes[7], $attributes[8], $attributes[9], $attributes[10], $attributes[11], $attributes[12], $attributes[13]);
		if($type==2) //jobs
		{$stmt->bind_param('iisssssssss', $attributes[0], $attributes[1], $attributes[2], $attributes[3], $attributes[4], $attributes[5], $attributes[6], $attributes[7], $attributes[8], $attributes[9], $attributes[10]);		}
		if($type==3) //user
		$stmt->bind_param('isssii', $attributes[0], $attributes[1], $attributes[2], $attributes[3], $attributes[4], $attributes[5]);
		if($type==4) //comments
		$stmt->bind_param('iissisissssss', $attributes[0], $attributes[1], $attributes[2], $attributes[3], $attributes[4], $attributes[5], $attributes[6], $attributes[7], $attributes[8], $attributes[9], $attributes[10], $attributes[11], $attributes[12]);
		if($type==5) //verifymail
		$stmt->bind_param('iiii', $attributes[0], $attributes[1], $attributes[2], $attributes[3]);
		if($type==6) //news, scholars, campus
		$stmt->bind_param('iissssss', $attributes[0], $attributes[1], $attributes[2], $attributes[3], $attributes[4], $attributes[5], $attributes[6], $attributes[7]);
		if($type==7) //Mailpin
		$stmt->bind_param('issi', $attributes[0], $attributes[1], $attributes[2], $attributes[3]);
		if($type==8) //credit card
		$stmt->bind_param('issssss', $attributes[0], $attributes[1], $attributes[2], $attributes[3], $attributes[4], $attributes[5], $attributes[6]);
        if($stmt->execute()) return true;
		$this->confirm_query($result, $for, $source);
	}
	public function query5($sql, $username) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		//$result = mysqli_query($this->connection, $sql, MYSQLI_STORE_RESULT);
		$stmt = $this->connection->prepare($sql);
		$stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
		$this->confirm_query($result, $for, $source);
		return $result;
	}
	public function query6($sql, $username, $two, $three) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		//$result = mysqli_query($this->connection, $sql, MYSQLI_STORE_RESULT);
		$stmt = $this->connection->prepare($sql);
		$stmt->bind_param('iii', $username, $two, $three);
        $stmt->execute();
        $result = $stmt->get_result();
		$this->confirm_query($result, $for, $source);
		return $result;
	}
	public function query7($sql, $username, $two, $type) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		$stmt = $this->connection->prepare($sql);
		if($type==1) $stmt->bind_param('si', $username, $two);
        if($stmt->execute()) return true;
		$this->confirm_query($result, $for, $source);
	}
	public function query8($sql, $username, $type) {
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		$stmt = $this->connection->prepare($sql);
		if($type==1) $stmt->bind_param('i', $username);
        if($stmt->execute()) return true;
		$this->confirm_query($result, $for, $source);
	}
	public function query9($sql){
	    $for=""; $page="";
		$source = ($page == "") ? "./error.php" : $page;
		$this->last_query = $sql;
		$stmt = $this->connection->prepare($sql);
		//if($type==1) $stmt->bind_param('i', $username);
        if($stmt->execute()) return true;
		$this->confirm_query($result, $for, $source);
	}
	public function escape_value($value) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string($this->connection, $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	// "database-neutral" methods
  public function fetch_array($result_set) {
    return mysqli_fetch_array($result_set, MYSQLI_BOTH);
  }
  public function num_rows($result_set) {
   return mysqli_num_rows($result_set);
  }
  public function insert_id() {
    // get the last id inserted over the current db connection
    return mysqli_insert_id($this->connection);
  }
  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }
  private function confirm_query($result, $for="", $source="") {
	if (!$result) {
	$output = "Database query failed: " . mysqli_error($this->connection) ;
	$output .= "Last SQL query: " . $this->last_query;
	$this->message($output, "errorText");
	//redirect_to($source);
	//header("Location: {$source}");
    exit;
	}
  }
  public function trace_error($error_no, $for, $source){
	
  }
}
$database = new MySQLDatabase();
$db =& $database;
?>