<!DOCTYPE html>
<html class="noIE" lang="en-US">
<body>
    <!-- meta -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- google fonts -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,bold" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Alegreya+Sans:regular,italic,bold,bolditalic" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Nixie+One:regular,italic,bold,bolditalic" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Alegreya+SC:regular,italic,bold,bolditalic" />

	<!-- css -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/style.css" media="screen" />


                    <div >
                        <h2><a href="../index.html">HOME</a></h2>
                    </div>

                <section class="center">
                   
                        Form Pembuatan Kategori Baru
            
                    <div>
                        <div>
                            <section>
                                <div class="col-md-6 col-md-offset-3">
                                    <form action="" method="get" role="form">
                                        <div>
                                            <input type="text"name="id_kategori" placeholder="Masukkan ID Kategori" style="text-align: center">
                                        </div>
                                        <div>
                                            <input type="text"name="nm_kategori" placeholder="Masukkan Nama Kategori" style="text-align: center">
                                        </div>
                                        <input type="submit" name="submit" value="Simpan Data">
                                        <br><br>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>


</body>
</html>
<?php
include 'Koneksi.php';
if (isset($_GET['submit'])) {
    $idKategori = $_GET['id_kategori'];
    $nmKategori = $_GET['nm_kategori'];
    $query = mysqli_query($conn, "INSERT INTO kategori VALUES ('$idKategori', '$nmKategori')");
    if ($query) {
        echo "<script>alert('Berhasil Di Input!')</script>";
    } else {
        echo "<script>alert('Gagal Di Input!')</script>";
    }
}


?>