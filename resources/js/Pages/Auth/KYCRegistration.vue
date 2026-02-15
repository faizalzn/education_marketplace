<template>
  <AppLayout>
    <div class="max-w-3xl mx-auto">
      <h1 class="text-3xl font-bold mb-8">Know Your Customer (KYC) Verification</h1>

      <!-- Progress Indicator -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div v-for="(step, index) in steps" :key="index" class="flex flex-col items-center flex-1">
            <div :class="[
              'w-10 h-10 rounded-full flex items-center justify-center font-bold',
              currentStep > index ? 'bg-green-500 text-white' : 
              currentStep === index ? 'bg-blue-500 text-white' : 
              'bg-gray-300 text-gray-700'
            ]">
              {{ index + 1 }}
            </div>
            <p class="mt-2 text-sm font-medium">{{ step }}</p>
          </div>
        </div>
      </div>

      <!-- Form -->
      <form @submit.prevent="submitForm" class="bg-white rounded-lg shadow p-6">
        <!-- Step 1: Personal Information -->
        <div v-if="currentStep === 0">
          <h2 class="text-xl font-bold mb-6">Personal Information</h2>
          
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
              <input
                v-model="form.full_name"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.full_name }"
              />
              <p v-if="errors.full_name" class="text-red-500 text-sm mt-1">{{ errors.full_name[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
              <input
                v-model="form.phone_number"
                type="tel"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.phone_number }"
              />
              <p v-if="errors.phone_number" class="text-red-500 text-sm mt-1">{{ errors.phone_number[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
              <input
                v-model="form.date_of_birth"
                type="date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.date_of_birth }"
              />
              <p v-if="errors.date_of_birth" class="text-red-500 text-sm mt-1">{{ errors.date_of_birth[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
              <select
                v-model="form.gender"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>

            <div class="col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">Nationality</label>
              <input
                v-model="form.nationality"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
              />
            </div>
          </div>
        </div>

        <!-- Step 2: Address Information -->
        <div v-if="currentStep === 1">
          <h2 class="text-xl font-bold mb-6">Address Information</h2>
          
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
              <input
                v-model="form.street_address"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.street_address }"
              />
              <p v-if="errors.street_address" class="text-red-500 text-sm mt-1">{{ errors.street_address[0] }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                <input
                  v-model="form.city"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                  :class="{ 'border-red-500': errors.city }"
                />
                <p v-if="errors.city" class="text-red-500 text-sm mt-1">{{ errors.city[0] }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">State/Province</label>
                <input
                  v-model="form.state"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                  :class="{ 'border-red-500': errors.state }"
                />
                <p v-if="errors.state" class="text-red-500 text-sm mt-1">{{ errors.state[0] }}</p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                <input
                  v-model="form.postal_code"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                  :class="{ 'border-red-500': errors.postal_code }"
                />
                <p v-if="errors.postal_code" class="text-red-500 text-sm mt-1">{{ errors.postal_code[0] }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                <input
                  v-model="form.country"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                  :class="{ 'border-red-500': errors.country }"
                />
                <p v-if="errors.country" class="text-red-500 text-sm mt-1">{{ errors.country[0] }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 3: Identity Verification -->
        <div v-if="currentStep === 2">
          <h2 class="text-xl font-bold mb-6">Identity Verification</h2>
          
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">ID Type</label>
              <select
                v-model="form.id_type"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.id_type }"
              >
                <option value="">Select ID Type</option>
                <option value="passport">Passport</option>
                <option value="national_id">National ID</option>
                <option value="driver_license">Driver License</option>
              </select>
              <p v-if="errors.id_type" class="text-red-500 text-sm mt-1">{{ errors.id_type[0] }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ID Number</label>
                <input
                  v-model="form.id_number"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                  :class="{ 'border-red-500': errors.id_number }"
                />
                <p v-if="errors.id_number" class="text-red-500 text-sm mt-1">{{ errors.id_number[0] }}</p>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ID Expiry Date</label>
                <input
                  v-model="form.id_expiry_date"
                  type="date"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                  :class="{ 'border-red-500': errors.id_expiry_date }"
                />
                <p v-if="errors.id_expiry_date" class="text-red-500 text-sm mt-1">{{ errors.id_expiry_date[0] }}</p>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Upload ID Document</label>
              <input
                type="file"
                @change="handleFileUpload('id_document_path', $event)"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg"
              />
              <p class="text-gray-500 text-sm mt-1">Accepted formats: JPG, PNG, PDF (Max 5MB)</p>
            </div>
          </div>
        </div>

        <!-- Step 4: Bank Account Verification -->
        <div v-if="currentStep === 3">
          <h2 class="text-xl font-bold mb-6">Bank Account Verification</h2>
          
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Bank Name</label>
              <input
                v-model="form.bank_name"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.bank_name }"
              />
              <p v-if="errors.bank_name" class="text-red-500 text-sm mt-1">{{ errors.bank_name[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Account Holder Name</label>
              <input
                v-model="form.bank_account_holder_name"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.bank_account_holder_name }"
              />
              <p v-if="errors.bank_account_holder_name" class="text-red-500 text-sm mt-1">{{ errors.bank_account_holder_name[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Account Number</label>
              <input
                v-model="form.bank_account_number"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
                :class="{ 'border-red-500': errors.bank_account_number }"
              />
              <p v-if="errors.bank_account_number" class="text-red-500 text-sm mt-1">{{ errors.bank_account_number[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Routing Number (Optional)</label>
              <input
                v-model="form.bank_routing_number"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-transparent"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bank Statement</label>
              <input
                type="file"
                @change="handleFileUpload('bank_statement_path', $event)"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg"
              />
              <p class="text-gray-500 text-sm mt-1">Accepted formats: JPG, PNG, PDF (Max 5MB)</p>
            </div>
          </div>
        </div>

        <!-- Step 5: Face Recognition/Liveness Check -->
        <div v-if="currentStep === 4">
          <h2 class="text-xl font-bold mb-6">Face Verification</h2>
          
          <div class="text-center">
            <div class="bg-gray-100 p-8 rounded-lg mb-6">
              <p class="text-gray-700 mb-4">
                Please take a clear selfie of your face for verification purposes. 
                Ensure you are in a well-lit area and your face is clearly visible.
              </p>
              <video
                v-if="!capturedImage"
                id="video"
                ref="videoElement"
                autoplay
                class="w-full max-w-sm mx-auto rounded-lg mb-4 bg-black"
              ></video>
              <img
                v-if="capturedImage"
                :src="capturedImage"
                alt="Captured selfie"
                class="w-full max-w-sm mx-auto rounded-lg mb-4"
              />
            </div>

            <div class="space-y-4">
              <button
                v-if="!capturedImage"
                type="button"
                @click="captureImage"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600"
              >
                Capture Selfie
              </button>
              
              <button
                v-if="capturedImage"
                type="button"
                @click="retakeSelfie"
                class="w-full bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600"
              >
                Retake Selfie
              </button>

              <canvas ref="canvas" style="display: none;"></canvas>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-8">
          <button
            v-if="currentStep > 0"
            type="button"
            @click="currentStep--"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
          >
            Previous
          </button>
          
          <button
            v-if="currentStep < steps.length - 1"
            type="button"
            @click="currentStep++"
            class="ml-auto px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
          >
            Next
          </button>

          <button
            v-if="currentStep === steps.length - 1"
            type="submit"
            :disabled="submitting"
            class="ml-auto px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 disabled:bg-gray-400"
          >
            {{ submitting ? 'Submitting...' : 'Submit for Verification' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const steps = ['Personal', 'Address', 'Identity', 'Bank', 'Face'];
const currentStep = ref(0);
const submitting = ref(false);
const capturedImage = ref(null);
const videoElement = ref(null);
const canvas = ref(null);

const form = useForm({
  full_name: '',
  phone_number: '',
  date_of_birth: '',
  gender: '',
  nationality: '',
  street_address: '',
  city: '',
  state: '',
  postal_code: '',
  country: '',
  id_type: '',
  id_number: '',
  id_expiry_date: '',
  id_document_path: null,
  address_proof_path: null,
  bank_name: '',
  bank_account_number: '',
  bank_routing_number: '',
  bank_account_holder_name: '',
  bank_statement_path: null,
  selfie_path: null,
});

const errors = ref({});

const handleFileUpload = (field, event) => {
  const file = event.target.files[0];
  if (file) {
    form[field] = file;
  }
};

const captureImage = () => {
  // Initialize camera
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
      videoElement.value.srcObject = stream;
    })
    .catch(err => {
      console.error('Camera access denied', err);
    });

  // Capture image
  setTimeout(() => {
    const context = canvas.value.getContext('2d');
    canvas.value.width = videoElement.value.videoWidth;
    canvas.value.height = videoElement.value.videoHeight;
    context.drawImage(videoElement.value, 0, 0);
    capturedImage.value = canvas.value.toDataURL('image/jpeg');
    
    // Stop video stream
    videoElement.value.srcObject.getTracks().forEach(track => track.stop());
  }, 500);
};

const retakeSelfie = () => {
  capturedImage.value = null;
};

const submitForm = () => {
  submitting.value = true;
  form.post('/auth/kyc', {
    onSuccess: () => {
      submitting.value = false;
    },
    onError: (err) => {
      errors.value = err;
      submitting.value = false;
    }
  });
};
</script>
