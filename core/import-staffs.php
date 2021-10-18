<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

include('../config/db_connect.php');

if (isset($_POST['import-staffs']) and !empty($_FILES['file-staffs']['name'])) {
    $input_file = $_FILES['file-staffs']['tmp_name'];
    $ext = pathinfo($_FILES['file-staffs']['name'], PATHINFO_EXTENSION);

    if ('csv' == $ext) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } elseif ('xlsx' == $ext) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    } else {
        header("Location: ../admin.php?name=nguoi-dung&errors=1");
    }
    /**  Advise the Reader that we only want to load cell data  **/
    $spreadsheet = $reader->load($input_file);

    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    if (!empty($sheetData)) {
        for ($i = 1; $i < count($sheetData); $i++) { //skipping first row
            $name = $sheetData[$i][1];
            $unit_name = $sheetData[$i][2];
            $position = $sheetData[$i][3];
            $email = $sheetData[$i][4];
            $phone = $sheetData[$i][5];

            $query = "SELECT madv FROM db_donvi where tendv like '%$unit_name%'";
            $unit = mysqli_fetch_assoc(mysqli_query($conn, $query));
            $unit_id = $unit['madv'];
            $sql  = "INSERT INTO db_nhanvien (tennv, chucvu, email, sodidong, madv) values('$name','$position','$email','$phone', '$unit_id')";
            $result = mysqli_query($conn, $sql);
        }
    }
    header("Location: ../admin.php?name=nguoi-dung&errors=1");
} else {
    header("Location: ../admin.php?name=nguoi-dung&errors=1");
}
