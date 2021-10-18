<?php
session_start();
if (!isset($_SESSION['id'])) header("Location: ../login.php");
require '../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

include('../config/db_connect.php');
$query = "SELECT nv.manv, nv.tennv, dv.tendv as tendv, nv.chucvu, nv.sodidong, nv.email, nv.image FROM db_nhanvien nv , db_donvi dv where nv.madv = dv.madv order by nv.manv";
$result = mysqli_query($conn, $query);
$staffs = mysqli_fetch_all($result, MYSQLI_ASSOC);

$numRow = 1;
$spreadsheet = new Spreadsheet();
$Excel_writer = new Xlsx($spreadsheet);
//Khởi tạo đối tượng
//Chọn trang cần ghi (là số từ 0->n)
$spreadsheet->setActiveSheetIndex(0);
$sheet = $spreadsheet->getActiveSheet();
//Tạo tiêu đề cho trang. (có thể không cần)

// Set width

$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(30);
$sheet->getColumnDimension('F')->setWidth(30);



//Tạo tiêu đề cho từng cột
//Vị trí có dạng như sau:




// thực hiện thêm dữ liệu vào từng ô bằng vòng lặp
$sheet->setCellValue('A' . $numRow, 'STT');
$sheet->setCellValue('B' . $numRow, 'Tên nhân viên');
$sheet->setCellValue('C' . $numRow, 'Tên đơn vị');
$sheet->setCellValue('D' . $numRow, 'Chức vụ');
$sheet->setCellValue('E' . $numRow, 'Email');
$sheet->setCellValue('F' . $numRow, 'Điện thoại');

foreach ($staffs as $i => $staff) {
    $numRow++;
    $sheet->setCellValue('A' . $numRow, $i + 1);
    $sheet->setCellValue('B' . $numRow, $staff['tennv']);
    $sheet->setCellValue('c' . $numRow, $staff['tendv']);
    $sheet->setCellValue('D' . $numRow, $staff['chucvu']);
    $sheet->setCellValue('E' . $numRow, $staff['email']);
    $sheet->setCellValue('F' . $numRow, $staff['sodidong']);
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


// Khởi tạo đối tượng PHPExcel_IOFactory để thực hiện ghi file
// ở đây mình lưu file dưới dạng excel2007
//Khởi tạo đối tượng writer
$filename = 'nhanvien.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$Excel_writer->save('php://output');
