<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');
?>
<style type="text/css">
	#gambar{
    /*float: right;*/
    border: #c1c8ec 1px solid;
    -moz-border-radius: 5px;
    background-color: #9DACBF;
    color: gray;
    border-radius: 7px;
 }
</style>
<div class="content">
    <h2 align="center">Profil Pasien</h2>
    <div align="center">
    	<?php
    	$id = (isset($_GET['id']))? $_GET['id'] : NULL;
    	if ($id==NULL) {
    		die("id pasien tidak ada !");
    	}else{
    		$query="SELECT * FROM pasien WHERE id='$id'";
	    	$sql=mysql_query($query);
	    	$hasil=mysql_fetch_array($sql);
	    	$foto = $hasil['foto'];
	    	$nama=$hasil['nama'];
	    	if (empty($foto)){
	    		echo "<strong>Foto tidak ditemukan !</strong>";
	    		echo "<br>"."Nama : ".$nama;
	    	}else{
	    		echo "<img id='gambar' src='$foto' width='400' height='200' />";
	    		echo "<br>"."Nama : ".$nama;
	    	}
    	
	    		
	    	}
    	
    	
    	?>
    </div>
    
</div>