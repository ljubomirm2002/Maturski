<?php

declare(strict_types=1);

namespace Controllers;

final class Page
{
    function __construct()
    {
        if (!isset($_SESSION))
            session_start();
        ob_start();
    }
    public function drawPage(string $page_name):void
    {
        include $page_name;
    }
    public function drawHead(string $page_title,string $base):void{
        $_SESSION['page_title']=$page_title;
        $_SESSION['base']=$base;
        $this->drawPage("{$_SERVER['DOCUMENT_ROOT']}/Maturski/header.php");
    }
    public function dialog($a = ""):void
{
    $_SESSION['a']=$a;
    $this->drawPage("{$_SERVER['DOCUMENT_ROOT']}/Maturski/dialog.php");
}
public function drawEnd():void{
    echo "</body></html>";
}

}
