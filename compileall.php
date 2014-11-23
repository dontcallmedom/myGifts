<?php
require_once("includes/includes.inc.php");

$smarty = new Smarty;
$smarty->template_dir = "skins/default/";
$smarty->use_sub_dirs = false;
$smarty->compile_dir = "skins/default/compiled";
$dh = opendir("skins/default/");
while ($file = readdir($dh)) {
	if (is_file("skins/default/$file")) {
		print "<h2>$file</h2>";
		$smarty->display("$file"); 
	}
} 
closedir($dh); 
?>