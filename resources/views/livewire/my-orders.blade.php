
<div class="bg-gray-300 lg:bg-gray-200 py-10 px-5 h-full lg:fixed overflow-auto myOrder " wire:poll.450ms wire:init="loadPart">

    {{-- Title --}}
    <p class="font-bold text-3xl">Hoá đơn thanh toán</p>

    {{-- Table Number --}}
    <div class="flex flex-row items-center gap-x-2 mt-2 font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
          </svg>
        <p>{{ auth()->user()->first_name . " " .  auth()->user()->last_name  }}</p>
    </div>

    {{-- Set Default Section --}}
    @empty($part)
        @php
            $part = "new";
        @endphp
    @endempty

    {{-- Filter Buttons --}}
    <div class="flex gap-y-4 flex-col xl:flex-row items-center gap-x-5 my-5 select-none text-sm">

        <div wire:click="new" class="flex flex-row items-center justify-center gap-x-3 border-3 border-green-800 text-center font-bold py-1.5 px-4 rounded-full w-full xl:w-40 cursor-pointer @isset($part) @if($part == "new") bg-primary text-white @elseif($part == "submitted") text-primary hover:bg-primary hover:text-white @else text-primary hover:bg-primary hover:text-white @endif @endisset">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <p>Gọi thêm đồ</p>
        </div>

        <div wire:click="submitted" class="flex flex-row items-center justify-center gap-x-3 border-3 border-green-800 text-center font-bold py-1.5 px-4 rounded-full w-full xl:w-52 cursor-pointer @isset($part) @if($part == "submitted") bg-primary text-white @elseif($part == "new") text-primary hover:bg-primary hover:text-white @else text-primary hover:bg-primary hover:text-white @endif @endisset">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p>Đồ đã gọi</p>
        </div>

    </div>

    {{-- Content --}}
    <div class="mt-8 min-h-screen" wire:poll>

        <form wire:submit.prevent='submitOrder' class="@isset($part) @if($part == "new") visible @elseif($part == "submitted") hidden @else hidden @endif @endisset">
            @csrf

            @if(!$myOrders->isEmpty())

                <div class="flex flex-col gap-y-4 mb-10 text-sm">

                    @foreach ($myOrders as $myOrder)

                        <div class="bg-white p-4 grid grid-cols-6 gap-x-4 rounded-lg group">
                            
                            {{-- Image --}}
                            @if ($myOrder->menu->thumbnail == null)

                                <div class="col-span-6 xl:col-span-2 shadow-lg relative w-auto h-full rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                            
                                    <img class="h-full w-auto object-cover" src="{{ asset('img/noimg.png') }}">

                                </div>

                            @else

                                <div class="col-span-6 xl:col-span-2 shadow-lg relative w-auto h-full rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                            
                                    <img class="h-full w-auto object-cover" src="{{ asset('images/'.$myOrder->menu->thumbnail) }}">

                                </div>

                            @endif

                            {{-- Desktop --}}
                            <div class="hidden col-span-6 xl:col-span-2 xl:flex flex-col justify-between gap-y-3">

                                <div class="">
                                    <p class="font-bold whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">{{ $myOrder->menu->name }}</p>
                                    <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Lựa chọn:{{ $myOrder->menuOption->name }}</p>
                                </div>
                                
                                {{-- Button --}}
                                <div class="flex flex-row items-center">
                                    <button type="button" wire:click="decrement({{ $myOrder->id }})" wire:loading.attr="disabled" wire:target="decrement({{ $myOrder->id }})" class="px-3 py-0.5 bg-primary hover:bg-primary disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-xl rounded-l-full transition-all duration-500">
                                        <span wire:loading.remove wire:target="decrement({{ $myOrder->id }})">-</span>
                                        <span wire:loading wire:target="decrement({{ $myOrder->id }})" class="inline-block animate-spin">⟳</span>
                                    </button>
                                    <p class="px-4 py-1 text-md font-bold w-10 text-center border-2 border-green-800">{{ $myOrder->quantity }}</p>
                                    <button type="button" wire:click="increment({{ $myOrder->id }})" wire:loading.attr="disabled" wire:target="increment({{ $myOrder->id }})" class="px-3 py-0.5 bg-primary hover:bg-primary disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-xl rounded-r-full transition-all duration-500">
                                        <span wire:loading.remove wire:target="increment({{ $myOrder->id }})">+</span>
                                        <span wire:loading wire:target="increment({{ $myOrder->id }})" class="inline-block animate-spin">⟳</span>
                                    </button>
                                </div>

                            </div>

                            <div class="hidden col-span-6 xl:col-span-2 xl:flex flex-col items-end justify-between">
                                <p class="font-extrabold">VNĐ {{ number_format($myOrder->menuOption->cost, 0) }}</p>

                                <button wire:click="remove({{ $myOrder->id }})" wire:loading.attr="disabled" wire:target="remove({{ $myOrder->id }})" type="button" class="bg-red-800 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-full px-3 py-1.5 transition-all duration-500">
                                    <span wire:loading.remove wire:target="remove({{ $myOrder->id }})">Remove</span>
                                    <span wire:loading wire:target="remove({{ $myOrder->id }})" class="inline-block animate-spin">⟳</span>
                                </button>
                                
                            </div>

                            {{-- iPad Pro --}}
                            <div class="xl:hidden col-span-6 flex flex-col justify-between gap-y-3">

                                <div class="mt-4">
                                    <p class="font-bold whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">{{ $myOrder->menu->name }}</p>
                                    <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Lựa chọn:{{ $myOrder->menuOption->name }}</p>
                                </div>
                                
                                {{-- Button --}}
                                <div class="flex flex-row items-center gap-x-2 w-full">
                                    <div class="flex flex-row items-center">
                                        <button type="button" wire:click="decrement({{ $myOrder->id }})" wire:loading.attr="disabled" wire:target="decrement({{ $myOrder->id }})" class="px-3 py-0.5 bg-primary hover:bg-primary disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-xl rounded-l-full transition-all duration-500">
                                            <span wire:loading.remove wire:target="decrement({{ $myOrder->id }})">-</span>
                                            <span wire:loading wire:target="decrement({{ $myOrder->id }})" class="inline-block animate-spin">⟳</span>
                                        </button>
                                        <p class="px-4 py-1 text-md font-bold w-10 text-center border-2 border-green-800">{{ $myOrder->quantity }}</p>
                                        <button type="button" wire:click="increment({{ $myOrder->id }})" wire:loading.attr="disabled" wire:target="increment({{ $myOrder->id }})" class="px-3 py-0.5 bg-primary hover:bg-primary disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-xl rounded-r-full transition-all duration-500">
                                            <span wire:loading.remove wire:target="increment({{ $myOrder->id }})">+</span>
                                            <span wire:loading wire:target="increment({{ $myOrder->id }})" class="inline-block animate-spin">⟳</span>
                                        </button>
                                    </div>
                                    <button wire:click="remove({{ $myOrder->id }})" wire:loading.attr="disabled" wire:target="remove({{ $myOrder->id }})" type="button" class="bg-red-800 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-full px-4 py-1 transition-all duration-500">
                                        <span wire:loading.remove wire:target="remove({{ $myOrder->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </span>
                                        <span wire:loading wire:target="remove({{ $myOrder->id }})" class="inline-block animate-spin">⟳</span>
                                    </button>
                                </div>

                            </div>

                            <div class="xl:hidden col-span-6 mt-4">
                                <p class="font-extrabold">VNĐ {{ number_format($myOrder->menuOption->cost, 0) }}</p>
                            </div>
                            
                        </div>

                    @endforeach

                </div>
            
            @else
            
                <div class="my-10 w-full">
                    <img src="{{ asset('img/tree.svg') }}" class="w-1/2 mx-auto">
                    <p class="text-center font-bold mt-2">No order yet.</p>
                </div>

            @endif
            
            {{-- Remarks --}}
            <div>
                <p class="font-bold mb-2">Yêu cầu thêm</p>
                <textarea class="rounded-lg mb-4 w-full h-32 p-3" wire:model="remark" placeholder="Nhập yêu cầu của bạn tại đây"></textarea>
            </div>

            {{-- Line --}}
            <div class="bg-primary w-full h-1 mt-5"></div>
            
            {{-- Tổng --}}
            <div class="flex flex-row items-center justify-between text-lg font-extrabold my-5">
                
                <p>Tổng</p>

                {{-- Initial Value of Tổng --}}
                @php $total = 0 @endphp
                
                {{-- Calculate Tổng --}}
                @foreach ( $myOrders as $myOrder)

                    <div class="hidden">
                        {{ $total +=  $myOrder->menuOption->cost * $myOrder->quantity}}
                    </div>

                @endforeach

                <p class="tracking-widest">{{ number_format($total,0)}} VNĐ</p>

            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="submitOrder" class="bg-primary hover:bg-primary disabled:opacity-50 disabled:cursor-not-allowed text-white py-4 w-full rounded-lg transform hover:scale-105 transition-all duration-500 flex items-center justify-center">
                <span wire:loading.remove wire:target="submitOrder">Submit</span>
                <span wire:loading wire:target="submitOrder" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Đang xử lý...
                </span>
            </button>

        </form>

        {{-- Submitted Orders --}}
        <div class="my-10 @isset($part) @if($part == "submitted") visible @elseif($part == "new") hidden @else hidden @endif @endisset">

            {{-- <p class="font-bold mb-4">Submitted Orders</p> --}}

            {{-- <p class="my-10">{{ $pendingOrders }}</p> --}}

            @if(!$submittedOrders->isEmpty())

                <div class="flex flex-col gap-y-4 mb-10 text-sm">

                    @foreach ($submittedOrders as $submittedOrder)

                        <div class="bg-white p-4 grid grid-cols-6 gap-x-4 rounded-lg group">
                            
                            {{-- Image --}}
                            @if ($submittedOrder->menu->thumbnail == null)

                                <div class="col-span-2 shadow-lg relative w-auto h-full rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                            
                                    <img class="h-full w-auto object-cover" src="{{ asset('img/noimg.png') }}">

                                </div>

                            @else

                                <div class="col-span-2 shadow-lg relative w-auto h-full rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                            
                                    <img class="h-full w-auto object-cover" src="{{ asset('images/'.$submittedOrder->menu->thumbnail) }}">

                                </div>

                            @endif


                            <div class="col-span-2 flex flex-col justify-between gap-y-3">

                                <div>
                                    <p class="font-bold whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">{{ $submittedOrder->menu->name }}</p>
                                    <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Lựa chọn:<span class="font-bold">{{ $submittedOrder->menuOption->name }}</span></p>
                                    <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Số lượng: <span class="font-bold">{{ $submittedOrder->quantity }}</span></p>
                                </div>

                                @if ($submittedOrder->completion_status == "no")

                                    <div class="bg-red-800 text-white text-xs w-20 text-center py-1 rounded-full">
                                        <p>Pending</p>
                                    </div>

                                @else

                                    <div class="bg-primary text-white text-xs w-20 text-center py-1 rounded-full">
                                        <p>Đã giao món</p>
                                    </div>

                                @endif

                            </div>

                            <div class="col-span-2 flex flex-col items-end justify-between">
                                <p class="font-extrabold">VNĐ {{ number_format($submittedOrder->menuOption->cost, 0) }}</p>

                            </div>
                            
                        </div>

                    @endforeach

                </div>

                {{-- Line --}}
                <div class="bg-primary w-full h-1 mt-5"></div>
                
                {{-- Tổng --}}
                <div class="flex flex-row items-center justify-between text-lg font-extrabold my-5">
                    
                    <p>Tổng</p>

                    {{-- Initial Value of Tổng --}}
                    @php $totalSubmitted = 0 @endphp
                    
                    {{-- Calculate Tổng --}}
                    @foreach ( $submittedOrders as $submittedOrder)

                        <div class="hidden">
                            {{ $totalSubmitted +=  $submittedOrder->menuOption->cost * $submittedOrder->quantity}}
                        </div>

                    @endforeach

                    <p class="tracking-widest">VNĐ {{ number_format($totalSubmitted, 2)}}</p>

                </div>

                {{-- Line --}}
                <div class="bg-primary w-full h-1 mt-5"></div>

            @else
            
                <div class="my-20 w-full">
                    <img src="{{ asset('img/working.svg') }}" class="w-1/2 mx-auto">
                    <p class="text-center font-bold mt-2">No submitted orders yet.</p>
                </div>
            
            @endif

        </div>

            
    </div>

</div>

