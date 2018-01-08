<?php
namespace Producer\Githooks;

use Composer\Installer\PackageEvent;
use Composer\Script\Event;

class Composer
{
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

        $hook = "{$hooks}/pre-commit";
        $script = dirname(__DIR__) . '/bin/pre-commit.php';
        $cmd = "php {$script}" . PHP_EOL;

        if (! is_file($hook)) {
            echo "Creating pre-commit hook." . PHP_EOL;
            file_put_contents($hook, $cmd);
            chmod('+x', $hook);
            return 0;
        }

        $code = file_get_contents($hook);
        if (strpos($code, $script) !== false) {
            echo "Appending to existing pre-commit hook." . PHP_EOL;
            file_put_contents($hook, PHP_EOL . $cmd, FILE_APPEND);
            return 0;
        }

        echo "Script appears to be in pre-commit hook already." . PHP_EOL;
        return 0;
    }
}
