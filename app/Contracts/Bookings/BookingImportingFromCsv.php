<?php

namespace App\Contracts\Bookings;

interface BookingImportingFromCsv
{
    public function import(string $filePath): void;
}
