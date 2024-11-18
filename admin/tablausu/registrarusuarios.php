<?php
    include "../../includes/template/header.php";
    $id=$_POST['id'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $rol=$_POST['rol'];
    $estado=$_POST['estado'];
    $id_nivel_subs=$_POST['id_nivel_subs'];

    include "../../includes/config/database.php";
    $db=conectarDB();
    $consql="INSERT INTO usuario (id,email,password,rol,estado,id_nivel_subs) values('$id','$email','$password','$rol','$estado','$id_nivel_subs')";
    $res=mysqli_query($db,$consql);
    if($res){
        echo "Registro Exitoso";
    }
    else{
        echo "Error al registrar";
    }
    include "../../includes/template/Footer.php";
?>