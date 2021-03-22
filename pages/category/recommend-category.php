<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Page;
use Controllers\User;
use Controllers\Dbconnection;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);
else $user=new User();
$page=new Page();
$page->drawHead('Recommend category',renderPath(__DIR__));
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
?>
<div class="container col-12 m-t">
<div class="row">
<div class="col-6">
<div class="container col-12 strip">
        <h1 class="text-center">Recommend category</h1>
    </div>
    <form id='form' action="handlers/category/recommend-category.php" method="POST">
        <div class="form-group text-center">
            <p class="text-center">Title<b class="text-danger">*</b></p>
            <input type="text" placeholder="Title" class='form-control col-3 mx-auto' name="title" id="title" required>
        </div>
        <div class="form-group text-center">
            <input type="button" class='btn btn-primary' id="btnSubmit" name='btnSubmit' value="Recommend" onclick='submitForm()'>
        </div>
    </form>
</div>
<div class="col-6">
<div class="container col-12 strip">
        <h1 class="text-center">Recommend subcategory</h1>
    </div>
    <form id='form1' action="handlers/category/recommend-subcategory.php" method="POST">
    <div class="form-group text-center">
                    <p class='text-center'>Category<b class="text-danger">*</b></p>
                    <select class='form-control col-3 mx-auto' name="category" id="category" >
                        <?php 
                        $db=new Dbconnection();
                        $all = $db->fetch('CALL getCategories()', true);
                        foreach ($all as $a) {
                            echo "<option value='" . $a['id'] . "'>" . $a['title'] . "</option>";
                        } 
                        /*$all = $db->fetch('CALL getUnverifiedCategories()', true);
                        foreach ($all as $a) {
                            echo "<option value='" . $a['id'] . "'>" . $a['title'] . "</option>";
                        } */
                        ?>
                    </select>
                </div>
        <div class="form-group text-center">
            <p class="text-center">Title<b class="text-danger">*</b></p>
            <input type="text" placeholder="Title" class='form-control col-3 mx-auto' name="title" id="title" required>
        </div>
        <div class="form-group text-center">
            <input type="button" class='btn btn-primary' id="btnSubmit" name='btnSubmit' value="Recommend" onclick='submitForm("form1")'>
        </div>
    </form>
</div>
</div>
</div>
<?php
$page->drawEnd();