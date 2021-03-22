<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Page;
use Controllers\User;
use Controllers\Category;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);
else $user=new User();
$page=new Page();
$page->drawHead('Verify category',renderPath(__DIR__));
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
$category=new Category();
$category->printCategories(true);
$category->printSubcategories(true);
$page->dialog('1');
$page->dialog('2');
$page->dialog('3');
$page->dialog('4');
?>
<input type="hidden" name="inputId" id='inputId'>
<script>
    $(document).ready(function(){
        $("#modal-submit1").click(function() {
            window.location = 'handlers/category/delete-category.php?id=' + $("#inputId").val()+ '&id1=<?php echo "a"; ?>';
        });
        $("#modal-submit2").click(function() {
                window.location = 'handlers/category/delete-subcategory.php?id=' + $("#inputId").val() + '&id1=<?php echo "a"; ?>';
            });
            $("#modal-submit3").click(function() {
                window.location = 'handlers/category/verify-category.php?id=' + $("#inputId").val();
            });
            $("#modal-submit4").click(function() {
                window.location = 'handlers/category/verify-subcategory.php?id=' + $("#inputId").val();
            });
    });
</script>
<?php
$page->drawEnd();