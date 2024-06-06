<?php
include './header.php';
require_once '../src/Database.php';


if (isset($_POST['submit'])) {

    $error = '';
    if (strlen($_POST['old-pass']) < 1) {
        $error = "please enter old password";
    } else if (strlen($_POST['new-pass']) < 1) {
        $error = "please enter new password";
    } else if (strlen($_POST['confirm-pass']) < 1) {
        $error = "please enter confirm password";
    } else if ($_POST['old-pass'] == $_POST['new-pass']) {
        $error = "new password cannot be same with old password";
    } else {

        $oldPass = $db->real_escape_string($_POST['old-pass']);
        $newPass = $db->real_escape_string($_POST['new-pass']);
        $password = password_hash($newPass, PASSWORD_DEFAULT);
        $query = "SELECT password FROM users WHERE id = '1'";
        $res = $db->query($query);
        $user = $res->fetch_object();
        if ($oldPass == password_verify($oldPass, $user->password)) {
            $sql = "UPDATE `users` SET `password`='$password' WHERE `id` = '1'";
            $res = $db->query($sql);
            if ($res) {
                $msg = "password change successfully";
            }
        } else {
            $error = "you have entered wrong old password";
        }

    }
}

?>


<ol class="breadcrumb" style="margin-top:-16px">
    <li class="breadcrumb-item">
        <a href="./dashboard.php">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Change Admin Password
    </li>
</ol>

<div class="container-fluid">


    <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-12">
        <?php if (isset($error) && strlen($error) > 1): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
        <?php endif?>

        <?php if (isset($msg) && strlen($msg) > 1): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $msg; ?>
        </div>
        <?php endif?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label>old password</label>
                <input type="password" name="old-pass" class="form-control" placeholder="Enter old password">
            </div>
            <div class="form-group">
                <label>new password</label>
                <input type="password" name="new-pass" class="form-control" placeholder="Enternew password">
            </div>
            <div class="form-group">
                <label>confirm password</label>
                <input type="password" name="confirm-pass" class="form-control" placeholder="Enter confirm password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>

        </form>

    </div>

</div>

<?php
include './footer.php';
?>