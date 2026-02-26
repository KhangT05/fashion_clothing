<?php

namespace App\Services;

use App\Repositories\StatisticRepository;

class StatisticService
{
    protected $statisticRepository;

    public function __construct(StatisticRepository $statisticRepository)
    {
        $this->statisticRepository = $statisticRepository;
    }

    public function getDashboardData()
    {
        // 1. Lấy số liệu tổng quan (Card)
        $counts = $this->statisticRepository->getCounts();

        // 2. Lấy số liệu biểu đồ
        $chartDataRaw = $this->statisticRepository->getRevenueChartData();

        // 3. Tách mảng cho ChartJS
        $labels = [];
        $dataMoney = [];
        $dataOrders = [];

        foreach ($chartDataRaw as $item) {
            $labels[] = date('d/m', strtotime($item->date)); // Ngày tháng
            $dataMoney[] = $item->total_money;
            $dataOrders[] = $item->total_orders;
        }

        return [
            'counts' => $counts,
            'chart' => [
                'labels' => $labels,
                'money' => $dataMoney,
                'orders' => $dataOrders
            ]
        ];
    }
}
