<?php


include('../config/db_connect.php');
if (!$_SERVER['REQUEST_METHOD'] == 'POST') echo header("Location: manager.php");
$word = $_POST['search_users'];
$sql = "SELECT * FROM users where first_name like '%$word%' or last_name like '%$word%' or email like '%$word%'";
$res = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($res, MYSQLI_ASSOC);

if (mysqli_num_rows($res) > 0) {
    $output = '  <thead class="thead-dark">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Registration Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Level</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>

                        </tr>
                    </thead>';

    foreach ($users as $i => $user) {
        $stt = $i + 1;

        $status = '';
        $level = '';
        $status =  $user['status'] == 0 ? "Not Activated" : "Activated";

        switch ($user['user_level']) {
            case 0:
                $level = "User";
                break;
            case 1:
                $level = "Admin";
                break;

            case 2:
                $level = "Manager";
                break;
        };
        $output .= "
                <tbody>
                    <tr>
                        <th scope='row'> $stt</th>
                        <td>" . $user['first_name'] . ' ' . $user['last_name'] . "</td>
                        <td>" . $user['email'] . "></td>
                        <td>" . $user['registration_date'] . "</td>
                        <td>" . $status . "</td>

                        <td>" . $level . "</td>
                        <?php
                        $status = '';
                        

                        
                        <td>$status></td>

                        <td><a class='text-primary' href='user.php?id=" . $user['userid'] . "'><i class='fas fa-edit '></i></a></td>

                        <td><a class='text-danger' href='deleteUser.php?id=" . $user['userid'] . "'><i class='fas fa-trash'></i></a></td>

                    </tr>
                
            </tbody>
            ";
    }
    echo $output;
};
