@extends('server.layout')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Chi tiết Slide</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $slide->id }}</td>
                    </tr>

                    <tr>
                        <th>Tiêu đề</th>
                        <td>{{ $slide->tieude }}</td>
                    </tr>

                    <tr>
                        <th>Hình ảnh</th>
                        <td>
                            @if ($slide->hinhthunho)
                                <img src="{{ asset($slide->hinhthunho) }}" alt="Slide hinhthunho"
                                    style="max-width: 300px; border-radius: 6px;">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Mô tả</th>
                        <td>{!! nl2br(e($slide->mota)) !!}</td>
                    </tr>

                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            @if ($slide->trangthai == 1)
                                <span class="badge badge-success">Hiển thị</span>
                            @else
                                <span class="badge badge-secondary">Ẩn</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Ngày tạo</th>
                        <td>{{ $slide->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer">
                <a href="{{ route('slides.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Quay lại
                </a>

                <a href="{{ route('slides.edit', $slide->id) }}" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Sửa
                </a>
            </div>
        </div>
    </div>
@endsection
