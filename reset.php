<?php

include('includes/connection.php');
include('includes/functions.php');

if( isset( $_GET['alert'] ) ) {
    
            // new client added
            if( $_GET['alert'] == 'error' ) {
                $error = "<div class='alert alert-danger'>Senha com no minímo 6 caracteres.<a class='close' data-dismiss='alert'>&times;</a></div>";
            }
        }

if(isset($_POST['submit_password']) )
    {
  
    
    $email=validateFormData($_POST['email']);
    $pass1=validateFormData( $_POST['password']);
    $code=($_POST['code']);
    
    
    if (strlen($pass1) < 6){
        
        header("Location: reset.php?key=".$email."&code=".$code."&alert=error");       
        
                                                
    }
    
    else {
    
        $token = rand(1000,1000000);
        
        $pass = password_hash($pass1, PASSWORD_DEFAULT);
        $select1="UPDATE users SET password='$pass', token='$token' WHERE token='$code'";
  
        if (mysqli_query($conn, $select1)) {
            
            header("Location: login.php?alert=updatesuccess");
            
            } else {

            echo "Error updating record: " . mysqli_error($conn);

            }
        
        }

        mysqli_close($conn);

    }


if($_GET['key'] AND $_GET['code'])
{
    $email=$_GET['key'];
    $code=$_GET['code'];
    $select="select email from users where email='$email' AND token='$code'";
    $result1 = mysqli_query( $conn, $select );
    
    if(mysqli_num_rows($result1) ==1)
  {
        
    
        ?>

<?php include('includes/header.php'); ?>
    
<!--Página para resetar a senha do usuário no site de animais perdidos ou para adoção -->
    <meta name="robots" content="noindex,nofollow">
    <div class="container">
    <h1>CRIAR NOVA SENHA </h1>
    
    <form method="post" class="sa-innate-form" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>">
    <input type="hidden" name="email" value="<?php echo $email;?>">
    <input type="hidden" name="code" value="<?php echo $code;?>">
    
                
    <div class="col-sm-4">
        <?php echo $error;?>
        <b><p>Digite sua nova senha</p></b>
        <input type="password" class="form-control" name="password" maxlength="25" required>
        <input type="submit" name="submit_password">
    </div>
        
    </form>
</div>
    
        
    <?php
  }
    else {
     
        header("Location: login.php");
        
    }
    mysqli_close($conn);
}
?>
        
<?php
include('includes/footer.php');
?>