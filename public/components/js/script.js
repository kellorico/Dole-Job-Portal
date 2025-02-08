function redirectToSignup() {
    const loginForm = document.querySelector('.login-form');
    const signupForm = document.querySelector('.signup-form');

    loginForm.classList.add('slide-out');

    setTimeout(() => {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
        signupForm.classList.add('slide-in');
        signupForm.classList.remove('slide-out');
    }, 500);
}

function redirectToLogin() {
    const signupForm = document.querySelector('.signup-form');
    const loginForm = document.querySelector('.login-form');

    signupForm.classList.add('slide-out');

    setTimeout(() => {
        signupForm.style.display = 'none';
        loginForm.style.display = 'block';
        loginForm.classList.add('slide-in');
        loginForm.classList.remove('slide-out');
    }, 500);
}

window.onload = function() {
    const loginForm = document.querySelector('.login-form');
    loginForm.style.display = 'block';
};
