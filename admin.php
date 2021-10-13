<?php



session_start();
if ($_SESSION['level'] == 0) {
    header("Location: index.php");
}


include('config/db_connect.php');

$query = "SELECT * FROM db_donvi";
$res = mysqli_query($conn, $query);
$units =  $unitsList = mysqli_fetch_all($res, MYSQLI_ASSOC);


if (isset($_GET['name'])) {
    if ($_GET['name'] === "nguoi-dung") {
        $sql = "SELECT nv.manv, nv.tennv, dv.tendv as tendv, nv.chucvu, nv.sodidong, nv.email, nv.image FROM db_nhanvien nv , db_donvi dv where nv.madv = dv.madv order by nv.manv";
        $res = mysqli_query($conn, $sql);
        $phoneBooks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $query = "SELECT * FROM db_donvi";
        $res = mysqli_query($conn, $query);
        $phoneBooks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
}
if (isset($_GET['filter_dv'])) {
    $filter = $_GET['filter_dv'];
    $query = "SELECT * FROM db_donvi where tendv like '$filter%'";
    $res = mysqli_query($conn, $query);
    $units = mysqli_fetch_all($res, MYSQLI_ASSOC);
}
if (isset($_GET['filter_staffs'])) {
    $filter = $_GET['filter_staffs'];
    $sql = "SELECT nv.manv, nv.tennv, dv.tendv, nv.chucvu, nv.sodidong, nv.email, nv.image FROM db_nhanvien nv , db_donvi dv where nv.madv = dv.madv and dv.tendv = '$filter' order by nv.manv";
    $res = mysqli_query($conn, $sql);
    $phoneBooks = mysqli_fetch_all($res, MYSQLI_ASSOC);
}


?>




<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-xl-3 col-md-12  bg-light">
            <div class="treeview-animated mr-4 my-4">
                <ul class="treeview-animated-list mb-3">
                    <li class="treeview-animated-items">
                        <a class="closed" href="#">
                            <i class="fas fa-angle-right"></i>
                            <span><i class="far fa-folder-open ic-w mx-1"></i> Danh bạ đơn vị</span>
                        </a>
                        <ul class="nested">
                            <a href="admin.php?name=<?php echo "don-vi" ?>">
                                <li>
                                    <div class=" treeview-animated-element "><i class=" far fa-folder-open ic-w mx-1"></i>Tất cả đơn vị
                                </li>
                            </a>

                            <a href="admin.php?filter_dv=<?php echo "Khoa" ?>">
                                <li>

                                    <div class=" treeview-animated-element "><i class=" far fa-folder-open ic-w mx-1"></i>Khoa
                                </li>
                            </a>
                            <a href="admin.php?filter_dv=<?php echo "Bộ môn" ?>">
                                <li>

                                    <div class="treeview-animated-element "><i class="far fa-folder-open ic-w mx-1"></i>Bộ môn
                                </li>

                            </a>
                            <a href="admin.php?filter_dv=<?php echo "Phòng ban" ?>">
                                <li>
                                    <div class="treeview-animated-element "><i class="far fa-folder-open ic-w mx-1"></i>Phòng Ban
                                </li>
                            </a>

                        </ul>
                    </li>
                    <li class="treeview-animated-items">
                        <a class="closed" href="#">
                            <i class=" fas fa-angle-right"></i>
                            <span> <i class="far fa-folder-open ic-w mx-1"></i>Danh bạ người dùng</span>
                        </a>
                        <ul class="nested">
                            <a href="admin.php?name=<?php echo "nguoi-dung" ?>">
                                <li>
                                    <div class=" treeview-animated-element "><i class=" far fa-folder-open ic-w mx-1"></i>Tất cả người dùng
                                </li>
                            </a>
                            <?php foreach ($unitsList as $unitList) : ?>
                                <a href="admin.php?filter_staffs=<?php echo $unitList['tendv'] ?> ">
                                    <li>
                                        <div class="treeview-animated-element "><i class="far fa-folder-open ic-w mx-1"></i><?php echo $unitList['tendv'] ?>
                                    </li>
                                </a>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-md-12 bg-body shadow-sm rounded">
            <!-- Hiển thị bảng đơn vị nếu không chọn hiển thị gì -->
            <?php if (isset($_GET['name']) or isset($_GET['filter_staffs'])) : ?>

                <!--  Hiển thị bảng theo người  -->
                <?php if (isset($_GET['filter_staffs']) or $_GET['name'] == "nguoi-dung") : ?>


                    <a href="addStaff.php" class="btn btn-success mt-2">Thêm danh bạ người dùng</a>
                    <div class="table-responsive">

                        <table class="table table-striped table-hover mt-3 mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Họ và tên</th>
                                    <th scope="col">Đơn vị</th>
                                    <th scope="col">Chức vụ</th>
                                    <th scope="col">SĐT</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>


                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($phoneBooks as $i => $phoneBook) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $i + 1 ?></th>
                                        <td><?php echo $phoneBook['tennv']; ?></td>
                                        <td><?php echo $phoneBook['tendv']; ?></td>
                                        <td><?php echo $phoneBook['chucvu']; ?></td>
                                        <td><?php echo $phoneBook['sodidong']; ?></td>
                                        <td><?php echo $phoneBook['email']; ?></td>

                                        <td><a class="text-primary" href="editStaff.php?id=<?php echo $phoneBook['manv']; ?>"><i class="fas fa-edit "></i></a></td>
                                        <td><a class="text-danger" href="deleteStaff.php?id=<?php echo $phoneBook['manv']; ?>"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <!-- Hiển thị bảng đơn vị -->
                <?php elseif ($_GET['name'] === "don-vi") : ?>
                    <a href="addUnit.php" class="btn btn-success mt-2">Thêm danh bạ đơn vị</a>
                    <div class="table-responsive">

                        <table class="table table-striped table-hover mt-3 mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên đơn vị</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">SĐT</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($phoneBooks as $i => $phoneBook) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $i + 1 ?></th>
                                        <td><?php echo $phoneBook['tendv']; ?></td>
                                        <td><?php echo $phoneBook['diachi']; ?></td>
                                        <td><?php echo $phoneBook['email']; ?></td>
                                        <td><?php echo $phoneBook['dienthoai']; ?></td>
                                        <td><a class="text-primary" href="editUnit.php?id=<?php echo $phoneBook['madv']; ?>"><i class="fas fa-edit "></i></a></td>
                                        <td><a class="text-danger" href="deleteUnit.php?id=<?php echo $phoneBook['madv']; ?>"><i class="fas fa-trash"></i></a></td>


                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                <?php else : header("Location: index.php"); ?>
                <?php endif; ?>

                <!-- ---------------------------------- -->
            <?php else : ?>
                <a href="addUnit.php" class="btn btn-success mt-2">Thêm danh bạ đơn vị</a>
                <div class="table-responsive">

                    <table class="table table-striped table-hover mt-3 mb-0">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên đơn vị</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Email</th>
                                <th scope="col">SĐT</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($units as $i => $unit) : ?>
                                <tr>
                                    <th scope="row"><?php echo $i + 1 ?></th>
                                    <td><?php echo $unit['tendv']; ?></td>
                                    <td><?php echo $unit['diachi']; ?></td>
                                    <td><?php echo $unit['email']; ?></td>
                                    <td><?php echo $unit['dienthoai']; ?></td>
                                    <td><a class="text-primary" href="editUnit.php?id=<?php echo $unit['madv']; ?>"><i class="fas fa-edit "></i></a></td>
                                    <td><a class="text-danger" href="deleteUnit.php?id=<?php echo $unit['madv']; ?>"><i class="fas fa-trash"></i></a></td>

                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

            <?php endif; ?>




        </div>
    </div>



</div>



<?php include('templates/footer.php'); ?>


</html>