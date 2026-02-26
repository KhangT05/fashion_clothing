@extends('server.layout')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Thêm danh mục</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content" style="border-left: 4px solid #1ab394;">
                        <h4 class="m-t-none m-b-sm">
                            <i class="fa fa-info-circle"></i> Lưu ý
                        </h4>
                        <p class="text-muted m-b-none">
                            Các trường có dấu <span class="text-danger">(*)</span> là bắt buộc nhập.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thông tin danh mục</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" class="form-horizontal"
                            action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}">
                            @csrf
                            @isset($category)
                                @method('PUT')
                            @endisset
                            <div class="form-group">

                                @error('name')
                                    <div class="alert alert-danger">*{{ $message }}</div>
                                @enderror

                                <label class="col-sm-3 control-label">Tên danh mục <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Nhập tên danh mục" value="{{ old('name', $category->name ?? '') }}"
                                        required>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Mô tả</label>
                                <div class="col-sm-9">
                                    <textarea name="description" rows="4" class="form-control" placeholder="Nhập mô tả cho danh mục">{{ old('description', $category->description ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Trạng thái</label>
                                <div class="col-sm-9">
                                    <select name="publish" class="form-control m-b">
                                        <option value="1"
                                            {{ old('publish', $category->publish ?? 1) == 1 ? 'selected' : '' }}>Xuất bản
                                        </option>
                                        <option value="0"
                                            {{ old('publish', $category->publish ?? 1) == 0 ? 'selected' : '' }}>Không xuất
                                            bản
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-3">
                                    <a href="{{ route('categories.index') }}"><button class="btn btn-white"
                                            type="button">Hủy</button></a>
                                    <button class="btn btn-primary" type="submit">Lưu danh mục</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
