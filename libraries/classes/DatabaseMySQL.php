<?php
class Database {
    private $_result = NULL;
    private $_link = NULL;
    private $_config = array();
    private static $_instance = NULL; 
 
    // Return singleton instance of MySQL class
    public static function getInstance(array $config = array()) {
       
        if (self::$_instance === NULL) {
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }
 
    // Private constructor
    private function __construct(array $config) {
        if (count($config) < 4) {
            throw new Exception('Invalid number of connection parameters');  
        }
        $this->_config = $config;
        //PARA QUE SE GUARDEN LOS ACENTOS
        $this->query("SET NAMES 'utf8'");
    }
 
    // Prevent cloning class instance
    private function __clone() {}
 
    // Connect to MySQL
    private function connect() {
        // Connect only once
     
        static $connected = FALSE;
        if ($connected === FALSE) {
			list($host, $user, $password, $database) = $this->_config;
           
            if ((!$this->_link = mysqli_connect($host, $user, $password, $database))) {
                //throw new Exception('Error connecting to MySQL : ' . mysqli_connect_error());
                echo 'Error connecting to MySQL : ' . mysqli_connect_error();
            }
            
            
            $connected = TRUE;
            unset($host, $user, $password, $database);      
        }
    } 
 
    // Perform query
    public function query($query) {
        if (is_string($query) and !empty($query)) {
            $this->connect();
            if ((!$this->_result = mysqli_query($this->_link, $query))) {
                throw new Exception('Error performing query ' . $query . ' Message : ' . mysqli_error($this->_link));
            }
        }
    }
 
    // Fetch row from result set
    public function fetch() {
        if ((!$row = mysqli_fetch_object($this->_result))) {
            mysqli_free_result($this->_result);
            return FALSE;
        }
        return $row;
    }
    
    // Get insertion ID
    public function getInsertID() {
        if ($this->_link !== NUlL) {
            return mysqli_insert_id($this->_link); 
        }
        return NULL;  
    }
    
    // Get affected rowd
    public function getAffectedRows() {
        if ($this->_link !== NUlL) {
            return mysqli_affected_rows($this->_link); 
        }
        return 0;  
    }
    
 
    // Count rows in result set
    public function countRows() {
        if ($this->_result !== NULL) {
           return mysqli_num_rows($this->_result);
        }
        return 0;
    }  
    
    public function escapeString($string){
        $this->connect();
        $stringEscape = mysqli_real_escape_string($this->_link,$string);
        return $stringEscape;
    }
    
	public function getArray()
		{
			$arreglo=array();
			$contador=0;
			while($row = $this->fetch()) {
				foreach($row as $key => $value){
					$arreglo[$contador][$key] = $value;
				}
				++$contador;
			}
			return $arreglo;
		}
 
    // Close the database connection
    function __destruct() {
        is_resource($this->_link) AND mysqli_close($this->_link);
    }
}

class DatabaseSQLserver {
    private $_result = NULL;
    private $_link = NULL;
    private $_config = array();
    private static $_instance = NULL; 

    public static function getInstance(array $config = array()) {
        if (self::$_instance === NULL){
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }
 
    // Private constructor
    private function __construct(array $config) {
        if (count($config) < 4) {
            throw new Exception('Invalid number of connection parameters');  
        }
        $this->_config = $config;
    } 
 
    // Prevent cloning class instance
    private function __clone() {}
 
    // Connect to MySQL
    private function connect(){
        // Connect only once
        static $connected = FALSE;
        if ($connected === FALSE){
            list($host, $user, $password, $database) = $this->_config;
            if ((!$this->_link = mssql_connect($host, $user, $password))){
                throw new Exception('Error connecting to MySQL : ' . mysqli_connect_error());
            }
        	if (!mssql_select_db($database, $this->_link)) {
				    throw new Exception('Error seleccionando la base de datos : ' . mysqli_connect_error());
			}
            $connected = TRUE;
            unset($host, $user, $password, $database);      
        }
    }
 
    // Perform query
    public function query($query) {
        if (is_string($query) and !empty($query)) {
            $this->connect();
            if ((!$this->_result = mssql_query($query))) {
                throw new Exception('Error performing query ' . $query . ' Message : ' . mysqli_error($this->_link));
            }
        }
    }
 
    // Fetch row from result set
    public function fetch() {
        if ((!$row = mssql_fetch_object($this->_result))) {
            mssql_free_result($this->_result);
            return FALSE;
        }
        return $row;
    }
    
    // Get insertion ID
    public function getInsertID() {
        if ($this->_link !== NUlL) {
            return mysqli_insert_id($this->_link); 
        }
        return NULL;  
    }
 
    // Count rows in result set
    public function countRows() {
        if ($this->_result !== NULL) {
           return mssql_num_rows($this->_result);
        }
        return 0;
    }  
    
	public function getArray()
		{
			$arreglo=array();
			$contador=0;
			while($row = $this->fetch()) {
				foreach($row as $key => $value){
					$arreglo[$contador][$key] = $value;
				}
				++$contador;
			}
			return $arreglo;
		}
 
    // Close the database connection
    function __destruct() {
        is_resource($this->_link) AND mssql_close($this->_link);
    }
}



?>