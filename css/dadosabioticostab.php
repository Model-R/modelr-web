<link href="css/secundarytab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php //if ($ttab=='11') echo 'class="active"';?>><a href="#tab_content11" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Seleção</a>
			</li>
			<li role="presentation" <?php //if ($ttab=='12') echo 'class="active"';?>><a href="#tab_content12" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Extensão</a>
			</li>
		</ul>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab11" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab11"><span>Seleção</span></label>


			<input id="tab12" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab12"><span>Extensão</span></label>
			
		</div>
		
		<div id="dadosAbioticosTab" class="tab-content">
			<div class="tab-pane  <?php if ($ttab=='11') echo 'in active';?>" id="tab_content11" aria-labelledby="home-tab">
				<?php require "selecaodadosabioticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='12') echo 'in active';?>" id="tab_content12" aria-labelledby="home-tab">
				<?php require "expextensao.php";?>
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

if(ttab == 11){
	document.getElementById('tab11').checked = true;
	document.getElementById('tab_content11').classList.add("in");
	document.getElementById('tab_content11').classList.add("active");
	document.getElementById('tab_content12').classList.remove("in");
	document.getElementById('tab_content12').classList.remove("active");
}
else if(ttab == 12){
	document.getElementById('tab12').checked = true;
	document.getElementById('tab_content11').classList.remove("in");
	document.getElementById('tab_content11').classList.remove("active");
	document.getElementById('tab_content12').classList.add("in");
	document.getElementById('tab_content12').classList.add("active");
}

$("label").click(function(){
    console.log($(this).attr('for'))
	var tab = $(this).attr('for');
	if(tab == 'tab11'){
		document.getElementById('tab_content11').classList.add("in");
		document.getElementById('tab_content11').classList.add("active");
		document.getElementById('tab_content12').classList.remove("in");
		document.getElementById('tab_content12').classList.remove("active");
	}
	else if(tab == 'tab12'){
		document.getElementById('tab_content11').classList.remove("in");
		document.getElementById('tab_content11').classList.remove("active");
		document.getElementById('tab_content12').classList.add("in");
		document.getElementById('tab_content12').classList.add("active");
	}
});
</script>