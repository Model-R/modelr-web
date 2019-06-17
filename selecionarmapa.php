<div style="display:flex; justify-content: center;">
	<?php $sql = "select distinct(taxon) from modelr.occurrence where idexperiment=" . $id  . "and (idstatusoccurrence = 17 or idstatusoccurrence = 4)";								
	$res = pg_exec($conn,$sql);
	if(pg_num_rows($res) > 1){
	?>	
		<div id="select-map-radio" class="radio-group" style="width:250px;">
	<?php	while ($row = pg_fetch_array($res)){ ?>
			<div><input type="radio" onChange="liberarSalvarMapa()" name="select-map-radio[]" id="<?php echo $row['taxon']; ?>" value="<?php echo $row['taxon']; ?>"/><?php echo $row['taxon']; ?></div>
	<?php } ?>
		</div>
	<?php }?>
		<!-- exibir select para escolha de modelo do mapa -->
		<div id="select-map" class="form-group shapebox-content" style="display: flex;justify-content: space-around;width: 500px;margin-bottom: 20px;">
			<label for="cmboxescolhermapa" style="margin-top:7px">Selecionar Mapa</label>
			<select id="cmboxescolhermapa" name="cmboxescolhermapa" class="form-control" style="width: 200px;">
				<option value="mean3" selected="selected">Mean 3</option>
				<option value="bin7">Bin 7</option>
				<option value="mean4">Mean 4</option>
			</select> 
			
			<?php if(pg_num_rows($res) > 1){?>
				<button disabled="true" type="button" id="button-save-map" class="btn btn-info" onClick='SalvarMapa()' data-toggle="tooltip" data-placement="top" title data-original-title="Salvar Mapa" style="">Salvar</button>
			<?php } else {?>
				<button type="button" id="button-save-map" class="btn btn-info" onClick='SalvarMapa()' data-toggle="tooltip" data-placement="top" title data-original-title="Salvar Mapa" style="">Salvar</button>
			<?php }?>
		</div> 
	</div>