@extends('client.layouts')
@section('title', 'Trang đặt hàng')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3">
                @include('client.pages.profile.layout_menu')
            </div>
            <div class="col-md-9">
                <h3>Đơn hàng của tôi</h3>
                {{-- Bộ lọc --}}
                <div class="mb-3">
                    <a href="?status=all" class="btn btn-sm btn-outline-secondary">Tất cả</a>
                    <a href="?status=1" class="btn btn-sm btn-outline-warning">Chờ duyệt</a>
                    <a href="?status=3" class="btn btn-sm btn-outline-success">Hoàn thành</a>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                {{-- Hiển thị Mã đơn --}}
                                <td>#{{ $item->id }}</td>

                                {{-- Hiển thị Ngày đặt --}}
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                {{-- Hiển thị Trạng thái (FIX LỖI TRỐNG CỘT TRẠNG THÁI) --}}
                                <td>
                                    @if ($item->trangthai == 1)
                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                    @elseif($item->trangthai == 2)
                                        <span class="badge bg-info text-dark">Đang giao</span>
                                    @elseif($item->trangthai == 3)
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($item->trangthai == 0)
                                        <span class="badge bg-danger">Đã hủy</span>
                                    @else
                                        <span class="badge bg-secondary">Không xác định</span>
                                    @endif
                                </td>

                                {{-- Cột Thao tác --}}
                                <td>

                                    <a href="#" class="btn btn-sm btn-primary">Xem</a>

                                    @if ($item->trangthai == 1)
                                        <form action="{{ route('client.orders.cancel', $item->id) }}" method="POST"
                                            style="display: inline-block;"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Hủy</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
