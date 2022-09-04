const signUpForm = document.getElementById("sign-up-form");
const email = document.getElementById("email");
const username = document.getElementById("username");
const password = document.getElementById("password");
const confirm = document.getElementById("confirm");
const errorMessage = input => document.querySelector(`#${input} + small.error-message`);

email.addEventListener('input', () => {
    if (email.validity.valueMissing) {
        email.setCustomValidity("Please enter an email!");
    } else if (email.validity.typeMismatch) {
        email.setCustomValidity("Please enter a valid email!");
    } else {
        email.setCustomValidity("");
    }
    errorMessage("email").textContent = email.validationMessage;
});

username.addEventListener('input', () => {
    if (username.validity.valueMissing) {
        username.setCustomValidity("Please enter a username!");
    } else if (username.validity.tooShort) {
        username.setCustomValidity(`Your username must be at least ${username.minLength} characters!`);
    } else if (username.validity.tooLong) {
        username.setCustomValidity(`Your username can be at most ${username.maxLength} characters!`);
    } else if (containsIllegalCharacters(username.value)) {
        username.setCustomValidity("Your username can only contain letters, numbers, underscores and dashes!");
    } else {
        username.setCustomValidity("");
    }
    errorMessage("username").textContent = username.validationMessage;
});

password.addEventListener('input', () => {
    if (password.validity.valueMissing) {
        password.setCustomValidity("Please enter a password!");
    } else if (password.validity.tooShort) {
        password.setCustomValidity(`We require your password to be at least ${password.minLength} characters!`);
    } else if (containsNoDigit(password.value)) {
        password.setCustomValidity("We require your password to contain at least one digit!");
    } else if (containsNoSpecialCharacter(password.value)) {
        password.setCustomValidity(`Password must contain at least one of "${specialCharacters.join('')}"!`);
    } else {
        password.setCustomValidity("");
    }
    errorMessage("password").textContent = password.validationMessage;
});

confirm.addEventListener('input', () => {
    if (confirm.value !== password.value) {
        confirm.setCustomValidity("Passwords don't match!");
    } else {
        confirm.setCustomValidity("");
    }
    errorMessage("confirm").textContent = confirm.validationMessage;
});

signUpForm.addEventListener('submit', e => {
    if (!signUpForm.checkValidity()) {
        e.preventDefault();
    }
});

const allowedCharacters = /^[a-z\d_-]+$/i;
function containsIllegalCharacters(string) {
    return !allowedCharacters.test(string);
}

const digits = [...Array.from({length: 10}, (v, k) => `${k}`)];
function containsNoDigit(string) {
    return digits.every(char => !string.includes(char));
}

const specialCharacters = ['#', '$', '%', '&', '!', '?'];
function containsNoSpecialCharacter(string) {
    return specialCharacters.every(char => !string.includes(char));
}
