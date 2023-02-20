<?php

namespace App\Services\Statistic;

use App\Contracts\Tasks\TaskInterface;

class StatisticService
{
    /** @var TaskInterface[] $tasks */
    private array $tasks;
    public function __construct(
        TaskInterface ...$tasks
    ) {
        $this->tasks = $tasks;
    }

    public function calculate(): array
    {
        $data = [];

        foreach ($this->tasks as $task) {
            $data[$task->getName()] = $task->handle();
        }

        return $data;
    }
}
