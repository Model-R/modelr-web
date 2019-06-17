function showContent(className) {
    console.log(className);
    var content = document.getElementsByClassName(className);
    if(content[0].style.display == 'block') content[0].style.display = 'none'
    else content[0].style.display = 'block';
}

function form_submit(idForm) {
    document.getElementById(idForm).submit();
} 

function changeUrl(id){
    document.getElementById(id).click();
}

$("html").keypress(function(e){
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        if($('#loginModal').is(':visible')){
            document.getElementById('loginForm').submit();
        }
        else if($('#senhaModal').is(':visible')){
            document.getElementById('passForm').submit();
        }
    }
});

// Listen for click on toggle checkbox
function selectAll(e) {
    console.log(event) 
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
}