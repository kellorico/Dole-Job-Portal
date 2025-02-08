<script setup>
import Main from '@/Layouts/Main.vue';
import { useForm } from '@inertiajs/vue3';
import ErrorMessages from '@/Components/ErrorMessages.vue';

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
}
</script>

<template>
    <Main>
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full mx-auto mt-3 top-24 min-h-[30rem]">
  <div class="text-center mb-6">
    <img src="/components/img/logo.png" alt="Job Portal Logo" class="mx-auto w-24">
    <h2 class="text-xl font-bold text-gray-700 mt-4">Create Your Account</h2>
  </div>

  <!-- Display errors, if any -->
  <ErrorMessages :errors="form.errors" />

  <form @submit.prevent="submit">
    <div class="mb-4">
      <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
      <input type="text" id="username"
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        v-model="form.username">
    </div>
    <div class="mb-4">
      <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
      <input type="email" id="email"
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        v-model="form.email">
    </div>
    <div class="mb-4">
      <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
      <input type="password" id="password"
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        v-model="form.password">
    </div>
    <div class="mb-4">
      <label for="confirm-password" class="block text-sm font-medium text-gray-600">Confirm Password</label>
      <input type="password" id="confirm-password"
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
        v-model="form.password_confirmation">
    </div>
    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Sign Up</button>
  </form>

  <div class="text-center mt-6">
    <p class="text-sm text-gray-600">Connect with us:</p>
    <div class="flex justify-center mt-4 space-x-4">
      <a href="#" class="text-gray-500 hover:text-blue-500"><i class="fab fa-facebook text-2xl"></i></a>
      <a href="#" class="text-gray-500 hover:text-pink-500"><i class="fab fa-instagram text-2xl"></i></a>
      <a href="#" class="text-gray-500 hover:text-blue-400"><i class="fab fa-twitter text-2xl"></i></a>
    </div>
  </div>

  <p class="text-center text-sm text-gray-600 mt-6">Already have an account? <a href="login.html" class="text-blue-500 hover:underline">Login</a></p>
</div>

    </Main>
</template>
