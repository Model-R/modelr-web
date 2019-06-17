<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

// print_r($_REQUEST);
// exit;

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$idexperimento = $_REQUEST['id'];

$box=$_POST['chtestemunho'];
//print_r($box);
//exit;
$ultima_especie = explode("*", $box[0])[4];
$ultimo_id = $idexperimento;
$fontedados = 3;

while (list ($key,$val) = @each($box)) { 
    //$result = $Cobertura->excluir($val);
    // echo $val;
    // exit;
    $val = explode("*", $val);

    if($val[4] == $ultima_especie){
        //echo 'adicionar experimento ' . $ultimo_id . ' especie ' . $val[4] .'<br>';
        //echo $val.'<br>';
        $latitude = $val[2];
        $longitude = $val[3];
        $taxon = $val[4];
        $coletor = $val[5];
        $numcoleta = $val[6];
        $imagemservidor=$val[7];
        $imagemcaminho=$val[8];
        $imagemarquivo=$val[9];
        $pais=$val[10];
        $estado = $val[11];
        $municipio=$val[12]; 
        $herbario=$val[13]; 
        if ($val[14] == ''){
            $tombo = 'null';
        } else {
            $tombo = $val[14];
        } 
        $Experimento->adicionarOcorrencia($ultimo_id,$fontedados,$latitude,$longitude,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio,$herbario,$tombo,0,'CSV');
    }
    else {
        $ultima_especie = $val[4];
        $newId = $Experimento->clonar($idexperimento,$ultima_especie);
        $ultimo_id = $newId;
        $latitude = $val[2];
        $longitude = $val[3];
        $taxon = $val[4];
        $coletor = $val[5];
        $numcoleta = $val[6];
        $imagemservidor=$val[7];
        $imagemcaminho=$val[8];
        $imagemarquivo=$val[9];
        $pais=$val[10];
        $estado = $val[11];
        $municipio=$val[12]; 
        $herbario=$val[13]; 
        if ($val[14] == ''){
            $tombo = 'null';
        } else {
            $tombo = $val[14];
        } 
        $Experimento->adicionarOcorrencia($ultimo_id,$fontedados,$latitude,$longitude,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio,$herbario,$tombo,0,'CSV');
        //echo 'adicionar NOVO experimento ' . $ultimo_id . ' especie ' . $val[4] .'<br>';
    }
} 

//exit;
 header("Location: cadexperimento.php?op=A&pag=2&MSGCODIGO=71&id=$idexperimento");
?>



