<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, computed } from 'vue';

const props = defineProps({
  message: String,
  success: String,
});

const form = useForm({
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'admin',
  status: 'active',
});

const showConfirmModal = ref(false);
const passwordStrength = ref(0);

// Computed property for form validation
const isFormValid = computed(() => {
  return form.username && 
         form.email && 
         form.password && 
         form.password_confirmation && 
         form.password === form.password_confirmation &&
         passwordStrength.value >= 2;
});

// Check password strength
const checkPasswordStrength = (password) => {
  let strength = 0;
  if (password.length >= 8) strength++;
  if (/[A-Z]/.test(password)) strength++;
  if (/[a-z]/.test(password)) strength++;
  if (/[0-9]/.test(password)) strength++;
  if (/[^A-Za-z0-9]/.test(password)) strength++;
  passwordStrength.value = strength;
};

// Get password strength color
const getPasswordStrengthColor = () => {
  const colors = {
    0: 'bg-red-500',
    1: 'bg-red-500',
    2: 'bg-yellow-500',
    3: 'bg-yellow-500',
    4: 'bg-green-500',
    5: 'bg-green-500'
  };
  return colors[passwordStrength.value] || 'bg-gray-200';
};

// Get password strength text
const getPasswordStrengthText = () => {
  const texts = {
    0: 'Very Weak',
    1: 'Weak',
    2: 'Fair',
    3: 'Good',
    4: 'Strong',
    5: 'Very Strong'
  };
  return texts[passwordStrength.value] || 'No Password';
};

const submit = () => {
  if (!isFormValid.value) {
    Swal.fire({
      title: 'Validation Error',
      text: 'Please fill in all required fields correctly.',
      icon: 'error',
      confirmButtonText: 'OK',
    });
    return;
  }
  showConfirmModal.value = true;
};

const confirmSubmit = () => {
  form.post('/admin/store', {
    preserveScroll: true,
    onSuccess: () => {
      showConfirmModal.value = false;
      Swal.fire({
        title: 'Success!',
        text: 'Admin successfully created!',
        icon: 'success',
        confirmButtonText: 'OK',
      });
      form.reset();
      passwordStrength.value = 0;
    },
    onError: () => {
      showConfirmModal.value = false;
      Swal.fire({
        title: 'Error!',
        text: 'Failed to add admin. Please check the input fields.',
        icon: 'error',
        confirmButtonText: 'OK',
      });
      form.reset('password', 'password_confirmation');
      passwordStrength.value = 0;
    },
  });
};

const resetForm = () => {
  Swal.fire({
    title: 'Reset Form',
    text: 'Are you sure you want to reset all fields?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, reset it!',
    cancelButtonText: 'No, keep it!',
  }).then((result) => {
    if (result.isConfirmed) {
      form.reset();
      passwordStrength.value = 0;
    }
  });
};
</script>

<template>
  <AdminLayout>
    <div class="p-6">
      <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
          <div>
            <h2 class="text-2xl font-semibold text-gray-800">Add New Admin</h2>
            <p class="text-sm text-gray-600 mt-1">Create a new administrator account</p>
          </div>
          <Link
            :href="route('admin-list')"
            class="px-4 py-2 bg-gray-600 text-white no-underline text-sm font-medium rounded hover:bg-gray-700 flex items-center gap-2"
          >
            <i class="fas fa-arrow-left"></i>
            Back to Admin List
          </Link>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <!-- Basic Information Section -->
          <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Username -->
              <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username *</label>
                <input
                  type="text"
                  id="username"
                  v-model="form.username"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="{ 'border-red-500': form.errors.username }"
                  placeholder="Enter admin username"
                />
                <p v-if="form.errors.username" class="mt-2 text-sm text-red-600">{{ form.errors.username }}</p>
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="{ 'border-red-500': form.errors.email }"
                  placeholder="Enter admin email"
                />
                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
              </div>
            </div>
          </div>

          <!-- Security Section -->
          <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Security</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Password -->
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                <input
                  type="password"
                  id="password"
                  v-model="form.password"
                  @input="checkPasswordStrength(form.password)"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="{ 'border-red-500': form.errors.password }"
                  placeholder="Enter password"
                />
                <div class="mt-2">
                  <div class="h-2 bg-gray-200 rounded-full">
                    <div
                      class="h-2 rounded-full transition-all duration-300"
                      :class="getPasswordStrengthColor()"
                      :style="{ width: `${(passwordStrength / 5) * 100}%` }"
                    ></div>
                  </div>
                  <p class="text-sm mt-1" :class="{
                    'text-red-600': passwordStrength <= 1,
                    'text-yellow-600': passwordStrength === 2 || passwordStrength === 3,
                    'text-green-600': passwordStrength >= 4
                  }">
                    Password Strength: {{ getPasswordStrengthText() }}
                  </p>
                </div>
                <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
              </div>

              <!-- Confirm Password -->
              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                <input
                  type="password"
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  :class="{ 'border-red-500': form.errors.password_confirmation }"
                  placeholder="Confirm password"
                />
                <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
              </div>
            </div>
          </div>

          <!-- Role and Status Section -->
          <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Role and Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Role -->
              <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select
                  id="role"
                  v-model="form.role"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                  <option value="admin">Administrator</option>
                  <option value="moderator">Moderator</option>
                  <option value="editor">Editor</option>
                </select>
              </div>

              <!-- Status -->
              <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select
                  id="status"
                  v-model="form.status"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="resetForm"
              class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
            >
              Reset
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
              :disabled="form.processing || !isFormValid"
            >
              <span v-if="form.processing">Creating...</span>
              <span v-else>Create Admin</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div v-if="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-800">Confirm Admin Creation</h3>
          <button
            @click="showConfirmModal = false"
            class="text-gray-500 hover:text-gray-700"
          >
            &times;
          </button>
        </div>
        <p class="text-gray-600 mb-4">Are you sure you want to create this admin account?</p>
        <div class="flex justify-end space-x-4">
          <button
            @click="showConfirmModal = false"
            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
          >
            Cancel
          </button>
          <button
            @click="confirmSubmit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
            :disabled="form.processing"
          >
            <span v-if="form.processing">Creating...</span>
            <span v-else>Confirm Creation</span>
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
