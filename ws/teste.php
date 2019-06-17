<!DOCTYPE html>
<html lang="en">

<head>
</head>
<body>
<div id="demo"></div>
<button onclick="teste()">teste</button>
<script>
function teste()
{
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
	//alert(this.readyState);
	//alert(this.status);
	var x = '';
    if (this.readyState == 4 && this.status == 200) {
        var myObj = JSON.parse(this.responseText);
		//var myObj = this.responseText;
		alert(this.responseText);
        //document.getElementById("demo").innerHTML = myObj['idexperiment'];
		//for (i in myObj.occurence) {
		//	x += "<h1>" + myObj.occurence[i].lat + "</h1>"; 
		//}
		
		for (i in myObj.experiment) {
             x += myObj.experiment[i]["idexperiment"] + "<br>";
        }
		
//		for (i in myObj.servlet) {
//			x += "teste" + myObj+ "<br>"; 
//		}
	
//        document.getElementById("demo").innerHTML = myObj.idexperiment.occurence;//this.responseText;
        document.getElementById("demo").innerHTML = x;//this.responseText;
    }
};
xmlhttp.open("GET", "https://model-r.jbrj.gov.br/ws/index.php", true);
xmlhttp.send();
}
</script>
</body>
</html>
