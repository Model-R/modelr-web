<link href="css/sectab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php //if ($ttab=='13') echo 'class="active"';?>><a href="#tab_content13" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Estatísticos</a>
			</li>
			<li role="presentation" <?php //if ($ttab=='14') echo 'class="active"';?>><a href="#tab_content14" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Modelos Gerados</a>
			</li>
			<li role="presentation" <?php //if ($ttab=='15') echo 'class="active"';?>><a href="#tab_content15" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Ensemble Inicial</a>
			</li>
			<li role="presentation" <?php //if ($ttab=='16') echo 'class="active"';?>><a href="#tab_content16" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Ensemble Final</a>
			</li>
			<li role="presentation" <?php //if ($ttab=='17') echo 'class="active"';?>><a href="#tab_content17" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Metadados</a>
			</li>
		</ul>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab13" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab13"><span>Dados Estatístico</span></label>

			<input id="tab14" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab14"><span>Modelos Gerados</span></label>
			
			<input id="tab15" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab15"><span>Ensemble Inicial</span></label>

			<input id="tab16" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab16"><span>Ensemble Final</span></label>
			
			<input id="tab17" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab17"><span>Metadados</span></label>
			
		</div>
		
		<div id="resultadoTab" class="tab-content">
			<div class="tab-pane  <?php if ($ttab=='13') echo 'in active';?>" id="tab_content13" aria-labelledby="home-tab">
				<?php require "dadosestatisticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='14') echo 'in active';?>" id="tab_content14" aria-labelledby="home-tab">
				<?php require "modelos.php";?>
			</div> 
			<div class="tab-pane  <?php if ($ttab=='15') echo 'in active';?>" id="tab_content15" aria-labelledby="home-tab">
				<?php require "ensembleinicial.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='16') echo 'in active';?>" id="tab_content16" aria-labelledby="home-tab">
				<?php require "ensemblefinal.php";?>
			</div> 
			<div class="tab-pane  <?php if ($ttab=='17') echo 'in active';?>" id="tab_content17" aria-labelledby="home-tab">
				<?php require "metadados.php";?>
			</div> 
		</div>
	</div>
</div>

<script>
var ttab = <?php 
	if(isset($ttab)){
		echo $ttab;
	} else {
		echo 0;
	}
?>;

if(ttab == 13){
	document.getElementById('tab13').checked = true;
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
else if(ttab == 14){
	document.getElementById('tab14').checked = true;
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
else if(ttab == 15){
	document.getElementById('tab15').checked = true;
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
else if(ttab == 16){
	document.getElementById('tab16').checked = true;
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
else if(ttab == 17){
	document.getElementById('tab17').checked = true;
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
	if(tab == 'tab13'){
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
