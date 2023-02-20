<?php

namespace App\Console\Commands\Imports;

use App\Contracts\Capacities\CapacityImportingFromCsv;
use Illuminate\Console\Command;

class ImportCapacitiesCommandFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:capacities-csv {--file-path= : The path to the capacities CSV file from project root directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import capacities data from CSV to the database.';

    private CapacityImportingFromCsv $capacityImporting;

    public function __construct(CapacityImportingFromCsv $capacityImporting)
    {
        parent::__construct();
        $this->capacityImporting = $capacityImporting;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $capacitiesFilePath = $this->option('file-path');

        if (!$capacitiesFilePath) {
            $this->error('Please provide the paths to the capacities file using --file-path option.');
            return;
        }

        $this->info('Importing data...');

        try {
            $this->capacityImporting->import($capacitiesFilePath);
        } catch (\Throwable $e) {
            $this->info('Something went wrong.');
            $this->error($e);
            return;
        }

        $this->info('Data import completed.');
    }
}
