@extends('layout.app')

@php $pagename = "Success" @endphp

@section('title')
    Đặt hàng thành công
@endsection

@section('header-title')
    Đặt hàng thành công
@endsection

@section('content')
<div class="container-fluid px-3 py-4" style="min-height: calc(100vh - 80px); padding-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <span class="material-symbols-outlined text-success" style="font-size: 80px;">check_circle</span>
                    </div>
                    <h2 class="fw-bold mb-3">Đặt hàng thành công!</h2>
                    <p class="text-secondary mb-4">
                        Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đang được xử lý.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('home.customer') }}" class="btn btn-warning">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">home</span>
                            Về trang chủ
                        </a>
                        <a href="{{ route('menu.customer') }}" class="btn btn-outline-primary">
                            <span class="material-symbols-outlined" style="vertical-align: middle;">restaurant_menu</span>
                            Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

