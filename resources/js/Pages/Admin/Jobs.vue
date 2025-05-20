<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    jobs: Array,
});

const showDeleteModal = ref(false);
const selectedJob = ref(null);
const searchQuery = ref('');
const statusFilter = ref('all');

// Filter jobs based on search query and status
const filteredJobs = computed(() => {
    return props.jobs.filter(job => {
        const matchesSearch = job.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            job.company.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                            job.location.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesStatus = statusFilter.value === 'all' || job.status === statusFilter.value;
        return matchesSearch && matchesStatus;
    });
});

// Delete job
const confirmDelete = (job) => {
    selectedJob.value = job;
    showDeleteModal.value = true;
};

const deleteJob = () => {
    if (!selectedJob.value) return;

    router.delete(`/admin/jobs/${selectedJob.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            selectedJob.value = null;
            Swal.fire({
                title: 'Deleted!',
                text: 'Job has been deleted.',
                icon: 'success',
                confirmButtonText: 'OK',
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to delete job. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};

// Edit job
const editJob = (id) => {
    router.get(`/admin/jobs/${id}/edit`);
};

// View applicants
const viewApplicants = (id) => {
    router.get(`/admin/jobs/${id}/applicants`);
};

// Get status badge class
const getStatusBadgeClass = (status) => {
    const classes = {
        'active': 'bg-green-100 text-green-800',
        'draft': 'bg-yellow-100 text-yellow-800',
        'closed': 'bg-red-100 text-red-800',
        'expired': 'bg-gray-100 text-gray-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
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
                        <h2 class="text-2xl font-semibold text-gray-800">Job List</h2>
                        <p class="text-sm text-gray-600 mt-1">Manage and monitor all job postings</p>
                    </div>
                    <div class="flex gap-4">
                        <Link
                            :href="route('admin.jobs.create')"
                            class="px-4 py-2 bg-blue-600 text-white no-underline text-sm font-medium rounded hover:bg-blue-700 flex items-center gap-2"
                        >
                            <i class="fas fa-plus"></i>
                            Add Job
                        </Link>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="mb-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input
                            type="text"
                            v-model="searchQuery"
                            placeholder="Search jobs by title, company, or location..."
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                    <div class="w-full sm:w-48">
                        <select
                            v-model="statusFilter"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="draft">Draft</option>
                            <option value="closed">Closed</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                </div>

                <!-- Jobs Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-sm">
                            <tr>
                                <th class="border p-3">Title</th>
                                <th class="border p-3">Company</th>
                                <th class="border p-3">Type</th>
                                <th class="border p-3">Location</th>
                                <th class="border p-3">Salary</th>
                                <th class="border p-3">Status</th>
                                <th class="border p-3">Deadline</th>
                                <th class="border p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="job in filteredJobs"
                                :key="job.id"
                                class="even:bg-gray-50 hover:bg-gray-100"
                            >
                                <td class="border p-3">
                                    <div class="font-medium text-gray-900">{{ job.title }}</div>
                                    <div class="text-sm text-gray-500">{{ job.applicants_count }} applicants</div>
                                </td>
                                <td class="border p-3">{{ job.company }}</td>
                                <td class="border p-3">{{ job.job_type }}</td>
                                <td class="border p-3">{{ job.location }}</td>
                                <td class="border p-3">
                                    {{ job.min_salary }} - {{ job.max_salary }}
                                    <span class="text-sm text-gray-500">/{{ job.salary_type }}</span>
                                </td>
                                <td class="border p-3">
                                    <span 
                                        class="px-3 py-1 rounded-full text-sm font-medium"
                                        :class="getStatusBadgeClass(job.status)"
                                    >
                                        {{ job.status }}
                                    </span>
                                </td>
                                <td class="border p-3">
                                    <div :class="{'text-red-600': new Date(job.application_deadline) < new Date()}">
                                        {{ formatDate(job.application_deadline) }}
                                    </div>
                                </td>
                                <td class="border p-3">
                                    <div class="flex gap-2">
                                        <button
                                            class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 flex items-center gap-1"
                                            @click="viewApplicants(job.id)"
                                        >
                                            <i class="fas fa-users"></i>
                                            View
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 flex items-center gap-1"
                                            @click="editJob(job.id)"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 flex items-center gap-1"
                                            @click="confirmDelete(job)"
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

                <!-- No Jobs Message -->
                <div v-if="filteredJobs.length === 0" class="text-center py-8">
                    <i class="fas fa-briefcase text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">No jobs found matching your criteria.</p>
                </div>
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
                    Are you sure you want to delete the job "{{ selectedJob?.title }}"? This action cannot be undone.
                </p>
                <div class="flex justify-end space-x-4">
                    <button
                        @click="showDeleteModal = false"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteJob"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    >
                        Delete Job
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
