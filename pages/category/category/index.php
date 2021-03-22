    <?php
    require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

    use Controllers\Page;
    use Controllers\User;
    use Controllers\Category;

    if (isset($_SESSION['id']))
        $user = new User($_SESSION['id']);
    else
        $user = new User();
    $user->redirectUser(true, true);
    $page = new Page();
    $page->drawHead('Category', renderPath(__DIR__));
    require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
    $category = new Category();
    $category->printCategories();
    $page->dialog('1');
    $page->drawPage('category.html');
    $page->drawEnd();
