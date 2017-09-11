<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');
if (!$_SESSION['nama'] && $_SESSION['role']!=1 OR !$_SESSION['nama'] && $_SESSION['role']!=2) {
    header('Location: '.base_url().'');
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/tampilan.css">

<div class="content">
    <div style="margin-bottom:15px;" align="right">
    <form action="" method="post">
       <h2 style="float: left;">Data Pasien</h2>
       <input type="text" name="cari" placeholder="Masukkan ID/Nama" style="width:200px; padding:7px;"/>
        <input type="submit" name="cari_pasien" value="Search" class="readmore" style="padding: 8px;padding-bottom: 1px;"/>
    </form>
    </div>


    <table id="tabel" width="100%" border="1"; style="border-collapse:collapse;">
        <tr align="left">
            <th>No</th>
            <th>ID Pasien</th>
            <th>Nama Pasien</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th align="center">Options</th>
        </tr>
        <?php 
        $no = 1;
        $batas = 10;
        $hal = $_GET['hal'];
        if(empty($hal)){
          $posisi = 0;
          $hal = 1;
        }else{
            $posisi = ($hal - 1) * $batas;
        }

        if ($_SESSION['role']==1) {
            $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a, login b WHERE a.id=b.user ORDER BY id DESC LIMIT $posisi, $batas") or die (mysql_error());
            $no = $posisi + 1;
            $cari = mysql_real_escape_string($_POST['cari']);
            $cari_pasien = mysql_real_escape_string($_POST['cari_pasien']);

            if($cari_pasien){
                if($cari != ""){
                  $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a JOIN login b ON a.id=b.user WHERE id LIKE '%$cari%' OR nama LIKE '%$cari%' LIMIT $posisi, $batas") or die (mysql_error());
                    }else{
                    $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a, login b WHERE a.id=b.user ORDER BY id DESC LIMIT $posisi, $batas") or die (mysql_error());
                    }
              
            }else{
              $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a, login b WHERE a.id=b.user ORDER BY id DESC LIMIT $posisi, $batas") or die (mysql_error());
            }
        }else{
            $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a, login b WHERE a.id=b.user AND b.status=1 ORDER BY id DESC LIMIT $posisi, $batas") or die (mysql_error());
            $no = $posisi + 1;
            $cari = mysql_real_escape_string($_POST['cari']);
            $cari_pasien = mysql_real_escape_string($_POST['cari_pasien']);

            if($cari_pasien){
                if($cari != ""){
                  $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a JOIN login b ON a.id=b.user WHERE id LIKE '%$cari%' OR nama LIKE '%$cari%' AND b.status=1 LIMIT $posisi, $batas") or die (mysql_error());
                    }else{
                    $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a, login b WHERE a.id=b.user AND b.status=1 LIMIT $posisi, $batas") or die (mysql_error());
                    }
              
            }else{
              $sql = mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a, login b WHERE a.id=b.user AND b.status=1 LIMIT $posisi, $batas") or die (mysql_error());
            }
        }

        

        $cek = mysql_num_rows($sql);
        if($cek < 1){ ?>
            <tr>
              <td colspan="7" align="center" style="padding:10px;">Data tidak ditemukan</td>
            </tr><?php

        }else {


        while ($hasil=mysql_fetch_array($sql)) {
            $id=$hasil['id_pasien'];
            $nama=$hasil['nama'];
            $alamat=$hasil['alamat'];
            $jk=($hasil['jk']==0)?"Pria":"Wanita";
            $status=$hasil['status'];
            $warna=($no%2==1)?"#ffffff":"#efefef";

        
        ?>
        <tr bgcolor="<?=$warna?>">
            <td><?=$no ?></td>
            <td><?=$id ?></td>
            <td><?=$nama ?></td>
            <td><?=$alamat ?></td>
            <td><?=$jk ?></td>
            <td align="center">
            <a href="<?php echo base_url(); ?>index.php?page=foto_pasien&id=<?=$id ?>"><img src="<?php echo base_url(); ?>images/foto.png" width="20" alt="profil" title="profil"></a>
                <?php 

                if ($_SESSION['nama'] && $_SESSION['role']==1) { ?>
                    <a onclick="return confirm('yakin hapus data ini?')" href="<?php echo base_url(); ?>index.php?page=tampil_pasien&delid=<?=$id?>"><img src="<?php echo base_url(); ?>images/del.png" width="20" alt="hapus" title="hapus"></a>
                    <?php
                    // qeuery untuk menampilkan data pasien yang belum di approve
                    if ($status==0) { ?>
                        <a onclick="return confirm('yakin approve?')" href="<?php echo base_url(); ?>index.php?page=tampil_pasien&appid=<?=$id?>">
                        
                        <img src="<?php echo base_url(); ?>images/approve.png" width="20" title="Approve" alt="Approve"></a>
                    <?php 
                        
                    }
                } ?>
            <a href="<?php echo base_url(); ?>index.php?page=printpas&id=<?=$id ?>" target="_blank"><img src="<?php echo base_url(); ?>images/print.png" width="20" alt="print" title="print"></a>     
            </td>
        </tr>

        <?php $no++; } } ?>
    
    <tr>
        <th colspan="5">Cetak Semua Data</th>
        <th><a href="<?php echo base_url(); ?>index.php?page=printall_pasien" target="_blank"><button>Print All</button></a>
            <a href="<?php echo base_url(); ?>index.php?page=printallpdf_pasien" target="_blank"><button>Print All to Pdf</button></a>
        </th>
    </tr>
    </table>

    <div style="margin-top:10px; float:left;">
        <?php
        $jml = mysql_num_rows(mysql_query("SELECT a.id as id_pasien,a.nama,a.alamat,a.jk, b.status FROM pasien a, login b WHERE a.id=b.user"));
        echo "Jumlah data : <b>".$jml."</b>"; ?>
    </div>

    <div style="margin-top:10px; float:Right;">
    <?php
    $jml_hal = ceil($jml / $batas);
    for($i=1; $i<=$jml_hal; $i++){
      if($i != $hal){
        echo "<a href='".$base_url."index.php?page=tampil_pasien&hal=$i'><button style='background-color:#fff; border:1px solid #666; color:#666;'>$i</button></a>";
      }else{
        echo "<button style='background-color:#ccc; border:1px solid #000;'><b>$i</b></button>";

      }
    }
     ?>
  </div>



    
</div>


<?php 
$delid=$_GET['delid'];
if (isset($_GET['delid'])) {
    if ($_SESSION['role']!=1 ) { ?>
        <script>alert('Anda tidak diizinkan menghapus !!');
        window.location.href='<?php echo base_url(); ?>index.php?page=tampil_pasien';
        </script>
        <?php         
    }else{
        $query="DELETE FROM pasien WHERE id='$delid'";
        $sql=mysql_query($query);
        $query2="DELETE FROM login WHERE user='$delid'";
        $sql2=mysql_query($query2);
        if ($sql) { ?>
           <script type="text/javascript">
                alert("Berhasil Hapus data !");
                window.location.href="<?php echo base_url(); ?>index.php?page=tampil_pasien";
            </script>
       <?php }else{ ?>
            <script type="text/javascript">
                alert("Gagal tambah data !");
            </script>
     <?php  }
    }

    
}

$appid=$_GET['appid'];
if (isset($_GET['appid'])) {
    $query="UPDATE login SET status=1 WHERE user='$appid'";
    $sql=mysql_query($query);
    
    if ($sql) { ?>
       <script type="text/javascript">
            alert("Berhasil Approve !");
            window.location.href="<?php echo base_url(); ?>index.php?page=tampil_pasien";
        </script>
   <?php }else{ ?>
        <script type="text/javascript">
            alert("Gagal tambah data !");
        </script>
 <?php  }
}

?>
