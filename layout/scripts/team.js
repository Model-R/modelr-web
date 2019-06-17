function hideMembers (id, headerId) {
	if(document.getElementById(id).style.display == 'block'){
		document.getElementById(id).style.display = 'none';
		document.getElementById(headerId).classList.remove('titulo-funcao-ativo');
	} else {
		document.getElementById(id).style.display = 'block';
		document.getElementById(headerId).classList.add('titulo-funcao-ativo');
	}
}