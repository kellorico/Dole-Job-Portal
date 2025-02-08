<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

// Initialize the form using useForm
const form = useForm({
    title: '',
    company: '',
    requirements: '',
    job_type: '',
    experience_level: '',
    min_salary: '',
    max_salary: '',
    location: '',
    salary_type: '',
    application_deadline: '',
});

// Handle form submission
const submit = () => {
    form.post('/admin/postjobs', {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'Job successfully posted.',
                icon: "success",
                confirmButtonText: 'Ok'
            });
            form.reset();
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to post job. Please check the input fields.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};
</script>

<template>
    <AdminLayout>
        <div class="p-3">
            <div class="p-10 bg-white shadow rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Post a Job</h2>
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input id="title" v-model="form.title"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  rows="3" placeholder="Enter job title"
                                  :class="{'border-red-500': form.errors.title}"/>
                        <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
                    </div>
                    <!-- company -->
                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                        <input id="company" v-model="form.company"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  rows="3" placeholder="Enter company"
                                  :class="{'border-red-500': form.errors.company}"/>
                        <p v-if="form.errors.company" class="mt-2 text-sm text-red-600">{{ form.errors.company }}</p>
                    </div>

                    <!-- Requirements -->
                    <div>
                        <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
                        <textarea id="requirements" v-model="form.requirements"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  rows="3" placeholder="Enter job requirements"
                                  :class="{'border-red-500': form.errors.requirements}"></textarea>
                        <p v-if="form.errors.requirements" class="mt-2 text-sm text-red-600">{{ form.errors.requirements }}</p>
                    </div>

                    <!-- Job Type and Experience Level -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Job Type</label>
                            <select id="jobType" v-model="form.job_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.job_type}">
                                <option value="" disabled>Select Job Type</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Contract">Contract</option>
                            </select>
                            <p v-if="form.errors.job_type" class="mt-2 text-sm text-red-600">{{ form.errors.job_type }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Experience Level</label>
                            <select id="experienceLevel" v-model="form.experience_level"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.experience_level}">
                                <option value="" disabled>Select Experience Level</option>
                                <option value="Entry">Entry</option>
                                <option value="Mid">Mid</option>
                                <option value="Senior">Senior</option>
                            </select>
                            <p v-if="form.errors.experience_level" class="mt-2 text-sm text-red-600">{{ form.errors.experience_level }}</p>
                        </div>
                    </div>

                    <!-- Salary Range and Type -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salary Range</label>
                            <div class="flex gap-2">
                                <input type="number" v-model="form.min_salary" placeholder="Min Salary"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       :class="{'border-red-500': form.errors.min_salary}">
                                <input type="number" v-model="form.max_salary" placeholder="Max Salary"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       :class="{'border-red-500': form.errors.max_salary}">
                            </div>
                            <p v-if="form.errors.min_salary" class="mt-2 text-sm text-red-600">{{ form.errors.min_salary }}</p>
                            <p v-if="form.errors.max_salary" class="mt-2 text-sm text-red-600">{{ form.errors.max_salary }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salary Type</label>
                            <select id="salaryType" v-model="form.salary_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.salary_type}">
                                <option value="" disabled>Select Salary Type</option>
                                <option value="Hourly">Hourly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                            </select>
                            <p v-if="form.errors.salary_type" class="mt-2 text-sm text-red-600">{{ form.errors.salary_type }}</p>
                        </div>
                    </div>

                    <!-- Application Deadline and Location -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Application Deadline</label>
                            <input type="date" v-model="form.application_deadline"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   :class="{'border-red-500': form.errors.application_deadline}">
                            <p v-if="form.errors.application_deadline" class="mt-2 text-sm text-red-600">{{ form.errors.application_deadline }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" v-model="form.location" placeholder="Enter location"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   :class="{'border-red-500': form.errors.location}">
                            <p v-if="form.errors.location" class="mt-2 text-sm text-red-600">{{ form.errors.location }}</p>
                        </div>
                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="flex justify-between items-center">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                            Post Job
                        </button>
                        <button type="reset" @click="form.reset"
                                class="px-4 py-2 bg-red-500 text-white rounded-md shadow hover:bg-red-600 focus:ring-2 focus:ring-red-500">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
