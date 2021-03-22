<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\Transaction;
use Controllers\User;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);
else $user=new User();
$user->redirectUser(true,false,true);
$t=new Transaction();
$t->deleteTransaction($_POST['id']);
$t->printTransactions($_SESSION['id']);
?>