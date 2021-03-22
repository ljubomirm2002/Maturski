    <div class="container col-6 col-6-sm m-t">
        <div class="container col-12 strip">
            <h1 class="text-center">Login</h1>
        </div>
        <form id='form'>
            <div class="form-group text-center">
                <p class="text-center">Username<b class="text-danger">*</b></p>
                <input type="text" placeholder="Username" class='form-control col-3 mx-auto' name="username" id="username" required>
            </div>
            <div class="form-group text-center">
                <p class='text-center'>Password<b class="text-danger">*</b></p>
                <input type="password" placeholder="Password" class='form-control col-3 mx-auto' name="password" id="password" required>
            </div>
            <div class="form-group text-center">
                <input type="button" class='btn btn-primary' id="submit" name='submit' value="Login" onclick="loginValidate()">
            </div>
        </form>
        <div class='text-center'>
            <a href="pages/user/forgot-password" class='text-center'>Forgot password?</a>
            <br>
            <a href="pages/user/register" class='text-center'>Don't have account?</a>
            <p class="text-danger text-center" id="error"></p>
        </div>
    </div>
