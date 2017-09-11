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
    <h2>Recovery your password</h2> <br>
        <form style="margin-top: 10px;" method="post" action="">
			<table id="tabeltambah">
		
	        <tr>
	            <th>E-mail</th>
	            <th>:</th>
	            <th><input type="E-mail" name="email" placeholder=" Input your E-mail" required></th>

	        </tr>
	        <tr>
	        </tr>        	         
	        <tr>
	            <th></th>
	            <th></th>
	            <th><input type="submit" name="forgot" class="add" value="Send"> <button type="reset" class="del">Reset</button></th>
	        </tr>

			</table>
			
		</form>
		<?php 
			
			

			if (isset($_POST['forgot'])) {

	        $email=mysql_real_escape_string($_POST['email']);
	        $unique_pass ="!Forgot#".substr(md5(time()), 0, 10);
	        
	        
			$query=mysql_query("SELECT id, email FROM pasien WHERE email='$email'");
			$hasil=mysql_fetch_assoc($query);
			$id=$hasil['id'];
			$msg="Berikut Password pemulihan anda untuk id = ".$id." Password = ".$unique_pass." </br> *Note : Harap Untuk tidak membalas E-mail ini.";
			$cek=mysql_num_rows($query);
			if ($cek>0) {

				   $qupdate=mysql_query("UPDATE login SET pass='".md5($unique_pass)."' WHERE user='$id'");

				   $message = mysql_real_escape_string($msg);
			       $subject = htmlspecialchars('Recovery Password');
			       $headers = "MIME-Version: 1.0\r\n";
			       $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			       $headers .= "From: admin@Dok_Line.com";
			       $email_to = $hasil['email'];
			       $html = stripcslashes($message);

			       $sendmail = mail($email_to, $subject, $html, $headers);
			       if ($sendmail) { ?>
			       	<script type="text/javascript">
			            alert("Pesan sudah terkirim ke email anda !");
			          </script>	
			          <?php 
			       }else{ ?>
			       		<script type="text/javascript">
			            alert("Gagal Terkirim, coba lagi..");
			          </script>	
			          <?php
			       }
					
			}else{ ?>
				<script type="text/javascript">
	            alert("E-mail tidak ditemukan !");
	          </script>
	          <?php
			}

		} ?>
		<br><br>
		<p style="color: red;"><b><i>#Password yang dipulihkan hanya untuk pasien dan E-mail yang sudah terdaftar di aplikasi Dok_Line. Untuk dokter harap hubungi admin.</i></b></p>
</div>