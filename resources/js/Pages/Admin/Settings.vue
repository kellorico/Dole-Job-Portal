<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<template>
   <AdminLayout>
      <div id="settingsSection" class="container mx-auto my-8 max-w-4xl px-4">
         <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="border-b pb-4 mb-6">
               <h2 class="text-2xl font-semibold text-gray-800">Settings</h2>
            </div>
            <form>
               <!-- Username -->
               <div class="mb-4">
                  <label for="username" class="text-sm font-medium text-gray-600">Username</label>
                  <input type="text" id="username" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="JohnDoe">
               </div>

               <!-- Email -->
               <div class="mb-4">
                  <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                  <input type="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="john.doe@example.com">
               </div>

               <!-- Password -->
               <div class="mb-4">
                  <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                  <input type="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
               </div>

               <!-- Confirm Password -->
               <div class="mb-6">
                  <label for="confirmPassword" class="text-sm font-medium text-gray-600">Confirm Password</label>
                  <input type="password" id="confirmPassword" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
               </div>

               <!-- Action Buttons -->
               <div class="flex justify-end space-x-4">
                  <button type="button" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
                  <button type="button" class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition duration-200" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete Account</button>
               </div>
            </form>
         </div>
      </div>

      <!-- Update Modal -->
      <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="updateModalLabel">Update Settings</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  Are you sure you want to update your settings?
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary">Save Changes</button>
               </div>
            </div>
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
                  <button type="button" class="btn btn-danger">Delete Account</button>
               </div>
            </div>
         </div>
      </div>
   </AdminLayout>
</template>
