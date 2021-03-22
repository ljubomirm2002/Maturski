<?php
ob_start();
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Category;
$category=new Category();
$category->recommendCategory($_POST['title']);
header("Location: /Maturski/pages/category/recommend-category.php");
ob_end_flush();