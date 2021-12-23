<!DOCTYPE html>
<html>
<h3><a href="FormLoadFile.php">Kembali Ke Form Input Link</a></h3>
<br><br>
</html>

<?php
include 'Koneksi.php';
include 'XML2Array.php';

$link = $_GET['link'];
$xml=simplexml_load_file($link);
if(!$xml) //using simplexml_load_file function to load xml file
{
echo 'load XML failed!';
}
else
{
echo '<h1>This is the Data</h1>';
}

$array = XML2Array($xml);

$a=0;

// Save to tabel galert_data
foreach ($array as $key => $value) {
    $id = $array['id'];
    $title = $array['title'];
    $link = $array['link'];
    $update = $array['updated'];
    $date = $array['updated'];

    // Select to database
    $sql = "SELECT * FROM galert_data WHERE feed_id='$id'";
    $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "";
        }else{
            echo 'Id : '.$id.'<br/>';
            echo 'Title : '.$title.'<br/>';
            echo 'Link : '.$link.'<br/>';
            echo 'Update : '.$update.'<br/>';
            echo 'date : '.$date.'<br/>';
            echo '<br/>';

        // Save to database
        $q = "INSERT INTO galert_data(feed_id,feed_title,feed_link,feed_update,date)
        VALUES('$id','$title','$link','$update','$date')";
        $result = mysqli_query($conn,$q);

        // Save to tabel galert_entry
        foreach ($xml as $record) {
            $id2 = $record->id;
            $title = $record->title;
            $link = $record->link;
            $published = $record->published;
            $update = $record->update;
            $content = $record->content;
            $author = $record->author;

            // select to database
            $sql = "SELECT * FROM galert_entry where entry_id='$id'";
            $result = $conn->query($sql);

            if ($result->num_rows>0) {
                echo "";
            }else{
                echo 'Id : '.$id2.'<br/>';
                echo 'Title : '.$title.'<br/>';
                echo 'Link : '.$link.'<br/>';
                echo 'Publisher : '.$published.'<br/>';
                echo 'Update : '.$update.'<br/>';
                echo 'Content : '.$content.'<br/>';
                echo 'Author : '.$author.'<br/>';
                echo '<br/>';

                // Save to database
                $q = "INSERT INTO
                galert_entry(entry_id,entry_title,entry_link,entry_published,
                entry_updated,entry_content,entry_author,feed_id)
                VALUES('$id2','$title','$link','$published','$update',
                '$content','$author','$id')";

                $result = mysqli_query($conn,$q);
            }
        }
    }
}

if ($result) {
    echo '<h2>Success Save to Database</h2>';
}else{
    echo '<h2>Failed Save to Database</h2>';
}

?>