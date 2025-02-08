<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
  message: String,
  success: String,
});

const form = useForm({
  username: null,
  email: null,
  password: null,
  password_confirmation: null,
});

const submit = () => {
  form.post('/admin/store', {
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        title: 'Success!',
        text: 'Admin successfully created!',
        icon: 'success',
        confirmButtonText: 'OK',
      });
      form.reset();
    },
    onError: () => {
      Swal.fire({
        title: 'Error!',
        text: 'Failed to add admin. Please check the input fields.',
        icon: 'error',
        confirmButtonText: 'OK',
      });
      form.reset('password', 'password_confirmation');
    },
  });
};
</script>

<template>
  <AdminLayout>
    <div class="p-6">
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Add New Admin</h2>
        <form @submit.prevent="submit" class="space-y-4">
          <!-- Username -->
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700">User Name</label>
            <input
              type="text"
              id="username"
              v-model="form.username"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              :class="{ 'border-red-500': form.errors.username }"
              placeholder="Enter admin name"
            />
            <p v-if="form.errors.username" class="mt-2 text-sm text-red-600">{{ form.errors.username }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              type="email"
              id="email"
              v-model="form.email"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              :class="{ 'border-red-500': form.errors.email }"
              placeholder="Enter admin email"
            />
            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              type="password"
              id="password"
              v-model="form.password"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              :class="{ 'border-red-500': form.errors.password }"
              placeholder="Enter password"
            />
            <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input
              type="password"
              id="password_confirmation"
              v-model="form.password_confirmation"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              placeholder="Confirm password"
            />
          </div>

          <!-- Buttons -->
          <div class="flex justify-between items-center">
            <button
              type="submit"
              class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
              Add Admin
            </button>
            <Link
              :href="route('admin-list')"
              class="px-4 py-2 bg-green-500 text-white no-underline rounded-md shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
            >
              Admin List
            </Link>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
