<?php 
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Page;
$page=new Page();
$page->drawHead('Forgot password?',renderPath(__DIR__));
$page->drawPage('forgot-password.html');
$page->dialog();
$page->drawEnd();
?>
