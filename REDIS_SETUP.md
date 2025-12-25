# 🔴 REDIS BROADCASTING SETUP

## 📋 Yêu cầu

1. Redis server đã được cài đặt và chạy
2. Laravel đã có Redis driver

## 🔧 Setup Steps

### 1. Kiểm tra Redis đã chạy

```bash
# Kiểm tra Redis container (nếu dùng Docker)
docker ps | grep redis

# Hoặc test Redis connection
docker exec restaurant_redis redis-cli ping
# Kết quả: PONG
```

### 2. Cập nhật .env

```env
BROADCAST_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Install Predis (nếu chưa có)

```bash
composer require predis/predis
```

### 4. Cấu hình Broadcasting

File `config/broadcasting.php` đã có sẵn Redis config:

```php
'redis' => [
    'driver' => 'redis',
    'connection' => 'default',
],
```

### 5. Queue Configuration (cho broadcasting)

Cập nhật `.env`:

```env
QUEUE_CONNECTION=redis
```

### 6. Chạy Queue Worker

```bash
# Trong Docker container
docker exec restaurant_app php artisan queue:work redis --tries=3

# Hoặc chạy background
docker exec -d restaurant_app php artisan queue:work redis --tries=3
```

### 7. Frontend - Laravel Echo với Redis

Cài đặt dependencies:

```bash
npm install --save laravel-echo socket.io-client
```

Cập nhật `resources/js/bootstrap.js`:

```javascript
import Echo from 'laravel-echo';
import io from 'socket.io-client';

window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    // Hoặc dùng Redis với Socket.IO server
});
```

### 8. Alternative: Dùng Laravel WebSockets (Recommended)

Laravel WebSockets là package tốt hơn cho Redis broadcasting:

```bash
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
```

Cấu hình `config/websockets.php`:

```php
'apps' => [
    [
        'id' => env('PUSHER_APP_ID'),
        'name' => env('APP_NAME'),
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'enable_client_messages' => false,
        'enable_statistics' => true,
    ],
],
```

Chạy WebSocket server:

```bash
php artisan websockets:serve
```

### 9. Frontend với Laravel Echo + WebSockets

```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

// Listen to events
window.Echo.channel('orders')
    .listen('.order.created', (e) => {
        console.log('New order:', e);
        // Update notifications
        loadNotifications();
        loadUnreadCount();
    });

window.Echo.channel('payments')
    .listen('.payment.success', (e) => {
        console.log('Payment success:', e);
        // Update notifications
        loadNotifications();
        loadUnreadCount();
    });
```

### 10. Enable Broadcasting trong Events

Events đã được setup sẵn:
- ✅ `NewOrderCreated` - implements `ShouldBroadcast`
- ✅ `PaymentSuccess` - implements `ShouldBroadcast`

Chỉ cần uncomment code broadcasting trong controllers.

## 🚀 Quick Start (Minimal Setup)

Nếu chỉ muốn test nhanh với polling (không cần real-time thật):

1. Giữ nguyên polling (10 giây) trong `layout/app.blade.php`
2. Không cần setup WebSockets
3. Notifications vẫn hoạt động bình thường

## 📝 Notes

- Redis broadcasting cần queue worker chạy
- Frontend cần Laravel Echo để listen events
- Có thể dùng Laravel WebSockets thay vì Pusher
- Polling (hiện tại) vẫn hoạt động tốt cho notifications

---

**Tạo bởi**: AI Assistant  
**Ngày**: 2025-12-21

