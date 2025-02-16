<?php

session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['role'])) {
    header("Location: .login/login.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Cek apakah user memiliki level 'admin'
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect ke halaman utama jika bukan admin
    exit();
}


// Tambah user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO user (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $stmt->close();
    header("Location: user.php");
    exit();
}

// Edit user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $userID = $_POST['userID'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE user SET username = ?, password = ?, role = ? WHERE userID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $username, $password, $role, $userID);
    } else {
        $query = "UPDATE user SET username = ?, role = ? WHERE userID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $username, $role, $userID);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: user.php");
    exit();
}

// Hapus user
if (isset($_GET['delete'])) {
    $userID = $_GET['delete'];
    $query = "DELETE FROM user WHERE userID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->close();
    header("Location: user.php");
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

$result = $conn->query("SELECT * FROM user");
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

<div class="h-screen flex">

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
                        class="group relative z-20 cursor-pointer mb-3 text-md w-full bg-[#FFF12B] rounded-md p-1 px-2 scale-105 duration-300 shadow-xl shadow-black/5 -translate-x-1 -translate-y-1 border-2 border-black">
                        <i class="fa-solid fa-user duration-300 text-black text-sm absolute mt-[1px] ms-[2px]"></i>
                        <a  class="duration-300 text-black ps-6">User Management</a>
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

    <div class="flex-1 p-10 bg-gradient-to-r from-violet-300 via-white to-white z-10 relative">
        <?php include('./header/header.php') ?>

        <div class="h-[2px] rounded-full w-full bg-black/10 mt-8"></div>
    <h2 class="text-2xl font-bold mb-4 mt-8">Manajemen User</h2>
    <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="openModal('createModal')">Tambah User</button>
    
    <table class="w-full bg-white shadow-md rounded mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">#</th>
                <th class="p-2">Username</th>
                <th class="p-2">Role</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr class="border-t">
                    <td class="p-2"><?= $row['userID'] ?></td>
                    <td class="p-2"><?= $row['username'] ?></td>
                    <td class="p-2"><?= ucfirst($row['role']) ?></td>
                    <td class="p-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="editUser('<?= $row['userID'] ?>', '<?= $row['username'] ?>', '<?= $row['role'] ?>')">Edit</button>
                        <a href="user.php?delete=<?= $row['userID'] ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Hapus user ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Create -->
<div id="createModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded w-96">
        <h3 class="text-xl mb-3">Tambah User</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <input type="text" name="username" placeholder="Username" class="w-full p-2 border rounded mb-3" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded mb-3" required>
            <select name="role" class="w-full p-2 border rounded mb-3" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</button>
            <button type="button" class="ml-2" onclick="closeModal('createModal')">Batal</button>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded w-96">
        <h3 class="text-xl mb-3">Edit User</h3>
        <form method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="userID" id="editUserID">
            <input type="text" name="username" id="editUsername" class="w-full p-2 border rounded mb-3" required>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full p-2 border rounded mb-3">
            <select name="role" id="editRole" class="w-full p-2 border rounded mb-3" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
            <button type="button" class="ml-2" onclick="closeModal('editModal')">Batal</button>
        </form>
    </div>
</div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.remove("hidden");
}
function closeModal(id) {
    document.getElementById(id).classList.add("hidden");
}
function editUser(id, username, role) {
    document.getElementById("editUserID").value = id;
    document.getElementById("editUsername").value = username;
    document.getElementById("editRole").value = role;
    openModal('editModal');
}
</script>
</body>
</html>