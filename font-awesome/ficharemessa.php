<?php 
//error_reporting(E_ALL);
//ini_set('display_errors','1');
	require_once('classes/relatorio.class.php');
	require_once('classes/conexao.class.php');

$clConexao = new Conexao();
$conn = $clConexao->Conectar();
$id = $_REQUEST['id'];

$sql = 'select * from item jabot.itemguiaremessa where idguiaremessa = '.$id; 
echo $sql;
exit;
//$res = pg_exec($conn,$sql);

//$arr_campo = array( "Família", "qtd"); 
//$arr_titulo = array( "Família.", "Quantidade"); 
//$arr_tamanho = array( "150", "40"); 
//$arr_alinhamento = array( "L", "R"); 

//$arr_assinatura = array("Diretor","data","Presidente");
$pdf = new PDF();
$pdf->conn = $conn;
$pdf->montaCabeca();
$pdf->Cell(190,10,'HERBÁRIO - RJ',0,1,'C');
$pdf->Cell(190,5,'Guia de Remessa (Shipping Notice) ',0,1,'L');
$pdf->Cell(190,5,'Data: ',0,1,'L');
$pdf->Cell(190,5,'Ao: Sr.:',0,1,'L');
$pdf->Cell(190,5,'Cargo:',0,1,'L');
$pdf->Cell(190,5,'Instituição',0,1,'L');
$pdf->Cell(190,5,'Endereço:',0,1,'L');

$pdf->Cell(190,10,'DISCRIMINAÇÃO DOS ESPÉCIMES',0,1,'C');

$res = pg_exec($conn,$sql);
while ($row = pg_fetch_array($res))
{
	$codtestemunho = $row['codtestemunho'];
	$pdf->Cell(190,5,$codtestemunho,0,1,'L');
}

//$clRel->totalizar=1;
//$clRel->dados = $res;

//$clRel->campos = $arr_campo;
//$clRel->titulocampo = $arr_titulo;
//$clRel->tamanhocampo = $arr_tamanho;
//$clRel->alinhamentocampo = $arr_alinhamento;
//$clRel->assinatura = $arr_assinatura;
//$clRel->nomefonte = 'Arial';
//$clRel->tamanhofonte = '8';
//$clRel->orientacao = 'P';
//$clRel->borda = '1';
//$clRel->titulo = 'Quantidade de espécimes por família - '.$basedados->pegaBase($base);
//$clRel->descricao=$descricao;
$pdf->Output();
?>
