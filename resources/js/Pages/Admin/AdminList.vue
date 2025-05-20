<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, computed } from 'vue';

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
    role: '',
    status: '',
});

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedAdmin = ref(null);
const searchQuery = ref('');
const roleFilter = ref('all');
const statusFilter = ref('all');

// Filter admins based on search query, role, and status
const filteredAdmins = computed(() => {
    return props.admins.filter(admin => {
        const matchesSearch = admin.username.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            admin.email.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesRole = roleFilter.value === 'all' || admin.role === roleFilter.value;
        const matchesStatus = statusFilter.value === 'all' || admin.status === statusFilter.value;
        return matchesSearch && matchesRole && matchesStatus;
    });
});

// Delete admin
const confirmDelete = (admin) => {
    selectedAdmin.value = admin;
    showDeleteModal.value = true;
};

const deleteAdmin = () => {
    if (!selectedAdmin.value) return;

    form.delete(`/admin/delete/${selectedAdmin.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            selectedAdmin.value = null;
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
};

// Edit admin
const editAdmin = (admin) => {
    selectedAdmin.value = { ...admin };
    form.username = admin.username;
    form.email = admin.email;
    form.role = admin.role;
    form.status = admin.status;
    form.password = ''; // Clear password field for security
    form.password_confirmation = ''; // Clear confirmation field
    showEditModal.value = true;
};

// Update admin
const updateAdmin = () => {
    if (!selectedAdmin.value) return;

    form.put(`/admin/update/${selectedAdmin.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            selectedAdmin.value = null;
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

// Get status badge class
const getStatusBadgeClass = (status) => {
    const classes = {
        'active': 'bg-green-100 text-green-800',
        'inactive': 'bg-red-100 text-red-800',
        'pending': 'bg-yellow-100 text-yellow-800',
        'suspended': 'bg-gray-100 text-gray-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

// Get role badge class
const getRoleBadgeClass = (role) => {
    const classes = {
        'admin': 'bg-purple-100 text-purple-800',
        'moderator': 'bg-blue-100 text-blue-800',
        'editor': 'bg-green-100 text-green-800',
        'super_admin': 'bg-red-100 text-red-800'
    };
    return classes[role] || 'bg-gray-100 text-gray-800';
};

// Format date
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};
</script>

<template>
    <AdminLayout>
        <div class="p-6">
            <div class="bg-white shadow rounded-lg p-6">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Admin Management</h2>
                        <p class="text-sm text-gray-600 mt-1">Manage and monitor all administrator accounts</p>
                    </div>
                    <div class="flex gap-4">
                        <Link
                            :href="route('admin-create')"
                            class="px-4 py-2 bg-blue-600 text-white no-underline text-sm font-medium rounded hover:bg-blue-700 flex items-center gap-2"
                        >
                            <i class="fas fa-plus"></i>
                            Add Admin
                        </Link>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="mb-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input
                            type="text"
                            v-model="searchQuery"
                            placeholder="Search admins by name or email..."
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <div class="w-full sm:w-48">
                        <select
                            v-model="roleFilter"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="all">All Roles</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="admin">Administrator</option>
                            <option value="moderator">Moderator</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-48">
                        <select
                            v-model="statusFilter"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>

                <!-- Admins Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-sm">
                            <tr>
                                <th class="border p-3">Name</th>
                                <th class="border p-3">Email</th>
                                <th class="border p-3">Role</th>
                                <th class="border p-3">Status</th>
                                <th class="border p-3">Last Login</th>
                                <th class="border p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="admin in filteredAdmins"
                                :key="admin.id"
                                class="even:bg-gray-50 hover:bg-gray-100"
                            >
                                <td class="border p-3">
                                    <div class="font-medium text-gray-900">{{ admin.username }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ admin.id }}</div>
                                </td>
                                <td class="border p-3">{{ admin.email }}</td>
                                <td class="border p-3">
                                    <span 
                                        class="px-3 py-1 rounded-full text-sm font-medium"
                                        :class="getRoleBadgeClass(admin.role)"
                                    >
                                        {{ admin.role }}
                                    </span>
                                </td>
                                <td class="border p-3">
                                    <span 
                                        class="px-3 py-1 rounded-full text-sm font-medium"
                                        :class="getStatusBadgeClass(admin.status)"
                                    >
                                        {{ admin.status }}
                                    </span>
                                </td>
                                <td class="border p-3">
                                    {{ formatDate(admin.last_login_at) }}
                                </td>
                                <td class="border p-3">
                                    <div class="flex gap-2">
                                        <button
                                            class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 flex items-center gap-1"
                                            @click="editAdmin(admin)"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 flex items-center gap-1"
                                            @click="confirmDelete(admin)"
                                        >
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- No Admins Message -->
                <div v-if="filteredAdmins.length === 0" class="text-center py-8">
                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">No admins found matching your criteria.</p>
                </div>
            </div>
        </div>

        <!-- Edit Admin Modal -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Admin</h3>
                    <button
                        @click="showEditModal = false"
                        class="text-gray-500 hover:text-gray-700"
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
                            v-model="form.username"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            :class="{ 'border-red-500': form.errors.username }"
                        />
                        <p v-if="form.errors.username" class="mt-2 text-sm text-red-600">{{ form.errors.username }}</p>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input
                            type="email"
                            id="email"
                            v-model="form.email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            :class="{ 'border-red-500': form.errors.email }"
                        />
                        <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password (optional)</label>
                        <input
                            type="password"
                            id="password"
                            v-model="form.password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            :class="{ 'border-red-500': form.errors.password }"
                        />
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            :class="{ 'border-red-500': form.errors.password_confirmation }"
                        />
                        <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select
                            id="role"
                            v-model="form.role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                            <option value="super_admin">Super Admin</option>
                            <option value="admin">Administrator</option>
                            <option value="moderator">Moderator</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select
                            id="status"
                            v-model="form.status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button
                            type="button"
                            @click="showEditModal = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Saving...</span>
                            <span v-else>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Confirm Deletion</h3>
                    <button
                        @click="showDeleteModal = false"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        &times;
                    </button>
                </div>
                <p class="text-gray-600 mb-4">
                    Are you sure you want to delete the admin "{{ selectedAdmin?.username }}"? This action cannot be undone.
                </p>
                <div class="flex justify-end space-x-4">
                    <button
                        @click="showDeleteModal = false"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteAdmin"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    >
                        Delete Admin
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
