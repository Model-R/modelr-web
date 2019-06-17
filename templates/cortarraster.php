<link href="css/custom.css" rel="stylesheet">

<!--<div class="form-group shapebox-content" style="display: flex;flex-direction: row;width: 50%;text-align: center;margin: auto;justify-content: space-between;">-->
<div class="form-group shapebox-content" style="display: flex;flex-direction: row;text-align: center;margin: auto;justify-content: center;">
<!--    <label for="cmboxcortarraster" style="margin-top:7px">Selecionar Shape</label>
    <select id="cmboxcortarraster" name="cmboxcortarraster" class="form-control" style="width: 200px;">
        <option value="BACIAS" selected="selected">Bacias</option>
        <option value="BIOMAS">Biomas</option>
        <option value="VEGETACIONAIS">Tipos Vegetacionais</option>
    </select> 

    <button type="button" class="btn btn-info" onClick='cortarRaster()' data-toggle="tooltip" data-placement="top" title data-original-title="Cortar Raster" style="">Salvar</button>-->
	<!--<select class="form-control" id="selectCortarShape" onchange="mostrarShapeBioma()" style="width: 250px; margin-right: 10px">
      <option selected disabled>Selecionar Bioma</option>
	  <option>Amazônia</option>
      <option>Caatinga</option>
      <option>Cerrado</option>
      <option>Mata Atlântica</option>
      <option>Pampa</option>
	  <option>Pantanal</option>
    </select>-->
	<button type="button" class="btn btn-info" id="tooglePontos" onClick='tooglePontos()' data-toggle="tooltip" data-placement="top" title data-original-title="Toogle Pontos">Mostrar/Esconder Pontos</button>
	<button type="button" class="btn btn-danger" id="cancelarCorteRaster" onClick='cancelarCorteRaster()' data-toggle="tooltip" data-placement="top" title data-original-title="Cancelar Corte" style="display: <?php if ($isImageCut) echo ' flex'; else echo 'none'?>;">Cancelar Corte</button>
	<?php if($_SESSION['s_idtipousuario'] == '5') { ?>
		<button type="button" class="btn btn-success" id="validarCorteRaster" onClick='validarCorteRaster()' data-toggle="tooltip" data-placement="top" title data-original-title="Validar Corte" style="display: <?php if ($isImageCut) echo ' flex'; else echo 'none'?>;">Validar Corte</button>	
	<?php } ?>
</div> 