<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\User;
use Controllers\Page;
use Controllers\Transaction;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);else
$user=new User();
$user->redirectUser(true,false,true);
$page=new Page();
$page->drawHead('Create user',renderPath(__DIR__));
    require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");    
    $transaction = new Transaction();
    $transaction->createTransaction();
$page->drawEnd();