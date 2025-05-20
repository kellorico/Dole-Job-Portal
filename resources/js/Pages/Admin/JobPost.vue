<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { ref, computed } from 'vue';

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
    status: 'draft',
    description: '',
    benefits: '',
    skills_required: '',
});

const showPreviewModal = ref(false);
const showConfirmModal = ref(false);

// Computed property for form validation
const isFormValid = computed(() => {
    return form.title && 
           form.company && 
           form.requirements && 
           form.job_type && 
           form.experience_level && 
           form.min_salary && 
           form.max_salary && 
           form.location && 
           form.salary_type && 
           form.application_deadline;
});

// Format date for display
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

// Handle form submission
const submit = () => {
    if (!isFormValid.value) {
        Swal.fire({
            title: 'Validation Error',
            text: 'Please fill in all required fields.',
            icon: 'error',
            confirmButtonText: 'OK',
        });
        return;
    }

    showConfirmModal.value = true;
};

const confirmSubmit = () => {
    form.post('/admin/postjobs', {
        preserveScroll: true,
        onSuccess: () => {
            showConfirmModal.value = false;
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

const previewJob = () => {
    if (!isFormValid.value) {
        Swal.fire({
            title: 'Validation Error',
            text: 'Please fill in all required fields before previewing.',
            icon: 'error',
            confirmButtonText: 'OK',
        });
        return;
    }
    showPreviewModal.value = true;
};

const resetForm = () => {
    Swal.fire({
        title: 'Reset Form',
        text: 'Are you sure you want to reset all fields?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, reset it!',
        cancelButtonText: 'No, keep it!',
    }).then((result) => {
        if (result.isConfirmed) {
            form.reset();
        }
    });
};
</script>

<template>
    <AdminLayout>
        <div class="p-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Post a Job</h2>
                        <p class="text-sm text-gray-600 mt-1">Create a new job posting</p>
                    </div>
                    <Link
                        :href="route('admin.jobs')"
                        class="px-4 py-2 bg-gray-600 text-white no-underline text-sm font-medium rounded hover:bg-gray-700 flex items-center gap-2"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Back to Jobs
                    </Link>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Basic Information Section -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Job Title *</label>
                                <input
                                    id="title"
                                    v-model="form.title"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.title}"
                                    placeholder="Enter job title"
                                />
                                <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
                            </div>

                            <!-- Company -->
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700">Company *</label>
                                <input
                                    id="company"
                                    v-model="form.company"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.company}"
                                    placeholder="Enter company name"
                                />
                                <p v-if="form.errors.company" class="mt-2 text-sm text-red-600">{{ form.errors.company }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details Section -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Job Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Job Type *</label>
                                <select
                                    id="jobType"
                                    v-model="form.job_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.job_type}"
                                >
                                    <option value="" disabled>Select Job Type</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Temporary">Temporary</option>
                                </select>
                                <p v-if="form.errors.job_type" class="mt-2 text-sm text-red-600">{{ form.errors.job_type }}</p>
                            </div>

                            <!-- Experience Level -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Experience Level *</label>
                                <select
                                    id="experienceLevel"
                                    v-model="form.experience_level"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.experience_level}"
                                >
                                    <option value="" disabled>Select Experience Level</option>
                                    <option value="Entry">Entry Level</option>
                                    <option value="Mid">Mid Level</option>
                                    <option value="Senior">Senior Level</option>
                                    <option value="Executive">Executive Level</option>
                                </select>
                                <p v-if="form.errors.experience_level" class="mt-2 text-sm text-red-600">{{ form.errors.experience_level }}</p>
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location *</label>
                                <input
                                    type="text"
                                    v-model="form.location"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.location}"
                                    placeholder="Enter job location"
                                />
                                <p v-if="form.errors.location" class="mt-2 text-sm text-red-600">{{ form.errors.location }}</p>
                            </div>

                            <!-- Application Deadline -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Application Deadline *</label>
                                <input
                                    type="date"
                                    v-model="form.application_deadline"
                                    :min="new Date().toISOString().split('T')[0]"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.application_deadline}"
                                />
                                <p v-if="form.errors.application_deadline" class="mt-2 text-sm text-red-600">{{ form.errors.application_deadline }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Salary Information Section -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Salary Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Min Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Minimum Salary *</label>
                                <input
                                    type="number"
                                    v-model="form.min_salary"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.min_salary}"
                                    placeholder="Enter minimum salary"
                                />
                                <p v-if="form.errors.min_salary" class="mt-2 text-sm text-red-600">{{ form.errors.min_salary }}</p>
                            </div>

                            <!-- Max Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Maximum Salary *</label>
                                <input
                                    type="number"
                                    v-model="form.max_salary"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.max_salary}"
                                    placeholder="Enter maximum salary"
                                />
                                <p v-if="form.errors.max_salary" class="mt-2 text-sm text-red-600">{{ form.errors.max_salary }}</p>
                            </div>

                            <!-- Salary Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Salary Type *</label>
                                <select
                                    id="salaryType"
                                    v-model="form.salary_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.salary_type}"
                                >
                                    <option value="" disabled>Select Salary Type</option>
                                    <option value="Hourly">Hourly</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                                <p v-if="form.errors.salary_type" class="mt-2 text-sm text-red-600">{{ form.errors.salary_type }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description Section -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Description</h3>
                        <div class="space-y-6">
                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter job description"
                                ></textarea>
                            </div>

                            <!-- Requirements -->
                            <div>
                                <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements *</label>
                                <textarea
                                    id="requirements"
                                    v-model="form.requirements"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    :class="{'border-red-500': form.errors.requirements}"
                                    placeholder="Enter job requirements"
                                ></textarea>
                                <p v-if="form.errors.requirements" class="mt-2 text-sm text-red-600">{{ form.errors.requirements }}</p>
                            </div>

                            <!-- Skills Required -->
                            <div>
                                <label for="skills_required" class="block text-sm font-medium text-gray-700">Skills Required</label>
                                <textarea
                                    id="skills_required"
                                    v-model="form.skills_required"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter required skills (comma-separated)"
                                ></textarea>
                            </div>

                            <!-- Benefits -->
                            <div>
                                <label for="benefits" class="block text-sm font-medium text-gray-700">Benefits</label>
                                <textarea
                                    id="benefits"
                                    v-model="form.benefits"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter job benefits"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button
                            type="button"
                            @click="resetForm"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Reset
                        </button>
                        <button
                            type="button"
                            @click="previewJob"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Preview
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Posting...</span>
                            <span v-else>Post Job</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Modal -->
        <div v-if="showPreviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Job Preview</h3>
                    <button
                        @click="showPreviewModal = false"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        &times;
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <h2 class="text-2xl font-bold text-gray-900">{{ form.title }}</h2>
                        <p class="text-gray-600">{{ form.company }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Job Type</p>
                            <p class="font-medium">{{ form.job_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Experience Level</p>
                            <p class="font-medium">{{ form.experience_level }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-medium">{{ form.location }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Salary</p>
                            <p class="font-medium">{{ form.min_salary }} - {{ form.max_salary }} / {{ form.salary_type }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Description</h4>
                        <p class="text-gray-600 whitespace-pre-line">{{ form.description }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Requirements</h4>
                        <p class="text-gray-600 whitespace-pre-line">{{ form.requirements }}</p>
                    </div>
                    <div v-if="form.skills_required">
                        <h4 class="font-medium text-gray-900 mb-2">Skills Required</h4>
                        <p class="text-gray-600">{{ form.skills_required }}</p>
                    </div>
                    <div v-if="form.benefits">
                        <h4 class="font-medium text-gray-900 mb-2">Benefits</h4>
                        <p class="text-gray-600 whitespace-pre-line">{{ form.benefits }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Application Deadline: {{ formatDate(form.application_deadline) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div v-if="showConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Confirm Job Posting</h3>
                    <button
                        @click="showConfirmModal = false"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        &times;
                    </button>
                </div>
                <p class="text-gray-600 mb-4">Are you sure you want to post this job?</p>
                <div class="flex justify-end space-x-4">
                    <button
                        @click="showConfirmModal = false"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                    <button
                        @click="confirmSubmit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Posting...</span>
                        <span v-else>Confirm Post</span>
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
