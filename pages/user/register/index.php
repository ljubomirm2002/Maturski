<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\Page;

$page = new Page();
$page->drawHead('Register', renderPath(__DIR__));
$page->drawPage('register.html');
$page->dialog();
$page->drawEnd();
