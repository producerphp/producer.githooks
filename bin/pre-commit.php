<?php
$autoloader = false;

$files = [
    dirname(__DIR__) . '/vendor/autoload.php',
    dirname(dirname(dirname(__DIR__))) . '/autoload.php',
];

foreach ($files as $file) {
    if (file_exists($file) && is_readable($file)) {
        $autoloader = $file;
        break;
    }
}

if (! $autoloader) {
    echo "Producer Githooks could not find a Composer autoloader." . PHP_EOL;
    echo "Please issue `composer install` or `composer update` first." . PHP_EOL;
    exit(1);
}

require $autoloader;

$command = new \Producer\Githooks\PreCommit();
exit($command());
