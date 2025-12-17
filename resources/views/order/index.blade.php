@extends('layout.app')

@php $pagename = "Home" @endphp

@section('title')

    @isset($pagename) {{ $pagename }} @endisset

@endsection

@section('content')

    @php
        $i = 0;
    @endphp

    <div class="p-6 lg:p-10 bg-gray-50 min-h-screen">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Quản lý đơn hàng</h1>
            <p class="text-gray-600">Xem và quản lý tất cả đơn hàng trong hệ thống</p>
            
            {{-- Bread Crumb --}}
            <div class="flex items-center text-sm text-gray-600 mt-4">
                <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-medium hover:text-green-600 transition-colors">Trang chủ</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Đơn hàng</span>
            </div>
        </div>
        
        {{-- Filter Buttons --}}
        <div class="mb-8 flex flex-wrap gap-3">
            <button id="allButton" class="flex items-center justify-center space-x-2 bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Tất cả</span>
            </button>

            <button id="uncompletedButton" class="flex items-center justify-center space-x-2 bg-white text-green-600 border-2 border-green-600 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:bg-green-50 transition-all duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
                <span>Chưa giao món</span>
            </button>

            <button id="completedButton" class="flex items-center justify-center space-x-2 bg-white text-green-600 border-2 border-green-600 font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg hover:bg-green-50 transition-all duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Đã giao món và chưa thanh toán</span>
            </button>
        </div>
        
        
        <div class="w-full my-10">
            
            {{-- All Tables --}}
            <div id="allContent">

                @isset($filledTables)

                    {{-- All Content Grids --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">

                        @foreach ($filledTables as $filledTable)

                            {{-- One Table Card --}}
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">

                                <form action="{{ route('order.show', $filledTable->id) }}" method="GET">
                                    @csrf

                                    {{-- Card Header --}}
                                    <div class="relative bg-gradient-to-br from-green-500 to-green-700 p-6 text-white">
                                        {{-- Status Badges --}}
                                        <div class="absolute top-3 right-3 flex flex-col gap-2">
                                            @if ($filledTable->order->every('completion_status', 'yes'))
                                                <span class="px-3 py-1 bg-white bg-opacity-90 text-green-700 text-xs font-semibold rounded-full shadow-lg">Đã giao</span>
                                            @else
                                                <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full shadow-lg">Chưa giao</span>
                                            @endif
                                            
                                            @if ($filledTable->order->every('payment_status', 'yes'))
                                                <span class="px-3 py-1 bg-white bg-opacity-90 text-green-700 text-xs font-semibold rounded-full shadow-lg">Đã thanh toán</span>
                                            @else
                                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">Chưa thanh toán</span>
                                            @endif
                                        </div>
                        
                                        {{-- Customer Name --}}
                                        <div class="mt-8">
                                            <p class="text-sm text-green-100 mb-1">Khách hàng</p>
                                            <p class="text-2xl font-bold">{{ $filledTable->first_name . " " . $filledTable->last_name }}</p>
                                        </div>
                                    </div>

                                    {{-- Card Body --}}
                                    <div class="p-4">
                                        @php $total = 0 @endphp
                                        @foreach ( $filledTable->order as $order)
                                            @if ($order->payment_status == "no")
                                                <div class="hidden">
                                                    {{ $total +=  $order->menuOption->cost * $order->quantity}}
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-gray-600 text-sm">Tổng tiền:</span>
                                            @if ($filledTable->order->every('payment_status', 'yes'))
                                                <span class="text-lg font-semibold text-green-600">Đã thanh toán</span>
                                            @else
                                                <span class="text-2xl font-bold text-gray-800">{{ number_format($total,0)}} VNĐ</span>
                                            @endif
                                        </div>
                                        
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                            Xem chi tiết
                                        </button>
                                    </div>

                                </form>
                    
                                {{-- Action Buttons --}}
                                <div class="px-4 pb-4 flex gap-2">
                                    @if ($filledTable->order->every('completion_status', 'yes'))
                                        <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2 text-center rounded-lg cursor-not-allowed font-medium">Đã giao</button>
                                    @else
                                        <form action="{{ route('order.complete', $filledTable->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('put')
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">Hoàn thành</button>
                                        </form>
                                    @endif

                                    @if ($filledTable->order->every('payment_status', 'yes'))
                                        <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2 text-center rounded-lg cursor-not-allowed font-medium">Đã thanh toán</button>
                                    @else
                                        <form action="{{ route('order.paid', $filledTable->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('put')
                                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">Thanh toán</button>
                                        </form>
                                    @endif
                                </div>
                    
                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-2xl font-bold text-gray-800 mb-2">Không có đơn hàng nào</p>
                        <p class="text-gray-600">Hiện tại chưa có đơn hàng nào trong hệ thống.</p>
                    </div>
                    
                @endisset

            </div>
            
            {{-- Table with Uncompleted Orders --}}
            <div id="uncompletedContent" class="hidden">
                
                {{-- Uncompleted Order Grids --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">

                    @foreach ($filledTables as $filledTable)

                        {{-- Table with Orders --}}
                        @if(!$filledTable->order->isEmpty())

                            {{-- Uncompleted Orders --}}
                            @if (!$filledTable->order->every('completion_status', 'yes'))
                                
                                @php
                                    $i = 1;
                                @endphp
                                
                                @include('order.partials.table-card', ['filledTable' => $filledTable])
                                
                            @endif
                            
                        @endif
                        
                    @endforeach
                   
                </div>

                @if ($i == 0)
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-2xl font-bold text-gray-800 mb-2">Tất cả đơn đã được giao</p>
                        <p class="text-gray-600">Tuyệt vời! Tất cả đơn hàng đã được xử lý.</p>
                    </div>
                @endif

                @php
                    $i = 0;
                @endphp

            </div>

            {{-- Table with Completed Orders --}}
            <div id="completedContent" class="hidden">
                
                {{-- Completed Order Grids --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                    @foreach ($filledTables as $filledTable )

                        {{-- Table with Orders --}}
                        @if(!$filledTable->order->isEmpty())
                            
                            {{-- Completed Orders --}}
                            @if ($filledTable->order->every('completion_status', 'yes'))

                                {{-- Unpaid Orders --}}
                                @if (!$filledTable->order->every('payment_status', 'yes'))

                                    @php
                                        $i = 1;
                                    @endphp

                                    @include('order.partials.table-card', ['filledTable' => $filledTable])

                                @endif

                            @endif
                            
                        @endif
                    
                    @endforeach

                </div>

                @if ($i == 0)
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-2xl font-bold text-gray-800 mb-2">Không có đơn nào đã giao và chưa thanh toán</p>
                        <p class="text-gray-600">Hãy đợi khách hàng hoàn thành bữa ăn.</p>
                    </div>
                @endif

                @php
                    $i = 0;
                @endphp

            </div>
            
        </div>

    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/order_index.js') }}" ></script>


@endsection
