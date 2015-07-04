<?php
define("LIBRARY_DIR",realpath(dirname(__DIR__)) . '/');
require_once LIBRARY_DIR."/Utils/DBObject.php";

class Entries {
	private $DBH;
		
	/**      
	* Creates a database object and stores relevant data      
	*      
	* Upon instantiation, this class accepts a database object      
	* that, if not null, is stored in the object's private $_db      
	*
	* @param object $dbo a database object      
	* @param string $useDate the date to use to build the calendar      
	* @return void      
	*/     
	public function __construct(){
	
		$DBObject = new DBObject();
		$this->DBH = $DBObject->DBH;
	}
	
	public function getColumnList(){
		
		$STH = $this->DBH->prepare("SHOW COLUMNS FROM entries");
		$STH->execute();
		
		$result = array();
		while($row=$STH->fetch(PDO::FETCH_ASSOC)){
			$columnName = str_replace("_", " ",$row["Field"]);
			$columnName = ucwords(strtolower($columnName));
			
			$list = array("columnName"=> $columnName, "fieldName"=>$row["Field"], "fieldType" => $row["Type"]);
						
			array_push($result,$list);
		}
		
		return $result;
		
		
		}
		
	public function getEntryList($filterIP=NULL,$filterDate=array()){
		
		$filterQuery='';
		$orderQuery = " ORDER BY dowl_date DESC";
		//Check if a fliter exist
		if($filterIP!== NULL && $filterDate != NULL){
			$filterQuery = " WHERE IP_ADDRESS LIKE '" . $filterIP . "%' AND ('" . $filterDate["from_date"]."' <= UNIX_TIMESTAMP(STR_TO_DATE(DOWNLOAD_DATE, '%c/%e/%Y %k:%i:%S')) AND '" .$filterDate["to_date"]. "' >= UNIX_TIMESTAMP(STR_TO_DATE(DOWNLOAD_DATE, '%c/%e/%Y %k:%i:%S')))";
		}
					
		$STH = $this->DBH->query("SELECT ID, TRACKID, IP_ADDRESS, EXPIRY_DATE, TRANSACTION_ID, STATUS, SOURCE, TYPE, UNIX_TIMESTAMP(STR_TO_DATE(DOWNLOAD_DATE, '%c/%e/%Y %k:%i:%S')) as dowl_date FROM entries" .$filterQuery .$orderQuery );
		//$STH->execute();
		
		
		
		
		
		$entries = array();
		while($row=$STH->fetch(PDO::FETCH_ASSOC)){	
			$entry = array(
				"ID" => $row['ID'],
				"TRACKID" => $row['TRACKID'],
				"IP_ADDRESS" => $row['IP_ADDRESS'],	
				"EXPIRY_DATE" => date("Y-m-d",strtotime($row['EXPIRY_DATE'])),				
				"TRANSACTION_ID" => $row['TRANSACTION_ID'] ,
				"STATUS" => $row['STATUS'],				
				"SOURCE" => $row['SOURCE'],				
				"TYPE" => $row['TYPE'],
				"DOWNLOAD_DATE" => gmdate("Y-m-d H:i:s",$row['dowl_date'])
				);
				
			array_push($entries,$entry);
				
		}
		
		return $entries;
		
	}
}

?>