<?php

namespace App\Http\Controllers;

use App\Services\Statistic\StatisticService;
use Illuminate\Support\Facades\Cache;

class StatisticController extends Controller
{
    public function __construct(
        private readonly StatisticService $statisticService,
    ) {}

    public function index()
    {
        $data = Cache::remember(
            'statistic',
            86400,
            fn() => $this->statisticService->calculate()
        );

        return view('statistic.dashboard', compact('data'));
    }
}
