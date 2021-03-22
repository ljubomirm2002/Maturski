<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\Category;
use Controllers\User;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);
else $user=new User();
$user->redirectUser(true,false,true);
$category=new Category($_POST['id']);
$subcategory = $category->getSubcategories();
echo "<option value='NULL'></option>";
foreach ($subcategory as $s) {
    $b="";
    if($_POST['sub']==$s['title'])$b='selected';
    echo "<option value='" . $s['id'] . "' ".$b." >".$s['title']."</option>";
}
?>