@extends('templates.login')

@section('header')
<link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" />
@endsection

@section('container')
<form action="{{ route('admin.auth') }}" method="POST" onsubmit="return 0;">
    @csrf

    <!-- Heading Wrapper -->
    <h3>Autentikasi</h3>
    <p>Silahkan masuk dengan kredensial anda.</p>

    <div class="alert alert-info">
        <h5>Harap Diperhatikan</h5>
        <ol class="p-0 m-0 pl-3">
            <li>Jaga kerahasiaan akun anda.</li>
            <li>Jika memerlukan waktu yang lama untuk terautentikasi, centanglah <strong>Ingatkan Saya!</strong></li>
        </ol>
    </div>

    <!-- Username Wrapper -->
    <div class="form-group mb-3">
        <label for="username">Nama Pengguna</label>
        <input type="text" name="username" id="username" class="form-control form-control-alt" placeholder="Misal: hypenamic123" required />
    </div>

    <!-- Password Wrapper -->
    <div class="form-group mb-3">
        <div class="d-flex justify-content-between">
            <label for="password">Kata Sandi</label>
            <a href="../html/forgot-password.html">Lupa Sandi?</a>
        </div>
        <input type="password" id="password" name="password" class="form-control form-control-alt" placeholder="Masukkan kata sandi anda." required />
    </div>

    <!-- Remember Me -->
    <div class="custom-control custom-checkbox mb-3">
        <input type="checkbox" class="custom-control-input" name="remember" id="remember" required>
        <label class="custom-control-label" for="remember">Ingatkan saya</label>
    </div>

    <!-- Button Login -->
    <button type="submit" class="btn btn-block btn-primary mb-3">Masuk<i class="fas fa-sign-in-alt ml-2"></i></button>
</form>
@endsection

@section('footer')
<!-- Addons -->
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/additional-methods.min.js') }}"></script>

<script>
"use strict";

$('form').validate({
    rules: {
        username: {
            required: true,
            minlength: 3
        },
        password: {
            required: true,
            minlength: 6
        },
    },
    messages: {
        username: {
            required: 'Kolom nama pengguna diperlukan!',
            minlenght: 'Kolom nama pengguna setidaknya ada 3 karakter!',
        },
        password: {
            required: 'Kolom kata sandi diperlukan!',
            minlenght: 'Kolom kata sandi setidaknya ada 6 karakter!',
        },
    },

    onfocusout(e) {
        this.element(e);
    },

    highlight(element) {
        jQuery(element).closest('.form-control').addClass('is-invalid');
        jQuery(element).closest('.form-control').removeClass('is-valid');
    },
    unhighlight(element) {
        jQuery(element).closest('.form-control').removeClass('is-invalid');
        jQuery(element).closest('.form-control').addClass('is-valid');
    },

    errorElement: 'div',
    errorClass: 'invalid-feedback',
    errorPlacement(error, element) {
        $(element).parents('.form-group').find(".error-message").append(error);
    },

    submitHandler(form) {
        let forms  = $(form);
        let data   = forms.serialize();
        let url    = forms.attr('action');
        let method = forms.attr('method');

        $.ajax({
            url: url,
            data: data,
            type: method,

            beforeSend() {
                Swal.fire({
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    title: 'Sedang Memproses!',
                    text: 'Tunggu sebentar ya? Sistem sedang memproses permintaan anda!',
                    didOpen() {
                        Swal.showLoading()
                    }
                });
            },
            success(result) {
                let res = result;

                successAlert.fire({
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    title: 'Berhasil!',
                    text: 'Sistem berhasil mengautentikasi diri anda dan akan diarahkan ke halaman administrator!',
                    didOpen() {
                        Swal.showLoading()
                    }
                });

                if(result.redirect) {
                    setTimeout(() => {
                        window.location.href = res.redirect;
                    }, 5000);
                }
            },
            error(exceptions) {
                let error = exceptions.responseJSON;
                warnAlert.fire({
                    title: 'Ups, Maaf!',
                    text: error.message,
                });
            },
        });
    }
});
</script>
@endsection
