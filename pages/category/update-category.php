<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\Category;
use Controllers\User;
use Controllers\Page;

if (isset($_SESSION['id']))
    $user = new User($_SESSION['id']);
else $user = new User();
$user->redirectUser(true, true);
$page = new Page();
$page->drawHead('Update category', renderPath(__DIR__));
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
$category = new Category();
$category->printCategoryUpdate($_GET['id']);
$page->drawEnd();