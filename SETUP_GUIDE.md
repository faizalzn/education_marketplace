# Education Marketplace Service - Setup Guide

## Project Overview
A private education marketplace service with KYC verification, booking flows, and settlement system built with:
- **Backend**: Laravel 11
- **Frontend**: Vue.js 3 + Inertia.js
- **Admin Panel**: Filament PHP
- **Runtime**: Laravel Octane
- **Styling**: Tailwind CSS

## Installation Steps

### 1. Fix Network Connectivity (if experiencing issues)
```bash
# Clear composer cache
composer clear-cache

# Update composer
composer self-update
```

### 2. Install Backend Dependencies
```bash
cd education-marketplace

# Install Inertia.js
composer require laravel/inertia-laravel

# Install Filament
composer require filament/filament

# Install Laravel Octane
composer require laravel/octane

# Install additional utilities
composer require spatie/laravel-medialibrary spatie/laravel-query-builder
```

### 3. Install Frontend Dependencies
```bash
npm install

# Install Vue.js 3 and Inertia packages
npm install vue @inertiajs/vue3 @vitejs/plugin-vue axios

# Install Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Install UI components
npm install @headlessui/vue @heroicons/vue
```

### 4. Publish Package Assets
```bash
# Publish Inertia.js middleware and config
php artisan inertia:middleware

# Publish Filament assets
php artisan filament:install --panels=admin

# Publish Octane
php artisan octane:install
```

### 5. Database Setup
```bash
# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed test data
php artisan db:seed
```

### 6. Build Frontend
```bash
npm run build
```

### 7. Run Development Server
```bash
# Using Octane (recommended for production-like environment)
php artisan octane:start

# Or traditional development server
php artisan serve
```

## Project Structure
```
education-marketplace/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── UserKYC.php
│   │   ├── Booking.php
│   │   ├── Course.php
│   │   ├── Settlement.php
│   │   └── Transaction.php
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Actions/
│   ├── Events/
│   └── Notifications/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── web.php
│   └── api.php
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   ├── Components/
│   │   └── Layouts/
│   ├── views/
│   └── css/
├── config/
│   ├── inertia.php
│   └── octane.php
├── storage/
└── tests/
```

## Key Features to Implement

### 1. User Registration & KYC Verification
- Step 1: Email Registration
- Step 2: Identity Verification (Government ID)
- Step 3: Address Verification
- Step 4: Bank Account Verification
- Step 5: Face Recognition/Liveness Check

### 2. Booking Flow
- Browse and search courses
- Add to cart
- Checkout
- Payment processing
- Booking confirmation

### 3. Settlement System
- Transaction tracking
- Commission calculation
- Instructor payouts
- Settlement schedules

## Package Versions
- Laravel 11.x
- Vue.js 3.x
- Inertia.js 2.x
- Filament 3.x
- Laravel Octane 2.x
- Tailwind CSS 3.x

## Next Steps
After completing the installation steps, refer to individual feature documentation in the `docs/` directory.
