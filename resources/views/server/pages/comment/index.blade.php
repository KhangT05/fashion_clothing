@extends('server.layout')

@section('title', 'Quản lý bình luận')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h2 class="m-0 font-weight-bold text-primary">Quản lý Bình luận</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-center">
                    <tr>
                        <th>STT</th>
                        <th>Người gửi</th>
                        <th>Sản phẩm</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $index => $comment)
                    <tr>
                        <td class="text-center">{{ $comments->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $comment->user->name ?? 'Ẩn danh' }}</strong><br>
                            <small class="text-muted">{{ $comment->user->email ?? '' }}</small>
                        </td>
                        <td>
                            {{-- Hiển thị tensp từ bảng sanpham --}}
                            {{ $comment->product->tensp ?? 'Sản phẩm đã xóa' }}
                        </td>
                        <td>{{ $comment->noidung }}</td>
                        
                        <td class="text-center">{{ $comment->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <form action="{{ route('comment.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Xóa bình luận này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection