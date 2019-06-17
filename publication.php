<?php
include_once 'templates/nav.php';
include_once 'templates/login.php';
include_once 'templates/pass.php';
?>

<section id="publicacoes">
    <h2>PUBLICAÇÕES</h2> 
    <div>
        <div class="publicacao1">
            <p><span>Model-R: A Framework for Scalable and Reproducible Ecological Niche Modeling. Communications in Computer and Information Science. </span><a href="../papers/ Model-R: A Framework for Scalable and Reproducible Ecological Niche Modeling. Communications in Computer and Information Science.pdf"><img src="../img/logo-pdf.jpg"></a></p>
            <p><a target="_blank" href="https://doi.org/10.1007/978-3-319-73353-1_15">1ed.: Springer International Publishing, 2018, v. 796, p. 218-232.</a></p>
            <p><span>Autores: </span>Sánchez-Tapia, Andrea ; Siqueira, Marinez Ferreira de ; Lima, Rafael Oliveira ; Barros, Felipe Sodré M. ; Gall, Guilherme M. ; Gadelha, Luiz M. R. ; da Silva, Luís Alexandre E. ; Osthoff, Carla.</p>
        </div>
    </div>

</section>
	
<?php
    include_once 'templates/footer.php';
    $ro = preg_replace('/\s+/', ' ','Rio de       Janeiro');
    echo $ro;
?>