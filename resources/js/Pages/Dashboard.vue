<script setup>
import { ref } from 'vue';
import Main from "@/Layouts/Main.vue";

defineProps({
  jobs: Array,
});

// State to control the modal visibility and selected job details
const modalVisible = ref(false);
const selectedJob = ref(null);

// Open modal with job details
const openModal = (job) => {
  selectedJob.value = job;
  modalVisible.value = true;
};

// Close modal
const closeModal = () => {
  modalVisible.value = false;
  selectedJob.value = null;
};

const applyForJob = (job) => {
  alert(`You applied for job ID: ${job.id}`);
};
</script>

<template>
  <Main>
    <div class="flex">
      <!-- Content -->
      <div class="flex-1 absolute top-20 left-96 p-6">
        <h1 class="text-2xl font-bold mb-6 text-blue-900">Matches Jobs</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="job in jobs"
            :key="job.id"
            class="bg-white shadow-md rounded-lg p-6 border border-gray-200 hover:shadow-lg"
          >
            <h2 class="text-lg font-bold text-blue-800">{{ job.title }}</h2>
            <p class="text-sm text-gray-600"><strong>componay: {{ job.company }}</strong></p>
            <p class="text-sm text-gray-600 italic">location: {{ job.location }}</p>
            <p class="text-blue-800 relative">requirements:</p>
            <p class="mt-4 text-gray-700 text-sm">{{ job.requirements }}</p>
            <button
              class="mt-6 bg-blue-900 text-white px-4 py-2 rounded-md hover:bg-blue-800 mr-2"
              @click="applyForJob(job)"
            >
              Apply Now
            </button>
            <!-- View More Button -->
            <button
              class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-400"
              @click="openModal(job)"
            >
              View More
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="modalVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-xl font-bold text-blue-900 mb-4">{{ selectedJob?.title }}</h2>
        <p class="text-sm text-gray-600"><strong>Company:</strong> {{ selectedJob?.company }}</p>
        <p class="text-sm text-gray-600"><strong>Location:</strong> {{ selectedJob?.location }}</p>
        <p class="text-sm text-gray-600"><strong>Job Type:</strong> {{ selectedJob?.job_type }}</p>
        <p class="text-sm text-gray-600"><strong>Experience Level:</strong> {{ selectedJob?.experience_level || 'N/A' }}</p>
        <p class="text-sm text-gray-600"><strong>Salary Range:</strong> ${{ selectedJob?.min_salary }} - ${{ selectedJob?.max_salary }}</p>
        <p class="text-sm text-gray-600"><strong>Salary Type:</strong> {{ selectedJob?.salary_type }}</p>
        <p class="text-sm text-gray-600"><strong>Application Deadline:</strong> {{ selectedJob?.application_deadline || 'N/A' }}</p>
        <button
          class="mt-6 bg-blue-900 text-white px-4 py-2 rounded-md hover:bg-blue-800"
          @click="closeModal"
        >
          Close
        </button>
      </div>
    </div>
  </Main>
</template>

<style scoped>
/* Optional styling for modal */
.fixed {
  position: fixed;
}
</style>
