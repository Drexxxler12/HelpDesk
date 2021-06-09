<?php
    require './includes/funciones.php';
    $resultado = $_GET['resultado'] ??null;
    
    //session_start();
    

    $auth = estaAutenticado();
    if($auth){
        header('Location:/login_HelpDesk.php');
    }
  
?>

<!DOCTYPE html>
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
    <header class="contenedor "><!--(INICIO) encabezado de la pagina principal-->
        <div class="header">
            <div class="logo">
                <img src="./build/img/log_ipn.webp" alt="IPN logo">
            </div>
            <div class="titulo">
                <h1>Instituto Politecnico Nacional</h1>
                <p class="text-center">Centro de Innovación y desarrollo Tecnológico en Computo</p>
            </div>
            
            <div class="logo cidetec">
                <img src="./build/img/logo-cidetec.webp" alt="Cidetec logo">
            </div>
        </div>
    </header><!--(FIN) encabezaado de la pagina principal-->
    <main class="contenedor"><!--(INICIO) contenedor principal-->
    
        <div class="login-contenedor">
            <nav class="tabs"><!--(INICIO) navegacion de los logins-->
                <button type="button" data-paso="1">Comunidad</button>
                <button type="button" data-paso="2">Soporte Tecnico</button>
                <button type="button" data-paso="3">Administrador</button>
            </nav><!--(FIN) navegacion de los logins-->
            
            <div id="paso-1" class="seccion"><!--(INICIO) PETICION-->
                <h2>Coloca tu peticion aqui:</h2>  
                <?php if(intval($resultado == 1)): ?>
                    <p class="alerta exito padding">Peticion enviada correctamente</p>
                    <a href="/index.php" class="button">Volver</a>
                <?php else:?>
                    <?php
                        incluirFormulario('peticion'); 
                    endif; ?>
            </div><!--(FIN) PETICION-->
            <div id="paso-2" class="seccion"><!--(INICIO) LOGIN SOPORTE-->
                    <?php
                        incluirFormulario('login_soporte'); 
                    ?>
                    
            </div><!--(FIN) LOGIN SOPORTE-->
            <div id="paso-3" class="seccion"><!--(INICIO) LOGIN ADMIN-->
                    <?php
                     
                        incluirFormulario('login_admin'); 
                    ?> 
            </div><!--(FIN) LOGIN ADMIN-->
        </div>
        
        
    </main><!--(FIN) CONTENEDOR PRINCIPAL -->
    <footer class="text-center">
        <p>Todos los derechos reservados</p>
    </footer>



    <script src="build/js/bundle.min.js"></script>
</body>
</html>