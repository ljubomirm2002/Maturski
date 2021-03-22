<?php
ob_start();
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\User;

if (isset($_SESSION['id']))
    $user = new User($_SESSION['id']);
else
    $user = new User();
$user->redirectUser();
if ($user->isAdmin()) {
    $user->updateUser($_POST['id'], $_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['address'], $_POST['biography'], $_POST['deleted'], $_POST['role'], $_POST['id1']);
    header('Location: /Maturski/pages/home.php');
    ob_end_flush();
} else {
    $user->updateUser($user->id, $_POST['name'], $_POST['username'], $_POST['email'], $user->password, $_POST['address'], $_POST['biography'], "NULL", $user->role_id, $user->id);
    header('Location: /Maturski/pages/user/account');
    ob_end_flush();
}
