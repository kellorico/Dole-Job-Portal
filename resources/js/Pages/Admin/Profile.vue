<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    current_password: '',
    new_password: '',
    new_password_confirmation: '',
    profile_image: null,
});

const showDeleteModal = ref(false);
const imagePreview = ref(props.user?.profile_image || '/components/img/default-avatar.png');

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.profile_image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const updateProfile = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('email', form.email);
    if (form.current_password) {
        formData.append('current_password', form.current_password);
        formData.append('new_password', form.new_password);
        formData.append('new_password_confirmation', form.new_password_confirmation);
    }
    if (form.profile_image) {
        formData.append('profile_image', form.profile_image);
    }

    form.post('/admin/profile/update', {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Profile updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK',
            });
            form.reset('current_password', 'new_password', 'new_password_confirmation');
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update profile. Please check the input fields.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};

const deleteAccount = () => {
    form.delete('/admin/profile/delete', {
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
      <div class="container mx-auto my-8 max-w-4xl px-4">
         <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-6">
               <h2 class="text-2xl font-semibold text-gray-800">Profile Settings</h2>
            </div>

            <form @submit.prevent="updateProfile" class="space-y-6">
               <!-- Profile Image -->
               <div class="flex flex-col items-center space-y-4">
                  <div class="relative">
                     <img 
                        :src="imagePreview" 
                        alt="Profile" 
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-200"
                     >
                     <label 
                        for="profile-image" 
                        class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700"
                     >
                        <i class="fas fa-camera"></i>
                     </label>
                     <input 
                        type="file" 
                        id="profile-image" 
                        class="hidden" 
                        accept="image/*"
                        @change="handleImageUpload"
                     >
                  </div>
                  <p class="text-sm text-gray-500">Click the camera icon to change your profile picture</p>
               </div>

               <!-- User Info -->
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                     <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                     <input 
                        type="text" 
                        id="name" 
                        v-model="form.name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.name }"
                     >
                     <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                  </div>

                  <div>
                     <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                     <input 
                        type="email" 
                        id="email" 
                        v-model="form.email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.email }"
                     >
                     <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                  </div>
               </div>

               <!-- Change Password Section -->
               <div class="border-t pt-6">
                  <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input 
                           type="password" 
                           id="current_password" 
                           v-model="form.current_password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           :class="{ 'border-red-500': form.errors.current_password }"
                        >
                        <p v-if="form.errors.current_password" class="mt-1 text-sm text-red-600">{{ form.errors.current_password }}</p>
                     </div>

                     <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input 
                           type="password" 
                           id="new_password" 
                           v-model="form.new_password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           :class="{ 'border-red-500': form.errors.new_password }"
                        >
                        <p v-if="form.errors.new_password" class="mt-1 text-sm text-red-600">{{ form.errors.new_password }}</p>
                     </div>

                     <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input 
                           type="password" 
                           id="new_password_confirmation" 
                           v-model="form.new_password_confirmation"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           :class="{ 'border-red-500': form.errors.new_password_confirmation }"
                        >
                        <p v-if="form.errors.new_password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.new_password_confirmation }}</p>
                     </div>
                  </div>
               </div>

               <!-- Action Buttons -->
               <div class="flex justify-between items-center pt-6">
                  <button 
                     type="button" 
                     @click="showDeleteModal = true"
                     class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200"
                  >
                     Delete Account
                  </button>
                  <button 
                     type="submit" 
                     class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200"
                     :disabled="form.processing"
                  >
                     <span v-if="form.processing">Updating...</span>
                     <span v-else>Save Changes</span>
                  </button>
               </div>
            </form>
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
