<?php
session_start();

// Jika pengguna bukan admin, arahkan kembali ke halaman utama
if ($_SESSION['level'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>
<?php

	$ambil = $koneksi->query("select * from tb_user where id='$_GET[id]'");

	$data = $ambil->fetch_assoc();

	$foto_produk=$data['foto'];

	if (file_exists("images/$foto_produk")) {
		unlink("images/$foto_produk");
	}

	$koneksi->query("delete from tb_user where id='$_GET[id]'");



?>


<script type="text/javascript">
	alert ("Data Berhasil Dihapus");
    window.location.href="?page=pengguna";
</script>