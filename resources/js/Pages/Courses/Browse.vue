<template>
  <AppLayout>
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Browse Courses</h1>
        <p class="text-gray-600 mt-2">Find and book educational courses from expert instructors</p>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Search courses..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select
              v-model="filters.category"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg"
            >
              <option value="">All Categories</option>
              <option value="programming">Programming</option>
              <option value="business">Business</option>
              <option value="design">Design</option>
              <option value="language">Languages</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Level</label>
            <select
              v-model="filters.level"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg"
            >
              <option value="">All Levels</option>
              <option value="beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="advanced">Advanced</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
            <select
              v-model="filters.price"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg"
            >
              <option value="">All Prices</option>
              <option value="0-50">$0 - $50</option>
              <option value="50-100">$50 - $100</option>
              <option value="100+">$100+</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Courses Grid -->
      <div class="grid grid-cols-3 gap-8">
        <div
          v-for="course in courses"
          :key="course.id"
          class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition"
        >
          <!-- Thumbnail -->
          <div class="h-48 bg-gray-200 flex items-center justify-center">
            <img
              v-if="course.thumbnail_path"
              :src="course.thumbnail_path"
              :alt="course.title"
              class="w-full h-full object-cover"
            />
            <div v-else class="text-gray-400">
              <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 1 10.587 1 15.5S6.5 24 12 24s11-4.317 11-8.5S17.5 6.253 12 6.253z"></path>
              </svg>
            </div>
          </div>

          <!-- Content -->
          <div class="p-6">
            <!-- Instructor -->
            <p class="text-sm text-gray-600 mb-2">
              by <span class="font-semibold">{{ course.instructor.name }}</span>
            </p>

            <!-- Title -->
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ course.title }}</h3>

            <!-- Description -->
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ course.description }}</p>

            <!-- Rating -->
            <div class="flex items-center mb-4">
              <div class="flex text-yellow-400">
                <span v-for="i in 5" :key="i">
                  <svg v-if="i <= Math.round(course.average_rating)" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"></path>
                  </svg>
                  <svg v-else class="w-4 h-4 fill-current" viewBox="0 0 20 20" opacity="0.3">
                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"></path>
                  </svg>
                </span>
              </div>
              <span class="text-sm text-gray-600 ml-2">({{ course.total_students }} students)</span>
            </div>

            <!-- Metadata -->
            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
              <span v-if="course.duration_hours">
                📚 {{ course.duration_hours }} hours
              </span>
              <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded">
                {{ course.level }}
              </span>
            </div>

            <!-- Price and Button -->
            <div class="flex items-center justify-between">
              <p class="text-2xl font-bold text-green-600">${{ course.price }}</p>
              <button
                @click="bookCourse(course.id)"
                :disabled="bookingCourse === course.id"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:bg-gray-400"
              >
                {{ bookingCourse === course.id ? 'Booking...' : 'Book Now' }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="courses.length === 0" class="text-center py-12">
        <p class="text-gray-600 text-lg">No courses found. Try adjusting your filters.</p>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  courses: Array,
});

const filters = reactive({
  search: '',
  category: '',
  level: '',
  price: '',
});

const bookingCourse = ref(null);
const page = usePage();

const bookCourse = (courseId) => {
  bookingCourse.value = courseId;
  
  const form = useForm({
    course_id: courseId,
  });

  form.post('/bookings', {
    onSuccess: () => {
      bookingCourse.value = null;
      // Redirect to payment or confirmation
    },
    onError: (errors) => {
      bookingCourse.value = null;
      alert(Object.values(errors)[0][0]);
    }
  });
};
</script>
