<?php
session_start();
include '../includes/conexion.php';

header('Content-Type: application/json'); // Importante para que fetch interprete como JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            // Guardamos datos de sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol']; // <- Asegúrate que tu tabla tenga el campo 'rol'

            echo json_encode([
                "status" => "success",
                "rol" => $usuario['rol']
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Contraseña incorrecta."
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Usuario no encontrado."
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido."
    ]);
}
?>
