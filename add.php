<?php


include('config/db_connect.php');
$errors = array('name' => '', 'init' => '', 'posison' => '', 'phone' => '', 'email' => '');

$query = "SELECT * FROM db_donvi";
$res = mysqli_query($conn, $query);
$units = mysqli_fetch_all($res, MYSQLI_ASSOC);

if (isset($_POST['submit_staff'])) {

    if (empty($_POST['email'])) {
        $errors['email'] = 'Hãy nhập email người dùng';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }
    }

    if (empty($_POST['name'])) {
        $errors['name'] = 'Hãy nhập tên người dùng';
    } else {
        $name = $_POST['name'];
    }
    if (empty($_POST['selectInit'])) {
        $errors['init'] = 'Hãy chọn đơn vị';
    } else {
        $selectInit = $_POST['selectInit'];
    }
    if (empty($_POST['posison'])) {
        $errors['posison'] = 'Hãy chọn đơn vị';
    } else {
        $posison = $_POST['posison'];
    }
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'Hãy chọn đơn vị';
    } else {
        $phone = $_POST['phone'];
        if (is_int($phone)) {
            $errors['phone'] = 'Hãy nhập số điện thoại';
        }
    }

    if (array_filter($errors)) {
        echo 'errors in form';
    } else {
        $sql = "INSERT INTO db_nhanvien (tennv, chucvu, email, sodidong, madv) VALUES ('$name', '$posison', '$email', '$phone', '$selectInit')";
        $res = mysqli_query($conn, $sql);
        header("Location: index.php");
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="container">
    <h2 class="text-center mt-2">Thêm Nhân Viên</h2>
    <form class="form-add" method="post" action="add.php">
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Tên nhân viên</label>
            <input name="name" type="text" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="form-group  mt-2">
            <label for="exampleFormControlSelect1">Đơn vị</label>
            <select name="selectInit" class="form-select" id="exampleFormControlSelect1">
                <?php foreach ($units as $unit) : ?>
                    <option <?php if ($selectInit = $unit['madv']) echo "selected" ?> value="<?php echo $unit['madv']; ?>"> <?php echo $unit['tendv']; ?> </option>
                <?php endforeach; ?>
                <option selected="selected" value="">---Chọn Đơn vị---</option>

            </select>
        </div>
        <div class="form-group mt-2">
            <label for=" exampleFormControlInput1">Chức vụ</label>
            <input name="posison" type="text" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Số điện thoại</label>
            <input name="phone" type="text" class="form-control" id="exampleFormControlInput1">
        </div>
        <div class="form-group mt-2">
            <label for="exampleFormControlInput1">Email</label>
            <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="email">
        </div>
        <div class="text-center mt-4">
            <button name="submit_staff" type="submit" class="btn btn-primary"> Submit </button>
        </div>
    </form>
</div>
<?php include('templates/footer.php'); ?>

</html>