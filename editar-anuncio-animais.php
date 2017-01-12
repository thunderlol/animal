<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: login.php");
}

// get ID sent by GET collection
$clientID = $_GET['id'];

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// query the database with client ID
$query = "SELECT * FROM lista WHERE id='$clientID'";
$result = mysqli_query( $conn, $query );

// if result is returned
if( mysqli_num_rows($result) > 0 ) {
    
    $id = $_SESSION['idUser'];
    // we have data!
    // set some variables
    while( $row = mysqli_fetch_assoc($result) ) {
        
        $telefone       = $row['phone'];
        $estado         = $row['estado'];
        $cidade         = $row['cidade'];
        $descricao      = $row['notes'];
        $bairro         = $row['bairro'];
        $anuncio        = $row['anuncio'];
        $optradio       = $row['optradio'];
        $optradio1      = $row['optradio1'];
        $porte          = $row['porte'];
        $image1         = $row['image'];
        $userpic        = $row['imageName'];    
    }
    
} else { // no results returned
    
    $alertMessage = "<div class='alert alert-warning'>Nada para ver aqui. <a href='meus-anuncios-animais.php'>Retornar</a>.</div>";
}

// if update button was submitted
if( isset($_POST['update']) ) {
    
    $imgFile = $_FILES['imageName']['name'];
    //$tmp_dir = $_FILES['imageName']['tmp_name'];
    $imgSize = $_FILES['imageName']['size'];
    $id      = $_SESSION['idUser'];
    
      
    if($imgFile){
        
        $image = addslashes($_FILES['imageName']['tmp_name']);
        $image = file_get_contents($image);
        $image = base64_encode($image);
      
        //$upload_dir = 'img/'; // upload directory 
        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
        $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
        $userpic = rand(1000,1000000).$id.".".$imgExt;
        
        if(in_array($imgExt, $valid_extensions)){   
          
            if($imgSize < 5000000){

                // set variables
                $clientTelefone =  validateFormData($_POST["clientTelefone"]);
                $clientEstado  =   validateFormData($_POST["clientEstado"]);
                $clientCidade  =   validate($_POST["clientCidade"]);
                $clientBairro  =   validate($_POST["clientBairro"]);
                $clientAnuncio  =  validate($_POST["clientAnuncio"]);
                $optradio  =        $_POST["optradio"];
                $optradio1  =       $_POST["optradio1"];
                $clientPorte  =     $_POST["clientPorte"];
                $clientNotes    =  validate($_POST["clientNotes"]);
                        

                if( !$_POST["clientCidade"] ) {
        
                    $error = "<div class='alert alert-danger col-md-2'>Cidade obrigatório *</div>";
        
                } else {
        
                    $clientCidade = $_POST["clientCidade"];
                }

                if( !$_POST["clientBairro"] ) {

                    $error = "<div class='alert alert-danger col-md-2'>Bairro obrigatório *</div>";

                } else {

                    $clientBairro =  $_POST["clientBairro"];
                }


                if( !$_POST["clientNotes"] ) {

                    $error = "<div class='alert alert-danger col-md-2'>Descrição obrigatório *</div>";

                } else {

                    $clientNotes = $_POST["clientNotes"];
                }

                if( !$_POST["clientTelefone"] ) {

                    $error = "<div class='alert alert-danger col-md-2'>Telefone obrigatório *</div>";

                } else {

                    $clientTelefone = validateFormData( $_POST["clientTelefone"] );
                }

                if(  $userpic && $clientNotes && $clientTelefone && $clientBairro && $clientCidade ) {
                      // new database query & result
                    $query =    "UPDATE lista 
                                SET image='$image',                        
                                phone='$clientTelefone', 
                                estado='$clientEstado', 
                                cidade='$clientCidade', 
                                date_added=CURRENT_TIMESTAMP,  
                                notes='$clientNotes', 
                                imageName='$userpic', 
                                bairro='$clientBairro', 
                                anuncio='$clientAnuncio', 
                                optradio='$optradio', 
                                optradio1='$optradio1',
                                porte='$clientPorte' 
                                WHERE id='$clientID' AND userId='$id'" ;
                    $result = mysqli_query( $conn, $query );
              
              
                    if( $result ) {

                        // redirect to client page with query string
                        header("Location: meus-anuncios-animais.php?alert=updatesuccess");

                    } else {

                        echo "Error updating record: " . mysqli_error($conn); 

                    }

                }
          }
            
        else
            
        {
            
                $errMSG = "<div class='alert alert-warning col-md-5'>Desculpe, o seu arquivo deve ser menor que 5MB<a class='close' data-dismiss='alert'>&times;</a>.</div>";
            
        }
          
    }
       else
           
       {
           
           $errMSG = "<div class='alert alert-warning col-md-5'>Desculpe, somente JPG, JPEG & PNG arquivos são permitidos.<a class='close' data-dismiss='alert'>&times;</a></div>";
               
                          
       } 
    
  }
    
      else
          
      {

         
             // set variables
            $clientTelefone =  validateFormData($_POST["clientTelefone"]);
            $clientEstado  =   validateFormData($_POST["clientEstado"]);
            $clientCidade  =   validate($_POST["clientCidade"]);
            $clientBairro  =   validate($_POST["clientBairro"]);
            $clientAnuncio  =  validate($_POST["clientAnuncio"]);
            $optradio  =        $_POST["optradio"];
            $optradio1  =       $_POST["optradio1"];
            $clientPorte  =     $_POST["clientPorte"];
            $clientNotes    =  validate($_POST["clientNotes"]);

          if( !$_POST["clientCidade"]) {

            $error = "<div class='alert alert-danger col-md-2'>Cidade obrigatório *</div>";

        } else {

            $clientCidade = $_POST["clientCidade"];
        }

        if( !$_POST["clientBairro"] ) {

            $error = "<div class='alert alert-danger col-md-2'>Bairro obrigatório *</div>";

        } else {

            $clientBairro =  $_POST["clientBairro"];
        }


        if( !$_POST["clientNotes"] ) {

            $error = "<div class='alert alert-danger col-md-2'>Descrição obrigatório *</div>";

        } else {

            $clientNotes = $_POST["clientNotes"];
        }

        if( !$_POST["clientTelefone"] ) {

            $error = "<div class='alert alert-danger col-md-2'>Telefone obrigatório *</div>";

        } else {

            $clientTelefone = validateFormData( $_POST["clientTelefone"] );
        }

            if(  $userpic && $clientNotes && $clientTelefone && $clientBairro && $clientCidade ) {           
              // new database query & result
            $query = "UPDATE lista 
            SET phone='$clientTelefone', 
            estado='$clientEstado', 
            cidade='$clientCidade', 
            date_added=CURRENT_TIMESTAMP,  
            notes='$clientNotes', 
            imageName='$userpic', 
            bairro='$clientBairro', 
            anuncio='$clientAnuncio', 
            optradio='$optradio', 
            optradio1='$optradio1',
            porte='$clientPorte' 
            WHERE id='$clientID'" ;

            $result = mysqli_query( $conn, $query );


            if( $result ) {

                // redirect to client page with query string
                header("Location: meus-anuncios-animais.php?alert=updatesuccess");

            } else {

                echo "Error updating record: " . mysqli_error($conn); 

            }
        }
    }

} 

   
// if delete button was submitted
if( isset($_POST['delete']) ) {
    
    $alertMessage = "<div class='alert alert-danger col-md-3'>
                        <p>Tem certeza que deseja deletar?</p><br>
                        <form action='". htmlspecialchars( $_SERVER["PHP_SELF"] ) ."?id=$clientID' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Sim, deletar!'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, não obrigado!</a>
                        </form>
                    </div>";
    
}

// if confirm delete button was submitted
if( isset($_POST['confirm-delete']) ) {
    
    $query = "DELETE FROM lista WHERE id='$clientID'";
    $result = mysqli_query( $conn, $query );
    
    if( $result ) {
        
        // redirect to client page with query string
        header("Location: meus-anuncios-animais.php?alert=deleted");
        
    } else {
        
        echo "Error updating record: " . mysqli_error($conn);
    }
    
}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<!--Página para editar anúncio de animais, pets perdidos ou para adoção -->
<meta name="robots" content="noindex,nofollow">

<h1 class="det">Editar anúncio</h1>

<div class="col-md-12"><?php echo $alertMessage ?><?php echo $errMSG ?><?php echo $error ?></div>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?id=<?php echo $clientID; ?>" name="imageform" method="post" enctype="multipart/form-data" class="row">

    <div class="form-group col-md-5">
        <label for="autocomplete">Local *</label>
        <input type="text" class="form-control input-lg" id="autocomplete" onFocus="geolocate()" placeholder="Em qual bairro voc&ecirc; o encontrou?" value="" autofocus >
    </div>
    
    <div class="form-group col-md-1">
        <label for="administrative_area_level_1">Estado *</label>
        <input type="text" class="form-control input-lg" name="clientEstado" id="administrative_area_level_1" value="<?php echo $estado ?>" required readonly >
    </div>
    
    <div class="form-group col-md-3">
        <label for="locality">Cidade *</label>
        <input type="text" class="form-control input-lg" name="clientCidade" id="locality" value="<?php echo $cidade ?>" required  readonly >
    </div>    
    
    <div class="form-group col-md-3">
        <label for="sublocality_level_1">Bairro *</label>
        <input type="text" class="form-control input-lg" name="clientBairro" id="sublocality_level_1" value="<?php echo $bairro ?>" required readonly >
    </div>
    
    <div class="form-group col-md-2">
        <label for="sel">Tipo de anúncio *</label>
        <select class="form-control input-lg" name="clientAnuncio" id="sel" >
            <option <?php if ($anuncio == 'Encontrado') echo 'selected="selected"' ?>>Encontrado</option>
            <option <?php if ($anuncio == 'Perdido') echo 'selected="selected"' ?>>Perdido</option>
            <option <?php if ($anuncio != 'Encontrado' AND $anuncio!='Perdido') echo 'selected="selected"' ?>>Adoção</option>
        </select>
    </div>
    
    <div class="form-group col-md-2">
        <label for="optradio">Sexo *</label><br><br>
        <div class="radio-inline">
          <label><input type="radio" name="optradio" value="Macho" <?php if($optradio=='Macho') {?>checked<?php }?>>Macho</label>
        </div>
        <div class="radio-inline">
          <label><input type="radio" name="optradio" value="F&ecirc;mea" <?php if($optradio!='Macho') {?>checked<?php }?>>Fêmea</label>
        </div>
    </div>        
    
    <div class="form-group col-md-2">
        <label for="optradio1">Tipo do animal *</label><br><br>
        <div class="radio-inline">
          <label><input type="radio" name="optradio1" value="Cachorro" <?php if($optradio1=='Cachorro') {?>checked<?php }?>>Cachorro</label>
        </div>
        <div class="radio-inline">
          <label><input type="radio" name="optradio1" value="Gato" <?php if($optradio1=='Gato') {?>checked<?php }?>>Gato</label>
        </div>
    </div>
    
    <div class="form-group col-md-3">
        <label for="porte">Porte *</label>
        <select class="form-control input-lg" id="porte" name="clientPorte">
            <option <?php if ($porte == 'Pequeno') echo 'selected="selected"' ?>>Pequeno</option>
            <option <?php if ($porte != 'Pequeno' AND $porte != 'Pequeno') echo 'selected="selected"' ?>>Médio</option>
            <option <?php if ($porte == 'Grande') echo 'selected="selected"' ?>>Grande</option>
        </select>
    </div>       
    
    <div class="form-group col-md-3">
        <p></p><label for="client-company">Telefone *</label>
        <input type="text" class="form-control input-lg" OnKeyPress="formatar('##-####-#####', this)" id="telefone" name="clientTelefone" value="<?php echo $telefone ?>" maxlength="13" required>
    </div>
    
    <div class="form-group col-md-6">
        <label for="imageName">Imagem *</label>
        <input type="file" id="imageName" name="imageName" enctype="multipart/form-data" onchange="readURL(this);" >
        <img src="data:image;base64,<?php echo $image1 ?>" id="photo" class="img-rounded" alt="foto do animal, pet perdido ou para adoção" >
    </div>        
    
    <div class="form-group col-md-6">
        <label for="client-notes">Descrição *</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes" rows="8" maxlength="480" placeholder="Breve descri&ccedil;&atilde;o" required><?php echo $descricao ?></textarea>
    </div>
        <div class="col-md-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Deletar</button>
        <div class="pull-right">
            <a href="meus-anuncios-animais.php" type="button" class="btn btn-lg btn-default">Cancelar</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Atualizar</button>
        </div>
    </div>
</form>

<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/main.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBcXSL5OBCPrUmvvRerD5sv3y1BKTssgU&libraries=places&callback=initAutocomplete" async defer></script>


<?php
include('includes/footer.php');
?>