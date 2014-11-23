<?php

class Category {

	var $id;
	var $category;
  
	function Category($id = "")
	{
		global $database, $user;
		
		if (!empty($id)) {
			$this->id = (int) $id;
			$database->loadObject($this, "select * from gft_category where id=".$this->id);
		}
	}

	function saveCategory($category)
	{
		global $database, $user;

		$category = strip_tags($category);

		if (!empty($this->id)) {
			$database->query("update gft_category set category='".addslashes($category)."' where id=".$this->id); 
		} else {
      $database->lock("gft_category");
      $id = $database->getNextId("gft_category");
			$database->query("insert into gft_category (id, category) values($id, '".addslashes($category)."')"); 
      $database->unlock("gft_category");
    }
		return 0;
	}
	
	function deleteCategory()
	{
		global $database, $user;
		
		if ($user->accessLevel < 3)
			return "ERROR_INSUFFICIENTPRIVILEGES";

    if ($this->id == 1)
      return "ERROR_CATEGORIES_REMOVEDEFAULT";
      
		$database->query("delete from gft_category where id=".$this->id); 

		return 0;
	}

  function initCategories() {
    global $strings, $database;
    
    $catObj = new Category();
    $catObj->saveCategory($strings["LANG_DEFAULT_CATEGORY"]);
    $catList = explode(",", $strings["LANG_CATEGORIES"]);
    foreach ($catList as $cat) {
      $catObj = new Category();
      $catObj->saveCategory($cat);
    }
  }
  
	function getParams()
	{
	}

}

Controler::registerHandler("adminEditCategory", "display", "Category", array("id"), 3);
Controler::registerHandler("saveCategory", "action", "Category", array("id", "category"), 3);
Controler::registerHandler("deleteCategory", "action", "Category", array("id"), 3);

?>