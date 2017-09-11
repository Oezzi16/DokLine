<?php 
include 'koneksi.php'; 

if (!$_SESSION['nama'] && !$_SESSION['role']==1 OR !$_SESSION['role']==2) { 
	header('Location: '.base_url().'index.php?page=artikel');
 } 
?>
<style type="text/css">
 #tabeltambah{
    text-align: left;
 }
</style>

<div class="content">
    <h2>Tambah Artikel Seputar Kesehatan</h2> <br>
    
    <form method="post" action="" name="simpan" enctype="multipart/form-data">
    <table id="tabeltambah">
        <tr>
            <th>Judul</th>
            <th>:</th>
            <th><input type="text" name="judul" size="80" required></th>
        </tr>
        <tr>
            <th>Isi</th>
            <th>:</th>
            <th><textarea name="isi" id="isiku"></textarea></th>
        </tr>
        <tr>
            <th>Penulis</th>
            <th>:</th>
            <th><input type="text" name="penulis" size="50" required></th>
        </tr>
        <tr>
            <th>Tags</th>
            <th>:</th>
            <th><input type="text" name="tags" size="50" required></th>
        </tr>
        <tr>
            <th>Gambar</th>
            <th>:</th>
            <th><input type="file" name="gambar" required class="readmore"></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        
        <tr>
            <th></th>
            <th></th>
            <th><input type="submit" name="simpan" class="add" value="Simpan"> <button type="reset" class="del">Batal</button></th>
        </tr>


    </table>
    </form>
    <?php 
    if (isset($_POST['simpan'])) {
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
            }elseif (is_uploaded_file($file_temp)) {
                move_uploaded_file($file_temp, $uploaded_image);
                $query="INSERT INTO artikel VALUES (NULL,'$judul','$isi','$penulis','$tags',NOW(),'$uploaded_image','$user')";
                $sql=mysql_query($query);
                if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil tambah data !");
                        window.location.href="<?php echo base_url();?>index.php?page=artikel";
                    </script>
                <?php             
                }else{ ?>
                    <script type="text/javascript">
                        alert("Gagal tambah data !");
                    </script>
                    <?php 
                }
            }
        }
        
    }
    ?>

</div>