<?php
session_start();
/*Inicia validacion del lado del servidor*/
if (empty($_POST['name'])) {
	$errors[] = "Ingrese Nombre";
} else if (empty($_POST['kind_user'])) {
	$errors[] = "Seleccione Tipo de Usuario";
} else if (empty($_POST['lastname'])) {
	$errors[] = "Ingrese Apellidos";
} else if (empty($_POST['email'])) {
	$errors[] = "Ingrese Correo";
} else if ($_POST['status'] == "") {
	$errors[] = "Selecciona Estado";
} else if (empty($_POST['password'])) {
	$errors[] = "Ingrese Contraseña";
} else {

	include "../config/config.php"; //Contiene funcion que conecta a la base de datos

	// escaping, additionally removing everything that could be (html/javascript-) code
	$kind_user = intval($_POST['kind_user']);
	$name = mysqli_real_escape_string($con, (strip_tags($_POST["name"], ENT_QUOTES)));
	$lastname = mysqli_real_escape_string($con, (strip_tags($_POST["lastname"], ENT_QUOTES)));
	$email = strtolower($_POST["email"]);
	$password = mysqli_real_escape_string($con, (strip_tags(sha1(md5($_POST["password"])), ENT_QUOTES)));
	$status = intval($_POST['status']);
	$end_name = $name . " " . $lastname;
	$created_at = date("Y-m-d H:i:s");
	$user_id = $_SESSION['user_id'];
	$profile_pic = "default.png";

	$sql = "INSERT INTO user ( name, password, email, profile_pic, is_active, kind, created_at) 
			VALUES (
					'$end_name',
					'$password',
					'$email',
					'$profile_pic',$status,
					'$kind_user',
					'$created_at'
			)";

	$query_new_insert = mysqli_query($con, $sql);
	
	if ($query_new_insert) {
		$messages[] = "El usuario ha sido ingresado satisfactoriamente.";
	} else {
		$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
	}
}

// Notificate error messages
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

// Notificate success messages
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