document.addEventListener("DOMContentLoaded", () => {
  // 1. Bootstrap-style form validation
  const forms = document.querySelectorAll("form.needs-validation");

  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          // Prevent submit if HTML5 validation fails
          event.preventDefault();
          event.stopPropagation();
        } else {
          // prevent double submit
          const submitBtn = form.querySelector('[type="submit"]');
          if (submitBtn && !submitBtn.dataset.submitted) {
            submitBtn.dataset.submitted = "true";
            submitBtn.disabled = true;
            submitBtn.dataset.originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = "Please wait...";
          } else if (submitBtn) {
            // Already submitted once – block extra submits
            event.preventDefault();
          }
        }

        form.classList.add("was-validated");
      },
      false
    );
  });

  // 2. Password strength + match
  const password = document.querySelector("#password");
  const confirmPassword = document.querySelector("#confirm_password");
  const strengthText = document.querySelector("#passwordStrength");
  const matchText = document.querySelector("#passwordMatch");

  function evaluateStrength(pw) {
    if (!pw || pw.length < 6) return { level: 0, label: "Too short" };

    let score = 0;
    if (pw.length >= 8) score++;
    if (/[A-Z]/.test(pw)) score++;
    if (/[0-9]/.test(pw)) score++;
    if (/[^A-Za-z0-9]/.test(pw)) score++;

    if (score <= 1) return { level: 1, label: "Weak" };
    if (score === 2) return { level: 2, label: "Medium" };
    return { level: 3, label: "Strong" };
  }

  function updatePasswordUI() {
    if (password && strengthText) {
      const value = password.value;
      const result = evaluateStrength(value);

      if (!value) {
        strengthText.textContent = "";
        strengthText.className = "form-text";
      } else {
        strengthText.textContent = "Password strength: " + result.label;
        strengthText.className = "form-text";

        if (result.level === 0 || result.level === 1) {
          strengthText.classList.add("text-danger");
        } else if (result.level === 2) {
          strengthText.classList.add("text-warning");
        } else if (result.level === 3) {
          strengthText.classList.add("text-success");
        }
      }
    }

    // Password match
    if (password && confirmPassword && matchText) {
      const pw = password.value;
      const cpw = confirmPassword.value;

      if (!pw && !cpw) {
        matchText.textContent = "";
        matchText.className = "form-text";
        return;
      }

      if (pw === cpw) {
        matchText.textContent = "Passwords match";
        matchText.className = "form-text text-success";
      } else {
        matchText.textContent = "Passwords do not match";
        matchText.className = "form-text text-danger";
      }
    }
  }

  if (password) {
    password.addEventListener("input", updatePasswordUI);
  }
  if (confirmPassword) {
    confirmPassword.addEventListener("input", updatePasswordUI);
  }
});
