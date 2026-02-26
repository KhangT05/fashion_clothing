@extends('client.layouts')

@section('title', $title)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('layouts') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
                <div class="page-header mb-4">
                    <h1 class="display-5 fw-bold text-primary">{{ $title }}</h1>
                    <hr class="my-3">
                </div>
                <div class="page-content bg-white p-4 rounded shadow-sm">
                    @if ($content)
                        <div class="content-text">
                            {!! nl2br(e($content)) !!}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Nội dung đang được cập nhật.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-content {
            line-height: 1.8;
            font-size: 1rem;
        }

        .content-text {
            color: #333;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        @media (min-width: 768px) {
            .page-header h1 {
                font-size: 2.5rem;
            }
        }
    </style>
@endsection
