<?php
namespace Producer\Githooks;

use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class Composer
{
    public static function postPackageInstall(PackageEvent $event) : void
    {
        // vendor/producer/githooks/src/Composer.php
        $root = dirname(dirname(dirname(__DIR__)));
        $hooks = $root . '/.git/hooks';

        if (! is_dir($hooks)) {
            echo "Git hooks directory not found at '$hooks'.";
            return 1;
        }

        $precommit = "{$hooks}/pre-commit";
        if (! is_file($precommit)) {
            touch($precommit);
        }

        $cmd = 'php ' . dirname(__DIR__) . '/bin/pre-commit.php';
        file_put_contents($precommit, PHP_EOL . $cmd . PHP_EOL, FILE_APPEND);
    }
}
