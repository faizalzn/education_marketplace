<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <Link href="/" class="text-xl font-bold text-blue-600">
              EduMarket
            </Link>
          </div>
          <div class="flex items-center space-x-4">
            <Link v-if="!auth.user" href="/login" class="text-gray-700 hover:text-blue-600">
              Login
            </Link>
            <Link v-if="!auth.user" href="/register" class="text-gray-700 hover:text-blue-600">
              Register
            </Link>
            
            <div v-if="auth.user" class="flex items-center space-x-4">
              <Link href="/dashboard" class="text-gray-700 hover:text-blue-600">
                Dashboard
              </Link>
              <div class="relative">
                <button @click="menuOpen = !menuOpen" class="text-gray-700 hover:text-blue-600">
                  {{ auth.user.name }}
                </button>
                <div v-if="menuOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10">
                  <Link href="/profile" class="block px-4 py-2 hover:bg-gray-100">Profile</Link>
                  <Link href="/logout" as="button" method="post" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                    Logout
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Flash Messages -->
    <div v-if="flash.message" class="bg-blue-50 border-l-4 border-blue-500 p-4 my-4">
      <p class="text-blue-700">{{ flash.message }}</p>
    </div>
    <div v-if="flash.success" class="bg-green-50 border-l-4 border-green-500 p-4 my-4">
      <p class="text-green-700">{{ flash.success }}</p>
    </div>
    <div v-if="flash.error" class="bg-red-50 border-l-4 border-red-500 p-4 my-4">
      <p class="text-red-700">{{ flash.error }}</p>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <slot></slot>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-4 gap-8">
          <div>
            <h3 class="font-bold text-white mb-4">About</h3>
            <ul class="space-y-2 text-sm">
              <li><Link href="/" class="hover:text-white">About Us</Link></li>
              <li><Link href="/" class="hover:text-white">Contact</Link></li>
            </ul>
          </div>
          <div>
            <h3 class="font-bold text-white mb-4">Learn</h3>
            <ul class="space-y-2 text-sm">
              <li><Link href="/" class="hover:text-white">Browse Courses</Link></li>
              <li><Link href="/" class="hover:text-white">Categories</Link></li>
            </ul>
          </div>
          <div>
            <h3 class="font-bold text-white mb-4">Teach</h3>
            <ul class="space-y-2 text-sm">
              <li><Link href="/" class="hover:text-white">Become Instructor</Link></li>
              <li><Link href="/" class="hover:text-white">Teaching Guide</Link></li>
            </ul>
          </div>
          <div>
            <h3 class="font-bold text-white mb-4">Legal</h3>
            <ul class="space-y-2 text-sm">
              <li><Link href="/" class="hover:text-white">Terms of Service</Link></li>
              <li><Link href="/" class="hover:text-white">Privacy Policy</Link></li>
            </ul>
          </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
          <p>&copy; 2025 Education Marketplace. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

defineProps({
  auth: Object,
  flash: Object,
});

const menuOpen = ref(false);
</script>
