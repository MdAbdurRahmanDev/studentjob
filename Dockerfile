# =========================
# Frontend build
# =========================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.* ./
COPY postcss.config.* ./
COPY tailwind.config.* ./

RUN npm run build


# =========================
# Laravel application
# =========================
FROM php:8.3-cli

WORKDIR /app

# Your existing PHP extensions/packages/etc.
# ...

COPY . .

# Copy compiled Vite assets
COPY --from=frontend /app/public/build ./public/build

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

RUN php artisan optimize
