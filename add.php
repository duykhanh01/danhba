<?php
// include('config/db_connect.php');
// $title = $ingredients = $fileName = '';
// $errors = array('email' => '', 'title' => '', 'ingredients' => '', 'fileName' => '');

// // echo '<pre>';
// // var_dump($_FILES);
// // echo '</pre>';
// session_start();

// if (!isset($_SESSION['userName'])) {
// 	header("Location: login.php");
// }

// if (isset($_POST['submit'])) {

// 	// check title
// 	if (empty($_POST['title'])) {
// 		$errors['title'] = 'A title is required';
// 	} else {
// 		$title = $_POST['title'];
// 		if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
// 			$errors['title'] = 'Title must be letters and spaces only';
// 		}
// 	}

// 	// check ingredients
// 	if (empty($_POST['ingredients'])) {
// 		$errors['ingredients'] = 'At least one ingredient is required';
// 	} else {
// 		$ingredients = $_POST['ingredients'];
// 		if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
// 			$errors['ingredients'] = 'Ingredients must be a comma separated list';
// 		}
// 	}


// 	if (empty($_POST['fileName'])) {
// 		$errors['fileName'] = 'img is not null';
// 	} else {
// 		$image = $_FILES['image'] ?? null;
// 		$imagePath = '';
// 		if ($image) {
// 			$imagePath = 'images/' . randomString(8) . '/' . $image['name'];
// 			mkdir(dirname($imagePath));
// 			move_uploaded_file($image['tmp_name'], $imagePath);
// 		}
// 	}
// 	if (!is_dir('images')) {
// 		mkdir('images');
// 	}

// 	if (array_filter($errors)) {
// 		echo 'errors in form';
// 	} else {


// 		$query = "INSERT INTO pizzas (title,ingredients,email,image) VALUES (:title,:ingredients,:email,:image)";
// 		$statement = $pdo->prepare($query);
// 		$statement->bindValue(':title', $title);
// 		$statement->bindValue(':email', $_SESSION['email']);
// 		$statement->bindValue(':ingredients', $ingredients);
// 		$statement->bindValue(':image', $imagePath);
// 		$statement->execute();
// 		$pdo = null;
// 		header('Location: index.php');

// 		// escape sql chars
// 		// $email = mysqli_real_escape_string($conn, $_POST['email']);
// 		// $title = mysqli_real_escape_string($conn, $_POST['title']);
// 		// $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

// 		// // create sql
// 		// $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

// 		// // save to db and check
// 		// if (mysqli_query($conn, $sql)) {
// 		// 	// success
// 		// 	header('Location: index.php');
// 		// } else {
// 		// 	echo 'query error: ' . mysqli_error($conn);
// 		// }
// 	}
// } // end POST check

// // random để tạo tên folder ngẫu nhiên
// function randomString($n)
// {
// 	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// 	$str = '';
// 	for ($i = 0; $i < $n; $i++) {
// 		# code...
// 		$index = rand(0, strlen($characters) - 1);
// 		$str .= $characters[$index];
// 	}
// 	return $str;
// }

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<section class="container grey-text">
	<h4 class="center">Them Danh Ba</h4>
	<form class="white" action="add.php" method="POST" enctype="multipart/form-data">
		<label>Tên Đơn vị</label>
		<input type="text" name="name">
		<label>Email</label>
		<input type="email" name="ingredients">
		<label>Địa chỉ</label>
		<input type="text" name="ingredients">
		<label>Website</label>
		<input type="text" name="ingredients">
		<label>Điện thoại</label>
		<input type="text" name="ingredients">
		<div class="center">
			<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
		</div>
	</form>
</section>

<?php include('templates/footer.php'); ?>

</html>