<?php

class BarangController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $query = "SELECT * FROM barang";
        $statement = $this->db->query($query);
        $data = $statement->fetchAll();

        require_once __DIR__ . "/../Views/Barang/indexb.php";
    }

    public function create()
    {
        // Menampilkan form untuk tambah data barang
        require_once __DIR__ . "/../Views/Barang/create.php";
    }

    public function store()
    {
        // Menyimpan data barang yang di-post dari form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode_barang = $_POST['kode_barang'];
            $nama_barang = $_POST['nama_barang'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok) VALUES (:kode_barang, :nama_barang, :harga, :stok)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kode_barang', $kode_barang);
            $stmt->bindParam(':nama_barang', $nama_barang);
            $stmt->bindParam(':harga', $harga);
            $stmt->bindParam(':stok', $stok);
            $stmt->execute();

            header("Location: index.php?controller=barang&action=index");
            exit();
        }
    }

    public function edit($id)
    {
        // Ambil data barang berdasarkan kode_barang
        $query = "SELECT * FROM barang WHERE kode_barang = :kode_barang";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kode_barang', $id);
        $stmt->execute();
        $barang = $stmt->fetch();

        // Pastikan barang ditemukan sebelum melanjutkan
        if ($barang) {
            require_once __DIR__ . "/../views/barang/editb.php"; // Menampilkan form edit
        } else {
            echo "Barang tidak ditemukan.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode_barang = $_POST['kode_barang'];
            $nama_barang = $_POST['nama_barang'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $query = "UPDATE barang SET nama_barang = :nama_barang, harga = :harga, stok = :stok WHERE kode_barang = :kode_barang";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kode_barang', $kode_barang);
            $stmt->bindParam(':nama_barang', $nama_barang);
            $stmt->bindParam(':harga', $harga);
            $stmt->bindParam(':stok', $stok);
            $stmt->execute();

            header("Location: index.php?controller=barang&action=index");
            exit();
        }
    }

    public function delete($id)
    {
        // Menghapus data barang berdasarkan kode_barang
        $query = "DELETE FROM barang WHERE kode_barang = :kode_barang";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kode_barang', $id);

        if ($stmt->execute()) {
            header("Location:index.php?controller=barang&action=index");
            exit();
        } else {
            echo "Gagal menghapus barang.";
        }
    }
}
