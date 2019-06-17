<?php session_start();
// $tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
// if ($_SESSION['donoDaSessao'] != $tokenUsuario)
// {
// 	header('Location: index.php');
// }
// error_reporting(E_ALL);
// ini_set('display_errors','1');
?><html lang="pt-BR">
<?php

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: https://modelr.jbrj.gov.br');

require_once('classes/conexao.class.php');
require_once('classes/experimento.class.php');
require_once('classes/statusoccurrence.class.php');
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$StatusOccurrence = new StatusOccurrence();
$StatusOccurrence->conn = $conn;

$filtro = $_REQUEST['filtro']; 

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$checkAutomaticFilter=$_REQUEST['checkAutomaticFilter'];
$liberado = false;

$sql = 'SELECT CAST(CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END AS BIT) FROM modelr.occurrence WHERE idstatusoccurrence = 17 AND idexperiment = '.$id;
$res = pg_exec($conn,$sql);
$row = pg_fetch_array($res);
if($row[0] == '1') $liberado = true;
else $liberado = false;

if($id){
	$sql = "select automatic_filter from modelr.experiment where idexperiment = ".$id;
	$res = pg_exec($conn,$sql);
	$row = pg_fetch_array($res);
	if($row['automatic_filter'] == 'f' || $row['automatic_filter'] == '') $automaticfilter = false;
	else{
        $automaticfilter = true;

    } 
        
}

if ($op=='A')
{
	$Experimento->getById($id);
	$idexperiment = $Experimento->idexperiment;
	$name = $Experimento->name ;
	$description = $Experimento->description ;
}

?>

<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 65%;
      }
	  #map2 {
        height: 65%;
      }
	  #map3 {
        height: 65%;
	  }
	  #map4 {
        height: 400px;
	  }
    </style>

<div class="modal fade" id="pointModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel2">Editar ponto</h4>
				</div>
				<div class="modal-body">
					<h4><div id="divtaxon"></div></h4>
					<p>Dados originais<br>
					<div id="dadosoriginais"></div><br>
					<div id="dadoscoletor"></div><br>
					<div id="dadosherbario"></div><br>
					<div class="row">
						<div class="col-md-1 col-sm-1 col-xs-1"></div>
						<div class="col-md-2 col-sm-2 col-xs-2">
							<div id="divimagem"></div><br>
						</div>
						
						<div class="col-md-8 col-sm-8 col-xs-8">
							<b>Dados inferidos</b><br>
							<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence',$idstatusoccurrence,'N','class="form-control"','1,4,6,8,17');?>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									Latitude:<input type="text" name="edtlatitude" id="edtlatitude" class="form-control"><br>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									Longitude:<input type="text" name="edtlongitude" id="edtlongitude" class="form-control"><br>
								</div>
							</div>
	
								<div id="map4"></div>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1"></div>
					</div>
					</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="edidocorrencia" id="edidocorrencia">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" onclick="atualizarPontos(document.getElementById('edidocorrencia').value,document.getElementById('cmboxstatusoccurrence').value,document.getElementById('edtlatitude').value,document.getElementById('edtlongitude').value, true)">Salvar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<h4><div id="divtaxonconfirmacao">Deseja alterar a localização do ponto ?</div></h4>
				<div id="dadosoriginaisconfirmacao"></div><br>
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-8">
						<b>Dados inferidos</b><br>
						<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrenceconfirmacao',$idstatusoccurrenceconfirmacao,'N','class="form-control"','1,4,6,17');?>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								Latitude:<input type="text" name="edtlatitude" id="edtlatitudeconfirmacao" class="form-control"><br>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								Longitude:<input type="text" name="edtlongitude" id="edtlongitudeconfirmacao" class="form-control"><br>
							</div>
						</div>
					</div>
				</div>
				</p>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="edidocorrencia" id="edidocorrenciaconfirmacao">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="initMapModal(document.getElementById('edidocorrenciaconfirmacao').value)">Fechar</button>
				<button type="button" class="btn btn-primary" onclick="atualizarPontos(document.getElementById('edidocorrenciaconfirmacao').value,document.getElementById('cmboxstatusoccurrenceconfirmacao').value,document.getElementById('edtlatitudeconfirmacao').value,document.getElementById('edtlongitudeconfirmacao').value, true)">Salvar</button>
			</div>
		</div>
	</div>
</div>

	 <div class="modal fade" id="myModalstatusoccurrence" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel2">Status Ocorrência</h4>
				</div>
				<div class="modal-body">
					<p>
					<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrence222',$idstatusoccurrence222,'N','class="form-control"','1,2,4,6,8,10,11,12,13,16,17,18,19');?>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" onclick="atualizarMultiplosPontos('',document.getElementById('cmboxstatusoccurrence222').value)">Salvar</button>
				</div>

			</div>
		</div>
	</div>		

<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
    <h2>Data Cleaning</h2>
    <div class="clearfix"></div>
    </div>
    <?php 
    // so mostra os filtros se não tiver filtro automatico setado	
    if ($automaticfilter == false){?>
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <button id="send3" type="button" onclick="atualizarPontos('',13,'','',false)" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos com ambas as coordenadas 0">Coordenada com zero</button>
			<button id="send1" type="button" onclick="atualizarPontos('',10,'','',false)" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos fora do Brasil">Fora limite Brasil</button>
            <button id="send4" type="button" onclick="marcarPontosDuplicados()" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar duplicatas">Duplicatas</button>
            <button id="send2" type="button" onclick="atualizarPontos('',2,'','',false)" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos fora do município coletado">Fora Município coleta</button>
			<button id="send3" type="button" onclick="atualizarPontos('',99,'','',false)" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Executar todos os filtros">Executar Todos</button>
            <!--<button id="send3" type="button" onclick="atualizarPontos('',11,'','',false)" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos no mar">Coordenada no mar</button>
            <button id="send3" type="button" onclick="atualizarPontos('',12,'','',false)" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos com coordenada invertida">Coordenada invertida</button>
            -->
            <!--<button id="send5" type="button" onclick="liberarParaModelagem()" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Liberar experimento para modelagem">Liberar Modelagem</button>-->
            </div>
    </div>
    <?php } ?>
    <div class="x_content">
    <p style="padding: 5px;">
    <div id="map3"></div>
    <!-- end pop-over -->
    </div>
    </div>
    </div>

    <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrencefiltro',$idstatusoccurrencefiltro,'N','class="form-control"','',$id);?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 points-table-options">
            <div>
                <button id="send" type="button" onclick="filtrar(document.getElementById('cmboxstatusoccurrencefiltro').value)" class="btn btn btn-success" data-toggle="tooltip" data-placement="top" title data-original-title="Filtrar pontos">Filtrar</button>
				
                <?php
                    if ($liberado == true && ($_SESSION['s_idtipousuario'] == '5')) {?>
                        <button type="button" class="btn btn-success" onClick='liberarExperimentoReflora()' data-toggle="tooltip" data-placement="top" title data-original-title="Liberar experimento para Modelagem">Modelar</button>
                    <?php
                    }
                    ?>
					<button style="height: 32px; id="cleanPoints" type="button" onclick="confirmarLimparDados()" class="btn btn btn-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Limpar Pontos"><i class="fa fa-eraser"></i></button>
                        </div>
            <div class="print-options">
                <a  class="btn btn-default btn-sm" onClick="imprimirDC('PDF');" data-toggle="tooltip" data-placement="top" title="Exportar tabela em PDF"><?php echo " PDF ";?></a>
                <a  class="btn btn-default btn-sm" onClick="imprimirDC('CSV');"data-toggle="tooltip" data-placement="top" title="Exportar tabela em CSV"><?php echo " CSV";?></a>
            </div>
        </div>
    </div>	
    <table id="points_table" class="table table-striped jambo_table bulk_action">
        <thead>
            <tr class="headings">
                <th class="a-center">
                    <input type="checkbox" name="chkboxtodos" id="chkboxtodos" onclick="selecionaTodos(true);">
                    <a style="margin-left: 1px;" data-toggle="tooltip" data-placement="top" title data-original-title="Editar" onclick="abreModelMultiplosPontos()" class="points-table-action-header"><span class="glyphicon glyphicon-edit edit-button" aria-hidden="true"></span></a>
                </th>
                <th class="column-title">Imagem</th>
				<th class="column-title">Origem</th>
                <th class="column-title">Espécie</th>
                <th class="column-title">Coletor</th>
                <th class="column-title">Localização</th>
                <th class="column-title">Status</th>
                <!--<th class="column-title">Ação</th>-->
            </tr>
        </thead>
<?php 
$sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,herbario,numtombo,fonte,
case when lat2 is not null then lat2 else lat end as lat,
case when long2 is not null then long2
else long end as long
from modelr.occurrence, modelr.statusoccurrence where 
occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
idexperiment = ".$id;
if (!empty($filtro))
{
	$sql.=' and occurrence.idstatusoccurrence = '.$filtro;
}
$res = pg_exec($conn,$sql);
$conta = pg_num_rows($res);
$marker = '';
$info = '';
?>
																			<tbody>
<tr class="even pointer">
	<td class="a-center total-busca" colspan=7>Total: <?php echo $conta;?></td>
</tr>

<?php 
$c=0;
while ($row = pg_fetch_array($res))
{   
	$servidor = $row['server'];
	$path =  $row['path'];
	$arquivo =  $row['file'];
	$herbario =  $row['herbario'];
	$tombo =  $row['numtombo'];
	$localizacao = $row['country'].', '.$row['majorarea'].' - '.$row['minorarea'];
	$coletor = $row['collector'].' '.$row['collectnumber'];
	
	$html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='.$row['codtestemunho'].'&arquivo='.$arquivo.' target=\"Visualizador\"><img src="http://'.$servidor.'/fsi/server?type=image&source='.$path.'/'.$arquivo.'&width=300&height=70&profile=jpeg&quality=20"></a>';
	
	// preparo os quadros de informação para cada ponto
	$c++;
	if ($c < $conta) {
		$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."','".$coletor."','".$herbario."','".$tombo."'],";
	}
	else
	{
		$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."','".$coletor."','".$herbario."','".$tombo."']";
		$latcenter = $row['lat'];
		$longcenter = $row['long'];
	}
	$icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
	if ($row['idstatusoccurrence']!='')
	{
		$icone = 'http://maps.google.com/mapfiles/ms/icons/'.$row['pathicon'];
	}
	?>
								
    <tr class="even pointer points-table-line">
        <td class="a-center "><input type="checkbox" name="table_records[]" id="table_records[]" value="<?php echo $row['idoccurrence'];?>" ><a data-toggle="tooltip" data-placement="top" title data-original-title="Editar" onclick="abreModal('<?php echo $row['taxon'];?>','<?php echo $row['lat'];?>','<?php echo $row['long'];?>','<?php echo $row['idoccurrence'];?>','<?php echo $row[''];?>','<?php echo $row[''];?>','<?php echo $servidor;?>','<?php echo $path;?>','<?php echo $arquivo;?>','<?php echo $row['idstatusoccurrence'];?>','<?php echo $localizacao;?>','<?php echo $coletor;?>','<?php echo $herbario;?>','<?php echo $tombo;?>')">  <span class="glyphicon glyphicon-edit edit-button" aria-hidden="true"></span></a></td><td><?php echo $html_imagem.' ';?></td>
        <td class="a-right a-right "><b><?php echo $row['fonte'];?></b></br><?php echo $row['herbario'];?></td>
		<td class="a-right a-right " style="width: 200px;"><?php echo $row['taxon'];?></td>
        <td class="a-right a-right "><?php echo $row['collector'];?> <?php echo $row['collectnumber'];?></td>
        <td class=" "><?php if($row['country']) echo $row['country'] . ',';?> <?php if($row['majorarea']) echo $row['majorarea'] . '-';?> <?php if($row['minorarea']) echo $row['minorarea'] . '.';?><br>(<?php echo $row['lat'];?>,<?php echo $row['long'];?>)</td>
        <td class=" " style="width: 200px;"><?php echo "<image src='".$icone."'>".' '.$row['statusoccurrence'];?></td>
    </tr>
	<?php }// while  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
	
	<!-- Modal -->
	<div class="modal fade" id="ConfirmCleanModalDataCleaning" tabindex="-1" role="dialog" aria-labelledby="ConfirmCleanLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ConfirmCleanLabel">Limpar Dados</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Deseja Limpar todos os dados desse Experimento ?</p>
					<div class="modal-footer cleanDataFooter">
						<button type="button" data-dismiss="modal" id="cleanButtonDataCleaning" class="btn btn-primary">Sim</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">Não</button>
					</div>
				</div>
			</div>
		</div>
	</div>


    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
	<script src="js/loading.js"></script>	

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhi_DlmaFvRu7eP357bOzl29fyZXKIJE0&libraries=drawing&callback=initMap" async defer></script>	

    <!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>

<script>

    function imprimirDC(tipo)
    {   
        document.getElementById('frm').target="_blank";//"'cons<?php echo strtolower($FORM_ACTION);?>.php';
        if (tipo=='PDF')
        {
            //console.log(document.getElementById('frm').action='export' + tipo + '.php?table=points')
            document.getElementById('frm').action='export' + tipo + '.php?table=points&expid=' + <?php echo $id;?>;
            document.getElementById('frm').submit();
        }
        if (tipo=='CSV')
        {
            //console.log(document.getElementById('frm').action='export' + tipo + '.php?table=points')
            document.getElementById('frm').action='export' + tipo + '.php?table=points&expid=' + <?php echo $id;?>;
            document.getElementById('frm').submit();
        }
    }

    function initMap() {
	<?php 
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	
	?>
	
    var map3 = new google.maps.Map(document.getElementById('map3'), {
     center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
	 mapTypeId: 'terrain',
	 gestureHandling: 'greedy',
        mapTypeControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['terrain','roadmap', 'satellite']
        },
        styles: [
            {
                "featureType": "landscape",
                "stylers": [
                    {"hue": "#FFA800"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {"hue": "#53FF00"},
                    {"saturation": -73},
                    {"lightness": 40},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {"hue": "#FBFF00"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {"hue": "#00FFFD"},
                    {"saturation": 0},
                    {"lightness": 30},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {"hue": "#00BFFF"},
                    {"saturation": 6},
                    {"lightness": 8},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {"hue": "#679714"},
                    {"saturation": 33.4},
                    {"lightness": -25.4},
                    {"gamma": 1}
                ]
            }
        ],
    zoom: 2
  });
 
  	var markers = [
        <?php echo $marker;?>
    ];
                        
    // Info Window Content
	
	var infoWindowContent = [
		<?php echo $info;?>
    ];

	var kmlLayer = new google.maps.KmlLayer({
    	url: 'http://model-r.jbrj.gov.br/v2/municipios.kml',
    	suppressInfoWindows: true,
    	map: map3,
    	preserveViewport: true
  	});


//        ['<div class="info_content">' +
 //       '<h3>Caesalpinia Echinata</h3>' +
  //      '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
   //     ['<div class="info_content">' +
    //    '<h3>Caesalpinia echinata</h3>' +
     //   '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +
      //  '</div>']
	
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        //bounds.extend(position);
		var icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
		if (markers[i][7]!='')
		{
			icone = 'http://maps.google.com/mapfiles/ms/icons/'+markers[i][7];
		}
		
        marker = new google.maps.Marker({
            position: position,
            map: map3,
			draggable: false,
            title: markers[i][0],
			icon: icone,
			scrollwheel:true
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],'','',markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9],markers[i][10],markers[i][11],markers[i][12]);
				
            }
        })(marker, i));
		
        // Automatically center the map fitting all markers on the screen
       // map3.fitBounds(bounds);
    }

	tabMap = map3;
	initMapModal()//start map inside modal
  
}

var tabMap;
var modalMap;

function initMapModal(idocorrencia) {
	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>
	
    var map4 = new google.maps.Map(document.getElementById('map4'), {
     center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
	 mapTypeId: 'terrain',
	 gestureHandling: 'greedy',
        mapTypeControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['terrain','roadmap', 'satellite']
        },
        styles: [
            {
                "featureType": "landscape",
                "stylers": [
                    {"hue": "#FFA800"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {"hue": "#53FF00"},
                    {"saturation": -73},
                    {"lightness": 40},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {"hue": "#FBFF00"},
                    {"saturation": 0},
                    {"lightness": 0},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {"hue": "#00FFFD"},
                    {"saturation": 0},
                    {"lightness": 30},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {"hue": "#00BFFF"},
                    {"saturation": 6},
                    {"lightness": 8},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {"hue": "#679714"},
                    {"saturation": 33.4},
                    {"lightness": -25.4},
                    {"gamma": 1}
                ]
            }
        ],
    zoom: 2
  });
 
  	var markers = [
        <?php echo $marker;?>
    ];
                        
    // Info Window Content
	
	var infoWindowContent = [
		<?php echo $info;?>
    ];

//        ['<div class="info_content">' +
 //       '<h3>Caesalpinia Echinata</h3>' +
  //      '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
   //     ['<div class="info_content">' +
    //    '<h3>Caesalpinia echinata</h3>' +
     //   '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +
      //  '</div>']
	
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  

    for( i = 0; i < markers.length; i++ ) {
		if(markers[i][3] != idocorrencia) continue; //only print clicked ocurrence
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        //bounds.extend(position);
		var icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
		if (markers[i][7]!='')
		{
			icone = 'http://maps.google.com/mapfiles/ms/icons/'+markers[i][7];
		}
		
        marker = new google.maps.Marker({
            position: position,
            map: map4,
			draggable: true,
            title: markers[i][0],
			icon: icone,
			scrollwheel:true
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],'','',markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9],markers[i][10],markers[i][11],markers[i][12]);
				
            }
        })(marker, i));
		
        google.maps.event.addListener(marker, 'dragend', (function(marker, i) {
            return function() {
				abreConfirmacao(markers[i][0],markers[i][1],markers[i][2],markers[i][3],this.position.lat(),this.position.lng(),markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9],markers[i][10],markers[i][11],markers[i][12]);
				//abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],this.position.lat(),this.position.lng(),markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9]);
				
            }
        })(marker, i));
        // Automatically center the map fitting all markers on the screen
       // map3.fitBounds(bounds);
    }

	modalMap = map4;

  
}

var ids = [];

function atualizarPontos(idponto,idstatus,latinf,longinf,statusOnly)
{
	//alert('?idstatus='+idstatus+'&idponto='+idponto+'&latinf='+latinf+'&longinf='+longinf);

	exibe('loading','Atualizando Status');
	document.getElementById('frm').action='exec.atualizarpontos.php?id='+ <?php echo $id;?> +'&idstatus='+idstatus+'&idponto='+idponto+'&latinf='+latinf+'&longinf='+longinf + '&statusOnly='+statusOnly;
    document.getElementById('frm').submit();
}

function atualizarMultiplosPontos(idponto,idstatus,latinf,longinf)
{
	//alert('exec.atualizarpontos.php?idstatus='+idstatus+'&idponto='+ids.join(',')+'&latinf='+latinf+'&longinf='+longinf);
	
	exibe('loading','Atualizando Status');
	document.getElementById('frm').action='exec.atualizarpontos.php?id='+ <?php echo $id;?> +'idstatus='+idstatus+'&idponto='+ids.join(',')+'&mult=true';
	document.getElementById('frm').submit();
}

function abreModelMultiplosPontos()
{  
    var docs = document.getElementsByName('table_records[]');
	if (contaSelecionados(docs)>0)
	{
        for(var i = 0; i < docs.length; i++){
            if (docs[i].checked){
                ids.push(docs[i].value);
            }
        }
		$('#myModalstatusoccurrence').modal('show');
	}
	else
	{
		criarNotificacao('Atenção','Selecione os registros que deseja alterar o status','warning');
	}
}

function abreModal(taxon,lat,lng,idocorrencia,latinf,lnginf,servidor,path,arquivo,idstatusocorrence,localizacao, coletor, herbario, tombo)
{

   document.getElementById('divtaxon').innerHTML=taxon;
	html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho=&arquivo='+arquivo+' target=\"Visualizador\"><img src="http://'+servidor+'/fsi/server?type=image&source='+path+'/'+arquivo+'&width=600&height=200&profile=jpeg&quality=20"></a>';
	document.getElementById('edidocorrencia').value=idocorrencia;
	document.getElementById('divimagem').innerHTML=html_imagem;
	document.getElementById('dadosoriginais').innerHTML='Latitude: '+lat+' Longitude: '+lng+' - '+localizacao;
	document.getElementById('dadoscoletor').innerHTML='Coletor: '+coletor;
	document.getElementById('dadosherbario').innerHTML='Herbário: '+herbario + ' - Tombo: ' + tombo;
	document.getElementById('edtlatitude').value=lat;
	document.getElementById('edtlongitude').value=lng;
	document.getElementById('cmboxstatusoccurrence').value=idstatusocorrence;
	$('#pointModal').modal('show');
	setTimeout(() => { 
		initMapModal(idocorrencia);
	}, 200);
}

function abreConfirmacao(taxon,lat,lng,idocorrencia,latinf,lnginf,servidor,path,arquivo,idstatusocorrence,localizacao)
{
	
	html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho=&arquivo='+arquivo+' target=\"Visualizador\"><img src="http://'+servidor+'/fsi/server?type=image&source='+path+'/'+arquivo+'&width=600&height=200&profile=jpeg&quality=20"></a>';

	document.getElementById('edidocorrenciaconfirmacao').value=idocorrencia;
	document.getElementById('edtlatitudeconfirmacao').value=latinf;
	document.getElementById('edtlongitudeconfirmacao').value=lnginf;
	document.getElementById('cmboxstatusoccurrenceconfirmacao').value='6';
	$('#confirmationModal').modal('show');
}

function filtrar(idstatusoccurrence)
{
	//exibe('loading','Filtrando');
	console.log(document.getElementById('frm'))
	// document.getElementById('frm').action='cadexperimento.php?tab=3&filtro='+idstatusoccurrence;
    document.getElementById('frm').action='cadexperimento.php?op='+'<?php echo $op;?>'+'&tab=10&id='+'<?php echo $id;?>' + '&filtro='+idstatusoccurrence;
	document.getElementById('frm').submit();
}

function excluirPontosDuplicados()
{
	exibe('loading','Excluindo pontos duplicados');
	document.getElementById('frm').action='exec.excluirpontosduplicados.php';
	document.getElementById('frm').submit();
}

function marcarPontosDuplicados()
{
	exibe('loading','');
	document.getElementById('frm').action='exec.marcarpontosduplicados.php';
	document.getElementById('frm').submit();
}

$('.nav-tabs a[href="#tab_content3"]').click(function(){
    $(this).tab('show');
    initMap();
    setTimeout(function(){ 
        google.maps.event.trigger(tabMap, "resize");
        tabMap.setCenter({lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>});
    }, 200);
})

$('.nav-tabs a[href="#tab_content3"]').click(function(){
    $(this).tab('show');
	//filtrar('');
})	

$('#pointModal').on('shown', function () {
		google.maps.event.trigger(modalMap, "resize");
    });

function liberarExperimentoReflora(){
    //document.getElementById('frm').action='exec.experimento.php?page=dc&op=LE&id=' + <?php echo $id?>;
	exibe('loading');
  	document.getElementById('frm').action='setupmodelagem.php?expid=' + <?php echo $id?>;
	document.getElementById('frm').submit();
	
	// xmlhttp=new XMLHttpRequest();
	// xmlhttp.onreadystatechange=function()  {
	// 	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	// 		console.log('Terminou');
    //         console.log('entrou' + xmlhttp.responseText);
    //         exibe('loading');
    //         window.location.href = url;
	// 	}
	// }
	// xmlhttp.open("GET",'setupmodelagem.php?expid=' + <?php echo $id?>,true);
	// xmlhttp.send();
		
}

$('#ConfirmCleanModalDataCleaning').modal({ show: false});

function confirmarLimparDados()
{   
	$('#ConfirmCleanModalDataCleaning').modal('show');
}
$("#cleanButtonDataCleaning").click(function() {
	document.getElementById('frm').action='exec.experimento.php?id='+<?php echo $id; ?>+'&op=LDDC';
	document.getElementById('frm').submit();
});
	

</script>
