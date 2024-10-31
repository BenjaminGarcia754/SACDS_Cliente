<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal - SACDS</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados para los botones de tablero */
        .menu-button {
            width: 100%;
            height: 150px;
            color: white;
            font-size: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 10px;
            background-size: cover;
            background-position: center;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Título de la página -->
    <div class="row mt-3">
        <div class="col-12">
            <h1 class="title">SACDS</h1>
        </div>
    </div>

    <!-- Tablero de botones -->
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <a href="ConsultarDonacionesUrgentes.php" class="menu-button" style="background-image: url('images/urgent-donations.jpg');">
                Consultar Donaciones Urgentes
            </a>
        </div>
        <div class="col-md-4 mb-4">
            
            <a href="RegistrarDonacion.php" class="image-button">
                <img src="/Recursos/DonarSangreButton.jpg" alt="Donar Sangre" height ="90" width="480">
                <span>Registrar Donación</span>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="ConsultarDonaciones.php" class="menu-button" style="background-image: url('images/view-donations.jpg');">
                Consultar Donaciones
            </a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
