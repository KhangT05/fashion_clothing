@extends('server.layout')
@section('title', 'Vai trò')
@section('content')
    <h2 class="text-center">Quản Lý Vai trò</h2>
    <div class="card">
        <a href="{{ route('roles.create') }}" class="btn btn-primary">Thêm Vai trò</a>
        <form method="GET" action="">
            <div>
                <input type="text" value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm" name="keyword" />
                <button class="btn btn-primary"><i class="fa fa-search">Tìm kiếm</i></button>
            </div>
        </form>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    @if (isset($roles) && count($roles) > 0)
                        <thead>
                            <tr class="info">
                                <th>#</th>
                                <th>Mã Vai trò</th>
                                <th>Tên Vai trò</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('server.pages.roles.components.table')
                        </tbody>
                    @else
                        <div class="text-center text-danger lead">Không tồn tại record</div>
                    @endif
                </table>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection
