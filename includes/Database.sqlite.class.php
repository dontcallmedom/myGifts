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
			$this->connection = sqlite_open('./data/myGifts.db');
			if (sqlite_last_error($this->connection)) {
				$logger->logMessage($logger->LOG_CRITICAL, "Can't connect to DB : ".sqlite_error_string(sqlite_last_error($this->connection)));
				return false;
			}
		}
    sqlite_create_function($this->connection, 'now', 'sqlite_now', 0);
    sqlite_create_function($this->connection, 'DAYOFYEAR', 'sqlite_dayofyear', 1);
		return true;
	}

  function lock($tableName) {
    $this->query("BEGIN TRANSACTION");
  }

  function unlock($tableName) {
    $this->query("COMMIT TRANSACTION");
  }

  function timestamp($col) {
    return "strftime('%s', $col)";
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
		$row = $this->fetchItem($sqlQuery);
		if ($row == "ERROR_DATABASE")
			return "ERROR_DATABASE";

		if (is_array($row)) {
 	    foreach (array_keys($row) as $colName) {
				$object->$colName = $row[$colName];
			}
	 		return $object;
		}

		return null;
	}

  function stripTableAlias($resultArr) {
      if (!is_array($resultArr))
        return array();

      $newArr = array();
      foreach ($resultArr as $key => $value) {
        if (strpos($key, ".") > 0)
          list($alias, $key) = explode(".", $key);
          $newArr[$key] = $value;
      }
      return $newArr;
  }

	function &fetch($sqlQuery)
	{
		$result = $this->query($sqlQuery);
		if ($result === false)
			return "ERROR_DATABASE";
		else {
			$resultData = array();
			while ($item = sqlite_fetch_array($result)) {
        $resultData[] = Database::stripTableAlias($item);
      }
			return $resultData;
		}
	}

	function &fetchItem($sqlQuery)
	{
		$result = $this->query($sqlQuery);
		if ($result) {
			return Database::stripTableAlias(sqlite_fetch_array($result));
		} else
			return "ERROR_DATABASE";
	}

	function query($sqlQuery)
	{
		global $logger;

		if (!$this->connect())
			return false;

		$logger->logMessage($logger->LOG_INFO, "Executing query : $sqlQuery");
		$result = sqlite_query($this->connection, $sqlQuery);
		if ($result) {
			return $result;
		} else {
			$logger->logMessage($logger->LOG_ERROR, "Error executing $sqlQuery : ".sqlite_error_string(sqlite_last_error($this->connection)));
			return false;
		}
	}

  function saveTable($tableName)
  {
    if (!$this->connect())
      return false;

    $logger->logMessage($logger->LOG_INFO, "Saving table : $tableName");
    sqlite_query($this->connection, "DROP TABLE ${tableName}_SAVE");
    $result = sqlite_query($this->connection, "ALTER TABLE ${tableName} RENAME ${tableName}_SAVE");
    if ($result)
      return true;
    else {
      $logger->logMessage($logger->LOG_ERROR, "Error saving table $tableName : ".sqlite_error_string(sqlite_last_error($this->connection)));
      return false;
    }
  }

  function restoreTable($tableName)
  {
    if (!$this->connect())
      return false;

    $logger->logMessage($logger->LOG_INFO, "Restoring table : $tableName");
    $result = sqlite_query($this->connection, "INSERT INTO ${tableName} SELECT * FROM ${tableName}_SAVE");
    if ($result)
      return true;
    else {
      $logger->logMessage($logger->LOG_ERROR, "Error restoring table $tableName : ".sqlite_error_string(sqlite_last_error($this->connection)));
      return false;
    }
  }
}

function sqlite_now() {
  return date('Y-m-d G:i:s');
}

function sqlite_dayofyear($date) {
  $dateArr = getdate(strtotime($date)); //, "%Y-%m-%d %T"
  return $dateArr["yday"];
}

?>
