<?php

include('config/db_connect.php');
session_start();
if (isset($_GET['id']) and $_SESSION['level'] != 0) {
    $id = $_GET['id'];
    $sql = "DELETE FROM db_donvi where madv = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header('Location: admin.php');
    } else {
        echo "Error";
    }
}
