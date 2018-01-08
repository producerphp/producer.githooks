<?php
namespace Producer\Githooks;

class PreCommit
{
    public function __invoke(array $args = []) : int
    {
        $files = $this->getChangedFiles();
        foreach ($files as $file) {
            $exit = $this->lint($file);
            if ($exit !== 0) {
                return $exit;
            }
        }
        return 0;
    }

    protected function getChangedFiles() : array
    {
        exec("git diff-index --cached --name-only HEAD", $files);
        return $files;
    }

    protected function lint(string $file) : int
    {
        if (substr($file, -4) !== '.php') {
            return 0;
        }

        $file = escapeshellarg($file);
        passthru("php -l {$file} 2>&1", $exit);
        return $exit;
    }
}
