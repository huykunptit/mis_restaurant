@extends('layout.app')

@section('title')
    {{ auth()->user()->first_name . " " . auth()->user()->last_name }}'s Homepage
@endsection

@section('content')

    {{-- <livewire:customer-home-menu /> --}}

    {{-- Insert Slider Here --}}

    {{-- Buttons --}}
    <div class="flex flex-row space-x-6 m-10">
        <p class="cursor-pointer font-bold text-blue-500" id="foodsButton">Đồ ăn bán chạy</p>
        <p class="cursor-pointer font-bold text-blue-500" id="drinksButton">Đồ uống bán chạy</p>
    </div>

    
    {{-- Popular Food --}}
    <div id="foodsContent" class="m-10">
        @foreach ($foods as $food )
        
            <div class="mb-4">
                <img class="w-10" src="{{ asset('images/'.$food->thumbnail) }}">
                <p class="font-bold">{{ $food->name }}</p>

                <p> {{ number_format($food->menuOption->first()->cost, 0) }} VNĐ</p>

                <div class="my-2">
                    <p>Options:</p>
                    <select name="role" id="role" class="border-2 border-black capitalize">
    
                        @foreach ($food->menuOption as $option)
                            <option value="{{ $option->id }}" class="capitalize">{{ $option->name }}</option>
                        @endforeach
    
                    </select>
                    
                    <form action="" method="">
                        @csrf
    
                        <button class="font-bold text-blue-500" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>

               
            </div>

        @endforeach
    </div>

    {{-- Đồ uống bán chạy --}}
    <div id="drinksContent" class="m-10 hidden">
        @foreach ($drinks as $drink )
        
            <div class="mb-4">
                <img class="w-10" src="{{ asset('images/'.$drink->thumbnail) }}">
                <p class="font-bold">{{ $drink->name }}</p>

                <p> {{ number_format($drink->menuOption->first()->cost, 0) }} VNĐ</p>

                <div class="my-2">
                    <p>Options:</p>
                    <select name="role" id="role" class="border-2 border-black capitalize">
    
                        @foreach ($drink->menuOption as $option)
                            <option value="{{ $option->id }}" class="capitalize">{{ $option->name }}</option>
                        @endforeach
    
                    </select>
                    
                    <form action="" method="">
                        @csrf
    
                        <button class="font-bold text-blue-500" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>

               
            </div>

        @endforeach
    </div>

    <div class="m-10">
        <p class="font-bold text-3xl">Hoá đơn thanh toán</p>
        <p>{{ auth()->user()->first_name . " " .  auth()->user()->last_name  }}</p>

        <div class="my-4">
            
            <div>
                <img src="">
                <p>Menu Item Tên</p>
                <p> Price VNĐ</p>

                {{-- Button --}}
                <div class="flex flex-row items-center space-x-2">
                    <button class="p-2 border-2 border-black">+</button>
                        <p>quantity</p>
                    <button class="p-2 border-2 border-black">-</button>
                </div>
                
            </div>
                
        </div>

    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('js/customer_home.js') }}" ></script>

@endsection