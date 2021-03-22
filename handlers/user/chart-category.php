<?php 
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\User;

if (isset($_SESSION['id']))
    $user = new User($_SESSION['id']);
else
    $user = new User();
$user->redirectUser();
if($_POST['id']=="NULL")echo "[['Subcategory','Money amount']]";else 
$user->chartCategory($_POST['id']);
?>