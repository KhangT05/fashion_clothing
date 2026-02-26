@extends('server.layout')

@section('content')
    @php
        // Logic xác định URL và Tiêu đề dựa trên biến $config từ Controller
        $isEdit = $config == 'update';
        $url = $isEdit ? route('users.update', $user->id) : route('users.store');
        $title = $isEdit ? 'Cập nhật thành viên: ' . $user->name : 'Thêm mới thành viên';
    @endphp

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title }}</h2>
            <ol class="breadcrumb">

                <li><a href="{{ route('users.index') }}">Thành viên</a></li>
                <li class="active"><strong>{{ $isEdit ? 'Cập nhật' : 'Thêm mới' }}</strong></li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thông tin chi tiết</h5>
                    </div>
                    <div class="ibox-content">
                        {{-- Form bắt đầu --}}
                        <form action="{{ $url }}" method="POST" class="form-horizontal">
                            @csrf
                            {{-- Nếu là Edit thì phải thêm method PUT giả lập --}}
                            @if ($isEdit)
                                @method('PUT')
                            @endif

                            {{-- Hiển thị lỗi Validate --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Email --}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Email <span class="text-danger">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" value="{{ old('email', $user->email ?? '') }}"
                                        class="form-control" {{ $isEdit ? 'readonly' : '' }}>
                                </div>
                            </div>

                            {{-- Họ tên --}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Họ tên <span class="text-danger">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                                        class="form-control">
                                </div>
                            </div>

                            {{-- Mật khẩu --}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Mật khẩu <span class="text-danger">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control">
                                    @if ($isEdit)
                                        <span class="help-block m-b-none text-warning">Để trống nếu không muốn đổi mật
                                            khẩu.</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Nhập lại Mật khẩu --}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nhập lại mật khẩu <span
                                        class="text-danger">(*)</span></label>
                                <div class="col-sm-10">
                                    <input type="password" name="re_password" class="form-control">
                                </div>
                            </div>

                            {{-- Số điện thoại --}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">Lưu lại</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-white">Hủy bỏ</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
