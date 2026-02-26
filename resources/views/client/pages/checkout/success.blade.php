@extends('client.layouts')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <div class="text-success fs-1 mb-2">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h3 class="text-success">Đặt hàng thành công!</h3>
                            <span>Đang chờ thanh toán</span>
                            <p class="text-muted">
                                Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi.
                            </p>
                            <p class="text-muted">
                                Cùng chúng tôi bảo vệ quyền lợi của bạn.Thường xuyên kiểm tra tin nhắn từ Người bán ở
                                ShopChat /Chỉ nhận & thanh toán khi đơn mua ở trạng thái "Đang giao hàng"
                            </p>
                        </div>
                        <hr>
                        <div class="text-center mt-4">
                            <a href="{{ route('layouts') }}" class="btn btn-primary px-4">
                                Về trang chủ
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
