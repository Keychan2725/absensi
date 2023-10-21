<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />


    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Dashboard</title>
</head>
<style>
/* ===== Google Font Import - Poppins ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

:root {
    /* ===== Colors ===== */
    --primary-color: #0E4BF1;
    --panel-color: #FFF;
    --text-color: #000;
    --black-light-color: #707070;
    --border-color: #e6e5e5;
    --toggle-color: #DDD;
    --box1-color: #4DA3FF;
    --box2-color: #FFE6AC;
    --box3-color: #E7D1FC;
    --title-icon-color: #fff;

    /* ====== Transition ====== */
    --tran-05: all 0.5s ease;
    --tran-03: all 0.3s ease;
    --tran-03: all 0.2s ease;
}

body {
    min-height: 100vh;
    background-color: var(--primary-color);
}

body.dark {
    --primary-color: #3A3B3C;
    --panel-color: #242526;
    --text-color: #CCC;
    --black-light-color: #CCC;
    --border-color: #4D4C4C;
    --toggle-color: #FFF;
    --box1-color: #3A3B3C;
    --box2-color: #3A3B3C;
    --box3-color: #3A3B3C;
    --title-icon-color: #CCC;
}

/* === Custom Scroll Bar CSS === */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 12px;
    transition: all 0.3s ease;
}

::-webkit-scrollbar-thumb:hover {
    background: #0b3cc1;
}

body.dark::-webkit-scrollbar-thumb:hover,
body.dark .activity-data::-webkit-scrollbar-thumb:hover {
    background: #3A3B3C;
}

nav {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 250px;
    padding: 10px 14px;
    background-color: var(--panel-color);
    border-right: 1px solid var(--border-color);
    transition: var(--tran-05);
}

nav.close {
    width: 73px;
}

nav .logo-name {
    display: flex;
    align-items: center;
}

nav .logo-image {
    display: flex;
    justify-content: center;
    min-width: 45px;
}

nav .logo-image img {
    width: 40px;
    object-fit: cover;
    border-radius: 50%;
}

nav .logo-name .logo_name {
    font-size: 22px;
    font-weight: 600;
    color: var(--text-color);
    margin-left: 14px;
    transition: var(--tran-05);
}

nav.close .logo_name {
    opacity: 0;
    pointer-events: none;
}

nav .menu-items {
    margin-top: 40px;
    height: calc(100% - 90px);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.menu-items li {
    list-style: none;
}

.menu-items li a {
    display: flex;
    align-items: center;
    height: 50px;
    text-decoration: none;
    position: relative;
}

.nav-links li a:hover:before {
    content: "";
    position: absolute;
    left: -7px;
    height: 5px;
    width: 5px;
    border-radius: 50%;
    background-color: var(--primary-color);
}

body.dark li a:hover:before {
    background-color: var(--text-color);
}

.menu-items li a i {
    font-size: 24px;
    min-width: 45px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--black-light-color);
}

.menu-items li a .link-name {
    font-size: 18px;
    font-weight: 400;
    color: var(--black-light-color);
    transition: var(--tran-05);
}

nav.close li a .link-name {
    opacity: 0;
    pointer-events: none;
}

.nav-links li a:hover i,
.nav-links li a:hover .link-name {
    color: var(--primary-color);
}

body.dark .nav-links li a:hover i,
body.dark .nav-links li a:hover .link-name {
    color: var(--text-color);
}

.menu-items .logout-mode {
    padding-top: 10px;
    border-top: 1px solid var(--border-color);
}

.menu-items .mode {
    display: flex;
    align-items: center;
    white-space: nowrap;
}

.menu-items .mode-toggle {
    position: absolute;
    right: 14px;
    height: 50px;
    min-width: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.mode-toggle .switch {
    position: relative;
    display: inline-block;
    height: 22px;
    width: 40px;
    border-radius: 25px;
    background-color: var(--toggle-color);
}

.switch:before {
    content: "";
    position: absolute;
    left: 5px;
    top: 50%;
    transform: translateY(-50%);
    height: 15px;
    width: 15px;
    background-color: var(--panel-color);
    border-radius: 50%;
    transition: var(--tran-03);
}

body.dark .switch:before {
    left: 40px;
}

.dashboard {
    position: relative;
    left: 250px;
    background-color: var(--panel-color);
    min-height: 100vh;
    width: calc(100% - 250px);
    padding: 10px 14px;
    transition: var(--tran-05);
}

nav.close~.dashboard {
    left: 73px;
    width: calc(100% - 73px);
}

.dashboard .top {
    position: fixed;
    top: 0;
    left: 250px;
    display: flex;
    width: calc(100% - 250px);
    justify-content: space-between;
    align-items: center;
    padding: 10px 14px;
    background-color: var(--panel-color);
    transition: var(--tran-05);
    z-index: 10;
}

nav.close~.dashboard .top {
    left: 73px;
    width: calc(100% - 73px);
}

.dashboard .top .sidebar-toggle {
    font-size: 26px;
    color: var(--text-color);
    cursor: pointer;
}

.dashboard .top .search-box {
    position: relative;
    height: 45px;
    max-width: 600px;
    width: 100%;
    margin: 0 30px;
}



.top img {
    width: 40px;
    border-radius: 50%;
}

.dashboard .dash-content {
    padding-top: 50px;
}

.dash-content .title {
    display: flex;
    align-items: center;
    margin: 60px 0 30px 0;
}

.dash-content .title i {
    position: relative;
    height: 35px;
    width: 35px;
    background-color: var(--primary-color);
    border-radius: 6px;
    color: var(--title-icon-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.dash-content .title .text {
    font-size: 24px;
    font-weight: 500;
    color: dark;
    margin-left: 10px;
}

.dash-content .boxes {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.dash-content .boxes .box {
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius: 12px;
    width: calc(100% / 3 - 15px);
    padding: 15px 20px;
    background-color: var(--box1-color);
    transition: var(--tran-05);
}

.boxes .box i {
    font-size: 35px;
    color: var(--text-color);
}

.boxes .box .text {
    white-space: nowrap;
    font-size: 18px;
    font-weight: 500;
    color: var(--text-color);
}

.boxes .box .number {
    font-size: 40px;
    font-weight: 500;
    color: var(--text-color);
}

.boxes .box.box2 {
    background-color: var(--box2-color);
}

.boxes .box.box3 {
    background-color: var(--box3-color);
}

.dash-content .activity .activity-data {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.activity .activity-data {
    display: flex;
}

.activity-data .data {
    display: flex;
    flex-direction: column;
    margin: 0 15px;
}

.activity-data .data-title {
    font-size: 20px;
    font-weight: 500;
    color: var(--text-color);
}

.activity-data .data .data-list {
    font-size: 18px;
    font-weight: 400;
    margin-top: 20px;
    white-space: nowrap;
    color: var(--text-color);
}

@media (max-width: 1000px) {
    nav {
        width: 73px;
    }

    nav.close {
        width: 250px;
    }

    nav .logo_name {
        opacity: 0;
        pointer-events: none;
    }

    nav.close .logo_name {
        opacity: 1;
        pointer-events: auto;
    }

    nav li a .link-name {
        opacity: 0;
        pointer-events: none;
    }

    nav.close li a .link-name {
        opacity: 1;
        pointer-events: auto;
    }

    nav~.dashboard {
        left: 73px;
        width: calc(100% - 73px);
    }

    nav.close~.dashboard {
        left: 250px;
        width: calc(100% - 250px);
    }

    nav~.dashboard .top {
        left: 73px;
        width: calc(100% - 73px);
    }

    nav.close~.dashboard .top {
        left: 250px;
        width: calc(100% - 250px);
    }

    .activity .activity-data {
        overflow-X: scroll;
    }
}

@media (max-width: 780px) {
    .dash-content .boxes .box {
        width: calc(100% / 2 - 15px);
        margin-top: 15px;
    }
}

@media (max-width: 560px) {
    .dash-content .boxes .box {
        width: 100%;
    }
}

@media (max-width: 400px) {
    nav {
        width: 0px;
    }

    nav.close {
        width: 73px;
    }

    nav .logo_name {
        opacity: 0;
        pointer-events: none;
    }

    nav.close .logo_name {
        opacity: 0;
        pointer-events: none;
    }

    nav li a .link-name {
        opacity: 0;
        pointer-events: none;
    }

    nav.close li a .link-name {
        opacity: 0;
        pointer-events: none;
    }

    nav~.dashboard {
        left: 0;

        width: 100%;
    }

    nav.close~.dashboard {
        left: 73px;
        width: calc(100% - 73px);
    }

    nav~.dashboard .top {
        left: 0;
        width: 100%;
    }

    nav.close~.dashboard .top {
        left: 0;
        width: 100%;
    }
}
</style>
<!-- <div class="sales-boxes">
                <div class="recent-sales box">
                    <div class="title">Recent Sales</div>
                    <div class="sales-details">
                        <ul class="details">
                            <li class="topic">Date</li>
                            <li><a href="#">02 Jan 2021</a></li>
                            <li><a href="#">02 Jan 2021</a></li>
                            <li><a href="#">02 Jan 2021</a></li>
                            <li><a href="#">02 Jan 2021</a></li>
                            <li><a href="#">02 Jan 2021</a></li>
                            <li><a href="#">02 Jan 2021</a></li>
                            <li><a href="#">02 Jan 2021</a></li>
                        </ul>
                        <ul class="details">
                            <li class="topic">Customer</li>
                            <li><a href="#">Alex Doe</a></li>
                            <li><a href="#">David Mart</a></li>
                            <li><a href="#">Roe Parter</a></li>
                            <li><a href="#">Diana Penty</a></li>
                            <li><a href="#">Martin Paw</a></li>
                            <li><a href="#">Doe Alex</a></li>
                            <li><a href="#">Aiana Lexa</a></li>
                            <li><a href="#">Rexel Mags</a></li>
                            <li><a href="#">Tiana Loths</a></li>
                        </ul>
                        <ul class="details">
                            <li class="topic">Sales</li>
                            <li><a href="#">Delivered</a></li>
                            <li><a href="#">Pending</a></li>
                            <li><a href="#">Returned</a></li>
                            <li><a href="#">Delivered</a></li>
                            <li><a href="#">Pending</a></li>
                            <li><a href="#">Returned</a></li>
                            <li><a href="#">Delivered</a></li>
                            <li><a href="#">Pending</a></li>
                            <li><a href="#">Delivered</a></li>
                        </ul>
                        <ul class="details">
                            <li class="topic">Total</li>
                            <li><a href="#">$204.98</a></li>
                            <li><a href="#">$24.55</a></li>
                            <li><a href="#">$25.88</a></li>
                            <li><a href="#">$170.66</a></li>
                            <li><a href="#">$56.56</a></li>
                            <li><a href="#">$44.95</a></li>
                            <li><a href="#">$67.33</a></li>
                            <li><a href="#">$23.53</a></li>
                            <li><a href="#">$46.52</a></li>
                        </ul>
                    </div>
                    <div class="button">
                        <a href="#">See All</a>
                    </div>
                </div>
                <div class="top-sales box">
                    <div class="title">Top Seling Product</div>
                    <ul class="top-sales-details">
                        <li>
                            <a href="#">
                                <img src="images/sunglasses.jpg" alt="">
                                <span class="product">Vuitton Sunglasses</span>
                            </a>
                            <span class="price">$1107</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="images/jeans.jpg" alt="">
                                <span class="product">Hourglass Jeans </span>
                            </a>
                            <span class="price">$1567</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="images/nike.jpg" alt="">
                                <span class="product">Nike Sport Shoe</span>
                            </a>
                            <span class="price">$1234</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="images/scarves.jpg" alt="">
                                <span class="product">Hermes Silk Scarves.</span>
                            </a>
                            <span class="price">$2312</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="images/blueBag.jpg" alt="">
                                <span class="product">Succi Ladies Bag</span>
                            </a>
                            <span class="price">$1456</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="images/bag.jpg" alt="">
                                <span class="product">Gucci Womens's Bags</span>
                            </a>
                            <span class="price">$2345</span>
                        <li>
                            <a href="#">
                                <img src="images/addidas.jpg" alt="">
                                <span class="product">Addidas Running Shoe</span>
                            </a>
                            <span class="price">$2345</span>
                        </li>
                        <li>
                            <a href="#">
                                <img src="images/shirt.jpg" alt="">
                                <span class="product">Bilack Wear's Shirt</span>
                            </a>
                            <span class="price">$1245</span>
                        </li>
                    </ul>
                </div>
            </div> -->

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="https://tse1.mm.bing.net/th?id=OIP.xKEbKVRjeWNbWnFmFDiGxgHaHa&pid=Api&P=0&h=180" alt="">
            </div>

            <a>Karyawan</a>
        </div>

        <div class="menu-items">
            <ul class="nav-links" style="padding-left:16px;">
                <li><a href="<?php echo base_url('karyawan/dashboard') ?>">
                        <i class="fa-solid fa-house"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>

                <li><a href="<?php echo base_url('karyawan/history') ?>">
                        <i class="fa-solid fa-clock-rotate-left"></i>

                        <span class="link-name">History Absensi</span>
                    </a></li>
                <li><a href="<?php echo base_url('karyawan/absensi') ?>">
                        <i class="fa-regular fa-calendar-days"></i>
                        <span class="link-name">Absensi</span>
                    </a></li>
                <li><a href="<?php echo base_url('karyawan/izin') ?>">
                        <i class="fa-solid fa-i"></i>
                        <span class="link-name">Izin</span>
                    </a></li>

                <li><a href="<?php echo base_url('karyawan/akun') ?>">
                        <i class="fa-solid fa-circle-user"></i>
                        <span class="link-name">Edit Profil</span>
                    </a></li>


                <br>
                <li class="mode">

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>

                <li class="logout-mode  ">
                <li><a class="btn btn-lg   " onclick=" logout(id)">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="link-name">Keluar</span>
                    </a>

                </li>
                <li>

                    <span id="clock" name="date" class="text-white link-name"> </span>

                </li>
                <li>
                    <span id="clock2" name="date2" class="text-dark link-name"> </span>
                </li>




        </div>


    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>


        </div>
        <div class="title  ">

            <span class="text  ">Dashboard</span>


        </div>

        <div class="overview shadow-lg p-1 mb-3 bg-body rounded">
            <div class="d-flex  ">

                <div class="card border " style="width: 15rem;height:13rem; ;">
                    <p class=" fs-6 text-white text-center p-3 bg-dark">Total <br> Masuk</p>


                    <p class=" fs-1 text-dark text-center"> <i class="fa-regular fa-calendar-days"></i>

                        <?php echo $jumlah_absen;?></p>


                </div>
                <div class="card  border" style="width: 15rem;height:13rem; ">
                    <p class=" fs-6 text-white text-center p-3 bg-dark">Total
                        <br>Izin
                    </p>
                    <p class=" fs-1 text-dark text-center"> <i class="fa-regular fa-calendar-minus"></i>
                        <?php echo $jumlah_izin;?>
                    </p>

                </div>

            </div>
        </div>
        </div>
        </div>
        </div>
        </main>
        <div class="overview shadow-lg p-1 mb-3 bg-body rounded">

            <div class="row">
                <div class="col">
                    <div class="overflow-auto" style="white-space: nowrap;">



                        <table class="table table-hover">
                            <thead>
                                <tr class="table-hover">
                                    <th scope="col">No</th>
                                    <th scope="col">Kegiatan</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Jam Masuk</th>
                                    <th scope="col">Jam Keluar</th>
                                    <th scope="col">Keterangan Izin</th>
                                    <th scope="col">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;foreach ($absen as $row): $no++?>
                                <tr class=" whitespace-nowrap">
                                    <td class="px-3 py-4 text-sm text-gray-500"><?php echo $no?>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php echo $row->kegiatan?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php echo $row->date?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php if( $row->jam_masuk == NULL) {
                        echo '-';
                      } else{
                        echo $row->jam_masuk;
                      }?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php if( $row->jam_keluar == NULL) {
                        echo '-';
                      } else{
                        echo $row->jam_keluar;
                      }?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php if( $row->keterangan_izin == NULL) {
                        echo '-';
                      } else{
                        echo $row->keterangan_izin;
                      }?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php if( $row->status == NULL) {
                        echo 'not';
                      } else{
                        echo $row->status;
                      }?>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        </div>
    </section>

    <script>
    function updateClock() {
        var now = new Date();
        var clock = document.getElementById('clock');
        clock.innerHTML = now.toLocaleTimeString();
    }

    // Memperbarui jam setiap detik
    setInterval(updateClock, 1000);

    function updateClock2() {
        var now = new Date();
        var clock = document.getElementById('clock2');
        clock.innerHTML = now.toLocaleTimeString();
    }

    // Memperbarui jam setiap detik
    setInterval(updateClock2, 1000);
    </script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    <script src="script.js"></script>
    <script>
    const body = document.querySelector("body"),
        modeToggle = body.querySelector(".mode-toggle");
    sidebar = body.querySelector("nav");
    sidebarToggle = body.querySelector(".sidebar-toggle");

    let getMode = localStorage.getItem("mode");
    if (getMode && getMode === "dark") {
        body.classList.toggle("dark");
    }

    let getStatus = localStorage.getItem("status");
    if (getStatus && getStatus === "close") {
        sidebar.classList.toggle("close");
    }

    modeToggle.addEventListener("click", () => {
        body.classList.toggle("dark");
        if (body.classList.contains("dark")) {
            localStorage.setItem("mode", "dark");
        } else {
            localStorage.setItem("mode", "light");
        }
    });

    sidebarToggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        if (sidebar.classList.contains("close")) {
            localStorage.setItem("status", "close");
        } else {
            localStorage.setItem("status", "open");
        }
    })
    </script>
</body>
<script>
function logout(id) {
    swal.fire({
        title: ' Yakin Ingin Log Out',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Log Out'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Log Out',
                showConfirmButton: false,
                timer: 1500,

            }).then(function() {
                window.location.href = "<?php echo base_url('auth/logout/')?>" + id;
            });
        }
    });
}
</script>

</html>