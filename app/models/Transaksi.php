<?php
class Transaksi
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    // Fungsi untuk mengambil semua data transaksi
    public function getAllTransaksi()
    {
        $query = "SELECT t.id_transaksi, p.kode_barang, pel.id_pelanggan, t.jumlah,
                  t.total_harga, t.tanggal
                  FROM transaksi t
                  JOIN barang p ON t.kode_barang = p.kode_barang
                  JOIN pelanggan pel ON t.id_pelanggan = pel.id_pelanggan";
        return $this->db->query($query)->fetchAll();
    }

    // Fungsi untuk membuat data transaksi baru
    public function create($data)
    {
        $query = "INSERT INTO transaksi (id_transaksi, kode_barang, id_pelanggan, jumlah, total_harga, tanggal)
                  VALUES (:id_transaksi, :kode_barang, :id_pelanggan, :jumlah, :total_harga, :tanggal)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
    }

    // Fungsi untuk memeriksa keberadaan produk
    public function checkProdukExists($kode_barang)
    {
        $query = "SELECT COUNT(*) FROM barang WHERE kode_barang = :kode_barang";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['kode_barang' => $kode_barang]);
        return $stmt->fetchColumn() > 0;
    }

    // Fungsi untuk memeriksa keberadaan pelanggan
    public function checkPelangganExists($id_pelanggan)
    {
        $query = "SELECT COUNT(*) FROM pelanggan WHERE id_pelanggan = :id_pelanggan";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_pelanggan' => $id_pelanggan]);
        return $stmt->fetchColumn() > 0;
    }

    // Fungsi untuk mendapatkan semua produk (opsional, jika dibutuhkan dalam controller)
    public function getAllProduk()
    {
        $query = "SELECT * FROM barang";
        return $this->db->query($query)->fetchAll();
    }

    // Fungsi untuk mendapatkan semua pelanggan (opsional, jika dibutuhkan dalam controller)
    public function getAllPelanggan()
    {
        $query = "SELECT * FROM pelanggan";
        return $this->db->query($query)->fetchAll();
    }

    public function getDetailTransaksi($id)
    {
        $query = "SELECT t.id_transaksi, p.nama_barang, pel.nama_pelanggan, t.jumlah, t.total_harga, t.tanggal
              FROM transaksi t
              JOIN barang p ON t.kode_barang = p.kode_barang
              JOIN pelanggan pel ON t.id_pelanggan = pel.id_pelanggan
              WHERE t.id_transaksi = :id"; // Pastikan 'produk' sesuai dengan nama tabel Anda

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
