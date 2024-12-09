
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(45deg, green, blue);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            flex: 1;
            text-align: center;
        }

        .header .btn-container {
            display: flex;
            gap: 10px;
        }

        .btn-login {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-login:hover {
            background-color: #218838;
        }

        #map {
            height: calc(100vh - 120px); /* Total tinggi layar dikurangi tinggi header */
            width: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <title>SIG Kampus</title>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Selamat Datang di Sistem Informasi Geografis Lokasi Kampus </h1>
        <a href="login.php" class="btn btn-login">Login</a>
        
    </div>

    <div style="
    background: linear-gradient(45deg, green, blue);
    color: white;
    padding: 20px;
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
    border-radius: 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 100vw;
    margin: 0;
">
    Sistem ini membantu Anda menemukan kampus dengan mudah dan cepat. 
    Gunakan fitur peta untuk melihat lokasi kampus di sekitar Anda.
</div>

    
<?php  
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "sig_kampus");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil data dari tabel tb_kampus
$query = "SELECT * FROM tb_kampus";
$result = $koneksi->query($query);

$kampus = array(); // Deklarasi array menggunakan fungsi array()

// Mengambil data dari tabel tb_kampus
$query = "SELECT * FROM tb_kampus";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kampus[] = array(
            'id' => $row['id'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'visi_misi' => $row['visi_misi'],
            'prodi' => $row['prodi'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'foto' => $row['foto'] // Foto kampus
        );
    }
}


// Jika ada parameter id di URL, tampilkan detail kampus
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM tb_kampus WHERE id = $id";
    $result = $koneksi->query($query);
    $kampusDetail = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .leaflet-popup-content {
            font-size: 25px;
        }
        .foto-kampus {
            width: 300px;
            height: 200px;
            object-fit: cover;
            margin-bottom: 5px;
        }
        .btn-detail {
            display: inline-block;
            margin-top: 20px;
            padding: 5px 10px;
            background-color: #28a745;
            color: black;
            text-decoration: center;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-detail:hover {
            background-color: red;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    

    <?php if (isset($kampusDetail)): ?>
        <!-- Menampilkan detail kampus dalam bentuk tabel -->
        <h2>Detail Kampus</h2>
        <table>
            <tr>
                <th>Nama Kampus</th>
                <td><?php echo $kampusDetail['nama']; ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo $kampusDetail['alamat']; ?></td>
            </tr>
            <tr>
                <th>Visi Misi</th>
                <td><?php echo $kampusDetail['visi_misi']; ?></td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td><?php echo $kampusDetail['prodi']; ?></td>
            </tr>
            
            <tr>
                <th>Foto Kampus</th>
                <td>
                    <?php 
                    $fotoPath = $kampusDetail['foto'] ? 'uploads/' . $kampusDetail['foto'] : 'uploads/default.jpg';
                    echo "<img src='$fotoPath' class='foto-kampus' alt='Foto Kampus'>";
                    ?>
                </td>
            </tr>
        </table>
        <a href="user.php" class="btn-detail">Kembali ke Maps</a>
    <?php else: ?>
        <!-- Peta Lokasi -->
        <div id="map"></div>
    <?php endif; ?>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta dengan koordinat default
        var map = L.map('map').setView([-4.3489941, 119.8843336], 13);

        // Menambahkan layer peta dari OpenStreetMap
        var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Menambahkan layer peta dari Satellite (Mapbox)
        var satelliteLayer = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-v9/tiles/{z}/{x}/{y}?access_token=YOUR_MAPBOX_ACCESS_TOKEN', {
            maxZoom: 19,
            attribution: '© Mapbox'
        });

        // Menambahkan kontrol untuk beralih antara peta
        var baseMaps = {
            
            
        };

       
        // Data kampus dari PHP
        var kampus = <?php echo json_encode($kampus); ?>;

        // Menambahkan marker untuk setiap lokasi kampus
        kampus.forEach(function(k) {
            var fotoSrc = k.foto ? 'uploads/' + k.foto : 'uploads/default.jpg';

            // Membuat marker pada lokasi kampus
            var marker = L.marker([k.latitude, k.longitude]).addTo(map);

            // Membuat konten popup dengan foto dan tombol detail
            var popupContent = `
                <b>${k.nama}</b><br>
                <img src="${fotoSrc}" class="foto-kampus" alt="Foto Kampus"><br>
                <b>Alamat:</b> ${k.alamat}<br>
                
                
                <a href="?id=${k.id}" class="btn-detail">Detail</a>
                <a href="#" class="btn-detail" onclick="getRoute(${k.latitude}, ${k.longitude})">RUTE</a>
                
            `;

            // Mengikat popup pada marker
            marker.bindPopup(popupContent);
        });

        // Fungsi untuk mendapatkan rute ke kampus yang dipilih
        function getRoute(destLat, destLng) {
            // Mendapatkan lokasi pengguna
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var originLat = position.coords.latitude;
                    var originLng = position.coords.longitude;

                    // Membuat URL rute ke Google Maps
                    var routeUrl = `https://www.google.com/maps/dir/?api=1&origin=${originLat},${originLng}&destination=${destLat},${destLng}&travelmode=driving`;

                    // Arahkan ke Google Maps
                    window.open(routeUrl, '_blank');
                }, function(error) {
                    alert('Gagal mendapatkan lokasi pengguna');
                });
            } else {
                alert('Geolocation tidak didukung oleh browser ini.');
            }
        }
    </script>
    
</body>
</html>
