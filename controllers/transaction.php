<?php

declare(strict_types=1);

namespace Controllers;

use DateTime;
require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
use Controllers\Dbconnection;
final class Transaction
{
    private $db;
    function __construct()
    {
        $this->db = new Dbconnection();
    }
    function printTransactions(int $id = 0): void
    {
        $all = $this->db->fetch('CALL getTransactions(' . $id . ')', true);
        echo "<div class='table-responsive' id='table'>";
        echo "<table class='table table-hover'>";
        echo "<thead class='thead-dark'>";
        echo "<tr>";
        echo "<th>money amount</th>";
        echo "<th>time</th>";
        echo "<th>description</th>";
        echo "<th>subject</th>";
        echo "<th>category</th>";
        echo "<th>subcategory</th>";
        echo "<th>type</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($all as $a) {
            if ($a['type_id'] == 1) {
                $classname = 'bg-info';
            } else {
                $classname = 'bg-warning';
            }
            $category = $this->db->fetch('CALL getCategory(' . $a['category_id'] . ')');
            $category = $category['title'];
            $subcategory = "";
            if (!is_null($a['subcategory_id'])) {
                $subcategory = $this->db->fetch('CALL getSubcategory(' . $a['subcategory_id'] . ')');
                $subcategory = $subcategory['title'];
            }
            $type = $this->db->fetch('CALL getType(' . $a['type_id'] . ')');
            $type = $type['title'];
            $date = date_create($a['time']);
            $target = $this->db->fetch('CALL getTarget(' . $a['target_id'] . ')');
            $target = $target['title'];
            echo "<tr class='" . $classname . "'>";
            echo "<td>" . $a['money_amount'] . "</td>";
            echo "<td>" . date_format($date, 'd.m.Y.') . "</td>";
            echo "<td>" . $a['description'] . "</td>";
            echo "<td>" . $target . "</td>";
            echo "<td>" . $category . "</td>";
            echo "<td>" . $subcategory . "</td>";
            echo "<td>" . $type . "</td>";
            echo "<td><button class='btn btn-success' onclick='goTo(\"pages/transaction/update-transaction.php?id=" . $a['id'] . "\")'>UPDATE</button></td>";
            echo "<td><button class='btn btn-danger'   onclick='deleteTransaction(" . $a['id'] . ")'>DELETE</button></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table></div>";
    }
    function printUpdateTransaction(int $id = 0): void
    {
        $t = $this->db->fetch('CALL getTransaction(' . $id . ')');
        $target = $this->db->fetch('CALL getTarget(' . $t['target_id'] . ')');
        $target = $target['title'];
        $category = $this->db->fetch('CALL getCategory(' . $t['category_id'] . ')');
        $category = $category['title'];
        if (is_null($t['subcategory_id'])) $subcategory = "";
        else {
            $subcategory = $this->db->fetch('CALL getSubcategory(' . $t['subcategory_id'] . ')');
            $subcategory = $subcategory['title'];
        }
?>
        <div class="container col-6 col-6-sm m-t">
            <div class="container col-12 strip">
                <h1 class="text-center">Update transaction</h1>
            </div>
            <form id='form' action="handlers/transaction/update-transaction.php" method="POST">
                <div class="form-group text-center">
                    <p class="text-center">Type<b class="text-danger">*</b></p>
                    <select class='form-control col-3 mx-auto' name="type" id="type">
                        <?php
                        $all = $this->db->fetch('CALL getTypes()', true);
                        foreach ($all as $a) {
                            $b = "";
                            if ($a['id'] == $t['type_id']) $b = 'selected';
                            echo "<option value='" . $a['id'] . "'" . $b . ">" . $a['title'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Money amount<b class="text-danger">*</b></p>
                    <input type="number" value="<?php echo $t['money_amount']; ?>" placeholder="Money amount" class='form-control col-3 mx-auto' name="money_amount" id="money_amount" required>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Date<b class="text-danger">*</b></p>
                    <input type="date" value='<?php echo $t['time']; ?>' placeholder="Date" class='form-control col-3 mx-auto' name="date" id="date" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Description</p>
                    <textarea placeholder="Description" name="description" id="description" class='mx-auto form-control col-7'><?php echo $t['description']; ?></textarea>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Subject<b class="text-danger">*</b></p>
                    <input type="text" autocomplete="off" value='<?php echo $target; ?>' list='target_list' placeholder="Subject" class='form-control col-3 mx-auto' name="target" id="target" required>

                    <datalist id="target_list">
                        <?php $all = $this->db->fetch('CALL getTargets()', true);
                        foreach ($all as $a) {
                            echo "<option value='" . $a['title'] . "'>";
                        } ?>
                    </datalist>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Category<b class="text-danger">*</b></p>
                    <select class='form-control col-3 mx-auto' name="category" id="category" onchange='readSubcategory("<?php if (isset($subcategory)) echo $subcategory; else echo "NULL";?>")'>
                        <?php $all = $this->db->fetch('CALL getCategories()', true);
                        foreach ($all as $a) {
                            $b = "";
                            if ($a['title'] == $category) $b = 'selected';
                            echo "<option value='" . $a['id'] . "'" . $b . ">" . $a['title'] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Subcategory</p>
                    <select class='form-control col-3 mx-auto' name="subcategory" id="subcategory">
                    </select>
                    <script>
                        readSubcategory("<?php if (isset($subcategory)) echo $subcategory; else echo "NULL"; ?>");
                    </script>
                </div>
                <input type="hidden" name="id" value='<?php echo $id; ?>'>
                <div class="form-group text-center">
                    <input type="button" class='m-b btn btn-primary' id="btnSubmit" name='btnSubmit' value="Update" onclick='submitForm()'>
                </div>
            </form>
        </div>
    <?php }
    function createTransaction(): void
    {
        $date = new DateTime('now');
        $date = $date->format('Y-m-d');
    ?>
        <div class="container col-6 col-6-sm m-t">
            <div class="container col-12 strip">
                <h1 class="text-center">Create transaction</h1>
            </div>
            <form id='form' action="handlers/transaction/new-transaction.php" method="POST">
                <div class="form-group text-center">
                    <p class="text-center">Type<b class="text-danger">*</b></p>
                    <select class='form-control col-3 mx-auto' name="type" id="type">
                        <?php
                        $all = $this->db->fetch('CALL getTypes()', true);
                        foreach ($all as $a) {
                            echo "<option value='" . $a['id'] . "'>" . $a['title'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Money amount<b class="text-danger">*</b></p>
                    <input type="number" placeholder="Money amount" class='form-control col-3 mx-auto' name="money_amount" id="money_amount" required>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Date<b class="text-danger">*</b></p>
                    <input type="date" value='<?php echo $date; ?>' placeholder="Date" class='form-control col-3 mx-auto' name="date" id="date" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Description</p>
                    <textarea placeholder="Description" name="description" id="description" class='mx-auto form-control col-7'></textarea>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Subject<b class="text-danger">*</b></p>
                    <input type="text" list='target_list' placeholder="Subject" class='form-control col-3 mx-auto' name="target" id="target" required>

                    <datalist id="target_list">
                        <?php $all = $this->db->fetch('CALL getTargets()', true);
                        foreach ($all as $a) {
                            echo "<option value='" . $a['title'] . "'>";
                        } ?>
                    </datalist>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Category<b class="text-danger">*</b></p>
                    <select class='form-control col-3 mx-auto' name="category" id="category" onchange='readSubcategory("")'>
                        <?php $all = $this->db->fetch('CALL getCategories()', true);
                        foreach ($all as $a) {
                            echo "<option value='" . $a['id'] . "'>" . $a['title'] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <p class='text-center'>Subcategory</p>
                    <select class='form-control col-3 mx-auto' name="subcategory" id="subcategory">
                    </select>
                    <script>
                        readSubcategory("");
                    </script>
                </div>
                <div class="form-group text-center">
                    <input type="button" class='m-b btn btn-primary' id="btnSubmit" name='btnSubmit' value="Create" onclick='submitForm()'>
                </div>
            </form>
        </div>
<?php
    }
    public function deleteTransaction(int $id = 0): void
    {
        $db = new Dbconnection();
        $db->execute('CALL deleteTransaction(' . $id . ')');
    }
    public function insertTransaction(int $money_amount,string $date,string $description,string $target,int $category,string $subcategory,int $type):void{
        $target = $this->db->fetch('CALL getTargetId("' . $target . '")');
$target = $target['id'];
if (!$subcategory) $subcategory = "NULL";
$a = 'CALL createTransaction(' . $money_amount . ",'" . $date . "','" . $description . "'," . $target;
$a .= "," . $category . "," . $subcategory . "," . $type . "," . $_SESSION['id'] . ")";
$this->db->execute($a);
    }
    public function updateTransaction(int $money_amount,string $date,string $description,string $target,int $category,string $subcategory,int $type,int $id):void{
        $target = $this->db->fetch('CALL getTargetId("' . $target . '")');
$target = $target['id'];
$a = 'CALL updateTransaction(' . $money_amount . ",'" . $date . "','" . $description . "'," . $target;
$a .= "," . $category . "," . $subcategory . "," . $type . "," . $_SESSION['id'] .",".$id. ")";
$this->db->execute($a);
    }
}
?>