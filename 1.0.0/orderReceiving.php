<?php
    $hopedir = '../';
    $config = $hopedir."config/hopeconfig.php";
    $cfg = include($config);
    $info = file_get_contents($cfg['siteurl']."/index.php?ctrl=site&action=orderReceiving");
?>
