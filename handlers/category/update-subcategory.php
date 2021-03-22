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
$category->updateSubcategory($_POST['id'],$_POST['title'],$_POST['id1']);
header('Location: /Maturski/pages/category/subcategory.php?id=' . $_POST['id2']);
ob_end_flush();
?>