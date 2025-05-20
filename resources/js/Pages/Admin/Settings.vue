<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    username: props.user?.username || '',
    email: props.user?.email || '',
    password: '',
    password_confirmation: '',
});

const showUpdateModal = ref(false);
const showDeleteModal = ref(false);

const updateSettings = () => {
    form.put('/admin/settings/update', {
        preserveScroll: true,
        onSuccess: () => {
            showUpdateModal.value = false;
            Swal.fire({
                title: 'Success!',
                text: 'Settings updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK',
            });
            form.reset('password', 'password_confirmation');
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update settings. Please check the input fields.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};

const deleteAccount = () => {
    form.delete('/admin/settings/delete-account', {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            Swal.fire({
                title: 'Account Deleted!',
                text: 'Your account has been successfully deleted.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to delete account. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};
</script>

<template>
   <AdminLayout>
      <div id="settingsSection" class="container mx-auto my-8 max-w-4xl px-4">
         <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="border-b pb-4 mb-6">
               <h2 class="text-2xl font-semibold text-gray-800">Settings</h2>
            </div>
            <form @submit.prevent="showUpdateModal = true">
               <!-- Username -->
               <div class="mb-4">
                  <label for="username" class="text-sm font-medium text-gray-600">Username</label>
                  <input 
                     type="text" 
                     id="username" 
                     v-model="form.username"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                     :class="{ 'border-red-500': form.errors.username }"
                  >
                  <p v-if="form.errors.username" class="mt-1 text-sm text-red-600">{{ form.errors.username }}</p>
               </div>

               <!-- Email -->
               <div class="mb-4">
                  <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                  <input 
                     type="email" 
                     id="email" 
                     v-model="form.email"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                     :class="{ 'border-red-500': form.errors.email }"
                  >
                  <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
               </div>

               <!-- Password -->
               <div class="mb-4">
                  <label for="password" class="text-sm font-medium text-gray-600">New Password</label>
                  <input 
                     type="password" 
                     id="password" 
                     v-model="form.password"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                     :class="{ 'border-red-500': form.errors.password }"
                  >
                  <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
               </div>

               <!-- Confirm Password -->
               <div class="mb-6">
                  <label for="confirmPassword" class="text-sm font-medium text-gray-600">Confirm New Password</label>
                  <input 
                     type="password" 
                     id="confirmPassword" 
                     v-model="form.password_confirmation"
                     class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                     :class="{ 'border-red-500': form.errors.password_confirmation }"
                  >
                  <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
               </div>

               <!-- Action Buttons -->
               <div class="flex justify-end space-x-4">
                  <button 
                     type="submit" 
                     class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50"
                     :disabled="form.processing"
                  >
                     <span v-if="form.processing">Updating...</span>
                     <span v-else>Update Settings</span>
                  </button>
                  <button 
                     type="button" 
                     @click="showDeleteModal = true"
                     class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition duration-200"
                  >
                     Delete Account
                  </button>
               </div>
            </form>
         </div>
      </div>

      <!-- Update Modal -->
      <div v-if="showUpdateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
         <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
               <h3 class="text-lg font-semibold text-gray-800">Confirm Update</h3>
               <button 
                  @click="showUpdateModal = false"
                  class="text-gray-500 hover:text-gray-700"
               >
                  &times;
               </button>
            </div>
            <p class="text-gray-600 mb-4">Are you sure you want to update your settings?</p>
            <div class="flex justify-end space-x-4">
               <button 
                  @click="showUpdateModal = false"
                  class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
               >
                  Cancel
               </button>
               <button 
                  @click="updateSettings"
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                  :disabled="form.processing"
               >
                  <span v-if="form.processing">Updating...</span>
                  <span v-else>Save Changes</span>
               </button>
            </div>
         </div>
      </div>

      <!-- Delete Account Modal -->
      <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
         <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
               <h3 class="text-lg font-semibold text-gray-800">Confirm Account Deletion</h3>
               <button 
                  @click="showDeleteModal = false"
                  class="text-gray-500 hover:text-gray-700"
               >
                  &times;
               </button>
            </div>
            <p class="text-gray-600 mb-4">Are you sure you want to delete your account? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
               <button 
                  @click="showDeleteModal = false"
                  class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
               >
                  Cancel
               </button>
               <button 
                  @click="deleteAccount"
                  class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                  :disabled="form.processing"
               >
                  <span v-if="form.processing">Deleting...</span>
                  <span v-else>Delete Account</span>
               </button>
            </div>
         </div>
      </div>
   </AdminLayout>
</template>
