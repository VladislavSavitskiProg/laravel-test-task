<?php

namespace App\Console\Commands\Statistic;

use App\Services\Statistic\StatisticService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistic:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate statistic';

    public function __construct(
        private readonly StatisticService $statisticService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Running...');

        try {
            Cache::delete('statistic');
            Cache::remember('statistic', 86400, function (){
                return $this->statisticService->calculate();
            });
        } catch (\Throwable $e) {
            $this->info('Something went wrong.');
            $this->error($e);
            return;
        }

        $this->info('Completed.');
    }
}
