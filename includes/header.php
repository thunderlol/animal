<!DOCTYPE html>

<html>

    <head>
        
        <title>ENCOPET - Animais perdidos e para adoção</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Language" content="pt-BR">
        <meta name="description" 
         content="Site para fazer pesquisa de animais, pets perdidos ou para adoção no Brasil">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        </head>
    
    <body style="padding-top: 60px;"> 
    <div id="loading">
    <div id="loading-center">
    <div id="loading-center-absolute">
    <div id="object"></div>
    </div>
    </div>
    </div>
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">

        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"> <img width="160px" height="35px" src="img/logos.png"></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                
                <?php
                if( $_SESSION['loggedInUser'] ) { // if user is logged in
                    
                ?>
                
                <!--Menu para adicionar, pesquisar animais perdidos ou para adoção-->
                <ul class="nav navbar-nav">
                    <li><a href="meus-anuncios-animais.php">Meus anúncios</a></li>
                    <li><a href="adicionar-anuncio-animais.php">Adicionar anúncio</a></li>
                    <li><a href="pesquisar-anuncios-animais.php?cidade=&bairro=&tipo=Todos">Anúncios</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <p class="navbar-text">Bem vindo, <?php echo $_SESSION['loggedInUser']?> !</p>
                    <li><a href="editar-conta-usuario.php">Conta</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
                <?php
                } else {
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="login.php">Login / Cadastrar</a></li>
                </ul>
                <?php
                }
                ?>

            </div>

        </div>

    </nav>
        
    <div class="container">
    
