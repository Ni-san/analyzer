#!/usr/bin/env php
<?php

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require(__DIR__ . '/vendor/autoload.php');

// Register PSR-4 based loader on src dir
$loader->addPsr4('nisan\analyzer\\', __DIR__ . '/src');

$config = ['listSize' => 50];
if (!empty($argv[1])) {
    $config['dir'] = $argv[1];
}

(new \nisan\analyzer\Application($config))->run();
