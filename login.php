<?php

include('config/db_connect.php');

session_start();

$userName = $password  = null;
$errors = array('user' => '', 'pass' => '', 'all' => '');

if (isset($_POST['submit'])) {

    if (empty($_POST['userName'])) {
        $errors['user'] = 'Hãy nhập tên đăng nhập';
    } else {
        $userName = $_POST['userName'];
    }
    if (empty($_POST['password'])) {
        $errors['pass'] = 'Hãy nhập tên đăng nhập';
    } else {
        $password = $_POST['password'];
    }



    if (!array_filter($errors)) {
        $query = "SELECT * From db_nguoidung where tendangnhap = '$userName' and matkhau = '$password'";
        $res = mysqli_query($conn, $query);
        $user = mysqli_num_rows($res);
        if ($user > 0) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['userName'] = $row['tendangnhap'];
            $_SESSION['email'] = $row['email'];
            header('Location: admin.php');
        } else {
            echo $errors['all'] = "Tên đăng nhập hoặc mật khẩu không chính xác";
            $userName = $password  = "";
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container">
    <main class="form-signin text-center">
        <form action="login.php" method="POST">
            <img class="mb-4" src="images/logo/logo.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
            <div><?php echo $errors['all'] ?></div>
            <div class="form-floating">
                <input type="text" value="<?php echo htmlspecialchars($userName) ?>" name="userName" class=" form-control" id="exampleInputPassword1" placeholder="User Name 124">
                <label>User Name</label>
            </div>
            <div><?php echo $errors['user'] ?></div>
            <div class="form-floating">
                <input type="password" value="<?php echo htmlspecialchars($password) ?>" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                <label>Password</label>
            </div>
            <div><?php echo $errors['pass'] ?></div>


            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>

        </form>
    </main>
</div>

<?php include('templates/footer.php'); ?>

</html>

</html>