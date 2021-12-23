<!DOCTYPE html>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
    <h3><a href="FormLoadFile.php">Kembali ke Form Awal</a></h3>
    <h3><a href="../index.html">Home</a></h3>
<br>
</html>
<style>
    body {
        background-color: #dde0ab;
    }

    tr {
        background-color: #66bfbf;
    }

</style>
<body>
    

<?php
include 'Koneksi.php';
include "stopword.php";

require_once __DIR__ .'/sastrawi/vendor/autoload.php';

$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
$stemmer = $stemmerFactory->createStemmer();

echo "<br>";

$sql = "SELECT katabaku, concat (katabaku,'') k_baku FROM slangword";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultSet = $stmt->get_result();
$result = $resultSet->fetch_all();
$arr_slang = array();
foreach($result as $k=>$v) {
    $arr_slang[$v[0]] = $v[1];
}

$sql="SELECT * FROM galert_entry where length(entry_id) !=0";
$result=$conn->query ($sql);
if($result->num_rows == 0){
    echo "Data Tidak Ditemukan";
} else {
?>

        <table border = "1" cellpadding ="1" cellspacing="1" bgcolor="#999999">
        <tr bgcolor="CCCCCC">
        <th>ID</th>
        <th>Content</th>
        <th>Case Folding</th>
        <th>Hapus Simbol</th>
        <th>Filter Slang Word</th>
        <th>Filter stop word</th>
        <th>Stimming</th>
        <th>Tokenisasi</th>
        <th>Data Bersih</th>
        <th>Kategori</th>
    </tr>
<?php
    while($d = mysqli_fetch_array($result)) {
        $id = $d['entry_id'];
        $content = $d['entry_content'];

        //1 Case Folding
            //echo strtoupper ($content);
            //echo strtolower ($sontent);
            $cf = strtolower($content);


        //2 Penghapusan Simbol-Simbol (Symbol Removel)
        $simbol=preg_replace("/[^a-zA-Z\\s]/", "", $cf);

        /*  //Penghapusan tag html
        $tags=preg_replace("/<.*?>/", " ", $cf);

        //penghapusan URL
        $regex="@(https?://([-\w\.]+[-\w]) + (:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\S])?)?)@";
        $url=preg_replace($regex, ' ', $tags);

        //Penghapusan angka dan tanda baca
        $simbol = preg_replace('/[^a-z\9\6]+/i', ' ', $url);
        
        $simbol = str_replace("nbsp", ' ', $sombol); //changes &nbsp to space
        */

        //3 Konversi Slangword
        $rem_slang=explode(" ", $simbol);
        $slangword=str_replace(array_keys($arr_slang), $arr_slang, $simbol);


        //4 stopword Removal
            $rem_stopword=explode(" ", $slangword);
            $str_data=array();
            foreach ($rem_stopword as $value) {
                if(!in_array($value, $stopwords)){
                    $str_data[] = "".$value;
                }
            }
            $stopword = implode(" ", $str_data);


        //5 Stemming
            $query1 = implode (' ', (array) $stopword);
            $stemming = $stemmer->stem($query1);

        //6 Tokenisasi
            $tokenisasi = preg_split ("/[\s,.:]+/", $stemming);
            $tokenisasi=implode(",  ",$tokenisasi);
        ?>

            <tr bgcolor="FFFFFF">
                <td><?php echo $id;?></td>
                <td><?php echo $content;?></td>
                <td><?php echo $cf;?></td>
                <td><?php echo $simbol;?></td>
                <td><?php echo $slangword;?></td>
                <td><?php echo $stopword;?></td>
                <td><?php echo $stemming;?></td>
                <td><?php echo $tokenisasi;?></td>
                <td><?php echo $stemming;?></td>
                <td>
                    <form action="" method="get">
                        <input type="hidden" name="entry_id" value="<?php echo $id; ?>">
                    <select name="kategori" id="kategori" class="form-group">
                    <?php
                        $sql1 = mysqli_query($conn, "SELECT * FROM kategori");
                        while ($data = mysqli_fetch_array($sql1)) {
                            $sql3 = mysqli_query($conn, "SELECT kategori FROM preprocessing WHERE entry_id='$id'");
                            if($sql3->num_rows > 0){
                                while ($data1 = mysqli_fetch_array($sql3)) {
                                    ?>
                                        <option value="<?php echo $data['nm_kategori']; ?>" <?php if($data['nm_kategori'] == $data1['kategori']){ echo 'selected';} ?>><?php echo $data['nm_kategori']; ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                   <option value="<?php echo $data['nm_kategori']; ?>"><?php echo $data['nm_kategori']; ?></option>
                                <?php
                            }
                        }
                    ?>
                    </select>
                    <input type="submit" name="ubah" value="Submit">
                    </form>
                </td>
            </tr>

        </tabel>

        <?php

        $sql="SELECT * FROM preprocessing where entry_id = '$id'";
        $result1 = $conn->query($sql);

        if ($result1->num_rows == 0) {
            //save to databases
            $q = "INSERT INTO preprocessing (`entry_id`,`p_cf`,`p_simbol`,`p_tokenisasi`,`p_sword`,`p_stopword`,`p_stemming`,`data_bersih`) VALUE ('$id','$cf','$simbol','$tokenisasi','$slangword,','$stopword','$stemming','$stemming')";

            $result1 = mysqli_query($conn, $q);
        }else{

            $q = "UPDATE preprocessing set p_cf='$cf', p_simbol='$simbol', p_tokenisasi = '$tokenisasi', p_sword='$slangword',
                p_stopword='stopword', p_stemming='$stemming',data_bersih='$stemming' where entry_id='$id'";

            $result1 = mysqli_query($conn, $q);
        }
    }
        if ($result1){
            echo'<h4>Preprocessing Data Berhasil</4>';
        }else{
            echo'<h2>Gagal Melakukan Preprocessing Data</h2>';
        }
    }


?>
 </div>
    </div>

</html>
<?php
    if(isset($_GET['ubah'])){
        $kategori = $_GET['kategori'];
        $id = $_GET['entry_id'];
        $sql2 = mysqli_query($conn, "UPDATE preprocessing SET kategori='$kategori' WHERE entry_id = '$id'");
        if($sql2){
            echo "<script>alert('Kategori Berhasil Di Update!'); window.location.href = 'PreProcessing.php';</script>";
        } else {
            echo "<script>alert('Kategori Gagal Di Update!')</script>";
        }
    }
?>
</body>