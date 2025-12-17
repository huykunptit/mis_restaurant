# 🐍 HƯỚNG DẪN TRIỂN KHAI MIS SERVICE VỚI DJANGO

## 📋 YÊU CẦU

- Python 3.9+
- MySQL 8.0
- Docker (optional)

---

## 🚀 SETUP PROJECT

### 1. Tạo Virtual Environment
```bash
mkdir mis-service
cd mis-service
python -m venv venv

# Windows
venv\Scripts\activate

# Linux/Mac
source venv/bin/activate
```

### 2. Install Dependencies
```bash
pip install django==4.2.7
pip install djangorestframework==3.14.0
pip install django-cors-headers==4.3.0
pip install mysqlclient==2.2.0  # hoặc PyMySQL nếu mysqlclient không cài được
pip install djangorestframework-simplejwt==5.3.0
pip install drf-spectacular==0.26.5
pip install pandas==2.1.3
pip install openpyxl==3.1.2
pip install python-decouple==3.8

# Tạo requirements.txt
pip freeze > requirements.txt
```

### 3. Tạo Django Project
```bash
django-admin startproject mis .
python manage.py startapp apps
cd apps
python ../manage.py startapp users
python ../manage.py startapp stores
python ../manage.py startapp products
python ../manage.py startapp banks
python ../manage.py startapp payments
python ../manage.py startapp invoices
python ../manage.py startapp reports
cd ..
```

---

## ⚙️ CẤU HÌNH SETTINGS

### mis/settings.py
```python
import os
from pathlib import Path
from decouple import config
from datetime import timedelta

BASE_DIR = Path(__file__).resolve().parent.parent

SECRET_KEY = config('SECRET_KEY', default='django-insecure-change-me')
DEBUG = config('DEBUG', default=True, cast=bool)
ALLOWED_HOSTS = ['*']

INSTALLED_APPS = [
    'django.contrib.admin',
    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',
    # Third party
    'rest_framework',
    'rest_framework_simplejwt',
    'corsheaders',
    'drf_spectacular',
    # Apps
    'apps.users',
    'apps.stores',
    'apps.products',
    'apps.banks',
    'apps.payments',
    'apps.invoices',
    'apps.reports',
]

MIDDLEWARE = [
    'django.middleware.security.SecurityMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
    'corsheaders.middleware.CorsMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
]

ROOT_URLCONF = 'mis.urls'

TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [],
        'APP_DIRS': True,
        'OPTIONS': {
            'context_processors': [
                'django.template.context_processors.debug',
                'django.template.context_processors.request',
                'django.contrib.auth.context_processors.auth',
                'django.contrib.messages.context_processors.messages',
            ],
        },
    },
]

WSGI_APPLICATION = 'mis.wsgi.application'

# Database
DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'NAME': config('DB_DATABASE', default='mis_db'),
        'USER': config('DB_USERNAME', default='root'),
        'PASSWORD': config('DB_PASSWORD', default='root'),
        'HOST': config('DB_HOST', default='localhost'),
        'PORT': config('DB_PORT', default='3306'),
        'OPTIONS': {
            'charset': 'utf8mb4',
        },
    }
}

# REST Framework
REST_FRAMEWORK = {
    'DEFAULT_AUTHENTICATION_CLASSES': (
        'rest_framework_simplejwt.authentication.JWTAuthentication',
    ),
    'DEFAULT_PERMISSION_CLASSES': (
        'rest_framework.permissions.IsAuthenticated',
    ),
    'DEFAULT_SCHEMA_CLASS': 'drf_spectacular.openapi.AutoSchema',
    'DEFAULT_PAGINATION_CLASS': 'rest_framework.pagination.PageNumberPagination',
    'PAGE_SIZE': 20,
}

# JWT Settings
SIMPLE_JWT = {
    'ACCESS_TOKEN_LIFETIME': timedelta(hours=1),
    'REFRESH_TOKEN_LIFETIME': timedelta(days=1),
    'ROTATE_REFRESH_TOKENS': True,
}

# CORS
CORS_ALLOWED_ORIGINS = [
    "http://localhost:8000",
    "http://localhost:3000",
]

# Spectacular (Swagger)
SPECTACULAR_SETTINGS = {
    'TITLE': 'MIS Service API',
    'DESCRIPTION': 'Management Information System API',
    'VERSION': '1.0.0',
}

# Internationalization
LANGUAGE_CODE = 'en-us'
TIME_ZONE = 'UTC'
USE_I18N = True
USE_TZ = True

# Static files
STATIC_URL = 'static/'
STATIC_ROOT = os.path.join(BASE_DIR, 'staticfiles')

# Media files
MEDIA_URL = 'media/'
MEDIA_ROOT = os.path.join(BASE_DIR, 'media')

DEFAULT_AUTO_FIELD = 'django.db.models.BigAutoField'
```

---

## 📦 MODELS

### apps/users/models.py
```python
from django.db import models

class Role(models.Model):
    name = models.CharField(max_length=50)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'roles'

    def __str__(self):
        return self.name

class User(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField(max_length=150, unique=True)
    password = models.CharField(max_length=255)
    phone = models.CharField(max_length=20, null=True, blank=True)
    role = models.ForeignKey(Role, on_delete=models.SET_NULL, null=True, db_column='role_id')
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'users'
        managed = False  # Nếu dùng database có sẵn

    def __str__(self):
        return self.name
```

### apps/products/models.py
```python
from django.db import models
from apps.stores.models import Store

class Product(models.Model):
    name = models.CharField(max_length=100)
    price = models.DecimalField(max_digits=10, decimal_places=2)
    stock = models.IntegerField(default=0)
    store = models.ForeignKey(Store, on_delete=models.CASCADE, db_column='store_id', null=True)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'products'

    def __str__(self):
        return self.name
```

---

## 🔄 SERIALIZERS

### apps/products/serializers.py
```python
from rest_framework import serializers
from apps.products.models import Product

class ProductSerializer(serializers.ModelSerializer):
    store_name = serializers.CharField(source='store.name', read_only=True)
    
    class Meta:
        model = Product
        fields = ['id', 'name', 'price', 'stock', 'store_id', 'store_name', 'created_at', 'updated_at']
        read_only_fields = ['created_at', 'updated_at']
```

---

## 🎮 VIEWS (ViewSets)

### apps/products/views.py
```python
from rest_framework import viewsets, permissions, filters
from rest_framework.decorators import action
from django_filters.rest_framework import DjangoFilterBackend
from apps.products.models import Product
from apps.products.serializers import ProductSerializer

class ProductViewSet(viewsets.ModelViewSet):
    queryset = Product.objects.select_related('store').all()
    serializer_class = ProductSerializer
    permission_classes = [permissions.IsAuthenticated]
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['store_id']
    search_fields = ['name']
    ordering_fields = ['name', 'price', 'created_at']
    ordering = ['-created_at']

    @action(detail=False, methods=['get'])
    def low_stock(self, request):
        """Sản phẩm sắp hết hàng"""
        products = self.queryset.filter(stock__lt=10)
        serializer = self.get_serializer(products, many=True)
        return Response(serializer.data)
```

---

## 🛣️ URLS

### apps/products/urls.py
```python
from django.urls import path, include
from rest_framework.routers import DefaultRouter
from apps.products.views import ProductViewSet

router = DefaultRouter()
router.register(r'products', ProductViewSet, basename='product')

urlpatterns = [
    path('', include(router.urls)),
]
```

### mis/urls.py
```python
from django.contrib import admin
from django.urls import path, include
from drf_spectacular.views import SpectacularAPIView, SpectacularSwaggerView

urlpatterns = [
    path('admin/', admin.site.urls),
    path('api/schema/', SpectacularAPIView.as_view(), name='schema'),
    path('api/docs/', SpectacularSwaggerView.as_view(url_name='schema'), name='swagger-ui'),
    path('api/auth/', include('apps.users.urls')),
    path('api/', include('apps.products.urls')),
    path('api/', include('apps.stores.urls')),
    path('api/', include('apps.banks.urls')),
    path('api/', include('apps.payments.urls')),
    path('api/', include('apps.invoices.urls')),
    path('api/', include('apps.reports.urls')),
]
```

---

## 🔐 AUTHENTICATION

### apps/users/views.py
```python
from rest_framework import status
from rest_framework.decorators import api_view, permission_classes
from rest_framework.permissions import AllowAny
from rest_framework.response import Response
from rest_framework_simplejwt.tokens import RefreshToken
from django.contrib.auth.hashers import check_password
from apps.users.models import User

@api_view(['POST'])
@permission_classes([AllowAny])
def login(request):
    email = request.data.get('email')
    password = request.data.get('password')
    
    try:
        user = User.objects.get(email=email)
        if check_password(password, user.password):
            refresh = RefreshToken.for_user(user)
            return Response({
                'access': str(refresh.access_token),
                'refresh': str(refresh),
                'user': {
                    'id': user.id,
                    'name': user.name,
                    'email': user.email,
                    'role_id': user.role_id,
                }
            })
        return Response({'error': 'Invalid credentials'}, status=status.HTTP_401_UNAUTHORIZED)
    except User.DoesNotExist:
        return Response({'error': 'User not found'}, status=status.HTTP_404_NOT_FOUND)
```

---

## 📊 REPORTING

### apps/reports/views.py
```python
from rest_framework.decorators import api_view, permission_classes
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response
from django.db.models import Sum, Count, Avg
from apps.invoices.models import Invoice
from apps.products.models import Product
import pandas as pd
from datetime import datetime, timedelta

@api_view(['GET'])
@permission_classes([IsAuthenticated])
def sales_report(request):
    """Báo cáo doanh thu"""
    start_date = request.query_params.get('start_date')
    end_date = request.query_params.get('end_date')
    
    queryset = Invoice.objects.all()
    
    if start_date:
        queryset = queryset.filter(created_at__gte=start_date)
    if end_date:
        queryset = queryset.filter(created_at__lte=end_date)
    
    # Tổng doanh thu
    total_revenue = queryset.aggregate(Sum('total'))['total__sum'] or 0
    
    # Doanh thu theo ngày
    daily_revenue = queryset.values('created_at__date').annotate(
        revenue=Sum('total')
    ).order_by('created_at__date')
    
    # Doanh thu theo cửa hàng
    store_revenue = queryset.values('store__name').annotate(
        revenue=Sum('total')
    ).order_by('-revenue')
    
    return Response({
        'total_revenue': total_revenue,
        'daily_revenue': list(daily_revenue),
        'store_revenue': list(store_revenue),
    })

@api_view(['GET'])
@permission_classes([IsAuthenticated])
def export_sales_excel(request):
    """Export báo cáo doanh thu ra Excel"""
    invoices = Invoice.objects.select_related('store', 'user').all()
    
    data = []
    for invoice in invoices:
        data.append({
            'ID': invoice.id,
            'Store': invoice.store.name if invoice.store else '',
            'User': invoice.user.name if invoice.user else '',
            'Total': float(invoice.total),
            'Date': invoice.created_at.strftime('%Y-%m-%d %H:%M:%S'),
        })
    
    df = pd.DataFrame(data)
    filename = f'sales_report_{datetime.now().strftime("%Y%m%d_%H%M%S")}.xlsx'
    filepath = f'media/{filename}'
    df.to_excel(filepath, index=False)
    
    return Response({'file': f'/media/{filename}'})
```

---

## 🐳 DOCKER SETUP

### Dockerfile
```dockerfile
FROM python:3.11-slim

WORKDIR /app

ENV PYTHONDONTWRITEBYTECODE=1
ENV PYTHONUNBUFFERED=1

RUN apt-get update && apt-get install -y \
    gcc \
    default-libmysqlclient-dev \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

COPY . .

EXPOSE 8000

CMD ["python", "manage.py", "runserver", "0.0.0.0:8000"]
```

### docker-compose.yml (cho MIS service)
```yaml
version: '3.8'

services:
  mis-app:
    build: .
    container_name: mis_app
    volumes:
      - .:/app
    ports:
      - "8001:8000"
    environment:
      - DB_HOST=mis-db
      - DB_DATABASE=mis_db
      - DB_USERNAME=root
      - DB_PASSWORD=root
    depends_on:
      - mis-db

  mis-db:
    image: mysql:8.0
    container_name: mis_db
    environment:
      MYSQL_DATABASE: mis_db
      MYSQL_ROOT_PASSWORD: root
    ports:
      - "3307:3306"
    volumes:
      - mis_db_data:/var/lib/mysql

volumes:
  mis_db_data:
```

---

## 🎯 DJANGO ADMIN SETUP

### apps/products/admin.py
```python
from django.contrib import admin
from apps.products.models import Product

@admin.register(Product)
class ProductAdmin(admin.ModelAdmin):
    list_display = ['name', 'price', 'stock', 'store', 'created_at']
    list_filter = ['store', 'created_at']
    search_fields = ['name']
    readonly_fields = ['created_at', 'updated_at']
    list_editable = ['price', 'stock']
    
    fieldsets = (
        ('Basic Information', {
            'fields': ('name', 'price', 'stock', 'store')
        }),
        ('Timestamps', {
            'fields': ('created_at', 'updated_at'),
            'classes': ('collapse',)
        }),
    )
```

### Tạo superuser
```bash
python manage.py createsuperuser
```

---

## ✅ CHECKLIST

- [ ] Setup Django project
- [ ] Configure database
- [ ] Create models
- [ ] Create serializers
- [ ] Create ViewSets
- [ ] Setup URLs
- [ ] Implement authentication
- [ ] Setup Django Admin
- [ ] Implement reporting APIs
- [ ] Docker setup
- [ ] Testing
- [ ] Documentation

---

## 📚 TÀI LIỆU THAM KHẢO

- [Django Documentation](https://docs.djangoproject.com/)
- [Django REST Framework](https://www.django-rest-framework.org/)
- [DRF Simple JWT](https://django-rest-framework-simplejwt.readthedocs.io/)
- [DRF Spectacular](https://drf-spectacular.readthedocs.io/)






