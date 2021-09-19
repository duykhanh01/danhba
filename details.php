<?php

include('config/db_connect.php');

if (isset($_POST['delete'])) {
	$id_to_delete = $_POST['id_to_delete'];
	if (!$id_to_delete) {
		header('Location: index.php');
		exit;
	}


	$query = "DELETE from pizzas where id = :id_to_delete";
	$statement = $pdo->prepare($query);
	$statement->bindValue(':id_to_delete', $id_to_delete);
	$statement->execute();
	header('Location: index.php');
}

// check GET request id param
if (isset($_GET['id'])) {

	$id = $_GET['id'];

	// make sql
	$sql = "SELECT id, title, email, ingredients, created_at FROM pizzas WHERE id = :id";
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $id);
	$statement->execute();
	$pizzas = $statement->fetch(PDO::FETCH_ASSOC);
	$pdo = null;
}

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<div class="container center grey-text">

	<h4><?php echo $pizzas['title']; ?></h4>
	<p>Created by <?php echo $pizzas['email']; ?></p>
	<p><?php echo date($pizzas['created_at']); ?></p>
	<h5>Ingredients:</h5>
	<p><?php echo $pizzas['ingredients']; ?></p>

	<!-- DELETE FORM -->
	<form action="details.php" method="POST">
		<input type="hidden" name="id_to_delete" value="<?php echo $pizzas['id']; ?>">
		<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
	</form>
	<a href="update.php?id=<?php echo $pizzas['id'] ?>" class="btn brand z-depth-0">Update</a>

</div>

<?php include('templates/footer.php'); ?>

</html>