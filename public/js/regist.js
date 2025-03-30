const form = document.getElementById('signupForm');
const email = document.getElementById('email');
const nameField = document.getElementById('name');
const username = document.getElementById('username');
const password = document.getElementById('password');
const emailError = document.getElementById('emailError');
const nameError = document.getElementById('nameError');
const usernameError = document.getElementById('usernameError');
const passwordError = document.getElementById('passwordError');
const successMessage = document.getElementById('successMessage');

// Hide all error messages by default
function hideErrors() {
    emailError.style.display = 'none';
    nameError.style.display = 'none';
    usernameError.style.display = 'none';
    passwordError.style.display = 'none';
    email.classList.remove('error');
    nameField.classList.remove('error');
    username.classList.remove('error');
    password.classList.remove('error');
}

// Validate form fields
function validateForm() {
    let valid = true;
    hideErrors();

    if (nameField.value.trim() === '') {
        nameError.style.display = 'block';
        nameField.classList.add('error');
        valid = false;
    }

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email.value)) {
        emailError.style.display = 'block';
        email.classList.add('error');
        valid = false;
    }

    if (username.value.trim() === '') {
        usernameError.style.display = 'block';
        username.classList.add('error');
        valid = false;
    }

    if (password.value.length < 6) {
        passwordError.style.display = 'block';
        password.classList.add('error');
        valid = false;
    }

    return valid;
}

form.addEventListener('submit', function (event) {
    event.preventDefault(); // Mencegah form dari pengiriman default

    if (validateForm()) {
        // Menampilkan pop-up
        alert('Welcome to PUREBEAUTY!');
        form.reset(); // Menghapus form

        // Redirect setelah 2 detik, jika diperlukan, bisa dibiarkan
        setTimeout(() => {
            // Ini mungkin tidak diperlukan jika sudah ada pengalihan di PHP
            window.location.href = 'login.php';
        }, 2000); // Delay 2 detik sebelum redirect
    }
});
