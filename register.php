<?php

include('config/db_connect.php');
session_start();
$userName = $pass = $cpass = $email =  '';
$errors = array('user' => '', 'pass' => '', 'email' => '', 'cpass' => '', 'all' => '');

if (isset($_POST['submit'])) {

    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }
    }

    if (empty($_POST['userName'])) {
        $errors['user'] = 'Hãy nhập tên đăng nhập';
    } else {
        $userName = $_POST['userName'];
    }
    if (empty($_POST['password'])) {
        $errors['pass'] = 'Hãy nhập tên mật khẩu';
    } else {
        $pass = $_POST['password'];
    }
    if (empty($_POST['cpassword'])) {
        $errors['cpass'] = 'Hãy nhập tên mật khẩu';
    } else {
        $cpass = $_POST['cpassword'];
        if ($cpass == $pass) {
        } else {
            $errors['cpass'] = 'Mật khẩu không khớp';
        }
    }

    if (array_filter($errors)) {
    } else {
        $query = "SELECT * FROM db_nguoidung WHERE email = '$email' and matkhau = '$pass'";
        $res = mysqli_query($conn, $query);

        $user = mysqli_num_rows($res);
        if ($user >= 1) {
            $errors['all'] = 'Tên đăng nhập hoặc email đã tồn tại';
        } else {
            $sql = "INSERT INTO db_nguoidung (tendangnhap, email, matkhau) VALUES ('$userName', '$email', '$pass')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // echo "<script> alert('Đăng ký thành công'); </script>";
                header('Location: login.php');
            } else {
                echo "Đăng ký thất bại";
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container">

    <form class="register" action="register.php" method="post">
        <div class="text-primary"> <?php echo $errors['all'] ?> </div>
        <div class="form-group">
            <label for="exampleInputUsername">Username</label>
            <input type="text" value="<?php echo htmlspecialchars($userName) ?>" name="userName" class=" form-control" id="exampleInputPassword1" placeholder="Username">
        </div>
        <div><?php echo $errors['user']; ?></div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" value="<?php echo htmlspecialchars($email) ?>" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div><?php echo $errors['email']; ?></div>

        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" value="<?php echo htmlspecialchars($pass) ?>" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div><?php echo $errors['pass']; ?></div>

        <div class="form-group">
            <label for="exampleInputConfirmPassword1">Confirm Password</label>
            <input type="password" value="<?php echo htmlspecialchars($cpass) ?>" name="cpassword" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password">
        </div>
        <div><?php echo $errors['cpass']; ?></div>
        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include('templates/footer.php'); ?>

</html>

</html>