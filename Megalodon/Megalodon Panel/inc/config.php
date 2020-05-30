<?php

if(file_exists('install.php') && basename($_SERVER['PHP_SELF'])!='install.php') header('Location: install.php');

session_start();

$config = array(
    'host'    => '', //Database Hostname
    'user'    => '', //Database Username
    'pass'    => '', //Database Password
    'db'      => '', //Database Name
    'logging' => false
);

//Starting Database Connection
try
{
    $con = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['db'], $config['user'], $config['pass']);
    if(!file_exists('install.php')) $settings =  $con->query("SELECT * FROM settings")->fetch(PDO::FETCH_OBJ);
}
catch(PDOException $e)
{
    echo $e->getMessage();
    die();
}

if($config['logging'])
{
	ini_set("log_errors" , "1");
	ini_set("error_log" , "logs/errors.txt");
	ini_set("display_errors" , "0");
}

?>
