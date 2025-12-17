@extends('layout.app')

@php $pagename = "Menu" @endphp

@section('title')

    Menu List

@endsection

@section('content')

    {{-- Full Page --}}
    <div class="grid grid-cols-7">
        
        {{-- Content --}}
        <div class="col-span-7 lg:col-span-5">

            <livewire:customer-menu />

        </div>

        {{-- Hoá đơn thanh toán Section --}}
        <div class="col-span-7 lg:col-span-2 w-full relative">

            <livewire:my-orders />
        
        </div>

    </div>

@endsection