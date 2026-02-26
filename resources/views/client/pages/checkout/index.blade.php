{{-- resources/views/client/pages/checkout/index.blade.php --}}
@extends('client.layouts')
@section('title', 'Trang thanh toán')
@section('content')
    <style>
        .product-item {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            display: flex;
            gap: 16px;
            transition: all 0.3s ease;
        }

        .product-item:hover {
            border-color: #4f46e5;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
        }

        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .product-attributes {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }

        .attr-badge {
            background-color: #f3f4f6;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: #6b7280;
        }

        .attr-label {
            font-weight: 600;
        }

        .product-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-info {
            font-size: 14px;
            color: #6b7280;
        }

        .total-price {
            font-weight: 700;
            color: #4f46e5;
            font-size: 16px;
        }
    </style>

    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold mb-8 text-gray-800">Thanh Toán</h1>

        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
            @csrf
            @foreach ($cartIds as $cartId)
                <input type="hidden" name="cart_ids[]" value="{{ $cartId }}">
            @endforeach

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">
                            Thông Tin Giao Hàng
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Họ và tên *</label>

                                <input type="text" name="name" value="{{ old('name', Auth::user()->name ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600"
                                    placeholder="Nhập họ và tên" required>
                                @error('name')
                                    <small class="text-red-600 block mb-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Số điện thoại *</label>
                                <input type="tel" name="sdtnhan" value="{{ old('sdtnhan', Auth::user()->phone ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600"
                                    placeholder="0901234567" required>
                                @error('sdtnhan')
                                    <small class="text-red-600 block mb-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">Email *</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600"
                                placeholder="email@example.com">
                            @error('email')
                                <small class="text-red-600 block mb-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2 font-medium">Địa chỉ *</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600"
                                placeholder="Số nhà, tên đường">
                            @error('address')
                                <small class="text-red-600 block mb-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Tỉnh/Thành phố *</label>
                                <select id="province" name="province_code"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600">
                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->province_code }}"
                                            {{ old('province_code') == $province->province_code ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_code')
                                    <small class="text-red-600 block mb-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2 font-medium">Phường/Xã *</label>
                                <select id="ward" name="ward_code"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600"
                                    required disabled>
                                    <option value="">-- Chọn Phường/Xã --</option>
                                </select>
                                @error('ward_code')
                                    <small class="text-red-600 block mb-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">
                            Ghi Chú Đơn Hàng
                        </h3>
                        <textarea name="note"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-600 resize-none"
                            placeholder="Nhập ghi chú cho đơn hàng (ví dụ: giao hàng vào giờ cụ thể, yêu cầu đặc biệt...)" rows="4">{{ old('note') }}</textarea>
                        <small class="text-gray-500 mt-2 block">Tối đa 500 ký tự</small>
                        @error('note')
                            <small class="text-red-600 block mb-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">
                            Phương Thức Thanh Toán
                        </h3>
                        <div class="space-y-3">
                            <label
                                class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-600 transition payment-method-label">
                                <input type="radio" name="phuongthuc_thanhtoan" value="cod"
                                    class="mr-3 w-5 h-5 text-indigo-600"
                                    {{ old('phuongthuc_thanhtoan') == 'cod' ? 'checked' : 'checked' }} required>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">Thanh toán khi nhận hàng (COD)</div>
                                    <div class="text-sm text-gray-600">Thanh toán bằng tiền mặt khi nhận hàng</div>
                                </div>
                            </label>
                        </div>
                        @error('phuongthuc_thanhtoan')
                            <small class="text-red-600 block mb-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">
                            Kiểm Tra Lại Đơn Hàng
                        </h3>
                        <div class="space-y-4">
                            @forelse ($checkout['items'] as $item)
                                <div class="product-item">
                                    <img src="{{ asset($item['hinhnen']) }}" alt="{{ $item['ten'] }}"
                                        class="product-image">
                                    <div class="product-info">
                                        <div class="product-name">{{ $item['ten'] }}</div>
                                        @if (!empty($item['attributes']))
                                            <div class="product-attributes">
                                                @foreach ($item['attributes'] as $attr)
                                                    <span class="attr-badge">
                                                        <span class="attr-label">{{ $attr['type'] }}:</span>
                                                        {{ $attr['value'] }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="product-price">
                                            <div class="price-info">
                                                Giá gốc: {{ number_format($item['gia_goc']) }}₫
                                                <strong>{{ $item['so_luong'] }}</strong>
                                            </div>
                                            <div class="total-price">
                                                Tổng: {{ number_format($item['thanh_tien']) }}₫
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fa fa-shopping-cart text-4xl mb-3"></i>
                                    <p>Giỏ hàng trống</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">
                            <i class="fa fa-calculator me-2"></i>Tóm Tắt Đơn Hàng
                        </h3>
                        <div class="space-y-3 border-b pb-4 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tổng số lượng:</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $checkout['totalQuantity'] }} sản phẩm
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600"> Giá gốc:</span>
                                <span class="font-semibold text-gray-800">
                                    {{ number_format($item['gia_goc']) }}₫
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Giảm giá:</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $item['discount'] }}%
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Giá sau khi giảm:</span>
                                <span class="font-semibold text-gray-800">
                                    {{ number_format($checkout['finalPrice']) }}₫
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Phí vận chuyển:</span>
                                <span class="font-semibold text-gray-800">Miễn phí</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-6 pb-4 border-b">
                            <span class="font-bold text-lg text-gray-800">Tổng cộng:</span>
                            <span class="font-bold text-indigo-600 text-2xl">
                                {{ number_format($checkout['totalPrice']) }}₫
                            </span>
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 font-semibold transition mb-3 flex items-center justify-center gap-2">
                            <i class="fa fa-check-circle"></i>
                            Đặt Hàng
                        </button>
                        <a href="{{ route('carts.index') }}"
                            class="block w-full border-2 border-gray-300 text-center py-3 rounded-lg hover:bg-gray-50 font-semibold transition text-gray-800">
                            <i class="fa fa-arrow-left me-2"></i>
                            Quay Lại Giỏ Hàng
                        </a>
                        <div class="mt-6 pt-6 border-t space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <i class="fa fa-shield text-indigo-600 text-lg"></i>
                                <span>Thanh toán an toàn 100%</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <i class="fa fa-lock text-indigo-600 text-lg"></i>
                                <span>Bảo mật thông tin khách hàng</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <i class="fa fa-phone text-indigo-600 text-lg"></i>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#province').change(function() {
                    let provinceCode = $(this).val();
                    $('#ward').html('<option value="">-- Chọn Phường/Xã --</option>').prop('disabled', true);

                    if (provinceCode) {
                        $('#ward').html('<option value="">Đang tải...</option>');
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
                            },
                            error: function() {
                                alert('Lỗi khi tải phường/xã');
                                $('#ward').prop('disabled', true);
                            }
                        });
                    }
                });
                $('input[name="phuongthuc_thanhtoan"]').change(function() {
                    $('.payment-method-label').removeClass('border-indigo-600 bg-indigo-50');
                    $(this).closest('.payment-method-label').addClass('border-indigo-600 bg-indigo-50');
                });
                $('#checkout-form').submit(function(e) {
                    if (!$('input[name="phuongthuc_thanhtoan"]:checked').val()) {
                        e.preventDefault();
                        alert('Vui lòng chọn phương thức thanh toán');
                        return false;
                    }
                });
                $('textarea[name="note"]').on('input', function() {
                    if ($(this).val().length > 500) {
                        $(this).val($(this).val().substring(0, 500));
                    }
                });
            });
        </script>
    @endpush
@endsection
