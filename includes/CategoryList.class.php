<?php

class CategoryList {
  var $selected;
	var $categories;

	function CategoryList($selected = "")
	{
		global $database;
    if (empty($selected))
      $this->selected = 1;
    else
    		$this->selected = $selected;
		$this->categories = $database->fetch("select * from gft_category order by category");
	}

	function getParams()
	{
	}

}

Controler::registerHandler("editCategory", "display", "CategoryList", array("id"));
Controler::registerHandler("adminCategories", "display", "CategoryList", null, 3);
?>