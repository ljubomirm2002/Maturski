<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\User;
if(isset($_SESSION['id']))
$user = new User($_SESSION['id']);
else $user=new User();
$user->redirectUser(true, true);
$user->updatePassword($_POST['new']);
header('Location: /Maturski/pages/user/account');
?>