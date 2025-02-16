
<div class="relative">
    <div class="absolute z-10 h-full w-full bg-black rounded-lg"></div>
    <div
        class="rounded-lg bg-[#FFF12B] border-2 border-black shadow-2xl shadow-black/10 w-full h-16 flex justify-between items-center p-4 relative z-20 -translate-x-1 -translate-y-1 shadow-xl shadow-black/30">
        <!-- Nama Akun dan Foto Profil -->
        <div class="flex items-center ms-auto">
            <?php if (isset($_SESSION['username'])): ?>
            <span class="text-md font-normal text-gray-800 font-oswald">Welcome our dearest user,
                <?php echo $_SESSION['username']; ?></span>

            <!-- Kotak Profil dengan Warna Unik -->
            <div class="w-10 h-10 text-white rounded-full flex items-center justify-center ml-6 border-black border-2"
                style="background-color: <?php echo $userColor; ?>;">
                <?php 
                    $initial = strtoupper(substr($_SESSION['username'], 0, 1)); 
                    echo $initial; 
                ?>
            </div>
            <?php else: ?>
            <span class="text-md font-light text-gray-800">Welcome, guest!</span>
            <?php endif; ?>
        </div>
    </div>
</div>