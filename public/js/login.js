
// Mendapatkan elemen-elemen form
const form = document.getElementById('signup1Form');
const username = document.getElementById('username');
const password = document.getElementById('password');
const successMessage = document.getElementById('success-message');

// Fungsi untuk validasi form
function validateForm() {
    if (username.value.trim() === '' || password.value.trim() === '') {
        alert('Username dan Password harus diisi!');
        return false; // Jika tidak valid
    }
    return true; // Jika valid
}

form.addEventListener('submit', function (event) {
    event.preventDefault();

    if (validateForm()) {
        // Menampilkan pop-up
        alert('Welcome to PUREBEAUTY!');
        form.reset(); // Menghapus form

        // Redirect setelah 2 detik
        setTimeout(() => {
            window.location.href = 'home.html';
        }, 2000); // Delay 2 detik sebelum redirect
    }
});
