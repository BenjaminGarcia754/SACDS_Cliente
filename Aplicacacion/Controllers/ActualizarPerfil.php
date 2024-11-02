<?php
session_start();
if(!isset($_SESSION['idDonador'])){
    header('Location: ../../index.php');
}

use GuzzleHttp\Psr7\Message;
require './../../Infraestructura/DonadorAPI.php';
require './../../Modelo/Donador.php';
require './../../Modelo/Singleton/DonadorSingleton.php';

$message = ''; // Variable para almacenar el mensaje de respuesta

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Crear el objeto Donador con los datos ingresados
    $donador = new Donador();
    // Llamar al método de registrar donador
    $donadorAPI = new DonadorAPI();
    $emailExists = false;
    if(isset($_POST['email']) && $_POST['email']!=null){
        $email = $_POST['email'];
        $donador->correo = $email;
        
        $emailExists = $donadorAPI->VerificarCorreo($email);
    }
    if(isset($_POST['password']) && $_POST['password']!=null){
        $password = $_POST['password'];
        $donador->contrasena = $password;
    }
    


    if($emailExists){
        $message = "<div class='alert alert-warning'>El correo ya esta asociado a otra cuenta.</div>";
    }
    else{
        $id = $_SESSION['idDonador'];
        $donador->id = $id;
        $result = $donadorAPI->actualizarDonador($id, $donador);
        if($result == 204){
            $message = "<div class='alert alert-success'>Se ha actualizado el perfil.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donaciones urgentes</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body style="background-image: url('./Images/background.jpg');">
    <div style="background-image: url('./Images/headerbg.avif');" class="header text-center py-4 bg-light rounded shadow">
        <h1 class="display-4 font-weight-bold text-primary">SISTEMA DE ADMINISTRACIÓN DE DONADORES DE SANGRE</h1>
        <h2 class="lead text-secondary">CENTRO DE ALTAS ESPECIALIDADES</h2>
    </div>
    <!--CONTENIFO AQUI-->
    
    <div class="container mt-5 mb-5">
        <div class="bg-white p-4 rounded shadow mx-auto" style="max-width: 600px;">
            <h2 class="text-center">Actualizar perfil</h2>
            <?php echo $message;?>
            <form action="ActualizarPerfil.php" method="POST">
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="correo">Nuevo correo</label>
                            <input type="email" class="form-control" id="correo" name="email" placeholder="Nuevo correo">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contrasena">Nueva contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="contrasena" name="password" placeholder="Crea una contraseña" >
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('contrasena')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones centrados -->
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary mr-5 w-25">Guardar</button>
                    <a href="./Menu.php" class="btn btn-secondary w-25">Regresar</a>
                </div>
            </form>

        </div>
    </div>

    <footer class="bg-white py-3 mt-5">
        <div class="container text-center">
            <img src="./Images/footerImages.png" class="img-fluid" alt="Imagen 1">
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>   
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
</body>
</html>