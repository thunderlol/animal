<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: login.php");
}

// connect to database
include('includes/connection.php');

// query & result
$id = $_SESSION['idUser'];
$query = "SELECT * FROM lista WHERE userId = $id  ORDER BY id DESC";
$result = mysqli_query( $conn, $query );

// check for query string
if( isset( $_GET['alert'] ) ) {
    
    // new client added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success col-md-2'>Anúncio publicado !<a class='close' data-dismiss='alert'>&times;</a></div>";
        
    // client updated
    } elseif( $_GET['alert'] == 'updatesuccess' ) {
        $alertMessage = "<div class='alert alert-success col-md-2'>Anúncio atualizado !<a class='close' data-dismiss='alert'>&times;</a></div>";
    
    // client deleted
    } elseif( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success col-md-2'>Anúncio deletado! <a class='close' data-dismiss='alert'>&times;</a></div>";
    
    } elseif( $_GET['alert'] == 'updateuser' ) {
        $alertMessage = "<div class='alert alert-success col-md-2'>Conta atualizada! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
      
}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<!--Página para ver todos os meus anúncios de animais, pets perdidos ou para adoção  -->
<meta name="robots" content="noindex,nofollow">
<h1 class="det">Meus anúncios</h1>

<div class="row"><?php echo $alertMessage; ?></div>

<table class="table table-condensed table-responsive">
    <tr>
        <th>Anúncio</th>
        <th>Sexo</th>
        <th>Tipo do Animal</th>
        <th>Porte</th>
        <th>Telefone</th>
        <th>Cidade</th>
        <th>Estado</th>
        <th>Bairro</th>
        <th>Imagem</th>
        <th>Editar</th>
    </tr>
    
    <?php
    
    if( mysqli_num_rows($result) > 0 ) {
        
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
        
            echo "<tr>";
            
            echo "<td>". $row['anuncio'] . "</td><td>" . $row['optradio'] . "</td><td>" . $row['optradio1'] . "</td><td>" . $row['porte'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['cidade'] . "</td><td>" . $row['estado'] . "</td><td>" . $row['bairro'] . "</td>";
            
            echo '<td><img src="data:image;base64,'.$row['image'].'" id="photo1" width="100" height="100" class="img-rounded" alt="foto do animal, pet perdido ou para adoção"></td>';
            
            echo '<td><a href="editar-anuncio-animais.php?id=' . $row['id'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                    </a></td>';
            
            echo "</tr>";
        }
        
    } else { // if no entries
        
        echo "<div class='alert alert-warning col-md-2'>Você não tem anúncios.</div>";
        
    }

    
    ?>

    <tr>
        
        <td colspan="10"><div class="text-center"><a href="adicionar-anuncio-animais.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Adicionar anúncio</a></div></td>
    
    </tr>
</table>

<?php
include('includes/footer.php');
?>