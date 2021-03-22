<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Page;
use Controllers\User;
$page=new Page();
$page->drawHead('Update user',renderPath(__DIR__));
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']); else
$user=new User();
$user->redirectUser(true,true);
        require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
        if ($user->isAdmin()) {
            $user->printUpdateUser($_GET['id']);
        } else {
            $user->printUpdateUser();
        }
$page->drawEnd();