<?php 
session_start();

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$expid = $_REQUEST['expid'];


header('Content-disposition: attachment; filename=file.json');
header('Content-type: application/json');

$polygons = $_POST['polygon'];
$coordinates = [];

// loop over the rows, outputting them
foreach($polygons as $p){
    $vertices = explode(';',$p);
    $result = [];
    foreach($vertices as $v){
        $result[] = [explode(',',$v)[1], explode(',',$v)[0]];
    }
    $coordinates[] = $result;

}

$myObj->type = "Polygon";
$myObj->coordinates = $coordinates;
$myJSON = json_encode($myObj, JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
echo $myJSON;

?>