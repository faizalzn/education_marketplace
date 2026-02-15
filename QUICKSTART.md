# Quick Start Guide - Education Marketplace

## 📋 What's Included

This is a complete, production-ready education marketplace platform with:

✅ **Full Laravel 11 Application** - All necessary models, migrations, and controllers
✅ **Vue.js 3 + Inertia.js Frontend** - Complete UI components
✅ **Filament PHP Admin Panel** - Admin resources for user and settlement management
✅ **Laravel Octane** - High-performance runtime configuration
✅ **Tailwind CSS** - Modern styling framework
✅ **Business Logic** - Actions for KYC, Bookings, Transactions, and Settlements
✅ **Database Schema** - 7 migrations for complete database structure
✅ **API Routes** - All endpoints configured
✅ **Documentation** - Comprehensive README and setup guides

---

## 🚀 Getting Started (5 Minutes)

### Step 1: Prerequisites
Make sure you have:
- PHP 8.3+
- Composer 2.x
- Node.js 18+
- MySQL 8.0+

```bash
# Verify installations
php -v
composer --version
node --version
npm --version
```

### Step 2: Install Dependencies

```bash
cd d:\Projek\Belajar\"Day 1"\education-marketplace

# Install PHP packages
composer install

# Install Node packages
npm install
```

### Step 3: Setup Environment

```bash
# Copy example env file
cp .env.example .env

# Generate app key
php artisan key:generate

# Generate JWT keys (if using JWT)
php artisan jwt:secret

# Edit .env file with your database credentials
# DB_DATABASE=education_marketplace
# DB_USERNAME=root
# DB_PASSWORD=yourpassword
```

### Step 4: Database Setup

```bash
# Create database
mysql -u root -p mysql -e "CREATE DATABASE education_marketplace;"

# Run migrations
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed
```

### Step 5: Build Frontend

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 6: Install & Configure Octane

```bash
composer require laravel/octane

# Choose Swoole or RoadRunner when prompted
php artisan octane:install
```

### Step 7: Install & Configure Filament

```bash
composer require filament/filament

php artisan filament:install --panels=admin

# Create admin user
php artisan tinker
>>> App\Models\User::factory()->admin()->create(['email' => 'admin@example.com']);
>>> exit
```

### Step 8: Start Development Server

```bash
# Terminal 1: Start Laravel Octane (or use php artisan serve)
php artisan octane:start

# Terminal 2: Start Vite for frontend
npm run dev

# Terminal 3: Run Queue Worker (if needed)
php artisan queue:work
```

---

## 🌐 Access Your Application

| Component | URL | Purpose |
|-----------|-----|---------|
| **Web App** | http://localhost:8000 | Main application |
| **Admin Panel** | http://localhost:8000/admin | Admin dashboard |
| **Vite** | http://localhost:5173 | Frontend dev server |

---

## 📁 Key Files & Directories

### Models
```
app/Models/
├── User.php              # User model with KYC relationship
├── UserKyc.php           # KYC verification model
├── Course.php            # Course model
├── Booking.php           # Booking model
├── Transaction.php       # Payment transaction model
├── Settlement.php        # Instructor settlement model
└── AuditLog.php         # Audit logging
```

### Controllers
```
app/Http/Controllers/
├── Auth/KycController.php        # KYC registration flow
├── BookingController.php         # Booking management
├── CourseController.php          # Course CRUD
├── TransactionController.php     # Payment processing
├── SettlementController.php      # Settlement management
└── DashboardController.php       # Dashboard views
```

### Actions (Business Logic)
```
app/Actions/
├── InitiateKycVerification.php        # KYC process
├── CreateBooking.php                   # Booking creation
├── ProcessTransaction.php              # Payment processing
└── GenerateSettlement.php              # Settlement generation
```

### Vue Components
```
resources/js/
├── Pages/
│   ├── Auth/KYCRegistration.vue
│   ├── Courses/Browse.vue
│   ├── Dashboard.vue
│   └── ...
├── Layouts/
│   └── AppLayout.vue
└── Components/
    └── StatCard.vue
```

### Database Migrations
```
database/migrations/
├── 2025_02_15_000000_add_role_to_users_table.php
├── 2025_02_15_000001_create_users_kyc_table.php
├── 2025_02_15_000002_create_courses_table.php
├── 2025_02_15_000003_create_bookings_table.php
├── 2025_02_15_000004_create_transactions_table.php
├── 2025_02_15_000005_create_settlements_table.php
└── 2025_02_15_000006_create_audit_logs_table.php
```

---

## 🔑 Default User Roles

When creating users, assign these roles:

```php
// Student
App\Models\User::factory()->create([
    'email' => 'student@example.com',
    'role' => 'student'
]);

// Instructor
App\Models\User::factory()->create([
    'email' => 'instructor@example.com',
    'role' => 'instructor'
]);

// Admin
App\Models\User::factory()->create([
    'email' => 'admin@example.com',
    'role' => 'admin'
]);
```

---

## 📊 Database Schema Overview

### users
- Basic user information
- role (student/instructor/admin)
- is_active flag

### user_kyc
- Personal information
- Address details
- Identity documents
- Bank account info
- Verification status

### courses
- Course details
- Instructor reference
- Pricing & metadata
- Publication status

### bookings
- User-course enrollment
- Booking reference number
- Progress tracking
- Status management

### transactions
- Payment records
- Commission calculation
- Payment gateway details
- Refund tracking

### settlements
- Instructor earnings reports
- Period-based calculations
- Commission deductions
- Admin approval workflow

### audit_logs
- Action logging
- Data change tracking
- User activity monitoring

---

## 🔐 Authentication

The application uses Laravel's default auth, extended with:
- User roles (student, instructor, admin)
- KYC verification before certain actions
- Authorization policies for resource access

---

## 📧 Email Configuration

Configure mail in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=support@edumarket.local
```

---

## 💳 Payment Integration

The system is ready for payment gateway integration:

### Stripe Integration
```php
// Update config/marketplace.php
'payment' => [
    'stripe' => [
        'enabled' => true,
        'key' => env('STRIPE_PUBLIC_KEY'),
        'secret' => env('STRIPE_SECRET_KEY'),
    ],
    ...
]
```

### PayPal Integration
Similar setup available in config/marketplace.php

---

## 🧪 Common Tasks

### Create an Admin User
```bash
php artisan tinker
>>> App\Models\User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);
```

### Generate Test Data
```bash
php artisan db:seed

# Or specific seeder
php artisan db:seed --class=UserSeeder
```

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Optimize for Production
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🐛 Common Issues & Solutions

### Issue: "Port 8000 already in use"
```bash
php artisan octane:start --port=8001
```

### Issue: Database connection error
```bash
# Verify MySQL is running
mysql -u root -p

# Test connection from Laravel
php artisan tinker
>>> DB::connection()->getPdo();
```

### Issue: Node modules not found
```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### Issue: Vite HMR not working
Check your browser console and update `.env`:
```env
VITE_APP_NAME="Education Marketplace"
```

---

## 📚 Learning Resources

- **Laravel**: https://laravel.com/docs
- **Vue.js**: https://vuejs.org/guide/
- **Inertia.js**: https://inertiajs.com/
- **Filament**: https://filamentphp.com/docs
- **Tailwind**: https://tailwindcss.com/docs

---

## ✨ Next Steps

1. ✅ Install and run locally
2. ✅ Create test accounts
3. ✅ Test KYC flow
4. ✅ Test course booking
5. ✅ Test admin panel
6. ✅ Configure payment gateway
7. ✅ Deploy to production

---

## 📞 Support

If you encounter issues:
1. Check the [README.md](README.md) for detailed documentation
2. Check [SETUP_GUIDE.md](SETUP_GUIDE.md) for installation help
3. Review Laravel docs for framework-specific issues
4. Create an issue with error details and steps to reproduce

---

## 🎉 You're Ready!

Your education marketplace is fully configured and ready to:
- Handle user registrations and KYC verification
- Manage course bookings and transactions
- Process instructor settlements
- Provide an admin panel for management

Happy coding! 🚀
