window.onload = () => {
    const sign_in_btn = document.querySelector("#sign-in-btn");
    const sign_up_btn = document.querySelector("#sign-up-btn");
    const container = document.querySelector(".container");
    
    const sign_in_btn2 = document.querySelector("#sign-in-btn2");
    const sign_up_btn2 = document.querySelector("#sign-up-btn2");
  
    sign_up_btn.addEventListener("click", () => {
      container.classList.add("sign-up-mode");
    });
    sign_in_btn.addEventListener("click", () => {
      container.classList.remove("sign-up-mode");
    });
    sign_up_btn2.addEventListener("click", () => {
      container.classList.add("sign-up-mode2");
    });
    sign_in_btn2.addEventListener("click", () => {
      container.classList.remove("sign-up-mode2");
    });
  
    const password = document.querySelector('#password');
    const retype_password = document.querySelector('#password_1');
    const togglePassword = document.querySelector('#togglePassword');
    const togglePassword_1 = document.querySelector('#togglePassword_1');
    const validationOutput = document.getElementById("password-validation");
    const togglePassword_login = document.querySelector('#togglePassword_login');
    const password_login = document.querySelector('#password_login');
    const reg = document.getElementById("reg");
    let passed = false;
  
    password.addEventListener("input", validatePassword);
    retype_password.addEventListener("input", validateRetypedPassword);
    togglePassword_login.addEventListener('click', togglePasswordVisibility.bind(null, password_login, togglePassword_login));
    togglePassword.addEventListener('click', togglePasswordVisibility.bind(null, password, togglePassword));
    togglePassword_1.addEventListener('click', togglePasswordVisibility.bind(null, retype_password, togglePassword_1));
  
    function hasMixedCharacters(str) {
      const hasLetter = /[a-zA-Z]/.test(str);
      const hasNumber = /\d/.test(str);
      return hasLetter && hasNumber;
    }
  
    function validatePassword() {
      const passwordValue = password.value;
      if (passwordValue.length < 8) {
        validationOutput.textContent = "Password must be at least 8 characters long.";
      } else if (!hasMixedCharacters(passwordValue)) {
        validationOutput.textContent = "Password must contain a mix of letters and numbers.";
      } else {
        validationOutput.textContent = "";
        passed = true;
      }
    }
  
    function validateRetypedPassword() {
      const passwordValue = password.value;
      const retypePasswordValue = retype_password.value;
  
      if (passwordValue !== retypePasswordValue) {
        validationOutput.textContent = "Entered passwords do not match.";
        password.parentElement.classList.add("error");
        retype_password.parentElement.classList.add("error");
      } else {
        password.parentElement.classList.remove("error");
        retype_password.parentElement.classList.remove("error");
        validationOutput.textContent = "";
      }
    }
  
    function togglePasswordVisibility(inputElement, toggleElement) {
      const type = inputElement.getAttribute('type') === 'password' ? 'text' : 'password';
      inputElement.setAttribute('type', type);
      toggleElement.classList.toggle('fa-eye-slash');
    }
      reg.onclick = () => {
      if (!passed || password.value !== retype_password.value) {
        if(password.value !== retype_password.value){
        alert("Passwords do not match or are invalid.");
        return false;}
        else if(!passed){
            alert("Password must include at least a mix of 8 characters and numbers.");
        }
      } else {
        sign_up.setAttribute('action', 'reg.php');
      }
    };
  };
  