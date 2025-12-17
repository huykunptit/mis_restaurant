@extends('layout.app')

@php $pagename = "Home" @endphp

@section('title')

    {{ $table->table_name  }}'s Order

@endsection

@section('content')

    @php
        $i = 0;
    @endphp

    <div class="p-10">

        {{-- Page Name --}}
        <p class="text-3xl font-bold">{{ $table->table_name  }}'s Order</p>

        {{-- Bread Crumb --}}
        <div class="flex flex-row items-center text-sm my-10">
            <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <p>{{ $table->table_name  }}'s Order</p>
        </div>

        {{-- No Orders --}}
        @if ($orders->isEmpty())

            <div class="sm:w-1/2 mx-auto ">
                <img src="{{ asset('img/no_food.svg') }}" class="sm:w-2/3 mx-auto"> 
                <p class="font-extrabold text-4xl text-center mt-4">No Orders Found</p>
                <p class="font-extrabold text-sm text-center mt-2">There's currently no order from this table. Come, let's go back.</p>
                
                <a href="{{ route('home.' . auth()->user()->role->name ) }}">
                    <div class="mt-10 mx-auto lg:w-1/2 text-white text-center bg-green-800 px-5 py-5 rounded-xl flex flex-row items-center justify-center gap-3 transform hover:scale-105 transition-all duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <p>Go Back</p>
                    </div>
                </a>
            </div>

        {{-- Has Orders --}}
        @else

            {{-- Filter Buttons --}}
            <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons mb-10">

                <div id="allButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-900 bg-green-800 text-white hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p>Tất cả</p>
                </div>

                <div id="uncompletedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-56 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    <p>Chưa giao món</p>
                </div>

                <div id="completedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-56 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Đã giao món</p>
                </div>

            </div>

            {{-- Yêu cầu đặt món --}}
            <div class="my-10">
                <p class="font-bold mb-4">Yêu cầu đặt món</p>
                
                <div>
                    {{-- @foreach ($orders as $order )
                        @if($order->remarks !== "")

                            @php
                                $i = 1;
                            @endphp

                            <span class="capitalize">{{ $order->remarks }}.</span>
        
                        @endisset
                    @endforeach --}}

                    @if ($remark !== null)
                        <p>{{ $remark->remarks }}</p>
                    @else
                        <p>No additional request available.</p>
                    @endif
                
                </div>
    
                {{-- @if ($i == 0)
                    <p>No additional request available.</p>                            
                @endif
    
                @php
                    $i = 0;
                @endphp --}}
            </div>
            
            {{-- All Orders --}}
            <div id="allContent">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">

                    {{-- Drinks Section --}}
                    <div class="flex flex-col gap-y-5">

                        <p class="text-3xl font-bold">Đồ uống</p>

                        @foreach ($orders as $order )
                        
                            @if ($order->menu->category->id == 2)

                                @php
                                    $i = 1;
                                @endphp

                                {{-- Single Drink Order --}}
                                <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                    
                                    {{-- Image --}}
                                    @if ($order->menu->thumbnail == null)

                                        <img class="col-span-2 w-full h-auto rounded-lg  transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('img/noimg.png') }}">
                            
                                    @else

                                        <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('images/'.$order->menu->thumbnail) }}">

                                    @endif

                                    {{-- <img class="col-span-2 w-full h-auto rounded-lg" src="{{ asset('images/'.$order->menu->thumbnail) }}"> --}}

                                    {{-- Details --}}
                                    <div class="col-span-2">
                                        <p class="font-bold text-lg mb-2">{{ $order->menu->name }}</p>
                                        <p class="text-gray-600 text-sm">Lựa chọn:<span class="font-bold">{{ $order->menuOption->name }}</span></p>
                                        <p class="text-sm">Số lượng: <span class="font-bold">{{ $order->quantity }}</span></p>

                                        {{-- Status --}}
                                        <div class="text-sm mt-4">
                                            @if ($order->completion_status == "no")
                                                <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Chưa giao món</div>
                                            @elseif ($order->completion_status == "yes")
                                                <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Đã giao món</div>
                                            @endif
                                        </div>

                                    </div>

                                    {{-- Buttons --}}
                                    @if ($order->completion_status == "no")

                                        {{-- Uncompleted Buttons --}}
                                        <div class="col-span-2 flex flex-row items-center">
                                            <form action="{{ route('order.show.complete', $order->id) }}" method="POST">
                                                @csrf
                                                @method('put')
                
                                                <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <form action="{{ route('order.show.cancel', $order->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                
                                                <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                    @else
                                        
                                        {{-- Completed Buttons --}}
                                        <div class="col-span-2 flex flex-row items-center">
                                            <button class="font-bold text-gray-500" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
    
                                            <button class="font-bold text-gray-500" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>

                                    @endif

                                </div>

                            @endif
                            
                        @endforeach

                        @if ($i == 0)
                            <p>No drink orders. Customer is not thirsty.</p>                            
                        @endif

                        @php
                            $i = 0;
                        @endphp

                    </div>

                    {{-- Foods Section --}}
                    <div class="flex flex-col gap-y-5 mt-16 lg:mt-0">

                        <p class="text-3xl font-bold">Đồ ăn</p>

                        @foreach ($orders as $order )
                        
                            @if ($order->menu->category->id == 1)

                                @php
                                    $i = 1;
                                @endphp

                                {{-- Single Food Order --}}
                                <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                    
                                    {{-- Image --}}
                                    @if ($order->menu->thumbnail == null)

                                        <img class="col-span-2 w-full h-auto rounded-lg  transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('img/noimg.png') }}">
                            
                                    @else

                                        <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('images/'.$order->menu->thumbnail) }}">

                                    @endif

                                    {{-- <img class="col-span-2 w-full h-auto rounded-lg" src="{{ asset('images/'.$order->menu->thumbnail) }}"> --}}

                                    {{-- Details --}}
                                    <div class="col-span-2">
                                        <p class="font-bold text-lg mb-2">{{ $order->menu->name }}</p>
                                        <p class="text-gray-600 text-sm">Lựa chọn:<span class="font-bold">{{ $order->menuOption->name }}</span></p>
                                        <p class="text-sm">Số lượng: <span class="font-bold">{{ $order->quantity }}</span></p>

                                        {{-- Status --}}
                                        <div class="text-sm mt-4">
                                            @if ($order->completion_status == "no")
                                                <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Chưa giao món</div>
                                            @elseif ($order->completion_status == "yes")
                                                <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Đã giao món</div>
                                            @endif
                                        </div>

                                    </div>

                                    {{-- Buttons --}}
                                    @if ($order->completion_status == "no")

                                        {{-- Uncompleted Buttons --}}
                                        <div class="col-span-2 flex flex-row items-center">
                                            <form action="{{ route('order.show.complete', $order->id) }}" method="POST">
                                                @csrf
                                                @method('put')
                
                                                <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <form action="{{ route('order.show.cancel', $order->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                
                                                <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                    @else
                                        
                                        {{-- Completed Buttons --}}
                                        <div class="col-span-2 flex flex-row items-center">
                                            <button class="font-bold text-gray-500" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
    
                                            <button class="font-bold text-gray-500" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>

                                    @endif

                                </div>

                            @endif
                            
                        @endforeach

                        @if ($i == 0)
                            <p>No food orders. Customer is not hungry.</p>                            
                        @endif

                        @php
                            $i = 0;
                        @endphp

                    </div>

                </div>

                {{-- Mark All As Complete Button --}}
                <div class="flex flex-row justify-end my-10">

                    @if ($orders->every('completion_status', 'yes'))
                        {{-- <button class="text-white bg-gray-500 px-10 py-4 rounded-xl flex flex-row items-center space-x-3 transition-all duration-500 cursor-not-allowed" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <p>Mark All As Complete</p>
                        </button> --}}
                    @else
                        <form action="{{ route('order.complete', $table->id) }}" method="POST">
                            @csrf
                            @method('put')

                            <button class="text-white bg-black px-10 py-4 rounded-xl flex flex-row items-center space-x-3 transform hover:scale-105 transition-all duration-500" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <p>Mark All As Complete</p>
                            </button>
                        </form>
                    @endif
                    
                </div>

            </div>

            {{-- Uncompleted Orders --}}
            <div id="uncompletedContent" class="hidden">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">

                    {{-- Drinks Section --}}
                    <div class="flex flex-col gap-y-5">

                        <p class="text-3xl font-bold">Đồ uống</p>

                        @foreach ($orders as $order )

                            @if ($order->menu->category->id == 2)
                            
                                @if ($order->completion_status == "no")

                                    @php
                                        $i = 1;
                                    @endphp
                                    
                                    {{-- Single Drink Order --}}
                                    <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                        {{-- Image --}}
                                        @if ($order->menu->thumbnail == null)

                                            <img class="col-span-2 w-full h-auto rounded-lg  transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('img/noimg.png') }}">
                                
                                        @else

                                            <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('images/'.$order->menu->thumbnail) }}">

                                        @endif

                                        {{-- <img class="col-span-2 w-full h-auto rounded-lg" src="{{ asset('images/'.$order->menu->thumbnail) }}"> --}}

                                        {{-- Details --}}
                                        <div class="col-span-2">
                                            <p class="font-bold text-lg mb-2">{{ $order->menu->name }}</p>
                                            <p class="text-gray-600 text-sm">Lựa chọn:<span class="font-bold">{{ $order->menuOption->name }}</span></p>
                                            <p class="text-sm">Số lượng: <span class="font-bold">{{ $order->quantity }}</span></p>

                                            {{-- Status --}}
                                            <div class="text-sm mt-4">
                                                @if ($order->completion_status == "no")
                                                    <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Chưa giao món</div>
                                                @elseif ($order->completion_status == "yes")
                                                    <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Đã giao món</div>
                                                @endif
                                            </div>

                                        </div>

                                        {{-- Buttons --}}
                                        @if ($order->completion_status == "no")

                                            {{-- Uncompleted Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <form action="{{ route('order.show.complete', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('order.show.cancel', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                    
                                                    <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                        @else
                                            
                                            {{-- Completed Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
        
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>

                                        @endif

                                    </div>

                                @endif

                            @endif

                        @endforeach

                        @if ($i == 0)
                            <p>No uncompleted drink orders.</p>                            
                        @endif

                        @php
                            $i = 0;
                        @endphp

                    </div>
                    
                    {{-- Foods Section --}}
                    <div class="flex flex-col gap-y-5 mt-16 lg:mt-0">

                        <p class="text-3xl font-bold">Đồ ăn</p>

                        @foreach ($orders as $order )

                            @if ($order->menu->category->id == 1)

                                @if ($order->completion_status == "no")

                                    @php
                                        $i = 1;
                                    @endphp

                                    {{-- Single Food Order --}}
                                    <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                        {{-- Image --}}
                                        @if ($order->menu->thumbnail == null)

                                            <img class="col-span-2 w-full h-auto rounded-lg  transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('img/noimg.png') }}">
                                
                                        @else

                                            <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('images/'.$order->menu->thumbnail) }}">

                                        @endif

                                        {{-- <img class="col-span-2 w-full h-auto rounded-lg" src="{{ asset('images/'.$order->menu->thumbnail) }}"> --}}

                                        {{-- Details --}}
                                        <div class="col-span-2">
                                            <p class="font-bold text-lg mb-2">{{ $order->menu->name }}</p>
                                            <p class="text-gray-600 text-sm">Lựa chọn:<span class="font-bold">{{ $order->menuOption->name }}</span></p>
                                            <p class="text-sm">Số lượng: <span class="font-bold">{{ $order->quantity }}</span></p>

                                            {{-- Status --}}
                                            <div class="text-sm mt-4">
                                                @if ($order->completion_status == "no")
                                                    <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Chưa giao món</div>
                                                @elseif ($order->completion_status == "yes")
                                                    <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Đã giao món</div>
                                                @endif
                                            </div>

                                        </div>

                                        {{-- Buttons --}}
                                        @if ($order->completion_status == "no")

                                            {{-- Uncompleted Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <form action="{{ route('order.show.complete', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('order.show.cancel', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                    
                                                    <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                        @else
                                            
                                            {{-- Completed Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
        
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>

                                        @endif

                                    </div>

                                @endif

                            @endif

                        @endforeach

                        @if ($i == 0)
                            <p>No uncompleted food orders.</p>                            
                        @endif

                        @php
                            $i = 0;
                        @endphp

                    </div>

                </div>

                {{-- Mark All As Complete Button --}}
                <div class="flex flex-row justify-end my-10">

                    @if ($orders->every('completion_status', 'yes'))
                        {{-- <button class="text-white bg-gray-500 px-10 py-4 rounded-xl flex flex-row items-center space-x-3 transition-all duration-500 cursor-not-allowed" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <p>Mark All As Complete</p>
                        </button> --}}
                    @else
                        <form action="{{ route('order.complete', $table->id) }}" method="POST">
                            @csrf
                            @method('put')

                            <button class="text-white bg-black px-10 py-4 rounded-xl flex flex-row items-center space-x-3 transform hover:scale-105 transition-all duration-500" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <p>Mark All As Complete</p>
                            </button>
                        </form>
                    @endif
                    
                </div>

            </div>

            {{-- Completed Orders --}}
            <div id="completedContent" class="hidden">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">

                    {{-- Drinks Section --}}
                    <div class="flex flex-col gap-y-5">

                        <p class="text-3xl font-bold">Đồ uống</p>

                        @foreach ($orders as $order )

                            @if ($order->menu->category->id == 2)

                                @if ($order->completion_status == "yes")

                                    @php
                                        $i = 1;
                                    @endphp

                                    {{-- Single Drink Order --}}
                                    <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                        {{-- Image --}}
                                        @if ($order->menu->thumbnail == null)

                                            <img class="col-span-2 w-full h-auto rounded-lg  transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('img/noimg.png') }}">
                                
                                        @else

                                            <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('images/'.$order->menu->thumbnail) }}">

                                        @endif

                                        {{-- <img class="col-span-2 w-full h-auto rounded-lg" src="{{ asset('images/'.$order->menu->thumbnail) }}"> --}}

                                        {{-- Details --}}
                                        <div class="col-span-2">
                                            <p class="font-bold text-lg mb-2">{{ $order->menu->name }}</p>
                                            <p class="text-gray-600 text-sm">Lựa chọn:<span class="font-bold">{{ $order->menuOption->name }}</span></p>
                                            <p class="text-sm">Số lượng: <span class="font-bold">{{ $order->quantity }}</span></p>

                                            {{-- Status --}}
                                            <div class="text-sm mt-4">
                                                @if ($order->completion_status == "no")
                                                    <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Chưa giao món</div>
                                                @elseif ($order->completion_status == "yes")
                                                    <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Đã giao món</div>
                                                @endif
                                            </div>

                                        </div>

                                        {{-- Buttons --}}
                                        @if ($order->completion_status == "no")

                                            {{-- Uncompleted Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <form action="{{ route('order.show.complete', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('order.show.cancel', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                    
                                                    <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                        @else
                                            
                                            {{-- Completed Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
        
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>

                                        @endif

                                    </div>

                                @endif

                            @endif

                        @endforeach

                        @if ($i == 0)
                            <p>No completed drink orders. Let's wait.</p>                            
                        @endif

                        @php
                            $i = 0;
                        @endphp

                    </div>
                    
                    {{-- Foods Section --}}
                    <div class="flex flex-col gap-y-5 mt-16 lg:mt-0">

                        <p class="text-3xl font-bold">Đồ ăn</p>

                        @foreach ($orders as $order )

                            @if ($order->menu->category->id == 1)

                                @if ($order->completion_status == "yes")

                                    @php
                                        $i = 1;
                                    @endphp

                                    {{-- Single Food Order --}}
                                    <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                        {{-- Image --}}
                                        @if ($order->menu->thumbnail == null)

                                            <img class="col-span-2 w-full h-auto rounded-lg  transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('img/noimg.png') }}">
                                
                                        @else

                                            <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="{{ asset('images/'.$order->menu->thumbnail) }}">

                                        @endif

                                        {{-- <img class="col-span-2 w-full h-auto rounded-lg" src="{{ asset('images/'.$order->menu->thumbnail) }}"> --}}

                                        {{-- Details --}}
                                        <div class="col-span-2">
                                            <p class="font-bold text-lg mb-2">{{ $order->menu->name }}</p>
                                            <p class="text-gray-600 text-sm">Lựa chọn:<span class="font-bold">{{ $order->menuOption->name }}</span></p>
                                            <p class="text-sm">Số lượng: <span class="font-bold">{{ $order->quantity }}</span></p>

                                            {{-- Status --}}
                                            <div class="text-sm mt-4">
                                                @if ($order->completion_status == "no")
                                                    <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Chưa giao món</div>
                                                @elseif ($order->completion_status == "yes")
                                                    <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Đã giao món</div>
                                                @endif
                                            </div>

                                        </div>

                                        {{-- Buttons --}}
                                        @if ($order->completion_status == "no")

                                            {{-- Uncompleted Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <form action="{{ route('order.show.complete', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <form action="{{ route('order.show.cancel', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                    
                                                    <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                        @else
                                            
                                            {{-- Completed Buttons --}}
                                            <div class="col-span-2 flex flex-row items-center">
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
        
                                                <button class="font-bold text-gray-500" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>

                                        @endif

                                    </div>

                                @endif

                            @endif

                        @endforeach

                        @if ($i == 0)
                            <p>No completed food orders. Let's wait.</p> 
                        @endif

                        @php
                            $i = 0;
                        @endphp
                        
                    </div>

                </div>

            </div>

        @endif
    
    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/order_index.js') }}" ></script>

@endsection