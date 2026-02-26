@extends('server.layout')
@section('title', 'Sản phẩm đã xóa')
@section('content')
    <h2 class="text-center">Quản Lý Sản Phẩm Đã Xóa</h2>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Quay lại danh sách
            </a>
            <form method="GET" action="">
                <div>
                    <input type="text" value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm"
                        name="keyword" />
                    <button class="btn btn-primary"><i class="fa fa-search">Tìm kiếm</i></button>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @if (isset($products) && $products->count() > 0)
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
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
                            @include('server.pages.products.components.backup')
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fa fa-inbox fa-3x mb-3"></i>
                        <p class="lead">Không có sản phẩm nào đã xóa</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
