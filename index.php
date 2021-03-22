<?php

use Controllers\User;
use Controllers\Page;

require_once('autoload.php');

$page = new Page();
$page->drawHead('Login', '');
$page->drawPage('pages/user/login-page.php');
if (isset($_SESSION['id']))
    $user = new User($_SESSION['id']);
else
    $user = new User();
$user->redirectUser(false);
$page->drawEnd();
