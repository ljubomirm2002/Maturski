<?php
ob_start();
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\Category;
use Controllers\User;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);
else $user=new User();
$user->redirectUser(true,true);
$category=new Category();
$category->deleteSubcategory($_GET['id']);
if($_GET['id1']=='a')
header('Location: /Maturski/pages/category/verify-category.php');
else 
header('Location: /Maturski/pages/category/subcategory.php?id=' . $_GET['id1']);
ob_end_flush();
?>