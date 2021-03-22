<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Page;
use Controllers\User;
use Controllers\Transaction;
$user=new User();
$user->redirectUser(true,false,true);
$page=new Page();
$page->drawHead('Update transaction',renderPath(__DIR__));
    require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
    $transaction = new Transaction();
    $transaction->printUpdateTransaction($_GET['id']);
