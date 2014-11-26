<?php
// only router.php if cli-server
if (php_sapi_name() == 'cli-server') {  
    $info = parse_url($_SERVER['REQUEST_URI']);
    if ($info["path"] === "/") {
      $info["path"] = "/index.php";
    }
    $path = dirname(__FILE__) .$info["path"];
    if (file_exists($path ) && strpos($info["path"], ".php") === FALSE) {
      echo file_get_contents( $path);
      return true;
    } else {
      include_once dirname(__FILE__) . $info["path"];
        return true;
    }
}
?>