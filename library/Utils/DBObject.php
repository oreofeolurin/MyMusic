<?php
use Charmms\Utils\Logger;

class DBObject{
/**     
* Defines the host     
*         
*      
* @var string Host     
*/     
private $host="localhost";
/**     
* Defines the username   
*         
*      
* @var string Username      
*/     
private $username="root";    

/**     
* Defines the password   
*         
*      
* @var string Password    
*/     
private $password="";
    
/**     
* Defines the database to be utilized 
*         
*      
* @var string Database    
*/     
private $database="mymusic";

/**     
* Stores the connection
*         
*      
* @var boolean Database    
*/     
public $DBH;

private static $INSTANCE;
/**      
* Connects to database object and select database to use      
*    
* @return void      
*/
public function __construct(){
	//Establish connection with the databae
	$host = $this->host;
	$dbname = $this->database;
	
	try{
		$this->DBH = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$this->username,$this->password);
		$this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->DBH->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); 
        }catch(PDOExeception $ex){
		$error = $ex->getMessage();
		Logger::write("PDO", $error);
	}
             
  }
public static function  getInstance(){
    if(!isset(self::$INSTANCE)){
	$object = __CLASS__;
	self::$INSTANCE = new $object;
    }
    return self::$INSTANCE;    
}

/**      
* Closes connection to a database   
*    
* @return void      
*/
public function closeConnection(){
	
        $this->DBH = null;
    }

}