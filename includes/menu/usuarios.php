<?php

    //Importar base de datos
    //require '../app.php';
    require '../config/database.php';
    require '../funciones.php';

    $auth = estaAutenticado();
    if(!$auth){
        header('Location: /');
    }

    $usuario= $_SESSION['usuario'];
    $rango= $_SESSION['rol'];

    $db = conectarDB();
    //Escribir el query
    $query = "SELECT * FROM usuarios";
    //Consultar la base de datos
    $resultadoConsulta = mysqli_query($db, $query);

    //borrando el usuario

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_POST['usuarioSelect'];
            //$id = filter_var($id,FILTER_VALIDATE_INT);

            if($id){
                $query = "DELETE FROM usuarios WHERE usuario = '${id}' ";
                $resultado = mysqli_query($db, $query);
                
                if($resultado){
                    header('Location:/login_HelpDesk.php');
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
    <main class="contenedor">
        <table class="peticiones menu">
            <thead>
                <tr>         
                    <th>Usuario</th>
                    <th>Tipo de Usuario</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>   <!--  Mostrar la base de datos  -->
            <?php while($usuarios = mysqli_fetch_assoc($resultadoConsulta)):?>
                <tr>
                    <td><?php echo $usuarios['nombre']; ?></td>
                    <td><?php echo $usuarios['tipoUsuario']; ?></td>
                    <td>
                        <form method="POST" >
                            <input type="hidden" name="usuarioSelect" value="<?php echo $usuarios['usuario'];?>">
                            <input type="submit" name="submitEliminar" class="btn-rojo w-100" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table> 
    </main>
</html>
    <?php //mysqli_close($db);?>