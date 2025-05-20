<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, computed } from 'vue';

const props = defineProps({
    users: Array,
    message: String,
    success: String,
});

// Form for editing user details
const form = useForm({
    username: '',
    email: '',
    role: '',
    status: '',
});

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedUser = ref(null);
const searchQuery = ref('');
const roleFilter = ref('all');
const statusFilter = ref('all');

// Filter users based on search query, role, and status
const filteredUsers = computed(() => {
    return props.users.filter(user => {
        const matchesSearch = user.username.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            user.email.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesRole = roleFilter.value === 'all' || user.role === roleFilter.value;
        const matchesStatus = statusFilter.value === 'all' || user.status === statusFilter.value;
        return matchesSearch && matchesRole && matchesStatus;
    });
});

// Delete user
const confirmDelete = (user) => {
    selectedUser.value = user;
    showDeleteModal.value = true;
};

const deleteUser = () => {
    if (!selectedUser.value) return;

    form.delete(`/admin/users/${selectedUser.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            selectedUser.value = null;
            Swal.fire({
                title: 'Deleted!',
                text: 'User has been deleted.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to delete user. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};

// Edit user
const editUser = (user) => {
    selectedUser.value = { ...user };
    form.username = user.username;
    form.email = user.email;
    form.role = user.role;
    form.status = user.status;
    showEditModal.value = true;
};

// Update user
const updateUser = () => {
    if (!selectedUser.value) return;

    form.put(`/admin/users/${selectedUser.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showEditModal.value = false;
            selectedUser.value = null;
            Swal.fire({
                title: 'Updated!',
                text: 'User details have been updated.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update user. Please try again.',
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
        'user': 'bg-gray-100 text-gray-800'
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
                        <h2 class="text-2xl font-semibold text-gray-800">User Management</h2>
                        <p class="text-sm text-gray-600 mt-1">Manage and monitor all user accounts</p>
                    </div>
                    <Link
                        :href="route('admin.dashboard')"
                        class="px-4 py-2 bg-gray-600 text-white no-underline text-sm font-medium rounded hover:bg-gray-700 flex items-center gap-2"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Back to Dashboard
                    </Link>
                </div>

                <!-- Filters Section -->
                <div class="mb-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input
                            type="text"
                            v-model="searchQuery"
                            placeholder="Search users by name or email..."
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <div class="w-full sm:w-48">
                        <select
                            v-model="roleFilter"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="all">All Roles</option>
                            <option value="admin">Administrator</option>
                            <option value="moderator">Moderator</option>
                            <option value="editor">Editor</option>
                            <option value="user">User</option>
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

                <!-- Users Table -->
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
                                v-for="user in filteredUsers"
                                :key="user.id"
                                class="even:bg-gray-50 hover:bg-gray-100"
                            >
                                <td class="border p-3">
                                    <div class="font-medium text-gray-900">{{ user.username }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ user.id }}</div>
                                </td>
                                <td class="border p-3">{{ user.email }}</td>
                                <td class="border p-3">
                                    <span 
                                        class="px-3 py-1 rounded-full text-sm font-medium"
                                        :class="getRoleBadgeClass(user.role)"
                                    >
                                        {{ user.role }}
                                    </span>
                                </td>
                                <td class="border p-3">
                                    <span 
                                        class="px-3 py-1 rounded-full text-sm font-medium"
                                        :class="getStatusBadgeClass(user.status)"
                                    >
                                        {{ user.status }}
                                    </span>
                                </td>
                                <td class="border p-3">
                                    {{ formatDate(user.last_login_at) }}
                                </td>
                                <td class="border p-3">
                                    <div class="flex gap-2">
                                        <button
                                            class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 flex items-center gap-1"
                                            @click="editUser(user)"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 flex items-center gap-1"
                                            @click="confirmDelete(user)"
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

                <!-- No Users Message -->
                <div v-if="filteredUsers.length === 0" class="text-center py-8">
                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">No users found matching your criteria.</p>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Edit User</h3>
                    <button
                        @click="showEditModal = false"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        &times;
                    </button>
                </div>
                <form @submit.prevent="updateUser" class="space-y-4">
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
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select
                            id="role"
                            v-model="form.role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                            <option value="admin">Administrator</option>
                            <option value="moderator">Moderator</option>
                            <option value="editor">Editor</option>
                            <option value="user">User</option>
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
                    Are you sure you want to delete the user "{{ selectedUser?.username }}"? This action cannot be undone.
                </p>
                <div class="flex justify-end space-x-4">
                    <button
                        @click="showDeleteModal = false"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteUser"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    >
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
