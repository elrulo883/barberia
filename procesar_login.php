<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "barberia");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$nombre_usuario = $_POST['nombre_usuario'];
$password = $_POST['password'];

// Consulta para verificar las credenciales del usuario
$sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' AND password = MD5('$password')";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Si el usuario existe, obtener su rol
    $fila = $resultado->fetch_assoc();
    $rol = $fila['rol'];

    // Guardar el rol del usuario en la sesión
    $_SESSION['rol'] = $rol;
    
    // Redireccionar según el rol
    if ($rol == 'barbero') {
        header("Location: barbero.php");
    } elseif ($rol == 'recepcionista') {
        header("Location: recepcionista.php");
    } elseif ($rol == 'jefe') {
        header("Location: jefe.php");
    }
} else {
    // Si las credenciales son incorrectas
    echo "Usuario o contraseña incorrectos";
}

// Cerrar la conexión
$conexion->close();
?>


