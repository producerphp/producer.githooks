<?php
namespace Producer\Githooks;

use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class Composer
{
    x

    public static function postPackageInstall(PackageEvent $event) : int
    {
        $dirs = [
            dirname(__DIR__) . '/.git/hooks',
            dirname(dirname(dirname(dirname(__DIR__)))) . '/.git/hooks',
        ];

        $hooks = false;
        foreach ($dirs as $dir) {
            echo $dir . PHP_EOL;
            if (is_dir($dir)) {
                $hooks = $dir;
                break;
            }
        }

        if ($hooks === false) {
            echo "Git hooks directory not found." . PHP_EOL;
            return 1;
        }

        $precommit = "{$hooks}/pre-commit";
        if (! is_file($precommit)) {
            touch($precommit);
        }

        $cmd = 'php ' . dirname(__DIR__) . '/bin/pre-commit.php';
        file_put_contents($precommit, PHP_EOL . $cmd . PHP_EOL, FILE_APPEND);
        return 0;
    }
}
