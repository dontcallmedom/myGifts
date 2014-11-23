<?php
function smarty_compiler_displayBlock($tag_attrs, & $compiler) {
	$_params = $compiler->_parse_attrs($tag_attrs);
	$id = null;
	$param = "\"\"";
  if (!array_key_exists("name", $_params)) {
    $compiler->_syntax_error("displayBlock: no template provided", E_USER_WARNING);
    return;
  }
  if (!array_key_exists("id", $_params))
    $_params["id"] = "null";
  if (!array_key_exists("param", $_params))
    $_params["param"] = "\"\"";
	$returnValue = "\$_smarty_tpl_vars = \$this->_tpl_vars;
	\$dispobject = Controler::getObject(".$_params['name'].", {$_params['id']});
	if (\$dispobject === null)
      \$dispobject = \$object;
	//  \$this->assign(\"object\", \$object);
	//\$this->assign(\"param\", {$_params['param']});
	//\$this->assign(\"id\", {$_params['id']});
  //\$this->display(".$_params['name'].".'.tpl');
	\$this->_smarty_include(array('smarty_include_tpl_file' => ".$_params['name'].".'.tpl','smarty_include_vars' => array('param' => {$_params['param']}, 'id' => {$_params['id']}, 'object' => \$dispobject)));
	\$this->_tpl_vars = \$_smarty_tpl_vars;
	unset(\$_smarty_tpl_vars);\n";

	return $returnValue;
}
?>