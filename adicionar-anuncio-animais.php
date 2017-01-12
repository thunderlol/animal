<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: login.php");
}

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');
    

// if add button was submitted
if( isset( $_POST['add'] ) ) {
    
    // set all variables to empty by default
    $imageName = $clientEstado = $clientCidade = $clientTelefone = $clientBairro = $clientAnuncio = $clientNotes = $optradio = $optradio1 = $clientPorte = "";
    
    // these inputs are not required
    // so we'll just store whatever has been entered
    $clientTelefone =  validateFormData($_POST["clientTelefone"]);
    $clientEstado  =   validateFormData($_POST["clientEstado"]);
    $clientCidade  =   validate( $_POST["clientCidade"]);
    $clientBairro  =   validate($_POST["clientBairro"]);
    $clientAnuncio  =  validate($_POST["clientAnuncio"]);
    $optradio  =        $_POST["optradio"];
    $optradio1  =       $_POST["optradio1"];
    $clientPorte  =     $_POST["clientPorte"];
    $clientNotes    =   validate($_POST["clientNotes"]);
    $imageName = $_FILES['imageName']['name'];
    $imgSize = $_FILES['imageName']['size'];
    //$tmp_dir = $_FILES['imageName']['tmp_name'];
    $id = $_SESSION['idUser'];
   

    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    
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
    
    if( empty($imageName)) {
        
        $imageError = "<div class='alert alert-danger col-md-2'>Por favor escolha uma imagem *</div>";
        
    } 
    
    else {
        
       $image = addslashes($_FILES['imageName']['tmp_name']);
       $image = file_get_contents($image);
       $image = base64_encode($image);
      // $upload_dir = 'img/'; // upload directory

       $imgExt = strtolower(pathinfo($imageName,PATHINFO_EXTENSION)); // get image extension

       // valid image extensions
       $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions

       // rename uploading image
       $userpic = rand(1000,1000000).$id.".".$imgExt;

       // allow valid image file formats
       if(in_array($imgExt, $valid_extensions)){   
        
           // Check file size '5MB'
            if($imgSize < 5000000)    {
           
                // if required fields have data
                if(  $imageName && $clientNotes && $clientTelefone && $clientBairro && $clientCidade ) {

                    //move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                                                            
                    // create query
                    $query = "INSERT INTO lista (id, image, phone, estado, cidade, date_added,  notes, userid, imageName, bairro, anuncio, optradio, optradio1, porte) VALUES (NULL, '$image', '$clientTelefone', '$clientEstado', '$clientCidade', CURRENT_TIMESTAMP, '$clientNotes', '$id', '$userpic', '$clientBairro', '$clientAnuncio', '$optradio', '$optradio1', '$clientPorte')";
                    
                    
                    $result = mysqli_query( $conn, $query );

                    // if query was successful
                    if( $result ) {

                        // refresh page with query string
                        header( "Location: meus-anuncios-animais.php?alert=success" );

                    } else {

                        // something went wrong
                        echo "Error: ". $query ."<br>" . mysqli_error($conn);

                    }

                }
            
            } else {
            
                $errMSG = "<div class='alert alert-warning col-md-4'>Desculpe, o seu arquivo deve ser menor que 5MB<a class='close' data-dismiss='alert'>&times;</a>.</div>";
                
            }
           
        } else {
        
           $errMSG = "<div class='alert alert-warning col-md-4'>Desculpe, somente JPG, JPEG & PNG arquivos são permitidos.<a class='close' data-dismiss='alert'>&times;</a>.</div>";
       
       }
        
}

}

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<!--Página para adicionar anúncios de animais, pets perdidos ou para adoção -->
<meta name="robots" content="noindex,nofollow">

<h1 class="det">Adicionar anúncio</h1>
<div class="col-md-12"><?php echo $imageError ?> <?php echo $errMSG ?> <?php echo $error ?></div>
    <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" name="imageform" method="post" enctype="multipart/form-data" class="row">

    <div class="form-group col-md-5">
        <label for="autocomplete">Local *</label>
        <input type="text" class="form-control input-lg" id="autocomplete" onFocus="geolocate()" placeholder="Em qual bairro ou rua voc&ecirc; o encontrou ou est&aacute;?"           value="" autofocus required>
    </div>
    
    <div class="form-group col-md-1">
        <label for="administrative_area_level_1">Estado *</label>
        <input type="text" class="form-control input-lg" name="clientEstado" id="administrative_area_level_1" required readonly >
    </div>
    
    <div class="form-group col-md-3">
        <label for="locality">Cidade *</label>
        <input type="text" class="form-control input-lg" name="clientCidade" id="locality"  required  readonly >
    </div>    
    
    <div class="form-group col-md-3">
        <label for="sublocality_level_1">Bairro *</label>
        <input type="text" class="form-control input-lg" name="clientBairro" id="sublocality_level_1" required readonly >
    </div>
    
    <div class="form-group col-md-2">
        <label for="sel">Anúncio *</label>
        <select class="form-control input-lg" name="clientAnuncio" id="sel">
            <option>Encontrado</option>
            <option>Perdido</option>
            <option>Adoção</option>
        </select>
    </div>
    
    <div class="form-group col-md-2">
        <label for="optradio">Sexo *</label><br><br>
        <div class="radio-inline">
          <label><input type="radio" name="optradio" checked value="Macho">Macho</label>
        </div>
        <div class="radio-inline">
          <label><input type="radio" name="optradio" value="F&ecirc;mea">Fêmea</label>
        </div>
    </div>        
    
    <div class="form-group col-md-2">
        <label for="optradio1">Animal *</label><br><br>
        <div class="radio-inline">
          <label><input type="radio" name="optradio1" checked value="Cachorro">Cachorro</label>
        </div>
        <div class="radio-inline">
          <label><input type="radio" name="optradio1" value="Gato">Gato</label>
        </div>
    </div>
    
    <div class="form-group col-md-3">
        <label for="porte">Porte *</label>
        <select class="form-control input-lg" id="porte" name="clientPorte">
            <option>Pequeno</option>
            <option>Médio</option>
            <option>Grande</option>
        </select>
    </div>       
    
    <div class="form-group col-md-3">
        <p></p><label for="client-company">Telefone *</label>
        <input type="text"  OnKeyPress="formatar('##-####-#####', this)" class="form-control input-lg" id="telefone" name="clientTelefone"  maxlength="13" required>
    </div>
    
    <div class="form-group col-md-6">
        <label for="imageName">Imagem *</label>
        <input type="file" id="imageName" name="imageName" enctype="multipart/form-data" onchange="readURL(this);" required>
        <img src="img/animais.png" id="photo" class="img-rounded" alt="foto do animal, pet perdido ou para adoção" >
    </div>        
    
    <div class="form-group col-md-6">
        <label for="client-notes">Descrição *</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes" rows="8" maxlength="480" placeholder="Breve descri&ccedil;&atilde;o de onde encontrou, perdeu e caracter&iacute;sticas do animal como cor e manchas" required></textarea>
    </div>
         
    <div class="col-md-12">
            <a href="meus-anuncios-animais.php" type="button" class="btn btn-lg btn-default">Cancelar</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Publicar</button>
    </div>
        
</form>

<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/main.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBcXSL5OBCPrUmvvRerD5sv3y1BKTssgU&libraries=places&callback=initAutocomplete" async defer></script>

<?php
include('includes/footer.php');
?>