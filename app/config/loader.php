<?php

global $config;
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerNamespaces(
    [
        "tennisClub"   => $config->application->modelsDir,
        "security"   => $config->application->modelsDir
    ]
);
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->pluginsDir
    ]
)->register();

require_once __DIR__ . "/../../vendor/autoload.php";
