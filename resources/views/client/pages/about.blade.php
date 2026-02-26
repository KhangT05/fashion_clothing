@extends('client.layouts')
@section('title', 'Trang giới thiệu')
@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('layouts') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Về Công Ty Chúng Tôi</h2>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h4>1. Thông tin chung</h4>
                        <p><strong>Tên công ty:</strong> Cửa hàng Laptop DoAnMonHoc</p>
                        <p><strong>Địa chỉ:</strong> 123 Đường ABC, Quận XYZ, TP.HCM</p>
                        <p><strong>Lĩnh vực kinh doanh:</strong> Chuyên cung cấp các dòng Laptop Gaming, Văn phòng chính
                            hãng...</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h4>2. Chính sách cửa hàng</h4>
                        <ul>
                            <li>Bảo hành chính hãng 12-24 tháng.</li>
                            <li>Đổi trả trong vòng 30 ngày nếu lỗi nhà sản xuất.</li>
                            <li>Hỗ trợ trả góp 0% lãi suất.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
