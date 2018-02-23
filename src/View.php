<?php

namespace nisan\analyzer;

class View
{
    const TAB = "\t";

    public $commits = 0;

    public $files = [];

    private $countFiles;

    public static function build(array $log): View
    {
        $view = new self();

        foreach ($log as $line) {
            if (!empty($line)) {
                // line with commit header (hash + message)
                $commitHeader = 1 === preg_match('/^[\d|a-f]*\s/', $line);

                if ($commitHeader) {
                    $view->commits++;
                } else {
                    $view->files[$line] = ($view->files[$line] ?? 0) + 1;
                }
            }
        }

        // SORT_DESC for files by change frequency
        arsort($view->files);

        return $view;
    }

    private function getCountFiles(): int
    {
        if (null === $this->countFiles) {
            $this->countFiles = count($this->files);
        }

        return $this->countFiles;
    }

    public function showOverall(): string
    {
        return implode(PHP_EOL, [
            'Commits total: ' . $this->commits,
            'Files total: ' . $this->getCountFiles(),
            '',
        ]);
    }

    public function showList(int $listSize): string
    {
        $lines = [];
        if ($this->getCountFiles() > $listSize) {
            $lines[] = 'Top-' . $listSize . ':';
            $files = array_slice($this->files, 0, $listSize);
        } else {
            $files = $this->files;
        }

        $lines[] = 'Count' . self::TAB . 'Freq' . self::TAB . 'File name';

        foreach ($files as $file => $count) {
            $lines[] = $count . self::TAB
                . ($this->commits ? sprintf('%.1f%%', 100 * $count / $this->commits) : 0) . self::TAB
                . $file;
        }

        $lines[] = '';

        return implode(PHP_EOL, $lines);
    }
}
