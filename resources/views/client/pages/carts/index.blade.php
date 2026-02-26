@extends('client.layouts')
@section('title', 'Giỏ hàng')

@section('content')
    <style>
        .cart-item:hover {
            transform: translateY(-2px);
            transition: 0.2s ease;
        }

        .cart-checkbox {
            transform: scale(1.2);
        }
    </style>

    <div class="container py-4 py-md-5">
        @if (count($carts) === 0)
            <div class="text-center my-5">
                <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Giỏ hàng của bạn đang trống</h5>
                <a href="{{ route('client.products.index') }}" class="btn btn-success mt-3 px-4">
                    Tiếp tục mua sắm
                </a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="select-all-wrapper">
                        <label class="form-check-label fw-semibold">
                            <input type="checkbox" class="form-check-input" id="select-all">
                            Chọn tất cả
                        </label>
                    </div>
                    @foreach ($carts as $cart)
                        <div class="card border-0 shadow-sm mb-3 cart-item">
                            <div class="card-body">
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        <input type="checkbox" class="form-check-input cart-checkbox"
                                            value="{{ $cart['cart_id'] }}" checked>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        <img src="{{ asset($cart['hinhnen']) }}" class="img-fluid rounded"
                                            style="height:90px; object-fit:cover;">
                                    </div>
                                    <div class="col-9 col-md-4">
                                        <h6 class="fw-semibold mb-1">{{ $cart['tensp'] }}</h6>
                                        @if (!empty($cart['attributes']) && is_array($cart['attributes']))
                                            <div class="cart-attributes mt-3">
                                                <div class="small text-muted">
                                                    @foreach ($cart['attributes'] as $attr)
                                                        <p class="mb-1">
                                                            <strong>{{ $attr['type'] }}:</strong> {{ $attr['value'] }}
                                                        </p>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <style>
                                                .cart-attributes {
                                                    padding: 12px;
                                                    background-color: #f8f9fa;
                                                    border-radius: 6px;
                                                    border-left: 3px solid #007bff;
                                                }

                                                .attribute-group {
                                                    display: flex;
                                                    flex-direction: column;
                                                }

                                                .attribute-label {
                                                    color: #495057;
                                                    font-size: 0.85rem;
                                                    letter-spacing: 0.3px;
                                                }

                                                .color-item {
                                                    transition: all 0.2s ease;
                                                    border: 1px solid #dee2e6;
                                                }

                                                .color-item:hover {
                                                    background-color: #e9ecef;
                                                    transform: translateY(-2px);
                                                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                                                }

                                                .color-name {
                                                    font-size: 0.75rem;
                                                    color: #495057;
                                                }

                                                .size-badge {
                                                    font-weight: 600;
                                                    padding: 6px 10px !important;
                                                    background-color: #f1f3f5 !important;
                                                    border-color: #adb5bd !important;
                                                    transition: all 0.2s ease;
                                                }

                                                .size-badge:hover {
                                                    background-color: #dee2e6 !important;
                                                    transform: scale(1.05);
                                                }

                                                .other-badge {
                                                    font-size: 0.8rem;
                                                    padding: 6px 10px !important;
                                                }
                                            </style>
                                        @endif
                                        <span class="text-success fw-bold">
                                            {{ number_format($cart['giaban']) }} ₫
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <form action="{{ route('carts.update-quantity') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cart_id" value="{{ $cart['cart_id'] }}">
                                                <input type="hidden" name="type" value="decrease">
                                                <button class="btn btn-outline-secondary btn-sm">−</button>
                                            </form>

                                            <span class="fw-bold px-2">{{ $cart['cart_quantity'] }}</span>

                                            <form action="{{ route('carts.update-quantity') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cart_id" value="{{ $cart['cart_id'] }}">
                                                <input type="hidden" name="type" value="increase">
                                                <button class="btn btn-outline-secondary btn-sm">+</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <div class="fw-bold text-success">
                                            {{ number_format($cart['subtotal']) }} ₫
                                        </div>
                                        <form action="{{ route('carts.delete') }}" method="POST"
                                            onsubmit="return confirm('Xóa sản phẩm này?')">
                                            @csrf
                                            <input type="hidden" name="cart_id" value="{{ $cart['cart_id'] }}">
                                            <button class="btn btn-link text-danger p-0 small">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm position-sticky" style="top:100px">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Tổng đơn hàng</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính</span>
                                <strong class="total-amount">
                                    {{ number_format($totals['totalAmount']) }} ₫
                                </strong>
                            </div>
                            <hr>
                            <form id="checkout-form" action="{{ route('checkout.index') }}" method="GET">
                                <div id="cart-ids-container"></div>
                                <button type="submit" class="btn btn-success w-100 py-3 fw-bold mb-2">
                                    <i class="fa fa-credit-card me-2"></i>Đặt hàng
                                </button>
                            </form>
                            <a href="{{ route('client.products.index') }}" class="btn btn-outline-secondary w-100">
                                Tiếp tục mua sắm
                            </a>
                            <div class="mt-4 small text-muted">
                                <p class="mb-1"><i class="fa fa-shield-alt me-1"></i> Thanh toán an toàn</p>
                                <p class="mb-1"><i class="fa fa-truck me-1"></i> Giao hàng nhanh</p>
                                <p class="mb-0"><i class="fa fa-undo me-1"></i> Đổi trả 7 ngày</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            const selectAllCheckbox = document.getElementById('select-all');
            const checkoutForm = document.getElementById('checkout-form');
            const cartIdsContainer = document.getElementById('cart-ids-container');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                });
            }
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else {
                        const allChecked = Array.from(checkboxes).every(checkbox => checkbox
                            .checked);
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const selectedIds = [];
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        selectedIds.push(cb.value);
                    }
                });
                if (selectedIds.length === 0) {
                    alert('Vui lòng chọn ít nhất 1 sản phẩm!');
                    return;
                }
                cartIdsContainer.innerHTML = '';
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'cart_ids[]';
                    input.value = id;
                    cartIdsContainer.appendChild(input);
                });
                this.submit();
            });
        });
    </script>
@endsection
