<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Muhamad Nauval Azhar">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a login page template based on Bootstrap 5">
    <title>Halaman Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="path-to-sweetalert2.css">
    <!-- Replace 'path-to-sweetalert2.css' with the actual path to your SweetAlert CSS file -->
    <script src="path-to-sweetalert2.js"></script>
    <!-- Replace 'path-to-sweetalert2.js' with the actual path to your SweetAlert JavaScript file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

</head>
<style>
.toggle-password {
    font-size: 1.2em;
    color: #555;
    /* Ubah warna sesuai kebutuhan Anda */
    cursor: pointer;
}
</style>

<body class="">

    <section class="vh-100" style="background-color: #eee;">

        <div class="container h-100">



            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <p class="text-center h1 fw-italic mb-5 mx-1 mx-md-4 mt-4">AppAbsen</p>
                            <hr>
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h3 fw-bold mb-5 mx-1 mx-md-4 mt-4"> Login</p>


                                    <form method="POST" class="needs-validation" novalidate="" autocomplete="off"
                                        action="<?php echo base_url(); ?>Auth/aksi_login">



                                        <div class="d-flex flex-row align-items-center mb-4">

                                            <div class="form-outline flex-fill mb-0">
                                                <input placeholder="Email" type="email" id="email" name="email"
                                                    class="form-control" value="<?php echo set_value('email'); ?>
                                    " required autofocus>

                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">

                                            <div class="d-flex form-outline flex-fill mb-0">
                                                <input placeholder="Password" type="password" id="password"
                                                    name="password" class="form-control">
                                                <button type="button" class="fa-solid fa-eye-slash toggle-password p-2"
                                                    id="show-password"></button>
                                            </div>
                                        </div>



                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <label for="form2Example3">
                                                don't have an account ? <a
                                                    href="<?php echo base_url('auth/register') ?>"
                                                    class="text-sky">Registrasi </a>

                                            </label>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-dark text-white btn-lg">Login</button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://tecdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                                        class="img-fluid" alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script>
var passwordInput = document.getElementById('password');
var togglePassword = document.getElementById('show-password');

togglePassword.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePassword.classList.remove('fa-eye-slash');
        togglePassword.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        togglePassword.classList.remove('fa-eye');
        togglePassword.classList.add('fa-eye-slash');
    }
});

function displaySweetAlert() {
    const message = "<?php echo $this->session->flashdata('sukses'); ?>";
    const error = "<?php echo $this->session->flashdata('gagal'); ?>";

    if (message) {
        Swal.fire({
            title: 'Selamat Datang Kembali ',
            text: message,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (error) {
        Swal.fire({
            title: 'Error!',
            text: error,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}

// Call the function when the page loads
window.onload = displaySweetAlert;
</script>


</html>