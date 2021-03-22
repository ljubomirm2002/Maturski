<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\User;
if(isset($_SESSION['id']))
$user = new User($_SESSION['id']);
else $user=new User();
$user->redirectUser();
if($user->deleteUser( $_POST['id'] ))
echo 1; else
$user->printUsers();
?>