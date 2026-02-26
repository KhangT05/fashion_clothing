@extends('server.layout')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Quản lý Thành viên</h2>
            <ol class="breadcrumb">
                <li class="active"><strong>Danh sách</strong></li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Danh sách thành viên</h5>
                        <div class="ibox-tools">
                            {{-- Nút Thêm mới --}}
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-xs">
                                <i class="fa fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>SĐT</th>
                                        <th>Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($users) && $users->count() > 0)
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>
                                                    @if ($user->publish == 1)
                                                        <span class="label label-primary">Hoạt động</span>
                                                    @else
                                                        <span class="label label-danger">Đã khóa</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{-- Nút Sửa --}}
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-success btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    {{-- LOGIC KHÓA / MỞ KHÓA --}}
                                                    @if ($user->publish == 1)
                                                        {{-- Nếu đang Hoạt động (1) -> Hiện nút Khóa (Delete) --}}
                                                        <a href="{{ route('users.destroy', $user->id) }}"
                                                            class="btn btn-danger btn-xs"
                                                            onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @else
                                                        {{-- Nếu đang Bị khóa (0) -> Hiện nút Mở khóa (Restore) --}}
                                                        <a href="{{ route('users.restore', $user->id) }}"
                                                            class="btn btn-warning btn-xs" title="Mở khóa tài khoản này"
                                                            onclick="return confirm('Bạn muốn mở khóa cho thành viên này?')">
                                                            <i class="fa fa-unlock"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Chưa có dữ liệu</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{-- Phân trang --}}
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
