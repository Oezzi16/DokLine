<?php 
error_reporting(0);
include "koneksi.php";
?>
<style type="text/css">
	#tabeltambah{
    text-align: left;
 }
</style>    
<div class="content">
	<h1 style="color: red;"> Welcome to Registeration User</h1>
	<?php
	  $carikode = mysql_query("SELECT MAX(id) from pasien") or die (mysql_error());
	  $datakode = mysql_fetch_array($carikode);
	  if ($datakode){
	    $nilaikode = substr($datakode[0],5);
	    $kode = (int) $nilaikode;
	    $kode = $kode + 1;
	    $hasilkode = "PAS".str_pad($kode, 5, "0", STR_PAD_LEFT);
	  }else {
	    $hasilkode = "PAS00001";
	  }
   ?>

		<form style="margin-top: 30px;" method="post" action="" enctype="multipart/form-data">
			<table id="tabeltambah">

			    
	    <tr>
            <th align="left">ID Pasien</th>
            <th>:</th>
            <th><input type="text" name="id" value="<?=$hasilkode ?>" readonly></th>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <th>:</th>
            <th><input type="text" name="nama" required></th>
        </tr>
        <tr>
            <th>Alamat Pasien</th>
            <th>:</th>
            <th><textarea name="alamat" rows="3" cols="22"  required></textarea></th>
        </tr>
        <tr>
            <th>E-mail Pasien</th>
            <th>:</th>
            <th><input type="E-mail" name="email" required></th>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <th>:</th>
            <th><input type="radio" name="jk" value="0" required checked>Pria
            <input type="radio" name="jk" value="1" required>Wanita
            </th>
        </tr>
        
        <tr>
            <th>Foto</th>
            <th>:</th>
            <th><input type="file" name="foto" required class="readmore"></th>

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
	            <th>Password</th>
	            <th>:</th>
	            <th><input type="text" name="pass" id="user" size="30" placeholder=" Password"></th>
	        </tr>
	         <tr>
	            <th>Re-Password</th>
	            <th>:</th>
	            <th><input type="text" name="repass" id="user" size="30" placeholder=" Re- Password"></th>
	        </tr>
	         
	        <tr>
	            <th></th>
	            <th></th>
	            <th><input type="submit" name="register" class="add" value="Registeration"> <button type="reset" class="del">Reset</button></th>
	        </tr>


	    </table>
			
		</form>

		<?php 
		
		

		if (isset($_POST['register'])) {

		$id=$_POST['id'];
        $nama=mysql_real_escape_string($_POST['nama']);
        $alamat=mysql_real_escape_string($_POST['alamat']);
        $email=mysql_real_escape_string($_POST['email']);
        $jk=$_POST['jk'];
        // validasi untuk image
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_temp = $_FILES['foto']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image ="Pasien-".substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "images/pasien/".$unique_image;

		$pw=md5($_POST['pass']);
		$repw=md5($_POST['repass']);
		$role=$_POST['role'];
		if ($pw==$repw) {
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
		                $query="INSERT INTO pasien VALUES('$id','$nama','$alamat','$email','$jk','$uploaded_image')";
				        $sql=mysql_query($query);
				        $query2="INSERT INTO login VALUES('$id','$pw',3,0)";
				        $sql2=mysql_query($query2);
				        if ($sql && $sql2) { ?>
				        <script type="text/javascript">
				            alert("Berhasil tambah data !");
				            window.location.href="<?php echo base_url(); ?>index.php?page=register";
				        </script>
				        <?php             
				        }else{ ?>
				        <script type="text/javascript">
				            alert("Gagal tambah data !");
				        </script>
				        <?php }
				    }
		        }
		        
		}else{ ?>
			<script type="text/javascript">
		            alert("Password tidak sama");
		        </script>
		    <?php
		}

        

			
      		
	}

?>
		

</div>