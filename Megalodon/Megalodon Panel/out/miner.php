<?php
if(isset($_GET['version']) && !isset($_GET['opencl']))
    echo implode(',',array_map('basename',glob('miner/'.(int)$_GET['version'].'/*.*')));
if(isset($_GET['opencl']))
    echo implode(',',array_map('basename',glob('miner/'.(int)$_GET['version'].'/opencl/*.*')));