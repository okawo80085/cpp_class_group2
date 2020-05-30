<?php
include '../inc/config.php';

if(isset($_GET['check']))
    echo (int)!empty($settings->pool);
else
    echo "$settings->pool $settings->worker $settings->wpassword";