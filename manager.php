<?php

session_start();
include('config/db_connect.php');

$sql = 'SELECT * from users';
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
            <table class="table table-bordered ">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Registration Date</th>
                        <th scope="col">Change Password</th>
                        <th scope="col">Delete</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $i => $user) : ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1; ?></th>
                            <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['registration_date']; ?></td>
                            <td><a class="text-primary" href="edituser.php?id=<?php echo $user['userid']; ?>"><i class="fas fa-edit "></i></a></td>
                            <?php if ($user['user_level'] == 1) : ?>
                                <td><a class="text-danger" href="deleteUser.php?id=<?php echo $user['userid']; ?>"><i class="fas fa-trash"></i></a></td>
                            <?php else : ?>
                                <td><a class="text-muted"><i class="fas fa-trash"></i></a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>



    </div>
</div>

<?php include('templates/footer.php'); ?>