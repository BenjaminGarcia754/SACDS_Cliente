<?php

use GuzzleHttp\Psr7\Message;

require './../../Infraestructura/DonadorAPI.php';
require './../../Modelo/Donador.php';
require './../../Modelo/Singleton/DonadorSingleton.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú principal</title>
    <link rel="stylesheet" href="./styles.css">
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
        nav a{
            text-decoration: none;
            color: #ccc;
        }
        nav li:hover a{
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
            <!-- Pestañas -->
            <ul class="nav nav-tabs w-75 d-flex">
                <li class="nav-item flex-fill">
                    <a class="nav-link active" href="#">Donaciones urgentes</a>
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
                </div>
            </div>
        </div>
    </nav>

    <div class="container container-donations my-5">
        <div class="row">
            <!-- Tarjeta 1 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Juan Pérez</h5>
                        <p class="card-text">Grupo Sanguíneo: O+</p>
                    </div>
                    <div class="card-footer text-center d-none">
                        <p class="mb-0">Número de Cama: 101</p>
                        <p class="mb-0">Área: Oncología</p>
                        <a href="detalle.html?nombre=Juan%20Pérez&grupo=O%2B&cama=101&area=Oncolog%C3%ADa" class="btn btn-primary mt-2">Ver Detalles</a>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 2 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">María González</h5>
                        <p class="card-text">Grupo Sanguíneo: A+</p>
                    </div>
                    <div class="card-footer text-center d-none">
                        <p class="mb-0">Número de Cama: 102</p>
                        <p class="mb-0">Área: Cardiología</p>
                        <a href="detalle.html?nombre=María%20González&grupo=A%2B&cama=102&area=Cardiolog%C3%ADa" class="btn btn-primary mt-2">Ver Detalles</a>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 3 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Luis Martínez</h5>
                        <p class="card-text">Grupo Sanguíneo: B-</p>
                    </div>
                    <div class="card-footer text-center d-none">
                        <p class="mb-0">Número de Cama: 103</p>
                        <p class="mb-0">Área: Urgencias</p>
                        <a href="detalle.html?nombre=Luis%20Martínez&grupo=B-&cama=103&area=Urgencias" class="btn btn-primary mt-2">Ver Detalles</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Tarjeta 4 -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Juan Pérez</h5>
                        <p class="card-text">Grupo Sanguíneo: O+</p>
                    </div>
                    <div class="card-footer text-center d-none">
                        <p class="mb-0">Número de Cama: 101</p>
                        <p class="mb-0">Área: Oncología</p>
                        <a href="detalle.html?nombre=Juan%20Pérez&grupo=O%2B&cama=101&area=Oncolog%C3%ADa" class="btn btn-primary mt-2">Ver Detalles</a>
                    </div>
                </div>
            </div>
            
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
        $(document).ready(function(){
            $('.card').hover(
                function() {
                    $(this).find('.card-footer').removeClass('d-none');
                    $(this).find('.card-body').hide(); // Oculta el body al hacer hover
                }, 
                function() {
                    $(this).find('.card-footer').addClass('d-none');
                    $(this).find('.card-body').show(); // Muestra el body al dejar de hacer hover
                }
            );
        });
    </script>
</body>
</html>
