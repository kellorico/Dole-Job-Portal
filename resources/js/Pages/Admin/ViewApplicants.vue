<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const props = defineProps({
    applicants: Array,
    job: Object,
});

const form = useForm({
    status: '',
    internal_notes: '',
    email_message: '',
    action: '', // schedule_interview, hr_check, offer_job, reject
});

const showApplicantModal = ref(false);
const showNextActionModal = ref(false);
const selectedApplicant = ref(null);

const viewApplicant = (applicant) => {
    selectedApplicant.value = applicant;
    showApplicantModal.value = true;
};

const handleNextAction = (applicant) => {
    selectedApplicant.value = applicant;
    showNextActionModal.value = true;
};

const updateApplicantStatus = () => {
    if (!selectedApplicant.value) return;

    form.put(`/admin/applicants/${selectedApplicant.value.id}/update`, {
        preserveScroll: true,
        onSuccess: () => {
            showApplicantModal.value = false;
            showNextActionModal.value = false;
            Swal.fire({
                title: 'Success!',
                text: 'Applicant status updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK',
            });
            form.reset();
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update applicant status. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};

const getStatusBadgeClass = (status) => {
    const classes = {
        'Under Review': 'bg-yellow-100 text-yellow-800',
        'Interview Scheduled': 'bg-blue-100 text-blue-800',
        'HR Check': 'bg-purple-100 text-purple-800',
        'Job Offered': 'bg-green-100 text-green-800',
        'Rejected': 'bg-red-100 text-red-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
   <AdminLayout>
      <div class="p-6">
         <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
               <h2 class="text-2xl font-semibold text-gray-800">Applicants for {{ job?.title }}</h2>
               <Link
                  :href="route('admin.jobs')"
                  class="px-4 py-2 bg-blue-600 text-white no-underline text-sm font-medium rounded hover:bg-blue-700"
               >
                  Back to Jobs
               </Link>
            </div>

            <!-- Applicants Table -->
            <div class="overflow-x-auto">
               <table class="w-full text-left border-collapse">
                  <thead class="bg-gray-100 text-sm">
                     <tr>
                        <th class="border p-3">ID</th>
                        <th class="border p-3">Applicant Name</th>
                        <th class="border p-3">Experience</th>
                        <th class="border p-3">Key Skills</th>
                        <th class="border p-3">Application Date</th>
                        <th class="border p-3">Status</th>
                        <th class="border p-3">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr v-for="applicant in applicants" :key="applicant.id" class="even:bg-gray-50 hover:bg-gray-100">
                        <td class="border p-3">{{ applicant.id }}</td>
                        <td class="border p-3">{{ applicant.name }}</td>
                        <td class="border p-3">{{ applicant.experience }}</td>
                        <td class="border p-3">{{ applicant.skills }}</td>
                        <td class="border p-3">{{ applicant.application_date }}</td>
                        <td class="border p-3">
                           <span 
                              class="px-3 py-1 rounded-full text-sm font-medium"
                              :class="getStatusBadgeClass(applicant.status)"
                           >
                              {{ applicant.status }}
                           </span>
                        </td>
                        <td class="border p-3">
                           <div class="flex gap-2">
                              <button
                                 @click="viewApplicant(applicant)"
                                 class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600"
                              >
                                 View
                              </button>
                              <button
                                 @click="handleNextAction(applicant)"
                                 class="px-4 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600"
                              >
                                 Next Action
                              </button>
                           </div>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>

      <!-- View Applicant Modal -->
      <div v-if="showApplicantModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
         <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
               <h3 class="text-lg font-semibold text-gray-800">Applicant Profile</h3>
               <button
                  @click="showApplicantModal = false"
                  class="text-gray-500 hover:text-gray-700"
               >
                  &times;
               </button>
            </div>

            <div v-if="selectedApplicant" class="space-y-4">
               <!-- Applicant Details -->
               <div class="grid grid-cols-2 gap-4">
                  <div>
                     <label class="block text-sm font-medium text-gray-600">Name</label>
                     <p class="mt-1">{{ selectedApplicant.name }}</p>
                  </div>
                  <div>
                     <label class="block text-sm font-medium text-gray-600">Email</label>
                     <p class="mt-1">{{ selectedApplicant.email }}</p>
                  </div>
                  <div>
                     <label class="block text-sm font-medium text-gray-600">Experience</label>
                     <p class="mt-1">{{ selectedApplicant.experience }}</p>
                  </div>
                  <div>
                     <label class="block text-sm font-medium text-gray-600">Skills</label>
                     <p class="mt-1">{{ selectedApplicant.skills }}</p>
                  </div>
               </div>

               <!-- Action Checkboxes -->
               <div class="space-y-2">
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="scheduleInterview"
                        v-model="form.action"
                        value="schedule_interview"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="scheduleInterview" class="ml-2 text-sm text-gray-700">Schedule Interview</label>
                  </div>
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="sendToHR"
                        v-model="form.action"
                        value="hr_check"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="sendToHR" class="ml-2 text-sm text-gray-700">Send to HR for Background Check</label>
                  </div>
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="offerJob"
                        v-model="form.action"
                        value="offer_job"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="offerJob" class="ml-2 text-sm text-gray-700">Offer Job</label>
                  </div>
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="rejectApplicant"
                        v-model="form.action"
                        value="reject"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="rejectApplicant" class="ml-2 text-sm text-gray-700">Reject Applicant</label>
                  </div>
               </div>

               <!-- Notes and Messages -->
               <div class="space-y-4">
                  <div>
                     <label for="internalNotes" class="block text-sm font-medium text-gray-700">Internal Notes</label>
                     <textarea
                        id="internalNotes"
                        v-model="form.internal_notes"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                     ></textarea>
                  </div>
                  <div>
                     <label for="emailMessage" class="block text-sm font-medium text-gray-700">Email Message</label>
                     <textarea
                        id="emailMessage"
                        v-model="form.email_message"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                     ></textarea>
                  </div>
               </div>

               <!-- Action Buttons -->
               <div class="flex justify-end space-x-4 mt-6">
                  <button
                     @click="showApplicantModal = false"
                     class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                  >
                     Cancel
                  </button>
                  <button
                     @click="updateApplicantStatus"
                     class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                     :disabled="form.processing"
                  >
                     <span v-if="form.processing">Updating...</span>
                     <span v-else>Save Changes</span>
                  </button>
               </div>
            </div>
         </div>
      </div>

      <!-- Next Action Modal -->
      <div v-if="showNextActionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
         <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
               <h3 class="text-lg font-semibold text-gray-800">Next Actions</h3>
               <button
                  @click="showNextActionModal = false"
                  class="text-gray-500 hover:text-gray-700"
               >
                  &times;
               </button>
            </div>

            <div class="space-y-4">
               <!-- Action Checkboxes -->
               <div class="space-y-2">
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="nextScheduleInterview"
                        v-model="form.action"
                        value="schedule_interview"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="nextScheduleInterview" class="ml-2 text-sm text-gray-700">Schedule Interview</label>
                  </div>
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="nextSendToHR"
                        v-model="form.action"
                        value="hr_check"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="nextSendToHR" class="ml-2 text-sm text-gray-700">Send to HR for Background Check</label>
                  </div>
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="nextOfferJob"
                        v-model="form.action"
                        value="offer_job"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="nextOfferJob" class="ml-2 text-sm text-gray-700">Offer Job</label>
                  </div>
                  <div class="flex items-center">
                     <input
                        type="checkbox"
                        id="nextRejectApplicant"
                        v-model="form.action"
                        value="reject"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                     >
                     <label for="nextRejectApplicant" class="ml-2 text-sm text-gray-700">Reject Applicant</label>
                  </div>
               </div>

               <!-- Notes and Messages -->
               <div class="space-y-4">
                  <div>
                     <label for="nextInternalNotes" class="block text-sm font-medium text-gray-700">Internal Notes</label>
                     <textarea
                        id="nextInternalNotes"
                        v-model="form.internal_notes"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                     ></textarea>
                  </div>
                  <div>
                     <label for="nextEmailMessage" class="block text-sm font-medium text-gray-700">Email Message</label>
                     <textarea
                        id="nextEmailMessage"
                        v-model="form.email_message"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                     ></textarea>
                  </div>
               </div>

               <!-- Action Buttons -->
               <div class="flex justify-end space-x-4 mt-6">
                  <button
                     @click="showNextActionModal = false"
                     class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                  >
                     Cancel
                  </button>
                  <button
                     @click="updateApplicantStatus"
                     class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                     :disabled="form.processing"
                  >
                     <span v-if="form.processing">Saving...</span>
                     <span v-else>Save Changes</span>
                  </button>
               </div>
            </div>
         </div>
      </div>
   </AdminLayout>
</template>