<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'kolekcija';


$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(!$db)
    die('Spajanje na bazu nije moguce: '.  mysqli_connect_error());

$db->set_charset('utf8');