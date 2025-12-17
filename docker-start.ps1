# PowerShell script to start Docker containers and setup Laravel

Write-Host "🐳 Starting Docker containers..." -ForegroundColor Cyan

# Copy .env if not exists
if (-not (Test-Path .env)) {
    Write-Host "📝 Creating .env file from .env.example..." -ForegroundColor Yellow
    Copy-Item .env.example .env
}

# Build and start containers
Write-Host "🔨 Building and starting containers..." -ForegroundColor Cyan
docker-compose up -d --build

# Wait for database to be ready
Write-Host "⏳ Waiting for database to be ready..." -ForegroundColor Yellow
Start-Sleep -Seconds 15

# Install PHP dependencies
Write-Host "📦 Installing PHP dependencies..." -ForegroundColor Cyan
docker-compose exec -T app composer install --no-interaction

# Generate application key if not exists
Write-Host "🔑 Generating application key..." -ForegroundColor Cyan
docker-compose exec -T app php artisan key:generate --force

# Run migrations
Write-Host "🗄️ Running migrations..." -ForegroundColor Cyan
docker-compose exec -T app php artisan migrate --force

# Seed database
Write-Host "🌱 Seeding database..." -ForegroundColor Cyan
docker-compose exec -T app php artisan db:seed --force

# Set permissions (Linux/Mac only, skip on Windows)
Write-Host "✅ Setup complete!" -ForegroundColor Green
Write-Host "🌐 Application is running at: http://localhost:8000" -ForegroundColor Green
Write-Host "📊 Database is running on: localhost:3306" -ForegroundColor Green






