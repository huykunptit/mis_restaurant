@extends('layout.app')

@php $pagename = "Home" @endphp

@section('title')

    {{ auth()->user()->first_name . " " . auth()->user()->last_name }}'s Homepage

@endsection

@section('content')

    {{-- Full Page --}}
    <div class="grid grid-cols-7">
        
        {{-- Content --}}
        <div class="col-span-7 lg:col-span-5">

            <style>

                .slick-dots{
                   bottom: 10px;
                }
                
            </style>

            {{-- Slider Container --}}
            <div class="relative mx-10 mt-10 -mb-10">

                {{-- Slider --}}
                <div class="customerHome w-full rounded-2xl overflow-hidden">

                    {{-- <img src="{{ asset('img/sliders/slide2.png') }}"> --}}

                    <img src="{{ asset('img/sliders/slide5.png') }}">

                    <img src="{{ asset('img/sliders/slide7.png') }}">

                    <img src="{{ asset('img/sliders/slide6.png') }}">

                </div>
                
            </div>

            <livewire:customer-home-menu />

        </div>

        {{-- Hoá đơn thanh toán Section --}}
        <div class="col-span-7 lg:col-span-2 w-full relative">

            <livewire:my-orders />
        
        </div>

    </div>

@endsection