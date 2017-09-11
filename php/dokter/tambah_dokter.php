<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');
?>
<style type="text/css">
 #tabeltambah{
    text-align: left;
 }
</style>
<div class="content">
    <h2> Tambah Data Dokter</h2> <br>
    <?php
      $carikode = mysql_query("SELECT MAX(id) from dokter") or die (mysql_error());
      $datakode = mysql_fetch_array($carikode);
      if ($datakode){
        $nilaikode = substr($datakode[0],3);
        $kode = (int) $nilaikode;
        $kode = $kode + 1;
        $hasilkode = "DOK".str_pad($kode, 3, "0", STR_PAD_LEFT);
      }else {
        $hasilkode = "DOK001";
      }
   ?>
    <form method="post" action="" name="simpan" enctype="multipart/form-data">
    <table id="tabeltambah">
    
        <tr>
            <th align="left">ID Dokter</th>
            <th>:</th>
            <th><input type="text" name="id" value="<?=$hasilkode ?>" readonly></th>
        </tr>
        <tr>
            <th>Nama Dokter</th>
            <th>:</th>
            <th><input type="text" name="nama" required></th>
        </tr>
        <tr>
            <th>E-mail</th>
            <th>:</th>
            <th><input type="E-mail" name="email" required></th>
        </tr>
        <tr>
            <th>Alamat Dokter</th>
            <th>:</th>
            <th><textarea name="alamat" rows="3" cols="22"  required></textarea></th>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <th>:</th>
            <th><input type="radio" name="jk" value="0" required checked>Pria
            <input type="radio" name="jk" value="1" required>Wanita
            </th>
        </tr>
        <tr>
            <th>Type Dokter</th>
            <th>:</th>
            <th><select name="type" required>
                <option value="">Pilih</option>
                <option value="0">Umum</option>
                <option value="1">Khusus</option>
            </select></th>
        </tr>
        <tr>
            <th>Gelar Dokter</th>
            <th>:</th>
            <th><textarea name="gelar" rows="3" cols="22" required></textarea></th>
        </tr>
        <tr>
            <th>Foto</th>
            <th>:</th>
            <th><input type="file" name="foto" required></th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th><input type="submit" name="simpan" value="Simpan" class="add"> <button class="del" type="reset">Batal</button></th>
        </tr>


    </table>
    </form>
    <?php 
    if (isset($_POST['simpan'])) {
        $id=$_POST['id'];
        $nama=mysql_real_escape_string($_POST['nama']);
        $email=mysql_real_escape_string($_POST['email']);
        $alamat=mysql_real_escape_string($_POST['alamat']);
        $jk=$_POST['jk'];
        $type=$_POST['type'];
        $gelar=mysql_real_escape_string($_POST['gelar']);

        // validasi untuk image
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_temp = $_FILES['foto']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image ="Dokter-".substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "images/dokter/".$unique_image;

        $pw=md5($id);
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
                $query="INSERT INTO dokter VALUES('$id','$nama','$alamat','$email','$jk','$type','$gelar','$uploaded_image')";
                $sql=mysql_query($query);
                $query2="INSERT INTO login VALUES('$id','$pw',2,1)";
                        $sql2=mysql_query($query2);
                if ($sql && $sql2) { ?>
                <script type="text/javascript">
                    alert("Berhasil tambah data !");
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
    } ?>
</div>