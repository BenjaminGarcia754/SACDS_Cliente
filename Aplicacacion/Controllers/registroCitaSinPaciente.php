<?php
session_start();
if (!isset($_SESSION['idDonador'])) {
    header('Location: ../../index.php');
    exit();
}

// Asegúrate de incluir la clase o API que contiene el método obtenerTipoDonaciones
require '../../Infraestructura/TipoDonacionAPI.php';
require '../../Infraestructura/CitaAPI.php';
require '../../Modelo/Cita.php';

// Instancia la clase y obtiene los tipos de donaciones
$tipoDonacionAPI = new TipoDonacionAPI();
$citaAPI = new CitaAPI();
$tiposDonaciones = $tipoDonacionAPI->obtenerTipoDonaciones();
$idDonador = $_SESSION['idDonador'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos
    $fecha = $_POST['fecha'];
    $fechaCita = new DateTime($fecha);
    $idTipoDonacion = $_POST['tipoDonacion'];

    if (empty($fecha) || empty($idTipoDonacion)) {
        echo "<script>alert('Debe seleccionar una fecha y un tipo de donación');</script>";
    } else {
        // Obtener la última cita del donador
        $ultimaCita = $citaAPI->obtenerCitaPorDonador($idDonador);
        $result = $ultimaCita['result'];
        $status = $ultimaCita['status'];
        // Verificar si el donador puede donar
        if ($status == 200) {
            $fechaUltimaCita = $ultimaCita->fechaDonacion;
            $diasReposo = $ultimaCita->diasReposo;

            // Convertir las fechas a timestamp
            $fechaUltimaCitaTimestamp = strtotime($fechaUltimaCita);
            $fechaCitaActualTimestamp = strtotime($fecha);
            $fechaReposoPermitidoTimestamp = strtotime("+$diasReposo days", $fechaUltimaCitaTimestamp);

            // Comparar las fechas
            if ($fechaReposoPermitidoTimestamp > $fechaCitaActualTimestamp) {
                // Calcular los días faltantes
                $diasFaltantes = ceil(($fechaReposoPermitidoTimestamp - $fechaCitaActualTimestamp) / (60 * 60 * 24));
                echo "<script>alert('Actualmente no puedes donar sangre. Necesitas reposar $diasFaltantes días para poder volver a donar.');</script>";
            } else {
                // Crear y guardar la nueva cita
                $citaDTO = new Cita();
                $citaDTO->idDonador = $idDonador;
                $citaDTO->idTipoDonacion = $idTipoDonacion;
                $citaDTO->fechaDonacion = $fechaCita;

                $resultado = $citaAPI->crearCita($citaDTO);
                $result = $resultado['result'];
                $status = $resultado['status'];
                
                if ($status == 201) {
                    echo "<script>alert('Cita registrada .');</script>";
                } else {
                    echo "<script>alert('Error al registrar la cita. $status');</script>";
                }
            }
        } else {
            // Si no tiene citas previas, procede normalmente
            
            $citaDTO = new Cita();
            $citaDTO->idDonador = $idDonador;
            $citaDTO->idTipoDonacion = $idTipoDonacion;
            $citaDTO->fechaDonacion = $fechaCita;

            $resultado = $citaAPI->crearCita($citaDTO);
            $result = $resultado['result'];
            $status = $resultado['status'];

            if ($status == 201) {
                echo "<script>alert('Cita  correctamente.');</script>";
            } else {
                echo "<script>alert('Error $status .');</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de cita sin paciente</title>
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
<body style="background-image: url('./Images/background.jpg'); background-size: cover; background-position: center;">
    <!-- Encabezado con imagen de fondo -->
    <div style="background-image: url('./Images/headerbg.avif');" class="header text-center py-4 bg-light rounded shadow">
        <h1 class="display-4 font-weight-bold text-primary">SISTEMA DE ADMINISTRACIÓN DE DONADORES DE SANGRE</h1>
        <h2 class="lead text-secondary">CENTRO DE ALTAS ESPECIALIDADES</h2>
    </div>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
        <div class="container-fluid justify-content-between">
            <ul class="nav nav-tabs w-75 d-flex">
                <li class="nav-item flex-fill">
                    <a class="nav-link" href="./Menu.php">Donaciones urgentes</a>
                </li>
                <li class="nav-item flex-fill">
                    <a class="nav-link active" href="#">Citas sin paciente</a>
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
            <form action="registroCitaSinPaciente.php" method="POST" onsubmit="return validarFormulario();">
                <div class="form-group">
                    <label for="fecha">Fecha de la Cita</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>

                <div class="form-group">
                    <label for="tipoDonacion">Tipo de Donación</label>
                    <select class="form-control" id="tipoDonacion" name="tipoDonacion" required>
                        <?php if (empty($tiposDonaciones)) : ?>
                            <option value="">Seleccione un tipo de donación</option>
                        <?php else : ?>
                            <option value="" disabled selected>Seleccione un tipo de donación</option>
                        <?php endif; ?>

                        <?php foreach ($tiposDonaciones as $tipo) : ?>
                            <option value="<?= htmlspecialchars($tipo->id) ?>">
                                <?= htmlspecialchars($tipo->nombre) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary w-25">Registrar</button>
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

    <script>
        function validarFormulario() {
            const fecha = document.getElementById('fecha').value;
            const tipoDonacion = document.getElementById('tipoDonacion').value;
            if (!fecha || !tipoDonacion) {
                alert('Debe seleccionar una fecha y un tipo de donación');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
