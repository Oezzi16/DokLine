<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');
?>
<style type="text/css">
 #tabeltambah{
    text-align: left;
 }
 #gambar{
    float: right;
    border: #c1c8ec 1px solid;
    -moz-border-radius: 5px;
    background-color: #9DACBF;
    color: gray;
    border-radius: 7px;
 }
</style>
<?php 
if (isset($_GET['id'])) {
    $iddok=$_GET['id'];
}else{
    die("error !!");
}
$query="SELECT * FROM dokter WHERE id ='$iddok'";
        $sql=mysql_query($query);
        $hasil=mysql_fetch_array($sql);
?>
<div class="content">
    <h2> Edit Data Dokter</h2> <br>
    <form method="post" action="" enctype="multipart/form-data">
    <table id="tabeltambah">
    
        <tr>
            <th align="left">ID Dokter</th>
            <th>:</th>
            <th><input type="text" name="id" value="<?=$hasil['id'] ?>" readonly></th>
        </tr>
        <tr>
            <th>Nama Dokter</th>
            <th>:</th>
            <th><input type="text" name="nama" value="<?=$hasil['nama'] ?>" required></th>
        </tr>
        <tr>
            <th>Alamat Dokter</th>
            <th>:</th>
            <th><textarea name="alamat" rows="3" cols="22"  required><?=$hasil['alamat'] ?></textarea></th>
        </tr>
         <tr>
            <th>Jenis Kelamin</th>
            <th>:</th>
            <th><input type="radio" name="jk" value="0" <?php echo ($hasil['jk']==0)?"checked":"" ?> >Pria
            <input type="radio" name="jk" value="1" <?php echo ($hasil['jk']==1)?"checked":"" ?>>Wanita
            </th>
        </tr>
        <tr>
            <th>Type Dokter</th>
            <th>:</th>
            <th><select name="type" required>
                <option value="">Pilih</option>
                <option value="0" <?php if ($hasil['type']==0) {
                    echo "selected=selected";
                } ?>>Umum</option>
                <option value="1" <?php if ($hasil['type']==1) {
                    echo "selected=selected";
                } ?>>Khusus</option>
            </select></th>
        </tr>
        <tr>
            <th>Gelar Dokter</th>
            <th>:</th>
            <th><textarea name="gelar" rows="3" cols="22" required><?=$hasil['gelar'] ?></textarea></th>
        </tr>
        <tr>
            <th>Foto</th>
            <th>:</th>
            <th><input type="file" name="foto"></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th><input type="submit" name="update" value="Simpan" class="add"> <button class="del" type="reset">Batal</button></th>
        </tr>
        <img id="gambar" src="<?php echo $base_url.$hasil['foto']; ?>" title="Lokasi Foto : images/foto/<?=$hasil['foto']; ?>" width="400" height="200">
        <div style="clear:both; float: right;">Lokasi Foto : <?=$hasil['foto']; ?></div>

        


    </table>
    </form>
     <?php 
     $fotoLama=$hasil['foto'];
    if (isset($_POST['update'])) {
        $id=$_POST['id'];
        $nama=mysql_real_escape_string($_POST['nama']);
        $alamat=mysql_real_escape_string($_POST['alamat']);
        $type=$_POST['type'];
        $gelar=mysql_real_escape_string($_POST['gelar']);
        $jk=$_POST['jk'];
        

        // validasi untuk image
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_temp = $_FILES['foto']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image ="Dokter-".substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "images/dokter/".$unique_image;
        
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
            }elseif(file_exists($fotoLama)) {
                unlink($fotoLama);
                    if(is_uploaded_file($file_temp)) {
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query="UPDATE dokter SET nama='$nama',alamat='$alamat',jk='$jk',type='$type',gelar='$gelar',foto='$uploaded_image' WHERE id ='$id'";
                    $sql=mysql_query($query);
                    if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil edit data !");
                        window.location.href="<?php echo base_url(); ?>index.php?page=tampil_dokter";
                    </script>
                    <?php             
                    }else{ ?>
                    <script type="text/javascript">
                        alert("Gagal tambah data !");
                    </script>
                    <?php }

                }
                
            }else{
                 if (is_uploaded_file($file_temp)) {
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query="UPDATE dokter SET nama='$nama',alamat='$alamat',jk='$jk',type='$type',gelar='$gelar',foto='$uploaded_image' WHERE id ='$id'";
                    $sql=mysql_query($query);
                    if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil edit data !");
                        window.location.href="<?php echo base_url(); ?>index.php?page=tampil_dokter";
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
            $query="UPDATE dokter SET nama='$nama',alamat='$alamat',jk='$jk',type='$type',gelar='$gelar' WHERE id ='$id'";
                    $sql=mysql_query($query);
                    if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil edit data !");
                        window.location.href="<?php echo base_url(); ?>index.php?page=tampil_dokter";
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