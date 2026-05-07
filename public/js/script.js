document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".container");

  // ambil SEMUA tombol register
  const registerBtns = document.querySelectorAll(".register-btn");
  const loginBtns = document.querySelectorAll(".login-btn");

  registerBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      container.classList.add("active");
    });
  });

  loginBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      container.classList.remove("active");
    });
  });

  // tombol submit register form
  const registerForm = document.querySelector(".form-box.register form");

  registerForm.addEventListener("submit", function (e) {
    e.preventDefault();
    alert("Registrasi berhasil!");
    container.classList.remove("active");
  });

  // ===============================
  // ✅ TAMBAHAN UNTUK LOGIN REDIRECT
  // ===============================
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      window.location.href = "index.html";
    });
  }
});
