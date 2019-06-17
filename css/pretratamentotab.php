<link href="css/secundarytab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="tab_container" role="tab_container" data-example-id="togglable-tabs">
		<!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php //if ($stab=='4') echo 'class="active"';?>><a href="#tab_content4" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Bióticos</a>
			</li>
			<li role="presentation" <?php //if ($stab=='5') echo 'class="active"';?>><a href="#tab_content5" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Dados Abióticos</a>
			</li>
		</ul>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab4" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab4"><span>Dados Bióticos</span></label>


			<input id="tab5" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab5"><span>Dados Abióticos</span></label>
			
		</div>
		
		<div id="preTratamentoTab" class="tab-content">
			<div class="tab-pane  <?php if ($stab=='4') echo 'in active';?>" id="tab_content4" aria-labelledby="home-tab">
				<?php require "dadosbioticostab.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($stab=='5') echo 'in active';?>" id="tab_content5" aria-labelledby="home-tab">
				<?php require "dadosabioticostab.php";?>
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

if(stab == 4){
	document.getElementById('tab4').checked = true;
	document.getElementById('tab_content4').classList.add("in");
	document.getElementById('tab_content4').classList.add("active");
	document.getElementById('tab_content5').classList.remove("in");
	document.getElementById('tab_content5').classList.remove("active");
}
else if(stab == 5){
	document.getElementById('tab5').checked = true;
	document.getElementById('tab_content4').classList.remove("in");
	document.getElementById('tab_content4').classList.remove("active");
	document.getElementById('tab_content5').classList.add("in");
	document.getElementById('tab_content5').classList.add("active");
}

$("label").click(function(){
    console.log($(this).attr('for'))
	var tab = $(this).attr('for');
	if(tab == 'tab4'){
		document.getElementById('tab_content4').classList.add("in");
		document.getElementById('tab_content4').classList.add("active");
		document.getElementById('tab_content5').classList.remove("in");
		document.getElementById('tab_content5').classList.remove("active");
	}
	else if(tab == 'tab5'){
		document.getElementById('tab_content4').classList.remove("in");
		document.getElementById('tab_content4').classList.remove("active");
		document.getElementById('tab_content5').classList.add("in");
		document.getElementById('tab_content5').classList.add("active");
	}
});
</script>