<?php 
include 'koneksi.php'; 

function textShorten($text, $limit = 400){
    $text = $text. " ";
    $text = substr($text, 0, $limit);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text.".....";
    return $text;
}
?>


<div class="content">
<?php 

if ($_SESSION['nama'] && $_SESSION['role']==1 OR $_SESSION['role']==2) { ?>

<a href="<?php echo base_url(); ?>index.php?page=tambah_artikel" style="margin-left: 10px; float: right;"><button class="add">Tambah Artikel</button></a>
<?php } ?>

    <div align="right">
        <form action="" method="post">
           <input type="text" name="cari" placeholder="Masukkan Kata Kunci" style="width:200px; padding:7px;"/>
            <input type="submit" name="cari_artikel" value="Search" class="readmore" style="padding: 8px;padding-bottom: 1px;"/>
        </form>
    </div>
    <h2>Artikel Pilihan Seputar Kesehatan</h2>

    <div class="post">
    <?php 
    $no = 1;
    $batas = 5;
    $hal = $_GET['hal'];
    if(empty($hal)){
      $posisi = 0;
      $hal = 1;
    }else{
        $posisi = ($hal - 1) * $batas;
    }

    $sql = mysql_query("SELECT * FROM artikel ORDER BY id DESC LIMIT $posisi, $batas") or die (mysql_error());
    $cari = mysql_real_escape_string($_POST['cari']);
    $cari_artikel = mysql_real_escape_string($_POST['cari_artikel']);

    if($cari_artikel){
            if($cari != ""){
              $sql = mysql_query("SELECT * FROM artikel WHERE judul LIKE '%$cari%' OR isi LIKE '%$cari%' OR tags LIKE '%$cari%' LIMIT $posisi, $batas") or die (mysql_error());
              
                }else{
                $sql = mysql_query("SELECT * FROM artikel ORDER BY id DESC LIMIT $posisi, $batas") or die (mysql_error());
                }

          
        }else{
          $sql = mysql_query("SELECT * FROM artikel ORDER BY id DESC LIMIT $posisi, $batas") or die (mysql_error());
        }

    $cek = mysql_num_rows($sql);
    if($cek < 1){ ?>
        <tr>
          <td colspan="7" align="center" style="padding:10px;"><h2 style="color: red;">Data tidak ditemukan !</h2></td>
        </tr><?php

    }else {

    while ($row=mysql_fetch_array($sql)) {
    
    ?>
            <?php if ($_SESSION['nama'] && $_SESSION['role']==1 OR $_SESSION['role']==2) { ?>
            <a onclick="return confirm('yakin hapus artikel ini?')" href="<?php echo base_url(); ?>index.php?page=artikel&delid=<?=$row['id'] ?>" style="float: right;"><button class="del">Delete</button></a>
            <a href="<?php echo base_url(); ?>index.php?page=edit_artikel&id=<?=$row['id'] ?>" style="float: right;"><button class="edit">Edit Artikel</button></a>
            <?php } ?>
            <h3><a style="text-decoration: none; color: maroon;" href="<?php echo base_url(); ?>index.php?page=detail_artikel&id=<?=$row['id'] ?>"><?=$row['judul']; ?></a></h3>
            Penulis : <?=$row['penulis']?> & Tanggal : <?=$row['tgl'] ?> Tags:<?=$row['tags'] ?> <br>
            <img class="imgart" src="<?php echo base_url(); ?><?=$row['gambar'] ?>" width="400">
            <p><?php echo textShorten($row['isi'], 400); ?></p>

            

            <br><a href="<?php echo base_url(); ?>index.php?page=detail_artikel&id=<?=$row['id'] ?>"><button class="readmore">Read More</button></a>

        <br><br>

     <?php }
     if ($cari != "") {
            echo "<div class='cari'><h2><i>:: hasil pencarian dengan kata kunci <b>$_POST[cari]</b> ::</i></h2></div>";
        }
         } ?>
    <div style="clear: both; padding-top: 100px;">
        <?php
            $jml = mysql_num_rows(mysql_query("SELECT * FROM artikel"));
            echo "Jumlah Artikel : <b>".$jml."</b>"; ?>
            <?php
            $jml_hal = ceil($jml / $batas);
            ?>
        <p style="float: right;"><?php 
            for($i=1; $i<=$jml_hal; $i++){
              if($i != $hal){ ?>
                <a href='<?php echo base_url(); ?>index.php?page=artikel&hal=<?php echo $i; ?>'><button style='background-color:#fff; border:1px solid #666; color:#666;'><?php echo $i; ?></button></a> <?php
              }else{ ?>
                <button style='background-color:#ccc; border:1px solid #000;'><b><?php echo $i; ?></b></button>
                <?php
              }
            }
        ?></p>
    </div>
            


        

    </div>

    <div class="sidepost">
        <h3 align="center">Artikel Terbaru</h3><br>
        <?php 
        $qtop=mysql_query("SELECT * FROM artikel ORDER BY id DESC LIMIT 10");
        $no=1;
        while ($rtop=mysql_fetch_assoc($qtop)) { ?>
            <a style="text-decoration: none;" href="<?php echo base_url(); ?>index.php?page=detail_artikel&id=<?=$rtop['id'] ?>"><button class="readmore link" style="text-align: left;"><i><?php echo $no; ?>. <?=$rtop['judul'] ?></i></button></a> <br> <br>
        <?php 
        $no++; 
            } ?>
    </div>


    <div class="sidepost2">
        <h3 align="center">Info Dok_Line</h3><br>
        <?php 
        $qd=mysql_query("SELECT * FROM dokter");
        $nd=mysql_num_rows($qd);

        ?>
        <a style="text-decoration: none;" href="<?php echo base_url(); ?>index.php?page=tampil_dokter"><button class="add link2"><i>Jumlah Tim Dokter Aktif = <?=$nd; ?> Dokter</i></button></a>
        <?php 
        $qp=mysql_query("SELECT a.id, b.status FROM pasien a, login b WHERE a.id=b.user AND b.status=1");
        $np=mysql_num_rows($qp);

        ?>
        <br><br>
        <a style="text-decoration: none;" href="#"><button class="add link2"><i>Jumlah Pasien Aktif Saat ini = <?=$np; ?> Pasien</i></button></a>
    </div>
    
</div>


<?php 
$delid=$_GET['delid'];
$user=$_SESSION['nama'];
if (isset($_GET['delid'])) {
    $query=mysql_query("SELECT * FROM artikel WHERE id='$delid' AND user_id='$user'");
    $cek=mysql_num_rows($query);
    if ($cek==0) {
        if ($_SESSION['nama']=="admin") { ?>
        <script type="text/javascript">
            alert("Admin diizinkan menghapus artikel ini !");
           
        </script> 
        <?php
            $query=mysql_query("SELECT * FROM artikel WHERE id='$delid'");
            $row=mysql_fetch_assoc($query);
            $foto=$row['gambar'];
            unlink($foto);
            $query2="DELETE FROM artikel WHERE id='$delid'";
            $sql2=mysql_query($query2);
            if ($sql2) { ?>
               <script type="text/javascript">
                    alert("Berhasil Hapus data !");
                    window.location.href="<?php echo base_url(); ?>index.php?page=artikel";
                </script>
           <?php }else{ ?>
                <script type="text/javascript">
                    alert("Gagal tambah data !");
                </script>
             <?php  }
            
        }else{ ?>
            <script type="text/javascript">
                alert("ID Artikel Salah ! / Anda tidak diizinkan Menghapus artikel ini !");
                window.location.href="<?php echo base_url(); ?>index.php?page=artikel";
            </script>
            <?php  
        }  
    }else{
        $row=mysql_fetch_assoc($query);
        $foto=$row['gambar'];
        unlink($foto);
        $query2="DELETE FROM artikel WHERE id='$delid'";
        $sql2=mysql_query($query2);
        if ($sql2) { ?>
           <script type="text/javascript">
                alert("Berhasil Hapus data !");
                window.location.href="<?php echo base_url(); ?>index.php?page=artikel";
            </script>
       <?php }else{ ?>
            <script type="text/javascript">
                alert("Gagal tambah data !");
            </script>
     <?php  }
    }
    
    
}

?>