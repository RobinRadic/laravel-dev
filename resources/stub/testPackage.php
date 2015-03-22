<?php

# place in base_path


# adjust classpath to match the script u want to run
$classPath = 'Laradic\Tests\Docs\TestPackage';


require_once __DIR__ . '/vendor/laradic/dev/stub/Booter.php';
$tempdir = __DIR__ . '/_test';
$app     = Booter::create(__DIR__, $tempdir);

new $classPath($app);
