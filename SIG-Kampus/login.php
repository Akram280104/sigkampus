<?php 
    error_reporting(0);
    ob_start();
    session_start();

    $koneksi = new mysqli("localhost", "root", "", "sig_kampus");

    if ($_SESSION['admin'] || $_SESSION['user']) {
        header("location:index.php");
    } else {
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIG KAMPUS</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<style>
       body {
    background-image: url('depositphotos_295558482-stock-illustration-university-campus-building-hall-education.jpg'); /* Pastikan jalur gambar benar */
    background-size: cover; /* Membuat gambar memenuhi layar */
    background-repeat: no-repeat; /* Mencegah pengulangan gambar */
    background-position: center center; /* Memusatkan gambar secara horizontal dan vertikal */
    font-family: 'Open Sans', sans-serif; /* Mengatur gaya font */
    color: #fff; /* Warna teks putih untuk kontras dengan background */
    margin: 0; /* Menghapus margin default dari body */
    padding: 0; /* Menghapus padding default dari body */
    height: 100vh; /* Memastikan body mengambil tinggi penuh viewport */
    width: 100vw; /* Memastikan body mengambil lebar penuh viewport */
}



        .panel {
            border-radius: 10px; /* Rounded corners for the panel */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Shadow effect */
            background-color: #6c757d; /* Darker panel background */
        }

        .panel-heading {
            background-color: #007bff; /* Bootstrap primary color */
            color: white; /* Text color */
            text-align: center; /* Center text */
            border-top-left-radius: 10px; /* Rounded corners */
            border-top-right-radius: 10px; /* Rounded corners */
            padding: 15px; /* Padding for the heading */
        }

        h2 {
            margin-bottom: 30px; /* Space below the heading */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); /* Text shadow for heading */
            color: white
        }

        .form-control {
            border-radius: 5px; /* Rounded corners for input fields */
            border: 1px solid #ced4da; /* Border color */
            background-color: black; /* Darker input background */
            color: #fff; /* Text color in input */
            transition: border-color 0.3s; /* Smooth transition for border color */
        }

        .form-control:focus {
            border-color: #007bff; /* Change border color on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add shadow on focus */
            background-color: #5a6268; /* Slightly darker on focus */
        }

        .btn {
            border-radius: 5px; /* Rounded corners for buttons */
            transition: background-color 0.3s; /* Smooth transition for background color */
        }

        .btn-primary {
            background-color: #007bff; /* Bootstrap primary color */
            border-color: #007bff; /* Border color */
        }

        .btn-primary:hover {
            background-color: black; /* Darker blue on hover */
            border-color: #0056b3; /* Darker border on hover */
        }

        .btn-success {
            background-color: #28a745; /* Green color */
            border-color: #28a745; /* Border color */
        }

        .btn-success:hover {
            background-color: #218838; /* Darker green on hover */
            border-color: #1e7e34; /* Darker border on hover */
        }

        .alert {
            margin-top: 10px; /* Space above alerts */
        }
    </style>
<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <br> <br> <br> <br> <br> <br>
                
                <br />
            </div>
        </div>
        <div class="row ">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Masukan Username dan Password</strong>  
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST">
                            <br />
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" class="form-control" placeholder="Username" name="nama" />
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" placeholder="Password" name="pass" />
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary" name="login">Login</button>
                                <a href="user.php" class="btn btn-info">User</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS - AT THE BOTTOM TO REDUCE THE LOAD TIME -->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>
</html>

<?php
if (isset($_POST['login'])) {
    $nama = $_POST['nama'];
    $pass = $_POST['pass'];

    $ambil = $koneksi->query("SELECT * FROM tb_user WHERE username='$nama' AND password='$pass'");
    $data = $ambil->fetch_assoc();
    $ketemu = $ambil->num_rows;

    if ($ketemu >= 1) {
        session_start();
        $_SESSION['username'] = $data['username'];
        $_SESSION['pass'] = $data['password'];
        $_SESSION['level'] = $data['level'];

        if ($data['level'] == "admin") {
            $_SESSION['admin'] = $data['id'];
            header("location:index.php");
        } else if ($data['level'] == "user") {
            $_SESSION['user'] = $data['id'];
            header("location:index.php");
        }
    } else {
        ?>
        <script type="text/javascript">
            alert("Username dan Password Anda Salah");
        </script>
        <?php
    }
}
?>
<?php } ?>