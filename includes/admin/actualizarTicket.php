<?php
    require '../funciones.php';
    //require '../app.php';
    require DATABASE_URL;
     $auth = estaAutenticado();
     if(!$auth){
         header('Location: /');
     }

    //Validar la url por id valido
    $id=$_GET['id'];
    $id=filter_var($id,FILTER_VALIDATE_INT);
   // var_dump($id);
    if(!$id){
       // header('Location:/login_HelpDesk.php');
    }

    //Importar la base de datos
    
   // require './includes/config/database.php';
    $db = conectarDB();

    //Consultar la Base de dAtos para obtener las peticiones
    $consulta = "SELECT * FROM tickets WHERE id =${id}";
    $resultado = mysqli_query($db,$consulta);
    $ticket = mysqli_fetch_assoc($resultado);
    $resultadoTickets= mysqli_query($db,$consulta);
/*
    echo "<pre>";
    var_dump($peticion);
    echo "</pre>";
 */   
    //$resultado = mysqli_query($db, $consulta);
    $errores=[];
    $usuario = $ticket['usuario'];
    $estatus = $ticket['estatus'];
    $fechaCreacion = $ticket['fechaCreacion'];
    $fechaCompromiso=$ticket['fechaCompromiso'];
    $descripcion=$ticket['descripcion'];
    $comentarios=$ticket['comentarios'];
    $codigo=$ticket['codigo'];
    $fechaAtencion=date("y-m-d");

    //Codigo que envia y valida los datos a enviar a la base de datos
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            /*
                echo "<pre>";
                var_dump($_POST);
                echo "</pre>";
            */
            $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
            $fechaCompromiso = mysqli_real_escape_string($db, $_POST['fechaCompromiso']);
            $comentarios=mysqli_real_escape_string($db, $_POST['comentario']);
           
    
            //guardar los errores en el arreglo errores
            if($descripcion === ""){
                $errores[]="Falta llenar el campo opcion";
            }
            if($comentarios === ""){
                $errores[]="Falta llenar el campo fechaCompromiso";
            }
            
    
              
           if(empty($errores)){
    
            //Subida de ARCHIVOS
            //Crear una carpeta
            //Insertar en la base de datos 
                //$query = "INSERT INTO tickets(fechaCreacion, usuario, descripcion,fechaCompromiso,fechaAtencion,comentarios,estatus,codigo ) VALUES ('$fechaCreacion', '$usuario', '$descripcion', '$fechaCompromiso' , '$fechaAtencion', '$comentarios', '$estatus', '$codigo')";
                $query = "UPDATE tickets SET fechaCreacion = '${fechaCreacion}', usuario = '${usuario}', descripcion = '${descripcion}', fechaCompromiso = '${fechaCompromiso}', fechaAtencion = '${fechaAtencion}', comentarios = '${comentarios}', estatus = '${estatus}', codigo = '${codigo}' WHERE id = ${id} ";
                
                $resultado = mysqli_query($db, $query);
                echo $query;
                
                if($resultado){
                    /*
                    $query= "DELETE FROM tickets WHERE id = ${id}";
                    mysqli_query($db, $query);*/
                    header('Location: /login_HelpDesk.php');
                    
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
    <table class="peticiones menu">
        <thead>
            <tr>         
                <th>Creacion</th>
                <th>Encargado</th>
                <th>Descripcion</th>
                <th>Fecha Compromiso</th>
                <th>Comentarios</th>
                <th>ID</th>
            </tr>
        </thead>
        <tbody>   <!--  Mostrar la base de datos  -->
        <?php while($tickets = mysqli_fetch_assoc($resultadoTickets)):?>
            <tr>
                <td><?php echo $tickets['fechaCreacion']; ?></td>
                <td><?php echo $tickets['usuario']; ?></td>
                <td><?php echo $tickets['descripcion']; ?></td>
                <td><?php echo $tickets['fechaCompromiso']; ?></td>
                <td><?php echo $tickets['comentarios']; ?></td>
                <td><?php echo $tickets['codigo']; ?></td>
                
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table> 
    <div class="contenedor login-contenedor ">
        <form class="formulario ticket" method="POST" action="#" enctype="multipart/form-data" >
            <h3>Actualizar Peticion </h3>
            <?php    foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error;   ?>
            </div>
            <?php    endforeach;    ?>
            <div class="campo">
                <label for="fechaCreacion">Fecha de Creacion: </label>
                <p><?php echo $fechaCreacion ?></p>
            </div>
            <div class="campo">
                <label for="boleta">Usuario: </label>
                <p><?php echo $usuario ?></p>
            </div>
            <div class="campo">
                <label for="descripcion">Descripcion: </label>
                <select name="descripcion" id="descripcion" value="<?php echo $descripcion?>">
                    <option>--Selecciona una opcion--</option>
                    <option>1.Instalación, reinstalación o activación de software</option>
                    <option>2.Peticiones de software institucional</option>
                    <option>3.Respaldo de equipos de cómputo</option>
                    <option>4.Difusión por redes sociales o correo institucional</option>
                    <option>5.Correo institucional</option>
                    <option>6.Seguridad informatica</option>
                    <option>7.Problemas con redes institucionales</option>
                    <option>8.Mantenimiento preventivo de equipos</option>
                    <option>9.Mantenimiento correctivo de equipos</option>
                    <option>10.Actividades administrativas de la unidad</option>
                </select>
            </div>
            <div class="campo">
                <label for="fechaCompromiso">Fecha Compromiso: </label>
                <input id="fechaCompromiso" type="date" name="fechaCompromiso" value="<?php echo $fechaCompromiso?>">
            </div>
            <div class="campo">
                <label for="comentario">Comentarios: </label>
                <input id="comentario" type="text" name="comentario" value="<?php echo $comentarios ?>">
            </div>
            <button type="submit"  class="button">
                Crear peticion
            </button>
        </form>
    </div>
    </body>
</html>
    
                