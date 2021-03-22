<?php
ob_start();
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Page;
use Controllers\User;
use Controllers\Transaction;
$user=new User();
$user->redirectUser(true);
$page=new Page();
$page->drawHead('Home',renderPath(__DIR__));

?>
    <script>
        $(document).ready(function() {

            $("#modal-submit1").click(function() {
                $.post('handlers/user/deactivate-user.php', {
                    id: $("#inputId").val()
                }, function(data, status) {
                    $('#modal1').modal('hide');
                    if(data==1)window.location='index.php';else{
                    $("#table").remove();
                    $("#store").html(data);
                    }
                });
            });
            $("#modal-submit2").click(function() {
                $.post('handlers/user/activate-user.php', {
                    id: $("#inputId").val()
                }, function(data, status) {
                    $('#modal2').modal('hide');
                    $("#table").remove();
                    $("#store").html(data);
                });
            });
            $("#modal-submit3").click(function() {
                $.post('handlers/user/delete-user.php', {
                    id: $("#inputId").val()
                }, function(data, status) {
                    $('#modal3').modal('hide');
                    if(data==1)window.location='index.php';else{
                    $("#table").remove();
                    $("#store").html(data);
                    }
                });
            });
            $("#modal-submit4").click(function() {
                $.post('handlers/transaction/delete-transaction.php', {
                    id: $("#inputId").val()
                }, function(data, status) {
                    $('#modal4').modal('hide');
                    $("#table").remove();
                    $("#store").html(data);
                });
            });
        });
    </script>
    <?php
    require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
    if(isset($_SESSION['id']))
    $user=new User($_SESSION['id']);
    else $user=new User();
    $user->welcome();
        if ($user->isAdmin()) {
            echo "<div id='store'>";
            $user->printUsers();
            echo "</div>";
            $page->dialog("1");
            $page->dialog("2");
            $page->dialog("3");
    ?>
            <button class='btn btn-success' onclick="goTo('pages/user/register')">New Account</button>
            <input type='hidden' id='inputId'>
        <?php
        } else {
            $page->dialog("4");
            $transaction = new Transaction();
            echo "<div id='store'>";
            $transaction->printTransactions($_SESSION['id']);
            echo "</div>";
        ?>
            <button class='btn btn-success' onclick="goTo('pages/transaction/new-transaction.php')">New Transaction</button>
            <input type='hidden' id='inputId'>
    <?php
        } 
$page->drawEnd();