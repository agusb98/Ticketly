<?php

if (isset($_FILES["files"])) {
  $files = $_FILES["files"];

  $name = $files["name"];
  $type = $files["type"];
  $tmp_n = $files["tmp_name"];
  $size = $files["size"];
  $src = "../files_ticket/" . $name;

  if ($size > 1024 * 1024) {
    $rta = array(
      "status" => false,
      "message" => "Error, el tamaño máximo permitido es un 1MB",
    );
  } else if (
    $type != 'image/jpg' &&
    $type != 'image/jpeg' &&
    $type != 'image/png' &&
    $type != 'image/gif' &&
    $type != 'application/pdf'
  ) {
    $rta = array(
      "status" => false,
      "message" => "Error, no es permitido este tipo de archivo",
    );
  } else {
    @move_uploaded_file($tmp_n, $src);

    $rta = array(
      "status" => true,
      "message" => $name,
    );
    echo json_encode($rta);die;
  }
}

$rta = array(
  "status" => false,
  "message" => "Error, algo inesperado ha surgido",
);

echo json_encode($rta);
