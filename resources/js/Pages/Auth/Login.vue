<script setup>
import Main from '@/Layouts/Main.vue';
import { useForm } from '@inertiajs/vue3';
import ErrorMessages from '@/Components/ErrorMessages.vue';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'))
}
</script>

<template>
    <Main>
        <div class="bg-white shadow-lg mx-auto rounded-lg p-8 max-w-md w-full mt-2 top-24">
            <div class="text-center">
                <img src="/components/img/logo.png" alt="Job Portal Logo" class="mx-auto w-24">
                <h2 class="text-xl font-bold text-gray-700 mt-4">Welcome Back!</h2>
            </div>

            <ErrorMessages :errors="form.errors"/>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" v-model="form.email">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input type="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" v-model="form.password">
                </div>
                <div class="flex justify-between items-center mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" class="mr-2"> Remember me
                    </label>
                    <a href="#" class="text-sm text-blue-500 hover:underline">Forgot password?</a>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Login</button>
            </form>
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">Connect with us:</p>
                <div class="flex justify-center mt-4 space-x-4">
                    <a href="#" class="text-gray-500 hover:text-blue-500"><i class="bi bi-facebook text-2xl"></i></a>
                    <a href="#" class="text-gray-500 hover:text-pink-500"><i class="bi bi-instagram text-2xl"></i></a>
                    <a href="#" class="text-gray-500 hover:text-blue-400"><i class="bi bi-twitter text-2xl"></i></a>
                </div>
            </div>
            <p class="text-center text-sm text-gray-600 mt-6">Don't have an account? <a href="signup.html" class="text-blue-500 hover:underline">Sign up</a></p>
        </div>
    </Main>
</template>
