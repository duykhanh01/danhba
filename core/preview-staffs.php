<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

include('../config/db_connect.php');

if (isset($_POST) and !empty($_FILES['file']['name'])) {
    $input_file = $_FILES['file']['tmp_name'];
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

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
    $preview = "
    
                            <thead>
                                <tr>
                                    <th scope='col'>STT</th>
                                    <th scope='col'>Họ và tên</th>
                                    <th scope='col'>Đơn vị</th>
                                    <th scope='col'>Chức vụ</th>
                                    <th scope='col'>SĐT</th>
                                    <th scope='col'>Email</th>
                                   


                                </tr>
                            </thead>
    
    ";

    if (!empty($sheetData)) {
        for ($i = 1; $i < count($sheetData); $i++) { //skipping first row
            $name = $sheetData[$i][1];
            $unit_name = $sheetData[$i][2];
            $position = $sheetData[$i][3];
            $email = $sheetData[$i][4];
            $phone = $sheetData[$i][5];

            $preview .= "
            <tbody>

                <tr>
                    <th scope='row'>$i</th>
                    <td> " . $name . "</td>
                    <td> " . $unit_name . "</td>
                    <td> " . $position . "</td>
                    <td> " . $phone . "</td>
                    <td> " . $email . "</td>

                </tr>
                               

            </tbody>
            
            ";

            if (isset($_POST['import-staffs'])) {

                $query = "SELECT madv FROM db_donvi where tendv like '%$unit_name%'";
                $unit = mysqli_fetch_assoc(mysqli_query($conn, $query));
                $unit_id = $unit['madv'];
                $sql  = "INSERT INTO db_nhanvien (tennv, chucvu, email, sodidong, madv) values('$name','$position','$email','$phone', '$unit_id')";
                $result = mysqli_query($conn, $sql);
            }
        }
    }
    echo $preview;
}
