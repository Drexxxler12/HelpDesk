<?php
     

//require '../../includes/config/database.php';
require DATABASE_URL;
$db = conectarDB();

//Arreglo que contendra los errores
$errores=[];
$nombre = '';
$boleta = '';
$peticion = '';
$fecha = '';
$success = '';
//Codigo que envia y valida los datos a enviar a la base de datos

if(isset($_POST['submit1'])){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        /*
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";

            echo "<pre>";
            var_dump($_FILES);
            echo "</pre>";
        */


        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $boleta = mysqli_real_escape_string ($db, $_POST['boleta']);
        $peticion = mysqli_real_escape_string($db, $_POST['peticion']);
        $fecha = date("y-m-d");
        $imagen =$_FILES['imagen'];

        //guardar los errores en el arreglo errores
        if($nombre === ""){
            $errores[]="Falta llenar el campo NOMBRE";
        }
        if($boleta ===""){
            $errores[]= "Falta llenar el campo BOLETA";
        }
        if( $boleta > 0 & (strlen($boleta) >10 || strlen($boleta) < 10)){
            $errores[] = "Boleta incorrecta";
        }
        if($peticion ===""){
            $errores[] = "Falta llenar el campo PETICION";
        }
        if($imagen['size'] > (2*1000000)){
            $errores[] = "La imagen excede 2 MB ";
        }

          
       if(empty($errores)){

        //Subida de ARCHIVOS
        //Crear una carpeta
        $carpetaImagenes = '../../imagenes';

        //Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . '/archivo.jpg');

        
        //Insertar en la base de datos 
            $query = "INSERT INTO peticiones(nombre, numero, texto, fecha, status ) VALUES ('$nombre', '$boleta', '$peticion', '$fecha', 'empty')";
            $resultado = mysqli_query($db, $query);
            
            if($resultado){
                $errores=[];
                $nombre = '';
                $boleta = '';
                $peticion = '';
                $fecha = '';
                $success = 'Peticion enviada correctamente';
                
                //sleep(5000);
                header('Location: /index.php?resultado=1');
                
            }
        }
        
    }   
}
    
  
?>


            
    <form class="formulario" method="POST" action="/index.php" enctype="multipart/form-data" >
    <?php    foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error;   ?>
    </div>
    <?php    endforeach;    ?>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input id="nombre" type="text" name="nombre" placeholder="Tu nombre" value= "<?php echo $nombre ?>">
        </div>
        <div class="campo">
            <label for="boleta">No. de Boleta</label>
            <input id="boleta" type="text" name="boleta" placeholder="Boleta o No. Empleado" value="<?php echo$boleta?>">
        </div>
        <div class="campo">
            <label for="peticion">Peticion</label>
            <input id="peticion" type="text" name="peticion" placeholder="Plantee aqui su peticion" value="<?php echo $peticion?>">
        </div>
        <div class="campo">
            <label for="imagen">Imagen</label>
            <input id="imagen" type="file" name="imagen"  accept="image/jpg, image/png">
        </div>
        <button type="submit"  name="submit1" class="button" >
            enviar
        </button>
    </form>
                
            
                

         
