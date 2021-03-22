<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['page_title'];unset($_SESSION['page_title']);?></title>
    <base href="<?php echo $_SESSION['base'];unset($_SESSION['base']);?>">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/mycss.css">
<script src="assets/js/jquery-3.4.1.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/validation/dist/jquery.validate.js"></script>
<script>
    function validation(a) {
        a = '#' + a;
        $(a).validate({
            errorClass: 'text-danger text-center',
            debug: true,
            success: "valid",
        });
        return $(a).valid();
    }

    function dialog(cla, title, content, btn = "", a = "") {
        $("#modal-header" + a).removeClass();
        $("#content" + a).removeClass();
        $("#modal-footer" + a).removeClass();
        $("#modal-submit" + a).removeClass();
        $("#modal-header" + a).addClass('modal-header');
        $("#content" + a).addClass('modal-body');
        $("#modal-footer" + a).addClass('modal-footer');
        $("#modal-submit" + a).addClass("btn btn-primary");
        $("#modal-header" + a).addClass('bg-' + cla);
        $("#content" + a).addClass('alert-' + cla);
        $("#modal-footer" + a).addClass('alert-' + cla);
        $("#modal-submit" + a).addClass('btn-' + cla);
        $("#modal-title" + a).html(title);
        $("#content" + a).html(content);
        $("#modal-submit" + a).html(btn);
        $("#modal" + a).modal("show");
    }

    function goTo(a) {
        window.location = a;
    }

    function logout() {
        dialog('danger', 'LOGOUT', 'Do you want to logout?', 'YES');
    }

    function onclickDelete(id) {
        $("#inputId").val(id);
        dialog('danger', 'DEACTIVATE ACCOUNT', 'Do you want to deactivate account?', 'YES', "1");
    }

    function onclickActivate(id) {
        $("#inputId").val(id);
        dialog('success', 'ACTIVATE ACCOUNT', 'Do you want to activate account?', 'YES', "2");
    }

    function deleteUser(id) {
        $("#inputId").val(id);
        dialog('danger', 'DELETE ACCOUNT', 'Do you want to delete account?', 'YES', "3");
    }

    function sendEmail() {
        if (validation('form')) {
            $.post('handlers/user/forgot-password.php', {
                email: $("#email").val()
            }, function(data, status) {
                if (data == 1) {
                    dialog('success', 'Succes', 'Password is changed successfuly and sent on your email.', 'OK');
                } else {
                    dialog('warning', 'Warning', "You don't have account.", 'OK');
                }
            });
        }
    }

    function register() {
        if (validation('form')) {
            if ($("#password").val() == $("#confirm").val())
                $.post('handlers/user/register.php', {
                    username: $("#username").val(),
                    password: $("#password").val(),
                    name: $("#name").val(),
                    email: $("#email").val(),
                    address: $("#address").val(),
                    password: $("#password").val(),
                    biography: $("#biography").val()
                }, function(data, status) {
                    if (data == 1) {
                        dialog('success', 'Succes', 'Account is created.', 'OK');
                    } else {
                        dialog('warning', 'Warning', 'Account exsist.', 'OK');
                    }

                });
            else dialog('warning', 'Warning', "Password are't confirmed.", 'OK');
        }
    }

    function readSubcategory(s) {
        $.post('handlers/category/read-subcategory.php', {
            id: $("#category").val(),
            sub:s
        }, function(data, status) {
            $("#subcategory").html(data);
        });
    }

    function submitForm(f = 'form') {
        if (validation(f)) {
            var a = document.getElementById(f);
            a.submit();
        }
    }

    function deleteCategory(id) {
        $("#inputId").val(id);
        dialog('danger', 'DELETE CATEGORY', 'Do you want to delete category?', 'YES','1');
    }

    function deleteSubcategory(id,a='1') {
        $("#inputId").val(id);
        dialog('danger', 'DELETE SUBCATEGORY', 'Do you want to delete subcategory?', 'YES',a);
    }

    function deleteTransaction(id) {
        $("#inputId").val(id);
        dialog('danger', 'DELETE TRANSACTION', 'Do you want to delete transaction?', 'YES', '4');
    }

    function loginValidate() {
        if (validation('form')) {
            $.post('handlers/user/login.php', {
                username: $("#username").val(),
                password: $("#password").val()
            }, function(data, status) {
                if (data == 1) window.location = 'pages/home.php';
                else $("#error").html(data);
            });
        }
    }
    function verifyCategory(id) {
        $("#inputId").val(id);
        dialog('success', 'VERIFY CATEGORY', 'Do you want to verify category?', 'YES', "3");
    }
    function verifySubcategory(id) {
        $("#inputId").val(id);
        dialog('success', 'VERIFY SUBCATEGORY', 'Do you want to verify subcategory?', 'YES', "4");
    }
    function changePassword(){
        if(validation('form1')){
            if($("#now").val()==$("#old").val())
            {
                if($('#new').val()==$('#confirm').val()){
                    var a=document.getElementById('form1');
                    a.submit();
                }else{
                    dialog('warning', 'WARNING', 'New password isn\'t confirmed!', 'OK','2');
                }

            }else{
                dialog('warning', 'WARNING', 'Old password isn\'t correct!', 'OK','2');
            }
        }
    }
</script>
</head>
<body>

