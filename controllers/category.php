<?php

declare(strict_types=1);

namespace Controllers;
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Dbconnection;
final class Category
{
    private $id;
    function __construct(int $id=0)
    {
        $this->id = $id;
    }
    public function getSubcategories(int $id=0){
        if($id==0)$id=$this->id;
        $db=new Dbconnection();
        return $db->fetch('CALL getSubcategories(' . $id . ')', true);
    }
    public function printCategories(bool $recommend=false): void
    {
        $db = new Dbconnection();
        if(!$recommend)
            $all = $db->fetch('CALL getCategories()', true);
            else $all = $db->fetch('CALL getUnverifiedCategories()', true);
            echo "<div class='table-responsive m-t' id='table'>";
            echo "<table class='table table-hover'>";
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th>title</th>";
           if(!$recommend)echo "<th></th>";
            echo "<th></th>";
            echo "<th></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($all as $a) {
                echo "<tr class='bg-info'>";
                echo "<td>" . $a['title'] . "</td>";
                if(!$recommend){
                echo "<td><button class='btn btn-success' onclick='goTo(\"pages/category/subcategory.php?id=" . $a['id'] . "\")'>EDIT SUBCATEGORIES</button></td>";
                echo "<td><button class='btn btn-success' onclick='goTo(\"pages/category/update-category.php?id=" . $a['id'] . "\")'>UPDATE</button></td>";
                }else echo "<td><button class='btn btn-success'   onclick='verifyCategory(" . $a['id'] . ")'>VERIFY</button></td>";
                echo "<td><button class='btn btn-danger'   onclick='deleteCategory(" . $a['id'] . ")'>DELETE</button></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table></div>";
        } 
        public function printCategoryUpdate(int $id=0):void{
            $db=new Dbconnection();
            $a = $db->fetch('CALL getCategory(' . $id . ')');
?>
            <div class="container col-6 col-6-sm m-t" >
                <div class="container col-12 strip">
                    <h1 class="text-center">Update category</h1>
                </div>
                <form id='form' action="handlers/category/update-category.php" method="POST">
                    <div class="form-group text-center">
                        <input type="hidden" value='<?php echo $a['id']; ?>' placeholder="Id" class='form-control col-3 mx-auto' name="id" id="id">
                    </div>
                    <div class="form-group text-center">
                        <p class="text-center">Title<b class="text-danger">*</b></p>
                        <input type="text" value='<?php echo $a['title']; ?>' placeholder="Title" class='form-control col-3 mx-auto' name="title" id="title" required>
                    </div>
                    <input type='hidden' name='id1' value='<?php echo $id; ?>'>
                    <div class="form-group text-center">
                        <input type="button" class='m-b btn btn-primary' id="btnSubmit" name='btnSubmit' value="Update" onclick='submitForm()'>
                    </div>
                </form>
            </div>
        <?php
        }
    public function printSubcategories(bool $recommend=false): void
    {
        $db = new Dbconnection();
        if(!$recommend)
            $all = $db->fetch('CALL getSubcategories(' . $this->id . ')', true);
            else $all = $db->fetch('CALL getUnverifiedSubcategories()', true);
            echo "<div class='table-responsive m-t' id='table'>";
            echo "<table class='table table-hover'>";
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th>title</th>";
            if($recommend)echo "<th>category</th>";
            echo "<th></th>";
            echo "<th></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($all as $a) {
                echo "<tr class='bg-info'>";
                echo "<td>" . $a['title'] . "</td>";
                if($recommend)  echo "<td>" .$db->fetch( 'CALL getCategory('.$a['category_id'].')' )['title']. "</td>";
                if(!$recommend)
                echo "<td><button class='btn btn-success' onclick='goTo(\"pages/category/update-subcategory.php?id=" . $a['id'] . "&id1=" . $this->id . "\")'>UPDATE</button></td>";
                else echo "<td><button class='btn btn-success'   onclick='verifySubcategory(" . $a['id'] . ")'>VERIFY</button></td>";
                if($recommend)$b='2'; else $b='1';
                echo "<td><button class='btn btn-danger'   onclick='deleteSubcategory(" . $a['id'] . ",".$b.")'>DELETE</button></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table></div>";
        } 
       public function printUpdateSubcategory(int $id=0):void{
            $db=new Dbconnection();
            $a = $db->fetch('CALL getSubcategory(' . $id . ')');
        ?>
            <div class="container col-6 col-6-sm m-t">
                <div class="container col-12 strip">
                    <h1 class="text-center">Update subcategory</h1>
                </div>
                <form id='form' action="handlers/category/update-subcategory.php" method="POST">
                    <div class="form-group text-center">
                        <input type="hidden" value='<?php echo $a['id']; ?>' placeholder="Id" class='form-control col-3 mx-auto' name="id" id="id">
                    </div>
                    <div class="form-group text-center">
                        <p class="text-center">Title<b class="text-danger">*</b></p>
                        <input type="text" value='<?php echo $a['title']; ?>' placeholder="Title" class='form-control col-3 mx-auto' name="title" id="title" required>
                    </div>
                    <input type='hidden' name='id1' value='<?php echo $id; ?>'>
                    <input type='hidden' name='id2' value='<?php echo $this->id; ?>'>
                    <div class="form-group text-center">
                        <input type="button" class='m-b btn btn-primary' id="btnSubmit" name='btnSubmit' value="Update" onclick='submitForm()'>
                    </div>
                </form>
            </div>
        <?php
        }
        public function deleteCategory(int $id=0):void{
            $db=new Dbconnection();
            $db->execute('CALL deleteCategory("' . $id . '")');
        }
        public function deleteSubcategory(int $id=0):void{
            $db=new Dbconnection();
            $db->execute('CALL deleteSubcategory("' . $id . '")');
        }
        public function createCategory(string $title):void{
            $db=new Dbconnection();
            $db->execute('CALL createCategory("' . $title . '")');
        }
        public function createSubcategory(int $id,string $title):void{
            $db=new Dbconnection();
            $db->execute('CALL createSubcategory(' . $id . ',"' . $title . '")');
        }
        public function updateCategory(int $id,string $title,int $id1=0):void{
            if($id1==0)$id1=$this->id;
            $db=new Dbconnection();
            $db->execute('CALL updateCategory(' . $id . ',"' . $title . '",' .$id1. ')');

        }
        public function updateSubcategory(int $id,string $title,int $id1):void{
            $db=new Dbconnection();
            $db->execute('CALL updateSubcategory(' . $id . ',"' . $title . '",' . $id1. ')');
        }
        public function recommendCategory(string $title):void{
            $db=new Dbconnection();
            $db->execute('CALL addCategory("' . $title . '")');
        }
        public function recommendSubcategory(int $id,string $title):void{
            $db=new Dbconnection();
            $db->execute('CALL addSubcategory(' . $id . ',"' . $title . '")');
        }
        public function verifyCategory(int $id):void{
            $db=new Dbconnection();
            $db->execute('CALL verifyCategory(' . $id . ')');
        }
        public function verifySubcategory(int $id):void{
            $db=new Dbconnection();
            $db->execute('CALL verifySubcategory(' . $id . ')');
        }
        
}
?>