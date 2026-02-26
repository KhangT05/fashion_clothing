@extends('client.layouts')
@section('title', 'Trang người dùng')
@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- Menu bên trái --}}
            <div class="col-md-3">
                @include('client.pages.profile.layout_menu')
            </div>

            {{-- Nội dung bên phải --}}
            <div class="col-md-9">
                <h3 class="mb-4">Thông tin cá nhân</h3>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('client.profile.update') }}" method="POST">
                            @csrf
                            {{-- Họ tên --}}
                            <div class="mb-3">
                                <label class="form-label">Họ tên</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    required>
                            </div>

                            {{-- Email (Không cho sửa) --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->email }}" disabled>
                            </div>

                            {{-- Số điện thoại --}}
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">Tỉnh/Thành phố *</label>
                                    @error('province_code')
                                        <small class="text-red-600">{{ $message }}</small>
                                    @enderror
                                    <select id="province" name="province_code"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600"
                                        required>
                                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province_code }}"
                                                {{ old('province_code') == $province->province_code ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium">Phường/Xã *</label>
                                    @error('ward_code')
                                        <small class="text-red-600">{{ $message }}</small>
                                    @enderror
                                    <select id="ward" name="ward_code"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600"
                                        required disabled>
                                        <option value="">-- Chọn Phường/Xã --</option>
                                    </select>
                                </div>
                            </div>
                    </div>


                    {{-- Ngày sinh --}}
                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="birthday" class="form-control" value="{{ $user->birthday }}">
                    </div>

                    {{-- Giới tính --}}
                    <div class="mb-3">
                        <label class="form-label">Giới tính</label>
                        <select name="gender" class="form-control">
                            <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>Nam</option>
                            <option value="2" {{ $user->gender == 2 ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Cập nhật thông tin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Khi chọn Tỉnh/Thành phố
            $('#province').change(function() {
                let provinceCode = $(this).val();

                // Reset ward dropdown
                $('#ward').html('<option value="">-- Chọn Phường/Xã --</option>').prop('disabled', true);

                if (provinceCode) {
                    // Hiển thị loading
                    $('#ward').html('<option value="">Đang tải...</option>');
                    // Gọi API lấy danh sách phường/xã - SỬA LẠI URL
                    $.ajax({
                        url: "{{ url('/get-wards') }}/" + provinceCode,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#ward').html('<option value="">-- Chọn Phường/Xã --</option>');

                            if (data.length > 0) {
                                $.each(data, function(index, ward) {
                                    $('#ward').append(
                                        `<option value="${ward.ward_code}">${ward.name}</option>`
                                    );
                                });
                                $('#ward').prop('disabled', false);
                            }
                        }
                    });

                }
            });
            // Highlight payment method khi chọn
            $('input[name="payment_method"]').change(function() {
                $('input[name="payment_method"]').parent().parent().removeClass(
                    'border-indigo-600 bg-indigo-50');
                $(this).parent().parent().addClass('border-indigo-600 bg-indigo-50');
            });
        });
    </script>
@endpush
