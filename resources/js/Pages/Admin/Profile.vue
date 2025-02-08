<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

</script>

<template>
   <AdminLayout>
      <div id="profileSection" class="container mx-auto my-8 max-w-4xl px-4">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center border-b pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Profile</h2>
                </div>
                <div class="text-center mb-6">
                    <img id="profileImage" src="/components/img/default-avatar.png" alt="Profile" class="rounded-full mb-4 w-24 h-24 object-cover mx-auto">
                </div>
                <div class="space-y-4">
                    <!-- User Info -->
                    <div class="flex flex-col space-y-1">
                        <label for="name" class="text-sm font-medium text-gray-600">Name</label>
                        <input type="text" id="name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="John Doe" readonly>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input type="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="john.doe@example.com" readonly>
                    </div>
                </div>
                <div class="mt-6 flex justify-center">
                    <button
                        type="button"
                        class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition duration-200"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteAccountModal">
                        Delete Account
                    </button>
                </div>
            </div>

            <!-- Delete Account Modal -->
            <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete your account? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" onclick="deleteAccount()">Delete Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </AdminLayout>
</template>
