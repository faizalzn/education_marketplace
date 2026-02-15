#!/usr/bin/env php
<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

// Create Student User
User::create([
    'name' => 'Student Test',
    'email' => 'student@test.com',
    'password' => bcrypt('password'),
    'role' => 'student',
    'is_active' => true,
    'email_verified_at' => now(),
]);

// Create Instructor User
User::create([
    'name' => 'Instructor Test',
    'email' => 'instructor@test.com',
    'password' => bcrypt('password'),
    'role' => 'instructor',
    'is_active' => true,
    'email_verified_at' => now(),
]);

// Create Admin User
User::create([
    'name' => 'Admin Test',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'is_active' => true,
    'email_verified_at' => now(),
]);

echo "✅ 3 test users created successfully!\n";
echo "───────────────────────────────────────\n";
echo "📧 STUDENT\n";
echo "   Email: student@test.com\n";
echo "   Password: password\n";
echo "────────────────────────────────────────\n";
echo "📧 INSTRUCTOR\n";
echo "   Email: instructor@test.com\n";
echo "   Password: password\n";
echo "────────────────────────────────────────\n";
echo "📧 ADMIN\n";
echo "   Email: admin@test.com\n";
echo "   Password: password\n";
echo "────────────────────────────────────────\n";
