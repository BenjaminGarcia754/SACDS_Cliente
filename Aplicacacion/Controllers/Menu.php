<?php
session_start();
if (!isset($_SESSION['idDonador'])) {
    header('Location: ../../index.php');
}
use GuzzleHttp\Psr7\Message;

require './../../Infraestructura/DonadorAPI.php';
require './../../Modelo/Donador.php';
require './../../Modelo/Singleton/DonadorSingleton.php';

require './../../Infraestructura/DonacionUrgenteAPI.php';
require './../../Modelo//DonacionUrgente.php';

$donacionAPI = new DonacionUrgenteAPI();

$response = $donacionAPI->obtenerDonacionesUrgentes();
$donaciones = $response['result'];


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas - Secretaria</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
    </style>
</head>

<body style="background-image: url('./Aplicacacion/Controllers/Images/background.jpg');">
    <!-- Header -->
    <div style="background-image: url('./Aplicacacion/Controllers/Images/headerbg.avif');" 
         class="header text-center py-4 bg-light rounded shadow">
        <h1 class="display-4 font-weight-bold text-primary">SISTEMA DE ADMINISTRACIÓN DE DONADORES DE SANGRE</h1>
        <h2 class="lead text-secondary">CENTRO DE ALTAS ESPECIALIDADES</h2>
    </div>

    <!-- Contenido principal -->
    <div class="container my-5 bg-white p-4 rounded shadow">
        <h2 class="text-center">Citas</h2>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <!-- Filtro -->
        <form method="POST" class="form-group mt-4">
            <input type="text" name="filtro" class="form-control" placeholder="Filtrar por nombre o tipo de donación..." value="<?php echo htmlspecialchars($filtro); ?>">
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
        </form>

        <!-- Tabla -->
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre del Donador</th>
                        <th>Tipo de Donación</th>
                        <th>Fecha de Donación</th>
                        <th>Días de Reposo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citasConNombres as $item): ?>
                        <?php
                        // Aplicar filtro
                        if ($filtro &&
                            !str_contains(strtolower($item['nombreDonador']), $filtro) &&
                            !str_contains(strtolower($item['nombreTipoDonacion']), $filtro)
                        ) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nombreDonador']); ?></td>
                            <td><?php echo htmlspecialchars($item['nombreTipoDonacion']); ?></td>
                            <td><?php echo htmlspecialchars($item['cita']->fechaDonacion); ?></td>
                            <td><?php echo htmlspecialchars($item['cita']->diasReposo); ?></td>
                            <td class="text-center">
                                <form method="POST">
                                    <input type="hidden" name="idCita" value="<?php echo htmlspecialchars($item['cita']->id); ?>">
                                    <button type="submit" class="btn btn-success">Marcar como atendida</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-3 mt-5">
        <div class="container text-center">
            <img src="./Aplicacacion/Controllers/Images/footerImages.png" class="img-fluid" alt="Imagen de pie de página">
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
