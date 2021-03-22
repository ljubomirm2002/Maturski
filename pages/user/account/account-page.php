<script>
        $(document).ready(function(){
            $("#modal-submit2").click(function(){
                $("#modal2").modal('hide');
            });
            
            $("#modal-submit1").click(function() {
                $.post('handlers/user/deactivate-user.php', {
                    id: $("#inputId").val()
                }, function(data, status) {
                    $('#modal1').modal('hide');
                    if(data==1)window.location='index.php';
                });
            });
            $("#modal-submit3").click(function() {
                $.post('handlers/user/delete-user.php', {
                    id: $("#inputId").val()
                }, function(data, status) {
                    $('#modal3').modal('hide');
                    if(data==1)window.location='index.php';
                });
            });
        });
    </script>
<div class="container col-6 col-6-sm m-t">
            <div class="container col-12 strip">
                <h1 class="text-center">Update account</h1>
            </div>
            <form id='form' action="handlers/user/update-user.php" method="POST">
                <div class="form-group text-center">
                    <p class="text-center">Username<b class="text-danger">*</b></p>
                    <input type="text" value='<?php echo $_SESSION['username']; unset($_SESSION['username']);?>' placeholder="Username" class='form-control col-3 mx-auto' name="username" id="username" required>
                </div>    
                <div class="form-group text-center">
                    <p class="text-center">Name<b class="text-danger">*</b></p>
                    <input type="text" value='<?php echo $_SESSION['name']; unset($_SESSION['name']);?>' placeholder="Name" class='form-control col-3 mx-auto' name="name" id="name" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Email<b class="text-danger">*</b></p>
                    <input type="email" value='<?php echo $_SESSION['email']; unset($_SESSION['email']);?>' placeholder="Email" class='form-control col-5 mx-auto' name="email" id="email" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Address<b class="text-danger">*</b></p>
                    <input type="text" value='<?php echo $_SESSION['address']; unset($_SESSION['address']);?>' placeholder="Address" class='form-control col-5 mx-auto' name="address" id="address" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Biography</p>
                    <textarea placeholder="Biography" name="biography" id="biography" class='mx-auto form-control col-7'><?php echo $_SESSION['biography']; unset($_SESSION['biography']);?></textarea>
                </div>
                <div class="form-group text-center">
                    <input type="button" class='m-b btn btn-primary'  name='btnSubmit' value="Update" onclick='submitForm()'>
                </div>
            </form>
        </div>
        <div class="container col-6">
            <div class="container col-12 strip">
                <h1 class="text-center">Change password</h1>
            </div>
            <form action="handlers/user/change-password.php" id="form1" method="POST">
            <input type="hidden" id='now' name="now" value="<?php echo $_SESSION['now'];unset($_SESSION['now']);?>">
            <div class="form-group text-center">
                    <p class='text-center'>Old password<b class="text-danger">*</b></p>
                    <input type="password" placeholder="Old password" class='form-control col-3 mx-auto' name="old" id="old" required>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>New password<b class="text-danger">*</b></p>
                    <input type="password" placeholder="New password" class='form-control col-3 mx-auto' name="new" id="new" required>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Confirm password<b class="text-danger">*</b></p>
                    <input type="password" placeholder="Confirm password" class='form-control col-3 mx-auto' name="confirm" id="confirm" required>
                </div>
                <div class="form-group text-center">
                    <input type="button" class='m-b btn btn-primary'  name='btnSubmit' value="Change" onclick='changePassword()'>
                </div>
            </form>
        </div>
        <input type='hidden' id='inputId'>
        <div class='text-center'>
        <button class='m-b btn btn-danger'   onclick="onclickDelete(<?php echo $_SESSION['id'];?>)">DEACTIVATE</button>
       <br>
        <button class='m-b btn btn-danger'   onclick="deleteUser(<?php echo $_SESSION['id'];?>)">DELETE</button>
        </div>