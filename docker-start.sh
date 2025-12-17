#!/bin/bash

# Script to start Docker containers and setup Laravel

echo "🐳 Starting Docker containers..."

# Copy .env if not exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
fi

# Build and start containers
echo "🔨 Building and starting containers..."
docker-compose up -d --build

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
sleep 10

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
docker-compose exec -T app composer install --no-interaction

# Generate application key if not exists
echo "🔑 Generating application key..."
docker-compose exec -T app php artisan key:generate --force

# Run migrations
echo "🗄️ Running migrations..."
docker-compose exec -T app php artisan migrate --force

# Seed database
echo "🌱 Seeding database..."
docker-compose exec -T app php artisan db:seed --force

# Set permissions
echo "🔐 Setting permissions..."
docker-compose exec -T app chmod -R 775 storage bootstrap/cache
docker-compose exec -T app chown -R www-data:www-data storage bootstrap/cache

echo "✅ Setup complete!"
echo "🌐 Application is running at: http://localhost:8000"
echo "📊 Database is running on: localhost:3306"






