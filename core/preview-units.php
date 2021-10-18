<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

include('../config/db_connect.php');
if (isset($_POST['import-units']) and !empty($_FILES['file-units']['name'])) {
    $input_file = $_FILES['file-units']['tmp_name'];
    $ext = pathinfo($_FILES['file-units']['name'], PATHINFO_EXTENSION);


    if ('csv' == $ext) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } elseif ('xlsx' == $ext) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    } else {
        header("Location: ../admin.php?errors=0");
    }
    /**  Advise the Reader that we only want to load cell data  **/
    $spreadsheet = $reader->load($input_file);

    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    if (!empty($sheetData)) {
        for ($i = 1; $i < count($sheetData); $i++) { //skipping first row
            $name = $sheetData[$i][1];
            $location = $sheetData[$i][2];
            $email = $sheetData[$i][3];
            $website = $sheetData[$i][4];
            $phone = $sheetData[$i][5];
            $sql  = "INSERT INTO db_donvi (tendv, diachi, email, website, dienthoai) values('$name','$location','$email','$website', '$phone')";
            $result = mysqli_query($conn, $sql);
        }
    }
    header("Location: ../admin.php");
} else {
    header("Location: ../admin.php?errors=1");
}
