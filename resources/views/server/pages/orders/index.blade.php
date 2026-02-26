@extends('server.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Quản lý Đơn hàng</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="#">Admin</a>
                </li>
                <li class="active">
                    <strong>Danh sách đơn hàng</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Bộ lọc & Tìm kiếm</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('orders.index') }}" method="GET" class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" style="text-align: left;">Từ khóa:</label>
                                        <input type="text" name="keyword" class="form-control"
                                            placeholder="Nhập Mã đơn, Tên, SĐT..." value="{{ request('keyword') }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label" style="text-align: left;">Trạng thái:</label>
                                        <select name="status" class="form-control">
                                            <option value="all">-- Tất cả --</option>
                                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Chờ xử
                                                lý</option>
                                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đang
                                                giao</option>
                                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Hoàn
                                                thành</option>
                                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đã hủy
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label class="control-label" style="text-align: left;">Ngày đặt:</label>
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="date" class="form-control" name="date_from"
                                                value="{{ request('date_from') }}" />
                                            <span class="input-group-addon">đến</span>
                                            <input type="date" class="form-control" name="date_to"
                                                value="{{ request('date_to') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Tìm kiếm
                                    </button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-default">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Danh sách hóa đơn</h5>
                        <div class="ibox-tools">
                            <span class="label label-warning pull-right">{{ $orders->total() }} đơn hàng</span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">Mã</th>
                                        <th width="20%">Khách hàng</th>
                                        <th width="10%">SĐT</th>
                                        <th width="15%">Thanh toán</th>
                                        <th width="15%">Ngày đặt</th>
                                        <th width="15%">Trạng thái</th>
                                        <th width="10%" class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($orders) && $orders->count() > 0)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td><strong>#{{ $order->id }}</strong></td>
                                                <td>
                                                    {{ $order->name ?? ($order->user->name ?? 'N/A') }}
                                                    <div class="small text-muted">{{ $order->diachigiaohang }}</div>
                                                </td>
                                                <td>{{ $order->sdtnhan }}</td>

                                                <td>
                                                    <div style="margin-bottom: 5px;">
                                                        @if ($order->payment_method == 'VNPAY')
                                                            <span class="label label-info">VNPAY</span>
                                                        @elseif($order->payment_method == 'MOMO')
                                                            <span class="label label-danger">MOMO</span>
                                                        @else
                                                            <span class="label label-default">COD</span>
                                                        @endif
                                                    </div>

                                                    @if ($order->payment_status == 1)
                                                        <small class="text-success font-bold"><i class="fa fa-check"></i> Đã
                                                            TT</small>
                                                    @else
                                                        <small class="text-warning font-bold"><i class="fa fa-clock-o"></i>
                                                            Chưa TT</small>
                                                    @endif
                                                </td>

                                                <td>
                                                    <i class="fa fa-calendar"></i>
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}<br>
                                                    <i class="fa fa-clock-o"></i>
                                                    {{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}
                                                </td>

                                                <td>
                                                    @if ($order->trangthai == 1)
                                                        <span class="label label-warning">Chờ xử lý</span>
                                                    @elseif($order->trangthai == 2)
                                                        <span class="label label-primary">Đang giao</span>
                                                    @elseif($order->trangthai == 3)
                                                        <span class="label label-success">Hoàn thành</span>
                                                    @else
                                                        <span class="label label-danger">Đã hủy</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                        class="btn btn-white btn-sm" title="Xem chi tiết">
                                                        <i class="fa fa-eye"></i> Xem
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <br>
                                                <i class="fa fa-inbox fa-3x"></i><br>
                                                <h4>Không tìm thấy đơn hàng nào phù hợp!</h4>
                                                <br>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                {{-- Laravel mặc định gen HTML Tailwind, nếu vỡ giao diện hãy dùng: --}}
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
