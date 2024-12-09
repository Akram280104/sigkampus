<?php 
session_start();

// Jika pengguna bukan admin, arahkan kembali ke halaman utama
if ($_SESSION['level'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>
<?php   
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "sig_kampus");

// Cek jika ID kampus tidak ada di URL
if (!isset($_GET['id'])) {
    header("Location: kampus.php?message=ID tidak valid.");
    exit();
}

$id = $_GET['id'];

// Mengambil data kampus berdasarkan ID
$stmt = $koneksi->prepare("SELECT * FROM tb_kampus WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Jika kampus tidak ditemukan
if (!$data) {
    header("Location: kampus.php?message=Data tidak ditemukan.");
    exit();
}

$message = ''; // Variabel untuk menyimpan pesan

// Proses pembaruan data kampus
if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $visi_misi = htmlspecialchars($_POST['visi_misi']);
    $prodi = htmlspecialchars($_POST['prodi']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);
    
    // Proses foto
    $foto = $data['foto'];
    if ($_FILES['foto']['name']) {
        $targetDir = "uploads/";
        $foto = basename($_FILES['foto']['name']);
        $targetFilePath = $targetDir . $foto;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Validasi format file
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Upload file
            move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath);
        } else {
            $message = 'Format foto tidak valid (hanya jpg, jpeg, png, gif).';
        }
    }

    // Menggunakan prepared statement untuk update data
    $updateStmt = $koneksi->prepare("UPDATE tb_kampus SET nama = ?, alamat = ?, visi_misi = ?, prodi = ?, foto = ?, latitude = ?, longitude = ? WHERE id = ?");
    $updateStmt->bind_param("sssssssi", $nama, $alamat, $visi_misi, $prodi, $foto, $latitude, $longitude, $id);

    // Jika update berhasil
    if ($updateStmt->execute()) {
        $message = 'Data berhasil diperbarui.';
    } else {
        $message = 'Data gagal diperbarui: ' . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Kampus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Ubah Data Kampus</h2>

    <!-- Tampilkan pesan jika ada -->
    <?php if ($message != ''): ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="">
        <div class="form-group">
            <label>NAMA</label>
            <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama']); ?>" required />
        </div>
        <div class="form-group">
            <label>ALAMAT</label>
            <input type="text" name="alamat" class="form-control" value="<?php echo htmlspecialchars($data['alamat']); ?>" required />
        </div>
        <div class="form-group">
            <label>VISI MISI</label>
            <textarea name="visi_misi" class="form-control" required><?php echo htmlspecialchars($data['visi_misi']); ?></textarea>
        </div>
        <div class="form-group">
            <label>PRODI</label>
            <input type="text" name="prodi" class="form-control" value="<?php echo htmlspecialchars($data['prodi']); ?>" required />
        </div>
        <div class="form-group">
            <label>FOTO</label>
            <input type="file" name="foto" class="form-control-file" />
            <small>File saat ini: <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Kampus" width="100"></small>
        </div>
        <div class="form-group">
            <label>Latitude</label>
            <input type="text" name="latitude" class="form-control" value="<?php echo htmlspecialchars($data['latitude']); ?>" required />
        </div>
        <div class="form-group">
            <label>Longitude</label>
            <input type="text" name="longitude" class="form-control" value="<?php echo htmlspecialchars($data['longitude']); ?>" required />
        </div>

        <input type="submit" name="submit" value="Perbarui" class="btn btn-primary" />
    </form>
</div>

</body>
</html>
