<?php

class Database {
	
	var $connection;

	var $server;
	var $user;
	var $password;
	var $database;
	
	function Database($server, $user, $password, $database)
	{
    $this->connection = null;
    
		$this->server = $server;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
	}

	function connect()
	{
		global $logger;
		
		if (!$this->connection) {
			$this->connection = @mysql_connect($this->server, $this->user, $this->password);
			if (mysql_errno() > 0) {
				$logger->logMessage($logger->LOG_CRITICAL, "Can't connect to DB : ".mysql_errno().": ".mysql_error());
				return false;
			}
			@mysql_select_db($this->database, $this->connection);
			if (mysql_errno() > 0) {
				$logger->logMessage($logger->LOG_CRITICAL, "Can't switch to DB : ".mysql_errno().": ".mysql_error());
				return false;
			}
		}
		return true;
	}

  function lock($tableName) {
    $this->query("LOCK TABLES $tableName WRITE");
  }

  function unlock($tableName) {
    $this->query("UNLOCK TABLES");
  }
  
  // not multiuser safe ! table must be locked/unlocked
  function getNextId($tableName) {
    $maxArr = $this->fetchItem("select max(id) as maxId from $tableName");
    if (is_array($maxArr))
      return $maxArr["maxId"]+1;
    else
      return 1;
  }
  
	function &loadObject(&$object, $sqlQuery)
	{
		$result = $this->query($sqlQuery);
		if ($result == 0)
			return "ERROR_DATABASE";
			
		if ($result && mysql_num_rows($result) > 0) {
			$row = mysql_fetch_assoc($result);
			//print_r($row);
 	        if ($row)
 	        	foreach (array_keys($row) as $colName) {
					$object->$colName = $row[$colName];
				}
		    mysql_free_result($result); 

	 		return $object;
        }
        
		return null; 
	}

	function &fetch($sqlQuery)
	{
		$resultData = array();
		$result = $this->query($sqlQuery);
		if ($result) {
			while($row = mysql_fetch_assoc($result)) {
				//print_r($row);
 	        	array_push($resultData, $row);
			}
		    mysql_free_result($result); 
                } else
                  $resultData = "ERROR_DATABASE";
 
 		return $resultData;
	}

	function &fetchItem($sqlQuery)
	{
		$resultData = array();
		$result = $this->query($sqlQuery);
		if ($result) {
			$resultData = mysql_fetch_assoc($result);
		    mysql_free_result($result); 
        } else
        	$resultData = "ERROR_DATABASE";
 
 		return $resultData;
	}
	
	function query($sqlQuery)
	{
		global $logger;
		
		if (!$this->connect())
			return false;

		$logger->logMessage($logger->LOG_INFO, "Executing query : $sqlQuery");
		$result = mysql_query ($sqlQuery, $this->connection);
		if ($result) {
			return $result;
		} else {
			$logger->logMessage($logger->LOG_ERROR, "Error executing $sqlQuery : ".mysql_errno().": ".mysql_error());
			return false;
		}
	}
	
}

?>