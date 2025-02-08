<script setup>
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const form = useForm({
   email: null,
   password: null,
});

// Submit function
const submit = () => {
   form.post('/admin/login', {
      onError: (errors) => {
         // If login fails, reset form and show SweetAlert
         form.reset();
         Swal.fire({
            title: 'Error',
            text: errors.email || 'These credentials do not match our records.',
            icon: 'error',
            confirmButtonText: 'Back'
         });
      },
   });
}
</script>

<template>
   <div class="body">
      <div class="container">
         <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12 col-md-6 col-lg-4">
               <div class="card p-4" id="loginForm">
                  <h3 class="text-center mb-3">Please Login</h3>
                  <form @submit.prevent="submit">
                     <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input 
                           type="email" 
                           class="form-control" 
                           v-model="form.email" 
                           :class="{'is-invalid': form.errors.email}"
                           required
                        >
                        <div v-if="form.errors.email" class="invalid-feedback">
                           {{ form.errors.email }}
                        </div>
                     </div>
                     <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input 
                           type="password" 
                           class="form-control" 
                           v-model="form.password" 
                           :class="{'is-invalid': form.errors.password}"
                           required
                        >
                        <div v-if="form.errors.password" class="invalid-feedback">
                           {{ form.errors.password }}
                        </div>
                     </div>
                     <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                     </div>
                     <button type="submit" class="btn btn-primary w-100">Login</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<style scoped>
.body {
   background: url('../../../../../public/components/img/background.png') no-repeat center center fixed;
   background-size: cover;
   font-family: "Poppins", sans-serif;
}

.card {
   background-color: rgba(37, 17, 17, 0.8);
   color: #fff;
   border-radius: 10px;
}

h3 {
   color: #fff;
}

.is-invalid {
   border-color: #dc3545;
}

.invalid-feedback {
   color: #dc3545;
}
</style>
