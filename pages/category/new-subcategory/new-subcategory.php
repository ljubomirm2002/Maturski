<div class="container col-6 col-6-sm m-t">
    <div class="container col-12 strip">
        <h1 class="text-center">Create subcategory</h1>
    </div>
    <form id='form' action="handlers/category/new-subcategory.php" method="POST">
        <div class="form-group text-center">
            <p class="text-center">Title<b class="text-danger">*</b></p>
            <input type="text" placeholder="Title" class='form-control col-3 mx-auto' name="title" id="title" required>
        </div>
        <input type="hidden" name="id" value="<?php echo $_SESSION['subcategory'];unset($_SESSION['subcategory']);?>">
        <div class="form-group text-center">
            <input type="button" class='m-b btn btn-primary' id="btnSubmit" name='btnSubmit' value="Create" onclick='submitForm()'>
        </div>
    </form>
</div>