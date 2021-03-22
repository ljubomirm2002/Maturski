<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\User;
$user=new User();
$id=$user->checkUser($_POST['username'],$_POST['password']);
if ($id) {
    $_SESSION['id']=$id;
    echo true;
} else echo "Wrong credentials or user doesn't exsist!";
?>