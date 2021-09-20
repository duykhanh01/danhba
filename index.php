<?php


session_start();

include('config/db_connect.php');
$sql = "SELECT * FROM db_nhanvien, db_donvi where db_nhanvien.madv = db_donvi.madv";
$res = mysqli_query($conn, $sql);

$phoneBooks = mysqli_fetch_all($res, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<div class="main">
	<div class="container">
		<div class="row">
			<div class="col-3 bg-light">
				<div class="treeview-animated mr-4 my-4">
					<ul class="treeview-animated-list mb-3">
						<li class="treeview-animated-items">
							<a class="closed">
								<i class="fas fa-angle-right"></i>
								<span><i class="far fa-folder-open ic-w mx-1"></i>Khoa Công nghệ thông tin</span>
							</a>
							<ul class="nested">
								<li>
									<div class="treeview-animated-element "><i class="far fa-folder-open ic-w mx-1"></i>Bộ môn HTTT
								</li>
								<li>
									<div class="treeview-animated-element "><i class="far fa-folder-open ic-w mx-1"></i>Bộ môn mạng máy tính
								</li>
							</ul>
						</li>
						<li class="treeview-animated-items">
							<a class="closed">
								<i class="fas fa-angle-right"></i>
								<span><i class="far fa-folder-open ic-w mx-1"></i>Khoa Kinh tế</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-9 bg-body">
				<table class="table table-striped table-hover my-3">
					<thead>
						<tr>
							<th scope="col">Mã nhân viên</th>
							<th scope="col">Họ và tên</th>
							<th scope="col">Đơn vị</th>
							<th scope="col">Chức vụ</th>
							<th scope="col">SĐT</th>
							<th scope="col">Email</th>
						</tr>
					</thead>
					<tbody>
						<?php if (mysqli_num_rows($res)) : ?>
							<?php foreach ($phoneBooks as $phoneBook) : ?>
								<tr>
									<th scope="row"><?php echo $phoneBook['manv']; ?></th>
									<td><?php echo $phoneBook['tennv']; ?></td>
									<td><?php echo $phoneBook['tendv']; ?></td>
									<td><?php echo $phoneBook['chucvu']; ?></td>
									<td><?php echo $phoneBook['sodidong']; ?></td>
									<td><?php echo $phoneBook['email']; ?></td>

								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>




<?php include('templates/footer.php'); ?>

</html>