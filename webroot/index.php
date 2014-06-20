<?php

$_SERVER['SERVER_PORT'] = 80;

// $app = require __DIR__.'/src/slimApp.php';
$app = require __DIR__.'/../src/app.php';

$app->run();

?>
