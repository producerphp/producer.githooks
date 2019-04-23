<?php
namespace Producer\Githooks;

class SetHooks
{
    public function __invoke(string $gitdir)
    {
        $hooks = rtrim(realpath($gitdir), DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR . '.git'
            . DIRECTORY_SEPARATOR . 'hooks';

        if (! is_dir($hooks)) {
            echo "{$hooks} directory not found." . PHP_EOL;
            return 1;
        }

        echo "Git hooks at {$hooks}." . PHP_EOL;

        $hook = "{$hooks}/pre-commit";
        $script = dirname(__DIR__) . '/bin/pre-commit.php';
        $cmd = "php {$script}" . PHP_EOL;

        if (! is_file($hook)) {
            echo "Creating pre-commit hook with the producer/githooks script." . PHP_EOL;
            file_put_contents($hook, $cmd);
            chmod($hook, 0755);
            return 0;
        }

        $code = file_get_contents($hook);
        if (strpos($code, $script) === false) {
            echo "Appending the producer/githooks script to existing pre-commit hook." . PHP_EOL;
            file_put_contents($hook, PHP_EOL . $cmd, FILE_APPEND);
            return 0;
        }


        echo "The producer/githooks script appears to be in the pre-commit hook already." . PHP_EOL;
        return 0;
    }
}
