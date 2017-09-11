<?php 
include 'koneksi.php'; 

if (!$_SESSION['nama'] && !$_SESSION['role']==1 OR !$_SESSION['role']==2) { 
	header('Location: '.base_url().'index.php?page=artikel');
 }
if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $user=$_SESSION['nama'];
}else{
    die("error !!");
}
$query=mysql_query("SELECT * FROM artikel WHERE id='$id' AND user_id='$user'");
$cek=mysql_num_rows($query);
if ($cek==0) { 

    if ($_SESSION['nama']=="admin") { ?>
    <script type="text/javascript">
        alert("Admin diizinkan mengubah artikel ini !");
       
    </script> 
    <?php
        $query=mysql_query("SELECT * FROM artikel WHERE id='$id'");
        $row=mysql_fetch_array($query);
    }else{ ?>
    <script type="text/javascript">
        alert("ID Artikel Salah ! / Anda tidak diizinkan mengubah artikel ini !");
        window.location.href="<?php echo base_url(); ?>index.php?page=artikel";
    </script> 
        <?php  
    }
     
}else{
    $row=mysql_fetch_array($query);
}
?>
<style type="text/css">
 #tabeltambah{
    text-align: left;
 }
</style>

<div class="content">
    <h2>Edit Artikel Seputar Kesehatan</h2> <br>
    <form method="post" action="" name="simpan" enctype="multipart/form-data">
    <table id="tabeltambah">
        <tr>
            <th>Judul</th>
            <th>:</th>
            <th><input type="text" name="judul" size="80" value="<?=$row['judul'] ?>"></th>
        </tr>
        <tr>
            <th>Isi</th>
            <th>:</th>
            <th><textarea name="isi" id="isiku"><?=$row['isi']; ?></textarea></th>
        </tr>
        <tr>
            <th>Penulis</th>
            <th>:</th>
            <th><input type="text" name="penulis" size="50" value="<?=$row['penulis'] ?>" required></th>
        </tr>
        <tr>
            <th>Tags</th>
            <th>:</th>
            <th><input type="text" name="tags" size="50" value="<?=$row['tags'] ?>" required></th>
        </tr>
        
        <tr>
            <th>Ganti Gambar</th>
            <th>:</th>
            <th><img src="<?php echo base_url(); ?><?=$row['gambar'] ?>" width="200"><br><br><input class="readmore" type="file" name="gambar"></th>
        </tr>
       <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th><input type="submit" class="add" name="ubah" value="Simpan"> <button class="del" type="reset">Batal</button></th>
        </tr>


    </table>
    </form>
    <?php 
    $fotoLama=$row['gambar'];
    if (isset($_POST['ubah'])) {
        $judul=mysql_real_escape_string($_POST['judul']);
        $isi=mysql_real_escape_string($_POST['isi']);
        $penulis=mysql_real_escape_string($_POST['penulis']);
        $tags=mysql_real_escape_string($_POST['tags']);
        $user=$_SESSION['nama'];
        // validasi untuk image
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['gambar']['name'];
        $file_size = $_FILES['gambar']['size'];
        $file_temp = $_FILES['gambar']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image ="Artikel-".substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "images/artikel/".$unique_image;


        if (strlen($file_name)>0) {
            if (!$file_size >= 10000){ ?>
                <script type="text/javascript">
                alert("Ukuran file melebihi dari 1MB !");
                </script>
            <?php                
            }elseif(in_array($file_ext, $permited) === false){ ?>

                <script type="text/javascript">
                alert("Extensi file yg diizinkan hanya : .JPG, .jpeg, .png, .gif");
                </script>
                
            <?php
            }elseif (file_exists($fotoLama)) {
                unlink($fotoLama);
                    if(is_uploaded_file($file_temp)) {
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query="UPDATE artikel SET judul='$judul',isi='$isi',penulis='$penulis',tags='$tags',tgl=NOW(),gambar='$uploaded_image' WHERE id ='$id'";
                    $sql=mysql_query($query);
                    if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil edit data !");
                        window.location.href="<?php echo base_url(); ?>index.php?page=artikel";
                    </script>
                    <?php             
                    }else{ ?>
                    <script type="text/javascript">
                        alert("Gagal tambah data !");
                    </script>
                    <?php }

                }
                
            }else{
                 if(is_uploaded_file($file_temp)) {
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query="UPDATE artikel SET judul='$judul',isi='$isi',penulis='$penulis',tags='$tags',tgl=NOW(),gambar='$uploaded_image' WHERE id ='$id'";
                    $sql=mysql_query($query);
                    if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil edit data !");
                        window.location.href="<?php echo base_url(); ?>index.php?page=artikel";
                    </script>
                    <?php             
                    }else{ ?>
                    <script type="text/javascript">
                        alert("Gagal tambah data !");
                    </script>
                    <?php }

                }

                
            }
            
        }else{  // str len 
            $query="UPDATE artikel SET judul='$judul',isi='$isi',penulis='$penulis',tags='$tags',tgl=NOW() WHERE id ='$id'";
                    $sql=mysql_query($query);
                    if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil edit data !");
                        window.location.href="<?php echo base_url(); ?>index.php?page=artikel";
                    </script>
                    <?php             
                    }else{ ?>
                    <script type="text/javascript">
                        alert("Gagal tambah data !");
                    </script>
                    <?php }
        } 
}
?>

</div>