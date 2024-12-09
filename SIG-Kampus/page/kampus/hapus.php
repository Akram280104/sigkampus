<?php
session_start();

// Jika pengguna bukan admin, arahkan kembali ke halaman utama
if ($_SESSION['level'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>
<?php
	
	$id = $_GET ['id'];

	$koneksi->query("delete from tb_kampus where id ='$id'");

?>


<script type="text/javascript">
		window.location.href="?page=kampus";
</script>