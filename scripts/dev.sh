#!/usr/bin/env bash
set -euo pipefail

# dev.sh - Build & run the stack, initialize Laravel, and build assets
# Usage: ./scripts/dev.sh

# Pull base images (optional, speeds up first build)
docker compose pull

# Rebuild images and start services
docker compose build
docker compose up -d

# Ensure Nginx re-resolves upstream after app restarts
docker compose restart nginx

SEED=${1:-}

# Generate app key and run migrations
docker compose exec app php artisan key:generate || true
docker compose exec app php artisan migrate

# Optional seeding: pass "--seed" to this script to seed sample data
if [[ "$SEED" == "--seed" ]]; then
	docker compose exec app php artisan db:seed || true
fi

# Install PHP dependencies (optimized)
docker compose exec app composer install --no-dev --optimize-autoloader

# Install JS deps and build assets with Laravel Mix
# Note: this project uses Mix, not Vite.
docker compose exec app npm install
# Production build (adjust to `npm run dev` for dev watching)
docker compose exec app npm run prod

# Optional: mark repo safe to suppress git ownership warning inside container
docker compose exec app git config --global --add safe.directory /var/www/html

# Show status and a quick health check
docker compose ps
curl -s http://localhost:8000 | head -20

echo "\n✅ Dev environment ready at http://localhost:8000"