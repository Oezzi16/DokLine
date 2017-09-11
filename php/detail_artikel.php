<?php include 'koneksi.php'; ?>

<div class="content">
    <?php
        $id = (isset($_GET['id']))? $_GET['id'] : NULL;
        if ($id==NULL) {
            die("id artikel tidak ada !");
        }else{
            $query="SELECT * FROM artikel WHERE id='$id'";
            $sql=mysql_query($query);
            $row=mysql_fetch_array($sql);
        }
        ?>
    <h2><?=$row['judul']  ?></h2> <br>
    Penulis : <?=$row['penulis']?> & Tanggal : <?=$row['tgl'] ?> Tags:<?=$row['tags'] ?> <br><br>
            <img class="imgart" src="<?php echo base_url(); ?><?=$row['gambar'] ?>" width="400"><br><br>
            <p><?=$row['isi']; ?></p>

    
</div>