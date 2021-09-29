<?php

include('config/db_connect.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM db_nguoidung where mand = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header('Location: manager.php');
    } else {
        echo "Error";
    }
}
