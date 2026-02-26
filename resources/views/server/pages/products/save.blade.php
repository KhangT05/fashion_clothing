@extends('server.layout')
@section('title', 'Thêm Sản Phẩm')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ 'Thêm Sản Phẩm' }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                            class="confirm-submit">
                            @csrf
                            @if (isset($product))
                                @method('PUT')
                            @endif

                            <!-- Thông tin cơ bản -->
                            <div class="form-group">
                                <label for="tensp">Tên Sản Phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tensp') is-invalid @enderror"
                                    id="tensp" name="tensp" value="{{ old('tensp', $products->tensp ?? '') }}"
                                    placeholder="Nhập tên sản phẩm" required>
                                @error('tensp')
                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sku">SKU</label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                            id="sku" name="sku" value="{{ old('sku', $sku ?? '') }}"
                                            min="0" placeholder="Nhập sku">
                                        @error('sku')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="giaban">Giá Bán (VNĐ) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('giaban') is-invalid @enderror"
                                            id="giaban" name="giaban"
                                            value="{{ old('giaban', $products->giaban ?? '') }}" placeholder="Nhập giá bán"
                                            required>
                                        @error('giaban')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="discount">Giảm Giá (%)</label>
                                        <input type="text" class="form-control @error('discount') is-invalid @enderror"
                                            id="discount" name="discount"
                                            value="{{ old('discount', $products->discount ?? '') }}" min="0"
                                            placeholder="Nhập giảm giá">
                                        @error('discount')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="soluong">Số lượng</label>
                                        <input type="text" class="form-control @error('soluong') is-invalid @enderror"
                                            id="soluong" name="soluong"
                                            value="{{ old('soluong', $products->soluong ?? '') }}" min="0"
                                            placeholder="Nhập số lượng">
                                        @error('soluong')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Danh mục & Thương hiệu -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Danh Mục <span class="text-danger">*</span></label>
                                        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                            @foreach ($categories as $category)
                                                <div class="form-check">
                                                    <input class="form-check-input category-checkbox" type="checkbox"
                                                        name="categories[]" value="{{ $category->id }}"
                                                        id="cat_{{ $category->id }}"
                                                        {{ in_array($category->id, old('categories', isset($products) ? $products->categories->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cat_{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('category_id')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="thuonghieu_id">Thương Hiệu <span class="text-danger">*</span></label>
                                        <select class="form-control @error('thuonghieu_id') is-invalid @enderror"
                                            id="thuonghieu_id" name="thuonghieu_id" required>
                                            <option value="">-- Chọn thương hiệu --</option>
                                            @foreach ($thuonghieu as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('thuonghieu_id', $products->thuonghieu_id ?? '') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->tenth }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('thuonghieu_id')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Hình ảnh sản phẩm -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fa fa-images"></i> Hình Ảnh Sản Phẩm</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Hình nền chính -->
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">
                                            Hình Nền Chính <span class="text-danger">*</span>
                                        </label>
                                        <div class="image-upload-wrapper">
                                            <div class="image-target-cus" style="cursor: pointer;">
                                                @php
                                                    $hinhnenValue = old('hinhnen', $product->hinhnen ?? '');
                                                @endphp

                                                @if ($hinhnenValue)
                                                    <img src="{{ $hinhnenValue }}" alt="Hình nền"
                                                        class="image-preview img-thumbnail"
                                                        style="max-width: 300px; max-height: 300px; object-fit: cover; display: block; margin: 0 auto;">
                                                @else
                                                    <img src="{{ asset('backend/img/not-found.png') }}" alt="Hình nền"
                                                        class="image-preview img-thumbnail"
                                                        style="max-width: 300px; max-height: 300px; object-fit: cover; display: block; margin: 0 auto;">
                                                @endif
                                            </div>
                                            <input type="hidden" class="image-target" value="{{ $hinhnenValue }}"
                                                name="hinhnen" id="hinhnen" />

                                            <div class="text-center mt-3">
                                                <small class="text-muted d-block">
                                                    <i class="fa fa-info-circle"></i> Click vào ảnh để thay đổi hình nền
                                                    chính
                                                </small>
                                                @if ($hinhnenValue)
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger mt-2 delete-image">
                                                        <i class="fa fa-trash"></i> Xóa hình nền
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        @error('hinhnen')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <hr>

                                    <!-- Album ảnh -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            Album Ảnh Sản Phẩm
                                            <small class="text-muted">(Tối đa 10 ảnh)</small>
                                        </label>
                                        <div class="album-upload-wrapper">
                                            <button type="button" class="upload-picture btn btn-primary btn-block mb-3"
                                                data-name="album">
                                                <i class="fa fa-upload"></i> Thêm Ảnh Vào Album
                                            </button>

                                            <div id="sortable" class="row upload-list">
                                                @php
                                                    $albumImages = [];

                                                    // Lấy album từ old() nếu có
                                                    if (old('album')) {
                                                        $albumImages = old('album');
                                                    }
                                                    // Hoặc lấy từ product variants khi edit
                                                    elseif (
                                                        isset($product) &&
                                                        $product->sanpham_variants->count() > 0
                                                    ) {
                                                        foreach ($product->sanpham_variants as $variant) {
                                                            if ($variant->album) {
                                                                $variantAlbum = is_string($variant->album)
                                                                    ? json_decode($variant->album, true)
                                                                    : $variant->album;

                                                                if (is_array($variantAlbum)) {
                                                                    $albumImages = array_merge(
                                                                        $albumImages,
                                                                        $variantAlbum,
                                                                    );
                                                                }
                                                            }
                                                        }
                                                        $albumImages = array_unique($albumImages);
                                                    }
                                                @endphp

                                                @forelse ($albumImages as $index => $image)
                                                    <div class="col-xl-2 col-md-3 col-sm-4 col-6 mb-3">
                                                        <div class="album-item">
                                                            <div class="album-image-wrapper">
                                                                <a href="{{ $image }}" data-fancybox="gallery">
                                                                    <img src="{{ $image }}"
                                                                        alt="Album {{ $index + 1 }}"
                                                                        class="img-thumbnail w-100">
                                                                </a>
                                                                <input type="hidden" name="album[]"
                                                                    value="{{ $image }}">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm delete-album-image"
                                                                    title="Xóa ảnh">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                                <span class="album-index">{{ $index + 1 }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-12">
                                                        <div class="alert alert-info text-center">
                                                            <i class="fa fa-info-circle"></i>
                                                            Chưa có ảnh trong album. Click nút "Thêm Ảnh Vào Album" để thêm
                                                            ảnh.
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                        @error('album')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Mô tả -->
                            <div class="form-group">
                                <label for="mota">Mô Tả Sản Phẩm</label>
                                <textarea class="form-control ck-editor" id="mota" name="mota" data-height="400">{{ old('mota') }}</textarea>
                                @error('mota')
                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Biến thể -->
                            @include('server.pages.products.components.varriants')

                            <!-- Nút submit -->
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg confirm-submit">
                                    <i class="fa fa-save"></i> {{ 'Thêm Sản Phẩm' }}
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg confirm-cancel">
                                    <i class="fa fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mt-3">
                @foreach ($errors->get('sanpham_variants.*.*') as $messages)
                    @foreach ($messages as $message)
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .album-item {
            position: relative;
            height: 100%;
        }

        .album-image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .album-image-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .album-image-wrapper img {
            height: 150px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .album-image-wrapper:hover img {
            transform: scale(1.1);
        }

        .delete-album-image {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .album-image-wrapper:hover .delete-album-image {
            opacity: 1;
        }

        .album-index {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }

        .image-target-cus {
            border: 2px dashed #ddd;
            padding: 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .image-target-cus:hover {
            border-color: #007bff;
            background: #f8f9fa;
        }

        #sortable {
            min-height: 100px;
        }

        .upload-list:empty::after {
            content: "Chưa có ảnh trong album";
            display: block;
            text-align: center;
            color: #999;
            padding: 40px;
        }
    </style>

    <script>
        // Xử lý xóa ảnh trong album
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-album-image') ||
                e.target.closest('.delete-album-image')) {
                const button = e.target.closest('.delete-album-image');
                const albumItem = button.closest('.col-xl-2, .col-md-3, .col-sm-4, .col-6');

                if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
                    albumItem.remove();
                    updateAlbumIndexes();
                }
            }
        });
        // Cập nhật số thứ tự ảnh
        function updateAlbumIndexes() {
            document.querySelectorAll('.album-index').forEach((el, index) => {
                el.textContent = index + 1;
            });
        }
        // Khởi tạo sortable để có thể kéo thả sắp xếp ảnh (nếu có jQuery UI)
        if (typeof $.fn.sortable !== 'undefined') {
            $("#sortable").sortable({
                update: function(event, ui) {
                    updateAlbumIndexes();
                }
            });
        }
    </script>
@endsection
