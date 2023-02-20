<?php

namespace App\Enums\Database;

use BenSampo\Enum\Enum;

final class TableNames extends Enum
{
    const USERS = 'users';
    const HOTELS = 'hotels';
    const CAPACITIES = 'capacities';
    const BOOKINGS = 'bookings';
}
