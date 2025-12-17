<div wire:init="loadSection" class="p-10">
    
    <div wire:poll.450ms>
        @include('layout.message')
    </div>

    {{-- Page Name --}}
    <p class="text-3xl font-bold">Menu List</p>

    {{-- Bread Crumb --}}
    <div class="flex flex-row items-center text-sm my-10">
        <a href="{{ route('home.customer' ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <p>Menu List</p>
    </div>
    
    {{-- Filter Buttons --}}
    <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons mb-10">

        <div wire:click="food" id="foodsButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500  @isset($section) @if($section == "food") bg-green-800 text-white @elseif($section == "drink") bg-white text-green-800 hover:bg-green-800 hover:text-white @else bg-white text-green-800 hover:bg-green-800 hover:text-white @endif @endisset">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
            </svg>
            <p>Đồ ăn</p>
        </div>

        <div wire:click="drink" id="drinksButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500 @isset($section) @if($section == "food") bg-white text-green-800 hover:bg-green-800 hover:text-white @elseif($section == "drink") bg-green-800 text-white @else bg-white text-green-800 hover:bg-green-800 hover:text-white @endif @endisset">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            <p>Đồ uống</p>
        </div>

    </div>

    {{-- Set Default Section --}}
    @empty($section)
        @php
            $section = "food";
        @endphp
    @endempty

    {{-- Foods --}}
    <div id="foodsContent" class="@isset($section) @if($section == "food") visible @elseif($section == "drink") hidden @else hidden @endif @endisset">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-7 mt-10">
            
            @php
                $i = 0;
            @endphp

            @foreach ( $foods as $food )

                @php $total = 0 @endphp

                @foreach ($food->order as $order)
                    <div class="hidden">
                        {{ $total += $order->quantity }}
                    </div>
                @endforeach

                @if ($total > -1)

                    @php
                        $i = 1;
                    @endphp

                    {{-- Single Grid --}}
                    <div class="">
                        
                        {{-- Image --}}
                        @if ($food->thumbnail == null)

                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                <img class="w-full h-auto" src="{{ asset('img/noimg.png') }}">

                            </div>

                        @else

                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                <img class="w-full h-auto" src="{{ asset('images/'.$food->thumbnail) }}">

                            </div>

                        @endif

                        {{-- Detail --}}
                        {{-- Menu Item Name and Price --}}
                        <div class="flex flex-row items-center justify-between font-bold mt-4 mx-2 space-x-2">
                            <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">{{ $food->name }}</p>
                            <p class="whitespace-nowrap"> {{ number_format($food->menuOption->first()->cost, 0) }} VNĐ</p>
                        </div>

                        {{-- Action --}}
                        <form wire:submit.prevent='addOrder({{ $food->id }})' class="mx-2 mt-2 flex flex-row items-center justify-between gap-x-3">
                            @csrf
                            
                            <select wire:model="optionId" class="w-full p-1 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-full capitalize" required>
                                
                                <option value="" class="capitalize">-- Lựa chọn --</option>

                                @foreach ($food->menuOption as $option)
                                    <option value="{{ $option->id }}" class="capitalize">{{ $option->name }}</option>
                                @endforeach
            
                            </select>

                            <button class="text-white bg-green-800 py-2 px-4 rounded-full" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </form>

                    </div>

                @endif
                
            @endforeach

        </div>

        @if ($i == 0)
            <p>Sorry, no food menu available.</p>                            
        @endif

        @php
            $i = 0;
        @endphp

    </div>

    {{-- Drinks --}}
    <div class="@isset($section) @if($section == "food") hidden @elseif($section == "drink") visible @else hidden @endif @endisset">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-7 mt-10">
            
            @php
                $i = 0;
            @endphp

            @foreach ( $drinks as $drink )

                @php $total = 0 @endphp

                @foreach ($drink->order as $order)
                    <div class="hidden">
                        {{ $total += $order->quantity }}
                    </div>
                @endforeach

                @if ($total > -1)

                    @php
                        $i = 1;
                    @endphp

                    {{-- Single Grid --}}
                    <div class="">

                        {{-- Image --}}
                        @if ($drink->thumbnail == null)

                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                <img class="w-full h-auto" src="{{ asset('img/noimg.png') }}">
                                
                            </div>

                        @else

                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                <img class="w-full h-auto" src="{{ asset('images/'.$drink->thumbnail) }}">

                            </div>

                        @endif

                        {{-- Detail --}}
                        {{-- Menu Item Name and Price --}}
                        <div class="flex flex-row items-center justify-between font-bold mt-4 mx-2 space-x-2">
                            <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">{{ $drink->name }}</p>
                            <p class="whitespace-nowrap">{{ number_format($drink->menuOption->first()->cost, 0) }} VNĐ</p>
                        </div>

                        {{-- Action --}}
                        <form wire:submit.prevent='addOrder({{ $drink->id }})' class="mx-2 mt-2 flex flex-row items-center justify-between gap-x-3">
                            @csrf
                            
                            <select wire:model="optionId" class="w-full p-1 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-full capitalize" required>
                                
                                <option value="" class="capitalize">-- Lựa chọn --</option>

                                @foreach ($drink->menuOption as $option)
                                    <option value="{{ $option->id }}" class="capitalize">{{ $option->name }}</option>
                                @endforeach
            
                            </select>

                            <button class="text-white bg-green-800 py-2 px-4 rounded-full" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </form>

                    </div>

                @endif
                
            @endforeach

        </div>

        @if ($i == 0)
            <p>Sorry, no drink menu available.</p>                            
        @endif

        @php
            $i = 0;
        @endphp

    </div>

</div>
