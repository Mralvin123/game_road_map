<?php

// Recoger datos del formulario
$no = $_POST['nom'];
$pa = $_POST['pat'];
$ma = $_POST['mat'];
$idc = $_POST['idcurso']; // ID del curso

include "../config/database.php";
$db = conectarDB();

// Insertar datos en la tabla `estudiante`
$consulta = "INSERT INTO estudiante (nombre, paterno, materno, idcurso) VALUES ('$no', '$pa', '$ma', '$idc')";
$res = mysqli_query($db, $consulta);

if ($res) {
    echo "<script>alert('Estudiante registrado correctamente');</script>";
} else {
    echo "No se pudo registrar el estudiante";
}
?>
