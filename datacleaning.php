<?php session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
	header('Location: index.php');
}

?><!DOCTYPE html>
<html lang="en">
<head>
<?php require_once('classes/conexao.class.php');
	  require_once('classes/paginacao2.0.class.php');
	  require_once('classes/experimento.class.php');
	  require_once('classes/statusoccurrence.class.php');


	  
	  $FORM_ACTION = 'experimento';
	  $tipofiltro = $_REQUEST['cmboxtipofiltro'];
	  $valorfiltro = $_REQUEST['edtvalorfiltro'];
	  $ordenapor = $_REQUEST['cmboxordenar'];
	  
	  $idproject = $_REQUEST['idproject'];
	  
	  $idexperimento = $_REQUEST['id'];
	  $op = $_REQUEST['op'];
	  
	  $especie = $_REQUEST['edtespecie'];
	  
	  //print_r($_REQUEST);
	  
$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$StatusOccurrence = new StatusOccurrence();
$StatusOccurrence->conn = $conn;


$sql = 'select * from modelr.experiment e, modelr.project p where e.idproject = p.idproject 
 ';

if ($_SESSION['s_idtipousuario']=='1')
{
   $sql.= " and p.idusuario = ".$_SESSION['s_idusuario'];	
}
 
if ($tipofiltro=='EXPERIMENTO')
{
   $sql.= " and e.name ilike '%".$valorfiltro."%'";	
}

if (($ordenapor=='EXPERIMENTO') || ($ordenapor==''))
{
   $sql.= " order by e.name";	
}

if ($op=='A')
{
	$Experimento->getById($idexperimento);
}
	  
?>
<?php include "head.php";?>
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
	  #mapid { height: 180px; }
    </style>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css"
   integrity="sha512-wcw6ts8Anuw10Mzh9Ytw4pylW8+NAD4ch3lqm9lzAsTxg0GFeJgoAtxuCLREZSC5lUXdVyo/7yfsqFjQ4S+aKw=="
   crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js"
   integrity="sha512-mNqn2Wg7tSToJhvHcqfzLMU6J4mkOImSPTxVZAdo+lcPlk+GhZmYgACEe0x35K7YzW1zJ7XyJV/TT1MrdXvMcA=="
   crossorigin=""></script>

</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>

<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos o(s) registros(s)? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>


      <div id="wrapper">
        <!-- Navigation -->
		<?php include "menutop.php";?>

        <!-- Left navbar-header -->
		<?php //include "menu.php";?>

        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
		
		<form name='frm' id='frm' action='exec.experimento.php' method="post" class="form-horizontal form-label-left">
            <div class="container-fluid">
			<hr>
			<div class="row">
				<div class="col-sm-12">
					<div class="white-box">
						<h3 class="box-title">Simple Basic Map</h3>
						<div id="mapid"></div>
					</div>
				</div>
			</div>
			 <div class="row">
                    <div class="col-lg-12">
					
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Dados do Experimento</h3>
                            <!--<p class="text-muted m-b-20">Create responsive tables by wrapping any <code>.table</code> in <code>.table-responsive </code></p>-->
                            <div class="row">
			                    <div class="col-lg-3">
								<div class="form-group">
                                    <label for="cmboxtipofiltro">Experimento</label><?php echo $idexperimento;?>
                                    <?php echo $Experimento->listaCombo('cmboxexperimento',$idexperimento,'S',' class="form-control"',$idusuario);?>
                                </div>
								</div>
			                    <div class="col-lg-6">
								
                                <label for="edtnomeexperimento">Nome do Experimento</label>
								<div class="input-group">
                                    <input id="edtnomeexperimento" name="edtnomeexperimento" class="form-control" placeholder="Nome do Experimento" value="<?php echo $Experimento->name;?>">
									 <span class="input-group-btn">
									 <button class="btn btn-info" type="button">Alterar</button>
									</span>
								</div>
								</div>
								
							</div>
						</div> <!-- whitebox -->
						

                                        <div class="row">
											<div class="col-md-5 col-sm-5 col-xs-12">
											
												<div class="x_panel">
													<div class="x_title">
														<h2>Data Cleaning</h2>
														<div class="clearfix"></div>
													</div>
													<div class="row">
														
													</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
														<button id="send1" type="button" onclick="atualizarPontos('',10,'','')" class="btn btn-xs btn-warning">Fora limite Brasil</button>
														<button id="send2" type="button" onclick="atualizarPontos('',2,'','')" class="btn btn-xs btn-warning">Fora Município coleta</button>
														<!--<button id="send3" type="button" onclick="atualizarPontos('',11,'','')" class="btn btn-xs btn-warning">Coordenada no mar</button>
														<button id="send3" type="button" onclick="atualizarPontos('',12,'','')" class="btn btn-xs btn-warning">Coordenada invertida</button>
														--><button id="send3" type="button" onclick="atualizarPontos('',13,'','')" class="btn btn-xs btn-warning">Coordenada com zero</button>
														
														<button id="send4" type="button" onclick="marcarPontosDuplicados()" class="btn btn-xs btn-danger">Duplicatas</button>
														<!--<button id="send5" type="button" onclick="liberarParaModelagem()" class="btn btn-xs btn-success">Liberar Modelagem</button>-->
														</div>
													</div>
													<div class="row">
														<h3 class="box-title">Over Layer Map</h3>
														
													</div>
												</div>
											</div>
											<div class="col-md-7 col-sm-7 col-xs-12">
												<div class="x_panel">
													<div class="x_title">
														<div class="clearfix">
														</div>
																		
														<div class="row">
															<div class="col-md-6 col-sm-6 col-xs-12">
																<?php echo $StatusOccurrence->listaCombo('cmboxstatusoccurrencefiltro',$idstatusoccurrencefiltro,'N','class="form-control"','');?>
															</div>
															<div class="col-md-6 col-sm-6 col-xs-12">
																<button id="send" type="button" onclick="filtrar(document.getElementById('cmboxstatusoccurrencefiltro').value)" class="btn btn btn-success">Filtrar</button>
															</div>
														</div>	
															<table class="table table-striped responsive-utilities jambo_table bulk_action">
																<thead>
																	<tr class="headings">
																		<th>
																			<input type="checkbox" name="chkboxtodos" id="chkboxtodos" onclick="selecionaTodos(true);">
																		</th>
																		<th class="column-title">Taxon/Tombo/Coletor </th>
																		<th class="column-title">Lat/Long </th>
																		<th class="column-title">Status</th>
																		<th class="column-title">
																		<button type="button" class="btn btn-default btn-xs" onclick="abreModelStatusOcorrencia()"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</button>
	<!--<button type="button" class="btn btn-success btn-xs" onclick="liberaModelagem('<?php echo $row['idoccurrence'];?>','S')">
	  <span class="glyphicon glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
	</button>-->
																		</th>
																	</tr>
																</thead>
							<?php 
							$sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,
case when lat2 is not null then lat2
else
lat
end as lat,
case when long2 is not null then long2
else
long
end as long


 from modelr.occurrence, modelr.statusoccurrence where 
							occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
							idexperiment = ".$idexperimento;
							
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
							<?php 
							$c=0;
							while ($row = pg_fetch_array($res))
							{
								$servidor = $row['server'];
								$path =  $row['path'];
								$arquivo =  $row['file'];
								$localizacao = $row['country'].', '.$row['majorarea'].' - '.$row['minorarea'];
								
								$html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='.$row['codtestemunho'].'&arquivo='.$arquivo.' target=\"Visualizador\"><img src="http://'.$servidor.'/fsi/server?type=image&source='.$path.'/'.$arquivo.'&width=300&height=100&profile=jpeg&quality=20"></a>';
								
								// preparo os quadros de informação para cada ponto
								$c++;
								if ($c < $conta) {
									$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."'],";
//									$info.="['<div class=\"info_content\"><h2>".$row['taxon']."</h2><table><tr><td>".$html_imagem."</td><td> Tombo: ".$row['numtombo']."<br>Coletor: ".$row['coletor']." ".$row['numcoleta']." <br>Lat: ".$row['lat'].' Long:'.$row['long']."<br>Lat: <input type=\"text\" size=\"8\" id=\"edtlat".($c-1)."\"  name=\"edtlat".($c-1)."\" value=\"".$row['lat']."\">Long: <input type=\"text\" size=\"8\" value=\"".$row['long']."\"></td></tr><button id=\"send\" type=\"button\" onclick=\"excluirPontos(".$row['idoccurrence'].","")\" class=\"btn btn-danger btn-xs\">Excluir</button><button id=\"send\" type=\"button\" onclick=\"enviar()\" class=\"btn btn-default btn-xs\">Salvar Posição</button><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\".bs-example-modal-sm2\">Small modal</button></div>'],";
								}
								else
								{
									$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long'].",".$row['idoccurrence'].",'".$servidor."','".$path."','".$arquivo."','".$row['pathicon']."','".$row['idstatusoccurrence']."','".$localizacao."']";
									//$marker .= "['".$row['taxon']."', ".$row['lat'].",".$row['long']."]";
//									$info.="['<div class=\"info_content\"><h2>".$row['taxon']."</h2><table><tr><td>".$html_imagem."</td><td>Tombo: ".$row['numtombo']."<br>Coletor: ".$row['coletor']." ".$row['numcoleta']."<br>Lat: ".$row['lat'].' Long:'.$row['long']."</td></tr><button id=\"send\" type=\"button\" onclick=\"excluirPontos(".$row['idoccurrence'].","")\" class=\"btn btn-danger btn-xs\">Excluir</button><button id=\"send\" type=\"button\" onclick=\"enviar()\" class=\"btn btn-default btn-xs\">Salvar Posição</button></div>']";
									$latcenter = $row['lat'];
									$longcenter = $row['long'];
								}
								
								$icone = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
								if ($row['idstatusoccurrence']!='')
								{
									$icone = 'http://maps.google.com/mapfiles/ms/icons/'.$row['pathicon'];
								}
								
								
								?>
								
																<tr class="even pointer">
																	<td class="a-center "><input type="checkbox" name="table_records[]" id="table_records[]" value="<?php echo $row['idoccurrence'];?>" > <?php echo $html_imagem.' ';?></td>
																	<td class="a-right a-right "><?php echo $row['taxon'];?><br><?php echo $row['numtombo'];?><br>
																	<?php echo $row['coletor'];?> <?php echo $row['numcoleta'];?></td>
																	<td class=" "><?php echo $row['lat'];?><br><?php echo $row['long'];?></td>
																	<td class=" "><?php echo "<image src='".$icone."'>".' '.$row['statusoccurrence'];?></td>
																	<td><button type="button" class="btn btn-default btn-xs" onclick="abreModal('<?php echo $row['taxon'];?>','<?php echo $row['lat'];?>','<?php echo $row['long'];?>','<?php echo $row['idoccurrence'];?>','<?php echo $row[''];?>','<?php echo $row[''];?>','<?php echo $servidor;?>','<?php echo $path;?>','<?php echo $arquivo;?>','<?php echo $row['idstatusoccurrence'];?>','<?php echo $localizacao;?>')">
							  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</button>
							<?php if ($row['checked']==false)
							{
								$checkedcor='success';
								$checkedicon='ok-circle';
							}
							else
							{
								$checkedcor='danger';
								$checkedicon='ban-circle';
							}
							?>
							<!--<button type="button" class="btn btn-<?php echo $checkedcor;?> btn-xs" onclick="liberaModelagem('<?php echo $row['idoccurrence'];?>','S')">
							  <span class="glyphicon glyphicon glyphicon-<?php echo $checkedicon;?>" aria-hidden="true"></span> Liberar
							</button>
							-->
																	</td>
																
																</tr>
														<?php }  ?>
																<tr class="even pointer">
																	<td class="a-center " colspan=5>Total: <?php echo $c;?></td>
																</tr>
															</tbody>
														</table>
													</div>
                               
												</div><!-- /x-panel -->
											</div>
										</div><!-- /row -->

                                <!-- /tabs -->
                        
							
					</div>
                </div>
			
                
					</div>
					</form>
					<?php //require "rodape.php";?>

                </div>

			
            <!-- /page content -->

<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Counter js -->
    <script src="plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="plugins/bower_components/counterup/jquery.counterup.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <script src="plugins/bower_components/toast-master/js/jquery.toast.js"></script>
	
	<script>
	

function initMap() {
	var mymap = L.map('mapid').setView([51.505, -0.09], 13);
	
/*	<?php if (empty($latcenter))
	{
		$latcenter = -24.5452;
		$longcenter = -42.5389;
	}
	?>
	alert('1');
    var map3 = new google.maps.Map(document.getElementById('map3'), {
     center: {lat: <?php echo $latcenter;?>, lng: <?php echo $longcenter;?>},
    zoom: 2
  });
 
  	var markers = [
        <?php echo $marker;?>
    ];
                        
    // Info Window Content
	
	var infoWindowContent = [
		<?php echo $info;?>
    ];
	alert('2');


//        ['<div class="info_content">' +
 //       '<h3>Caesalpinia Echinata</h3>' +
  //      '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +        '</div>'],
   //     ['<div class="info_content">' +
    //    '<h3>Caesalpinia echinata</h3>' +
     //   '<p><button id="send" type="button" onclick="enviar()" class="btn btn-danger">Excluir</button><button id="send" type="button" onclick="excluirPonto()" class="btn btn-default">Salvar Posição</button></p>' +
      //  '</div>']
	
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
   	alert('3');

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
			draggable: true,
            title: markers[i][0],
			icon: icone
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],'','',markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9]);
				
            }
        })(marker, i));
		
        google.maps.event.addListener(marker, 'dragend', (function(marker, i) {
            return function() {
				abreModal(markers[i][0],markers[i][1],markers[i][2],markers[i][3],this.position.lat(),this.position.lng(),markers[i][4],markers[i][5],markers[i][6],markers[i][8],markers[i][9]);
				
            }
        })(marker, i));
        // Automatically center the map fitting all markers on the screen
       // map3.fitBounds(bounds);
    }
	alert('4');
*/
  
}	

// This example adds a user-editable rectangle to the map.
function selecionaTodos2(isChecked) {
	//alert('');
	var chks = document.getElementsByName('chtestemunho[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos2').checked;
				
	}
	
}

function selecionaTodos(isChecked) {
	//alert('');
	var chks = document.getElementsByName('table_records[]');
	var hasChecked = false;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		chks[i].checked=document.getElementById('chkboxtodos').checked;
				
	}
	
}


function filtrar(idstatusoccurrence)
{
	alert('');
	console.log('entrou filtrar dataclaning')
	initMap();
	//exibe('loading');
//	document.getElementById('frm').action='cadexperimento.php?tab=2&filtro='+idstatusoccurrence;/
//	document.getElementById('frm').submit();
}

function buscar()
{	
	alert('datacleaning')
	if (document.getElementById('edtespecie').value=='')
	{
		criarNotificacao('Atenção','Informe o nome da espécie','warning')
	}
	else
	{
		var texto = document.getElementById('edtespecie').value;
		var palavra = texto.split(' ');
		if ((palavra.length)<2)
		{
			criarNotificacao('Atenção','Informe o nome da espécie','warning');
		}
		else
		{
			document.getElementById('frm').action="cadexperimento.php?busca=TRUE";
			document.getElementById('frm').submit();
		}
	}
}

</script>
	
    <script type="text/javascript">
    $(document).ready(function() {
		
        /*$.toast({
            heading: 'Welcome to Elite admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'info',
            hideAfter: 3500,

            stack: 6
        })
		*/
    });
    </script>
    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="js/cbpFWTabs.js"></script>
    <script type="text/javascript">
    (function() {

        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });

    })();
    </script>
	
<script>
function contaSelecionados(objeto)
{
    var chks = objeto;
	var conta = 0;
	for (var i=0 ; i< chks.length; i++)
	{
		if (chks[i].checked){
			conta = conta + 1;
		}
	}
	return conta;
}
function abreModelStatusOcorrencia()
{
	if (contaSelecionados(document.getElementsByName('table_records[]'))>0)
	{
		$('#myModalstatusoccurrence').modal('show');
	}
	else
	{
		criarNotificacao('Atenção','Selecione os registros que deseja alterar o status','warning');
	}
}

function abreModal(taxon,lat,lng,idocorrencia,latinf,lnginf,servidor,path,arquivo,idstatusocorrence,localizacao)
{

   document.getElementById('divtaxon').innerHTML=taxon;
	
	html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho=&arquivo='+arquivo+' target=\"Visualizador\"><img src="http://'+servidor+'/fsi/server?type=image&source='+path+'/'+arquivo+'&width=300&height=100&profile=jpeg&quality=20"></a>';

	document.getElementById('edidocorrencia').value=idocorrencia;
	document.getElementById('divimagem').innerHTML=html_imagem;
	document.getElementById('dadosoriginais').innerHTML='Latitude: '+lat+' Longitude: '+lng+'<br>'+localizacao;
	document.getElementById('edtlatitude').value=latinf;
	document.getElementById('edtlongitude').value=lnginf;
	//alert(idstatusocorrence);
	document.getElementById('cmboxstatusoccurrence').value=idstatusocorrence;

	$('#myModal').modal('show');
}
	</script>
	
	
	
	<script>
	
<?php 

require 'MSGCODIGO.php';

?>
<?php $MSGCODIGO = $_REQUEST['MSGCODIGO'];
?>
		
	
	function limparDadosExperimento(idexperimento)
	{
		document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?id='+idexperimento+'&op=LD';
		document.getElementById('frm').submit();
	}
	function modelar(idexperimento)
	{
		document.getElementById('frm').action='cadmodelagem.php?id='+idexperimento;
		document.getElementById('frm').submit();
	}
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').target = '_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}

	function filterApply()
	{
		document.getElementById('frm').target = '_self';
		document.getElementById('frm').action='cons<?php echo strtolower($FORM_ACTION);?>.php';
    	document.getElementById('frm').submit();
		
	}

	function imprimir(tipo)
	{
		alert(tipo);
		document.getElementById('frm').target="_blank";//"'cons<?php echo strtolower($FORM_ACTION);?>.php';
		if (tipo=='pdf')
		{
			document.getElementById('frm').action='rel<?php echo strtolower($FORM_ACTION);?>.php';
			document.getElementById('frm').submit();
		}
		if (tipo=='xls')
		{
			document.getElementById('frm').action='rel<?php echo strtolower($FORM_ACTION);?>Excel.php';
			document.getElementById('frm').submit();
		}
	}

	function novo()
	{
		window.location.href = 'cad<?php echo strtolower($FORM_ACTION);?>.php?op=I&idproject=<?php echo $idproject;?>';
	}

	
	function removeFilter()
	{
		window.location.href = 'cons<?php echo strtolower($FORM_ACTION);?>.php';
	}

	function showExcluir()
	{
		$('#myModal').modal({
  		keyboard: true
	})
	}
	
	function excluir()
	{
		$('#myModal').modal('hide');
		document.getElementById('frm').action='exec.<?php echo strtolower($FORM_ACTION);?>.php?op=E';
  			document.getElementById('frm').submit();
	}	
	
	</script>

</body>

</html>