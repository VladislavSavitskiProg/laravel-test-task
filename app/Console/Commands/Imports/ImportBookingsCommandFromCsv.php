<?php

namespace App\Console\Commands\Imports;

use App\Contracts\Bookings\BookingImportingFromCsv;
use Illuminate\Console\Command;

class ImportBookingsCommandFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:bookings-csv {--file-path= : The path to the bookings CSV file from project root directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import bookings data from CSV to the database.';

    private BookingImportingFromCsv $bookingImporting;

    public function __construct(BookingImportingFromCsv $bookingImporting)
    {
        parent::__construct();
        $this->bookingImporting = $bookingImporting;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $bookingsFilePath = $this->option('file-path');

        if (!$bookingsFilePath) {
            $this->error('Please provide the paths to the bookings file using --file-path option.');
            return;
        }

        $this->info('Importing data...');

        try {
            $this->bookingImporting->import($bookingsFilePath);
        } catch (\Throwable $e) {
            $this->info('Something went wrong.');
            $this->error($e);
            return;
        }

        $this->info('Data import completed.');
    }
}
