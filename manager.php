<?php

session_start();
include('config/db_connect.php');

$sql = 'SELECT * from db_nguoidung';
$res = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($res, MYSQLI_ASSOC);


// Edit user


?>



<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="register.php" class="btn btn-success my-2">Thêm người dùng</a>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">User name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $i => $user) : ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1; ?></th>
                            <td><?php echo $user['tendangnhap']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><a class="text-primary" href="edituser.php?id=<?php echo $user['mand']; ?> "><i class="fas fa-edit "></i></a></td>
                            <td><a class="text-danger" href="edituser.php?id=<?php echo $user['mand']; ?>"><i class="fas fa-trash"></i></a></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>



    </div>
</div>

<?php include('templates/footer.php'); ?>