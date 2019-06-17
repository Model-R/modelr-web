<link href="css/sectab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php //if ($ttab=='9') echo 'class="active"';?>><a href="#tab_content9" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Aquisição</a>
			</li>
			<li role="presentation" <?php //if ($ttab=='10') echo 'class="active"';?>><a href="#tab_content10" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Limpeza de Dados</a>
			</li>
		</ul>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab9" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab9"><span>Aquisição</span></label>


			<input id="tab10" type="radio" name="sec-tabs" class="input-tab">
			<label class="tab-label third-tab" for="tab10"><span>Limpeza de Dados</span></label>
			
		</div>
		
		<div id="dadosBioticottab" class="tab-content">
			<div class="tab-pane  <?php if ($ttab=='9') echo 'in active';?>" id="tab_content9" aria-labelledby="home-tab">
				<?php require "dadosbioticos.php";?>
			</div> 
			<div  class="tab-pane fade <?php if ($ttab=='10') echo 'in active';?>" id="tab_content10" aria-labelledby="home-tab">
				<?php require "expdatacleaning.php";?>
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

if(ttab == 9){
	document.getElementById('tab9').checked = true;
	document.getElementById('tab_content9').classList.add("in");
	document.getElementById('tab_content9').classList.add("active");
	document.getElementById('tab_content10').classList.remove("in");
	document.getElementById('tab_content10').classList.remove("active");
}
else if(ttab == 10){
	document.getElementById('tab10').checked = true;
	document.getElementById('tab_content9').classList.remove("in");
	document.getElementById('tab_content9').classList.remove("active");
	document.getElementById('tab_content10').classList.add("in");
	document.getElementById('tab_content10').classList.add("active");
}

$("label").click(function(){
    console.log($(this).attr('for'))
	var tab = $(this).attr('for');
	if(tab == 'tab9'){
		document.getElementById('tab_content9').classList.add("in");
		document.getElementById('tab_content9').classList.add("active");
		document.getElementById('tab_content10').classList.remove("in");
		document.getElementById('tab_content10').classList.remove("active");
	}
	else if(tab == 'tab10'){
		document.getElementById('tab_content9').classList.remove("in");
		document.getElementById('tab_content9').classList.remove("active");
		document.getElementById('tab_content10').classList.add("in");
		document.getElementById('tab_content10').classList.add("active");
	}
});
</script>