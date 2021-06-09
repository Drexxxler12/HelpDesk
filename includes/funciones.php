<?php
require 'app.php';

function incluirFormulario($nombre){
    
    include FORMULARIOS_URL. "/${nombre}.php";

}

function incluirMenu($nombre){
    include MENU_URL. "/${nombre}.php";
}

function estaAutenticado() : bool{
    session_start();
    $auth = $_SESSION['rol'] ?? null;
    
    if($auth){
        return true;
    }

    return false;
}


/*
function leerUsuarios() : array{

    try {
        //Importar una conexion
        require 'database.php';

        //Escribir el codigo SQL
        $sql = "SELECT * FROM usuarios;";
        $consulta = mysqli_query($db, $sql);


        //Arreglo vacio
        $usuarios =[];
        $i = 0;

        //Obtener los resultados
        while ($row = mysqli_fetch_assoc($consulta)) {

            $usuarios[$i]['nombre']=$row['nombre'];
            $usuarios[$i]['numeroEmpleado']=$row['numeroEmpleado'];
            $usuarios[$i]['usuario']=$row['usuario'];
            $usuarios[$i]['password']=$row['password'];
            $usuarios[$i]['tipoUsuario']=$row['tipoUsuario'];
           $i++;
        }
        
        echo"<pre>";
        var_dump($usuarios);
        echo"</pre>";
        
        return $usuarios;

    } catch (\Throwable $th) {
        //throw $th;
        var_dump($th);
    }
}

function insertarUsuarios(){


    try {
        //Importar una conexion
        require 'database.php';


        if(isset($_POST['btn-1']))
        {

            $nombre=$_POST['nombre'];
            $matricula=$_POST['matricula'];
            $peticion=$_POST['peticion'];
            $conexion->query("INSERT INTO $peticiones (nombre, matricula, peticion) values ('$nombre','$matricula','$peticion')");

            
        }
    } catch (\Throwable $th) {
        throw $th;
    }



}
*/

