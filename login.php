<?php

session_start();

include('includes/functions.php');
include('includes/connection.php');
require_once('class/class.phpmailer.php');
// if login form was submitted

if( isset( $_GET['alert'] ) ) {
    
    // new client added
    if( $_GET['alert'] == 'updatesuccess' ) {
        $alertMessage = "<div class='alert alert-success'>Senha redefinida.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

if(isset($_POST['action']))
    {          
        if($_POST['action']=="login")
        {
            // create variables
            // wrap data with validate function
            $formEmail = validateFormData( $_POST['email'] );
            $formPass = validateFormData( $_POST['password'] );

            // create query
            $query = "SELECT name, password, id FROM users WHERE email='$formEmail'";

            // store the result
            $result = mysqli_query( $conn, $query );

            // verify if result is returned
            if( mysqli_num_rows($result) > 0 ) {

                // store basic user data in variables
                while( $row = mysqli_fetch_assoc($result) ) {
                    
                    $name       = $row['name'];
                    $hashedPass = $row['password'];
                    $id = $row['id'];
                }

                        // verify hashed password with submitted password
                if( password_verify( $formPass, $hashedPass ) ) {

                    // correct login details!
                    // store data in SESSION variables
                    $_SESSION['loggedInUser'] = $name;
                    $_SESSION['idUser'] = $id;

                    // redirect user to clients page
                    header( "Location: meus-anuncios-animais.php" );
                    } 
                
                else { // hashed password didn't verify

                    // error message
                    $loginError = "<div class='alert alert-danger'>Email / Senha  errado. Tente novamente.<a class='close' data-dismiss='alert'>&times;</a></div>";
                     
                    }

                } 
            
            else { // there are no results in database

                // error message
                $loginError = "<div class='alert alert-danger'>Email / Senha  errado. Tente novamente.<a class='close' data-dismiss='alert'>&times;</a></div>";
                }

            }
    
            elseif($_POST['action']=="signup"){
                
                $name       = validateFormData($_POST['name']);
                $email      = validateFormData($_POST['email']);
                $password   = validateFormData($_POST['password']);

                $name = strtoupper($name);
                                
                $query = "SELECT email FROM users where email='$email'";

                $result = mysqli_query($conn,$query);
                $numResults = mysqli_num_rows($result);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validate email address
                    {
                    
                    $loginError1 = "<div class='alert alert-danger'>Email inválido !<a class='close' data-dismiss='alert'>&times;</a></div>";
                        
                    }
                
                elseif($numResults>=1)
                    
                    {
                    
                    $loginError1 = "<div class='alert alert-danger'>Email já cadastrado !<a class='close' data-dismiss='alert'>&times;</a></div>";
                    }
                
                elseif(strlen($password) < 6){
                    
                    $loginError1 = "<div class='alert alert-danger'>Senha com no minímo 6 caracteres.<a class='close' data-dismiss='alert'>&times;</a></div>";            
                    
                    }
                
                else
                    
                    {
                     
                     $password1 = password_hash($password, PASSWORD_DEFAULT);
                     $query = "INSERT INTO users (id, name, email, password) VALUES (NULL, '$name', '$email', '$password1')";
                     $result = mysqli_query( $conn, $query );
                     $sucess = "<div class='alert alert-success'>Cadastrado com sucesso !<a class='close' data-dismiss='alert'>&times;</a></div>";

                    }
            }
    
            elseif($_POST['action']=="Enviar email"){
                
                 // create variables
                // wrap data with validate function
                $formEmail =  $_POST['emailR'];

                // create query
                $query = "SELECT name, id, email FROM users WHERE email='$formEmail'";

                // store the result
                $result = mysqli_query( $conn, $query );

                // verify if result is returned

                if (!filter_var($formEmail, FILTER_VALIDATE_EMAIL)) // Validate email address
                {

                $loginError1 = "<div class='alert alert-danger'>Email inválido !<a class='close' data-dismiss='alert'>&times;</a></div>";

                }
                
                elseif( mysqli_num_rows($result) > 0 ) 
                {
                    
                    $token = rand(1000,1000000);
                    // store basic user data in variables
                    while( $row = mysqli_fetch_assoc($result) ) {

                        $name       = $row['name'];
                        $email      = $row['email'];
                        $id = $row['id'];
                    }
                    
                    $query = "UPDATE users
                    SET token='$token'
                    WHERE email='$email'";

                    mysqli_query( $conn, $query );
                    
                    
                    
                    // Inicia a classe PHPMailer
$mail = new PHPMailer(true);
 
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
 
try {
     $link="<a href='http://encopet.com.br/reset.php?key=".$email."&code=".$token."'>Criar nova senha</a>";
     $mail->Host = 'smtp.encopet.com.br'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
     $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
     $mail->Port       = 587; //  Usar 587 porta SMTP
     $mail->Username = 'encopet@encopet.com.br'; // Usuário do servidor SMTP (endereço de email)
     $mail->Password = 'Encopet10'; // Senha do servidor SMTP (senha do email usado)
 
     //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
     $mail->SetFrom('encopet@encopet.com.br'); //Seu e-mail
     $mail->AddReplyTo('encopet@encopet.com.br'); //Seu e-mail
     $mail->Subject = 'Esqueceu sua senha ?';//Assunto do e-mail
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress($email);
 
     //Campos abaixo são opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
 
 
     //Define o corpo do email
     $mail->MsgHTML('  <h1>Criar nova senha</h1>
                                    <p>Esqueceu sua senha? Sem problemas.<br>Para criar uma nova senha clique no link abaixo:</p>'.$link.'
                                    <p>Voc&ecirc recebeu este e-mail atrav&eacutes de uma solicita&ccedil&atildeo no site ENCOPET. Se voc&ecirc N&AtildeO solicitou uma nova senha, ignore este e-mail que sua senha continuar&aacute a mesma. </p>
                                    <p>Att, <br> Equipe ENCOPET</p>
                    
                    '); 
 
     ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
     //$mail->MsgHTML(file_get_contents('arquivo.html'));
 
     $mail->Send();
     $resetOk = "Mensagem enviada com sucesso</p>\n";
 
    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      $resetNot =  $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
    }
                }
            }
}
 
// close mysql connection
mysqli_close($conn);

include('includes/header.php');


?>
<meta name="robots" content="noindex,nofollow">

<div class="text-center"><h1>Encontre seu <b>AMIGO</b> perdido ou para adoção aqui.</h1></div>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="form-body">
                <ul class="nav nav-tabs final-login">
                    <?php echo $alertMessage; ?>
                    <?php echo $sucess; ?>
                    <?php echo $loginError; ?>
                    <?php echo $loginError1; ?>
                    <?php echo $resetOk; ?>
                    <?php echo $resetNot; ?>
                
                    <!--Página de login e cadastrar no site para persquisa de animais perdidos ou para adoção -->
                    <li class="active"><a data-toggle="tab" href="#sectionA">Login</a></li>
                    <li><a data-toggle="tab" href="#sectionB">Cadastrar</a></li>
                </ul>
                
                    <div class="tab-content">
                        <div id="sectionA" class="tab-pane fade in active">
                            <div class="innter-form">
                                <form class="sa-innate-form" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                                    <label>Email *</label>
                                    <input type="text" name="email" maxlength="30" required>
                                    <label>Senha *</label>
                                    <input type="password" name="password" maxlength="25" required>
                                    <input name="action" type="hidden" value="login" /></p>
                                    <p><input type="submit" value="Entrar" /></p>
                                    <a data-toggle="tab" href="#sectionC" id="rPass">Esqueci minha senha</a>
                                </form>
                            </div>
                        <div class="clearfix"></div>
                        </div>

                    <div id="sectionB" class="tab-pane fade">
                        <div class="innter-form">
                            <form class="sa-innate-form" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                                <label>Nome *</label>
                                <input type="text" name="name" style='text-transform:uppercase' maxlength="30" required>
                                <label>Email *</label>
                                <input type="text" name="email" maxlength="60" required>
                                <label>Senha *</label>
                                <input type="password" name="password" maxlength="25" required>
                                <input name="action" type="hidden" value="signup" /></p>
                                <p><input type="submit" value="Criar conta" /></p>
                                <p>*Ao clicar em <b>Criar conta</b>, você concorda com a nossa Política de Privacidade, Política de Cookies e Termos de uso.</p>
                            </form>
                        </div>
                    </div>

                    <div id="sectionC" class="tab-pane fade">
                        <div class="innter-form">
                            <form class="sa-innate-form" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                                <label>Por favor forneça seu email *</label>
                                <input type="text" name="emailR" maxlength="60" required>
                                <input type="submit" href="#sectionC" name="action" value="Enviar email">
                                <a data-toggle="tab" href="#sectionA">Cancelar</a></li>
                            </form>
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include('includes/footer.php');
?>