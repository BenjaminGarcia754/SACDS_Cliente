<?php
session_start();

// Verificar si el usuario inició sesión correctamente
if (!isset($_SESSION['idDonador'])) {
    header('Location: ../../index.php');
    exit;
}

// Incluir la clase Cita (ajusta la ruta según tu estructura)
require './../../Modelo/Cita.php';
require '../../Infraestructura/CitaAPI.php';
$mensaje = ''; // Mensaje para mostrar al usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $idDonacion = $_SESSION['idTipoDonacion'] ?? null; // Capturar el ID de donación
    $idUrgente = $_SESSION['idDonacionUrgente'];
    $fecha = $_POST['fecha'] ?? null;

     // Crear objeto de tipo Cita
        $cita = new Cita();
        $cita->idTipoDonacion = $idDonacion;
        $cita->idDonador = $_SESSION['idDonador'];
        $cita->idDonacionUrgente = $idUrgente;
    // Validar datos recibidos
    if (empty($fecha)) {
        $mensaje = "Por favor, selecciona una fecha para la cita.";
    } elseif (empty($idDonacion)) {
        $mensaje = "El ID de la donación no está disponible.";
    } else {
        $citaAPI = new CitaAPI();
        $idDonador = $_SESSION['idDonador'];
        $ultimaCita = $citaAPI->obtenerCitaPorDonador($idDonador);
        $result = $ultimaCita['result'];
        $status = $ultimaCita['status'];

        if ($status != 404) {
            $fechaUltimaCita = new DateTime($result->$fechaDonacion);
            $diasReposo = $result->diasReposo;
            $fechaUltimaCita->add(new DateInterval("P{$diasReposo}D"));
            $fechacActual = new DateTime();
            // Comparar las fechas
            if ($fechaUltimaCita > $fechacActual) {
                // Calcular los días faltantes
                $fechaFinal = $fechacActual->diff($fechaUltimaCita);
                $intervalo = $fechaFinal->format('%a');
                echo "<script>alert('Actualmente no puedes donar sangre. Necesitas reposar $intervalo días para poder volver a donar.');</script>";
            } else {
                // Crear y guardar la nueva cita
                $cita->fechaDonacion = new DateTime($fecha);

                $resultado = $citaAPI->crearCita($cita);
                $result = $resultado['result'];
                $status = $resultado['status'];
                
                if ($status == 201) {
                    echo "<script>alert('Cita registrada .');</script>";
                } else {
                    echo "<script>alert('Error al registrar la cita. $status');</script>";
                }
            }
        } else {            
            $cita->fechaDonacion = new DateTime($fecha);

            $resultado = $citaAPI->crearCita($cita);
            $result = $resultado['result'];
            $status = $resultado['status'];

            if ($status == 201) {
                echo "<script>alert('Cita  correctamente.');</script>";
            } else {
                echo "<script>alert('Error $status .');</script>";
            }
        }
    }
} else {
    $mensaje = "Acceso no permitido.";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de cita</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .user-menu {
            position: relative;
            display: inline-block;
        }
        .user-menu-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .user-menu-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .user-menu-content a:hover {
            background-color: #f1f1f1;
        }
        .user-menu:hover .user-menu-content {
            display: block;
        }
        nav a {
            text-decoration: none;
            color: #ccc;
        }
        nav li:hover a {
            color: #c1c1c1;
        }
    </style>
</head>
<body style="background-image: url('./Images/background.jpg');">
    <div style="background-image: url('./Images/headerbg.avif');" class="header text-center py-4 bg-light rounded shadow">
        <h1 class="display-4 font-weight-bold text-primary">SISTEMA DE ADMINISTRACIÓN DE DONADORES DE SANGRE</h1>
        <h2 class="lead text-secondary">CENTRO DE ALTAS ESPECIALIDADES</h2>
    </div>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
        <div class="container-fluid justify-content-between">
            <ul class="nav nav-tabs w-75 d-flex">
                <li class="nav-item flex-fill">
                    <a class="nav-link active" href="./Menu.php">Donaciones urgentes</a>
                </li>
                <li class="nav-item flex-fill">
                    <a class="nav-link" href="#">Citas sin paciente</a>
                </li>
            </ul>

            <!-- Menú de usuario -->
            <div class="user-menu">
                <img src="./Images/user.png" alt="Usuario" class="rounded-circle" width="50" height="50">
                <div class="user-menu-content">
                    <a href="./ActualizarPerfil.php">Actualizar perfil</a>
                    <a href="./../../index.php">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5 mb-5">
        <div class="bg-white p-4 rounded shadow mx-auto" style="max-width: 600px;">
            <h2 class="text-center">Registrar Cita para Donación</h2>
            <form action="registroCita.php" method="POST">
                <div class="row mt-5">
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="fecha">Fecha de la Cita</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                    </div>
                    
                </div>

                <!-- Botones centrados -->
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary mr-5 w-25">Registrar</button>
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

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>