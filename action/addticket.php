<?php
session_start();
/*Inicia validacion del lado del servidor*/
if (empty($_POST['title'])) {
	$errors[] = "Titulo vacío";
} else if (empty($_POST['description'])) {
	$errors[] = "Description vacío";
} else if (
	!empty($_POST['title']) &&
	!empty($_POST['description'])
) {
	include "../config/config.php"; //Contiene funcion que conecta a la base de datos

	$title = $_POST["title"];
	$description = $_POST["description"];
	$category_id = $_POST["category_id"];
	$project_id = $_POST["project_id"];
	$priority_id = $_POST["priority_id"];
	$user_id = $_SESSION["user_id"];
	$status_id = $_POST["status_id"];
	$kind_id = $_POST["kind_id"];
	$created_at = "NOW()";

	if (!empty($_POST["files"])) {
		$files = $_POST["files"];
	} else {
		$files = "";
	}

	$sql = "INSERT INTO ticket (
							title,
							description,
							files,
							category_id,
							project_id,
							priority_id,
							user_id,
							status_id,
							kind_id,
							created_at
						) 
			VALUE (
				\"$title\",
				\"$description\",
				\"$files\",
				\"$category_id\",
				\"$project_id\",
				$priority_id,
				$user_id,
				$status_id,
				$kind_id,
				$created_at
			)";

	if (mysqli_query($con, $sql)) {
		$messages[] = "Tu pedido se realizó con éxito.";
	} else {
		$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
	}
} else {
	$errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
	</div>
<?php
}
if (isset($messages)) {

?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
	</div>
<?php
}

?>