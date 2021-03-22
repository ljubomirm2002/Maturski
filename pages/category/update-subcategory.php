<?php 
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Page;
use Controllers\User;
use Controllers\Category;
$page=new Page();
$page->drawHead('Update subcategory',renderPath(__DIR__));
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
    $category = new Category($_GET['id1']);
    $category->printUpdateSubcategory($_GET['id']);
    $page->drawEnd();
