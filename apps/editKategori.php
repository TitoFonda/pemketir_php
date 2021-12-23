<!DOCTYPE html>
<?php
    include 'Koneksi.php';
?>
<html class="noIE" lang="en-US">
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
    
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Judul</td>
            <td>Action</td>
        </tr>
        <?php
            $sql = mysqli_query($koneksi, "SELECT entry_id, entry_title FROM galert_entry");
            while ($data = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                    <td><?php echo $data['entry_id']; ?></td>
                    <td><?php echo $data['entry_title']; ?></td>
                    <td>
                        <select name="" id="">
                            <option selected disabled>-Pilih Kategori-</option>
                        <?php
                            $sql1 = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($data1 = mysqli_fetch_array($sql1)) {
                                ?>
                                <option value="<?php echo $data1['id_kategori']; ?>"><?php echo $data1['nm_kategori']; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <?php
            }
        ?>
    </table>
    </html>