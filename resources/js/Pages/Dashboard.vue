<template>
  <AppLayout>
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ auth.user.name }}</p>
      </div>

      <!-- KYC Verification Banner -->
      <div v-if="!auth.user.is_kyc_verified" class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-8">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-yellow-800 font-semibold">Complete KYC Verification</p>
            <p class="text-yellow-700 text-sm">You need to complete identity verification to access all features.</p>
          </div>
          <Link href="/auth/kyc" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
            Complete KYC
          </Link>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="grid grid-cols-4 gap-4 mb-8">
        <StatCard
          v-if="auth.user.role === 'student'"
          title="Enrolled Courses"
          :value="stats.enrolledCourses"
          icon="📚"
        />
        <StatCard
          v-if="auth.user.role === 'student'"
          title="In Progress"
          :value="stats.inProgress"
          icon="⏳"
        />
        <StatCard
          v-if="auth.user.role === 'student'"
          title="Completed"
          :value="stats.completed"
          icon="✅"
        />
        <StatCard
          v-if="auth.user.role === 'instructor'"
          title="Total Earnings"
          :value="`$${stats.totalEarnings}`"
          icon="💰"
        />
        <StatCard
          v-if="auth.user.role === 'instructor'"
          title="Active Courses"
          :value="stats.activeCourses"
          icon="📖"
        />
        <StatCard
          v-if="auth.user.role === 'instructor'"
          title="Total Students"
          :value="stats.totalStudents"
          icon="👥"
        />
        <StatCard title="Account Balance" :value="`$${stats.accountBalance}`" icon="💳" />
      </div>

      <!-- Main Content -->
      <div class="grid grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="col-span-2">
          <!-- Student Bookings -->
          <div v-if="auth.user.role === 'student'" class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold mb-6">My Courses</h2>
            
            <div v-if="bookings.length > 0" class="space-y-4">
              <div
                v-for="booking in bookings"
                :key="booking.id"
                class="border rounded-lg p-4 flex items-center justify-between hover:shadow-lg transition"
              >
                <div class="flex-1">
                  <h3 class="font-semibold text-gray-900">{{ booking.course.title }}</h3>
                  <p class="text-sm text-gray-600">by {{ booking.course.instructor.name }}</p>
                  <div class="mt-2 flex items-center space-x-4">
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                      {{ booking.status }}
                    </span>
                    <div class="w-24 bg-gray-200 rounded-full h-2">
                      <div
                        class="bg-green-500 h-2 rounded-full"
                        :style="{ width: booking.progress_percentage + '%' }"
                      ></div>
                    </div>
                    <span class="text-sm text-gray-600">{{ booking.progress_percentage }}%</span>
                  </div>
                </div>
                <Button href="#" class="ml-4">Continue Learning</Button>
              </div>
            </div>
            <div v-else class="text-center text-gray-600 py-8">
              <p class="mb-4">You haven't enrolled in any courses yet.</p>
              <Link href="/courses" class="text-blue-600 hover:underline">Browse Courses</Link>
            </div>
          </div>

          <!-- Instructor Stats -->
          <div v-if="auth.user.role === 'instructor'" class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-bold mb-6">Recent Activity</h2>
            
            <div class="space-y-4">
              <div
                v-for="activity in activities"
                :key="activity.id"
                class="flex items-center space-x-4 pb-4 border-b last:border-b-0"
              >
                <div class="flex-shrink-0">
                  <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                    {{ activity.icon }}
                  </div>
                </div>
                <div class="flex-1">
                  <p class="text-sm font-medium text-gray-900">{{ activity.title }}</p>
                  <p class="text-xs text-gray-500">{{ activity.timestamp }}</p>
                </div>
                <p class="text-sm font-semibold text-gray-900">{{ activity.value }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column -->
        <div>
          <!-- Quick Links -->
          <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-bold mb-4">Quick Links</h3>
            <div class="space-y-2">
              <Link
                v-if="auth.user.role === 'student'"
                href="/courses"
                class="block px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
              >
                → Browse Courses
              </Link>
              <Link
                v-if="auth.user.role === 'student'"
                href="/bookings"
                class="block px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
              >
                → My Bookings
              </Link>
              <Link
                v-if="auth.user.role === 'instructor'"
                href="/courses/create"
                class="block px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
              >
                → Create Course
              </Link>
              <Link
                v-if="auth.user.role === 'instructor'"
                href="/instructor/earnings"
                class="block px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
              >
                → View Earnings
              </Link>
              <Link
                href="/profile"
                class="block px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
              >
                → Edit Profile
              </Link>
            </div>
          </div>

          <!-- Support -->
          <div class="bg-blue-50 rounded-lg shadow p-6">
            <h3 class="text-lg font-bold mb-4">Need Help?</h3>
            <p class="text-sm text-gray-700 mb-4">
              Contact our support team for help with any questions or issues.
            </p>
            <a href="mailto:support@edumarket.com" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
              Contact Support
            </a>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  auth: Object,
  bookings: Array,
  stats: Object,
  activities: Array,
});

const Button = {
  props: ['href'],
  template: '<a :href="href" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"><slot></slot></a>'
};
</script>
