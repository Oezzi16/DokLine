<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../koneksi.php');
?>
<style type="text/css">
	#gambar{
    border: #c1c8ec 1px solid;
    -moz-border-radius: 5px;
    background-color: #9DACBF;
    color: gray;
    border-radius: 7px;
 }
</style>
<div class="content">
    <h2 align="center">Profil Dokter</h2>
    <div align="center">
    	<?php
    	$id = (isset($_GET['id']))? $_GET['id'] : NULL;
    	if ($id==NULL) {
    		die("id dokter tidak ada !");
    	}else{
    		$query="SELECT * FROM dokter WHERE id='$id'";
	    	$sql=mysql_query($query);
	    	$hasil=mysql_fetch_array($sql);
	    	$foto = $hasil['foto'];
	    	$nama=$hasil['nama'];
	    	$tipe=($hasil['type']==0)?"Umum":"Khusus";
            $gelar=$hasil['gelar'];
	    	if (empty($foto)){
	    		echo "<strong>Foto tidak ditemukan !</strong>";
	    		echo "<br>"."Nama : ".$nama;
	    		echo "<br>"."Type : ".$tipe;
	    		echo "<br>"."Gelar : ".$gelar;
	    	}else{
	    		echo "<img id='gambar' src='$foto' width='400' height='300' />";
	    		echo "<br>"."Nama : ".$nama;
	    		echo "<br>"."Type : ".$tipe;
	    		echo "<br>"."Gelar : ".$gelar;
	    	}
    	} ?>
    </div>
    
</div>