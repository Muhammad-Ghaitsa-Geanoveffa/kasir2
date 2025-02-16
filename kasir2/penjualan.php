<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

$UserID = $_SESSION['UserID'];

// Tambah atau Edit Data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['PenjualanID'];
    $tanggal = date('Y-m-d'); 
    $pelanggan = $_POST['PelangganID'];

    if ($id) {
        $query = "UPDATE penjualan SET TanggalPenjualan='$tanggal', PelangganID='$pelanggan' WHERE PenjualanID='$id'";
    } else {
        $query = "INSERT INTO penjualan (UserID, TanggalPenjualan, PelangganID) VALUES ('$UserID', '$tanggal', '$pelanggan')";
    }
    mysqli_query($conn, $query);
    header("Location: penjualan.php");
    exit;
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM penjualan WHERE PenjualanID='$id'");
    header("Location: penjualan.php");
    exit;
}

// Ambil data penjualan
$query = "SELECT p.*, pl.NamaPelanggan, u.username FROM penjualan p 
          JOIN pelanggan pl ON p.PelangganID = pl.PelangganID
          JOIN user u ON p.UserID = u.UserID";
$result = mysqli_query($conn, $query);

// Ambil data pelanggan untuk dropdown
$query_pelanggan = "SELECT * FROM pelanggan";
$result_pelanggan = mysqli_query($conn, $query_pelanggan);


function generateUserColor($username) {
    $hash = md5($username); // Hash dari username
    $color = substr($hash, 0, 6); // Ambil 6 karakter pertama sebagai warna hex
    return "#" . $color;
}

if (isset($_SESSION['username'])) {
    $userColor = generateUserColor($_SESSION['username']);
    
}$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="">


<div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 z-20 shadow-xl shadow-black/70 bg-white bg-gradient-to-b from-violet-800 to-violet-950 text-white p-9 flex flex-col    border-r-4 border-black relative">
            <div class="p-4 text-4xl font-semibold text-white border-b font-teko text-center mt-[12px]">Menu</div>
            <div class="mt-8 font-teko text-xl uppercase">
                <div class="relative">
                    <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                    <div onclick="location.href='index.php'"
                        class="relative z-20 cursor-pointer mb-3 text-md w-full bg-white hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-black">
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
                        class="relative z-20 cursor-pointer mb-3 text-md w-full bg-[#FFF12B] rounded-md p-1 px-2 scale-105 duration-300 shadow-xl shadow-black/5 -translate-x-1 -translate-y-1 border-2 border-black">
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


    <div class="flex-1 p-10 bg-gradient-to-r from-violet-300 via-white to-white">
    <?php include('./header/header.php'); ?>

    <div class="h-[2px] rounded-full w-full bg-black/10 mt-8"></div>
    <h2 class="text-2xl font-bold mb-4 mt-8">Data Penjualan</h2>
    <button class="bg-blue-500 text-white px-4 py-2 mb-4" onclick="toggleModal('modalTambah')">Tambah Penjualan</button>
    
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Pelanggan</th>
                <th class="border px-4 py-2">User </th>
                <th class="border px-4 py-2">Total Harga</th> <!-- Kolom baru -->
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $row['PenjualanID']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['TanggalPenjualan']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['NamaPelanggan']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['username']; ?></td>
                    <td class="border px-4 py-2"><?php echo number_format($row['TotalHarga'], 2); ?></td> <!-- Tampilkan Total Harga -->
                    <td class="border px-4 py-2">
                        <button class="bg-yellow-500 text-white px-3 py-1" onclick="editData(<?php echo $row['PenjualanID']; ?>, <?php echo $row['PelangganID']; ?>)">Edit</button>
                        <a href="?hapus=<?php echo $row['PenjualanID']; ?>" class="bg-red-500 text-white px-3 py-1">Hapus</a>
                        <a href="detailpenjualan.php?id=<?php echo $row['PenjualanID']; ?>" class="bg-green-500 text-white px-3 py-1">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="fixed inset-0 hidden bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h3 class="text-xl mb-4">Tambah Penjualan</h3>
            <form action="penjualan.php" method="post">
                <label>Pelanggan:</label>
                <select name="PelangganID" class="border p-2 w-full">
                    <?php while ($pelanggan = mysqli_fetch_assoc($result_pelanggan)) : ?>
                        <option value="<?php echo $pelanggan['PelangganID']; ?>"><?php echo $pelanggan['NamaPelanggan']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-2">Simpan</button>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 mt-2" onclick="toggleModal('modalTambah')">Batal</button>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="modalEdit" class="fixed inset-0 hidden bg-gray-600 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h3 class="text-xl mb-4">Edit Penjualan</h3>
            <form action="penjualan.php" method="post">
                <input type="hidden" name="PenjualanID" id="editPenjualanID">
                <label>Pelanggan:</label>
                <select name="PelangganID" id="editPelangganID" class="border p-2 w-full"></select>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-2">Simpan</button>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 mt-2" onclick="toggleModal('modalEdit')">Batal</button>
            </form>
        </div>
    </div>
    </div>
</div>

    <script>
        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        function editData(id, pelanggan) {
            document.getElementById('editPenjualanID').value = id;
            document.getElementById('editPelangganID').value = pelanggan;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>
</body>
</html>
