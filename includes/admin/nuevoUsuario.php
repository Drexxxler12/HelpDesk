<?php
    
    require '../funciones.php';
    require DATABASE_URL;
    $auth = estaAutenticado();
    if(!$auth){
         header('Location: /');
    }
    $db = conectarDB();

    $errores=[];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $usuario = mysqli_real_escape_string($db, $_POST['usuario']);
        $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $tipoUsuario = $_POST['rango'];

        if($nombre === ""){
            $errores[]="Falta llenar el campo NOMBRE";
        }
        if($usuario === ""){
            $errores[]="Falta llenar el campo USUARIO";
        }
        if($_POST['password'] === "" || $_POST['password2'] === "" ){
            $errores[]="Falta llenar el campo contraseña";
        }
        if($_POST['password'] != $_POST['password2']){
            $errores[]="Las contraseñas no coinciden";
        }


        if(empty($errores)){

            //revisar si el usuario existe
            
            $query = "SELECT * FROM usuarios WHERE usuario = '${usuario}' ";
            $resultado = mysqli_query($db, $query);

            if($resultado->num_rows){
                $errores[]="El usuario ya existe";
            }else{
            $query = "INSERT INTO usuarios(nombre, usuario, password, tipoUsuario) VALUES('$nombre','$usuario','$passwordHash','$tipoUsuario')";
            $resultado = mysqli_query($db, $query); 
            
            if($resultado){
                header('Location: /login_HelpDesk.php');
            }
            }
            
        }
    }



?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Help Desk Cidetec</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/build/css/app.css">
    </head>
    <body>
        <div class="contenedor login-contenedor">
            <form class="formulario ticket" method="POST" action="#">
                <?php    foreach($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error;  ?>
                </div>
                <?php    endforeach;    ?>
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input id="nombre" type="text" name="nombre" placeholder="Nombre">
                </div>
                <div class="campo">
                    <label for="usuario">Usuario</label>
                    <input id="usuario" type="text" name="usuario" placeholder="Usuario">
                </div>
                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" name="password" placeholder="Contraseña" >
                </div>
                <div class="campo">
                    <label for="password2">Repite la contraseña</label>
                    <input id="password2" type="password" name="password2" placeholder="Repite la contraseña" >
                </div>
                <div class="campo">
                    <label for="rango">Rango</label>
                    <select name="rango" id="rango">
                        <option>soporte</option>
                        <option>admin</option>
                    </select>
                </div>
                <button type="submit" class="button" >
                    enviar
                </button>
            </form>
        </div>
        
    </body>
</html>
   