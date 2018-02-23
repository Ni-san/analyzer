<?php

namespace nisan\analyzer;

class Application
{
    /** Max files in list - default value */
    const LIST_SIZE = 50;

    /** @var int $listSize Max files in list */
    private $listSize;

    /** @var string|null $dir */
    private $dir;

    public function __construct(array $config = [])
    {
        $this->listSize = (int)($config['listSize'] ?? self::LIST_SIZE);
        $this->dir = $config['dir'] ?? null;
    }

    public function run()
    {
        try {
            $command = $this->getCommand();

            // Array of string. Output of command by line
            $log = $this->execute($command);

            $view = View::build($log);

            echo $view->showOverall();
            echo $view->showList($this->listSize);

        } catch (\Throwable $t) {
            echo 'Fatal error occured.' . PHP_EOL;
        }
    }

    private function getCommand()
    {
        return (
            isset($this->dir)
                ? 'git -C ' . $this->dir . ' '
                : 'git '
            ) . 'log --name-only --oneline';
    }

    private function execute(string $command): array
    {
        $log = [];
        $returnCode = 0;

        exec($command, $log, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception('Command returned non-zero code');
        }

        return $log;
    }
}
