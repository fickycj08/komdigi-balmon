<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css') <!-- Pastikan Tailwind sudah terinstall -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

</head>

<body class="flex items-center justify-center min-h-screen bg-cover bg-center bg-no-repeat bg-fixed"
    style="background-image: url('images/bg_login.png');">


    <div class="w-[645px] h-[665px] max-w-[545px] bg-[#525252]/50 pt-[77px] p-6 rounded-lg shadow-md">
        <img src="{{ asset('images/logo_kominfo.png') }}" alt="Logo" class="w-[140px] h-[140px] mx-auto mb-4">
        <h2 class="text-[19px] font-[Inter] pt-[27px] text-center tracking-[8px] text-green-50 mb-4">LOGIN PAGE</h2>

        @if(session('error'))
            <div class="bg-red-500 text-white p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="flex justify-center items-center">
                <div class="relative mb-4">
                    <span class="absolute inset-y-0 left-3 flex items-center text-green-50">
                        <x-heroicon-o-envelope class="w-6 h-6" />
                    </span>
                    <input type="email" name="email" placeholder="Email" class="w-[285px] pl-12 pr-4 py-2
             text-green-50 placeholder-green-50
             bg-white/15 border border-white/40
             focus:border-[#006DB0]
             rounded-xl shadow-md backdrop-blur-md
             transition-all focus:outline-none" />
                </div>
            </div>




            <div class="flex justify-center items-center">
                <div class="relative mb-4">
                    <span class="absolute inset-y-0 left-3 flex items-center text-green-50">
                        <x-heroicon-o-lock-closed class="w-6 h-6" />
                    </span>
                    <input type="password" id="password" name="password" placeholder="Password" class="w-[285px] pl-12 pr-10 py-2
                   text-green-50 placeholder-green-50
                   bg-white/15 border border-white/40
                   focus:border-[#006DB0]
                   rounded-xl shadow-md backdrop-blur-md
                   transition-all focus:outline-none" />
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-50">
                        <x-heroicon-o-eye id="eye" class="w-6 h-6 hidden" /> <!-- Mata terbuka di-hidden -->
                        <x-heroicon-o-eye-slash id="eye-slash" class="w-6 h-6" /> <!-- Mata tertutup tampil -->
                    </button>

                </div>
            </div>





            <div class="flex justify-center items-center pt-[30px]">
                <button type="submit"
                    class="w-[285px] h-[35px] bg-[#006DB0] hover:bg-blue-600 text-white  rounded-lg font-semibold">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>
<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var eyeOpen = document.getElementById("eye");
        var eyeOff = document.getElementById("eye-slash");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeOpen.classList.remove("hidden");    // Mata terbuka muncul
            eyeOff.classList.add("hidden");        // Mata tertutup hilang
        } else {
            passwordInput.type = "password";
            eyeOpen.classList.add("hidden");       // Mata terbuka hilang
            eyeOff.classList.remove("hidden");     // Mata tertutup muncul
        }
    }

</script>

</html>