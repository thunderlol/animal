<?php

$server     = "encopet.mysql.dbaas.com.br";
$username   = "encopet";
$password   = "Encopet102016";
$db         = "encopet";

// create a connection
$conn = mysqli_connect( $server, $username, $password, $db );

// check connection
if( !$conn ) {
    die( "Connection failed: " . mysqli_connect_error() );
}

?>