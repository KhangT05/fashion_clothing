@extends('server.layout')
@section('title', 'Thương hiệu')
@section('content')
    <h2 class="text-center">Quản Lý Thương hiệu</h2>
    <div class="card">
        <a href="{{ route('brands.create') }}" class="btn btn-primary">Thêm Thương hiệu</a>
        <form method="GET" action="">
            <div>
                <input type="text" value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm" name="keyword" />
                <button class="btn btn-primary"><i class="fa fa-search">Tìm kiếm</i></button>
            </div>
        </form>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    @if (isset($brands) && count($brands) > 0)
                        <thead>
                            <tr class="info">
                                <th>#</th>
                                <th>Mã SP</th>
                                <th>Tên Thương hiệu</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>Số Lượng</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('server.pages.brands.components.table')
                        </tbody>
                    @else
                        <div class="text-center text-danger lead">Không tồn tại record</div>
                    @endif
                </table>
                {{ $brands->links() }}
            </div>
        </div>
    </div>
@endsection
