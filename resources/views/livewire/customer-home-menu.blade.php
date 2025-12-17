<div wire:init="loadSection" class="p-10">

    <div wire:poll.450ms>
        @include('layout.message')
    </div>

    {{-- Recommendation Button --}}
    <div class="flex flex-row w-full lg:w-1/2 whitespace-nowrap">

        <div wire:click="food" id="foodsButton" class="border-b-6 hover:border-green-800 w-full flex flex-row items-center gap-x-2 pr-10 py-2 font-bold text-lg cursor-pointer transition-all duration-500 @isset($section) @if($section == "food") border-green-800 @elseif($section == "drink") border-gray-300 @else border-gray-300 @endif @endisset">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
            </svg>
            <p class="">Đồ ăn bán chạy</p>
        </div>

        <div wire:click="drink" id="drinksButton" class="border-b-6 hover:border-green-800 border-gray-300 w-full flex flex-row items-center gap-x-2 pr-10 py-2 font-bold text-lg cursor-pointer transition-all duration-500 @isset($section) @if($section == "food") border-gray-300 @elseif($section == "drink") border-green-800 @else border-gray-300 @endif @endisset">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
            </svg>
            <p class="">Đồ uống bán chạy</p>
        </div>

    </div>

    {{-- Set Default Section --}}
    @empty($section)
        @php
            $section = "food";
        @endphp
    @endempty

    {{-- Đồ ăn bán chạy--}}
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
                                
                                {{-- Tags --}}
                                <div class="absolute right-1 top-1 flex flex-row space-x-2">

                                    <div class="px-2 py-1 bg-purple-600 text-white text-xs rounded-full">
                                        <p>{{ number_format($total*20.6+38, 0) }} đã bán</p>
                                    </div>

                                </div>

                            </div>

                        @else

                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                <img class="w-full h-auto" src="{{ asset('images/'.$food->thumbnail) }}">
                                
                                {{-- Tags --}}
                                <div class="absolute right-1 top-1 flex flex-row space-x-2">

                                    <div class="px-2 py-1 bg-purple-600 text-white text-xs rounded-full">
                                        <p>{{ number_format($total*20.6+38, 0) }} đã bán</p>
                                    </div>

                                </div>

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
            <p>Sorry, no popular foods for now.</p>                            
        @endif

        @php
            $i = 0;
        @endphp

    </div>


    {{-- Đồ uống bán chạy --}}
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
                                
                                {{-- Tags --}}
                                <div class="absolute right-1 top-1 flex flex-row space-x-2">

                                    <div class="px-2 py-1 bg-pink-600 text-white text-xs rounded-full">
                                        <p>{{ number_format($total*20.6+38, 0) }} đã bán</p>
                                    </div>

                                </div>

                            </div>

                        @else

                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        
                                <img class="w-full h-auto" src="{{ asset('images/'.$drink->thumbnail) }}">
                                
                                {{-- Tags --}}
                                <div class="absolute right-1 top-1 flex flex-row space-x-2">

                                    <div class="px-2 py-1 bg-pink-600 text-white text-xs rounded-full">
                                        <p>{{ number_format($total*20.6+38, 0) }} đã bán</p>
                                    </div>

                                </div>

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
            <p>Sorry, no popular drinks for now.</p>                            
        @endif

        @php
            $i = 0;
        @endphp

    </div>

</div>
