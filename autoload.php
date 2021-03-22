<?php
if (!isset($_SESSION))
    session_start();
spl_autoload_register(
    function ($class_name) {
        $class_name = strtolower($class_name);
        $class_name=str_replace('\\','/',$class_name);
        require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/".$class_name . ".php");
    }
);
function renderPath(string $s):string{
        $s=substr($s,strpos($s,'Maturski')+8);
        $a='';
        while(!is_bool(strpos($s,'\\'))){
            $a.='../';
            $s=substr($s,strpos($s,'\\')+1);
        }
        return $a;
}
?>