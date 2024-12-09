<?php  
session_start();

// Jika pengguna bukan admin, arahkan kembali ke halaman utama
if ($_SESSION['level'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "sig_kampus");

// Menyimpan data kampus baru
$message = ''; // Variabel untuk menyimpan pesan

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama = htmlspecialchars($_POST['nama']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $visi_misi = htmlspecialchars($_POST['visi_misi']);
    $prodi = htmlspecialchars($_POST['prodi']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);

    // Proses foto
    $foto = ''; // Foto default kosong
    if ($_FILES['foto']['name']) {
        $targetDir = "uploads/";
        $foto = basename($_FILES['foto']['name']);
        $targetFilePath = $targetDir . $foto;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Validasi format file
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Upload file
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
                $message = 'Foto berhasil diunggah.';
            } else {
                $message = 'Gagal mengunggah foto.';
            }
        } else {
            $message = 'Format foto tidak valid (hanya jpg, jpeg, png, gif).';
        }
    }

    // Menggunakan prepared statement untuk menambahkan data ke database
    $insertStmt = $koneksi->prepare("INSERT INTO tb_kampus (nama, alamat, visi_misi, prodi, foto, latitude, longitude) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("sssssss", $nama, $alamat, $visi_misi, $prodi, $foto, $latitude, $longitude);

    // Jika data berhasil ditambahkan
    if ($insertStmt->execute()) {
        $message = 'Data berhasil ditambahkan.';
    } else {
        $message = 'Data gagal ditambahkan: ' . $koneksi->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kampus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Tambah Data Kampus</h2>

    <!-- Tampilkan pesan jika ada -->
    <?php if ($message != ''): ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="">
        <div class="form-group">
            <label>Nama Kampus</label>
            <input type="text" name="nama" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Visi Misi</label>
            <textarea name="visi_misi" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Prodi</label>
            <input type="text" name="prodi" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control-file" />
        </div>
        <div class="form-group">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" required />
        </div>

        <input type="submit" name="submit" value="Tambah" class="btn btn-primary" />
    </form>
</div>

<script>

	const map = L.map('map').setView([-4.338201798942075, 119.87477310937835], 13);

	const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

	const marker = L.marker([-4.338201798942075, 119.87477310937835]).addTo(map)
		

	const popup = L.popup()
		.setLatLng([-4.338201798942075, 119.87477310937835])
		.openOn(map);

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent(`${e.latlng.toString()}`)
			.openOn(map);
	}

	map.on('click', onMapClick);

</script>

</body>
</html>
