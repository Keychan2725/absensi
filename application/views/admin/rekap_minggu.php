<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Rekap Mingguan</title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<style>
/* Google Font Link */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    width: 78px;
    background: #11101D;
    padding: 6px 14px;
    z-index: 99;
    transition: all 0.5s ease;
}

.sidebar.open {
    width: 250px;
}

.sidebar .logo-details {
    height: 60px;
    display: flex;
    align-items: center;
    position: relative;
}

.sidebar .logo-details .icon {
    opacity: 0;
    transition: all 0.5s ease;
}

.sidebar .logo-details .logo_name {
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    opacity: 0;
    transition: all 0.5s ease;
}

.sidebar.open .logo-details .icon,
.sidebar.open .logo-details .logo_name {
    opacity: 1;
}

.sidebar .logo-details #btn {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    font-size: 22px;
    transition: all 0.4s ease;
    font-size: 23px;
    text-align: center;
    cursor: pointer;
    transition: all 0.5s ease;
}

.sidebar.open .logo-details #btn {
    text-align: right;
}

.sidebar i {
    color: #fff;
    height: 60px;
    min-width: 50px;
    font-size: 28px;
    text-align: center;
    line-height: 60px;
}

.sidebar .nav-list {
    margin-top: 20px;
    height: 100%;
}

.sidebar li {
    position: relative;
    margin: 8px 0;
    list-style: none;
}

.sidebar li .tooltip {
    position: absolute;
    top: -20px;
    left: calc(100% + 15px);
    z-index: 3;
    background: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 400;
    opacity: 0;
    white-space: nowrap;
    pointer-events: none;
    transition: 0s;
}

.sidebar li:hover .tooltip {
    opacity: 1;
    pointer-events: auto;
    transition: all 0.4s ease;
    top: 50%;
    transform: translateY(-50%);
}

.sidebar.open li .tooltip {
    display: none;
}

.sidebar input {
    font-size: 15px;
    color: #FFF;
    font-weight: 400;
    outline: none;
    height: 50px;
    width: 100%;
    width: 50px;
    border: none;
    border-radius: 12px;
    transition: all 0.5s ease;
    background: #1d1b31;
}

.sidebar.open input {
    padding: 0 20px 0 50px;
    width: 100%;
}

.sidebar .bx-search {
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    font-size: 22px;
    background: #1d1b31;
    color: #FFF;
}

.sidebar.open .bx-search:hover {
    background: #1d1b31;
    color: #FFF;
}

.sidebar .bx-search:hover {
    background: #FFF;
    color: #11101d;
}

.sidebar li a {
    display: flex;
    height: 100%;
    width: 100%;
    border-radius: 12px;
    align-items: center;
    text-decoration: none;
    transition: all 0.4s ease;
    background: #11101D;
}

.sidebar li a:hover {
    background: #FFF;
}

.sidebar li a .links_name {
    color: #fff;
    font-size: 15px;
    font-weight: 400;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: 0.4s;
}

.sidebar.open li a .links_name {
    opacity: 1;
    pointer-events: auto;
}

.sidebar li a:hover .links_name,
.sidebar li a:hover i {
    transition: all 0.5s ease;
    color: #11101D;
}

.sidebar li i {
    height: 50px;
    line-height: 50px;
    font-size: 18px;
    border-radius: 12px;
}

.sidebar li.profile {
    position: fixed;
    height: 60px;
    width: 78px;
    left: 0;
    bottom: -8px;
    padding: 10px 14px;
    background: #1d1b31;
    transition: all 0.5s ease;
    overflow: hidden;
}

.sidebar.open li.profile {
    width: 250px;
}

.sidebar li .profile-details {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
}

.sidebar li img {
    height: 45px;
    width: 45px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 10px;
}

.sidebar li.profile .name,
.sidebar li.profile .job {
    font-size: 15px;
    font-weight: 400;
    color: #fff;
    white-space: nowrap;
}

.sidebar li.profile .job {
    font-size: 12px;
}

.sidebar .profile #log_out {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    background: #1d1b31;
    width: 100%;
    height: 60px;
    line-height: 60px;
    border-radius: 0px;
    transition: all 0.5s ease;
}

.sidebar.open .profile #log_out {
    width: 50px;
    background: none;
}

.home-section {
    position: relative;
    background: #E4E9F7;
    min-height: 100vh;
    top: 0;
    left: 78px;
    width: calc(100% - 78px);
    transition: all 0.5s ease;
    z-index: 2;
}

.sidebar.open~.home-section {
    left: 250px;
    width: calc(100% - 250px);
}

.home-section .text {
    display: inline-block;
    color: #11101d;
    font-size: 25px;
    font-weight: 500;
    margin: 18px
}

@media (max-width: 420px) {
    .sidebar li .tooltip {
        display: none;
    }
}
</style>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus icon'></i>
            <div class="logo_name">Admin</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">


            <li>
                <a href="<?php echo base_url('admin/dashboard') ?>">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="<?php echo base_url('admin/karyawan') ?>">
                    <i class="fa-solid fa-circle-user"></i>
                    <span class="links_name">Karyawan</span>
                </a>
                <span class="tooltip">Karyawan</span>
            </li>
            <li>
                <a href="<?php echo base_url('admin/rekap_harian') ?>">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span class="links_name">Rekapan Harian</span>
                </a>
                <span class="tooltip">Rekapan Harian</span>
            </li>
            <li>
                <a href="<?php echo base_url('admin/rekap_minggu') ?>">
                    <i class="fa-solid fa-calendar-week"></i>
                    <span class="links_name">Rekapan Minggu</span>
                </a>
                <span class="tooltip">Rekapan Minggu</span>
            </li>
            <li>
                <a href="<?php echo base_url('admin/rekap_bulan') ?>">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span class="links_name">Rekapan Bulan</span>
                </a>
                <span class="tooltip">Rekapan Bulan</span>
            </li>


            <li>

                <span id="clock" name="date" class="text-white links_name"> </span>


            </li>
            <li class="profile">





                <a class="btn btn-lg   " onclick=" logout(id)">

                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="links_name">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section bg-slate-100 ">

        <main id="content" class="max-h-screen overflow-y-auto flex-1 p-6 lg:px-8">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 px-2 md:grid-cols-3 rounded-t-lg py-2.5 bg-sky-900 text-white text-xl">
                    <div class="flex justify-center mb-2 md:justify-start md:pl-6">
                        REKAP MINGGUAN
                    </div>
                    <div class="flex flex-wrap justify-center col-span-2 gap-2 md:justify-end">
                        <a href="<?php echo base_url('Admin/export_minggu'); ?>"
                            class="py-1 float-end bg-green-600
          text-white bg-green-400 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center w-[250px] md:w-[250px]">
                            Export Data
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto w-full px-4 bg-white rounded-b-lg shadow">
                    <table class="my-4 w-full divide-y divide-gray-300 text-center">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-xs text-gray-500">NO</th>
                                <th class="px-3 py-2 text-xs text-gray-500">NAMA</th>
                                <th class="px-3 py-2 text-xs text-gray-500">
                                    KEGIATAN
                                </th>
                                <th class="px-3 py-2 text-xs text-gray-500">TANGGAL</th>
                                <th class="px-3 py-2 text-xs text-gray-500">JAM MASUK</th>
                                <th class="px-3 py-2 text-xs text-gray-500">JAM PULANG</th>
                                <th class="px-3 py-2 text-xs text-gray-500">KETERANGAN IZIN</th>
                                <th class="px-3 py-2 text-xs text-gray-500">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <?php $no=0; foreach ($absensi as $absen): $no++ ?>
                            <tr class="whitespace-nowrap">
                                <td class="px-3 py-4 text-sm text-gray-500"><?php echo $no ?></td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php echo tampil_id_karyawan( $absen['id_karyawan']); ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php echo $absen['kegiatan']; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php echo $absen['date']; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php if( $absen['jam_masuk'] == NULL) {
                        echo '-';
                      } else{
                        echo  $absen['jam_masuk'];
                      }?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php if( $absen['jam_keluar'] == NULL) {
                        echo '-';
                      } else{
                        echo  $absen['jam_keluar'];
                      }?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php echo $absen['keterangan_izin']; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php echo $absen['status']; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Add an event listener for the "change" event on the select element
            var selectElement = document.getElementById('bulan');
            var formElement = selectElement.form; // Get the parent form

            selectElement.addEventListener('change', function() {
                formElement.submit(); // Submit the form when the select element changes
            });
        });
        </script>

</body>

</section>

</body>
<script>
function updateClock() {
    var now = new Date();
    var clock = document.getElementById('clock');

    var options = {
        hour12: false
    };
    clock.innerHTML = now.toLocaleTimeString(undefined, options);
}

// Memperbarui jam setiap detik
setInterval(updateClock, 1000);




let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    menuBtnChange(); //calling the function(optional)
});

searchBtn.addEventListener("click", () => { // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); //calling the function(optional)
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
    if (sidebar.classList.contains("open")) {
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
    } else {
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
    }
}

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