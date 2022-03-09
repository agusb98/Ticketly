<?php

//upd user by abisoft https://github.com/amnersaucedososa
session_start();

if (empty($_POST['mod_name'])) {
	$errors[] = "Ingrese Nombre Completo";
} else if (empty($_POST['mod_email'])) {
	$errors[] = "Ingrese Correo";
} else if ($_POST['mod_status'] == "") {
	$errors[] = "Seleccione Estado";
} else if ($_POST['mod_kind'] == "") {
	$errors[] = "Seleccione Tipo de Usuario";
} else {
	include "../config/config.php"; //Contiene funcion que conecta a la base de datos

	$name = mysqli_real_escape_string($con, (strip_tags($_POST["mod_name"], ENT_QUOTES)));
	$email = strtolower($_POST["mod_email"]);
	$password = mysqli_real_escape_string($con, (strip_tags(sha1(md5($_POST["password"])), ENT_QUOTES)));
	$status = intval($_POST['mod_status']);
	$kind = intval($_POST['mod_kind']);
	$id = $_POST['mod_id'];

	$sql = "UPDATE user SET 
				name=\"$name\", 
				email=\"$email\", 
				is_active=$status,
				kind=$kind  
			WHERE id=$id";

	$query_update = mysqli_query($con, $sql);

	if ($query_update) {
		$messages[] = "Datos actualizados satisfactoriamente.";

		// update password by abisoft
		if ($_POST["password"] != "") {
			$update_passwd = mysqli_query($con, "update user set password=\"$password\" where id=$id");
			if ($update_passwd) {
				$messages[] = " Y la Contraseña ah sido actualizada.";
			}
		}
	} else {
		$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
	}
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