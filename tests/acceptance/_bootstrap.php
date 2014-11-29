<?php
// Here you can initialize variables that will be available to your tests
@unlink("tests/_output/config.inc.php");
$mysqli = new mysqli("localhost", "mygifts_dev", "mygifts_dev", "mygifts_dev");
$mysqli->query("DROP DATABASE mygifts_dev");
$mysqli->query("CREATE DATABASE mygifts_dev");


\Codeception\Util\Autoload::registerSuffix('Steps', __DIR__.DIRECTORY_SEPARATOR.'_steps');
