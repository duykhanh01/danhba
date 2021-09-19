<?php
include('config/db_connect.php');

$errors = array('email' => '', 'title' => '', 'ingredients' => '', 'fileName' => '');

// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';

// lay id
if (isset($_GET['id'])) {

    $id = $_GET['id'];
    // make sql
    $sql = "SELECT * FROM pizzas WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $pizzas = $statement->fetch(PDO::FETCH_ASSOC);
}

$email = $pizzas['email'];
$title = $pizzas['title'];
$ingredients = $pizzas['ingredients'];

// thuc hien update
if (isset($_POST['submit'])) {

    // check email
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        }
    }

    // check title
    if (empty($_POST['title'])) {
        $errors['title'] = 'A title is required';
    } else {
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = 'Title must be letters and spaces only';
        }
    }

    // check ingredients
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'At least one ingredient is required';
    } else {
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors['ingredients'] = 'Ingredients must be a comma separated list';
        }
    }


    if (empty($_POST['fileName'])) {
        $errors['fileName'] = 'img is not null';
    } else {
        $image = $_FILES['image'] ?? null;
        $imagePath = $pizzas['image'];
        if ($pizzas['image']) {
            unlink($pizzas['image']);
        }
        if ($image && $image['tmp_name']) {
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
    }
    if (!is_dir('images')) {
        mkdir('images');
    }

    if (array_filter($errors)) {
        echo 'errors in form';
    } else {
        $query = "UPDATE pizzas SET title =:title,ingredients =:ingredients,email=:email,image=:image where id =:id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':id',  $id);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':ingredients', $ingredients);
        $statement->bindValue(':image', $imagePath);
        $statement->execute();
        header('Location: index.php');

        // escape sql chars
        // $email = mysqli_real_escape_string($conn, $_POST['email']);
        // $title = mysqli_real_escape_string($conn, $_POST['title']);
        // $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        // // create sql
        // $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

        // // save to db and check
        // if (mysqli_query($conn, $sql)) {
        // 	// success
        // 	header('Location: index.php');
        // } else {
        // 	echo 'query error: ' . mysqli_error($conn);
        // }
    }
} // end POST check

// random để tạo tên folder ngẫu nhiên
function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        # code...
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}



?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Update <?php echo $pizzas['title'] ?></h4>
    <form class="white" method="POST" enctype="multipart/form-data">
        <?php if ($pizzas['image']) : ?>
            <img src=" <?php echo $pizzas['image']; ?> " class="pizza" alt="">
        <?php endif; ?>
        <label>Your Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>
        <label>Pizza Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['title']; ?></div>
        <label>Ingredients (comma separated)</label>
        <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
        <div class="red-text"><?php echo $errors['ingredients']; ?></div>
        <div class="file-field input-field">
            <div class="btn">
                <span>File</span>
                <input type="file" name="image">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" name="fileName" type="text">
            </div>
            <div class="red-text"><?php echo $errors['fileName']; ?></div>
        </div>
        <div class="center">
            <input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php'); ?>

</html>