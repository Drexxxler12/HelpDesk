<?php

    //Importar base de datos
    //require '../app.php';
    //require DATABASE_URL;
    $db = conectarDB();
    //Escribir el query
    $query = "SELECT * FROM tickets WHERE estatus='attended'";
    //Consultar la base de datos
    $resultadoConsulta = mysqli_query($db, $query);
    
?>
<div class="">
    <table class="peticiones menu">
        <thead>
            <tr>         
                <th>Creacion</th>
                <th>Encargado</th>
                <th>Descripcion</th>
                <th>Fecha Compromiso</th>
                <th>Fecha Atencion</th>
                <th>Comentarios</th>
                <th>ID</th>
            </tr>
        </thead>
        <tbody>   <!--  Mostrar la base de datos  -->
        <?php while($tickets = mysqli_fetch_assoc($resultadoConsulta)):?>
            <tr>
                <td><?php echo $tickets['fechaCreacion']; ?></td>
                <td><?php echo $tickets['usuario']; ?></td>
                <td><?php echo $tickets['descripcion']; ?></td>
                <td><?php echo $tickets['fechaCompromiso']; ?></td>
                <td><?php echo $tickets['fechaAtencion']; ?></td>
                <td><?php echo $tickets['comentarios']; ?></td>
                <td><?php echo $tickets['codigo']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table> 
</div>
   
   
    <?php mysqli_close($db);?>
    