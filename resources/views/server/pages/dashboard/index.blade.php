@extends('server.layout')

@section('content')
<div class="wrapper wrapper-content">
    {{-- PHẦN 1: THỐNG KÊ SỐ LƯỢNG (3 ĐỐI TƯỢNG) --}}
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title"><span class="label label-success pull-right">Tổng</span>
                    <h5>Doanh thu</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ number_format($dashboardData['counts']['revenue']) }} đ</h1>
                    <small>Tổng thu nhập thực tế</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title"><span class="label label-info pull-right">Thành viên</span>
                    <h5>User</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $dashboardData['counts']['users'] }}</h1>
                    <small>Tài khoản khách hàng</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title"><span class="label label-primary pull-right">Kho</span>
                    <h5>Sản phẩm</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $dashboardData['counts']['products'] }}</h1>
                    <small>Sản phẩm đang bán</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title"><span class="label label-danger pull-right">Giao dịch</span>
                    <h5>Đơn hàng</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $dashboardData['counts']['orders'] }}</h1>
                    <small>Tổng đơn hàng phát sinh</small>
                </div>
            </div>
        </div>
    </div>

    {{-- PHẦN 2: BIỂU ĐỒ DOANH THU & LƯỢT MUA --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Biểu đồ doanh thu 30 ngày gần nhất</h5>
                </div>
                <div class="ibox-content">
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script vẽ biểu đồ ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Dữ liệu từ Controller truyền sang
        const labels = @json($dashboardData['chart']['labels']);
        const dataMoney = @json($dashboardData['chart']['money']);
        const dataOrders = @json($dashboardData['chart']['orders']);

        new Chart(ctx, {
            type: 'bar', // Dạng cột kết hợp đường
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Doanh thu (VNĐ)',
                        data: dataMoney,
                        backgroundColor: 'rgba(26, 179, 148, 0.6)',
                        borderColor: 'rgba(26, 179, 148, 1)',
                        borderWidth: 1,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Số đơn hàng',
                        data: dataOrders,
                        type: 'line', // Vẽ đường đè lên cột
                        borderColor: '#f8ac59',
                        borderWidth: 2,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: { drawOnChartArea: false } // Ẩn lưới bên phải cho đỡ rối
                    }
                }
            }
        });
    });
</script>
@endsection