<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StatisticService;

class DashboardServerController extends Controller
{
    protected $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function index()
    {
        // Gọi Service lấy toàn bộ data
        $dashboardData = $this->statisticService->getDashboardData();

        // Trả về view kèm dữ liệu
        return view('server.pages.dashboard.index', compact('dashboardData'));
    }
}
