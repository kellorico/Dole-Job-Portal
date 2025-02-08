<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';


</script>

<template>
   <AdminLayout>
      <div class="card" style="background-color: rgba(0, 0, 0, 0.7);">
                    <div class="card-body" style="background-color: rgba(0, 0, 0, 0.7); border-radius: 8px;">
                        <h4 class="card-title mb-4 text-white">Applicants</h4>
                        <div class="table-responsive bg-white" style="border-radius: 8px;">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Applicant Name</th>
                                        <th>Experience</th>
                                        <th>Key Skills</th>
                                        <th>Application Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td>5 Years</td>
                                        <td>Java, Spring Boots</td>
                                        <td>October 5, 2024</td>
                                        <td>Under Review</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#applicantModal">View</button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nextActionModal">Next</button>
                                        </td>
                                    </tr>
                                    <!-- More rows can go here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="applicantModal" tabindex="-1" aria-labelledby="applicantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applicantModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="scheduleInterview">
                        <label class="form-check-label" for="scheduleInterview">
                            Schedule Interview
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sendToHR">
                        <label class="form-check-label" for="sendToHR">
                             Send to HR for Background Check
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="offerJob">
                        <label class="form-check-label" for="offerJob">
                            Offer Job
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rejectApplicant">
                        <label class="form-check-label" for="rejectApplicant">
                            Reject Applicant
                        </label>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <label for="internalNotes" class="form-label">Internal Notes:</label>
                        <textarea class="form-control" id="internalNotes" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">
                            <i class="fas fa-envelope"></i> Email Message:
                        </label>
                        <input type="text" class="form-control" id="emailMessage" placeholder="Type your message">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Next</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Action Modal -->
    <div class="modal fade" id="nextActionModal" tabindex="-1" aria-labelledby="nextActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nextActionModalLabel">Next Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="scheduleInterview">
                        <label class="form-check-label" for="scheduleInterview">
                            Schedule Interview
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sendToHR">
                        <label class="form-check-label" for="sendToHR">
                            Send to HR for Background Check
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="offerJob">
                        <label class="form-check-label" for="offerJob">
                            Offer Job
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rejectApplicant">
                        <label class="form-check-label" for="rejectApplicant">
                            Reject Applicant
                        </label>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="internalNotes" class="form-label">Internal Notes:</label>
                        <textarea class="form-control" id="internalNotes" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">
                            <i class="fas fa-envelope"></i> Email Message:
                        </label>
                        <input type="text" class="form-control" id="emailMessage" placeholder="Type your message">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
   </AdminLayout>
</template>