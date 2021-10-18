<?php

include('config/db_connect.php');
session_start();
if (!isset($_GET['id']) and $_SESSION['id'] == 2) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users where userid = '$id'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        header('Location: manager.php');
    } else {
        echo "Error";
    }
} else {
    header('Location: index.php');
}
