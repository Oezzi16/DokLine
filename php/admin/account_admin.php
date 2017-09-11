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

<?php  $id=$_SESSION['nama']; ?>

<div class="content">
    <h2>My Account</h2><br>
	<form style="margin-top: 20px;" method="post" action="">
		<table id="tabeltambah">
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
	            <th><input type="submit" name="update" value="Save" class="add"> <button  class="del" type="reset">Reset</button></th>
	        </tr>
	        <img id="gambar" src="<?php echo base_url(); ?>images/admin.png" title="Lokasi Foto : images/admin.png" width="400" height="230">
        	<div style="clear:both; float: right;">Lokasi Foto : images/admin.png</div>


	    </table>
			
		</form>
	<?php 
    
    if (isset($_POST['update'])) {
        $lpass=mysql_real_escape_string($_POST['lpass']);
        $npass=mysql_real_escape_string(md5($_POST['npass']));
        $repass=mysql_real_escape_string(md5($_POST['repass']));
        $querypw="SELECT pass FROM login WHERE user='$id'";
        $sqlpw=mysql_query($querypw);
        $row=mysql_fetch_array($sqlpw);
        if ($row['pass']==md5($lpass)) {

        	if ($npass == $repass) {

                    $query="UPDATE login SET pass='$npass' WHERE user ='$id'";
                    $sql=mysql_query($query);
                    if ($sql) { ?>
                    <script type="text/javascript">
                        alert("Berhasil edit Account !");
                        window.location.href="<?php echo base_url(); ?>index.php?page=account_admin";
                    </script>
                    <?php             
                    }else{ ?>
                    <script type="text/javascript">
                        alert("Gagal edit data !");
                    </script>
                    <?php }
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
