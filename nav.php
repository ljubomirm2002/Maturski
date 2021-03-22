<script>
    $(document).ready(
        function() {
            $("#modal-submit").click(function() {
                $.post('handlers/user/logout.php', {
                    hidden: 'a'
                }, function(data, status) {
                    $('#modal').modal('hide');
                    window.location = 'index.php';
                });
            });
        });
</script>
<?php

use Controllers\Page;
use Controllers\User;
if(isset($_SESSION['id']))
$user=new User($_SESSION['id']);
else $user=new User();
$page=new Page();
$page->dialog();
if ($user->isAdmin()) {
?>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" href="index.php">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="pages/category/category">CATEGORIES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="pages/category/verify-category.php">VERIFY CATEGORY</a>
        </li>
        <li class="nav-item" id='logout' onclick="logout()">
            <button class="nav-link active btn">LOGOUT</button>
        </li>
    </ul>
<?php
} else {
?>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" href="index.php">HOME</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="pages/user/account">ACCOUNT</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="pages/user/statistic.php">STATISTICS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="pages/user/compare.php">COMPARE</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="pages/category/recommend-category.php">RECOMMEND CATEGORY</a>
        </li>
        <li class="nav-item" id='logout' onclick="logout()">
            <button class="nav-link active btn">LOGOUT</button>
        </li>
    </ul>
<?php
}
?>