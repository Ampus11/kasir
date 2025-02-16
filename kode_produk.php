<?php
// Menampilkan produk dalam keranjang
foreach ($_SESSION['keranjang'] as $produk) {
    echo "<div>";
    echo "<p>{$produk['nama_produk']}</p>";
    echo "<p>Harga: Rp " . number_format($produk['harga'], 0, ',', '.') . "</p>";
    echo "<p>Stok: {$produk['stok']}</p>";
    echo "<a href='hapus_produk.php?kode_produk={$produk['kode_produk']}' class='btn btn-danger'>Hapus</a>";
    echo "</div>";
}
?>
