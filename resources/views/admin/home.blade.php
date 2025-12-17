@extends('layout.app')

@php $pagename = "Dashboard" @endphp

@section('title')
    Bảng điều khiển Admin
@endsection

@section('content')
<div class="p-6 lg:p-10 bg-gray-50 min-h-screen">
    
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Bảng điều khiển</h1>
        <p class="text-gray-600">Chào mừng trở lại, {{ auth()->user()->first_name }}!</p>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Total Orders Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Tổng đơn hàng</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
                    <p class="text-xs text-gray-500 mt-2">Đơn chưa thanh toán</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Orders Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Đơn chờ xử lý</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
                    <p class="text-xs text-gray-500 mt-2">Cần xử lý ngay</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Today Revenue Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Doanh thu hôm nay</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($todayRevenue, 0) }}</p>
                    <p class="text-xs text-gray-500 mt-2">VNĐ</p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Revenue Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Tổng doanh thu</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($totalRevenue, 0) }}</p>
                    <p class="text-xs text-gray-500 mt-2">VNĐ</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- Secondary Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        {{-- Users Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Người dùng</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tổng người dùng</span>
                    <span class="font-bold text-gray-800">{{ $totalUsers }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Khách hàng</span>
                    <span class="font-bold text-blue-600">{{ $totalCustomers }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Nhân viên</span>
                    <span class="font-bold text-green-600">{{ $totalStaff }}</span>
                </div>
            </div>
        </div>

        {{-- Menu Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Menu</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tổng món</span>
                    <span class="font-bold text-gray-800">{{ $totalMenuItems }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Đang hoạt động</span>
                    <span class="font-bold text-green-600">{{ $activeMenuItems }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Đã vô hiệu</span>
                    <span class="font-bold text-red-600">{{ $totalMenuItems - $activeMenuItems }}</span>
                </div>
            </div>
        </div>

        {{-- Orders Status Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Trạng thái đơn</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Chờ xử lý</span>
                    <span class="font-bold text-yellow-600">{{ $pendingOrders }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Đã hoàn thành</span>
                    <span class="font-bold text-green-600">{{ $completedOrders }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tổng đơn</span>
                    <span class="font-bold text-gray-800">{{ $totalOrders }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Quick Actions & Recent Orders --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Quick Actions --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Thao tác nhanh</h3>
                <div class="space-y-3">
                    <a href="{{ route('orders.admin') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Xem đơn hàng</span>
                    </a>
                    <a href="{{ route('menu.index') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Thêm món mới</span>
                    </a>
                    <a href="{{ route('user.index') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Quản lý người dùng</span>
                    </a>
                    <a href="{{ route('tables.index') }}" class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span>Quản lý bàn</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Đơn hàng gần đây</h3>
                    <a href="{{ route('orders.admin') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Xem tất cả →</a>
                </div>
                @if($recentOrders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Món</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentOrders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->user->first_name ?? 'N/A' }} {{ $order->user->last_name ?? '' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                        {{ $order->menu->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                        {{ $order->quantity }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($order->completion_status == 'yes')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Hoàn thành</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Chờ xử lý</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-gray-500">Chưa có đơn hàng nào</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection
