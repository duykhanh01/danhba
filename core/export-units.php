<?php
session_start();

if (!isset($_SESSION['id'])) header("Location: ../login.php");

require '../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

include('../config/db_connect.php');
$sql = 'SELECT * FROM db_donvi';
$res = mysqli_query($conn, $sql);
$units = mysqli_fetch_all($res, MYSQLI_ASSOC);


//Khởi tạo đối tượng
$spreadsheet = new Spreadsheet();
$Excel_writer = new Xlsx($spreadsheet);
//Chọn trang cần ghi (là số từ 0->n)
$spreadsheet->setActiveSheetIndex(0);
$sheet = $spreadsheet->getActiveSheet();
//Tạo tiêu đề cho trang. (có thể không cần)
$sheet->setTitle('Danh bạ đơn vị');





$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(30);
$sheet->getColumnDimension('F')->setWidth(30);


//Tạo tiêu đề cho từng cột
//Vị trí có dạng như sau:



$sheet->setCellValue('A1', 'STT');
$sheet->setCellValue('B1', 'Tên đơn vị');
$sheet->setCellValue('C1', 'Địa chỉ');
$sheet->setCellValue('D1', 'Email');
$sheet->setCellValue('E1', 'Website');
$sheet->setCellValue('F1', 'Điện thoại');



// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
// dòng bắt đầu = 2
$numRow = 2;
foreach ($units as $i => $unit) {
    $sheet->setCellValue('A' . $numRow, $i + 1);
    $sheet->setCellValue('B' . $numRow, $unit['tendv']);
    $sheet->setCellValue('C' . $numRow, $unit['diachi']);
    $sheet->setCellValue('D' . $numRow, $unit['email']);
    $sheet->setCellValue('E' . $numRow, $unit['website']);
    $sheet->setCellValue('F' . $numRow, $unit['dienthoai']);

    $numRow++;
}

//Xét in đậm cho khoảng cột
$sheet->getStyle('A1:F1')->getFont()->setBold(true);
// $styleArray = [
//     'borders' => [
//         'allBorders' => [
//             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK
//         ],
//     ],
// ];


// $sheet->getStyle('A1:' . 'G' . ($numRow + 1))->applyFromArray($styleArray);
// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
// ở đây mình lưu file dưới dạng excel2007
//Khởi tạo đối tượng writer
$filename = 'donvi.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');
