<?php
namespace Producer\Githooks;

class PreCommit
{
    public function __invoke(array $args = []) : int
    {
        $files = $this->getChangedFiles();
        foreach ($files as $file) {
            $exit = (int) $this->lint($file);
            if ($exit > 0) {
                return $exit;
            }
        }
        return 0;
    }

    protected function getChangedFiles() : array
    {
        // check for initial commit on empty tree
        exec('git rev-parse --verify HEAD 2> /dev/null', $output, $exit);
        $tree = ($exit == 0) ? 'HEAD' : '4b825dc642cb6eb9a060e54bf8d69288fbee4904';

        // filter on added/copied/modified PHP files
        exec("git diff-index --diff-filter=ACM --name-only {$tree}", $files);
        return $files;
    }

    protected function lint(string $file) : ?int
    {
        if (substr($file, -4) !== '.php') {
            return null;
        }

        $file = escapeshellarg($file);
        passthru("php -l {$file} 2>&1", $exit);
        return $exit;
    }
}
