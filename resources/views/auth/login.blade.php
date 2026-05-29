<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIROP - Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
<div class="container">

    {{-- FORM LOGIN --}}
    <div class="form-box login">
        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            <h1>Login</h1>

            @if ($errors->any())
                <div style="color:red; font-size:13px; margin-bottom:10px;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div style="color:green; font-size:13px; margin-bottom:10px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="input-box">
                <input type="email" name="email" placeholder="Email"
                    value="{{ old('email') }}" required />
                <i class="fa-solid fa-envelope"></i>
            </div>

            {{-- PASSWORD LOGIN + TOGGLE MATA --}}
            <div class="input-box" style="position:relative;">
                <input type="password" name="password" id="passwordLogin" placeholder="Password" required />
                <i class="fa-solid fa-lock"></i>
                <span onclick="togglePassword('passwordLogin', this)"
                      style="position:absolute; right:40px; top:50%; transform:translateY(-50%); cursor:pointer;">
                    <i class="fa-solid fa-eye-slash"></i>
                </span>
            </div>

            <div class="forget-link">
                <a href="#">Lupa Password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>

    {{-- FORM REGISTER --}}
    <div class="form-box register">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <h1>Registrasi</h1>
            <div class="input-box">
                <input type="text" name="name" placeholder="Nama"
                    value="{{ old('name') }}" required />
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email"
                    value="{{ old('email') }}" required />
                <i class="fa-solid fa-envelope"></i>
            </div>

            {{-- PASSWORD REGISTER + TOGGLE MATA --}}
            <div class="input-box" style="position:relative;">
                <input type="password" name="password" id="passwordRegister" placeholder="Password" required />
                <i class="fa-solid fa-lock"></i>
                <span onclick="togglePassword('passwordRegister', this)"
                      style="position:absolute; right:40px; top:50%; transform:translateY(-50%); cursor:pointer;">
                    <i class="fa-solid fa-eye-slash"></i>
                </span>
            </div>

            {{-- KONFIRMASI PASSWORD + TOGGLE MATA --}}
            <div class="input-box" style="position:relative;">
                <input type="password" name="password_confirmation" id="passwordConfirm" placeholder="Konfirmasi Password" required />
                <i class="fa-solid fa-lock"></i>
                <span onclick="togglePassword('passwordConfirm', this)"
                      style="position:absolute; right:40px; top:50%; transform:translateY(-50%); cursor:pointer;">
                    <i class="fa-solid fa-eye-slash"></i>
                </span>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>
    </div>

    {{-- TOGGLE BOX --}}
    <div class="toggle-box">
        <div class="toggle-panel toggle-left">
            <h1>Hai, Selamat Datang</h1>
            <p>Tidak Punya Akun?</p>
            <button type="button" class="btn register-btn">Register</button>
        </div>
        <div class="toggle-panel toggle-right">
            <h1>Selamat Datang <br />di SIROP!</h1>
            <p>Sudah Punya Akun?</p>
            <button type="button" class="btn login-btn">Login</button>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector(".container");
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

        @if(session('show_register'))
            container.classList.add("active");
        @endif
    });

    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        const i = icon.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            i.classList.remove('fa-eye-slash');
            i.classList.add('fa-eye');
        } else {
            input.type = 'password';
            i.classList.remove('fa-eye');
            i.classList.add('fa-eye-slash');
        }
    }
</script>

</body>
</html>