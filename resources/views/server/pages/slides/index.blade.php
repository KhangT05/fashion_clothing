@extends('server.layout')

@section('title', 'Danh sách slide')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h2 class="m-0 font-weight-bold text-primary">Quản lý Slide</h2>
            <a href="{{ route('slides.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle"></i> Thêm mới slide
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light text-center">
                        <tr class="info">
                            <th>STT</th>
                            <th>Têu đề</th>
                            <th>Hình ảnh thu nhỏ</th>
                            <th>Order</th>
                            <th>linklienket</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('server.pages.slides.components.table')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
