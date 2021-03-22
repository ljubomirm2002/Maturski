<?php

declare(strict_types=1);

namespace Controllers;

require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");

use Controllers\Dbconnection;

final class User
{
    public $id = 0;
    public $role_id = 0;
    public $password = "";
    function __construct(int $id = 0)
    {
        ob_start();
        $db = new Dbconnection();
        $this->id = $id;
        $role_id = $db->fetch('CALL getUser(' . $this->id . ')');
        $this->password = $role_id['password'];
        $role_id = $role_id['role_id'];
        $this->role_id = $role_id;
    }
    public function checkUser(string $username, string $password)
    {
        $db = new Dbconnection();
        $user = $db->fetch("CALL checkUser('" . $username . "','" . $password . "')");
        if ($user) return intval($user['id']);
        return false;
    }
    public function redirectUser(bool $toIndex = true, bool $mustAdmin = false, bool $mustUser = false): void
    {
        if ($toIndex) {
            if (!isset($_SESSION['id']) || ($mustAdmin && !$this->isAdmin()) || ($mustUser && $this->isAdmin())) {
                header("Location: /Maturski/index.php");
                ob_end_flush();
            }
        } else {
            if (isset($_SESSION['id'])) {
                header("Location: /Maturski/pages/home.php");
                ob_end_flush();
            }
        }
    }
    public function welcome(): void
    {
        $db = new Dbconnection();
        $name = $db->fetch('CALL getUser(' . $this->id . ')')['name'];
        echo "<div class='container col-12 m-t'>";
        echo '<h1 class="strip">WELCOME ' . $name . '</h1>';
        echo "</div>";
    }
    public function isAdmin(): bool
    {
        if ($this->role_id == 1)
            return true;
        else return false;
    }
    function printUsers(): void
    {
        $db = new Dbconnection();
        $all = $db->fetch('CALL getUsers()', true);
        echo "<div class='table-responsive' id='table'>";
        echo "<table class='table table-hover'>";
        echo "<thead class='thead-dark'>";
        echo "<tr>";
        echo "<th>name</th>";
        echo "<th>username</th>";
        echo "<th>password</th>";
        echo "<th>email</th>";
        echo "<th>address</th>";
        echo "<th>status</th>";
        echo "<th>biography</th>";
        echo "<th>role</th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "<th></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($all as $a) {
            if (is_null($a['deleted'])) {
                $b = "ACTIVE";
                $classname = 'bg-info';
            } else {
                $b = "INACTIVE";
                $classname = 'bg-warning';
            }
            $role = $db->fetch("CALL getRole(" . $a['role_id'] . ")");
            echo "<tr class='" . $classname . "'>";
            echo "<td>" . $a['name'] . "</td>";
            echo "<td>" . $a['username'] . "</td>";
            echo "<td>" . $a['password'] . "</td>";
            echo "<td>" . $a['email'] . "</td>";
            echo "<td>" . $a['address'] . "</td>";
            echo "<td>" . $b . "</td>";
            echo "<td>" . $a['biography'] . "</td>";
            echo "<td>" . $role['title'] . "</td>";
            echo "<td><button class='btn btn-success' onclick='goTo(\"pages/user/update-user.php?id=" . $a['id'] . "\")'>UPDATE</button></td>";
            if ($b == "INACTIVE")
                echo "<td><button class='btn btn-success'   onclick='onclickActivate(" . $a['id'] . ")'>ACTIVATE</button></td>";
            else
                echo "<td><button class='btn btn-danger'   onclick='onclickDelete(" . $a['id'] . ")'>DEACTIVATE</button></td>";
            echo "<td><button class='btn btn-danger'   onclick='deleteUser(" . $a['id'] . ")'>DELETE</button></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table></div>";
    }
    function printUpdateUser(int $id = 0): void
    {
        $db = new Dbconnection();
        if ($id == 0) $id = $this->id;
        $user = $db->fetch("CALL getUser(" . $id . ")");
?>
        <div class="container col-6 col-6-sm m-t">
            <div class="container col-12 strip">
                <h1 class="text-center">Update user</h1>
            </div>
            <form id='form' action="handlers/user/update-user.php" method="POST">
                <?php
                if ($this->isAdmin()) {
                ?>
                    <div class="form-group text-center">
                        <input type="hidden" value="<?php echo $user['id']; ?>" placeholder="Id" class='form-control col-3 mx-auto' name="id" id="id">
                    </div>
                <?php
                }
                ?>
                <div class="form-group text-center">
                    <p class="text-center">Username<b class="text-danger">*</b></p>
                    <input type="text" value="<?php echo $user['username']; ?>" placeholder="Username" class='form-control col-3 mx-auto' name="username" id="username" required>
                </div>
                <?php
                if ($this->isAdmin()) { ?>
                    <div class="form-group text-center">
                        <p class='text-center'>Password<b class="text-danger">*</b></p>
                        <input type="text" value="<?php echo $user['password']; ?>" placeholder="Password" class='form-control col-3 mx-auto' name="password" id="password" required>
                    </div>
                <?php } else { ?>
                    <div class="form-group text-center">
                        <p class='text-center'>Password<b class="text-danger">*</b></p>
                        <input type="password" value="<?php echo $user['password']; ?>" placeholder="Password" class='form-control col-3 mx-auto' name="password" id="password" required>
                    </div>
                    <div class="form-group text-center">
                        <p class='text-center'>Confirm password<b class="text-danger">*</b></p>
                        <input type="password" placeholder="Password" class='form-control col-3 mx-auto' name="confirm" id="confirm" required>
                    </div>
                <?php } ?>
                <div class="form-group text-center">
                    <p class="text-center">Name<b class="text-danger">*</b></p>
                    <input type="text" value="<?php echo $user['name']; ?>" placeholder="Name" class='form-control col-3 mx-auto' name="name" id="name" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Email<b class="text-danger">*</b></p>
                    <input type="email" value="<?php echo $user['email']; ?>" placeholder="Email" class='form-control col-5 mx-auto' name="email" id="email" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Address<b class="text-danger">*</b></p>
                    <input type="text" value="<?php echo $user['address']; ?>" placeholder="Address" class='form-control col-5 mx-auto' name="address" id="address" required>
                </div>
                <div class="form-group text-center">
                    <p class="text-center">Biography</p>
                    <textarea placeholder="Biography" name="biography" id="biography" class='mx-auto form-control col-7'><?php echo $user['biography']; ?></textarea>
                </div>
                <?php
                if ($this->isAdmin()) {
                ?>
                    <div class="form-group text-center">
                        <p class="text-center">Role<b class="text-danger">*</b></p>
                        <select class='form-control col-3 mx-auto' name="role" id="role">
                            <?php
                            $s = $db->fetch('CALL getRoles()', true);
                            foreach ($s as $a) {
                                $b = "<option value='" . $a['id'] . "' ";
                                if ($user['role_id'] == $a['id']) $b .= 'selected';
                                $b .= " >" . $a['title'] . "</option>";
                                echo $b;
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <p class="text-center">Deleted</p>
                        <select class='form-control col-3 mx-auto' name="deleted" id="deleted">
                            <?php
                            $s = $db->fetch('CALL getUser(' . $a['id'] . ')', true);
                            if (is_null($s['deleted'])) {
                                $b = "<option value='NULL' selected>ACTIVE</option>";
                                echo $b;
                                $b = "<option value='1'>DELETED</option>";
                                echo $b;
                            } else {
                                $b = "<option value='NULL'>ACTIVE</option>";
                                echo $b;
                                $b = "<option value='1' selected>DELETED</option>";
                                echo $b;
                            }
                            ?>
                        </select>
                    </div>
                <?php } ?>
                <input type="hidden" name="id1" value="<?php echo $id; ?>">
                <div class="form-group text-center">
                    <input type="button" class='m-b btn btn-primary' id="btnSubmit" name='btnSubmit' value="Update" onclick='submitForm()'>
                </div>
            </form>
        </div>
<?php
    }
    function hide(): void
    {
        $db = new Dbconnection();
        $db->execute('CALL hideUser(' . $this->id . ')');
    }
    function getUser(int $id = 0)
    {
        $db = new Dbconnection();
        if ($id == 0) $id = $this->id;
        return $db->fetch('CALL getUser(' . $id . ')');
    }
    public function activateUser(int $id = 0): void
    {
        $db = new Dbconnection();
        if ($id == 0) $id = $this->id;
        $db->execute('CALL activateUser(' . $id . ')');
    }
    public function updatePassword(string $new, int $id = 0): void
    {
        $db = new Dbconnection();
        if ($id == 0) $id = $this->id;
        $db->execute('CALL updatePassword("' . $new . '",' . $id . ')');
    }
    public function deactivateUser(int $id = 0): bool
    {
        $db = new Dbconnection();
        if ($id == 0) $id = $this->id;
        $db->execute('CALL hideUser(' . $id . ')');
        if ($this->id == $id) {
            unset($_SESSION['id']);
            return true;
        }
        return false;
    }
    public function deleteUser(int $id = 0): bool
    {
        $db = new Dbconnection();
        if ($id == 0) $id = $this->id;
        $db->execute('CALL deleteUser(' . $id . ')');
        if ($this->id == $id) {
            unset($_SESSION['id']);
            return true;
        }
        return false;
    }
    public function checkEmail(string $s)
    {
        $db = new Dbconnection();
        return $db->fetch("CALL checkUserMail('" . $s . "')");
    }
    public function forgottenPassword(string $new, string $email): void
    {
        $db = new Dbconnection();
        $db->execute("CALL forgottenPassword('" . $new . "','" . $email . "')");
    }
    public function createUser(string $name, string $username, string $password, string $email, string $address, string $biography): void
    {
        $db = new Dbconnection();
        $query = "'" . $name . "','" . $username . "','" . $password . "','" . $email;
        $query .= "','" . $address . "','" . $biography . "'";
        $db->execute('CALL createUser(' . $query . ')');
    }
    public function updateUser(int $id, string $name, string $username, string $email, string $password, string $address, string $biography, string $deleted, int $role, int $id1): void
    {
        $db = new Dbconnection();
        $a = "CALL updateUser(" . $id . ",'" . $name . "','" . $username . "','" . $email . "','" . $password . "','";
        $a .= $address . "','" . $biography . "'," . $deleted . "," . $role . "," . $id1 . ")";
        $db->execute($a);
    }
    public function chartUser(int $id = 0): void
    {
        if ($id == 0) $id = $this->id;
        $db = new Dbconnection();
        $q = 'SELECT title AS "label",SUM(money_amount) AS "y" FROM transactions,categories WHERE type_id=2 AND category_id=categories.id AND user_id=' . $id . ' GROUP BY category_id';
        $all = $db->fetch($q, true);
        $b = "[['Category','Money amount']";
        foreach ($all as $a) {
            $b .= ",['" . $a['label'] . "'," . $a['y'] . "]";
        }
        $b .= "]";
        echo $b;
    }
    public function chartCategory(int $id=0): void
    {
        $query = 'SELECT SUM(money_amount) AS "y",subcategory_id AS "label" FROM transactions WHERE type_id=2  AND user_id=' . $_SESSION['id'] . ' AND category_id=' . $id . ' GROUP BY subcategory_id';
        $db = new Dbconnection();
        $all = $db->fetch($query, true);
        $b = "[['Subcategory','Money amount']";
        foreach ($all as $a) {
            if (!is_null($a['label'])) $a['label'] = $db->fetch('CALL getSubcategory(' . $a['label'] . ')')['title'];
            else $a['label'] = "Subcategory hasn\'t title";
            $b .= ",['" . $a['label'] . "'," . $a['y'] . "]";
        }
        $b .= "]";
        echo $b;
    }
}
?>