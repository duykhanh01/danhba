<?php

include('config/db_connect.php');
session_start();
if (isset($_GET['id']) and $_SESSION['level'] != 0) {
    $id = $_GET['id'];
    echo $id;
    $sql = "DELETE FROM db_nhanvien where manv = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header('Location: http://localhost:3000/danhba/admin.php?name=nguoi-dung');
    } else {
        echo "Error";
    }
}
