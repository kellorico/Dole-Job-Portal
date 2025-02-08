// Toggle between Login and Signup
document.getElementById('show-signup').addEventListener('click', function (e) {
   e.preventDefault();
   document.getElementById('login-form').classList.add('d-none');
   document.getElementById('signup-form').classList.remove('d-none');
 });
 
 document.getElementById('show-login').addEventListener('click', function (e) {
   e.preventDefault();
   document.getElementById('signup-form').classList.add('d-none');
   document.getElementById('login-form').classList.remove('d-none');
 });