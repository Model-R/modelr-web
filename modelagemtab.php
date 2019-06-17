<link href="css/secTab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="tab_container" role="tab_container" data-example-id="togglable-tabs">	
		<!--<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab6" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab6"><span>Parâmetros</span></label>


			<input id="tab7" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab7"><span>Dados Resultados</span></label>
			
		</div>
		
		<div id="teste" class="tab-content">
			<div class="tab-pane  <?php //if ($stab=='6') echo 'in active';?>" id="tab_content6" aria-labelledby="home-tab">
				<?php //require "parametrosmodelagem.php";?>
			</div> 
			<div  class="tab-pane fade <?php ///if ($stab=='7') echo 'in active';?>" id="tab_content7" aria-labelledby="home-tab">
				<?php //require "resultadotab.php";?>
			</div>
		</div>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab6" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab6"><span>Parâmetros</span></label>


			<input id="tab13" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab13"><span>Dados Estatísticos</span></label>
			
			<input id="tab14" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab14"><span>Modelos Gerados</span></label>


			<input id="tab15" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab15"><span>Ensemble Inicial</span></label>
			
			<input id="tab16" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab16"><span>Ensemble Final</span></label>


			<input id="tab17" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab17"><span>Metadados</span></label>
			
		</div>
		
		<div id="teste" class="tab-content">
			<div class="tab-pane  <?php if ($stab=='6') echo 'in active';?>" id="tab_content6" aria-labelledby="home-tab">
				<?php require "parametrosmodelagem.php";?>
			</div> 
			<div class="tab-pane  <?php if ($stab=='13') echo 'in active';?>" id="tab_content13" aria-labelledby="home-tab">
				<?php require "dadosestatisticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='14') echo 'in active';?>" id="tab_content14" aria-labelledby="home-tab">
				<?php require "modelos.php";?>
			</div> 
			<div class="tab-pane  <?php if ($stab=='15') echo 'in active';?>" id="tab_content15" aria-labelledby="home-tab">
				<?php require "ensembleinicial.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='16') echo 'in active';?>" id="tab_content16" aria-labelledby="home-tab">
				<?php require "ensemblefinal.php";?>
			</div> 
			<div class="tab-pane  <?php if ($stab=='17') echo 'in active';?>" id="tab_content17" aria-labelledby="home-tab">
				<?php require "metadados.php";?>
			</div> 
		</div>
	</div>
</div>

<script>
var stab = <?php 
	if(isset($stab)){
		echo $stab;
	} else {
		echo 0;
	}
?>;

if(stab == 6){
	document.getElementById('tab6').checked = true;
	document.getElementById('tab_content6').classList.add("in");
	document.getElementById('tab_content6').classList.add("active");
	document.getElementById('tab_content13').classList.remove("in");
	document.getElementById('tab_content13').classList.remove("active");
	document.getElementById('tab_content14').classList.remove("in");
	document.getElementById('tab_content14').classList.remove("active");
	document.getElementById('tab_content15').classList.remove("in");
	document.getElementById('tab_content15').classList.remove("active");
	document.getElementById('tab_content16').classList.remove("in");
	document.getElementById('tab_content16').classList.remove("active");
	document.getElementById('tab_content17').classList.remove("in");
	document.getElementById('tab_content17').classList.remove("active");
}
else if(stab == 13){
	document.getElementById('tab13').checked = true;
	document.getElementById('tab_content6').classList.remove("in");
	document.getElementById('tab_content6').classList.remove("active");
	document.getElementById('tab_content13').classList.add("in");
	document.getElementById('tab_content13').classList.add("active");
	document.getElementById('tab_content14').classList.remove("in");
	document.getElementById('tab_content14').classList.remove("active");
	document.getElementById('tab_content15').classList.remove("in");
	document.getElementById('tab_content15').classList.remove("active");
	document.getElementById('tab_content16').classList.remove("in");
	document.getElementById('tab_content16').classList.remove("active");
	document.getElementById('tab_content17').classList.remove("in");
	document.getElementById('tab_content17').classList.remove("active");
}
else if(stab == 14){
	document.getElementById('tab14').checked = true;
	document.getElementById('tab_content6').classList.remove("in");
	document.getElementById('tab_content6').classList.remove("active");
	document.getElementById('tab_content13').classList.remove("in");
	document.getElementById('tab_content13').classList.remove("active");
	document.getElementById('tab_content14').classList.add("in");
	document.getElementById('tab_content14').classList.add("active");
	document.getElementById('tab_content15').classList.remove("in");
	document.getElementById('tab_content15').classList.remove("active");
	document.getElementById('tab_content16').classList.remove("in");
	document.getElementById('tab_content16').classList.remove("active");
	document.getElementById('tab_content17').classList.remove("in");
	document.getElementById('tab_content17').classList.remove("active");
}
else if(stab == 15){
	document.getElementById('tab15').checked = true;
	document.getElementById('tab_content6').classList.remove("in");
	document.getElementById('tab_content6').classList.remove("active");
	document.getElementById('tab_content13').classList.remove("in");
	document.getElementById('tab_content13').classList.remove("active");
	document.getElementById('tab_content14').classList.remove("in");
	document.getElementById('tab_content14').classList.remove("active");
	document.getElementById('tab_content15').classList.add("in");
	document.getElementById('tab_content15').classList.add("active");
	document.getElementById('tab_content16').classList.remove("in");
	document.getElementById('tab_content16').classList.remove("active");
	document.getElementById('tab_content17').classList.remove("in");
	document.getElementById('tab_content17').classList.remove("active");
}
else if(stab == 16){
	document.getElementById('tab16').checked = true;
	document.getElementById('tab_content6').classList.remove("in");
	document.getElementById('tab_content6').classList.remove("active");
	document.getElementById('tab_content13').classList.remove("in");
	document.getElementById('tab_content13').classList.remove("active");
	document.getElementById('tab_content14').classList.remove("in");
	document.getElementById('tab_content14').classList.remove("active");
	document.getElementById('tab_content15').classList.remove("in");
	document.getElementById('tab_content15').classList.remove("active");
	document.getElementById('tab_content16').classList.add("in");
	document.getElementById('tab_content16').classList.add("active");
	document.getElementById('tab_content17').classList.remove("in");
	document.getElementById('tab_content17').classList.remove("active");
}
else if(stab == 17){
	document.getElementById('tab17').checked = true;
	document.getElementById('tab_content6').classList.remove("in");
	document.getElementById('tab_content6').classList.remove("active");
	document.getElementById('tab_content13').classList.remove("in");
	document.getElementById('tab_content13').classList.remove("active");
	document.getElementById('tab_content14').classList.remove("in");
	document.getElementById('tab_content14').classList.remove("active");
	document.getElementById('tab_content15').classList.remove("in");
	document.getElementById('tab_content15').classList.remove("active");
	document.getElementById('tab_content16').classList.remove("in");
	document.getElementById('tab_content16').classList.remove("active");
	document.getElementById('tab_content17').classList.add("in");
	document.getElementById('tab_content17').classList.add("active");
}

$("label").click(function(){
    console.log($(this).attr('for'))
	var tab = $(this).attr('for');
	if(tab == 'tab6'){
		document.getElementById('tab_content6').classList.add("in");
		document.getElementById('tab_content6').classList.add("active");
		document.getElementById('tab_content13').classList.remove("in");
		document.getElementById('tab_content13').classList.remove("active");
		document.getElementById('tab_content14').classList.remove("in");
		document.getElementById('tab_content14').classList.remove("active");
		document.getElementById('tab_content15').classList.remove("in");
		document.getElementById('tab_content15').classList.remove("active");
		document.getElementById('tab_content16').classList.remove("in");
		document.getElementById('tab_content16').classList.remove("active");
		document.getElementById('tab_content17').classList.remove("in");
		document.getElementById('tab_content17').classList.remove("active");
	}
	else if(tab == 'tab13'){
		document.getElementById('tab_content6').classList.remove("in");
		document.getElementById('tab_content6').classList.remove("active");
		document.getElementById('tab_content13').classList.add("in");
		document.getElementById('tab_content13').classList.add("active");
		document.getElementById('tab_content14').classList.remove("in");
		document.getElementById('tab_content14').classList.remove("active");
		document.getElementById('tab_content15').classList.remove("in");
		document.getElementById('tab_content15').classList.remove("active");
		document.getElementById('tab_content16').classList.remove("in");
		document.getElementById('tab_content16').classList.remove("active");
		document.getElementById('tab_content17').classList.remove("in");
		document.getElementById('tab_content17').classList.remove("active");
	}
	else if(tab == 'tab14'){
		document.getElementById('tab14').checked = true;
		document.getElementById('tab_content6').classList.remove("in");
		document.getElementById('tab_content6').classList.remove("active");
		document.getElementById('tab_content13').classList.remove("in");
		document.getElementById('tab_content13').classList.remove("active");
		document.getElementById('tab_content14').classList.add("in");
		document.getElementById('tab_content14').classList.add("active");
		document.getElementById('tab_content15').classList.remove("in");
		document.getElementById('tab_content15').classList.remove("active");
		document.getElementById('tab_content16').classList.remove("in");
		document.getElementById('tab_content16').classList.remove("active");
		document.getElementById('tab_content17').classList.remove("in");
		document.getElementById('tab_content17').classList.remove("active");
	}
	else if(tab == 'tab15'){
		document.getElementById('tab_content6').classList.remove("in");
		document.getElementById('tab_content6').classList.remove("active");
		document.getElementById('tab_content13').classList.remove("in");
		document.getElementById('tab_content13').classList.remove("active");
		document.getElementById('tab_content14').classList.remove("in");
		document.getElementById('tab_content14').classList.remove("active");
		document.getElementById('tab_content15').classList.add("in");
		document.getElementById('tab_content15').classList.add("active");
		document.getElementById('tab_content16').classList.remove("in");
		document.getElementById('tab_content16').classList.remove("active");
		document.getElementById('tab_content17').classList.remove("in");
		document.getElementById('tab_content17').classList.remove("active");
	}
	else if(tab == 'tab16'){
		document.getElementById('tab_content6').classList.remove("in");
		document.getElementById('tab_content6').classList.remove("active");
		document.getElementById('tab_content13').classList.remove("in");
		document.getElementById('tab_content13').classList.remove("active");
		document.getElementById('tab_content14').classList.remove("in");
		document.getElementById('tab_content14').classList.remove("active");
		document.getElementById('tab_content15').classList.remove("in");
		document.getElementById('tab_content15').classList.remove("active");
		document.getElementById('tab_content16').classList.add("in");
		document.getElementById('tab_content16').classList.add("active");
		document.getElementById('tab_content17').classList.remove("in");
		document.getElementById('tab_content17').classList.remove("active");
	}
	else if(tab == 'tab17'){
		document.getElementById('tab_content6').classList.remove("in");
		document.getElementById('tab_content6').classList.remove("active");
		document.getElementById('tab_content13').classList.remove("in");
		document.getElementById('tab_content13').classList.remove("active");
		document.getElementById('tab_content14').classList.remove("in");
		document.getElementById('tab_content14').classList.remove("active");
		document.getElementById('tab_content15').classList.remove("in");
		document.getElementById('tab_content15').classList.remove("active");
		document.getElementById('tab_content16').classList.remove("in");
		document.getElementById('tab_content16').classList.remove("active");
		document.getElementById('tab_content17').classList.add("in");
		document.getElementById('tab_content17').classList.add("active");
	}
});
</script>