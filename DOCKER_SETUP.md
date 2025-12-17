# 🐳 HƯỚNG DẪN SETUP DOCKER

## Yêu cầu
- Docker Desktop (Windows/Mac) hoặc Docker Engine (Linux)
- Docker Compose

## Các bước setup

### 1. Copy file environment
```bash
cp .env.docker.example .env
```

### 2. Generate application key
```bash
docker-compose run --rm artisan key:generate
```

### 3. Build và start containers
```bash
docker-compose up -d --build
```

### 4. Install dependencies
```bash
# Install PHP dependencies
docker-compose exec app composer install

# Install NPM dependencies (nếu cần)
docker-compose exec app npm install
```

### 5. Run migrations
```bash
docker-compose exec artisan migrate
```

### 6. Seed database (optional)
```bash
docker-compose exec artisan db:seed
```

### 7. Set permissions (Linux/Mac)
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

## Truy cập ứng dụng

- **Web:** http://localhost:8000
- **Database:** localhost:3306
  - Username: root
  - Password: root
  - Database: bear_1997_ttcs

## Các lệnh hữu ích

### Xem logs
```bash
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f db
```

### Chạy Artisan commands
```bash
docker-compose exec artisan migrate
docker-compose exec artisan db:seed
docker-compose exec artisan route:list
```

### Chạy Composer commands
```bash
docker-compose exec app composer install
docker-compose exec app composer update
```

### Vào container
```bash
docker-compose exec app bash
docker-compose exec db mysql -u root -p
```

### Stop containers
```bash
docker-compose down
```

### Stop và xóa volumes (xóa database)
```bash
docker-compose down -v
```

### Rebuild containers
```bash
docker-compose up -d --build --force-recreate
```

## Troubleshooting

### Lỗi permission
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Lỗi database connection
- Kiểm tra DB_HOST trong .env phải là `db` (tên service trong docker-compose)
- Đợi database khởi động xong (có thể mất vài giây)

### Clear cache
```bash
docker-compose exec artisan cache:clear
docker-compose exec artisan config:clear
docker-compose exec artisan route:clear
docker-compose exec artisan view:clear
```






