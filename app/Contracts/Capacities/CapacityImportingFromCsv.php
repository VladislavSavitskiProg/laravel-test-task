<?php

namespace App\Contracts\Capacities;

interface CapacityImportingFromCsv
{
    public function import(string $filePath): void;
}
