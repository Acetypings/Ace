// set year in footer
document.getElementById("year").textContent = new Date().getFullYear();

const loginForm = document.getElementById("login-form");
const signupForm = document.getElementById("signup-form");
const title = document.getElementById("card-title");
const subtitle = document.getElementById("card-sub");

// show/hide forms
function showLogin() {
  signupForm.classList.add("hidden");
  loginForm.classList.remove("hidden");
  title.textContent = "Welcome back";
  subtitle.textContent = "Sign in to continue to Customer Feedback Monitoring";
}

function showSignup() {
  loginForm.classList.add("hidden");
  signupForm.classList.remove("hidden");
  title.textContent = "Create an account";
  subtitle.textContent = "Join to start monitoring customer feedback";
}

document.getElementById("to-signup").addEventListener("click", showSignup);
document.getElementById("to-login").addEventListener("click", showLogin);

// password toggle logic
document.querySelectorAll("[data-toggle-target]").forEach((btn) => {
  btn.addEventListener("click", () => {
    const input = document.querySelector(btn.dataset.toggleTarget);
    const icon = btn.querySelector("i");

    if (!input || !icon) return;

    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    }
  });
});

// custom dropdown logic
const roleBtn = document.getElementById("role-dropdown-btn");
const roleMenu = document.getElementById("role-dropdown-menu");
const roleLabel = document.getElementById("role-dropdown-label");
const roleHidden = document.getElementById("role-input");

if (roleBtn && roleMenu && roleLabel && roleHidden) {
  roleBtn.addEventListener("click", () => {
    roleMenu.classList.toggle("hidden");
  });

  roleMenu.querySelectorAll("button").forEach((option) => {
    option.addEventListener("click", () => {
      const value = option.dataset.value;
      roleHidden.value = value;
      roleLabel.textContent = option.textContent;
      roleMenu.classList.add("hidden");

      // update card title dynamically
      if (value === "customer") {
        title.textContent = "Create a Customer Account";
      } else if (value === "staff") {
        title.textContent = "Create a Staff Account";
      } else {
        title.textContent = "Create an account";
      }
      subtitle.textContent = "Join to start monitoring customer feedback";
    });
  });

  // close dropdown when clicking outside
  document.addEventListener("click", (e) => {
    if (!roleBtn.contains(e.target) && !roleMenu.contains(e.target)) {
      roleMenu.classList.add("hidden");
    }
  });
}
