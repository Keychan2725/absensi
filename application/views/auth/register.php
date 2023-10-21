<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Muhamad Nauval Azhar">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a login page template based on Bootstrap 5">
    <title>Halaman Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sistem Absensi</p>
                            <hr>

                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h3 fw-bold mb-5 mx-1 mx-md-4 mt-4"> Register Karyawan</p>

                                    <?php echo $this->session->flashdata('message'); ?>

                                    <form method="POST" class="needs-validation" novalidate="" autocomplete="off"
                                        action="<?php echo base_url(); ?>Auth/aksi_register">
                                        <div class="row justify-content-start">
                                            <div class="d-flex flex-row align-items-center mb-4 col-6">

                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="text" id="nama_depan" placeholder="Nama Depan"
                                                        name="nama_depan" class="form-control" required autofocus>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4 col-6">

                                                <div class="form-outline flex-fill mb-0">
                                                    <input placeholder="Nama Belakang" type="text" id="nama_belakang"
                                                        name="nama_belakang" class="form-control" required autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">

                                            <div class="form-outline flex-fill mb-0">
                                                <input placeholder="Username" type="text" id="username" name="username"
                                                    class="form-control" required autofocus>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">

                                            <div class="form-outline flex-fill mb-0">
                                                <input placeholder="Email" type="text" id="email" name="email"
                                                    class="form-control" required autofocus>
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
                                        <p>*Password harus memiliki 8 angka</p>





                                        <div class="form-check d-flex justify-content-center mb-5">
                                            <label for="form2Example3">
                                                You have an account ? <a href="<?php echo base_url('auth/login') ?>"
                                                    class="text-sky">login</a>

                                            </label>
                                        </div>


                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit"
                                                class="btn btn-dark text-white btn-lg">Registrasi</button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://img.freepik.com/premium-vector/boys-are-working-presentation_118167-8419.jpg?w=360"
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
</script>

</html>