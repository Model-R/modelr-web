<link href="css/secTab.css" rel="stylesheet" type="text/css" media="all">

<div class="x_content">
	<div class="tab_container" role="tab_container" data-example-id="togglable-tabs">
		<!--<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" <?php //if ($stab=='8') echo 'class="active"';?>><a href="#tab_content8" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Mapa</a>
			</li>
		</ul>-->
		
		<div class="nav nav-tabs bar_tabs" role="tablist">
			<input id="tab8" type="radio" name="tabs" class="input-tab">
			<label class="tab-label" for="tab8"><span>Mapa</span></label>
		</div>
		
		<div id="mapaTab" class="tab-content">
			<div class="tab-pane  <?php if ($stab=='8') echo 'in active';?>" id="tab_content8" aria-labelledby="home-tab">
				<?php require "mapa.php";?>
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
console.log('tab mapa ' + stab);
if(stab == 8){
	document.getElementById('tab8').checked = true;
	document.getElementById('tab_content8').classList.add("in");
	document.getElementById('tab_content8').classList.add("active");
}

$("label").click(function(){
    console.log($(this).attr('for'))
	var tab = $(this).attr('for');
	if(tab == 'tab8'){
		document.getElementById('tab_content8').classList.add("in");
		document.getElementById('tab_content8').classList.add("active");
	}
});
</script>