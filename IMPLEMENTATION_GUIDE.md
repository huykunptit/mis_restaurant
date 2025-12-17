# 📘 HƯỚNG DẪN TRIỂN KHAI CHI TIẾT

## 🎯 TỔNG QUAN

Tài liệu này hướng dẫn chi tiết từng bước để tách project Laravel thành 2 microservices.

---

## 📅 TIMELINE DỰ KIẾN

- **Phase 1:** Dockerize (1-2 ngày) ✅
- **Phase 2:** Tách Database (1 ngày)
- **Phase 3:** E-commerce Service (2-3 ngày)
- **Phase 4:** MIS Service (3-4 ngày)
- **Phase 5:** Service Communication (1-2 ngày)
- **Phase 6:** Testing & Documentation (1-2 ngày)

**Tổng:** 9-14 ngày

---

## 🔧 PHASE 1: DOCKERIZE (ĐÃ HOÀN THÀNH)

### Đã làm:
- ✅ Tạo Dockerfile
- ✅ Tạo docker-compose.yml
- ✅ Cấu hình Nginx
- ✅ Cấu hình PHP
- ✅ Tạo .dockerignore
- ✅ Tạo hướng dẫn setup

### Cần test:
```bash
# 1. Copy .env
cp .env.docker.example .env

# 2. Build và start
docker-compose up -d --build

# 3. Generate key
docker-compose run --rm artisan key:generate

# 4. Install dependencies
docker-compose exec app composer install

# 5. Run migrations
docker-compose exec artisan migrate

# 6. Seed
docker-compose exec artisan db:seed
```

---

## 🗄️ PHASE 2: TÁCH DATABASE

### Bước 1: Tạo migration scripts

#### E-commerce Database Migration:
```sql
-- File: database/migrations/ecommerce/create_ecommerce_database.sql
CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

-- Import từ project hiện tại nhưng chỉ các tables cần thiết
```

#### MIS Database Migration:
```sql
-- File: database/migrations/mis/create_mis_database.sql
CREATE DATABASE IF NOT EXISTS mis_db;
USE mis_db;

-- Import tất cả tables
```

### Bước 2: Update docker-compose.yml
Thêm 2 database services riêng biệt:
- `ecommerce-db` (MySQL)
- `mis-db` (MySQL)

### Bước 3: Update .env files
- `.env.ecommerce` cho E-commerce service
- `.env.mis` cho MIS service

---

## 🛒 PHASE 3: E-COMMERCE SERVICE

### Bước 1: Giữ lại Laravel project hiện tại
- Giữ nguyên cấu trúc Laravel
- Xóa các routes/controllers không cần thiết

### Bước 2: Tạo Models
```php
// app/Models/Product.php
// app/Models/Store.php
// app/Models/Invoice.php
// app/Models/InvoiceDetail.php
// app/Models/Payment.php
// app/Models/Bank.php
```

### Bước 3: Tạo Controllers
```php
// app/Http/Controllers/Api/AuthController.php
// app/Http/Controllers/Api/ProductController.php
// app/Http/Controllers/Api/StoreController.php
// app/Http/Controllers/Api/OrderController.php (Invoice)
```

### Bước 4: Tạo API Routes
```php
// routes/api.php
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/stores', [StoreController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
});
```

### Bước 5: Implement Business Logic
- Authentication với Sanctum
- Product listing với pagination
- Order creation với validation
- Stock management

---

## 📊 PHASE 4: MIS SERVICE (DJANGO)

### Bước 1: Tạo Django Project
```bash
mkdir mis-service
cd mis-service
python -m venv venv
source venv/bin/activate  # Windows: venv\Scripts\activate
pip install django djangorestframework django-cors-headers mysqlclient djangorestframework-simplejwt drf-spectacular pandas openpyxl python-decouple
django-admin startproject mis .
python manage.py startapp users
python manage.py startapp stores
python manage.py startapp products
python manage.py startapp banks
python manage.py startapp payments
python manage.py startapp invoices
python manage.py startapp reports
```

### Bước 2: Cấu trúc Project
```
mis-service/
├── manage.py
├── requirements.txt
├── Dockerfile
├── docker-compose.yml
├── mis/
│   ├── __init__.py
│   ├── settings.py
│   ├── urls.py
│   ├── wsgi.py
│   └── asgi.py
├── apps/
│   ├── users/
│   │   ├── models.py
│   │   ├── views.py
│   │   ├── serializers.py
│   │   ├── admin.py  # Django Admin
│   │   └── urls.py
│   ├── stores/
│   ├── products/
│   ├── banks/
│   ├── payments/
│   ├── invoices/
│   └── reports/
├── static/
└── media/
```

### Bước 3: Setup Settings
```python
# mis/settings.py
INSTALLED_APPS = [
    'django.contrib.admin',
    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',
    'rest_framework',
    'rest_framework_simplejwt',
    'corsheaders',
    'drf_spectacular',
    'apps.users',
    'apps.stores',
    'apps.products',
    'apps.banks',
    'apps.payments',
    'apps.invoices',
    'apps.reports',
]

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'NAME': os.getenv('DB_DATABASE'),
        'USER': os.getenv('DB_USERNAME'),
        'PASSWORD': os.getenv('DB_PASSWORD'),
        'HOST': os.getenv('DB_HOST', 'db'),
        'PORT': os.getenv('DB_PORT', '3306'),
    }
}

REST_FRAMEWORK = {
    'DEFAULT_AUTHENTICATION_CLASSES': (
        'rest_framework_simplejwt.authentication.JWTAuthentication',
    ),
    'DEFAULT_PERMISSION_CLASSES': (
        'rest_framework.permissions.IsAuthenticated',
    ),
    'DEFAULT_SCHEMA_CLASS': 'drf_spectacular.openapi.AutoSchema',
}
```

### Bước 4: Tạo Models
```python
# apps/users/models.py
from django.db import models

class Role(models.Model):
    name = models.CharField(max_length=50)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    def __str__(self):
        return self.name

class User(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField(max_length=150, unique=True)
    password = models.CharField(max_length=255)
    phone = models.CharField(max_length=20, null=True, blank=True)
    role = models.ForeignKey(Role, on_delete=models.SET_NULL, null=True)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    def __str__(self):
        return self.name
```

### Bước 5: Tạo Serializers
```python
# apps/products/serializers.py
from rest_framework import serializers
from apps.products.models import Product

class ProductSerializer(serializers.ModelSerializer):
    store_name = serializers.CharField(source='store.name', read_only=True)
    
    class Meta:
        model = Product
        fields = ['id', 'name', 'price', 'stock', 'store_id', 'store_name', 'created_at', 'updated_at']
```

### Bước 6: Implement Views (ViewSets)
```python
# apps/products/views.py
from rest_framework import viewsets, permissions
from rest_framework.decorators import action
from apps.products.models import Product
from apps.products.serializers import ProductSerializer

class ProductViewSet(viewsets.ModelViewSet):
    queryset = Product.objects.all()
    serializer_class = ProductSerializer
    permission_classes = [permissions.IsAuthenticated]
    
    def get_queryset(self):
        queryset = Product.objects.select_related('store')
        store_id = self.request.query_params.get('store_id')
        if store_id:
            queryset = queryset.filter(store_id=store_id)
        return queryset
```

### Bước 7: Setup URLs
```python
# apps/products/urls.py
from django.urls import path, include
from rest_framework.routers import DefaultRouter
from apps.products.views import ProductViewSet

router = DefaultRouter()
router.register(r'products', ProductViewSet)

urlpatterns = [
    path('', include(router.urls)),
]

# mis/urls.py
urlpatterns = [
    path('admin/', admin.site.urls),
    path('api/', include('apps.products.urls')),
    path('api/', include('apps.stores.urls')),
    # ... other apps
]
```

### Bước 8: Setup Django Admin
```python
# apps/products/admin.py
from django.contrib import admin
from apps.products.models import Product

@admin.register(Product)
class ProductAdmin(admin.ModelAdmin):
    list_display = ['name', 'price', 'stock', 'store', 'created_at']
    list_filter = ['store', 'created_at']
    search_fields = ['name']
    readonly_fields = ['created_at', 'updated_at']
```

### Bước 9: Implement Reporting APIs
```python
# apps/reports/views.py
from rest_framework.decorators import api_view, permission_classes
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response
from django.db.models import Sum, Count
from apps.invoices.models import Invoice
import pandas as pd

@api_view(['GET'])
@permission_classes([IsAuthenticated])
def sales_report(request):
    # Tổng doanh thu theo thời gian
    invoices = Invoice.objects.values('created_at__date').annotate(
        total=Sum('total')
    )
    return Response(invoices)
```
```

---

## 🔗 PHASE 5: SERVICE COMMUNICATION

### Bước 1: Setup API Gateway với Nginx
```nginx
# nginx/nginx.conf
upstream ecommerce {
    server ecommerce-app:9000;
}

upstream mis {
    server mis-app:3000;
}

server {
    listen 80;
    
    location /api/ecommerce/ {
        proxy_pass http://ecommerce/;
    }
    
    location /api/mis/ {
        proxy_pass http://mis/;
    }
}
```

### Bước 2: Implement Service-to-Service Communication
```javascript
// E-commerce service: Sync products from MIS
// src/services/syncService.js
const axios = require('axios');

exports.syncProducts = async () => {
  try {
    const response = await axios.get('http://mis-app:3000/api/products');
    // Update local products table
  } catch (error) {
    console.error('Sync failed:', error);
  }
};
```

### Bước 3: Event-Driven Communication (Optional)
- Sử dụng Redis Pub/Sub
- Hoặc Message Queue (RabbitMQ, Kafka)

---

## ✅ PHASE 6: TESTING & DOCUMENTATION

### Testing:
1. Unit Tests (PHPUnit cho Laravel, Jest cho Node.js)
2. Integration Tests
3. API Tests (Postman/Newman)

### Documentation:
1. API Documentation (Swagger/OpenAPI)
2. Setup Guide
3. Deployment Guide
4. Architecture Diagram

---

## 🚀 DEPLOYMENT

### Development:
```bash
docker-compose up -d
```

### Production:
- Docker Swarm
- Kubernetes
- CI/CD Pipeline

---

## 📝 NOTES

- Đảm bảo data consistency giữa 2 services
- Implement proper error handling
- Add logging và monitoring
- Security: Rate limiting, CORS, Input validation
- Performance: Caching, Database indexing

