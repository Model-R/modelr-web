<!DOCTYPE html>
<html>
<head>
    <!-- essa linha do charset não tava no vídeo! -->
    <meta charset="utf-8">
    <title>Model R</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto+Slab:400,700|Pacifico' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/estilos-index.css">
    <link rel="stylesheet" href="css/estilos-equipes.css">
    <link rel="stylesheet" href="css/estilos-sobre.css">
    <link rel="stylesheet" href="css/estilos-projetos.css">
    <link rel="stylesheet" href="css/estilos-publicacoes.css">

    <script src="js/cover.js"></script>
    <script src="js/jquery.min.js"></script>

</head>
  
<body>
    <div id="container">

    <nav>
        <div class="title">
            <img src="image/jardim botanico.jpg" alt="jardim botanico">
            <a href="index.php">Model R</a>
        </div>
        <ul>
            <li onclick="changeUrl('aboutLink')"><a id="aboutLink" href="about.php">SOBRE</a></li>
            <li onclick="changeUrl('teamLink')"><a id="teamLink" href="team.php">EQUIPE</a></li>
            <li onclick="changeUrl('publicationsLink')"><a id="publicationsLink" href="publication.php">PUBLICAÇÕES</a></li>
            <li onclick="changeUrl('projectsLink')"><a id="projectsLink" href="projects.php">PROJETOS</a></li>
            <li data-toggle="modal" data-target="#loginModal"><a href="#" data-toggle="modal" data-target="#loginModal">LOGIN</a></li>
            <!-- <li><a href="login.php">LOGIN</a></li>
 -->    </ul>
 <!-- <form name="loginForm" id="loginForm" method="post" action="testalogin.php">
        <div class="form-group">
            <label for="recipient-name" class="form-control-label label-user">Usuário:</label>
            <input type="text" class="form-control input-user" name="edtlogin" id="edtlogin">
        </div>
        <div class="form-group">
            <label for="message-text" class="form-control-label">Senha:</label>
            <input type="password" class="form-control" name="edtsenha" id="edtsenha">
        </div>
    </form> -->
    </nav>