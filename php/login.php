<?php 
 include "koneksi.php";
error_reporting(0);
session_start();
if ($_SESSION['nama']) {
  header('location: '.base_url().'');  
} ?>
<style type="text/css">
	
	#kotak{
		text-align: left;
		padding-left: 50px;
		border:1px solid #ecf0f1;
		border-collapse: collapse;
		border-radius: 20px;
		margin-top: 40px;
		background-color: #e74c3c;
		margin: auto;
		width: 300px;
		height: 300px;
	}
	
	#reg{
		float: right;
		margin-right: 55px;
		text-align :center;
		font-size: 14px;
	}
	#reg a{
		text-decoration: none;
	}
</style>    
<div class="content">
	<h1 align="center" style="color: red;"> Welcome to Admin Login</h1>

	<div id="kotak">
		<form style="margin-top: 30px;" method="post" action="">
		<br><br>
			<label>Username</label><br>
			<input type="text" name="user" id="user" size="30" placeholder=" Username" style="border-radius: 7px;">
			<br><br>
			<label>Password</label><br>
			<input type="password" name="pass" id="pass" size="30" placeholder=" Password" style="border-radius: 7px;">
			
			<br><br>
			<input type="submit" name="login" value="Login" style="cursor:pointer; height: 35px;width: 88px;border-radius: 5px;">
			<div id="reg">
			<a href="index.php?page=forgot">Forgot Your Password?</a><br>
				or <br>
			<a href="index.php?page=register">Register Here !</a>
			</div>
			<br>
			<br>
			
		</form>

		<?php
		
		$user=mysql_real_escape_string($_POST['user']);
		$pw=mysql_real_escape_string(md5($_POST['pass']));
	
		if (isset($_POST['login'])) {
			if($user == "" || $pw == ""){
	          ?> <script type="text/javascript">
	            alert("Isi terlebih dahulu Username dan Password");
	          </script>
	          <?php
	        }else{
	        	$query= "SELECT * FROM login WHERE user='$user' AND pass='$pw'";
	            $sql=mysql_query($query);
	            $hasil=mysql_fetch_array($sql);
	            $cek = mysql_num_rows($sql);
	            if ($cek>=1) {
	            	if ($hasil['status'] == 1) {
	            		$_SESSION['nama'] = $hasil['user']; 
	            		$_SESSION['role'] = $hasil['role']; 
	            		
	            		// 1. admin 2. dokter 3. pasien
	            		

	            		?>
				    	<script type="text/javascript">
			                alert("Selamat Datang.. Anda Login sebagai <?php if ($_SESSION[role]==1) {
	            			echo "Admin";
	            		}elseif ($_SESSION[role]==2) {
	            			echo "Dokter";
	            		}else{
	            			echo "Pasien";
	            		} ?>");
			                    window.location.href="<?php echo base_url(); ?>";
			            </script>
		    		<?php
		    		}else{ ?>
		    			<script type="text/javascript">
			                    alert("Status Anda belum di Approve !");
			                    window.location.href="<?php echo base_url(); ?>index.php?page=login";
			            </script>
		    		<?php

		    		} 		      		
	            }else{ ?>
	            	<script type="text/javascript">
	                        alert("user/password salah !");
	                        window.location.href="<?php echo base_url(); ?>index.php?page=login";
	                    </script>
	            	<?php

	            }
					
			}

			
      		
		}

		?>
		
	</div>

</div>