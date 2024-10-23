function checkPasswordStrength() {
    var password = document.getElementById('password').value;
    var strength = document.getElementById('passwordStrength');
    
    if (password.length < 8) {
        strength.innerHTML = "<span style='color:red;'>Weak</span>";
    } else if (password.match(/[A-Z]/) && password.match(/[a-z]/) && password.match(/\d/) && password.match(/\W/)) {
        strength.innerHTML = "<span style='color:green;'>Strong</span>";
    } else {
        strength.innerHTML = "<span style='color:orange;'>Medium</span>";
    }
}

function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var toggleButton = document.getElementById("togglePassword");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.textContent = "Hide";
    } else {
        passwordField.type = "password";
        toggleButton.textContent = "Show";
    }
}

function validateForm() {
    var captchaAnswer = document.getElementById('captcha').value;
    if (captchaAnswer != "13") {
        alert("Captcha is incorrect. Please try again.");
        return false;
    }
    return true;
}

const { spawn } = require('child_process');

const phpPath = 'C:\\xampp\\php\\php.exe';  // Ensure the PHP path is correct
const scriptPath = 'C:\\xampp\\htdocs\\Cybersecurity\\process_secure.php';  // Ensure the script path is correct

const child = spawn(phpPath, [scriptPath]);

child.stdout.on('data', (data) => {
    console.log(`Output: ${data}`);
});

child.stderr.on('data', (data) => {
    console.error(`Error: ${data}`);
});

child.on('close', (code) => {
    console.log(`Process exited with code ${code}`);
});

