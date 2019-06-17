<link href="css/secTab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="tab_container" role="tab_container" data-example-id="togglable-tabs">	
		<!--<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab4" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab4"><span>Dados Bióticos</span></label>


			<input id="tab5" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab5"><span>Dados Abióticos</span></label>
			
		</div>
		
		<div id="preTratamentoTab" class="tab-content">
			<div class="tab-pane <?php //if ($stab=='4') echo 'in active';?>" id="tab_content4" aria-labelledby="home-tab">
				<?php //require "dadosbioticostab.php";?>
			</div> 
			<div  class="tab-pane fade <?php //if ($stab=='5') echo 'in active';?>" id="tab_content5" aria-labelledby="home-tab">
				<?php //require "dadosabioticostab.php";?>
			</div> 
		</div>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab9" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab9"><span>Aquisição de Dados Bióticos</span></label>


			<input id="tab10" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab10"><span>Limpeza de Dados</span></label>
			
			<input id="tab11" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab11"><span>Seleção de Dados Abióticos</span></label>


			<input id="tab12" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab12"><span>Extensão</span></label>
			
			<input id="tab18" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab18"><span>Projeção</span></label>
			
		</div>
		
		<div id="preTratamentoTab" class="tab-content">
			<div class="tab-pane <?php if ($stab=='9') echo 'in active';?>" id="tab_content9" aria-labelledby="home-tab">
				<?php require "dadosbioticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='10') echo 'in active';?>" id="tab_content10" aria-labelledby="home-tab">
				<?php require "expdatacleaning.php";?>
			</div> 
			<div class="tab-pane <?php if ($stab=='11') echo 'in active';?>" id="tab_content11" aria-labelledby="home-tab">
				<?php require "selecaodadosabioticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='12') echo 'in active';?>" id="tab_content12" aria-labelledby="home-tab">
				<?php require "expextensao.php";?>
			</div>
			<div  class="tab-pane fade <?php if ($stab=='18') echo 'in active';?>" id="tab_content18" aria-labelledby="home-tab">
				<?php require "expprojecao.php";?>
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

if(stab == 9){
	document.getElementById('tab9').checked = true;
	document.getElementById('tab_content9').classList.add("in");
	document.getElementById('tab_content9').classList.add("active");
	document.getElementById('tab_content10').classList.remove("in");
	document.getElementById('tab_content10').classList.remove("active");
	document.getElementById('tab_content11').classList.remove("in");
	document.getElementById('tab_content11').classList.remove("active");
	document.getElementById('tab_content12').classList.remove("in");
	document.getElementById('tab_content12').classList.remove("active");
	document.getElementById('tab_content18').classList.remove("in");
	document.getElementById('tab_content18').classList.remove("active");
}
else if(stab == 10){
	document.getElementById('tab10').checked = true;
	document.getElementById('tab_content9').classList.remove("in");
	document.getElementById('tab_content9').classList.remove("active");
	document.getElementById('tab_content10').classList.add("in");
	document.getElementById('tab_content10').classList.add("active");
	document.getElementById('tab_content11').classList.remove("in");
	document.getElementById('tab_content11').classList.remove("active");
	document.getElementById('tab_content12').classList.remove("in");
	document.getElementById('tab_content12').classList.remove("active");
	document.getElementById('tab_content18').classList.remove("in");
	document.getElementById('tab_content18').classList.remove("active");
	
}
else if(stab == 11){
	document.getElementById('tab11').checked = true;
	document.getElementById('tab_content9').classList.remove("in");
	document.getElementById('tab_content9').classList.remove("active");
	document.getElementById('tab_content10').classList.remove("in");
	document.getElementById('tab_content10').classList.remove("active");
	document.getElementById('tab_content11').classList.add("in");
	document.getElementById('tab_content11').classList.add("active");
	document.getElementById('tab_content12').classList.remove("in");
	document.getElementById('tab_content12').classList.remove("active");
	document.getElementById('tab_content18').classList.remove("in");
	document.getElementById('tab_content18').classList.remove("active");
}
else if(stab == 12){
	document.getElementById('tab12').checked = true;
	document.getElementById('tab_content9').classList.remove("in");
	document.getElementById('tab_content9').classList.remove("active");
	document.getElementById('tab_content10').classList.remove("in");
	document.getElementById('tab_content10').classList.remove("active");
	document.getElementById('tab_content11').classList.remove("in");
	document.getElementById('tab_content11').classList.remove("active");
	document.getElementById('tab_content12').classList.add("in");
	document.getElementById('tab_content12').classList.add("active");
	document.getElementById('tab_content18').classList.remove("in");
	document.getElementById('tab_content18').classList.remove("active");
}
else if(stab == 18){
	document.getElementById('tab18').checked = true;
	document.getElementById('tab_content9').classList.remove("in");
	document.getElementById('tab_content9').classList.remove("active");
	document.getElementById('tab_content10').classList.remove("in");
	document.getElementById('tab_content10').classList.remove("active");
	document.getElementById('tab_content11').classList.remove("in");
	document.getElementById('tab_content11').classList.remove("active");
	document.getElementById('tab_content12').classList.remove("in");
	document.getElementById('tab_content12').classList.remove("active");
	document.getElementById('tab_content18').classList.add("in");
	document.getElementById('tab_content18').classList.add("active");
}

$("label").click(function(){
    console.log($(this).attr('for'))
	var tab = $(this).attr('for');
	if(tab == 'tab9'){
		document.getElementById('tab_content9').classList.add("in");
		document.getElementById('tab_content9').classList.add("active");
		document.getElementById('tab_content10').classList.remove("in");
		document.getElementById('tab_content10').classList.remove("active");
		document.getElementById('tab_content11').classList.remove("in");
		document.getElementById('tab_content11').classList.remove("active");
		document.getElementById('tab_content12').classList.remove("in");
		document.getElementById('tab_content12').classList.remove("active");
		document.getElementById('tab_content18').classList.remove("in");
		document.getElementById('tab_content18').classList.remove("active");
	}
	else if(tab == 'tab10'){
		document.getElementById('tab_content9').classList.remove("in");
		document.getElementById('tab_content9').classList.remove("active");
		document.getElementById('tab_content10').classList.add("in");
		document.getElementById('tab_content10').classList.add("active");
		document.getElementById('tab_content11').classList.remove("in");
		document.getElementById('tab_content11').classList.remove("active");
		document.getElementById('tab_content12').classList.remove("in");
		document.getElementById('tab_content12').classList.remove("active");
		document.getElementById('tab_content18').classList.remove("in");
		document.getElementById('tab_content18').classList.remove("active");
	}
	else if(tab == 'tab11'){
		document.getElementById('tab_content9').classList.remove("in");
		document.getElementById('tab_content9').classList.remove("active");
		document.getElementById('tab_content10').classList.remove("in");
		document.getElementById('tab_content10').classList.remove("active");
		document.getElementById('tab_content11').classList.add("in");
		document.getElementById('tab_content11').classList.add("active");
		document.getElementById('tab_content12').classList.remove("in");
		document.getElementById('tab_content12').classList.remove("active");
		document.getElementById('tab_content18').classList.remove("in");
		document.getElementById('tab_content18').classList.remove("active");
	}
	else if(tab == 'tab12'){
		document.getElementById('tab_content9').classList.remove("in");
		document.getElementById('tab_content9').classList.remove("active");
		document.getElementById('tab_content10').classList.remove("in");
		document.getElementById('tab_content10').classList.remove("active");
		document.getElementById('tab_content11').classList.remove("in");
		document.getElementById('tab_content11').classList.remove("active");
		document.getElementById('tab_content12').classList.add("in");
		document.getElementById('tab_content12').classList.add("active");
		document.getElementById('tab_content18').classList.remove("in");
		document.getElementById('tab_content18').classList.remove("active");
	}
	else if(tab == 'tab18'){
		document.getElementById('tab_content9').classList.remove("in");
		document.getElementById('tab_content9').classList.remove("active");
		document.getElementById('tab_content10').classList.remove("in");
		document.getElementById('tab_content10').classList.remove("active");
		document.getElementById('tab_content11').classList.remove("in");
		document.getElementById('tab_content11').classList.remove("active");
		document.getElementById('tab_content12').classList.remove("in");
		document.getElementById('tab_content12').classList.remove("active");
		document.getElementById('tab_content18').classList.add("in");
		document.getElementById('tab_content18').classList.add("active");
	}
});
</script>