<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\User;
use Controllers\Page;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);
else $user=new User();
$user->redirectUser(true,true);
$page=new Page();
$page->drawHead('Create subcategory',renderPath(__DIR__));
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
$_SESSION['subcategory']=$_GET['id'];
$page->drawPage('new-subcategory.php');
$page->drawEnd();