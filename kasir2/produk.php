<?php
session_start();    
// Menggunakan koneksi dari file koneksi.php
require_once "koneksi.php";

// Tambah Produk
if (isset($_POST['add'])) {
    $namabarang = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO produk (NamaProduk, Harga, Stok) VALUES ('$namabarang', '$harga', '$stok')";
    if ($conn->query($sql) === TRUE) {
        header("Location: produk.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit Produk
if (isset($_POST['edit'])) {
    $id = $_POST['produk_id'];
    $namabarang = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "UPDATE produk SET NamaProduk='$namabarang', Harga='$harga', Stok='$stok' WHERE ProdukID='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: produk.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus Produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM produk WHERE ProdukID='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: produk.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
    <title>Produk</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="">

<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 z-20 shadow-xl shadow-black/70 bg-white bg-gradient-to-b from-violet-800 to-violet-950 text-white p-9 flex flex-col border-r-4 border-black relative">
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
                    class="relative z-20 cursor-pointer mb-3 text-md w-full bg-[#FFF12B] rounded-md p-1 px-2 scale-105 duration-300 shadow-xl shadow-black/5 -translate-x-1 -translate-y-1 border-2 border-black">
                    <i class="fa-solid fa-box text-black text-sm absolute mt-[1px] ms-[2px]"></i>
                    <a class="text-black px-6">Data Produk</a>
                    <div class="w-full bg-black h-full z-50"></div>
                </div>
            </div>
            <div class="relative">
                <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                <div onclick="location.href='pelanggan.php'"
                    class="relative z-20 cursor-pointer mb-3 text-md w-full bg-white hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-black">
                    <i class="fa-solid fa-person text-black text-sm absolute mt-[1px] ms-[2px]"></i>
                    <a class="text-black px-6">Data Pelanggan</a>
                    <div class="w-full bg-black h-full z-50"></div>
                </div>
            </div>
            <div class="relative">
                <div class="absolute z-10 h-full w-full bg-black rounded-md"></div>
                <div onclick="location.href='penjualan.php'"
                    class="relative z-20 cursor-pointer mb-3 text-md w-full bg-white hover:bg-[#FFF12B] rounded-md p-1 px-2 hover:scale-105 duration-300 shadow-xl shadow-black/5 hover:-translate-x-1 hover:-translate-y-1 border-2 border-black">
                    <i class="fa-solid fa-cart-shopping text-black text-sm absolute mt-[1px] ms-[0px]"></i>
                    <a class="text-black px-6">Penjualan</a>
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
                    <a class="text-[#FFF12B] duration-300 group-hover:text-black ps-6">User  Management</a>
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
                            <a class="text-black px-6 font-teko text-xl">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 p-10 bg-gradient-to-r from-violet-300 via-white to-white">
        <?php include('./header/header.php') ?>

        <div class="h-[2px] rounded-full w-full bg-black/10 mt-8"></div>
        <h2 class="text-2xl font-bold text-gray-700 mt-8 mb-4">Data Produk</h2>

        <!-- Tombol Tambah Produk -->
        <button onclick="toggleModal('addModal')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Produk</button>

        <!-- Tabel Produk -->
        <table class="w-full mt-4 border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Nama Produk</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Stok</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM produk");
                while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr class='text-center'>
                        <td class='border p-2'><?php echo $row['ProdukID']; ?></td>
                        <td class='border p-2'><?php echo $row['NamaProduk']; ?></td>
                        <td class='border p-2'>Rp<?php echo number_format($row['Harga'], 2, ',', '.'); ?></td>
                        <td class='border p-2'><?php echo $row['Stok']; ?></td>
                        <td class='border p-2'>
                            <button onclick="deleteProduk('<?php echo $row['ProdukID']; ?>')" class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600'>Hapus</button>
                            <button onclick="editModal('<?php echo $row['ProdukID']; ?>', '<?php echo $row['NamaProduk']; ?>', '<?php echo $row['Harga']; ?>', '<?php echo $row['Stok']; ?>')" class='bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600'>Edit</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div id="addModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-96">
            <h3 class="text-xl font-bold mb-4">Tambah Produk</h3>
            <form method="POST">
                <input type="text" name="nama_produk" placeholder="Nama Produk" class="w-full border p-2 rounded mb-2" required>
                <input type="number" name="harga" placeholder="Harga" class="w-full border p-2 rounded mb-2" required>
                <input type="number" name="stok" placeholder="Stok" class="w-full border p-2 rounded mb-2" required>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="toggleModal('addModal')" class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" name="add" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-96">
            <h3 class="text-xl font-bold mb-4">Edit Produk</h3>
            <form method="POST">
                <input type="hidden" id="edit_produk_id" name="produk_id">
                <input type="text" id="edit_nama_produk" name="nama_produk" placeholder="Nama Produk" class="w-full border p-2 rounded mb-2" required>
                <input type="number" id="edit_harga" name="harga" placeholder="Harga" class="w-full border p-2 rounded mb-2" required>
                <input type="number" id="edit_stok" name="stok" placeholder="Stok" class="w-full border p-2 rounded mb-2" required>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="toggleModal('editModal')" class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" name="edit" class="px-4 py-2 bg-yellow-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(id) {
        let modal = document.getElementById(id);
        if (modal) {
            modal.classList.toggle("hidden");
        } else {
            console.error("Modal dengan ID " + id + " tidak ditemukan!");
        }
    }

    function editModal(id, nama, harga, stok) {
        document.getElementById("edit_produk_id").value = id;
        document.getElementById("edit_nama_produk").value = nama;
        document.getElementById("edit_harga").value = harga;
        document.getElementById("edit_stok").value = stok;
        toggleModal("editModal");
    }

    function deleteModal(id) {
        document.getElementById("delete_produk_id").value = id;
        toggleModal("deleteModal");
    }

    // ini scrit untuk alert pada delete produk
    function deleteProduk(id) {
        if (confirm("Yakin ingin menghapus produk ini?")) {
            window.location.href = "produk.php?delete=" + id;
        }
    }
</script>
</body>
</html>