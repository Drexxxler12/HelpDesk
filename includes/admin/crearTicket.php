<?php

    //Importar la base de datos
    
    require '../funciones.php';
   // require '../app.php';
    require DATABASE_URL;
    $auth = estaAutenticado();
    if(!$auth){
         header('Location: /');
    }

    //Validar la url por id valido
    $id=$_GET['id'];
    $id=filter_var($id,FILTER_VALIDATE_INT);
    
    if(!$id){
        header('Location:/login_HelpDesk.php');
    }

   // require './includes/config/database.php';
    $db = conectarDB();

    //Consultar la Base de dAtos para obtener las peticiones
    $consulta = "SELECT * FROM peticiones WHERE id =${id}";
    $resultado = mysqli_query($db,$consulta);
    $peticion = mysqli_fetch_assoc($resultado);
/*
    echo "<pre>";
    var_dump($peticion);
    echo "</pre>";
 */   
    //$resultado = mysqli_query($db, $consulta);
    $errores=[];
    $usuario = $_SESSION['usuario'];
    $estatus = 'process';
    $fechaCreacion = $peticion['fecha'];
    $fechaCompromiso=date("y-m-d");;
    $descripcion='';
    $comentarios='';
    $fechaAtencion=date("0-0-0");

    //Creacion del codigo del ticket
    $consultaCodigo = "SELECT * FROM tickets";
    $resultadoConsulta = mysqli_query($db,$consultaCodigo); 
    
    //Convierte el string a un arreglo
    //$codigoActual= $revisaCodigo['codigo_actual'];
    $i=0;
    while($revisaCodigo = mysqli_fetch_assoc($resultadoConsulta)){
        $codigo=  explode('/',$revisaCodigo['codigo']);
        $codigoUdi = $codigo[0];
        $codigoYear = intval($codigo[1]);
        $codigoNum = intval($codigo[2]);   

        if($i<$codigoNum){
            $i=$codigoNum;
        }
        
    echo "<pre>";
    var_dump($codigoUdi);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoYear);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoNum);
    echo "</pre>";
    echo "<pre>";
    var_dump($i);
    echo "</pre>";
    }
    
    if(date('Y') == $codigoYear){
        $i=$i+1;
        $codigoNum=$i;
        $codigoNum = strval($codigoNum);
        $codigoYear = strval($codigoYear);
        //$codigoNuevo = $codigoUdi + '/' + $codigoYear + '/'+ $codigoNum;
        $codigoNuevo = "${'codigoUdi'}/${'codigoYear'}/${'codigoNum'}";
        

    }else{
        $codigoYear++;
        $codigoNum = 0;
    }



    //$codigoNuevo = strval($codigoNuevo);
  /*  echo "<pre>";
    var_dump($codigoUdi);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoYear);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoNum);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoNuevo);
    echo "</pre>";
    exit;*/
/*
    $date=date('Y');
    $numCodigo='';
    echo $date;
    exit;
*/

    $consulta = "SELECT * FROM peticiones WHERE id =${id}";
    $resultado = mysqli_query($db,$consulta);
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
            if($descripcion === "--Selecciona una opcion--"){
                $errores[]="Falta llenar el campo descripcion";
            }
            if($fechaCompromiso === ""){
                $errores[]="Falta llenar el campo fechaCompromiso";
            }
            if($comentarios === ""){
                $errores[]="Falta llenar el campo comentarios";
            }

            
    
              
           if(empty($errores)){
    
            //Subida de ARCHIVOS
            //Crear una carpeta
            //Insertar en la base de datos 
                $query = "INSERT INTO tickets(fechaCreacion, usuario, descripcion,fechaCompromiso,fechaAtencion,comentarios,estatus,codigo ) VALUES ('$fechaCreacion', '$usuario', '$descripcion', '$fechaCompromiso' , '$fechaAtencion', '$comentarios', '$estatus', '$codigoNuevo')";
                $resultado = mysqli_query($db, $query);
                echo $query;
                
                if($resultado){
                    
                    $query= "DELETE FROM peticiones WHERE id = ${id}";
                    mysqli_query($db, $query);
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
                <th>Nombre</th>
                <th>Boleta</th>
                <th>fecha</th>
                <th>status</th>
                <th>peticion</th>
                <th>Archivo</th>
            </tr>
        </thead>
        <tbody> <!--    Mostrar la base de datos    -->
        <?php while($peticiones = mysqli_fetch_assoc($resultado)):?>
            <tr>
                <td><?php echo $peticiones['nombre']; ?></td>
                <td><?php echo $peticiones['numero']; ?></td>
                <td><?php echo $peticiones['fecha']; ?></td>
                <td><?php echo $peticiones['status']; ?></td>
                <td><?php echo $peticiones['texto']; ?></td>
                <td><?php echo $peticiones['imagen']; ?></td>
              
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table> 
    
    <div class="contenedor login-contenedor ">
        <form class="formulario ticket" method="POST" action="#" enctype="multipart/form-data" >
            <h3>Crea aqui la peticion </h3>
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
                <select name="descripcion" id="descripcion">
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
            <button type="submit" id="btn-1" name="btn-1" class="button">
                Crear peticion
            </button>
        </form>
    </div>
    </body>
</html>
    
                
    
                    