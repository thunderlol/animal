<?php
session_start();
// did the user's browser send a cookie for the session?
if( isset( $_COOKIE[ session_name() ] ) ) {

    // empty the cookie
    setcookie( session_name(), '', time()-86400, '/' );

}

// clear all session variables
session_unset();

// destroy the session
session_destroy();

include('includes/header.php');
?>

<meta name="robots" content="noindex,nofollow">
<meta http-equiv="refresh" content=5;url="http://encopet.com.br/index.php">

<h1>Volte sempre.</h1>

<p class="lead">Obrigado por ajudar e utilizar o nosso site, ajude a divulgar.</p>

<?php
include('includes/footer.php');
?>