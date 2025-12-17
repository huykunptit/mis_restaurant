@extends('layout.app')

@php $pagename = "Help" @endphp

@section('title')

    Help

@endsection

@section('content')

    <div class="p-10">

        {{-- Page Name --}}
        <p class="text-3xl font-bold">@isset($pagename) {{ $pagename }} @endisset - Frequently Asked Questions </p>

        {{-- Bread Crumb --}}
        <div class="flex flex-row items-center text-sm my-10">
            <a href="{{ route('home.' . auth()->user()->role->name ) }}" class="font-bold hover:text-blue-800">Trang chủ</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <p>Help - Frequently Asked Questions</p>
        </div>

        {{-- Description --}}
        <div class="flex flex-row items-center gap-x-2 text-gray-500">
            <p class="">Need help in using the website? Browse through the FAQs below</p>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>


        {{-- Accordion --}}

        <div class="my-10 flex flex-col gap-y-3 w-full xl:w-1/2">

            <div class="shadow-lg overflow-hidden">
                <div class="select-none accordion rounded-md flex flex-row items-center justify-between bg-green-800 text-white cursor-pointer px-10 py-3 w-full font-bold">
                    <p>How to make an order?</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="panel rounded-b-md bg-gray-200 text-green-800 px-10 py-6 w-full hidden overflow-hidden">
                    
                    <p>You can make an order from:</p>
                    <ol class="list-disc list-inside">
                        <li><a href="{{ route('home.customer') }}" class="text-blue-500 font-bold">Home page</a> (Popular section)</li>
                        <li><a href="{{ route('menu.customer') }}" class="text-blue-500 font-bold">Menu page</a></li>
                    </ol>

                    <br>

                    <p class="font-bold">Steps:</p>
                    <ol class="list-decimal list-inside">
                        <li>From the menu list, select the menu item that you desire.</li>
                        <li>Click on the <strong>Option</strong> field, and select one from the dropdown.</li>
                        <li>Click on the green <strong>Plus</strong> button.</li>
                        <li>The menu item will appear in <strong>Hoá đơn thanh toán</strong> (right side).</li>
                        <li>Repeat <strong>Step 1 - Step 3</strong> if you want to add more.</li>
                        <li>After you're finished, on <strong>Hoá đơn thanh toán</strong> section, click <strong>Submit</strong>.</li>
                    </ol>
                </div>
            </div>

            <div class="shadow-lg overflow-hidden">
                <div class="select-none accordion rounded-md flex flex-row items-center justify-between bg-green-800 text-white cursor-pointer px-10 py-3 w-full font-bold">
                    <p>How to check my order status?</p>
                    <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="panel rounded-b-md bg-gray-200 text-green-800 px-10 py-6 w-full hidden overflow-hidden">
                    
                    <p>You can access this from:</p>
                    <ol class="list-disc list-inside">
                        <li><a href="{{ route('home.customer') }}" class="text-blue-500 font-bold">Home page</a></li>
                        <li><a href="{{ route('menu.customer') }}" class="text-blue-500 font-bold">Menu page</a></li>
                    </ol>

                    <br>

                    <p class="font-bold">Steps:</p>
                    <ol class="list-decimal list-inside">
                        <li>On <strong>Hoá đơn thanh toán</strong> section, click the <strong>Đồ đã gọi</strong> button.</li>
                        <li>Look for the <strong>colored tag</strong> on the menu item.</li>
                        <li><strong>Pending</strong> means the menu item is currently being prepared.</li>
                        <li><strong>Đã giao món</strong> means your item has been cooked.</li>
                    </ol>

                </div>
            </div>

            <div class="shadow-lg overflow-hidden">
                <div class="select-none accordion rounded-md flex flex-row items-center justify-between bg-green-800 text-white cursor-pointer px-10 py-3 w-full font-bold">
                    <p>Where to find drinks section?</p>
                    <svg id="arrow3" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <div class="panel rounded-b-md bg-gray-200 text-green-800 px-10 py-6 w-full hidden overflow-hidden">
                    
                    <p class="font-bold">Steps:</p>
                    <ol class="list-decimal list-inside">
                        <li>Go to <a href="{{ route('menu.customer') }}" class="text-blue-500 font-bold">Menu</a> page.</li>
                        <li>Click on the <strong>Đồ uống</strong> button.</li>
                        <li>The Drink Menu should appear.</li>
                    </ol>

                </div>
            </div>
            
        </div>

        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {

                acc[i].addEventListener("click", function() {

                    if (this.classList.contains('bg-green-800')) {
                        this.classList.remove('bg-green-800');
                        this.classList.add('bg-green-700');
                    } else {
                        this.classList.remove('bg-green-700');
                        this.classList.add('bg-green-800');
                    }

                    var panel = this.nextElementSibling;
                    if (panel.classList.contains('hidden')) {
                        panel.classList.remove('hidden');
                    } else {
                        panel.classList.add('hidden');
                    }

                    var icon = this.lastElementChild;
                    if (icon.classList.contains('rotate-90')) {
                        icon.classList.remove('rotate-90');
                    } else {
                        icon.classList.add('rotate-90');
                    }

                });

            }

        </script>


    </div>

@endsection