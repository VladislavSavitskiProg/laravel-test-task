<?php

namespace App\Contracts\Tasks;

interface TaskInterface
{
    public function handle();

    public function getName(): string;
}
