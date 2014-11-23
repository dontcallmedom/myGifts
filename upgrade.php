<html>
<body>
<?php

$dbvers = Setup::getParam("dbVersionNum");

print "<h1>Updating database</h1>";

$ok = true;

if ($dbvers < 200) {
	print "<h2>Updating structure to version 2.00</h2>";
	$ok &= $database->query("ALTER TABLE gft_gift ADD owner VARCHAR (32) AFTER forUser");
	$ok &= $database->query("update gft_gift set owner=forUser where owner is null");
	$ok &= $database->query("ALTER TABLE gft_gift ADD INDEX (owner)");
	$ok &= $database->query("CREATE TABLE gft_params (name VARCHAR(32) NOT NULL, type VARCHAR(16) NOT NULL, valueInt INT, valueStr VARCHAR(64), PRIMARY KEY (name))");
	$ok &= Setup::updateParam("dbVersionNum", 200, "int");
}
if ($dbvers < 201) {
  print "<h2>Updating structure to version 2.01</h2>";
  $ok &= $database->query("UPDATE gft_user SET accessLevel = accessLevel+1");
  $ok &= Setup::updateParam("dbVersionNum", 201, "int");
}
if ($dbvers < 210) {
  print "<h2>Updating structure to version 2.10</h2>";
  $ok &= $database->query("CREATE TABLE gft_alert (owner varchar(32) NOT NULL, list varchar(32) NOT NULL, type char(1) NOT NULL, PRIMARY KEY  (owner,list))");
  $ok &= Setup::updateParam("dbVersionNum", 210, "int");
}
if ($dbvers < 250) {
  print "<h2>Updating structure to version 2.50</h2>";
  Setup::updateParam("currency", $strings["LANG_CURRENCY"], "string");
  $ok &= $database->query("DROP TABLE gft_alert");
  $ok &= $database->query("CREATE TABLE gft_alert (owner varchar(32) NOT NULL, list varchar(32) NOT NULL, type char(1) NOT NULL, lastSent INT, PRIMARY KEY  (owner,list))");
  $ok &= Setup::updateParam("dbVersionNum", 250, "int");
}

if (Setup::getParam("dbVersionNum") == 250 && $ok)
	print "<p><b>success</b></p>";

?>
<script type="text/javascript">
function redirect() {
	document.location = "<?= $_SERVER["REQUEST_URI"] ?>";
}
setTimeout("redirect()", 3000);
</script>
</body>
</html>
<?php
exit;
?>
