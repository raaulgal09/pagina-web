<?php
include '../includes/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El correo ya está registrado";
    } else {
        $sql = "INSERT INTO usuarios (nombre, apellidos, correo, password) VALUES ('$nombre', '$apellidos', '$correo', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error al registrar: " . $conn->error;
        }
    }
}

$conn->close();
?>