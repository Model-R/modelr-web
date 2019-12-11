<?php session_start();
//print_r ($_SESSION['s_taxon']);
$especiesReflora = $_SESSION['s_taxon'];
$usuarioreflora = 5; // id tipo usuario reflora;


header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Origin: http://php7.jbrj.gov.br');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-type: text/html; charset=UTF-8");

require_once('classes/conexao.class.php');
require_once('classes/experimento.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

$idsource = $_REQUEST['cmboxfonte'];
$especie = $_REQUEST['edtespecie'];

if ($op=='A')
{
	$Experimento->getById($id);
	$idexperiment = $Experimento->idexperiment;
	$name = $Experimento->name ;
	$description = $Experimento->description ;
	//$automaticFilter = $Experimento->automaticfilter ;
	//$bool_automaticfilter = $automaticFilter === 't'? true: false;
}

?>

<link href="css/dadosbioticos.css" rel="stylesheet" type="text/css" media="all">

<div class="modal fade" id="instructionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
        <div class="modal-header">
            <h4 class="modal-title" >Instruções CSV</h4>
        </div>
        <!-- dialog body -->
        <div class="modal-body" style="font-size: 16;"> 
            <p>
                O CSV deve seguir o seguinte modelo:
                <br><br>
                [sp*],[lat*],[long*],[num_coleta],[país],[estado],[municipio],[localidade],[coletor]
                <br><br>
				<img src='imagens/exemplo csv entrada modelr.PNG' style="width: 100%;">
				<br><br>
				Caso o campo não exista, basta não colocá-lo no CSV.
				Os campos podem estar em qualquer ordem.
				<br><br>
                Todos os dados podem ser separados por vírgula(,), dois pontos(:) ou ponto e vírgula(;).
                Não é necessário marcar o final da linha. 
                <br><br>
                Restrições:
                <br><br>
                Espécies: O nome da espécie deve ser sem acento;
                <br><br>
                Longitude: Valor decimal (ex.: -11.6358334);
                <br><br>
                Latitude: Valor decimal (ex.: -41.0013889);
				<br><br>
				<b>*Campos obrigatórios</b>
            </p>
        </div>
        <!-- dialog buttons -->
        <div class="modal-footer csv-modal-footer"> 
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="multSpeciesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content"> 
        <div class="modal-header">
            <h4 class="modal-title" >Múltiplas Espécies</h4>
        </div>
        <!-- dialog body -->
        <div class="modal-body"> 
            <p>
                Você está adicionando mais de uma espécie. Gostaria de adicionar todas as ocorrências 
				no mesmo experimento ou criar um experimento para cada espécie ? 
            </p>
        </div>
        <!-- dialog buttons -->
        <div class="modal-footer csv-modal-footer"> 
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="sameExperiment()">Mesmo Experimento</button>
			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="moreThanOneExperiment()">Mais de um Experimento</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal --> 
<div class="modal fade" id="ConfirmAutomaticFilter" tabindex="-1" role="dialog" aria-labelledby="ConfirmAutomaticFilterLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ConfirmAutomaticFilterLabel">Adicionar Ocorrências</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Todos os filtros serão executados automaticamente. Esta operação pode demorar alguns minutos. Deseja continuar ?</p>
				<div class="modal-footer ConfirmAutomaticFilterFooter">
					<button type="button" data-dismiss="modal" id="ConfirmAutomaticFilterButton" class="btn btn-primary">Sim</button>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Não</button>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
    <h2>Dados Bióticos <small></small></h2>
    <div class="clearfix">
    </div>
    </div>
    <form name='frm2' id='frm2' action='' method="post" class="form-horizontal form-label-left" novalidate>
        <input id="op" value="<?php echo $op;?>" name="op" type="hidden">
        <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
        <div class="x_content">
        <div>
            <div class="item form-group files-options">
            <label class="control-label" for="email">Fonte<span class="required">*</span>
            </label>
            <div class="">
                <div class="radio-group" style="width:300px;">
                    <div><input type="checkbox" name="fontebiotico[]" id="checkfontejabot" value="1" <?php if (in_array('1', $_REQUEST['fontebiotico'])) echo "checked";?> /> JABOT</div>
                    <div><input type="checkbox" name="fontebiotico[]" id="checkfontegbif" value="2" <?php if (in_array('2', $_REQUEST['fontebiotico'])) echo "checked";?>/> GBIF</div>
                    <!--<div><input type="radio" disabled name="fontebiotico[]" id="checkfontesibbr" value="2" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> SiBBr</div>-->
					<div><input type="checkbox" name="fontebiotico[]" id="checkfontehv" value="4" <?php if (in_array('4', $_REQUEST['fontebiotico'])) echo "checked";?>/> HV</div>
					<div><input type="checkbox" name="fontebiotico[]" id="checkfontespecieslink" value="5" <?php if (in_array('5', $_REQUEST['fontebiotico'])) echo "checked";?>/> Species Link</div>
                    <div><input disabled type="checkbox" name="fontebiotico[]" id="checkfontesibbr" value="3" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> SiBBr</div>
					<div><input <?php if ($_SESSION['s_idtipousuario']==$usuarioreflora){ echo "disabled" ;} ?> type="checkbox" name="fontebiotico[]" id="checkfontecsv" value="3" <?php if ($_REQUEST['fontebiotico'][0]=='3') echo "checked";?>/> CSV</div>
                </div>
                <div class="csv-button" <?php if ($_SESSION['s_idtipousuario']==$usuarioreflora){ echo 'style="display:none"' ;} ?>>
                    <form enctype="multipart/form-data"><label id="label-arquivo" for='upload'>Arquivo CSV</label><input id="upload" type=file accept="text/csv" name="files[]" size=30></form>
                    <div onclick="showInstructions()">
                    <span style="cursor: pointer;">Instruções</span>
				</div>
				
            </div>
            
            <span id="filename"></span>
            </div>
            </div>
            <div id="csv-separator" class="item form-group files-options">
                <label class="control-label" for="email">Selecione o separador do CSV<span class="required">*</span></label>
                <select id="csv-select">
                    <option value=",">Vírgula (,)</option>
                    <option value=";">Ponto e vírgula (;) </option>
                    <option value=":">Dois pontos (:)</option>
                </select>
            </div>
            <div class="item form-group species-name">
                <div class="">
                    <div class="input-group">
						<?php if ($_SESSION['s_idtipousuario']==$usuarioreflora){
                            echo "<select id='edtespecie' name='edtespecie' class='form-control'>";
                            while (list ($key,$val) = @each($especiesReflora)) {
								$valor = explode(' ',$val);
								
								$s = '';
								if ($description==$valor[0])
								{
									$s = 'selected';
								}
								
                                echo "<option value='".$valor[0]."' ".$s.">" . $val . "</option>";
                             }
                             echo "</select>";
						}?>
							
                        <?php if ($_SESSION['s_idtipousuario']!=$usuarioreflora){ ?>
                            <input id="edtespecie" value="<?php echo $especie;?>"  name="edtespecie" class="form-control col-md-7 col-xs-12" >
                        <?php } ?>
                        <span class="input-group-btn"><button type="button" onclick="buscar()" class="btn btn-primary" >Buscar</button>
                        <button type="button" onclick="confirmarFiltrarDados()" class="btn btn-success btn"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Adicionar</button></span>
                    </div>
					<div class="">
						<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtfiltroautomatico"></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="checkbox" name="edtfiltroautomatico" id="edtfiltroautomatico">Executar filtros automaticamente<br>
							</div>
						</div>
					</div>
					<div id="erro-busca" style="display:none">
						<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtfiltroautomatico"></label>
							<div class="col-md-6 col-sm-6 col-xs-12" style="color: red;font-weight: 700;">
								<span>Nenhum resultado foi encontrado !</span>
							</div>
						</div>
					</div>
                </div>
            </div>
        </form>
    </div>		
    <!--id="check-all" class="flat"-->
    <div id='div_resultadobusca'>
        <table class="table table-striped responsive-utilities jambo_table bulk_action">
        <?php 
        //1 jabot
        //2 Gbif
        if ((!empty($especie)) && ($_REQUEST['fontebiotico'][0]=='1'))
        {
			$ws = file_get_contents("https://model-r.jbrj.gov.br/modelr-web/execjabot.php?especie=" . $especie);
        } // if ((!empty($especie)) && ($_REQUEST['fontebiotico'][0]=='JABOT'))
	?>

                            </tbody>
                        </table>
                    </div>
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

    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
	<script src="js/loading.js"></script>	

    <!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>	
    
<script>

var busca = <?php if($_REQUEST['busca']){
					echo 'true';
				} else {
					echo 'false';
				}?>;
				
function confirmarFiltrarDados()
{   
	if(document.getElementById('edtfiltroautomatico').checked){
		$('#ConfirmAutomaticFilter').modal('show');
	} else {
		adicionarOcorrencia();
	}
}
$("#ConfirmAutomaticFilterButton").click(function() {
	adicionarOcorrencia();
});
//exibe('loading','Buscando Ocorrências');

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
	console.log('conta selecionados', conta);
	return conta;
}

   
function getSibbr(sp)
{
    var destinationUrl = 'https://gbif.sibbr.gov.br/api/v1.1/ocorrencias?scientificname=' + sp + '&ignoreNullCoordinates=true';
    $.ajax({
      type: 'GET',
      url: destinationUrl,
      dataType: 'json', // use json only, not jsonp
      crossDomain: true, // tell browser to allow cross domain.
      success: successResponse,
      error: failureFunction
    });

}

function successResponse(data) {
    //console.log('success');
    //console.log(data);
  }

 function failureFunction(data) {
    //console.log('failure');
    //console.log(data);
  }

function getCORS(url, success) {
    var xhr = new XMLHttpRequest();
    if (!('withCredentials' in xhr)) xhr = new XDomainRequest(); // fix IE8/9
    xhr.open('GET', url);
    xhr.onload = success;
    xhr.send();
    return xhr;
}
  
  // Helper method to parse the title tag from the response.
  function getTitle(text) {
    return text.match('<title>(.*)?</title>')[1];
  }
  

function getTaxonKeyGbif(sp)
{
	exibe('loading','Buscando Ocorrências');
	document.getElementById('erro-busca').style.display = 'none';
	if(document.getElementById('checkfontegbif').checked==true){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				//console.log('resultado gbif');
				var myObj = JSON.parse(this.responseText);
				if(myObj.results.length){
					let data = myObj.results.find((res) => res.taxonomicStatus == 'ACCEPTED');
					let key = data.key
					document.getElementById("demo").innerHTML = key; //this.responseText;//myObj.result[key];//count;
					//gbif(key);
					jabot(key)
				} else {
					jabot(null);
				}
			}
		};
		xmlhttp.open("GET", "https://api.gbif.org/v1/species?name="+sp, true);
		xmlhttp.send();
	} else if (document.getElementById('checkfontejabot').checked==true){
		jabot(null);
	}
}

async function jabot (gbifTaxonKey) {
	let synonyms = await getSpecieSynonym(<?php echo '"' . $especie . '"'; ?>)
	console.log(synonyms);
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			//console.log(this.responseText)
			if(gbifTaxonKey && this.responseText != ']') getAllGbif(gbifTaxonKey, 0, [], JSON.parse(this.responseText))
			else if(gbifTaxonKey && this.responseText == ']') getAllGbif(gbifTaxonKey, 0, [], [])
			else if (!gbifTaxonKey && this.responseText == ']'){
				exibe('loading','Buscando Ocorrências');
				document.getElementById('erro-busca').style.display = 'block';
			}
			else printData([], JSON.parse(this.responseText), [])
		}
	};
	
	if(document.getElementById('checkfontejabot').checked==true){
		xmlhttp.open("GET", `https://model-r.jbrj.gov.br/modelr-web/execjabot.php?especie=${synonyms.join(',')}`);
		xmlhttp.send();
	} else {
		//gbif(gbifTaxonKey, [])
		getAllGbif(gbifTaxonKey, 0, [], [])
	}
}

function printJabotOnly(jabotData){
	
	var body = '';		
	//print jabot
	exibe('loading','Buscando Ocorrências');
	//console.log(jabotData[0])
	for (i = 0; i < jabotData.length; i++) {
		//alert(i);
		longitude = jabotData[i].longitude;
		latitude = jabotData[i].latitude;
			
		taxon = jabotData[i].taxoncompleto;
		tombo = jabotData[i].numtombo;
		coletor = jabotData[i].coletor;
		numcoleta = jabotData[i].numcoleta;
		pais = jabotData[i].pais;
		estado = jabotData[i].estado;
		cidade = jabotData[i].municipio;
		herbario = jabotData[i].herbario;
		
		//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
		var idexperimento = document.getElementById('id').value;
		var html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='+jabotData[i].codtestemunho+'&arquivo='+jabotData[i].arquivo+' target=\'Visualizador\'><img src="http://'+jabotData[i].servidor+'/fsi/server?type=image&source='+jabotData[i].path+'/'+jabotData[i].arquivo+'&width=300&height=100&profile=jpeg&quality=20"></a>'
		var Jval = jabotData[i].codtestemunho; 

			body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
			body +='<td class=" ">'+html_imagem+taxon+'</td>';
			body +='<td class="a-right a-right ">Jabot</td>';
            body +='<td class="a-right a-right ">'+herbario+'</td>';
			body +='<td class="a-right a-right ">'+tombo+'</td>';
			body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
			body +='<td class=" ">'+latitude+', '+longitude+'</td>';
			body +='<td class=" ">'+pais+', '+estado+' - '+cidade+'</td>';
		
	}
	
	var table = '';
	table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Táxon </th><th class="column-title">Origem </th><th class="column-title">Coleção</th><th class="column-title">Tombo </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
	table += '<th class="column-title">Localização</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody><td class="a-center total-busca" colspan=8>Total:' + (jabotData.length)  + '</td>'+body+'</tbody></table>';
	table += '';
	
	document.getElementById("div_resultadobusca").innerHTML = table;
}

//function gbif(taxonKey, jabotData)
async function printData(gbifData, jabotData, HVdata = [], spLinkData = [])
{		

	var body = '';
	var especie;
	//print gbif
	for (i = 0; i < gbifData.length; i++) {
		especie = gbifData[0].scientificName;
		//alert(i);
		longitude = gbifData[i].decimalLongitude;
		latitude = gbifData[i].decimalLatitude;

		taxon = gbifData[0].scientificName;
		tombo = gbifData[i].catalogNumber;
		coletor = gbifData[i].recordedBy || '';
		numcoleta = gbifData[i].recordNumber;
		pais = gbifData[i].country || '';
		estado = gbifData[i].stateProvince || '';
		cidade = gbifData[i].municipality || '';
		herbario = gbifData[i].datasetName || '';
		localidade = gbifData[i].locality || '';
		
		//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
		var idexperimento = document.getElementById('id').value;
		//split * 
		var Jval = idexperimento + '*2*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'****'+ pais+'*'+ estado+'*'+ cidade + '*' + herbario + '*' + tombo + '*' + localidade; 

			body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
			body +='<td class=" ">'+taxon+'</td>';
			body +='<td class="a-right a-right ">GBIF</td>';
			body +='<td class="a-right a-right ">'+herbario+'</td>';
			body +='<td class="a-right a-right ">'+tombo+'</td>';
			body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
			body +='<td class=" ">'+latitude+', '+longitude+'</td>';
			body +='<td class=" ">'+pais+'</td>';
			body +='<td class=" ">'+estado+'</td>';
			body +='<td class=" ">'+cidade+'</td>';
			body +='<td class=" ">'+localidade+'</td>';
	}
	
	//print jabot
	for (i = 0; i < jabotData.length; i++) {
		//alert(i);
		longitude = jabotData[i].longitude;
		latitude = jabotData[i].latitude;
		
		especie = especie || jabotData[i].taxoncompleto;

		taxon = jabotData[i].taxoncompleto || '';
		tombo = jabotData[i].numtombo;
		coletor = jabotData[i].coletor || '';
		numcoleta = jabotData[i].numcoleta;
		pais = jabotData[i].pais || '';
		estado = jabotData[i].estado || '';
		cidade = jabotData[i].municipio || '';
		herbario = jabotData[i].herbario || '';
		localidade = jabotData[i].localidade || '';
		
		//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
		var idexperimento = document.getElementById('id').value;
		var html_imagem='<a href=templaterb2.php?colbot=rb&codtestemunho='+jabotData[i].codtestemunho+'&arquivo='+jabotData[i].arquivo+' target=\'Visualizador\'><img src="http://'+jabotData[i].servidor+'/fsi/server?type=image&source='+jabotData[i].path+'/'+jabotData[i].arquivo+'&width=300&height=100&profile=jpeg&quality=20"></a>'
		var Jval = jabotData[i].codtestemunho; 

			body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
			body +='<td class=" ">'+html_imagem+taxon+'</td>';
			body +='<td class="a-right a-right ">Jabot</td>';
			body +='<td class="a-right a-right ">'+herbario+'</td>';
			body +='<td class="a-right a-right ">'+tombo+'</td>';
			body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
			body +='<td class=" ">'+latitude+'<br>'+longitude+'</td>';
			body +='<td class=" ">'+pais+'</td>';
			body +='<td class=" ">'+estado+'</td>';
			body +='<td class=" ">'+cidade+'</td>';
			body +='<td class=" ">'+localidade+'</td>';
		
	}
	
	if(document.getElementById('checkfontehv').checked==true){
		HVdata = await getHV(especie);
		for (i = 0; i < HVdata.length; i++) {
			//alert(i);
			try {		
				longitude = HVdata[i].decimalLongitude;
				latitude = HVdata[i].decimalLatitude;

				//if (longitude == 'NA' || latitude == 'NA') continue;

				taxon = especie;
				tombo = HVdata[i].catalogNumber;
				coletor = HVdata[i].recordedBy;
				numcoleta = HVdata[i].recordNumber;
				pais = HVdata[i].country;
				estado = HVdata[i].stateProvince;
				cidade = HVdata[i].municipality;
				herbario = HVdata[i].collectionCode;
				localidade = HVdata[i].locality;
				
				//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
				var idexperimento = document.getElementById('id').value;
				var imageComponents = extractComponents(HVdata[i].associatedMedia);
				var html_imagem='<a href=templatehv.php?path='+imageComponents.path + '/' + imageComponents.file+' target=\'Visualizador\'><img src='+HVdata[i].associatedMedia.replace('imagens1','imagens4')+'&width=100&height=150></a>';
				//split * 
				var Jval = idexperimento + '*4*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'*'+imageComponents.server+'*'+imageComponents.path+'*'+imageComponents.file+'*'+ pais+'*'+ estado+'*'+ cidade + '*' + herbario + '*' + tombo + '*' + localidade; 
					body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
					body +='<td class=" ">'+html_imagem+ ' ' + taxon+'</td>';
					body +='<td class="a-right a-right ">HV</td>';
					body +='<td class="a-right a-right ">'+herbario+'</td>';
					body +='<td class="a-right a-right ">'+tombo+'</td>';
					body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
					body +='<td class=" ">'+latitude+', '+longitude+'</td>';
					body +='<td class=" ">'+pais+'</td>';
					body +='<td class=" ">'+estado+'</td>';
					body +='<td class=" ">'+cidade+'</td>';
					body +='<td class=" ">'+localidade+'</td>';
			} catch (error) {
				//console.log(error)
			}
		}
	}

	if(document.getElementById('checkfontespecieslink').checked==true){
		spLinkData = await getSpeciesLink(especie);
		for (i = 0; i < spLinkData.length; i++) {
			//alert(i);
			try {		
				longitude = spLinkData[i].decimalLongitude;
				latitude = spLinkData[i].decimalLatitude;
	
				//if (longitude == 'NA' || latitude == 'NA') continue;
	
				taxon = spLinkData[i].genus + ' ' + spLinkData[i].specificEpithet;
				tombo = spLinkData[i].catalogNumber;
				coletor = spLinkData[i].recordedBy;
				numcoleta = spLinkData[i].recordNumber;
				pais = spLinkData[i].country;
				estado = spLinkData[i].stateProvince;
				cidade = spLinkData[i].county;
				herbario = spLinkData[i].collectionCode;
				localidade = spLinkData[i].locality;
				imagecode = spLinkData[i].imagecode;
			
				//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
				var html_imagem='<a href=http://reflora-cdc.cria.org.br/inct/exsiccatae/viewer/imagecode/'+ imagecode+'/format/slide/foo/48941 target=\'Visualizador\'><img src=http://reflora-cdc.cria.org.br/inct/exsiccatae/image/imagecode/'+imagecode+'/size/thumb/format/jpeg/foo/48941></a>';
			
				//split * 
				var Jval = idexperimento + '*5*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'**'+imagecode+'**'+ pais+'*'+ estado+'*'+ cidade + '*' + herbario + '*' + tombo + '*' + localidade; 
					body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
					body +='<td class=" ">'+html_imagem+ ' ' + taxon+'</td>';
					body +='<td class="a-right a-right ">SpeciesLink</td>';
					body +='<td class="a-right a-right ">'+herbario+'</td>';
					body +='<td class="a-right a-right ">'+tombo+'</td>';
					body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
					body +='<td class=" ">'+latitude+', '+longitude+'</td>';
					body +='<td class=" ">'+pais+'</td>';
					body +='<td class=" ">'+estado+'</td>';
					body +='<td class=" ">'+cidade+'</td>';
					body +='<td class=" ">'+localidade+'</td>';
			} catch (error) {
				//console.log(error)
			}
		}
	}

	exibe('loading','Buscando Ocorrências');

	var table = '';
	table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Táxon </th><th class="column-title">Origem </th><th class="column-title">Coleção</th><th class="column-title">Tombo </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
	table += '<th class="column-title">País</th><th class="column-title">Estado</th><th class="column-title">Município</th><th class="column-title">Localidade</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody><td class="a-center total-busca" colspan=11>Total:' + (jabotData.length + gbifData.length + HVdata.length + spLinkData.length)  + '</td>'+body+'</tbody></table>';
	table += '';
		
	document.getElementById("div_resultadobusca").innerHTML = table;
	
}

function getAllGbif (taxonKey, offset, results, jabotData) {
	
	if(taxonKey == null){
		document.getElementById('erro-busca').style.display = 'block';
		exibe('loading','Buscando Ocorrências');
	} else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var data = JSON.parse(this.responseText);
				results = results.concat(data.results);
				offset += data.limit;
				if(offset < data.count){
					getAllGbif (taxonKey, offset, results, jabotData)
				} else {
					//imprimir results
					printData(results, jabotData)
				}
			};
		}
		xmlhttp.open("GET", "https://api.gbif.org/v1/occurrence/search?taxonKey="+taxonKey+'&limit=300&offset='+offset, true);
		xmlhttp.send();
	}
}

function adicionarOcorrencia()
{	
    console.log($("#frm2").serialize());
	if (contaSelecionados(document.getElementsByName('chtestemunho[]'))>0 && !multipleSpecies)
	{
		exibe('loading','Adicionando Ocorrências');
		document.getElementById('frm2').action='exec.adicionarocorrencia.php?filtro=' + document.getElementById('edtfiltroautomatico').checked;
		document.getElementById('frm2').submit();
	}
    else if(contaSelecionados(document.getElementsByName('chtestemunho[]'))>0 && multipleSpecies){
		$('#multSpeciesModal').modal('show');
    }
	else
	{
		criarNotificacao('Atenção','Selecione os registros que deseja adicionar','warning');
	}
}

function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // use the 1st file from the list
    f = files[0];

    var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {

		//console.log(e.target.result)
		var arr = e.target.result.split('\n');

		document.getElementById("checkfontecsv").checked = true;
		document.getElementById("filename").innerHTML = f.name;
		document.getElementById("csv-separator").style.display = 'flex';
		// console.log('inside get file')
		// console.log(arr)
		file = arr;
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsText(f);
  }

function printCSV(lines){
	var body = '';
	var separator = document.getElementById("csv-select").options[document.getElementById("csv-select").selectedIndex].value;
	
	var spindex, latindex, longindex, estadoindex, municipioindex, coletorindex, numcoletaindex, paisindex, localidadeindex;
	spindex = latindex = longindex = estadoindex = municipioindex = coletorindex = numcoletaindex = paisindex = localidadeindex = -1;
	var csv_headers = lines[0].split(separator);
	for (i = 0; i < csv_headers.length; i++) {
		if(csv_headers[i] == 'sp') spindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'lat') latindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'long') longindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'estado') estadoindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'municipio') municipioindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'coletor') coletorindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'num_coleta') numcoletaindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'país' || csv_headers[i].toLowerCase().replace(/\s/g, "") === 'pais') paisindex = i;
		else if(csv_headers[i].toLowerCase().replace(/\s/g, "") === 'localidade') localidadeindex = i;
	}
	
	if(spindex == -1 || latindex == -1 || longindex == -1){
		criarNotificacao('Atenção','Os campos sp, lat e long do csv são obrigatórios','warning');
	} else {
		checkIsMultipleSpecies(lines.slice(1), separator);
		for (i = 1; i < lines.length; i++) { //ignore csv headers 
			var values = lines[i].split(separator);
			//alert(i);
			//[espécie],[estado],[município],[coletor],[número de coleta],[longitude],[latitude]
			taxon = values[spindex];
			estado = values[estadoindex] || '';
			municipio = values[municipioindex] || '';
			coletor = values[coletorindex] || '';
			numcoleta = values[numcoletaindex] || null;
			longitude = values[longindex] || 0;
			latitude = values[latindex] || 0;
			pais = values[paisindex] || '';
			localidade = values[localidadeindex] || '';

			var idexperimento = document.getElementById('id').value;
			//split * 
			var Jval = idexperimento + '*2*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'****'+pais+'*'+estado+'*'+municipio+'***'+localidade; 
			 
			body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
			body +='<td class=" ">'+taxon+'</td>';
			body +='<td class=" ">'+coletor+'</td>';
			body +='<td class=" ">'+numcoleta+'</td>';
			body +='<td class=" ">'+pais+'</td>';
			body +='<td class=" ">'+estado+'</td>';
			body +='<td class=" ">'+municipio+'</td>';
			body +='<td class=" ">'+localidade+'</td>';
			body +='<td class=" ">'+latitude+', '+longitude+'</td>';

		}
		
		var table = '';
		table += '<table class="table table-csv table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
		table += '</th><th class="column-title">Taxon </th><th>Coletor</th><th>Número de Coleta</th><th>País</th><th>Estado</th><th>Município</th><th>Localidade</th><th class="column-title">Coordenadas</th>';
		table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
		table += '</th></tr></thead>';
		table += '<tbody>'+body+'</tbody></table>';
		table += '';
		
		document.getElementById("div_resultadobusca").innerHTML = table;
	}
	exibe('loading','Buscando Ocorrências');
}

  document.getElementById('upload').addEventListener('change', handleFileSelect, false);

var multipleSpecies = false;
function checkIsMultipleSpecies(lines, separator){

    var species = [];
    for (i = 0; i < lines.length-1; i++) {

		var values = lines[i].split(separator);
		species.push(values[0]);
	}

    var uniques = species.unique();
    if(uniques.length > 1) multipleSpecies = true;
    
    return;
}

Array.prototype.unique = function() {
    var arr = [];
    for(var i = 0; i < this.length; i++) {
        if(!arr.includes(this[i])) {
            arr.push(this[i]);
        }
    }
    return arr; 
}

function showInstructions() {
	$('#instructionModal').modal('show');
}

$(document).ready(function(){
    if(document.getElementById('checkfontejabot').checked==true || document.getElementById('checkfontegbif').checked==true){
        var especie = document.getElementById('edtespecie').value;
		getTaxonKeyGbif(especie);
    }
});

async function buscar()
{
	 if (document.getElementById('edtespecie').value=='' && document.getElementById('checkfontecsv').checked==false)// && document.getElementById('checkfontecsv').checked==false)
	 {
	 	criarNotificacao('Atenção','Informe o nome da espécie','warning')
	 }
	 else if (document.getElementById('checkfontejabot').checked==false && 
			document.getElementById('checkfontegbif').checked==false && 
			document.getElementById('checkfontesibbr').checked==false &&
			document.getElementById('checkfontehv').checked==false &&
			document.getElementById('checkfontespecieslink').checked==false &&
			document.getElementById('checkfontecsv').checked==false) {
			criarNotificacao('Atenção','Selecione pelo menos uma fonte de dados.','warning')
	 }
	 else
	 {   
		exibe('loading','Buscando Ocorrências');
	 	var texto = document.getElementById('edtespecie').value;
	 	var palavra = texto.split(' ');
		
         if (document.getElementById('checkfontejabot').checked==true || document.getElementById('checkfontegbif').checked==true)
         {
             document.getElementById('frm2').action="cadexperimento.php?id=" + '<?php echo $id;?>' + "&op=" + '<?php echo $op;?>' + "&busca=TRUE&tab=9";
             document.getElementById('frm2').submit();
         }
         else if (document.getElementById('checkfontesibbr').checked==true)
         {
            getSibbr(texto);
         }
		 else if (document.getElementById('checkfontehv').checked==true){
			var data = await getHV(texto);
			printHV(data)
		 }
		 else if (document.getElementById('checkfontespecieslink').checked==true){
			var spLinkData = await getSpeciesLink(texto);
			//console.log('data',spLinkData)
			printSpeciesLink(spLinkData)
		 }
         else printCSV(file);
     }
	 //exibe('loading','Buscando Ocorrências');
}

function sameExperiment () {
	exibe('loading','Adicionando Ocorrências');
	document.getElementById('frm2').action='exec.adicionarocorrencia.php';
	document.getElementById('frm2').submit();
}

function moreThanOneExperiment () {
    exibe('loading','Adicionando Ocorrências');
	document.getElementById('frm2').action='exec.adicionargrupo.php';
	document.getElementById('frm2').submit();
}
$('#checkfontecsv').on('change', function() {
    if(document.getElementById('checkfontecsv').checked){
        document.getElementById('checkfontejabot').checked = false;
        document.getElementById('checkfontegbif').checked = false;
		document.getElementById('checkfontehv').checked = false
		document.getElementById('checkfontespecieslink').checked = false
    }
});

$('#checkfontejabot').on('change', function() {
    if(document.getElementById('checkfontejabot').checked){
        document.getElementById('checkfontecsv').checked = false;
    }
});

$('#checkfontegbif').on('change', function() {
    if(document.getElementById('checkfontegbif').checked){
        document.getElementById('checkfontecsv').checked = false;
    }
});

$('#checkfontehv').on('change', function() {
    if(document.getElementById('checkfontehv').checked){
        document.getElementById('checkfontecsv').checked = false;
    }
});


$('#checkfontespecieslink').on('change', function() {
    if(document.getElementById('checkfontespecieslink').checked){
        document.getElementById('checkfontecsv').checked = false;
    }
});

function getHV(sp)
{
	return new Promise(function(resolve, reject) {
		$.get('searchRefloraIPT.php?expid=' + <?php echo $id;?> + '&sp=' + sp, function(data, status){
			for(let u of unicode){
				var regex = new RegExp(`\<${u.code}\>`, "g");
				data = data.replace(regex,u.char)
			}
			resolve(JSON.parse(data));
		});
	});
}

function printHV (data) {
	var body = '';
	//print gbif
	contador = 0;
	//console.log(data[0])
	exibe('loading','Buscando Ocorrências');
	for (i = 0; i < data.length; i++) {
		//alert(i);
		try {		
			longitude = data[i].decimalLongitude;
			latitude = data[i].decimalLatitude;

			//if (longitude == 'NA' || latitude == 'NA') continue;

			contador = contador + 1;
			taxon = data[i].genus + ' ' + data[i].specificEpithet;
			tombo = data[i].catalogNumber;
			coletor = data[i].recordedBy;
			numcoleta = data[i].recordNumber;
			pais = data[i].country;
			estado = data[i].stateProvince;
			cidade = data[i].municipality.toLowerCase().split(' ').map((s) => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
			herbario = data[i].collectionCode;
			localidade = data[i].locality;
			
			//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
			var idexperimento = document.getElementById('id').value;
			var imageComponents = extractComponents(data[i].associatedMedia);
			var html_imagem='<a href=templatehv.php?path='+imageComponents.path + '/' + imageComponents.file+' target=\'Visualizador\'><img src='+data[i].associatedMedia.replace('imagens1','imagens4')+'&width=100&height=150></a>';
			//split * 
			var Jval = idexperimento + '*4*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'*'+imageComponents.server+'*'+imageComponents.path+'*'+imageComponents.file+'*'+ pais+'*'+ estado+'*'+ cidade + '*' + herbario + '*' + tombo + '*' + localidade; 
				body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
				body +='<td class=" ">'+html_imagem+ ' ' + taxon+'</td>';
				body +='<td class="a-right a-right ">HV</td>';
				body +='<td class="a-right a-right ">'+herbario+'</td>';
				body +='<td class="a-right a-right ">'+tombo+'</td>';
				body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
				body +='<td class=" ">'+latitude+', '+longitude+'</td>';
				body +='<td class=" ">'+pais+'</td>';
				body +='<td class=" ">'+estado+'</td>';
				body +='<td class=" ">'+cidade+'</td>';
				body +='<td class=" ">'+localidade+'</td>';
		} catch (error) {
			//console.log(error)
		}
	}
	
	var table = '';
	table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Táxon </th><th class="column-title">Origem </th><th class="column-title">Coleção</th><th class="column-title">Tombo </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
	table += '<th class="column-title">País</th><th class="column-title">Estado</th><th class="column-title">Município</th><th class="column-title">Localidade</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody><td class="a-center total-busca" colspan=11>Total:' + (contador)  + '</td>'+body+'</tbody></table>';
	table += '';
	
	document.getElementById("div_resultadobusca").innerHTML = table;
}

function printSpeciesLink (data) {
	var body = '';
	//print gbif
	contador = 0;
	//console.log(data[0])
	exibe('loading','Buscando Ocorrências');
	for (i = 0; i < data.length; i++) {
		//alert(i);
		try {		
			longitude = data[i].decimalLongitude;
			latitude = data[i].decimalLatitude;

			//if (longitude == 'NA' || latitude == 'NA') continue;

			contador = contador + 1;
			taxon = data[i].genus + ' ' + data[i].specificEpithet;
			tombo = data[i].catalogNumber;
			coletor = data[i].recordedBy;
			numcoleta = data[i].recordNumber;
			pais = data[i].country;
			estado = data[i].stateProvince;
			cidade = data[i].county;
			herbario = data[i].collectionCode;
			localidade = data[i].locality;
			imagecode = data[i].imagecode;
			
			//$idexperimento,$idfontedados,$lat,$long,$taxon,$coletor,$numcoleta,$imagemservidor,$imagemcaminho,$imagemarquivo,$pais,$estado,$municipio
			var idexperimento = document.getElementById('id').value;
			var html_imagem='<a href=http://reflora-cdc.cria.org.br/inct/exsiccatae/viewer/imagecode/'+ imagecode+'/format/slide/foo/48941 target=\'Visualizador\'><img src=http://reflora-cdc.cria.org.br/inct/exsiccatae/image/imagecode/'+imagecode+'/size/thumb/format/jpeg/foo/48941></a>';
			
			//split * 
			var Jval = idexperimento + '*5*'+latitude+'*'+longitude+'*'+taxon+'*'+ coletor+'*'+numcoleta+'**'+imagecode+'**'+ pais+'*'+ estado+'*'+ cidade + '*' + herbario + '*' + tombo + '*' + localidade; 
				body += '<tr class="even pointer"><td class="a-center "><input name="chtestemunho[]" id="chtestemunho[]" value="'+Jval+'" type="checkbox" ></td>';
				body +='<td class=" ">'+html_imagem+ ' ' + taxon+'</td>';
				body +='<td class="a-right a-right ">SpeciesLink</td>';
				body +='<td class="a-right a-right ">'+herbario+'</td>';
				body +='<td class="a-right a-right ">'+tombo+'</td>';
				body +='<td class="a-right a-right ">'+coletor+' '+numcoleta+'</td>';
				body +='<td class=" ">'+latitude+', '+longitude+'</td>';
				body +='<td class=" ">'+pais+'</td>';
				body +='<td class=" ">'+estado+'</td>';
				body +='<td class=" ">'+cidade+'</td>';
				body +='<td class=" ">'+localidade+'</td>';
		} catch (error) {
			//console.log(error)
		}
	}
	
	var table = '';
	table += '<table class="table table-striped responsive-utilities jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="chkboxtodos2" name="chkboxtodos2" onclick="selecionaTodos2(true);">';
	table += '</th><th class="column-title">Táxon </th><th class="column-title">Origem </th><th class="column-title">Coleção</th><th class="column-title">Tombo </th><th class="column-title">Coletor </th><th class="column-title">Coordenadas </th>';
	table += '<th class="column-title">País</th><th class="column-title">Estado</th><th class="column-title">Município</th><th class="column-title">Localidade</th>';
	table += '<a class="antoo" style="color:#fff; font-weight:500;">Total de Registros selecionados: ( <span class="action-cnt"> </span> ) </a>';
	table += '</th></tr></thead>';
	table += '<tbody><td class="a-center total-busca" colspan=11>Total:' + (contador)  + '</td>'+body+'</tbody></table>';
	table += '';
	
	document.getElementById("div_resultadobusca").innerHTML = table;
}

async function getSpeciesLink(sp)
{	
	return new Promise(function(resolve, reject) {
		//console.log('species link ' + sp);
		var data = new FormData();
		data.append('ScientificName', sp);
		data.append('Scope', 'plants');
		data.append('Format', 'JSON');
		data.append("Images", "yes");
		
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'https://php7.jbrj.gov.br:8443/splink?ScientificName='+sp+'&Scope=plants&Format=JSON', true);
		xhr.onload = function () {
			// do something to response
			const data = JSON.parse(this.responseText);
			console.log(data) 
			resolve(data)
		};
		xhr.send();
	})
}

function getSpecieSynonym (sp) {
	return new Promise(function(resolve, reject) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var myObj = JSON.parse(this.responseText);
				if(myObj.results.length){
					let key = myObj.results[0]["key"];
					var xhr = new XMLHttpRequest();
					xhr.open('GET', 'https://api.gbif.org/v1/species/'+key+'/synonyms', true);
					xhr.onload = function () {
						// do something to response
						const data = JSON.parse(this.responseText);
						console.log(data) 
						let synonyms = [sp];
						for(let sym of data.results){
							synonyms.push(sym.canonicalName)
						}
						resolve(synonyms)
					};
					xhr.send();
				}
			}
		};
		xmlhttp.open("GET", "https://api.gbif.org/v1/species?name="+sp, true);
		xmlhttp.send();
	})
}

function extractComponents (url) {
	//server
	//console.log('hv url')
	//console.log(url)
	if(url.indexOf('|')) url = url.split('|')[0];
	var server = url.match(new RegExp('http://' + "(.*)" + '/fsi')) || url.match(new RegExp("(.*)" + '/fsi'));
	if(server && server.length) server = server[1];
	else server='';
	var path_file = url.match(new RegExp('source=' + "(.*)"));
	if(path_file && path_file.length) path_file = path_file[1];
	else path_file = ''
	path_file = path_file.split('/');
	var path = path_file.slice(0, -1).join('/');
	var file = path_file.slice(-1)[0]
	// console.log({ 'server': server, 'path': path, 'file':file });
	// console.log('\n\n')
	return { 'server': server, 'path': path, 'file':file }; 
}

var unicode = [
  {
    "code": "U\\+00C0",
    "char": "À"
  },
  {
    "code": "U\\+00C1",
    "char": "Á"
  },
  {
    "code": "U\\+00C2",
    "char": "Â"
  },
  {
    "code": "U\\+00C3",
    "char": "Ã"
  },
  {
    "code": "U\\+00C4",
    "char": "Ä"
  },
  {
    "code": "U\\+00C5",
    "char": "Å"
  },
  {
    "code": "U\\+00C7",
    "char": "Ç"
  },
  {
    "code": "U\\+00C8",
    "char": "È"
  },
  {
    "code": "U\\+00C9",
    "char": "É"
  },
  {
    "code": "U\\+00CA",
    "char": "Ê"
  },
  {
    "code": "U\\+00CB",
    "char": "Ë"
  },
  {
    "code": "U\\+00CC",
    "char": "Ì"
  },
  {
    "code": "U\\+00CD",
    "char": "Í"
  },
  {
    "code": "U\\+00CE",
    "char": "Î"
  },
  {
    "code": "U\\+00CF",
    "char": "Ï"
  },
  {
    "code": "U\\+00D2",
    "char": "Ò"
  },
  {
    "code": "U\\+00D3",
    "char": "Ó"
  },
  {
    "code": "U\\+00D4",
    "char": "Ô"
  },
  {
    "code": "U\\+00D5",
    "char": "Õ"
  },
  {
    "code": "U\\+00DA",
    "char": "Ú"
  },
  {
    "code": "U\\+00E0",
    "char": "à"
  },
  {
    "code": "U\\+00E1",
    "char": "á"
  },
  {
    "code": "U\\+00E2",
    "char": "â"
  },
  {
    "code": "U\\+00E3",
    "char": "ã"
  },
  {
    "code": "U\\+00E4",
    "char": "ä"
  },
  {
    "code": "U\\+00E7",
    "char": "ç"
  },
  {
    "code": "U\\+00E9",
    "char": "é"
  },
  {
    "code": "U\\+00EA",
    "char": "ê"
  },
  {
    "code": "U\\+00ED",
    "char": "í"
  },
  {
    "code": "U\\+00F3",
    "char": "ó"
  },
  {
    "code": "U\\+00F4",
    "char": "ô"
  },
  {
    "code": "U\\+00F5",
    "char": "õ"
  },
  {
    "code": "U\\+00FA",
    "char": "ú"
  }
]
</script>