<?php 
    require './includes/funciones.php';
    $auth = estaAutenticado();
    if(!$auth){
        header('Location: /');
    }

    $usuario= $_SESSION['usuario'];
    $rango= $_SESSION['rol'];

?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Help Desk Cidetec</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="build/css/app.css">
    </head>
<body>
    <main class="contenedor app">
        <nav class="menu tabs">
            <div class="icon ">
                <img src="./build/img/log_ipn.webp" alt="icono IPN">
            </div>
            <button type="button" data-paso="1">Nuevas peticiones</button>
            <button type="button" data-paso="2">Peticiones</button>
            <button type="button" data-paso="3">Mis Peticiones</button>
            <?php if($rango ==='admin'):?>
            <button type="button" data-paso="4">Tickets</button>
            <button type="button" data-paso="5">Reporte de Tickets</button>
           
            <?php endif;?>
        </nav>
        <div class="">
            <div class="sesion">
                <div>
                    <p><?php echo $usuario ?></p>
                </div>
                <div class="sesion">
                    <?php if($rango === 'admin'): ?>
                        <a href="/includes/admin/nuevoUsuario.php" >Nuevo Usuario</a>
                        <a href="/includes/menu/usuarios.php">Usuarios</a>
                    <?php endif;?>
                    <?php if($auth): ?>
                        <a href="cerrar-sesion.php">Cerrar Sesion </a>
                    <?php endif;?>
                </div>
                
               
            </div>
            <div id="paso-1" class="seccion">
                <?php incluirMenu('nuevasPeticiones') ?>
            </div>
            <div id="paso-2" class="seccion">
                <?php incluirMenu('peticiones') ?>
            </div>
            <div id="paso-3" class="seccion">
                <?php incluirMenu('misPeticiones') ?>
            </div>
            <div id="paso-4" class="seccion">
                <?php incluirMenu('tickets') ?>
            </div>
            <div id="paso-5" class="seccion">
                <?php incluirMenu('reporteTickets') ?>
            </div> 
        </div>
        
       

        
    </main>
    
    <script src="build/js/bundle.min.js"></script>
</body>
</html>