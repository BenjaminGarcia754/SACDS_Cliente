<?php
session_start();
if (!isset($_SESSION['idDonador'])) {
    header('Location: ../../index.php');
    exit;
}

require './../../Infraestructura/CitaAPI.php';
require './../../Infraestructura/DonadorAPI.php';
require './../../Infraestructura/TipoDonacionAPI.php';
require './../../Modelo/Cita.php';

// Instancias de APIs
$citaAPI = new CitaAPI();
$donadorAPI = new DonadorAPI();
$tipoDonacionAPI = new TipoDonacionAPI();

// Manejar la acción de marcar como atendida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCita'])) {
    $idCita = intval($_POST['idCita']);
    
    // Encontrar la cita original en la lista
    $citaOriginal = null;
    foreach ($citas as $cita) {
        if ($cita->id === $idCita) {
            $citaOriginal = $cita;
            break;
        }
    }

    // Validar si se encontró la cita
    if ($citaOriginal) {
        $resultado = $citaAPI->editarCita($citaOriginal); // Pasar el objeto completo
        if ($resultado['success']) {
            $mensaje = "La cita fue marcada como atendida exitosamente.";
        } else {
            $mensaje = "Error al marcar la cita como atendida: " . htmlspecialchars($resultado['message']);
        }
    } else {
        $mensaje = "Cita no encontrada.";
    }
}

// Obtener citas
$response = $citaAPI->obtenerCitasDiaActual();
$citas = $response['result'];

// Mapeo para presentación
$citasConNombres = [];
if (sizeof($citas) > 0) {
    foreach ($citas as $cita) {
        $donadorResponse = $donadorAPI->obtenerDonador($cita->idDonador);
        $tipoDonacionResponse = $tipoDonacionAPI->obtenerTipoDonacion($cita->idTipoDonacion);
        
        // Crear un objeto temporal con los datos originales y los nombres
        $citasConNombres[] = [
            'cita' => $cita,
            'nombreDonador' => $donadorResponse['result']->nombre ?? 'Desconocido',
            'nombreTipoDonacion' => $tipoDonacionResponse['result']->nombre ?? 'Desconocido',
        ];
    }
}

// Filtro de búsqueda
$filtro = isset($_POST['filtro']) ? strtolower(trim($_POST['filtro'])) : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
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
</body>

</html>
