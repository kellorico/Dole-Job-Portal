// Handle switching between login and register forms
document.getElementById('goToRegister').addEventListener('click', function (event) {
    event.preventDefault();
    document.getElementById('loginForm').classList.add('d-none');
    document.getElementById('registerForm').classList.remove('d-none');
  });
  
  document.getElementById('goToLogin').addEventListener('click', function (event) {
    event.preventDefault();
    document.getElementById('loginForm').classList.remove('d-none');
    document.getElementById('registerForm').classList.add('d-none');
  });
  
//profile dropdown
function dropdown() {
    document.getElementById("dropdown").classList.toggle("show");
}
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdown = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0;i < dropdown.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
      }
    }   
}


 
 