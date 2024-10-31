<?php 
require './../../Infraestructura/DonadorAPI.php';
require './../../Modelo/Donador.php';

$message = ''; // Variable para almacenar el mensaje de respuesta

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $lastnameP = $_POST['lastnameP'];
    $lastnameM = $_POST['lastnameM'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $blood = $_POST['blood'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    
    // Crear el objeto Donador con los datos ingresados
    $donador = new Donador();
    $donador->nombre = $name;
    $donador->grupoSanguineo = $blood;
    $donador->apellidoMaterno = $lastnameM;
    $donador->apellidoPaterno = $lastnameP;
    $donador->correo = $email;
    $donador->contrasena = $password;
    $donador->telefono = $phoneNumber;
    $donador->direccion = $address;

    // Llamar al método de registrar donador
    $donadorAPI = new DonadorAPI();

    $emailExists = $donadorAPI->VerificarCorreo($email);
    if($emailExists){
        $message = "<div class='alert alert-warning'>El correo proporcionado ya existe.</div>";
    }
    else{
        $result = $donadorAPI->registrarDonador($donador);
        if(isset($result->id)){
            header('Location: ./../../index.php?idNuevaCuenta='.$result->id);
        }
        else {
            $message = "<div class='alert alert-danger'>Ha ocurrido un error, intentalo mas tarde.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Donador</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body style="background-image: url('./Images/background.jpg');">
<div style="background-image: url('./Images/headerbg.avif');" class="header text-center py-4 bg-light rounded shadow">
        <h1 class="display-4 font-weight-bold text-primary">SISTEMA DE ADMINISTRACIÓN DE DONADORES DE SANGRE</h1>
        <h2 class="lead text-secondary">CENTRO DE ALTAS ESPECIALIDADES</h2>
    </div>
    <div class="container mt-5">
        <div class="bg-white p-4 rounded shadow mx-auto" style="max-width: 600px;">
            <h2 class="text-center">Formulario de Registro</h2>
            <?php echo $message;?>
            <form action="userRegistration.php" method="POST">
                <div class="row">
                    <!-- Primera columna: Nombre y Apellido -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="name" placeholder="Nombre(s)" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoP">Apellido Paterno</label>
                            <input type="text" class="form-control" id="apellidoP" name="lastnameP" placeholder="Apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidoM">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellidoM" name="lastnameM" placeholder="Apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="bloodGroup">Grupo Sanguíneo</label>
                            <select class="form-control" id="bloodGroup" name="blood" required>
                                <option value="">Selecciona tu grupo sanguíneo</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>

                    <!-- Segunda columna: Dirección, Teléfono, Correo y Contraseña -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Calle, Numero, Colonia, Ciudad" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Número de teléfono</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="228 128 1418" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="correo@ejemplo.com" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones centrados -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary mr-2 w-25">Crear</button>
                    <a href="../../index.php" class="btn btn-secondary w-25">Regresar</a>
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
