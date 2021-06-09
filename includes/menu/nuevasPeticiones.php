<?php
    
    //Importar base de datos
    require DATABASE_URL;
    $db = conectarDB();
   

    //if(isset($_POST['submitEliminarNuevas'])){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_POST['id']??null;
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $query = "DELETE FROM peticiones WHERE id = ${id} ";
                $resultado = mysqli_query($db,$query);
                if($resultado){
                   header('Location:/login_HelpDesk.php');
                }
            }
        }
   // }
     //Escribir el query
     $query = "SELECT * FROM peticiones";
     //Consultar la base de datos
     $resultadoConsulta = mysqli_query($db, $query);

?>
    <table class="peticiones menu">
        <thead>
            <tr>         
                <th>Nombre</th>
                <th>Boleta</th>
                <th>fecha</th>
                <th>peticion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody> <!--    Mostrar la base de datos    -->
        <?php while($peticiones = mysqli_fetch_assoc($resultadoConsulta)):  ?>
            <tr>
                <td><?php echo $peticiones['nombre']; ?></td>
                <td><?php echo $peticiones['numero']; ?></td>
                <td><?php echo $peticiones['fecha']; ?></td>
                <td><?php echo $peticiones['texto']; ?></td>
                <td>
                    <a href="./includes/admin/crearTicket.php?id=<?php echo $peticiones['id'];?>" class="btn-verde">Crear</a>
                    <form method="POST"class="w-100">
                        <input type="hidden" name="id" value="<?php echo $peticiones['id']; ?>">
                        <input type="submit"  class="btn-rojo" value="Eliminar">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table> 
    <!--Cerrando la conexion de base de datos -->