@extends('server.layout')
@section('title', 'Sản phẩm')
@section('content')
    <h2 class="text-center">Quản Lý Sản Phẩm</h2>
    <div class="card">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
        <form method="GET" action="">
            <div>
                <input type="text" value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm" name="keyword" />
                <button class="btn btn-primary"><i class="fa fa-search">Tìm kiếm</i></button>
            </div>
        </form>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    @if (isset($products) && count($products) > 0)
                        <thead>
                            <tr class="info">
                                <th>Mã SP</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>Số Lượng</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('server.pages.products.components.table')
                        </tbody>
                    @else
                        <div class="text-center text-danger lead">Không tồn tại record</div>
                    @endif
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
