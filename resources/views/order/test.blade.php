@extends('layout.app')

@section('title')
    Test
@endsection

@section('content')

    <div class="p-10">

        <p class="text-3xl mb-5">Trang chủ</p>

        @if (session('error'))
            <p>{{ session('error') }}</p>
        @endif
        
        @if (session('success'))
            <div id="success">
                <p onclick="removeSuccessMsg()">X</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        <div class="mb-2 space-x-3 flex flex-row text-center">
            <p id="allButton" class="bg-black text-white p-2 w-60 cursor-pointer">Tất cả</p>
            <p id="uncompletedButton" class="bg-black text-white p-2 w-60 cursor-pointer">Chưa giao món</p>
            <p id="completedButton" class="bg-black text-white p-2 w-60 cursor-pointer">Đã giao món và chưa thanh toán</p>
        </div>
        
        <div class="w-full">
            
            {{-- All Tables --}}
            <div id="allContent">

                @isset($filledTables)

                    <div class="grid grid-cols-4 gap-4">

                        @foreach ($filledTables as $filledTable)
                                    
                            <div class="my-4 border-2 border-black p-2">

                                <form action="{{ route('order.show', $filledTable->id) }}" method="GET">
                                    @csrf

                                    <button class="font-bold text-blue-500" type="submit">{{ $filledTable->first_name . " " . $filledTable->last_name }}</button>
                                </form>
                                
                                <div class="my-4">
                                    <p>Status:</p>

                                    {{-- Check if all 'Orders' is Completed --}}
                                    @if ($filledTable->order->contains('completion_status', 'no'))
                                        <p class="text-red-500">Chưa giao món</p>
                                    @else
                                        <p class="text-green-500">Đã giao món</p>
                                    @endif

                                    {{-- Check if all 'Orders' is Paid --}}
                                    @if ($filledTable->order->contains('payment_status', 'no'))
                                        <p class="text-red-500">Unpaid</p>
                                    @else
                                        <p class="text-green-500">Đã thanh toán</p>
                                    @endif
                                </div>

                                <div>
                                    <p>Button:</p>

                                    {{-- Check if all 'Orders' is Completed --}}
                                    @if ($filledTable->order->contains('completion_status', 'no'))
                                        <form action="{{ route('order.complete', $filledTable->id) }}" method="POST">
                                            @csrf
                                            @method('put')
            
                                            <button class="font-bold text-red-500" type="submit">Complete</button>
                                        </form>
                                    @else
                                        <button class="font-bold text-green-500" disabled>Đã giao món</button>
                                    @endif

                                    {{-- Check if all 'Orders' is Paid --}}
                                    @if ($filledTable->order->contains('payment_status', 'no'))
                                        <form action="{{ route('order.paid', $filledTable->id) }}" method="POST">
                                            @csrf
                                            @method('put')
            
                                            <button class="font-bold text-red-500" type="submit">Đã thanh toán</button>
                                        </form>
                                    @else
                                        <button class="font-bold text-green-500" disabled>Đã thanh toán</button>
                                    @endif
                                </div>

                            </div>

                        @endforeach

                    </div>

                @else
                    <p>No 'Table (Number)' here. Please add some users with the role 'Customer' if you are an admin.</p>    
                @endisset

            </div>
            
            {{-- Table with Uncompleted Orders --}}
            <div id="uncompletedContent" class="hidden">

                {{-- Check if there is any Customers account. e.g Table (Number) --}}
                @isset($filledTables)

                    {{-- @dd($filledTables) --}}

                    <div class="grid grid-cols-4 gap-4">

                        @foreach ($filledTables as $filledTable)

                            
                            
                        @endforeach
                    </div>

                @endisset

            </div>

            {{-- Table with Completed Orders --}}
            <div id="completedContent" class="hidden">
                
                <div class="grid grid-cols-4 gap-4">

                    @foreach ($filledTables as $filledTable )

                        {{-- Table with Orders --}}
                        @if(!$filledTable->order->isEmpty())
                            
                            {{-- Completed Orders --}}
                            @if ($filledTable->order->every('completion_status', 'yes'))

                                {{-- Unpaid Orders --}}
                                @if (!$filledTable->order->every('payment_status', 'yes'))

                                    <div class="my-4 border-2 border-black p-2">
                                        <p class="font-bold">{{ $filledTable->first_name . " " . $filledTable->last_name }}</p>
                                        
                                        <div class="my-4">
                                            <p>Status:</p>

                                            {{-- Check if all 'Orders' is Completed --}}
                                            @if ($filledTable->order->every('completion_status', 'yes'))
                                                <p class="text-green-500">Đã giao món</p>
                                            @else
                                                <p class="text-red-500">Chưa giao món</p>
                                            @endif

                                            {{-- Check if all 'Orders' is Paid --}}
                                            @if ($filledTable->order->every('payment_status', 'yes'))
                                                <p class="text-green-500">Đã thanh toán</p>
                                            @else
                                                <p class="text-red-500">Unpaid</p>
                                            @endif
                                        </div>

                                        <div>
                                            <p>Button:</p>

                                            {{-- Check if all 'Orders' is Completed --}}
                                            @if ($filledTable->order->every('completion_status', 'yes'))
                                                <button class="font-bold text-green-500" disabled>Đã giao món</button>
                                            @else
                                                <form action="{{ route('order.complete', $filledTable->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button class="font-bold text-red-500" type="submit">Complete</button>
                                                </form>
                                            @endif

                                            {{-- Check if all 'Orders' is Paid --}}
                                            @if ($filledTable->order->every('payment_status', 'yes'))
                                                <button class="font-bold text-green-500" disabled>Đã thanh toán</button>
                                            @else
                                                <form action="{{ route('order.paid', $filledTable->id) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                    
                                                    <button class="font-bold text-red-500" type="submit">Đã thanh toán</button>
                                                </form>
                                            @endif
                                        </div>

                                    </div>

                                @endif

                            @endif
                            
                        @endif
                    
                    @endforeach

                </div>

            </div>
            
        </div>

    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/order_index.js') }}" ></script>
    <script src="{{ asset('js/message.js') }}" ></script>


@endsection
