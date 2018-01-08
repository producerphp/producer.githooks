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
    echo "Could not find autoloader." . PHP_EOL;
    exit(1);
}

require $autoloader;

$command = new \Producer\Githooks\PreCommit();
exit($command());
