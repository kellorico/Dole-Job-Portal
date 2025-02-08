<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    jobs: Array,
});

// Delete job
const deleteJob = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/admin/jobs/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
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
        }
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
</script>

<template>
    <AdminLayout>
        <div class="p-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Job List</h2>
                    <Link
                        :href="route('admin.jobs.create')"
                        class="px-4 py-2 bg-blue-600 text-white no-underline text-sm font-medium rounded hover:bg-blue-700"
                    >
                        Add Job
                    </Link>
                </div>
                <div>
                    <template v-if="jobs.length > 0">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-100 text-sm">
                                <tr>
                                    <th class="border p-3">#</th>
                                    <th class="border p-3">Title</th>
                                    <th class="border p-3">Type</th>
                                    <th class="border p-3">Location</th>
                                    <th class="border p-3">Salary</th>
                                    <th class="border p-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(job, index) in jobs"
                                    :key="job.id"
                                    class="even:bg-gray-50 hover:bg-gray-100"
                                >
                                    <td class="border p-3">{{ index + 1 }}</td>
                                    <td class="border p-3">{{ job.title }}</td>
                                    <td class="border p-3">{{ job.job_type }}</td>
                                    <td class="border p-3">{{ job.location }}</td>
                                    <td class="border p-3">{{ job.min_salary }} - {{ job.max_salary }}</td>
                                    <td class="border p-3 flex gap-2">
                                        <button
                                            class="px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600"
                                            @click="editJob(job.id)"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                                            @click="deleteJob(job.id)"
                                        >
                                            Delete
                                        </button>
                                        <button
                                            class="px-4 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600"
                                            @click="viewApplicants(job.id)"
                                        >
                                            Applicants
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <p v-else class="text-center text-gray-500">
                        No jobs found. Click "Add Job" to create one.
                    </p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
