<?php
session_start();

include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login/login.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Ambil role pengguna dari session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

function generateUserColor($username) {
    $hash = md5($username); // Hash dari username
    $color = substr($hash, 0, 6); // Ambil 6 karakter pertama sebagai warna hex
    return "#" . $color;
}

if (isset($_SESSION['username'])) {
    $userColor = generateUserColor($_SESSION['username']);
    
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utama</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="">

    <div class="flex h-screen relative">
        <!-- Sidebar -->
        <div class="w-64 z-20 shadow-xl shadow-black/70 bg-white bg-gradient-to-b from-violet-800 to-violet-950 text-white p-9 flex flex-col    border-r-4 border-black relative">
            <div class="p-4 text-4xl font-semibold text-white border-b font-teko text-center mt-[12px]">Menu</div>
            <div class="mt-8 font-teko text-xl uppercase">
                <div class="relative">
                    <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                    <div onclick="location.href='index.php'"
                        class="relative z-20 cursor-pointer mb-3 text-md w-full bg-[#FFF12B] rounded-md p-1 px-2 scale-105 duration-300 shadow-xl shadow-black/5 -translate-x-1 -translate-y-1 border-2 border-black">
                        <i class="fa-solid fa-house text-black text-sm absolute mt-[1px]"></i>
                        <a class="text-black px-6">Dashboard</a>
                        <div class="w-full bg-black h-full z-50"></div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                    <div onclick="location.href='produk.php'"
                        class="relative z-20 cursor-pointer mb-3 text-md w-full bg-white hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-black">
                        <i class="fa-solid fa-box text-black text-sm absolute mt-[1px] ms-[2px]"></i>
                        <a  class="text-black px-6">Data Produk</a>
                        <div class="w-full bg-black h-full z-50"></div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                    <div onclick="location.href='pelanggan.php'"
                        class="relative z-20 cursor-pointer mb-3 text-md w-full bg-white hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-black">
                        <i class="fa-solid fa-person text-black text-sm absolute mt-[1px] ms-[2px]"></i>
                        <a  class="text-black px-6">Data Pelanggan</a>
                        <div class="w-full bg-black h-full z-50"></div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                    <div onclick="location.href='penjualan.php'"
                        class="relative z-20 cursor-pointer mb-3 text-md w-full bg-white hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-black">
                        <i class="fa-solid fa-cart-shopping text-black text-sm absolute mt-[1px] ms-[0px]"></i>
                        <a  class="text-black px-6">Penjualan</a>
                        <div class="w-full bg-black h-full z-50"></div>
                    </div>
                </div>
                <!-- Menu hanya untuk admin -->
                <?php if ($role === 'admin') : ?>
                <div class="relative">
                    <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                    <div onclick="location.href='user.php'"
                        class="group relative z-20 cursor-pointer mb-3 text-md w-full bg-black hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-[#FFF12B] hover:border-black">
                        <i class="fa-solid fa-user text-[#FFF12B] group-hover:text-black duration-300 group-hover:text-black text-sm absolute mt-[1px] ms-[2px]"></i>
                        <a  class="text-[#FFF12B] duration-300 group-hover:text-black ps-6">User Management</a>
                        <div class="w-full bg-black h-full z-50"></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

                <!-- Profile -->
                <div class="h-screen flex">
                    <div class="mt-auto flex flex-col gap-3 w-full">
                        <div>
                            <div class="flex items-center ms-auto gap-2 mb-4">
                                <div class="relative">

                                <div class="absolute bg-green-600 rounded-full h-3 w-3 bottom-0 right-0 border border-black"></div>
                                    <!-- Kotak Profil dengan Warna Unik -->
                                    <div class="w-10 h-10 text-white rounded-full flex items-center justify-center font-poppins border-2 border-black"
                                    style="background-color: <?php echo $userColor; ?>;">
                                    <?php 
                                        $initial = strtoupper(substr($_SESSION['username'], 0, 1)); 
                                        echo $initial; 
                                    ?>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col">
                                    <?php if (isset($_SESSION['username'])): ?>
                                    <span class="text-3xl font-teko text-white">
                                        <?php echo $_SESSION['username']; ?></span>
                                        <span class="font-teko text-green-500 -mt-3 text-sm">online</span>
                                </div>
                                <?php else: ?>
                                <span class="text-2xl font-teko text-white">Welcome, guest!</span>
                                <?php endif; ?>
                            </div>
                            <div class="h-[1px] w-full bg-white/50 ms-auto rounded-full"></div>
                        </div>
                        <div class="relative">
                        <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                            <div onclick="location.href='./login/logout.php'" 
                                class="relative z-20 cursor-pointer text-md w-full bg-white hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-black flex justify-center">
                                <div class="flex justify-between">
                                    <i class="fa-solid fa-power-off text-black text-sm absolute mt-[2.5px] ms-[0px]"></i>
                                    <a  class="text-black px-6 font-teko text-xl">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Konten Utama -->
        <main class="flex-1 p-10 bg-gradient-to-r from-violet-300 via-white to-white z-10 relative">
            <?php include('./header/header.php'); ?>

            <div class="h-[2px] rounded-full w-full bg-black/10 mt-8"></div>
            <h1 class="text-3xl font-bold mb-4 mt-8 font-oswald uppercase">Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-3">

                <?php // Query untuk menghitung jumlah total produk
                    $query = "SELECT COUNT(*) AS total_produk FROM produk";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_produk = $row['total_produk'];
                ?>
                <div class="relative">
                    <div class="absolute z-10 w-full h-full bg-black rounded-lg translate-x-0.5 translate-y-0.5 shadow-2xl shadow-black/50"></div>
                    <div
                        class="z-20 group relative px-6 rounded-lg border-4 border-black hover:bg-gradient-to-tr hover:from-white hover:to-slate-200 shadow-black/20 bg-gradient-to-tr from-blue-500 to-blue-800 duration-300 hover:scale-105 hover:-translate-x-2 hover:-translate-y-2">
                        <div class="relative">
                            <i class="fa-solid fa-box text-black/20 text-8xl absolute right-6 mt-2"></i>
                        </div>
                        <div class="py-5 pb-12">
                            <h2 class="font-semibold font-teko text-2xl  group-hover:text-black text-white">Produk</h2>
                            <p class="text-slate-200 group-hover:text-black/75 font-oswald text-xl"><?php echo $total_produk; ?></p>
                        </div>
                        <div onclick="location.href='produk.php'" 
                            class="cursor-pointer absolute bottom-0 left-0 h-8 bg-blue-800 w-full rounded-b-sm flex justify-center items-center border-t-2 border-blue-950 gap-2 text-white/60 hover:text-black/60">
                            <h1 style="font-size:10px;" class="font-poppins">show more</h1>
                            <i style="font-size:10px;"  class=" fa-solid fa-circle-arrow-right mt-[1px]"></i>
                        </div>
                    </div>
                </div>

                <?php // Query untuk menghitung jumlah total pelanggan
                    $query = "SELECT COUNT(*) AS total_pelanggan FROM pelanggan";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_pelanggan = $row['total_pelanggan'];
                ?>
                <div class="relative">
                    <div class="absolute z-10 w-full h-full bg-black rounded-lg translate-x-0.5 translate-y-0.5  shadow-2xl shadow-black/50"></div>
                    <div
                        class="z-20 group relative px-6 rounded-lg shadow-lg border-4 border-black hover:bg-gradient-to-tr hover:from-white hover:to-slate-200 shadow-black/20 bg-gradient-to-tr from-red-500 to-red-700 duration-300 hover:scale-105 hover:-translate-x-2 hover:-translate-y-2">
                        <div class="relative">
                            <i class="fa-solid fa-person text-black/20 text-8xl absolute right-6 mt-2"></i>
                        </div>
                        <div class="py-5 pb-12">
                            <h2 class="font-semibold font-teko text-2xl  group-hover:text-black text-white">Pelanggan</h2>
                            <p class="text-slate-200 group-hover:text-black/75 font-oswald text-xl"><?php echo $total_pelanggan; ?></p>
                        </div>
                        <div onclick="location.href='produk.php'" 
                            class="cursor-pointer absolute bottom-0 left-0 h-8 bg-red-800 w-full rounded-b-sm flex justify-center items-center border-t-2 border-red-950 gap-2 text-white/60 hover:text-black/60">
                            <h1 style="font-size:10px;" class="font-poppins">show more</h1>
                            <i style="font-size:10px;"  class=" fa-solid fa-circle-arrow-right mt-[1px]"></i>
                        </div>
                    </div>
                </div>

                <?php // Query untuk menghitung jumlah total penjuakan
                    $query = "SELECT COUNT(*) AS total_penjualan FROM penjualan";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_penjualan = $row['total_penjualan'];
                ?>
                <div class="relative">
                    <div class="absolute z-10 w-full h-full bg-black rounded-lg translate-x-0.5 translate-y-0.5  shadow-2xl shadow-black/50"></div>
                    <div
                        class="z-20 group relative px-6 rounded-lg shadow-lg border-4 border-black hover:bg-gradient-to-tr hover:from-white hover:to-slate-200 shadow-black/20 bg-gradient-to-tr from-green-500 to-green-700 duration-300 hover:scale-105 hover:-translate-x-2 hover:-translate-y-2">
                        <div class="relative">
                            <i class="fa-solid fa-cart-shopping text-black/20 text-8xl absolute right-6 mt-2"></i>
                        </div>
                        <div class="py-5 pb-12">
                            <h2 class="font-semibold font-teko text-2xl group-hover:text-black text-white">Penjualan</h2>
                            <p class="text-slate-200 group-hover:text-black/75 font-oswald text-xl"><?php echo $total_penjualan; ?></p>
                        </div>
                        <div onclick="location.href='penjualan.php'" 
                            class="cursor-pointer absolute bottom-0 left-0 h-8 bg-green-800 w-full rounded-b-sm flex justify-center items-center border-t-2 border-green-950 gap-2 text-white/60 hover:text-black/60">
                            <h1 style="font-size:10px;" class="font-poppins">show more</h1>
                            <i style="font-size:10px;"  class=" fa-solid fa-circle-arrow-right mt-[1px]"></i>
                        </div>
                    </div>
                </div>

                <?php // Query untuk menghitung jumlah total detail penjualan
                    $query = "SELECT COUNT(*) AS total_detail_penjualan FROM detailpenjualan";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_detail_penjualan = $row['total_detail_penjualan'];
                ?>
                <div class="relative">
                    <div class="absolute z-10 w-full h-full bg-black rounded-lg translate-x-0.5 translate-y-0.5 shadow-2xl shadow-black/50"></div>
                    <div
                        class="z-20 group relative px-6 rounded-lg border-4 border-black hover:bg-gradient-to-tr hover:from-white hover:to-slate-200 shadow-black/20 bg-gradient-to-tr from-yellow-500 to-yellow-600 duration-300 hover:scale-105 hover:-translate-x-2 hover:-translate-y-2">
                        <div class="relative">
                            <i class="fa-solid fa-inbox text-black/20 text-8xl absolute right-6 mt-2"></i>
                        </div>
                        <div class="py-5 pb-12">
                            <h2 class="font-semibold font-teko text-2xl  group-hover:text-black text-white">Detail Penjualan</h2>
                            <p class="text-slate-200 group-hover:text-black/75 font-oswald text-xl"><?php echo $total_detail_penjualan; ?></p>
                        </div>
                        <div onclick="location.href='penjualan.php'" 
                            class="cursor-pointer absolute bottom-0 left-0 h-8 bg-yellow-800 w-full rounded-b-sm flex justify-center items-center border-t-2 border-yellow-950 gap-2 text-white/60 hover:text-black/60">
                            <h1 style="font-size:10px;" class="font-poppins">show more</h1>
                            <i style="font-size:10px;"  class=" fa-solid fa-circle-arrow-right mt-[1px]"></i>
                        </div>
                    </div>
                </div>


                <?php // Query untuk menghitung jumlah total user
                    $query = "SELECT COUNT(*) AS total_user FROM user";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_user = $row['total_user'];
                ?>
                <div class="relative">
                    <div class="absolute z-10 w-full h-full bg-black rounded-lg translate-x-0.5 translate-y-0.5 shadow-2xl shadow-black/50"></div>
                    <div
                        class="z-20 group relative px-6 rounded-lg border-4 border-black hover:bg-gradient-to-tr hover:from-white hover:to-slate-200 shadow-black/20 bg-gradient-to-tr from-violet-500 to-violet-800 duration-300 hover:scale-105 hover:-translate-x-2 hover:-translate-y-2">
                        <div class="relative">
                            <i class="fa-solid fa-user text-black/20 text-8xl absolute right-6 mt-2"></i>
                        </div>
                        <div class="py-5 pb-12">
                            <h2 class="font-semibold font-teko text-2xl group-hover:text-black text-white">Pengguna</h2>
                            <p class="text-slate-200 group-hover:text-black/75 font-oswald text-xl"><?php echo $total_user; ?></p>
                        </div>
                        <div onclick="location.href='.php'" 
                            class="cursor-pointer absolute bottom-0 left-0 h-8 bg-violet-800 w-full rounded-b-sm flex justify-center items-center border-t-2 border-violet-950 gap-2 text-white/60 hover:text-black/60">
                            <h1 style="font-size:10px;" class="font-poppins">show more</h1>
                            <i style="font-size:10px;"  class=" fa-solid fa-circle-arrow-right mt-[1px]"></i>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>