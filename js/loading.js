
function exibe(id, text) { 
        if(text != '') document.getElementById('loading-title').innerHTML = text;
	if(document.getElementById(id).style.display=="none") {  
	document.getElementById(id).style.display = "inline";  
	}else {  
		document.getElementById(id).style.display = "none";  
	}  
}  
	
