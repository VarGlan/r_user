<?php
$conexion= mysqli_connect("localhost", "root", "", "r_user");

if(isset($_POST['registrar'])){

    if(strlen($_POST['nombre']) >=1 && strlen($_POST['correo'])  >=1 && strlen($_POST['telefono'])  >=1 
    && strlen($_POST['password'])  >=1 && strlen($_POST['rol']) >= 1 ){

    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $password = trim($_POST['password']);
    $rol = trim($_POST['rol']);
    
    // Cifrar la contraseña ingresada por el usuario para utilizarla como clave secreta
    $clave_secreta = password_hash($password, PASSWORD_DEFAULT);

    // Definir la clave secreta en MySQL
    $consulta = "SET @clave = '$clave_secreta';";
    mysqli_query($conexion, $consulta);

    // Insertar la fila en la tabla user
    $consulta = "INSERT INTO user (nombre, correo, telefono, password, rol)
    VALUES ('$nombre', '$correo','$telefono', AES_ENCRYPT('$password', @clave), '$rol' )";

    mysqli_query($conexion, $consulta);
    mysqli_close($conexion);

    header('Location: ../views/user.php');
  }
}
?>
