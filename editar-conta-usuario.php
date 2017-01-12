<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: login.php");
}

// get ID sent by GET collection
$clientID = $_SESSION['idUser'];

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

if( isset( $_GET['alert'] ) ) {
    
            // new client added
            if( $_GET['alert'] == 'error' ) {
                $error = "<div class='alert alert-danger'>Senha com no minímo 6 caracteres.<a class='close' data-dismiss='alert'>&times;</a></div>";
            }
        }


// query the database with client ID
$query = "SELECT * FROM users WHERE id='$clientID'";
$result = mysqli_query( $conn, $query );

// if result is returned
if( mysqli_num_rows($result) > 0 ) {
    
    // we have data!
    // set some variables
    while( $row = mysqli_fetch_assoc($result) ) {
        
        $email       = $row['email'];
        $name        = $row['name'];
    }
    
} else { // no results returned
    
    $alertMessage = "<div class='alert alert-warning'>Nada para ver aqui. <a href='meus-anuncios-animais.php'>Retornar</a>.</div>";
}

// if update button was submitted
if( isset($_POST['update']) ) {
    
      $email       = validateFormData($_POST["email"]);
      $name        = validateFormData($_POST["name"]);
      $password    = validateFormData($_POST['password']);

            if (empty($password)) {
                
                $query =    "UPDATE users 
                            SET name='$name', 
                            email='$email'
                            WHERE id='$clientID'";
                $result1 = mysqli_query( $conn, $query );
                
            } else {
                
                if (strlen($password) < 6){
                 
                    header("Location: editar-conta-usuario.php?alert=error");       
                
                } else {
                    
                    $pass = password_hash($password, PASSWORD_DEFAULT);
                    $query =    "UPDATE users 
                                SET name='$name', 
                                email='$email',
                                password='$pass'
                                WHERE id='$clientID'";
                    $result1 = mysqli_query( $conn, $query );
                }
                
            }
            
              
              
            if( $result1 ) {

                // redirect to client page with query string
                header("Location: meus-anuncios-animais.php?alert=updateuser");

            } else {

                echo "Error updating record: " . mysqli_error($conn); 

            }

        }
                    
   
// if delete button was submitted
if( isset($_POST['delete']) ) {
    
    $alertMessage = "<div class='alert alert-danger col-md-3'>
                        <p>Tem certeza que deseja deletar a sua conta?</p><br>
                        <form action='". htmlspecialchars( $_SERVER["PHP_SELF"] ) ."?id=$clientID' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Sim, deletar!'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, não obrigado!</a>
                        </form>
                    </div>";
    
}

// if confirm delete button was submitted
if( isset($_POST['confirm-delete']) ) {
    
    $query = "DELETE FROM users WHERE id='$clientID'";
    $result = mysqli_query( $conn, $query );
    
    if( $result ) {
        
        // redirect to client page with query string
        header("Location: logout.php");
        
    } else {
        
        echo "Error updating record: " . mysqli_error($conn);
    }
    
}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<!--Página para editar a conta do usuário no site de pesquisa de animais, pets perdidos ou para adoção -->
<meta name="robots" content="noindex,nofollow">
<h1 class="det">Editar conta</h1>

<?php echo $alertMessage ?>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?id=<?php echo $clientID; ?>" name="editform" method="post" class="row">
    
    <div class="row">
    <div class="col-sm-4">
        <?php echo $error ?>
    </div>
</div>
    
    <div class="row">
        <div class="form-group col-md-4">
            <p></p><label for="client-name">Nome *</label>
            <input type="text" class="form-control input-lg" id="name" name="name" style='text-transform:uppercase'value="<?php echo $name ?>" maxlength="30" required>
        </div>
    
        <div class="form-group col-md-4">
            <p></p><label for="client-email">Email *</label>
            <input type="text" class="form-control input-lg" id="email" name="email" value="<?php echo $email ?>" maxlength="60" required>
        </div>    
    </div>
    
    <div class="row">
        <div class="form-group col-md-4">
            <p></p><label for="password">Nova senha </label>
            <input type="password" class="form-control input-lg" id="password" name="password" maxlength="25">
        </div>    
    </div>
    
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Deletar</button>
        <div class="pull-right">
            <a href="meus-anuncios-animais.php" type="button" class="btn btn-lg btn-default">Cancelar</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Atualizar</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>