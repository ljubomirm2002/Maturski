<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\Page;
use Controllers\User;

$page = new Page();
if (isset($_SESSION['id']))
    $user = new User($_SESSION['id']);
else
    $user = new User();
$user->redirectUser();
$page->drawHead('Account', renderPath(__DIR__));
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
$a = $user->getUser();
$_SESSION['username'] = $a['username'];
$_SESSION['name'] = $a['name'];
$_SESSION['email'] = $a['email'];
$_SESSION['address'] = $a['address'];
$_SESSION['biography'] = $a['biography'];
$_SESSION['now']=$a['password'];
$page->dialog('1');
$page->dialog('2');
$page->dialog('3');
$page->drawPage('account-page.php');
$page->drawEnd();
