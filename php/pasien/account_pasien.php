<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');
?>

<style type="text/css">
    #tabeltambah{
    text-align: left;}
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
$id=$_SESSION['nama'];
$query="SELECT * FROM pasien WHERE id ='$id'";
        $sql=mysql_query($query);
        $hasil=mysql_fetch_array($sql);
?>

<div class="content">
    <h2>My Account</h2><br>

    <form style="margin-top: 30px;" method="post" action="" enctype="multipart/form-data">
		<table id="tabeltambah">

			    
	    <tr>
            <th align="left">ID Pasien</th>
            <th>:</th>
            <th><input type="text" name="id" size="30" value="<?=$id ?>" readonly></th>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <th>:</th>
            <th><input type="text" size="30" name="nama" value="<?php echo $hasil['nama']; ?>" required></th>
        </tr>
        <tr>
            <th>Alamat Pasien</th>
            <th>:</th>
            <th><textarea name="alamat" rows="5" cols="32"  required><?=$hasil['alamat']; ?></textarea></th>
        </tr>
        <tr>
            <th>E-mail Pasien</th>
            <th>:</th>
            <th><input type="E-mail" size="30" name="email" value="<?=$hasil['email']; ?>" required></th>
        </tr>
                
        <tr>
            <th>Foto</th>
            <th>:</th>
            <th><input type="file" name="foto"></th>
        </tr>
	       <tr>
	            <th>Last Password</th>
	            <th>:</th>
	            <th><input type="Password" name="lpass" id="user" size="30" placeholder="Last Password" required></th>
	        </tr>
	        <tr>
	            <th>New Password</th>
	            <th>:</th>
	            <th><input type="Password" name="npass" id="user" size="30" placeholder=" Password" required></th>
	        </tr>
	         <tr>
	            <th>Re-Password</th>
	            <th>:</th>
	            <th><input type="Password" name="repass" id="user" size="30" placeholder=" Re- Password" required></th>
	        </tr>
	         
	        <tr>
	            <th></th>
	            <th></th>
	            <th><input type="submit" class="add" name="update" value="Save"> <button class="del" type="reset">Reset</button></th>
	        </tr>
	        <img id="gambar" src="<?php echo base_url(); ?><?=$hasil['foto'] ?>" title="Lokasi Foto : <?=$hasil['foto']; ?>" width="400" height="300">
        	<div style="clear:both; float: right;">Lokasi Foto : <?=$hasil['foto']; ?></div>


	    </table>
			
		</form>
		<?php 
    $fotoLama=$hasil['foto'];
    if (isset($_POST['update'])) {

        $id=$_POST['id'];
        $nama=mysql_real_escape_string($_POST['nama']);
        $alamat=mysql_real_escape_string($_POST['alamat']);
        $email=mysql_real_escape_string($_POST['email']);
        $lpass=mysql_real_escape_string($_POST['lpass']);
        $npass=mysql_real_escape_string(md5($_POST['npass']));
        $repass=mysql_real_escape_string(md5($_POST['repass']));

         // validasi untuk image
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_temp = $_FILES['foto']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image ="Pasien-".substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "images/pasien/".$unique_image;


        $querypw="SELECT pass FROM login WHERE user='$id'";
        $sqlpw=mysql_query($querypw);
        $row=mysql_fetch_array($sqlpw);
        if ($row['pass']==md5($lpass)) {

        	if ($npass == $repass) {
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
		                    $query="UPDATE pasien SET nama='$nama',alamat='$alamat',email='$email',foto='$uploaded_image' WHERE id ='$id'";
		                    $sql=mysql_query($query);
		                    $query2="UPDATE login SET pass='$npass' WHERE user ='$id'";
		                    $sql2=mysql_query($query2);
		                    if ($sql && $sql2) { ?>
		                    <script type="text/javascript">
		                        alert("Berhasil edit Account !");
		                        window.location.href="<?php echo base_url(); ?>index.php?page=account_pasien";
		                    </script>
		                    <?php             
		                    }else{ ?>
		                    <script type="text/javascript">
		                        alert("Gagal edit data !");
		                    </script>
		                    <?php }

		                }
		                
		            }else{
		                 if (is_uploaded_file($file_temp)) {
		                    move_uploaded_file($file_temp, $uploaded_image);
		                    $query="UPDATE pasien SET nama='$nama',alamat='$alamat',email='$email',foto='$uploaded_image' WHERE id ='$id'";
		                    $sql=mysql_query($query);
		                    $query2="UPDATE login SET pass='$npass' WHERE user ='$id'";
		                    $sql2=mysql_query($query2);
		                    if ($sql && $sql2) { ?>
		                    <script type="text/javascript">
		                        alert("Berhasil edit Account !");
		                        window.location.href="<?php echo base_url(); ?>index.php?page=account_pasien";
		                    </script>
		                    <?php             
		                    }else{ ?>
		                    <script type="text/javascript">
		                        alert("Gagal edit data !");
		                    </script>
		                    <?php }

		                }

		                
		            }
		            
		        }else{  // str len 
		            	$query="UPDATE pasien SET nama='$nama',alamat='$alamat',email='$email' WHERE id ='$id'";
		                    $sql=mysql_query($query);
		                    $query2="UPDATE login SET pass='$npass' WHERE user ='$id'";
		                    $sql2=mysql_query($query2);
		                    if ($sql && $sql2) { ?>
		                    <script type="text/javascript">
		                        alert("Berhasil edit Account !");
		                        window.location.href="<?php echo base_url(); ?>index.php?page=account_pasien";
		                    </script>
		                    <?php             
		                    }else{ ?>
		                    <script type="text/javascript">
		                        alert("Gagal edit data !");
		                    </script>
		                    <?php }
		        	} 
      		}else{ ?>

        		<script type="text/javascript">
                        alert("Password Tidak sama.. !");
                    </script>
        		<?php 
      		}
        	
        
        }else{ ?>

        		<script type="text/javascript">
                        alert("Password lama anda salah.. !");
                    </script>
        <?php 

        }
        
        
    }
    ?>
    



    
</div>
