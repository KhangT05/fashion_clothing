@extends('server.layout')
@section('title', 'Thêm Vai Trò')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ 'Thêm Vai Trò' }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data"
                            class="confirm-submit">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên Vai Trò <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $roles->name ?? '') }}"
                                    placeholder="Nhập tên Vai Trò" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mô tả</label>
                                <div class="col-sm-9">
                                    <textarea name="description" rows="4" class="form-control" placeholder="Nhập mô tả cho danh mục">{{ old('description', $category->description ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="publish" name="publish"
                                    value="{{ old('publish', $roles->publish ?? '') }}"></label>
                                <select name="publish" id="publish" class="form-control">
                                    <option>--- Chọn trạng thái---</option>
                                    <option value="1"
                                        {{ old('publish', $roles->publish ?? 1) == 1 ? 'selected' : '' }}>Xuất bản
                                    </option>
                                    <option value="2"
                                        {{ old('publish', $roles->publish ?? 2) == 2 ? 'selected' : '' }}>Không xuất
                                        bản
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary confirm-submit">
                                    <i class="fa fa-save"></i>
                                    {{ 'Thêm Vai Trò' }}
                                </button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary confirm-cancel">
                                    <i class="fa fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        .card-header {
            background: linear-gradient(135deg, #363f5a 0%, #000000 100%);
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 15px 20px;
        }

        .card-title {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .text-danger {
            color: #e74c3c;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #00060c;
            border: none;
        }

        .invalid-feedback {
            display: block;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
@endsection
