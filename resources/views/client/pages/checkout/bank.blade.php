@extends('client.layouts')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <h4 class="mb-3 text-primary">
                            <i class="bi bi-bank"></i> Thanh toán chuyển khoản
                        </h4>

                        <ul class="list-group mb-4">
                            <li class="list-group-item">
                                <strong>Ngân hàng:</strong> Vietcombank
                            </li>
                            <li class="list-group-item">
                                <strong>Số tài khoản:</strong> 0123 456 789
                            </li>
                            <li class="list-group-item">
                                <strong>Chủ tài khoản:</strong> DO AN MON HOC
                            </li>
                            <li class="list-group-item">
                                <strong>Số tiền:</strong>
                                <span class="text-danger fw-bold">
                                    {{ number_format($order->chiTiet->sum('thanhtien')) }} VNĐ
                                </span>
                            </li>
                            <li class="list-group-item">
                                <strong>Nội dung chuyển khoản:</strong>
                                <span class="text-primary">
                                    {{ $order->name }}
                                </span>
                            </li>
                        </ul>

                        <div class="text-center">
                            <a href="{{ route('checkout.thanhcong') }}" class="btn btn-success px-4">
                                Tôi đã chuyển khoản
                            </a>

                            <a href="{{ route('carts.index') }}" class="btn btn-outline-secondary ms-2">
                                Quay lại giỏ hàng
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
