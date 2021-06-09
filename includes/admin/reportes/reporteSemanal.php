<?php
require '../../../includes/config/database.php';
require '../../../includes/funciones.php';
require('../../../fpdf/fpdf.php');

$i=0;

class PDF extends FPDF
{
// Cabecera de página
function Header(){
    // Logo
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(60);
    // Título
    $this->Cell(60,10,'Reporte de Tickets Semanal',0,0,'C');
    // Salto de línea
    $this->Ln(20);
}
// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
}
}

//Consulta base de datos
$db= conectarDB();
$query = "SELECT * FROM tickets WHERE estatus = 'attended'  ";
$resultado = mysqli_query($db,$query);
/*
while($revision= mysqli_fetch_assoc($resultado) ){
    //Convierte el string a un arreglo
    //$codigoActual= $revisaCodigo['codigo_actual'];
    $codigo=  explode('-',$revision['fechaAtencion']);
    $codigoYear = $codigo[0];
    $codigoMes = $codigo[1];
    $codigoDay = $codigo[2];

    if($codigoYear != date('Y')){
        break;
    }

    echo "<pre>";
    var_dump($revision['fechaAtencion']);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoYear);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoMes);
    echo "</pre>";
    echo "<pre>";
    var_dump($codigoDay);
    echo "</pre>";
    echo "<pre>";
    var_dump($i);
    echo "</pre>";
    $i++;
}
*/
//Creacion de la pagina
$pdf = new PDF();
$pdf-> AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

//imorimir los productos de la bas de datos
while ($row = $resultado->fetch_assoc()) {
    $codigo=  explode('-',$row['fechaAtencion']);
    $codigoYear = $codigo[0];
    $codigoMes = $codigo[1];
    $codigoDay = $codigo[2];
    if($codigoDay >= (date('d') - 7) && $codigoMes ==date('m') && $codigoYear == date('Y')){
        $pdf->Cell(69,8,utf8_decode('ID: '),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['codigo']),1,1,'C',0);
        $pdf->Cell(69,8,utf8_decode('Creacion: '),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['fechaCreacion']),1,1,'C',0);
        $pdf->Cell(69,8,utf8_decode('Ingeniero: '),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['usuario']),1,1,'C',0);
        $pdf->Cell(69,8,utf8_decode('Descripcion'),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['descripcion']),1,1,'C',0);
        $pdf->Cell(69,8,utf8_decode('Fecha Compromiso: '),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['fechaCompromiso']),1,1,'C',0);
        $pdf->Cell(69,8,utf8_decode('Fecha Atencion: '),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['fechaAtencion']),1,1,'C',0);
        $pdf->Cell(69,8,utf8_decode('Comentiarios: '),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['comentarios']),1,1,'C',0);
        $pdf->Cell(69,8,utf8_decode('Estatus'),1,0,'C',0);
        $pdf->Cell(99,8,utf8_decode($row['estatus']),1,1,'C',0);
        $pdf ->Ln(10);
        
        $i++;
        if($i>=3){      
            $pdf-> AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial','',12);
            $i=0;
        }
    }

    

}
//Imprimir el documento
$pdf->Output();
?>