@extends('server.layout')
@section('title', 'Thêm Slide')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ 'Thêm Slide' }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('slides.store') }}" method="POST" enctype="multipart/form-data"
                            class="confirm-submit">
                            @csrf
                            <div class="form-group">
                                <label for="tieude">Tên Slide <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tieude') is-invalid @enderror"
                                    id="tieude" name="tieude" value="{{ old('tieude', $slide->tieude ?? '') }}"
                                    placeholder="Nhập tên slide" required>
                                @error('tieude')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="linklienket">Link Liên Kết</label>
                                <input type="url" class="form-control @error('linklienket') is-invalid @enderror"
                                    id="linklienket" name="linklienket"
                                    value="{{ old('linklienket', $slide->linklienket ?? '') }}"
                                    placeholder="https://example.com">
                                @error('linklienket')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                {{-- <small class="text-muted">
                                    <i class="fa fa-info-circle"></i> Nhập URL đầy đủ (bao gồm http:// hoặc https://)
                                </small> --}}
                            </div>
                            <div class="form-group mb-4">
                                <label>Hình Nền Slide</label>
                                <div class="image-upload-wrapper">
                                    <div class="image-target-cus" style="cursor: pointer;">
                                        @php
                                            $hinhthunhoValue = old('hinhthunho', $slide->hinhthunho ?? '');
                                        @endphp

                                        @if ($hinhthunhoValue)
                                            <img src="{{ $hinhthunhoValue }}" alt="Hình nền"
                                                class="image-preview img-thumbnail"
                                                style="max-width: 300px; max-height: 300px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('backend/img/not-found.png') }}" alt="Hình nền"
                                                class="image-preview img-thumbnail"
                                                style="max-width: 300px; max-height: 300px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <input type="hidden" class="image-target" value="{{ $hinhthunhoValue }}"
                                        name="hinhthunho" id="hinhthunho" />

                                    <small class="text-muted d-block mt-2">
                                        <i class="fa fa-info-circle"></i> Click vào ảnh để thay đổi hình nền
                                    </small>

                                    @if ($hinhthunhoValue)
                                        <button type="button" class="btn btn-sm btn-danger mt-2 delete-image">
                                            <i class="fa fa-trash"></i> Xóa hình nền
                                        </button>
                                    @endif
                                </div>
                                @error('hinhthunho')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="stt">Số Thứ Tự</label>
                                <input type="number" class="form-control @error('stt') is-invalid @enderror" id="stt"
                                    name="stt" value="{{ old('stt', $slide->stt ?? 0) }}" placeholder="Nhập số thứ tự"
                                    min="0">
                                @error('stt')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">
                                    <i class="fa fa-info-circle"></i> Số thứ tự hiển thị (0 = hiển thị đầu tiên)
                                </small>
                            </div>
                            <div class="form-group">
                                <label>Mô tả slide</label>
                                <textarea class="" value="{{ old('mota', $slide->mota ?? '') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="trangthai">Trạng Thái <span class="text-danger">*</span></label>
                                <select class="form-control @error('trangthai') is-invalid @enderror" id="trangthai"
                                    name="trangthai" required>
                                    <option value="1"
                                        {{ old('trangthai', $slide->trangthai ?? '1') == '1' ? 'selected' : '' }}>
                                        Hiển thị
                                    </option>
                                    <option value="0"
                                        {{ old('trangthai', $slide->trangthai ?? '') == '0' ? 'selected' : '' }}>
                                        Ẩn
                                    </option>
                                </select>
                                @error('trangthai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary confirm-submit">
                                    <i class="fa fa-save"></i>
                                    {{ 'Thêm Slide' }}
                                </button>
                                <a href="{{ route('slides.index') }}" class="btn btn-secondary confirm-cancel">
                                    <i class="fa fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
