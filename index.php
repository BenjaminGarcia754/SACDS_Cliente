<?php 
require 'Infraestructura/DonadorAPI.php';
require 'Modelo/Donador.php';

$message = ''; // Variable para almacenar el mensaje de respuesta

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Crear el objeto Donador con los datos ingresados
    $donador = new Donador();
    $donador->correo = $username;
    $donador->contrasena = $password;

    // Llamar al método de inicio de sesión
    $donadorAPI = new DonadorAPI();
    $result = $donadorAPI->IniciarSesion($donador);

    // Verificar el estado de la respuesta y construir el mensaje
    if ($result['status'] === 200) {
        $message = "<div class='alert alert-success'>Inicio de sesión exitoso: " . $result['data']['mensaje'] . "</div>";
    } elseif ($result['status'] === 404) {
        $message = "<div class='alert alert-danger'>Usuario o contraseña incorrectos.</div>";
    } else {
        $message = "<div class='alert alert-warning'>Ocurrió un error: " . $result['data'] . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center mt-5">Iniciar Sesión</h2>
            <?php echo $message; // Mostrar el mensaje de respuesta aquí ?>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="username">Correo</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>


