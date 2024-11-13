

<?php
require_once 'config/database.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/BarangController.php';
require_once 'app/controllers/PelangganController.php';
require_once 'app/controllers/TransaksiController.php';

// Koneksi Database
$database = new Database();
$db = $database->getConnection();

// Menangkap Controller dan Action dari URL
if (isset($_GET['controller']) && isset($_GET['action'])) {
$controller = $_GET['controller'];
$action = $_GET['action'];
$id = $_GET['id'] ?? null; // Ambil ID dari URL jika ada

// Menentukan controller yang sesuai
switch ($controller) {
    case 'barang':
        $controllerObj = new BarangController($db);
        break;
    case 'pelanggan':
        $controllerObj = new PelangganController($db);
        break;
    case 'transaksi':
        $controllerObj = new TransaksiController($db);
        break;
    default:
        $controllerObj = new HomeController($db);
        break;
}

//sampai sini  Memanggil action yang sesuai
if (method_exists($controllerObj, $action)) {
    // Memanggil metode detail jika action adalah detail dan $id ada
    if ($action === 'detail' && $id !== null) {
        $controllerObj->detail($id);
    } elseif ($action === 'edit' && $id !== null) {
        $controllerObj->edit($id);
    } elseif ($action === 'delete' && $id !== null) {
        $controllerObj->delete($id);
    } elseif ($action === 'update') {
        $controllerObj->update(); // Panggil update tanpa parameter
    } else {
        // Panggil action lain tanpa parameter
        $controllerObj->$action();
    }
} else {
    echo "Aksi tidak ditemukan.";
    }
} else {
    // Jika controller dan action tidak ditentukan, tampilkan halaman home atau dashboard
    $controllerObj = new HomeController();
    $controllerObj->index(); 
}


// Tampilkan kesalahan jika ada
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
