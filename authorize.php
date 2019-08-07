<?php
$username = 'figlerr';
$password = 'Napsugar2019';

if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || $username != $_SERVER['PHP_AUTH_USER'] || $password != $_SERVER['PHP_AUTH_PW']){
    header('HTTP/1.1401 Unautorized');
    header('WWW-Authenticate: Basic realm ="Guitar Wars"');
    exit('<h2>Guitar Wars</h2><br>Sorry, you must enter valid user name and password to access this page.');
}
?>