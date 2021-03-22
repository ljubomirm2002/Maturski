<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\User;
$user=new User();
$a = $user->checkUser($_POST['username'],$_POST['password']);
if (!$a) {
    $user->createUser($_POST['name'],$_POST['username'],$_POST['password'],$_POST['email'],$_POST['address'] ,$_POST['biography']);
    echo 1;
} else {
    echo 0;
}
?>