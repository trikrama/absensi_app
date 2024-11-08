<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#004AAD">
    <title>E-Presensi Geolocation</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('icon-512.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon-512.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <!-- Menambahkan Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZAILbhH1Tm5CtQXHWCCU8+YrdEYXYNVKfrRBjwX39LZUdwtu3D7XQoNZgrg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">
            <div class="section">
                <img src="{{ asset('assets/img/login/login.webp') }}" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <h1>E-Presensi </h1>
                <h4>Silahkan Login</h4>
            </div>
            <div class="section mt-1 mb-5">
                @php
                    $messagewarning = Session::get('warning');
                @endphp
                @if (Session::get('warning'))
                    <div class="alert alert-outline-warning">
                        {{ $messagewarning }}
                    </div>
                @endif
                <form action="/proseslogin" method="POST">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <select name="role" class="form-control" required>
                                <option value="" disabled selected>Login Sebagai..</option>
                                <option value="admin">Admin</option>
                                <option value="karyawan">Karyawan</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" name="nik" class="form-control" id="nik" placeholder="NIK atau Email" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <div class="icon-right" style="position: absolute; right:8px; top:10px">
                                <ion-icon name="eye-off-outline" id="show_hide_password" style="font-size: 1.5rem"></ion-icon>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar Captcha -->
                    <div class="text-center">
                        <img src="{{ captcha_src(env('CAPTCHA_STYLE', 'default')) }}" alt="captcha" id="captcha_image" class="img-fluid mb-1 border border-secondary">
                        
                        <!-- Tombol Refresh menggunakan ikon -->
                        <button type="button" onclick="refreshCaptcha()" class="btn btn-secondary btn-sm w-20 h-20">
                            <i class="fas fa-sync-alt"></i> <!-- Font Awesome refresh icon -->
                        </button>
                    </div>

                    <!-- Input untuk Captcha -->
                    <div class="form-group w-75 mx-auto">
                        <input type="text" name="captcha" class="form-control" placeholder="Enter captcha" required>
                        @error('captcha')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Login -->
                    <div class="form-button-group">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Log in</button>
                    </div>
                    {{-- @php
                            echo captcha_img();
                        @endphp --}}
                </form>
                
            </div>
        </div>


    </div>
    <!-- * App Capsule -->

    <script>
        var BASE_URL = "{{ url('/') }}/";
        //alert(BASE_URL);
        document.addEventListener('DOMContentLoaded', init, false);

        function init() {
            if ('serviceWorker' in navigator && navigator.onLine) {
                navigator.serviceWorker.register(BASE_URL + 'service-worker.js')
                    .then((reg) => {
                        console.log('Registrasi service worker Berhasil', reg);
                    }, (err) => {
                        console.error('Registrasi service worker Gagal', err);
                    });
            }
        }
        
        // refresh Captcha
        function refreshCaptcha() {
            document.getElementById('captcha_image').src = '{{ captcha_src() }}' + '?' + Math.random();
        }
    </script>

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>

    <script>
        $(function() {
            $("#show_hide_password").click(function(e) {
                e.preventDefault();
                if ($("#password").attr("type") == "text") {
                    $("#password").attr("type", "password");
                    $("#show_hide_password").attr("name", "eye-off-outline");
                } else if ($("#password").attr("type") == "password") {
                    $("#password").attr("type", "text");
                    $("#show_hide_password").attr("name", "eye-outline");
                }
            });
        });
    </script>

</body>

</html>
