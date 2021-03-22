<?php 
 require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
 use Controllers\Page;
 use Controllers\User;
 use Controllers\Category;
 if(isset($_SESSION['id']))
 $user = new User($_SESSION['id']);else
    $user = new User();
    $user->redirectUser(true, true);
$page=new Page();
$page->drawHead('Subcategory',renderPath(__DIR__));
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
    $category = new Category($_GET['id']);
    $category->printSubcategories();
    $page->dialog('1');
    ?>
    <button class='btn btn-success' onclick="goTo('pages/category/new-subcategory?id=<?php echo $_GET['id']; ?>')">New Subcategory</button>
    <input type='hidden' id='inputId'>
    <script>
        $(document).ready(function() {
            $("#modal-submit1").click(function() {
                window.location = 'handlers/category/delete-subcategory.php?id=' + $("#inputId").val() + '&id1=<?php echo $_GET['id']; ?>';
            });
        });
    </script>
<?php
$page->drawEnd();