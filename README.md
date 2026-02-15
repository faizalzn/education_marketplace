# Education Marketplace Service - Complete Documentation

A comprehensive private education marketplace platform built with Laravel, Vue.js, Inertia.js, Filament PHP, and Laravel Octane.

## 🚀 Features

### 1. **User Registration & KYC (Know Your Customer) Verification**
- Multi-step registration process
- Email verification
- Identity document upload (Passport, National ID, Driver's License)
- Address verification with proof documents
- Bank account verification
- Facial recognition/liveness detection
- Admin review and approval system
- Automatic KYC status updates

### 2. **Course Booking Flow**
- Browse available courses with advanced filtering
- Course categorization (Programming, Business, Design, Languages, etc.)
- Course ratings and student reviews
- Shopping cart functionality
- One-click booking
- Booking confirmation and details tracking
- Progress tracking for enrolled courses
- Course completion certificates

### 3. **Payment & Transaction Processing**
- Multiple payment methods (Credit Card, Debit Card, Bank Transfer, E-Wallet)
- Automatic commission calculation (default 15%)
- Transaction tracking and history
- Payment gateway integration (Stripe, PayPal - ready for implementation)
- Refund processing
- Transaction receipts and invoices

### 4. **Settlement & Payout System**
- Automated settlement periods (Weekly, Bi-weekly, Monthly)
- Commission deduction and balance calculation
- Instructor earnings dashboard
- Settlement status tracking (Pending → Approved → Processing → Completed)
- Admin approval workflows
- Dispute resolution tracking
- Payment history and analytics

### 5. **Admin Panel (Filament PHP)**
- User management and role assignment
- KYC verification review and approval
- Course moderation
- Transaction monitoring
- Settlement processing and payouts
- Financial reporting and analytics
- Audit logging

## 📦 Tech Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| **Backend** | Laravel | 11.x |
| **Frontend** | Vue.js | 3.x |
| **UI Framework** | Inertia.js | 2.x |
| **Admin Panel** | Filament PHP | 3.x |
| **Runtime** | Laravel Octane | 2.x |
| **Styling** | Tailwind CSS | 3.x |
| **Server** | Swoole/RoadRunner | Latest |
| **Database** | MySQL/PostgreSQL | - |
| **Package Manager** | Composer/NPM | Latest |

## 🔧 Prerequisites

- PHP 8.3+
- Composer 2.x
- Node.js 18+ & NPM
- MySQL 8.0+ or PostgreSQL 12+
- Laravel CLI (optional but recommended)

## 📥 Installation

### 1. Clone and Setup

```bash
# Navigate to project directory
cd education-marketplace

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Update `.env` with your configuration:

```env
APP_NAME="Education Marketplace"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=education_marketplace
DB_USERNAME=root
DB_PASSWORD=

MAIL_DRIVER=smtp
MAIL_FROM_ADDRESS=support@edumarket.local

# Marketplace Configuration
PLATFORM_COMMISSION_RATE=0.15
MIN_INSTRUCTOR_PAYOUT=50
SETTLEMENT_PERIOD=monthly

# Payment Gateways
STRIPE_ENABLED=false
STRIPE_PUBLIC_KEY=
STRIPE_SECRET_KEY=
```

### 3. Database Setup

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE education_marketplace;"

# Run migrations
php artisan migrate

# Seed sample data
php artisan db:seed
```

### 4. Build Frontend Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 5. Install & Configure Octane

```bash
# Install Octane
composer require laravel/octane

# Publish Octane configuration
php artisan octane:install

# Choose runtime: swoole or roadrunner
```

### 6. Install & Configure Filament

```bash
# Install Filament
composer require filament/filament

# Publish Filament assets
php artisan filament:install --panels=admin

# Create admin user (if seeder isn't used)
php artisan tinker
# Then run: App\Models\User::factory()->create(['role' => 'admin']);
```

## 🚀 Running the Application

### Development Mode

```bash
# Using Octane (Recommended)
php artisan octane:start

# Or traditional development server
php artisan serve

# In another terminal, run frontend build watcher
npm run dev
```

### Production Mode

```bash
# Build frontend assets
npm run build

# Start Octane server
php artisan octane:start --host=0.0.0.0 --port=8000 --workers=4

# Or use supervisor for process management
```

## 📖 Project Structure

```
education-marketplace/
├── app/
│   ├── Actions/              # Business logic actions
│   │   ├── InitiateKycVerification.php
│   │   ├── CreateBooking.php
│   │   ├── ProcessTransaction.php
│   │   └── GenerateSettlement.php
│   ├── Http/
│   │   ├── Controllers/       # API/Web controllers
│   │   ├── Middleware/        # Custom middleware
│   │   └── Requests/          # Form requests & validation
│   ├── Models/                # Eloquent models
│   │   ├── User.php
│   │   ├── UserKyc.php
│   │   ├── Course.php
│   │   ├── Booking.php
│   │   ├── Transaction.php
│   │   ├── Settlement.php
│   │   └── AuditLog.php
│   ├── Policies/              # Authorization policies
│   ├── Filament/Resources/    # Admin panel resources
│   ├── Events/                # Application events
│   ├── Notifications/         # Email/SMS notifications
│   └── Services/              # Business logic services
├── database/
│   ├── migrations/            # Database migrations
│   ├── seeders/               # Database seeders
│   └── factories/             # Model factories for testing
├── resources/
│   ├── js/
│   │   ├── Pages/             # Inertia pages (Vue components)
│   │   ├── Layouts/           # Shared layouts
│   │   ├── Components/        # Reusable Vue components
│   │   ├── app.js             # Vue app entry point
│   │   └── bootstrap.js       # Initialization
│   ├── css/
│   │   ├── app.css            # Global styles
│   │   └── tailwind.css       # Tailwind imports
│   └── views/
│       └── app.blade.php      # Root Inertia layout
├── routes/
│   ├── web.php                # Web routes
│   └── api.php                # API routes
├── config/
│   ├── marketplace.php        # Marketplace settings
│   ├── inertia.php            # Inertia configuration
│   ├── octane.php             # Octane configuration
│   └── ...other configs
├── storage/
│   ├── app/                   # File storage
│   ├── logs/                  # Application logs
│   └── ...
└── tests/                      # Test suite
```

## 🔑 Key Workflows

### 1. User Registration & KYC Flow

```
User Registration
    ↓
Email Verification
    ↓
Step 1: Personal Information
    ↓
Step 2: Address Verification
    ↓
Step 3: Identity Document Upload
    ↓
Step 4: Bank Account Details
    ↓
Step 5: Face Recognition
    ↓
Submit for Admin Review
    ↓
Admin Approval/Rejection
    ↓
Account Activation
```

### 2. Booking Flow

```
Browse Courses
    ↓
View Course Details
    ↓
Add to Cart (if applicable)
    ↓
Proceed to Checkout
    ↓
Select Payment Method
    ↓
Process Payment
    ↓
Create Transaction Record
    ↓
Booking Confirmation
    ↓
Access Course Content
    ↓
Track Progress
    ↓
Complete Course
```

### 3. Settlement Flow

```
Monthly Period Ends
    ↓
System Generates Settlement Report
    ↓
Calculate Total Earnings & Commissions
    ↓
Factor in Refunds & Disputes
    ↓
Submit for Admin Review
    ↓
Admin Approves/Rejects
    ↓
Process Payment (if approved)
    ↓
Update Instructor Wallet
    ↓
Send Settlement Confirmation
```

## 🔐 User Roles

### Student
- Browse and book courses
- Complete KYC verification
- Track course progress
- View transaction history
- Leave reviews and ratings

### Instructor
- Create and manage courses
- View student enrollments
- Track earnings
- Request settlements
- Complete KYC verification

### Admin
- User management
- KYC verification review
- Course moderation
- Transaction oversight
- Settlement approval and processing
- Financial reporting
- System configuration

## 🎯 API Endpoints

### Authentication
- `POST /login` - User login
- `POST /register` - User registration
- `POST /logout` - User logout
- `GET /me` - Current user info

### Courses
- `GET /courses` - List courses
- `GET /courses/{id}` - Get course details
- `POST /courses` - Create course (instructor)
- `PUT /courses/{id}` - Update course (instructor)
- `DELETE /courses/{id}` - Delete course (instructor)

### Bookings
- `GET /bookings` - List user bookings
- `GET /bookings/{id}` - Get booking details
- `POST /bookings` - Create booking
- `POST /bookings/{id}/cancel` - Cancel booking

### Transactions
- `GET /transactions/{id}` - Get transaction details
- `POST /transactions` - Create transaction
- `POST /transactions/{id}/refund` - Refund transaction

### Settlements
- `GET /settlements` - List settlements (instructor)
- `GET /settlements/{id}` - Get settlement details
- `POST /settlements/generate` - Generate settlement (instructor)
- `POST /settlements/{id}/approve` - Approve settlement (admin)
- `POST /settlements/{id}/pay` - Pay settlement (admin)

## 📧 Notifications

The system sends notifications for:
- Email verification
- KYC status updates
- Booking confirmations
- Payment confirmations
- Settlement approvals/rejections
- Course enrollment expiration

## 📊 Admin Dashboard Features

- User statistics and analytics
- Financial reports
- KYC approval queue
- Recent transactions
- Settlement pending approvals
- Course performance metrics
- System health monitoring

## 🛠️ Maintenance

### Database Optimization

```bash
# Run migrations
php artisan migrate

# Optimize autoloader
composer dump-autoload --optimize

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache
```

### Clear Caches

```bash
# Clear all caches
php artisan cache:clear

# Clear specific cache
php artisan cache:clear --tags=kyc
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookingTest.php

# Generate coverage report
phpunit --coverage-html=coverage
```

## 📝 Environment Variables Reference

```env
# Application
APP_NAME=Education Marketplace
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=education_marketplace
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=support@edumarket.local
MAIL_FROM_NAME="${APP_NAME}"

# Marketplace Settings
PLATFORM_COMMISSION_RATE=0.15
MIN_INSTRUCTOR_PAYOUT=50
SETTLEMENT_PERIOD=monthly

# Payment Gateways
STRIPE_ENABLED=false
STRIPE_PUBLIC_KEY=
STRIPE_SECRET_KEY=

PAYPAL_ENABLED=false
PAYPAL_CLIENT_ID=
PAYPAL_SECRET=

# Octane Configuration
OCTANE_SERVER=swoole
OCTANE_HOST=127.0.0.1
OCTANE_PORT=8000
OCTANE_WORKERS=auto
```

## 🐛 Troubleshooting

### Octane Port Already In Use
```bash
# Kill existing process
lsof -ti:8000 | xargs kill -9

# Or use different port
php artisan octane:start --port=8001
```

### Database Connection Issues
```bash
# Test connection
php artisan tinker
DB::connection()->getPdo();
```

### Frontend Build Issues
```bash
# Clear Node modules and reinstall
rm -rf node_modules package-lock.json
npm install
npm run dev
```

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue.js Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Filament Documentation](https://filamentphp.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Laravel Octane Documentation](https://laravel.com/docs/octane)

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write tests
5. Submit a pull request

## 📞 Support

For support, email support@edumarket.local or open an issue on GitHub.

## 🎉 Next Steps

1. ✅ Complete installation
2. ✅ Verify database setup
3. ✅ Start development server
4. ✅ Create admin account
5. ✅ Test registration flow
6. ✅ Configure payment gateway
7. ✅ Deploy to production

---

**Happy Learning! 🚀**
