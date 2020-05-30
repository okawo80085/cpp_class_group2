<?php
include '../inc/config.php';
include '../inc/functions.php';
AuthenticatedCheck('LoggedOut');

if(!isset($_POST['action']))die("<font color='red'>Invalid request</font>");

if($_POST['action'] == 'Add User')
{
    $_POST['register'] = 1;
    $_POST['repassword'] = $_POST['password'];
    Register($_POST['access']);
}
else if($_POST['action'] == 'Modify User')
{
    $con->prepare("UPDATE users SET username=:username, access=:access WHERE id=:id")->execute(array(
        ':username' => $_POST['username'],
        ':access' => $_POST['access'],
        ':id' => $_POST['id']
    ));

    if($_POST['password'] != '')
        $con->prepare("UPDATE users SET password=:password WHERE id=:id")->execute(array(
            ':password' => getPass($_POST['username'],$_POST['password']),
            ':id' => $_POST['id']
        ));
    echo '<font color="limegreen">User updated!</font>';
}