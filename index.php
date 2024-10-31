<?php

use GuzzleHttp\Psr7\Message;

require 'Infraestructura/DonadorAPI.php';
require 'Modelo/Donador.php';
require 'Modelo/Singleton/DonadorSingleton.php';

$message = ''; // Variable para almacenar el mensaje de respuesta
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['idNuevaCuenta'])){
        $message = "<div class='alert alert-success'>Se ha creado tu cuenta exitosamente.</div>";
    }
}
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

    // Verificar el estado de la respuesta
    if ($result['status'] === 200) {
        // Crea una instancia de Donador con los datos deserializados
        $donadorTemporal = $result['donador'];
        DonadorSingleton::getInstance()->fromDonador($donadorTemporal);
        // Redirige a menuPrincipal.php si el inicio de sesión es exitoso
        header("Location: Aplicacacion/Controllers/Menu.php");
        exit();  // Asegura que se detiene el procesamiento después de la redirección
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
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="./Aplicacacion/Controllers/styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body style="background-image: url('./Aplicacacion/Controllers/Images/background.jpg');">
    <div style="background-image: url('./Aplicacacion/Controllers/Images/headerbg.avif');" class="header text-center py-4 bg-light rounded shadow">
        <h1 class="display-4 font-weight-bold text-primary">SISTEMA DE ADMINISTRACIÓN DE DONADORES DE SANGRE</h1>
        <h2 class="lead text-secondary">CENTRO DE ALTAS ESPECIALIDADES</h2>
    </div>
    <div class="bg-white p-4 rounded shadow mx-auto mt-5 mb-5 w-50" style="max-width: 500px;">
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php echo $message;?>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" class="form-control" id="username" name="username" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary mr-2 w-75">Iniciar</button>
                <a href="./Aplicacacion/Controllers/userRegistration.php" class="btn btn-outline-primary w-75 mt-4">Registrarme</a>
            </div>
        </form>
    </div>
</div>
    <footer class="bg-white py-3 mt-5">
        <div class="container text-center">
            <img src="./Aplicacacion/Controllers/Images/footerImages.png" class="img-fluid" alt="Imagen 1">
        </div>
    </footer>
    <script>
        // Función para mostrar/ocultar la contraseña de un campo específico
        function togglePassword(fieldId) {
            var passwordInput = document.getElementById(fieldId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
              
</body>
</html>
