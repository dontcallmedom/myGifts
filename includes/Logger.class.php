<?php

class Logger {
	
	var  $LOG_DEBUG		= 0;
	var  $LOG_INFO		= 1;
	var  $LOG_WARNING	= 2;
	var  $LOG_ERROR		= 4;
	var  $LOG_CRITICAL	= 8;
	
	function logMessage($level, $message) {
		if (defined("DEBUG") && DEBUG) {
			//$this->messageLog .= "<!-- $message -->\n";
			if ($level >= $this->LOG_ERROR) {
				$this->logMessageToFile($level, "$message", "errors.log");
			}
			echo "<!-- $message -->\n";
		}
	}
	
	function logMessageToFile($level, $message, $logfilename) {
		if (defined("LOG_DIR")) {
			$fp = @fopen(LOG_DIR."$logfilename", "a");
			@fwrite ($fp, date ("D d/m/Y - H:i")." ($level) : $message (".$_SERVER["REQUEST_URI"].")\n");
			@fclose($fp);
		}
	}

	function logToFile($message, $logfilename) {
		global $HTTP_USER_AGENT, $REMOTE_ADDR;
		
		if (defined("LOG_DIR")) {
			$fp = @fopen(LOG_DIR."$logfilename", "a");
			@fwrite ($fp, date ("D d/m/Y - H:i")."|$message|".$_SERVER["HTTP_USER_AGENT"]."|".$_SERVER["REMOTE_ADDR"]."\n");
			@fclose($fp);
		}
	}
}

?>
