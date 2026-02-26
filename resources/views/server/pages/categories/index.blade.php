@extends('server.layout')
@section('title', 'Danh sách danh mục')

@section('content')
    <div class="container">
        <div class="">
            <h1 class="">
                <i class=""></i> Quản lý danh mục
            </h1>

            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Thêm mới danh mục
            </a>
        </div>
        @if ($categories !== [])
            <form method="GET" action="{{ route('categories.index') }}" style="padding:3px 0px;">
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Nhập tên hoặc mô tả..."
                            value="{{ request('keyword') }}" style="padding:3px 0px;">
                    </div>

                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </div>
            </form>
        @endif
        <div class="">
            <div class="">
                <h3 class="">Danh sách danh mục</h3>
            </div>
            @if ($categories->count() == 0)
                <div class="text-center" style="margin: 40px 0;">
                    <h1 class="text-muted">
                        <i class="fa fa-folder-open"></i>
                        <span>Không có danh mục</span>
                    </h1>
                </div>
            @else
                <div class="">
                    <div class="">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr class="info">
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th class="text-center">Slug</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('server.pages.categories.components.table')
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
