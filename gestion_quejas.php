<?php
session_start();

// Verificar si el usuario es recepcionista
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'recepcionista') {
    echo "Acceso denegado.";
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "barberia");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener quejas y sugerencias
$sql_quejas = "SELECT * FROM quejas";
$result = $conexion->query($sql_quejas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Quejas y Sugerencias</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al CSS -->
</head>
<body>
    <div class="container">
        <h1>Gestión de Quejas y Sugerencias</h1>
        <h2>Quejas y Sugerencias</h2>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row['comentario']) . " 
                    <form style='display:inline;' action='eliminar_queja.php' method='POST'>
                        <input type='hidden' name='id_queja' value='" . $row['id_queja'] . "'>
                        <button type='submit'>Eliminar</button>
                    </form></li>";
                }
            } else {
                echo "<li>No hay quejas ni sugerencias.</li>";
            }
            ?>
        </ul>
        <a href="menu_recepcionista.php">Regresar al menú</a>
    </div>
</body>
</html>

<?php
$conexion->close();
?>