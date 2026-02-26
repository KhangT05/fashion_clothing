@extends('server.layout')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Chi tiết sản phẩm đơn #{{ $order->id }}</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($order->chiTiet as $item)
                                @php $total += $item->thanhtien; @endphp
                                <tr>
                                    <td>
                                        {{ $item->sanpham->tensp ?? 'Sản phẩm đã bị xóa' }}
                                    </td>
                                    <td>{{ number_format($item->dongia) }} đ</td>
                                    <td>{{ $item->soluong }}</td>
                                    <td>{{ number_format($item->thanhtien) }} đ</td>
                                </tr>
                            @endforeach
                            <tr class="font-weight-bold">
                                <td colspan="3" class="text-right">Tổng cộng:</td>
                                <td>{{ number_format($total) }} đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Xử lý đơn hàng</div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Trạng thái hiện tại:</label>
                            <select name="trangthai" class="form-control">
                                <option value="1" {{ $order->trangthai == 1 ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="2" {{ $order->trangthai == 2 ? 'selected' : '' }}>Đang giao hàng
                                </option>
                                <option value="3" {{ $order->trangthai == 3 ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="0" {{ $order->trangthai == 0 ? 'selected' : '' }}>Hủy đơn</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-3">Cập nhật trạng thái</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Thông tin giao hàng</div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> {{ $order->name }}</p>
                    <p><strong>SĐT:</strong> {{ $order->sdtnhan }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->diachigiaohang }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
