<?php
    //Verificar inicio de sesion 
    


    //Importar la base de datos
    require_once DATABASE_URL;
    
    $db=conectarDB();

    //Autenticar el usuario

    $errores=[];
    if(isset($_POST['submit2'])){
        if($_SERVER['REQUEST_METHOD']=== 'POST'){

            $admin = mysqli_real_escape_string($db, $_POST['admin']);
            $password = mysqli_real_escape_string($db, $_POST['password']);
    
            //Validando errores
            if(!$admin){
                $errores[] = 'El usuario es necesario, o no es valido';
            }
            if(!$password){
                $errores[] = 'La contraseña es necesaria';
            }
    
            //Si no hay errores comprobar si el usuario existe
            if(empty($errores)){
                $query = "SELECT * FROM usuarios WHERE usuario = '${admin}'" ;
                $resultado = mysqli_query($db, $query);
                /*echo "<pre>";
                var_dump($resultado);
                echo "</pre>";
               */
                if($resultado->num_rows){
                    $usuario = mysqli_fetch_assoc($resultado);
                    $auth = password_verify($password, $usuario['password']);
                   // $auth = password_verify($password, $usuario['password']);
    
                    if($auth){
                        //session_start();
                        $_SESSION['usuario']=$usuario['usuario'];
                        $_SESSION['rol']=$usuario['tipoUsuario'];
    
                       // echo "<pre>";
                       // var_dump($_SESSION);
                       //echo "</pre>";
                       header('Location: /login_HelpDesk.php');
                    }else{
                        $errores[] = 'La contraseña es incorrecta';
                    }
                }else{
                    $errores[]='El usuario no existe';
                }
    
    
            }
    
    
            
        }
    }

    


?>

<!--    Formulario    -->

<form method="POST" class="formulario">
    <?php    foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error;   ?>
    </div>
    <?php    endforeach;    ?>

    <div class="campo">
        <label for="admin">Admin</label>
        <input id="admin" name="admin" type="text" placeholder="Usuario">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input id="password" name="password" type="password" placeholder="Contraseña">
    </div>
    <button type="submit" name="submit2" class="button">
        Iniciar Sesion
    </button>
</form>