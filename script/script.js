


function toggleEyePass() {
    const passwordInput = document.getElementById('password');
    const eyeBtn = document.getElementById('eyeBtn');
    const eyeIcon = eyeBtn.querySelector('i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('bi-eye-fill');
        eyeIcon.classList.add('bi-eye-slash-fill');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('bi-eye-slash-fill');
        eyeIcon.classList.add('bi-eye-fill');
    }
}