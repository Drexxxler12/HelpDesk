<?php
    //Importar base de datos
    //require '../app.php';
    //require DATABASE_URL;
    
    
    $db = conectarDB();
    $usuario = $_SESSION['usuario'];
    //Escribir el query
    $query = "SELECT * FROM tickets WHERE usuario = '${usuario}' AND estatus = 'process' ";
    //Consultar la base de datos
    $resultadoConsulta = mysqli_query($db, $query);



    if($_SERVER['REQUEST_METHOD']==='POST'){
        $id = $_POST['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);

        $consulta = "SELECT * FROM tickets  WHERE id = ${id} ";
        $resultado = mysqli_query($db,$consulta);
        $ticket = mysqli_fetch_assoc($resultado);

        $errores=[];
        $usuario = $ticket['usuario'];
        $estatus = 'attended';
        $fechaCreacion = $ticket['fechaCreacion'];
        $fechaCompromiso=$ticket['fechaCompromiso'];
        $descripcion=$ticket['descripcion'];
        $comentarios=$ticket['comentarios'];
        $codigo=$ticket['codigo'];
        $fechaAtencion=date("y-m-d");

        if($id){
            $query = "UPDATE tickets SET fechaCreacion = '${fechaCreacion}', usuario = '${usuario}', descripcion = '${descripcion}', fechaCompromiso = '${fechaCompromiso}', fechaAtencion = '${fechaAtencion}', comentarios = '${comentarios}', estatus = '${estatus}', codigo = '${codigo}' WHERE id = ${id} ";
            $resultado = mysqli_query($db,$query);

            if($resultado){
                header('Location:/login_HelpDesk.php');
            }
        }
    }


    
?>
<div class="">
    <table class="peticiones menu">
        <thead>
            <tr>         
                <th>Creacion</th>
                <th>Encargado</th>
                <th>Descripcion</th>
                <th>Fecha Compromiso</th>
                <th>Comentarios</th>
                <th>ID</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>   <!--  Mostrar la base de datos  -->
        <?php while($tickets = mysqli_fetch_assoc($resultadoConsulta)):?>
            <tr>
                <td><?php echo $tickets['fechaCreacion']; ?></td>
                <td><?php echo $tickets['usuario']; ?></td>
                <td><?php echo $tickets['descripcion']; ?></td>
                <td><?php echo $tickets['fechaCompromiso']; ?></td>
                <td><?php echo $tickets['comentarios']; ?></td>
                <td><?php echo $tickets['codigo']; ?></td>
                <td>
                <a href="/includes/admin/actualizarTicket.php? id= <?php echo $tickets['id']; ?>"class="btn-verde">Actualizar</a> 
                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $tickets['id'];?>">
                    <input type="submit"  class="btn-verde" value="Cerrar">
                </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table> 
</div>
   
   
<?php //mysqli_close($db);?>
    