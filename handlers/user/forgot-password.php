<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\User;
use Controllers\Mailer;
use Controllers\Random;
$user=new User();
$mailer = new Mailer();
$random = new Random();
$newPassword = $random->generateRandomPassword();
$body = 'Your new password is ' . $newPassword;
$a = $user->checkEmail($_POST['email']);
if ($a) {
    $user->forgottenPassword($newPassword,$_POST['email']);
    $mailer->sendMail($_POST['email'], 'New password', $body);
    echo 1;
} else
    echo 0;
?>