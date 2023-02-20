<?php

namespace App\Console\Commands\Bookings;

use App\Services\Bookings\BookingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateBookingStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating statuses of bookings.';

    public function __construct(private BookingService $bookingService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Running...');

        DB::beginTransaction();

        try {
            $this->bookingService->updateStatuses();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->info('Something went wrong.');
            $this->error($e);
            return;
        }

        DB::commit();

        $this->info('Completed.');
    }
}
