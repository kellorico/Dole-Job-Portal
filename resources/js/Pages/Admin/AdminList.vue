<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const props = defineProps({
    admins: Array,
    message: String,
    success: String,
});

// Form for editing admin details
const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showEditModal = ref(false);
const currentAdmin = ref(null);

// Delete admin
const deleteAdmin = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(`/admin/delete/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Admin has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    });
                },
                onError: () => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete admin. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                },
            });
        }
    });
};

// Edit admin
const editAdmin = (admin) => {
    currentAdmin.value = { ...admin };
    form.username = admin.username;
    form.email = admin.email;
    form.password = ''; // Clear password field for security
    form.password_confirmation = ''; // Clear confirmation field
    showEditModal.value = true;
};

// Update admin
const updateAdmin = () => {
    form.put(`/admin/update/${currentAdmin.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            Swal.fire({
                title: 'Updated!',
                text: 'Admin details have been updated.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update admin. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};
</script>

<template>
   <AdminLayout>
       <div class="p-6">
           <div class="bg-white shadow rounded-lg p-6">
               <div class="flex justify-between items-center mb-4">
                   <h2 class="text-xl font-semibold text-gray-800">Admin List</h2>
                   <Link
                       :href="route('admin-create')"
                       class="px-4 py-2 bg-blue-600 text-white no-underline text-sm font-medium rounded hover:bg-blue-700"
                   >
                       Back
                   </Link>
               </div>
               <div>
                   <template v-if="admins.length > 0">
                       <table class="w-full text-left border-collapse">
                           <thead class="bg-gray-100 text-sm">
                               <tr>
                                   <th class="border p-3">#</th>
                                   <th class="border p-3">Name</th>
                                   <th class="border p-3">Email</th>
                                   <th class="border p-3">Actions</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr
                                   v-for="(admin, index) in admins"
                                   :key="admin.id"
                                   class="even:bg-gray-50 hover:bg-gray-100"
                               >
                                   <td class="border p-3">{{ index + 1 }}</td>
                                   <td class="border p-3">{{ admin.username }}</td>
                                   <td class="border p-3">{{ admin.email }}</td>
                                   <td class="border p-3 flex gap-2">
                                       <button
                                           class="px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600"
                                           @click="editAdmin(admin)"
                                       >
                                           <i class="fas fa-edit"></i> Edit
                                       </button>
                                       <button
                                           class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                                           @click="deleteAdmin(admin.id)"
                                       >
                                           <i class="fas fa-trash"></i> Delete
                                       </button>
                                   </td>
                               </tr>
                           </tbody>
                       </table>
                   </template>
                   <p v-else class="text-center text-gray-500">
                       No admins found. Click "Back" and Click "Add Admin" to create one.
                   </p>
               </div>
           </div>
       </div>

       <!-- Edit Admin Modal -->
       <div
           v-if="showEditModal"
           class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50"
       >
           <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
               <div class="flex justify-between items-center mb-4">
                   <h3 class="text-lg font-semibold text-gray-800">Edit Admin</h3>
                   <button
                       class="text-gray-500 hover:text-gray-800"
                       @click="showEditModal = false"
                   >
                       &times;
                   </button>
               </div>
               <form @submit.prevent="updateAdmin" class="space-y-4">
                   <div>
                       <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                       <input
                           type="text"
                           id="username"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           v-model="form.username"
                       />
                   </div>
                   <div>
                       <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                       <input
                           type="email"
                           id="email"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           v-model="form.email"
                       />
                   </div>
                   <div>
                       <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                       <input
                           type="password"
                           id="password"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           v-model="form.password"
                       />
                   </div>
                   <div>
                       <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                       <input
                           type="password"
                           id="password_confirmation"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           v-model="form.password_confirmation"
                       />
                   </div>
                   <div class="flex justify-end">
                       <button
                           type="submit"
                           class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700"
                       >
                           Save
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </AdminLayout>
</template>
